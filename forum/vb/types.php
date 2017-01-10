<?php if (!defined('VB_ENTRY')) die('Access denied.');
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin 4.2.0 
|| # ---------------------------------------------------------------- # ||
|| # Copyright �2000-2012 vBulletin Solutions Inc. All Rights Reserved. ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
|| # http://www.vbulletin.com | http://www.vbulletin.com/license.html # ||
|| #################################################################### ||
\*======================================================================*/

/**
 * vB Types Handler
 * Provides methods to convert id's, class names, packages, class string fragments
 * and friendly titles for the framework object types package and contenttype.
 *
 * Child classes may add additional types allowing them to be fetched and handled
 * together.
 *
 * @version $Revision: 29650 $
 * @since $Date: 2009-02-25 15:39:20 +0000 (Wed, 25 Feb 2009) $
 * @copyright vBulletin Solutions Inc.
 */
class vB_Types
{
    /*Properties====================================================================*/

    /**
     * A reference to the singleton instance
     *
     * @var vB_Types
     */
    protected static $instance;

    /**
     * Whether we have loaded the type info.
     *
     * @var bool
     */
    protected $loaded;

    /**
     * Valid packages by class string identifier.
     * A string lookup for all packages.  The array is in the format
     *    array(class string => array('enabled' => bool, 'class' => string, 'id' => int)
     *
     * @var array mixed
     */
    protected $packages = array();

    /**
     * Valid packages by numeric id.
     * An integer lookup for all packages. The values are references to $packages.
     * @see vB_Core::$packages
     *
     * @var array mixed
     */
    protected $package_ids = array();

    /**
     * Valid contenttypes by type key.
     * Note: The key is generated by vB_Core::getTypeKey() based on the
     * package class string identifer and content type class string identifier.
     *
     * The array is in the format
     *  array(string contenttype key => array('class' => string, 'package' => package, 'id' => integer)
     *
     * Note: The package value is a reference to an element in $packages.
     *
     * @var array mixed
     */
    protected $contenttypes = array();

    /**
     * Valid contenttypes by numeric id.
     * An integer lookup for all contenttypes.  The values are references to $contenttypes.
     * @see vB_Core::$contenttypes
     *
     * @var array mixed
     */
    protected $contenttype_ids = array();


    /**
     * The key to use to store the type cache.
     *
     * @var string
     */
    protected $cache_key = 'vb_types.types';

    /** array of aggregator content type ids *****/
    protected $aggregators = array();

    /** array of non-aggregator content type ids *****/
    protected $nonaggregators = array();


    /**
     * Events that expire the type cache.
     *
     * @var array string
     */
    protected $cache_events = array(
        'vb_types.type_updated',
        'vb_types.package_updated',
        'vb_types.contenttype_updated'
    );


    /*Construction==================================================================*/

    /**
     * Constructor protected to enforce singleton use.
     * @see instance()
     */
    protected function __construct()
    {
        $this->loadTypes();
    }


    /**
     * Returns singleton instance of self.
     * @todo This can be inherited once late static binding is available.  For now
     * it has to be redefined in the child classes
     *
     * @return vB_Types                            - Reference to singleton instance of the type handler
     */
    public static function instance()
    {
        if (!isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class();
        }

        return self::$instance;
    }


    /*Initialization================================================================*/

    /**
     * Ensures the type information is loaded.
     */
    protected function loadTypes()
    {
        // Assert the type cache
        if (!($type_info = vB_Cache::instance()->read($this->cache_key, true, true))) {
            $type_info = $this->getTypeInfo();
            vB_Cache::instance()->write($this->cache_key, $type_info, false, $this->cache_events);
        }

        // Load the types from the cached info
        $this->loadTypeInfo($type_info);
    }


    /**
     * Builds the type info cache.
     *
     * @TODO Use type collection
     *
     * @return array mixed                        - Assoc array of type info
     */
    protected function getTypeInfo()
    {
        // Get package and contenttypes
        $result = vB::$db->query($sql = "
			(SELECT 'package' AS classtype, package.packageid AS typeid, package.packageid AS packageid,
				package.productid AS productid, if(package.productid = 'vbulletin', 1, product.active) AS enabled,
				package.class AS class, -1 as isaggregator
			FROM " . TABLE_PREFIX . "package AS package
			LEFT JOIN " . TABLE_PREFIX . "product AS product
					ON product.productid = package.productid
			WHERE product.active = 1
				OR package.productid = 'vbulletin'
			)

			UNION

			(SELECT 'contenttype' AS classtype, contenttypeid AS typeid, contenttype.packageid AS packageid,
				1, 1, contenttype.class AS class  ,  contenttype.isaggregator
			FROM " . TABLE_PREFIX . "contenttype AS contenttype
			INNER JOIN " . TABLE_PREFIX . "package AS package ON package.packageid = contenttype.packageid
			LEFT JOIN " . TABLE_PREFIX . "product AS product ON product.productid = package.productid
			WHERE product.active = 1
			OR package.productid = 'vbulletin'  )
		");

        $types = array();
        while ($type = vB::$db->fetch_array($result)) {
            $types[] = $type;
        }

        return $types;
    }


    /**
     * This gives up a list of the Aggregator types.
     *
     * @return array of ID
     */
    public function getAggregatorTypeIds()
    {
        //See if we've already pulled them out.
        if (count($this->aggregators)) {
            return $this->aggregators;
        }

        //If we get here, we haven't.
        $typeinfo = $this->getTypeInfo();

        //Now scan the list. If it's a package we ignore it. If
        // it's a content type, it's either an aggregator or not.
        foreach ($typeinfo as $id => $type) {
            if ('contenttype' == $type['classtype']) {
                if (intval($type['isaggregator'])) {
                    $this->aggregators[] = $type['typeid'];
                } else {
                    $this->nonaggregators[] = $type['typeid'];
                }
            }
        }
        return $this->aggregators;
    }


    /**
     * This gives up a list of the non-Aggregator types.
     *
     * @return array of ID
     */
    public function getNonAggregatorTypeIds()
    {
        //Check to see if the list has been generated.
        if (!count($this->nonaggregators)) {
            //If not, we can just call this function. We build both
            // arrays at the same time.
            $this->getAggregatorTypeIds();
        }
        return $this->nonaggregators;
    }

    /**
     * Loads the type info from the type info cache into distinct type properties.
     *
     * @param array mixed $type_info            - The type info cache data
     */
    protected function loadTypeInfo($type_info)
    {
        // Set up packages
        $this->loadPackages($type_info);

        // Set up content types
        $this->loadContentTypes($type_info);
    }



    /*Types=========================================================================*/

    /**
     * Gets a unique string key representing a type for the given package
     * and class.
     *
     * Note: The key is only unique per type (ie, unique for contenttypes).
     *
     * @param string $package - The package identifier
     * @param string $class - The class identifier
     * @return string                            - The resulting single string unique key identifier
     */
    public function getTypeKey($package, $class)
    {
        return $package . '_' . $class;
    }



    /*Packages======================================================================*/

    /**
     * Loads package info from the type info cache.
     * @see vB_Core::buildTypeCache()
     *
     * @param array mixed $type_info            - The type info cache data
     * @throws vB_Exception_Critical            - Thrown if no packages are found
     */
    protected function loadPackages($type_info)
    {
        foreach ($type_info AS $type) {
            if ('package' == $type['classtype']) {
                $this->packages[$type['class']] = array('enabled' => $type['enabled'], 'class' => $type['class'], 'id' => $type['typeid']);

                // vbulletin product packages are always enabled
                if ('vbulletin' == $type['productid']) {
                    $this->packages[$type['class']]['enabled'] = 1;
                }

                $this->package_ids[$type['typeid']] =& $this->packages[$type['class']];
            }
        }

        if (!sizeof($this->packages)) {
            throw (new vB_Exception_Critical('No packages found'));
        }
    }


    /**
     * Gets the numeric package id a package class string identifier.
     * Note: This will also return a package id for a given package id after
     * verification so the function can be used for normalisation.
     *
     * @param mixed $package - Class string identifier or numeric id of the package to check
     * @return int | false
     */
    public function getPackageID($package)
    {
        if (is_numeric($package)) {
            return (isset($this->package_ids[$package]) ? $package : false);
        } else {
            return (isset($this->packages[$package]) ? $this->packages[$package]['id'] : false);
        }
    }


    /**
     * Gets the class string identifier for a package.
     *
     * @param mixed $package - Class string identifier or numeric id of the package to check
     * @throws vB_Exception_Warning                - Thrown if an invalid package was given
     * @return string
     */
    public function getPackageClass($package)
    {
        if (!($id = $this->getPackageID($package))) {
            throw (new vB_Exception_Warning('Trying to get package class string from an invalid package \'' . htmlspecialchars($package) . '\''));
        }

        return $this->package_ids[$id]['class'];
    }


    /**
     * Checks if a package is valid and throws an exception if it isn't.
     *
     * @param mixed $package - Class string identifier or numeric id of the package to check
     * @param vB_Exception $e - An alternative exception to throw
     * @throws mixed                            - Thrown if the package was not valid
     */
    public function assertPackage($package, vB_Exception $e = null)
    {
        if (!($id = $this->getPackageID($package))) {
            throw ($e ? $e : new vB_Exception_Warning('Invalid package \'' . htmlspecialchars($package) . '\''));
        }

        return $id;
    }


    /**
     * Checks if a package is enabled.
     *
     * @param mixed $package - Class string identifier or numeric id of the package to check
     */
    public function packageEnabled($package)
    {
        if (!($id = $this->getPackageID($package))) {
            throw (new vB_Exception_Warning('Checking if a package is enabled for an invalid package \'' . htmlspecialchars($package) . '\''));
        }

        return $this->package_ids[$id]['enabled'];
    }



    /*ContentTypes==================================================================*/

    /**
     * Loads contenttype info from the type info cache.
     * @see vB_Core::buildTypeCache()
     *
     * @param array mixed $type_info            - The type info cache
     * @throws vB_Exception_Critical            - Thrown if no contenttypes were found
     */
    protected function loadContentTypes($type_info)
    {
        foreach ($type_info AS $type) {
            if ('contenttype' == $type['classtype']) {
                if (isset($this->package_ids[$type['packageid']])) {
                    $key = $this->getTypeKey($this->package_ids[$type['packageid']]['class'], $type['class']);
                    $this->contenttypes[$key] = array('class' => $type['class'], 'id' => $type['typeid']);
                    $this->contenttypes[$key]['package'] =& $this->package_ids[$type['packageid']];
                    $this->contenttype_ids[$type['typeid']] =& $this->contenttypes[$key];
                }
            }
        }

        if (!sizeof($this->contenttypes)) {
            throw (new vB_Exception_Critical('No contenttypes found'));
        }
    }


    /**
     * Gets a contenttype id from a type key or array(package, class).
     * Note: This will also return the numeric id if one is given, allowing the
     * function to be used for normalisation and validation.
     *
     * If the contenttype is given as an array, it must be in the form
     *    array('package' => package class string, 'class' => contenttype class string)
     *
     * @param mixed $contenttype - Key, array(package, class) or numeric id of the contenttype
     * @return int | false
     */
    public function getContentTypeID($contenttype)
    {
        if (is_numeric($contenttype)) {
            return (isset($this->contenttype_ids[$contenttype]) ? $contenttype : false);
        } else if (is_string($contenttype) OR (is_array($contenttype) AND isset($contenttype['package']) AND isset($contenttype['class']))) {
            if (is_array($contenttype)) {
                $contenttype = $this->getTypeKey($contenttype['package'], $contenttype['class']);
            }

            if (!isset($this->contenttypes[$contenttype])) {
                return false;
            }

            return $this->contenttypes[$contenttype]['id'];
        }

        return false;
    }


    /**
     * Checks if a contenttype id is valid and throws an exception if it isn't.
     *
     * @param mixed $contenttype - Key, array(package, class) or numeric id of the contenttype
     * @param vB_Exception $e - An alternative exception to throw
     * @throws mixed                            - Thrown if the given contenttype is not valid
     */
    public function assertContentType($contenttype, vB_Exception $e = null)
    {
        if (!($id = $this->getContentTypeID($contenttype))) {
            throw ($e ? $e : new vB_Exception_Warning('Invalid contenttype \'' . htmlspecialchars(print_r($contenttypeid, 1)) . '\''));
        }

        $this->assertPackage($this->contenttype_ids[$id]['package']['id']);

        return $id;
    }


    /**
     * Gets the package class string identifier for a contenttype
     *
     * @param mixed $contenttype - Key, array(package, class) or numeric id of the contenttype
     * @return string                            - The class string of the package
     */
    public function getContentTypePackage($contenttype)
    {
        if (!($id = $this->getContentTypeID($contenttype))) {
            throw (new vB_Exception_Warning('Trying to get package class from invalid contenttype \'' . htmlspecialchars(print_r($contenttype, 1)) . '\''));
        }

        $this->assertPackage($this->contenttype_ids[$id]['package']['id']);

        return $this->contenttype_ids[$id]['package']['class'];
    }


    /**
     * Gets the package id for a contenttype
     *
     * @param mixed $contenttype - Key, array(package, class) or numeric id of the contenttype
     * @return int                                - The integer id of the package that the contenttype belongs to
     */
    public function getContentTypePackageID($contenttype)
    {
        $package = $this->getContentTypePackage($contenttype);

        $this->assertPackage($package);

        return $this->packages[$package]['id'];
    }


    /**
     * Gets the class string identifier for a contenttype.
     *
     * @param mixed $contenttype - Key, array(package, class) or numeric id of the contenttype
     * @return string                            - The class string identifier of the given contenttype
     */
    public function getContentTypeClass($contenttype)
    {
        if (!($id = $this->getContentTypeID($contenttype))) {
            throw (new vB_Exception_Warning('Trying to get contenttype class id from invalid contenttype \'' . htmlspecialchars(print_r($contenttype, 1)) . '\''));
        }

        return $this->contenttype_ids[$id]['class'];
    }


    /**
     * Gets the full controller class name for a contenttype.
     *
     * @param $contenttypeid - An identifier for the contenttypeid
     * @param $contentid - An optional contentid
     *
     * @return string
     */
    public function getContentTypeController($contenttypeid, $contentid = false)
    {
        if (!($id = $this->getContentTypeID($contenttypeid))) {
            throw (new vB_Exception_Warning('Trying to get contenttype controller class from invalid contenttype \'' . htmlspecialchars(print_r($contenttypeid, 1)) . '\''));
        }

        return vB_Content::create($this->getContentTypePackage($id), $this->getContentTypeClass($id), $contentid);
    }


    /**
     * Gets the user friendly title of a contenttype.
     * Note: The title is not stored as part of the contenttype and is instead a
     * phrase that is evaluated from the contenttype's package and class.
     *
     * @param mixed $contenttype
     * @return string
     */
    public function getContentTypeTitle($contenttype)
    {
        if (!($id = $this->getContentTypeID($contenttype))) {
            throw (new vB_Exception_Warning('Trying to get contenttype title from invalid contenttype \'' . htmlspecialchars(print_r($contenttype, 1)) . '\''));
        }

        return new vB_Phrase('contenttypes', 'contenttype_' . strtolower($this->getContentTypePackage($contenttype) . '_' . $this->getContentTypeClass($contenttype)));
    }


    /**
     * Gets a user friendly phrase for an untitled piece of content.
     *
     * @param mixed $contenttype
     * @return string
     */
    public function getUntitledContentTypeTitle($contenttype)
    {
        if (!($id = $this->getContentTypeID($contenttype))) {
            throw (new vB_Exception_Warning('Trying to get untitled contenttype title from invalid contenttype \'' . htmlspecialchars(print_r($contenttype, 1)) . '\''));
        }

        return new vB_Phrase('contenttypes', 'contenttype_' . strtolower($this->getContentTypePackage($contenttype) . '_' . $this->getContentTypeClass($contenttype) . '_untitled'));
    }


    /**
     * Gets the class and package of a contenttypeid.
     * Note: The title is not stored as part of the contenttype and is instead a
     * phrase that is evaluated from the contenttype's package and class.
     *
     * @param mixed $contenttype
     */
    public function getContentClassFromId($contenttypeid)
    {
        return array('package' => $this->getContentTypePackage($contenttypeid),
            'class' => $this->getContentTypeClass($contenttypeid));
    }


    /**
     * Checks of a contenttype is enabled.
     * A contenttype is disabled if it's package is disabled.
     *
     * @param mixed $contenttype - Key, array(package, class) or numeric id of the contenttype
     * @return bool
     */
    public function contentTypeEnabled($contenttype)
    {
        if (!$id = $this->getContentTypeID($contenttype)) {
            throw (new vB_Exception_Warning('Checking if a contenttype\'s package is enabled for an invalid contenttype \'' . htmlspecialchars(print_r($contenttype, 1)) . '\''));
        }

        return $this->contenttype_ids[$id]['package']['enabled'];
    }


    /**
     * Fetches the cache events that affect contenttypes.
     * @return array string
     */
    public function getContentTypeCacheEvents()
    {
        return $this->cache_events;
    }

    /**
     * Fetches all content types
     * @return array Content types.
     */
    public function getContentTypes()
    {
        return $this->contenttypes;
    }
}

/*======================================================================*\
|| ####################################################################
|| # 
|| # SVN: $Revision: 29650 $
|| ####################################################################
\*======================================================================*/