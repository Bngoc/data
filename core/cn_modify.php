<?php if (!defined('BQN_MU')) {
    die('Access restricted');
}
// Since 1.5.0: UTF-8 to HTML-Entities
function cn_db_init()
{
    //global $db;
    // basic CN db
    include SERVDIR . '/core/db/flat_web.php';
}

function UTF8ToEntities($string)
{
    if (is_array($string)) {
        return $string;
    }

    // @Note May be deprecated in next versions
    $HTML_SPECIAL_CHARS_UTF8 = array
    (
        'c2a1' => '&iexcl;',
        'c2a2' => '&cent;',
        'c2a3' => '&pound;',
        'c2a4' => '&curren;',
        'c2a5' => '&yen;',
        'c2a6' => '&brvbar;',
        'c2a7' => '&sect;',
        'c2a8' => '&uml;',
        'c2a9' => '&copy;',
        'c2aa' => '&ordf;',
        'c2ab' => '&laquo;',
        'c2bb' => '&raquo;',
        'c2ac' => '&not;',
        'c2ae' => '&reg;',
        'c2af' => '&macr;',
        'c2b0' => '&deg;',
        'c2ba' => '&ordm;',
        'c2b1' => '&plusmn;',
        'c2b9' => '&sup1;',
        'c2b2' => '&sup2;',
        'c2b3' => '&sup3;',
        'c2b4' => '&acute;',
        'c2b7' => '&middot;',
        'c2b8' => '&cedil;',
        'c2bc' => '&frac14;',
        'c2bd' => '&frac12;',
        'c2be' => '&frac34;',
        'c2bf' => '&iquest;',
        'c380' => '&Agrave;',
        'c381' => '&Aacute;',
        'c382' => '&Acirc;',
        'c383' => '&Atilde;',
        'c384' => '&Auml;',
        'c385' => '&Aring;',
        'c386' => '&AElig;',
        'c387' => '&Ccedil;',
        'c388' => '&Egrave;',
        'c389' => '&Eacute;',
        'c38a' => '&Ecirc;',
        'c38b' => '&Euml;',
        'c38c' => '&Igrave;',
        'c38d' => '&Iacute;',
        'c38e' => '&Icirc;',
        'c38f' => '&Iuml;',
        'c390' => '&ETH;',
        'c391' => '&Ntilde;',
        'c392' => '&Ograve;',
        'c393' => '&Oacute;',
        'c394' => '&Ocirc;',
        'c395' => '&Otilde;',
        'c396' => '&Ouml;',
        'c397' => '&times;',
        'c398' => '&Oslash;',
        'c399' => '&Ugrave;',
        'c39a' => '&Uacute;',
        'c39b' => '&Ucirc;',
        'c39c' => '&Uuml;',
        'c39d' => '&Yacute;',
        'c39e' => '&THORN;',
        'c39f' => '&szlig;',
        'c3a0' => '&agrave;',
        'c3a1' => '&aacute;',
        'c3a2' => '&acirc;',
        'c3a3' => '&atilde;',
        'c3a4' => '&auml;',
        'c3a5' => '&aring;',
        'c3a6' => '&aelig;',
        'c3a7' => '&ccedil;',
        'c3a8' => '&egrave;',
        'c3a9' => '&eacute;',
        'c3aa' => '&ecirc;',
        'c3ab' => '&euml;',
        'c3ac' => '&igrave;',
        'c3ad' => '&iacute;',
        'c3ae' => '&icirc;',
        'c3af' => '&iuml;',
        'c3b0' => '&eth;',
        'c3b1' => '&ntilde;',
        'c3b2' => '&ograve;',
        'c3b3' => '&oacute;',
        'c3b4' => '&ocirc;',
        'c3b5' => '&otilde;',
        'c3b6' => '&ouml;',
        'c3b7' => '&divide;',
        'c3b8' => '&oslash;',
        'c3b9' => '&ugrave;',
        'c3ba' => '&uacute;',
        'c3bb' => '&ucirc;',
        'c3bc' => '&uuml;',
        'c3bd' => '&yacute;',
        'c3be' => '&thorn;',
        'c3bf' => '&yuml;',
        'c592' => '&OElig;',
        'c593' => '&oelig;',
        'c5a0' => '&Scaron;',
        'c5a1' => '&scaron;',
        'c5b8' => '&Yuml;',
        'cb86' => '&circ;',
        'cb9c' => '&tilde;',
        'c692' => '&fnof;',
        'ce91' => '&Alpha;',
        'ce92' => '&Beta;',
        'ce93' => '&Gamma;',
        'ce94' => '&Delta;',
        'ce95' => '&Epsilon;',
        'ce96' => '&Zeta;',
        'ce97' => '&Eta;',
        'ce98' => '&Theta;',
        'ce99' => '&Iota;',
        'ce9a' => '&Kappa;',
        'ce9b' => '&Lambda;',
        'ce9c' => '&Mu;',
        'ce9d' => '&Nu;',
        'ce9e' => '&Xi;',
        'ce9f' => '&Omicron;',
        'cea0' => '&Pi;',
        'cea1' => '&Rho;',
        'cea3' => '&Sigma;',
        'cea4' => '&Tau;',
        'cea5' => '&Upsilon;',
        'cea6' => '&Phi;',
        'cea7' => '&Chi;',
        'cea8' => '&Psi;',
        'cea9' => '&Omega;',
        'ceb1' => '&alpha;',
        'ceb2' => '&beta;',
        'ceb3' => '&gamma;',
        'ceb4' => '&delta;',
        'ceb5' => '&epsilon;',
        'ceb6' => '&zeta;',
        'ceb7' => '&eta;',
        'ceb8' => '&theta;',
        'ceb9' => '&iota;',
        'ceba' => '&kappa;',
        'cebb' => '&lambda;',
        'cebc' => '&mu;',
        'cebd' => '&nu;',
        'cebe' => '&xi;',
        'cebf' => '&omicron;',
        'cf80' => '&pi;',
        'cf81' => '&rho;',
        'cf82' => '&sigmaf;',
        'cf83' => '&sigma;',
        'cf84' => '&tau;',
        'cf85' => '&upsilon;',
        'cf86' => '&phi;',
        'cf87' => '&chi;',
        'cf88' => '&psi;',
        'cf89' => '&omega;',
        'cf91' => '&thetasym;',
        'cf92' => '&upsih;',
        'cf96' => '&piv;',
        'e2809d' => '&rdquo;',
        'e2809c' => '&ldquo;',
        'e284a2' => '&trade;',
        'e28099' => '&rsquo;',
        'e28098' => '&lsquo;',
        'e280b0' => '&permil;',
        'e280a6' => '&hellip;',
        'e282ac' => '&euro;',
        'e28093' => '&ndash;',
        'e28094' => '&mdash;',
        'e280a0' => '&dagger;',
        'e280a1' => '&Dagger;',
        'e280b9' => '&lsaquo;',
        'e280ba' => '&rsaquo;',
        'e280b2' => '&prime;',
        'e280b3' => '&Prime;',
        'e280be' => '&oline;',
        'e28498' => '&weierp;',
        'e28491' => '&image;',
        'e2849c' => '&real;',
        'e284b5' => '&alefsym;',
        'e28690' => '&larr;',
        'e28691' => '&uarr;',
        'e28692' => '&rarr;',
        'e28693' => '&darr;',
        'e28694' => '&harr;',
        'e286b5' => '&crarr;',
        'e28790' => '&lArr;',
        'e28791' => '&uArr;',
        'e28792' => '&rArr;',
        'e28793' => '&dArr;',
        'e28794' => '&hArr;',
        'e28880' => '&forall;',
        'e28882' => '&part;',
        'e28883' => '&exist;',
        'e28885' => '&empty;',
        'e28887' => '&nabla;',
        'e28888' => '&isin;',
        'e28889' => '&notin;',
        'e2888b' => '&ni;',
        'e2888f' => '&prod;',
        'e28891' => '&sum;',
        'e28892' => '&minus;',
        'e28897' => '&lowast;',
        'e2889a' => '&radic;',
        'e2889d' => '&prop;',
        'e2889e' => '&infin;',
        'e288a0' => '&ang;',
        'e288a7' => '&and;',
        'e288a8' => '&or;',
        'e288a9' => '&cap;',
        'e288aa' => '&cup;',
        'e288ab' => '&int;',
        'e288b4' => '&there4;',
        'e288bc' => '&sim;',
        'e28985' => '&cong;',
        'e28988' => '&asymp;',
        'e289a0' => '&ne;',
        'e289a1' => '&equiv;',
        'e289a4' => '&le;',
        'e289a5' => '&ge;',
        'e28a82' => '&sub;',
        'e28a83' => '&sup;',
        'e28a84' => '&nsub;',
        'e28a86' => '&sube;',
        'e28a87' => '&supe;',
        'e28a95' => '&oplus;',
        'e28a97' => '&otimes;',
        'e28aa5' => '&perp;',
        'e28b85' => '&sdot;',
        'e28c88' => '&lceil;',
        'e28c89' => '&rceil;',
        'e28c8a' => '&lfloor;',
        'e28c8b' => '&rfloor;',
        'e29fa8' => '&lang;',
        'e29fa9' => '&rang;',
        'e2978a' => '&loz;',
        'e299a0' => '&spades;',
        'e299a3' => '&clubs;',
        'e299a5' => '&hearts;',
        'e299a6' => '&diams;',
    );

    // Decode UTF-8 code-table
    $HTML_SPECIAL_CHARS = array();
    foreach ($HTML_SPECIAL_CHARS_UTF8 as $hex => $html) {
        $key = '';
        if (strlen($hex) == 4) {
            $key = pack("CC", hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)));
        } elseif (strlen($hex) == 6) {
            $key = pack("CCC", hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2)));
        }

        if ($key) {
            $HTML_SPECIAL_CHARS[$key] = $html;
        }
    }

    // Common conversion
    $string = str_replace(array_keys($HTML_SPECIAL_CHARS), array_values($HTML_SPECIAL_CHARS), $string);

    /* note: apply htmlspecialchars if desired /before/ applying this function
    /* Only do the slow convert if there are 8-bit characters */
    /* avoid using 0xA0 (\240) in ereg ranges. RH73 does not like that */
    if (!preg_match("~[\200-\237]~", $string) and !preg_match("~[\241-\377]~", $string)) {
        return $string;
    }

    // reject too-short sequences
    $string = preg_replace("/[\302-\375]([\001-\177])/", "&#65533;\\1", $string);
    $string = preg_replace("/[\340-\375].([\001-\177])/", "&#65533;\\1", $string);
    $string = preg_replace("/[\360-\375]..([\001-\177])/", "&#65533;\\1", $string);
    $string = preg_replace("/[\370-\375]...([\001-\177])/", "&#65533;\\1", $string);
    $string = preg_replace("/[\374-\375]....([\001-\177])/", "&#65533;\\1", $string);
    $string = preg_replace("/[\300-\301]./", "&#65533;", $string);
    $string = preg_replace("/\364[\220-\277]../", "&#65533;", $string);
    $string = preg_replace("/[\365-\367].../", "&#65533;", $string);
    $string = preg_replace("/[\370-\373]..../", "&#65533;", $string);
    $string = preg_replace("/[\374-\375]...../", "&#65533;", $string);
    $string = preg_replace("/[\376-\377]/", "&#65533;", $string);
    $string = preg_replace("/[\302-\364]{2,}/", "&#65533;", $string);
    /*
        // decode four byte unicode characters
        $string = preg_replace_callback(
            "/([\360-\364])([\200-\277])([\200-\277])([\200-\277])/",
            function ($matches)
            {
                return '&#'.((ord($matches[1])&7)<<18 | (ord($matches[2])&63)<<12 |(ord($matches[3])&63)<<6 | (ord($matches[4])&63)).';';
            },
            $string);

        // decode three byte unicode characters
        $string = preg_replace_callback(
            "/([\340-\357])([\200-\277])([\200-\277])/",
            function ($matches)
            {
                return '&#'.((ord($matches[1])&15)<<12 | (ord($matches[2])&63)<<6 | (ord($matches[3])&63)).';';
            },
            $string);

        // decode two byte unicode characters
        $string = preg_replace_callback(
            "/([\300-\337])([\200-\277])/",
            function ($matches)
            {
                return '&#'.((ord($matches[1])&31)<<6 | (ord($matches[2])&63)).';';
            },
            $string);

        // reject leftover continuation bytes
        $string = preg_replace("/[\200-\277]/", "&#65533;", $string);
    */
    return $string;
}


function i18n()
{
    $i8 = getMemcache('#i18n');
    $va = func_get_args();
    $ft = array_shift($va);

    if (is_array($ft)) list($ft, $sph) = $ft; else $sph = '';
    $sph .= hi18n($ft);

    // match soundex found
    if (isset($i8[$sph]))
        $ft = UTF8ToEntities($i8[$sph]);

    // Replace placeholders
    foreach ($va as $id => $vs)
        $ft = str_replace("%" . ($id + 1), $vs, $ft);

    return $ft;
}

function cn_url_modify()
{
    global $PHP_SELF;
    $GET = $_GET;
    $args = func_get_args();
    $SN = $PHP_SELF;

    // add new params
    foreach ($args as $ks) {
        // 1) Control
        if (is_array($ks)) {
            foreach ($ks as $vs) {
                $id = $val = '';

                if (strpos($vs, '=') !== FALSE) {
                    list($id, $var) = explode('=', $vs, 2);
                } else {
                    $id = $vs;
                }
                if ($id == 'self') {
                    $SN = $var;
                } elseif ($id == 'reset') {
                    $GET = array();
                } elseif ($id == 'group') {
                    foreach ($vs as $a => $b) {
                        $GET[$a] = $b;
                    }
                }
            }
        } // 2) Subtract
        elseif (strpos($ks, '=') === FALSE) {
            $keys = explode(',', $ks);

            foreach ($keys as $key) {
                $key = trim($key);
                if (isset($GET[$key])) {
                    unset($GET[$key]);
                }
            }
        } // 3) Add
        else {
            list($k, $v) = explode('=', $ks, 2);

            $GET[$k] = $v;
            if ($v === '') {
                unset($GET[$k]);
            }
        }
    }

    return cn_pack_url($GET, $SN);
}

// URL LIBRARY ---------------------------------------------------------------------------------------------------------

// Since 2.0: Grab from $_POST all parameters
function cn_parse_url()
{
    // Decode post data
    $post_data = array();
    if (isset($_POST['__post_data'])) {
        $post_data = unserialize(base64_decode($_POST['__post_data']));
    }
    // A. Click "confirm"
    if (REQ('__my_confirm') == '_confirmed') {
        // In case if exists another data from form
        $APPEND = isset($_POST['__append']) ? $_POST['__append'] : array();

        $_POST = $post_data;
        $_POST['__my_confirm'] = '_confirmed';

        // Return additional parameters in POST
        if (is_array($APPEND)) foreach ($APPEND as $id => $v) $_POST[$id] = $v;

        return TRUE;
    } // B. Click "decline"
    elseif (REQ('__my_confirm') == '_decline') {
        $_POST['__referer'] = $post_data['__referer'];
        return FALSE;
    } // C. First access
    else {
        $_POST['__referer'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        //print "0000000000000000000000000000000000000000:" . $_POST['__referer'] . "<br>";
        //print "0000000000000000000000000000000000000000 HTTP_REFERER:" . $_SERVER['HTTP_REFERER'] . "<br>";
    }

    // Set POST required params to GET
    if (REQ('mod', 'POST')) $_GET['mod'] = REQ('mod', 'POST');
    if (REQ('opt', 'POST')) $_GET['opt'] = REQ('opt', 'POST');
    if (REQ('sub', 'POST')) $_GET['sub'] = REQ('sub', 'POST');

    // Unset signature dsi
    unset($_GET['__signature_key'], $_GET['__signature_dsi']);

    return FALSE;
}


// Since 2.0: Pack only required parameters
function cn_pack_url($GET, $URL = PHP_SELF)
{
    $url = $result = array();

    foreach ($GET as $k => $v) if ($v !== '') $result[$k] = $v;
    foreach ($result as $k => $v) $url[] = "$k=" . urlencode($v);

    list($ResURL) = hook('core/url_rewrite', array($URL . ($url ? '?' . join('&', $url) : ''), $URL, $GET));
    return $ResURL;
}

// Since 1.5.0: Cascade Hooks
function hook($hook, $args = null)
{

    global $_HOOKS;

    // Plugin hooks
    if (!empty($_HOOKS[$hook]) && is_array($_HOOKS[$hook])) {
        foreach ($_HOOKS[$hook] as $hookfunc) {
            if ($hookfunc[0] == '*') {
                $_args = call_user_func_array(substr($hookfunc, 1), $args);
            } else {
                $_args = call_user_func($hookfunc, $args);
            }

            if (!is_null($_args)) {
                $args = $_args;
            }
        }
    }

    return $args;
}

// Since 2.0: Extended extract
function _GL($v)
{
    $vs = explode(',', $v);
    $result = array();
    foreach ($vs as $vc) {
        $el = explode(':', $vc, 2);
        $vc = isset($el[0]) ? $el[0] : false;
        $func = isset($el[1]) ? $el[1] : false;
        $var = false;
        if ($vc) $var = isset($GLOBALS[trim($vc)]) ? $GLOBALS[trim($vc)] : false;
        if ($func) $var = call_user_func($func, $var);
        $result[] = $var;
    }

    return $result;
}

/*  ---------- Sanitize: get POST vars (default) --------
    POST [def] only POST
    GET only GET
    POSTGET -- or POST or GET
    GETPOST -- or GET or POST
    REQUEST -- from REQUEST
    COOKIES -- from COOKIES
    GLOB -- from GLOBALS
    + combination (comma separated)
*/

// Since 1.5.3
function GET($var, $method = 'GETPOST')
{
    $result = array();
    $vars = separateString($var);
    $method = strtoupper($method);

    if ($method == 'GETPOST') {
        $methods = array('GET', 'POST');
    } elseif ($method == 'POSTGET') {
        $methods = array('POST', 'GET');
    } elseif ($method == 'GPG') {
        $methods = array('POST', 'GET', 'GLOB');
    } else {
        $methods = separateString($method);
    }

    foreach ($vars as $var) {
        $var = trim($var);
        $value = null;

        foreach ($methods as $method) {
            if ($method == 'GLOB' && isset($GLOBALS[$var])) {
                $value = $GLOBALS[$var];
            } elseif ($method == 'POST' && isset($_POST[$var])) {
                $value = $_POST[$var];
            } elseif ($method == 'GET' && isset($_GET[$var])) {
                $value = $_GET[$var];
            } elseif ($method == 'POSTGET') {
                if (isset($_POST[$var])) {
                    $value = $_POST[$var];
                } elseif (isset($_GET[$var])) {
                    $value = $_GET[$var];
                }
            } elseif ($method == 'GETPOST') {
                if (isset($_GET[$var])) {
                    $value = $_GET[$var];
                } elseif (isset($_POST[$var])) {
                    $value = $_POST[$var];
                }
            } elseif ($method == 'REQUEST' && isset($_REQUEST[$var])) {
                $value = $_REQUEST[$var];
            } elseif ($method == 'COOKIE' && isset($_COOKIE[$var])) {
                $value = $_COOKIE[$var];
            }

            if (!is_null($value)) {
                break;
            }
        }

        $result[] = $value;
    }
    return $result;
}

// Since 1.5.0
// Separate string to array: imporved "explode" function
function separateString($separated_string, $seps = ',')
{
    if (strlen($separated_string) == 0) {
        return array();
    }
    $ss = explode($seps, $separated_string);
    return $ss;
}

// Since 2.0: convert all GET to hidden fields
function cn_snippet_get_hidden($ADD = array())
{
    $hid = '';
    $GET = $_GET + $ADD;
    foreach ($GET as $k => $v) {
        if ($v !== '') {
            $hid .= '<input type="hidden" name="' . cn_htmlspecialchars($k) . '" value="' . cn_htmlspecialchars($v) . '" />';
        }
    }

    return $hid;
}

// Since 2.0: Cutenews HtmlSpecialChars
function cn_htmlspecialchars($_str)
{
    $key = array('&' => '&amp;', '"' => '&quot;', "'" => '&#039;', '<' => '&lt;', '>' => '&gt;');
    $matches = null;
    preg_match('/(&amp;)+?/', $_str, $matches);
    if (count($matches) != 0) {
        array_shift($key);
    }
    return str_replace(array_keys($key), array_values($key), $_str);
}


// Since 2.0: Unpack cookie for ACP
function cn_cookie_unpack($cookie)
{
    $list = array();

    $cookies = explode(',', $cookie);
    foreach ($cookies as $c) {
        $c = trim($c);
        if (isset($_COOKIE[$c])) {
            $list[] = unserialize(base64_decode($_COOKIE[$c]));
        } else {
            $list[] = array();
        }
    }

    return $list;
}

// Since 2.0: Pack cookie for ACP
function cn_cookie_pack()
{
    $args = func_get_args();
    $cookie = array_shift($args);

    $cookies = explode(',', $cookie);
    //print "bqn cooki " . $cookie . "<br>";
    foreach ($cookies as $id => $cookie) {
        print "bqn cooki " . $cookie . "<br>";
        print "bqn cooki id " . $id . "<br>";
        $cookie = trim($cookie);
        if ($args[$id]) {

            $data = base64_encode(serialize($args[$id]));
        } else {
            $data = null;
        }
        print "bqn cooki of data " . $data . "<br>";
        setcookie($cookie, $data);
    }
}


// Since 1.5.3
// GET Helper for single value
// $method[0] = * ---> htmlspecialchars ON
function REQ($var, $method = 'GETPOST')
{
    if ($method[0] == '*') {
        list($value) = (GET($var, substr($method, 1)));
        return cn_htmlspecialchars($value);
    } else {
        list($value) = GET($var, $method);
        return $value;
    }
}


// Since 2.0: Get cached categories with acl test
function cn_get_categories($is_frontend = FALSE)
{
    if ($cc = getMemcache('#categories')) {
        $catgl = $cc;
    } else {
        //$catgl = getOption('#category');
        list($catgl) = cn_category_struct_display();
        //$catgl = cn_category_struct_display();
        mcache_set('#categories', $catgl);
    }

    // Delete not allowed cats
    foreach ($catgl as $id => $v) {
        print "F_cn_url_modify 761 test id f $id <br>";
        if ($id == '#') {
            unset($catgl[$id]);
        } elseif (!test_cat($id) && !$is_frontend) {
            unset($catgl[$id]);
        }
    }

    //return array($catgl);
    return $catgl;
}


// Since 2.0: Test category accessible for current user
function test_cat($cat)
{
    $user = getMember();
    $grp = getOption('#grp');

    if (!$user) return FALSE;

    // Get from cache
    if ($cc = getMemcache('#categories'))
        $catgl = $cc;
    else {
        //$catgl = getOption('#category');
        list($catgl) = cn_category_struct_display();
        mcache_set('#categories', $catgl);
    }

    print "F_cn_url_modify 600 xac dinh bien cat truyen: $cat <br>";
    //foreach ($catgl as $f =>$r)
    //print "F_cn_url_modify 600 xac dinh bien catgl: $f =>". $r['acl'] ."<br>";
    //foreach ($cc as $f =>$r)
    //print "F_cn_url_modify 600 xac dinh bien cc: $f =>". $r['acl'] ." <br>";


    // View all category
    if (test('Ccv'))
        return TRUE;

    $acl = $user['acl'];
    $cat = separateString($cat);

    // Overall ACL test, with groups + own
    $acl = array_unique(array_merge(array($acl), separateString($grp[$acl]['G'])));

    foreach ($cat as $ct) {
        // Requested cat not exists, skip
        if (!isset($catgl[$ct])) continue;

        // Group list included (partially/fully) in group list for category
        $sp = separateString($catgl[$ct]['acl_forum']);
        $is = array_intersect($sp, $acl);
        if (!$is) return FALSE;
    }

    return TRUE;
}


// Since 2.0: Extended assign
function cn_assign()
{
    $args = func_get_args();
    $keys = explode(',', array_shift($args));

    foreach ($args as $id => $arg) {
        // Simple assign
        if (isset($keys[$id])) {
            $KEY = trim($keys[$id]);
            $GLOBALS[$KEY] = $arg;
        } else // Inline assign
        {
            list($k, $v) = explode('=', $arg, 2);
            $GLOBALS[$k] = $v;
        }
    }
}


// Since 2.0: Show breadcrumbs
function cn_snippet_bc($sep = '&gt;')
{
    $bc = getMemcache('.breadcrumbs');
    echo '<div class="cn_breadcrumbs">';

    $ls = array();
    if (is_array($bc)) {
        foreach ($bc as $item) {
            $ls[] = '<span class="bcitem"><a href="' . $item['url'] . '">' . cn_htmlspecialchars($item['name']) . '</a></span>';
        }
    }
    echo join(' <span class="bcsep">' . $sep . '</span> ', $ls);
    echo '</div>';
}


// ---------------------------------------- SNIPPETS -------------------------------------------------------------------

// Since 2.0: Generate CSRF stamp (only for members)
// @Param: type = std (input hidden), a (inline in a)
function cn_snippet_digital_signature($type = 'std')
{
    $member = getMember();

    // Is not member - is fatal error
    if (is_null($member)) die("Exception with generating signature");

    // Make signature
    $sign_extr = MD5(time() . mt_rand()) . '-' . $member['name'];
    $signature = MD5($sign_extr . $member['pass'] . MD5(getOption('#crypt_salt')));

    if ($type == 'std') {
        echo '<input type="hidden" name="__signature_key" value="' . cn_htmlspecialchars($sign_extr) . '" />';
        echo '<input type="hidden" name="__signature_dsi" value="' . cn_htmlspecialchars($signature) . '" />';
    } elseif ($type == 'a') {
        return '__signature_dsi_inline=' . $signature . '.' . urlencode($sign_extr);
    }

    return FALSE;
}

// Since 2.0: Write default input=hidden fields
function cn_form_open($fields)
{
    $fields = explode(',', $fields);
    foreach ($fields as $field) {
        $_field = REQ(trim($field), 'GPG');
        echo '<input type="hidden" name="' . trim($field) . '" value="' . cn_htmlspecialchars($_field) . '" />';
    }

    cn_snippet_digital_signature();
}

// Since 2.0: Create snippet for open external window
function cn_snippet_open_win($url, $params = array(), $title = 'CN Window')
{
    if (empty($params['w'])) {
        $params['w'] = 550;
    }
    if (empty($params['h'])) {
        $params['h'] = 500;
    }
    if (empty($params['t'])) {
        $params['t'] = 100;
    }
    if (empty($params['l'])) {
        $params['l'] = 100;
    }
    if (empty($params['sb'])) {
        $params['sb'] = 1;
    }
    if (empty($params['rs'])) {
        $params['rs'] = 1;
    }

    $echo = '';
    if ($params['l'] === 'auto') {
        $echo .= 'var lp=(window.innerWidth - ' . $params['w'] . ') / 2; ';
    } else {
        $echo .= 'var lp=' . $params['l'] . '; ';
    }

    return $echo . "window.open('$url', '$title', 'scrollbars={$params['sb']},resizable={$params['rs']},width={$params['w']},height={$params['h']},left='+lp+',top={$params['t']}'); return false;";
}


// Since 1.4.7: Insert smilies for adding into news/comments
function insert_smilies($insert_location, $break_location = FALSE, $admincp = FALSE)
{
    $i = 0;
    $output = false;
    //$config_http_script_dir = 'http://localhost/forum';
    $config_http_script_dir = getOption('http_script_dir');
    $smilies = separateString(getOption('smilies'));
    //$smilies    = separateString('smile,wink,wassat,tongue,laughing,sad,angry,crying');

    foreach ($smilies as $smile) {
        $i++;
        $smile = trim($smile);

        if ($admincp) {
            $output .= '<a href="#" onclick="insertAtCursor(document.getElementById(\'' . $insert_location . '\'), \' :' . $smile . ': \'); return false;"><img alt="' . $smile . '" src="' . $config_http_script_dir . '/skins/emoticons/' . $smile . '.gif" /></a>';
        } else {
            if (getOption('base64_encode_smile')) {
                $url = "data:image/png;base64," . base64_encode(join('', file(SERVDIR . '/skins/emoticons/' . $smile . '.gif')));
            } else {
                $url = $config_http_script_dir . "/skins/emoticons/" . $smile . ".gif";
            }
            $output .= "<a href='#' onclick='insertext(\":$smile:\", \"$insert_location\"); return false;'><img style=\"border: none;\" alt=\"$smile\" src=\"$url\" /></a>";
        }

        if (isset($break_location) && intval($break_location) > 0 && $i % $break_location == 0) {
            $output .= "<br />";
        } else {
            $output .= "&nbsp;";
        }
    }

    return $output;
}


// Since 1.5.3: UTF8-Cutenews compliant
function utf8decrypt($str, $oldhash)
{
    $len = strlen($str) * 3;
    while ($len >= 16) $len -= 16;
    $len = floor($len / 2);

    $salt = substr($oldhash, $len, 10);
    $pass = SHA256_hash($salt . $str . '`>,');
    $pass = substr($pass, 0, $len) . $salt . substr($pass, $len);

    return $pass;
}


// Since 1.5.0: Handle user errors
function user_error_handler($errno, $errmsg, $filename, $linenum, $vars)
{
    $errtypes = array
    (
        E_ERROR => "Error",
        E_WARNING => "Warning",
        E_PARSE => "Parsing Error",
        E_NOTICE => "Notice",
        E_CORE_ERROR => "Core Error",
        E_CORE_WARNING => "Core Warning",
        E_COMPILE_ERROR => "Compile Error",
        E_COMPILE_WARNING => "Compile Warning",
        E_USER_ERROR => "User Error",
        E_USER_WARNING => "User Warning",
        E_USER_NOTICE => "User Notice",
        E_STRICT => "Runtime Notice",
        E_DEPRECATED => "Deprecated"
    );

    // Debug log not enabled, see in error.log
    if (!file_exists(SERVDIR . '/debug')) {
        return;
    }

    // E_NOTICE skip
    if ($errno == E_NOTICE) {
        return;
    }

    $out = $errtypes[$errno] . ': ' . $errmsg . '; ' . trim($filename) . ':' . $linenum . ";";
    $out = str_replace(array("\n", "\r", "\t"), ' ', $out);

    // Store data
    $dbg_info = '';

    // show debug if php >= 4.3.0
    if (function_exists('debug_backtrace') && CN_DEBUG) {
        foreach (debug_backtrace() as $item) {
            if ($item['function'] != 'user_error_handler') {
                $dbg_info .= '   ' . str_replace(SERVDIR, '', $item['file']) . ":" . $item['line'] . " " . $item['function'] . '(' . count($item['args']) . ')' . "\n";
            }
        }

        $dbg_info .= "\n";
    }

    $str = trim(str_replace(array("\n", "\r", SERVDIR), array(" ", " ", ''), $out));
    if (is_writable(cn_path_construct(SERVDIR, 'log'))) {
        $time = time();
        $log = fopen(cn_path_construct(SERVDIR, 'log') . 'error_dump.log', 'a');
        fwrite($log, '[' . $time . '] ' . date('Y-m-d H:i:s', $time) . '|' . $str . "\n$dbg_info");
        fclose($log);
    }
}


// Since 2.0: Add user log
function cn_user_log($msg)
{
    if (!getOption('userlogs')) {
        return;
    }

    if (!file_exists($ul = cn_path_construct(SERVDIR, 'log') . 'user.log')) {
        fclose(fopen($ul, 'w+'));
    }

    $a = fopen($ul, 'a');
    fwrite($a, time() . '|' . str_replace("\n", ' ', $msg) . "\n");
    fclose($a);
}

// ----------------------------------------------------

// Since 2.0: Decode "defaults/templates" to list
function cn_template_list()
{
    $config = file(cn_path_construct(SKIN, 'defaults') . 'templates.tpl');
    $tbasic = getOption('#templates_basic');
    $tbasic['hash'] = isset($tbasic['hash']) ? $tbasic['hash'] : '';

    // template file is changed
    if ($tbasic['hash'] !== ($nhash = md5(join(',', $config)))) {
        $templates = array();
        $current_tpl_name = $_tpl_var = '';

        foreach ($config as $line) {
            if ($line[0] == '#') {
                $current_tpl_name = trim(substr($line, 1));
                $templates[$current_tpl_name] = array();
                continue;
            }

            // Subtemplate markers
            if ($line[0] == '*') {
                $_tpl_var = trim(substr($line, 1));
                if ($_tpl_var) $template_vars[$_tpl_var] = '';
            } // Subtemplate codes
            elseif (preg_match('/\s/', $line[0]) || $line[0] === '') {
                if (isset($templates[$current_tpl_name][$_tpl_var])) {
                    $templates[$current_tpl_name][$_tpl_var] .= substr($line, 1);
                } else {
                    $templates[$current_tpl_name][$_tpl_var] = substr($line, 1);
                }
            }
        }

        // set <change hash> var and parsed templates
        $tbasic['hash'] = $nhash;
        $tbasic['templates'] = $templates;

        //setoption('#templates_basic', $tbasic);
    }

    return isset($tbasic['templates']) ? $tbasic['templates'] : array();
}

// Since 2.0: Get template (if not exists, create from defaults)
function cn_get_template($subtemplate, $template_name = 'default')
{
    print "F_cn_url_modify 597 bien kiem tra subtemplat: " . $subtemplate . "<br>";
    $templates = getOption('#templates');
    //---------------------------------------------
    //foreach($templates as $rt =>$sd){
    //print "F_cn_url_modify 597 bien kiem tra subtemplat: $rt" . $sd . "<br>";
    //print "F_cn_url_modify 597 bien kiem tra template_name: $template_name <br>";
    //}
    //exit();
    //---------------------------------------------
    foreach ($templates as $kf => $gh) {
        print "F_core 2626 bien templates: " . $gh . "<br><br>";
    }
    //----------------------------------
    $template_name = strtolower($template_name);

    // User template not exists in config... get from defaults
    if (isset($templates[$template_name])) {
        return $templates[$template_name][$subtemplate];
    }

    $list = cn_template_list();


    if (isset($list[$template_name][$subtemplate])) {
        return $list[$template_name][$subtemplate];
    }

    return false;
}

/*
// Since 2.0: @bootstrap in case if UTF-8 used in Admin Panel
function cn_sendheaders()
{
    header( 'X-Frame-Options:sameorigin' );
    header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
    header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
    header( 'Cache-Control: no-store, no-cache, must-revalidate' );
    header( 'Cache-Control: post-check=0, pre-check=0', false );
    header( 'Pragma: no-cache' );

    if (getOption('useutf8'))
    {
        header( 'Content-Type: text/html; charset=UTF-8', true);
        header( 'Accept-Charset: UTF-8', true);
    }

    b64dck();
}


// And the duck fly away.
function b64dck()
{
    $cr = bd_config('e2NvcHlyaWdodHN9');
    $shder = bd_config('c2tpbl9oZWFkZXI=');
    $sfter = bd_config('c2tpbl9mb290ZXI=');

    global $$shder,$$sfter;
    $HDpnlty = bd_config('PGNlbnRlcj48aDE+Q3V0ZU5ld3M8L2gxPjxhIGhyZWY9Imh0dHA6Ly9jdXRlcGhwLmNvbSI+Q3V0ZVBIUC5jb208L2E+PC9jZW50ZXI+PGJyPg==');
    $FTpnlty = bd_config('PGNlbnRlcj48ZGl2IGRpc3BsYXk9aW5saW5lIHN0eWxlPVwnZm9udC1zaXplOiAxMXB4XCc+UG93ZXJlZCBieSA8YSBzdHlsZT1cJ2ZvbnQtc2l6ZTogMTFweFwnIGhyZWY9XCJodHRwOi8vY3V0ZXBocC5jb20vY3V0ZW5ld3MvXCIgdGFyZ2V0PV9ibGFuaz5DdXRlTmV3czwvYT4gqSAyMDA1ICA8YSBzdHlsZT1cJ2ZvbnQtc2l6ZTogMTFweFwnIGhyZWY9XCJodHRwOi8vY3V0ZXBocC5jb20vXCIgdGFyZ2V0PV9ibGFuaz5DdXRlUEhQPC9hPi48L2Rpdj48L2NlbnRlcj4=');

    if (!stristr($$shder,$cr) and !stristr($$sfter,$cr))
    {
        $$shder = $HDpnlty.$$shder;
        $$sfter = $$sfter.$FTpnlty;
    }
}
*/

// Since 2.0: Replace all {name} and [name..] .. [/name] in template file
function entry_make($entry, $template_name, $template_glob = 'default', $section = '')
{

    global $_raw_md5;

    $_raw_md5 = array();
    $template = cn_get_template($template_name, strtolower($template_glob));

    list($template, $raw_vars) = cn_extrn_raw_template($template);


    // Extrn function for replace
    $template = cn_extrn_morefields($template, $entry, $section);

    //-----------------------
    //print "F_core 2668: " . $template . "<br>";


    // Hooks before
    //list($template) = hook('core/entry_make_start', array($template, $entry, $template_name, $template_glob));

    // Catch { ... }
    if (preg_match_all('/\{(.*?)\}/is', $template, $tpls, PREG_SET_ORDER)) {
        foreach ($tpls as $tpl) {
            $result = '';
            $tplp = explode('|', $tpl[1], 2);
            $tplc = isset($tplp[0]) ? $tplp[0] : '';
            $tpla = isset($tplp[1]) ? $tplp[1] : '';

            // send modifiers titte
            $short = "cn_modify_" . ($section ? $section . '_' : "");

            if (function_exists($short)) {
                $result = call_user_func($short, $entry, explode('|', $tpla));
            }
            $template = str_replace($tpl[0], $result, $template);
        }
    }
//exit();
    // Extern function [middle]
    $template = cn_extrn_if_cond($template);

    // Hooks middle
    //list($template) = hook('core/entry_make_mid', array($template, $entry, $template_name, $template_glob));

    // Catch[bb-tag]...[/bb-tag]
    if (preg_match_all('/\[([\w-]+)(.*?)\](.*?)\[\/\\1\]/is', $template, $tpls, PREG_SET_ORDER)) {
        foreach ($tpls as $tpl) {
            $result = '';
            $short = "cn_modify_bb_" . ($section ? $section . '_' : "");
            $short .= preg_replace('/[^a-z]/i', '_', $tpl[1]);

            if (function_exists($short)) {
                $result = call_user_func($short, $entry, $tpl[3], $tpl[2]); // entry, text, options
            }
            $template = str_replace($tpl[0], $result, $template);
        }

    }
    // Hooked
    //list($template) = hook('core/entry_make_end', array($template, $entry, $template_name, $template_glob));

    // UTF-8 -- convert to entities on frontend
    /*
	if ($section == 'comm' && getOption('comment_utf8html'))
    {
        $template = UTF8ToEntities($template);
    }
    elseif (!$section && getOption('utf8html'))
    {
        $template = UTF8ToEntities($template);
    }
	*/
    $template = UTF8ToEntities($template);
    // Return raw data
    list($template) = cn_extrn_raw_template($template, $raw_vars);

    return $template;
}


// Since 1.5.0: Hash type MD5 and SHA256
function hash_generate($password, $md5hash = false)
{
    $try = array
    (
        0 => md5($password),
        1 => utf8decrypt($password, $md5hash),
        2 => SHA256_hash($password),
    );

    return $try;
}


// Since 2.0: @bootstrap
function cn_detect_user_ip()
{
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $IP = $_SERVER['HTTP_CLIENT_IP'];
    }

    if (empty($IP) && isset($_SERVER['REMOTE_ADDR'])) {
        $IP = $_SERVER['REMOTE_ADDR'];
    }
    if (empty($IP)) {
        $IP = false;
    }

    if (!preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $IP)) {
        $IP = '';
    }

    define('CLIENT_IP', $IP);
    // CRYPT_SALT consists an IP
    define('CRYPT_SALT', (getOption('ipauth') == '1' ? CLIENT_IP : '') . '@' . getOption('#crypt_salt'));
}

function cn_load_session()
{
    session_name('CUTENEWS_SESSION');
    session_start();

    if (isset($_COOKIE['session']) && ($users = cn_cookie_restore())) {
        $_SESSION['users'] = $users;
    }
}


//----------------------------------S login-----------------------------------------------

function cn_cookie_unset()
{
    setcookie('session', '', 0, '/');
}

function cn_relocation($url)
{
    header("Location: $url");
    echo '<html><head><title>Redirect...</title><meta http-equiv="refresh" content="0;url=' . cn_htmlspecialchars($url) . '"></head><body>' . i18n('Please wait... Redirecting to ') . cn_htmlspecialchars($url) . '...<br/><br/></body></html>';
    die();
}

function cn_cookie_remember($client = false)
{
    // String serialize
    $cookie = strtr(base64_encode(xxtea_encrypt(serialize($_SESSION['users']), CRYPT_SALT)), '=/+', '-_.');
    if ($client) {
        echo '<script type="text/javascript">cn_set_cookie("session", "' . $cookie . '")</script>';
        echo "<noscript>Your browser is not Javascript enable or you have turn it off. COOKIE not saved</noscript>";
    } else {
        //exit();
        setcookie('session', $cookie, time() + 60 * 60 * 24 * 2, '/');
    }
}

function cn_cookie_restore()
{
    $xb64d = xxtea_decrypt(base64_decode(strtr($_COOKIE['session'], '-_.', '=/+')), CRYPT_SALT);

    if ($xb64d) {
        return unserialize($xb64d);
    }

    return false;
}

/////////////////////////////////
// Function:	msg
// Description:	Displays message

function msg($type, $title, $text, $back = FALSE)
{
    echoheader($type, $title);
    echo "<table border=0 cellpading=0 cellspacing=0 width=100%;><tr><td style='padding:12px'>$text";
    if ($back) {
        $back = str_replace('&amp;amp;', '&amp;', str_replace('&', '&amp;', $back));
        echo '<br /><br> <a href="' . $back . '">go back</a>';
    }
    echo '</td></tr></table>';
    exit();
}


// Since 2.0: Short message form
function msg_info($title, $go_back = null)
{
    include SERVDIR . '/skins/default.skin.php';
    echoheader('info', i18n("Permission check"));

    if ($go_back === null) $go_back = $_POST['__referer'];
    if (empty($go_back)) $go_back = PHP_SELF;

    echo "<p>" . i18n($title) . "</p>";
    echo "<p><b><a href='$go_back'>OK</a></b></p>";

    echofooter();
    DIE();
}


//// Since 2.0: @bootstrap
//function cn_load_skin()
//{
//    $config_skin = preg_replace('~[^a-z]~i', '', getOption('skin'));
//    if (file_exists($skin_file = SERVDIR . "/skins/$config_skin.skin.php")) {
//        echo "F_cn_url_modify 1364 => $skin_file <br>";
//        include($skin_file);
//    } else {
//        die("Can't load skin $config_skin");
//    }
//}


// Since 2.0: Check CSRF challenge
function cn_dsi_check()
{
    list($key, $dsi) = GET('__signature_key, __signature_dsi', 'GETPOST');

    if (empty($key) && empty($dsi)) {
        list($dsi_inline) = GET('__signature_dsi_inline', 'GETPOST');

        if ($dsi_inline) {
            list($dsi, $key) = explode('.', $dsi_inline, 2);
        } else {
            die('CSRF attempt! No data');
        }

        // cn_url_modify
        unset($_GET['__signature_dsi_inline']);
    } else {
        // cn_url_modify
        unset($_GET['__signature_key'], $_GET['__signature_dsi']);
    }

    $member = getMember();
    list(, $username) = explode('-', $key, 2);

    if ($member['name'] !== $username)
        die('CSRF attempt! Username invalid');

    // Get signature
    $signature = MD5($key . $member['pass'] . MD5(getOption('#crypt_salt')));

    if ($dsi !== $signature)
        die('CSRF attempt! Signatures not match');
}


// get data catagoris and forums array ==> chua goi
function cn_get_catforum()
{

    global $db;
    $dcat = array();
    $dforum = array();
    //catagoris
    $catsql = "SELECT id, name FROM categories;";
    $catresult = $db->query($catsql);
    if ($catresult->num_rows != 0)
        while ($catrow = $catresult->fetch_assoc()) {
            $dcat[] = $catrow;
        }

    //forums
    $catsql1 = "SELECT id, cat_id, name FROM forums;";//" WHERE cat_id =" . $getidcat . ";";
    $catresult1 = $db->query($catsql1);
    if ($catresult1->num_rows != 0)
        while ($catfor = $catresult1->fetch_assoc()) {
            $dforum[] = $catfor;
        }
    return array($dcat, $dforum);

}


// Since 2.0: Basic function for list news
function cn_get_news($opts)
{
    global $db;
    //$FlatDB = new FlatDB();

    // Source must be:
    // -----------------
    // null -- active news only
    // 'draft'
    // 'archive'
    // 'A2' -- active news and archives
    // -----------------

    $source = isset($opts['source']) ? $opts['source'] : '';
    //$archive_id = isset($opts['archive_id']) ? intval($opts['archive_id']) : 0;

    // Sorting
    $sort = isset($opts['sort']) ? $opts['sort'] : '';
    $dir = isset($opts['dir']) ? strtolower($opts['dir']) : '';

    // Pagination
    $page = isset($opts['page']) ? intval($opts['page']) : 0;
    $per_page = isset($opts['per_page']) ? intval($opts['per_page']) : 25;

    // Filters user and forum
    //$page_alias = isset($opts['page_alias']) ? $opts['page_alias'] : '';
    $cfilter = isset($opts['cfilter']) ? $opts['cfilter'] : array();
    $ufilter = isset($opts['ufilter']) ? $opts['ufilter'] : array();
    //$tag        = isset($opts['tag']) ? trim(strtolower($opts['tag'])) : '';
    //$only_active= isset($opts['only_active']) ? $opts['only_active'] : false;

    // System
    //$nocat      = isset($opts['nocat']) ? $opts['nocat'] : false;
    //$by_date    = isset($opts['by_date']) ? $opts['by_date'] : '';
    //$nlpros     = isset($opts['nlpros']) ? intval($opts['nlpros']) : 0;

    //Filters Y-m-d
    //$year      = !isset($opts['year']) ? $opts['year'] : date('Y');
    //$mon    = !isset($opts['mon']) ? $opts['mon'] : date('F');
    //$day     = !isset($opts['day']) ? intval($opts['day']) : date('d');

    if (isset($opts['sort'])) {
        $sort = stripslashes($opts['sort']);
        $sort = mysqli_real_escape_string($db, $sort);
    }
    if (isset($opts['dir'])) {
        $dir = stripslashes($opts['dir']);
        $dir = mysqli_real_escape_string($db, $dir);
    }

    //y-m-d
    if (isset($opts['year'])) {
        $year = stripslashes($opts['year']);
        $year = mysqli_real_escape_string($db, $year);
    }
    if (isset($opts['mon'])) {
        $mon = stripslashes($opts['mon']);
        $mon = mysqli_real_escape_string($db, $mon);
    }
    if (isset($opts['day'])) {
        $day = stripslashes($opts['day']);
        $day = mysqli_real_escape_string($db, $day);
    }

    // ==============================================================================================================

    print "F_cn_url_modify 1574 sort: $sort <br>";
    print "F_cn_url_modify 1574 dir: $dir <br>";
    print "F_cn_url_modify 1574 page: $page <br>";
    print "F_cn_url_modify 1574 per_page: $per_page <br>";
    if (!empty($ufilter)) {
        arsort($ufilter);
        foreach ($ufilter as $vl => $k) {
            print "F_cn_url_modify 1583 id_ user " . $vl . " <br>";
        }
    }
    arsort($cfilter);
    foreach ($cfilter as $vl => $k) {
        print "F_cn_url_modify 1583 id_ forums " . $vl . " <br>";
    }
    if (isset($year))
        print "F_cn_url_modify 1574 year: $year <br>";
    if (isset($mon))
        print "F_cn_url_modify 1574 mon: $mon <br>";
    if (isset($day))
        print "F_cn_url_modify 1574 day: $day <br>";

    // ----------------------S _ Mysql select------------------------------


    //none sql
    $order1 = "SELECT topics.id AS topicid, (SELECT name_forum FROM `forums` WHERE topics.forum_id = forums.id) AS nameforum, (SELECT acl_forum FROM `forums` WHERE topics.forum_id = forums.id) as acl_forum, (SELECT count(*) FROM `messages` WHERE messages.topic_id = topics.id) AS com, topics.*, users.username, messages.id AS messagesid, messages.date AS messagesdate, messages.user_id AS messagesuser_id FROM messages, topics, users WHERE topics.user_id = users.id";
    // if active or draft
    if ($source == '') {
        $order2 = " AND topics.active ='1'";
    } else
        $order2 = " AND topics.active ='0'";

    // array cfilter (topics)
    $order3 = '';
    if (count($cfilter) > 0) {
        arsort($cfilter);
        $checkok = true;
        foreach ($cfilter as $id) {
            if ($checkok) {
                $order3 .= " AND (topics.forum_id = '$id'";
                $checkok = false;
            } else
                $order3 .= " OR topics.forum_id = '$id'";
        }
        $order3 .= ")";
    }
    //array ucfirst (user)
    if (count($ufilter) > 0) {
        arsort($ufilter);
        $checkok = true;
        foreach ($ufilter as $uid) {
            if ($checkok) {
                $order3 .= " AND (users.id = '$uid'";
                $checkok = false;
            } else
                $order3 .= " OR users.id = '$uid'";
        }
        $order3 .= ")";
    }

    //year=2015&mon=September&day=27
    $order4 = '';
    if (isset($year)) {
        $order4 .= " AND YEAR(topics.date) = '$year'";
        if (isset($mon)) {
            $order4 .= " AND MONTHNAME(topics.date) = '$mon'";
            if (isset($day))
                $order4 .= " AND DAY(topics.date) = '$day'";
        }
    }

    //sort _date _ num comment _ author
    if ($sort == 'date') {
        if ($dir == 'd')
            $order4 .= " GROUP BY topics.id ORDER BY topics.date DESC";
        else if ($dir == 'a')
            $order4 .= " GROUP BY topics.id ORDER BY topics.date ASC";
    } else if ($sort == 'author') {
        if ($dir == 'd')
            $order4 .= " GROUP BY topics.id ORDER BY users.username DESC";
        else if ($dir == 'a')
            $order4 .= " GROUP BY topics.id ORDER BY users.username ASC";
    } else if ($sort == 'comments') {
        if ($dir == 'd')
            $order4 .= " GROUP BY topics.id ORDER BY com DESC";
        else if ($dir == 'a')
            $order4 .= " GROUP BY topics.id ORDER BY com ASC";
    }

    // ----------------------End _ Mysql select------------------------------

// ----------------------my select Active or ndraft------------------------------
    $order = $order1 . $order2 . $order3 . $order4;
    $sqlpagina = $db->query($order);
    $total = $sqlpagina->num_rows; //total recode

//-----------------------my se total ndraft------------------------------------------

    $orderw = $order1 . " AND topics.active = '0'" . $order3 . $order4 . ";";
    $sqlndraft = $db->query($orderw);
    $numdraft = $sqlndraft->num_rows; // recode

//-------------------------sum recode toptipc full year mont day my select------------------------

    $sum_recode_topics = $order1 . $order2 . $order3;

//--------------------_year _ month _day---------------------------

    $myy = "SELECT DISTINCT YEAR(date) as year FROM topics ORDER BY year DESC;";
    if (isset($year)) {
        $YS = $year;
        $myym = "SELECT DISTINCT MONTHNAME(date) as mon FROM topics WHERE YEAR(date) = '" . $YS . "' ORDER BY mon DESC;";
        if (isset($mon)) {
            $MS = $mon;
            $myymd = "SELECT DISTINCT DAY(date) as day FROM topics WHERE YEAR(date) = '" . $YS . "' AND MONTHNAME(date) = '" . $MS . "' ORDER BY day DESC;";
            if (isset($day))
                $DS = $day;
        }
    }

//$mysql_tem = $sum_recode_topics . " AND YEAR(topics.date) = '" . $year . "' AND MONTHNAME(topics.date) = '" . $mon . "' AND DAY(topics.date) = '". $day ."' GROUP BY topics.id;";

    $dyear = array();
    $dmon = array();
    $dday = array();
    $dymd = array();

    $dy = $db->query($myy);
    if ($dy->num_rows != 0) // recode
        while ($dyrow = $dy->fetch_assoc()) {
            $dyear[] = $dyrow;
        }


    //if (in_array($dyear['year'], $dyear)) {
    if (isset($year)) {
        $dm = $db->query($myym);
        if ($dm->num_rows != 0) // recode
            while ($dmrow = $dm->fetch_assoc()) {
                $dmon[] = $dmrow;
            }
    }

    if (isset($mon) && count($dmon) > 0) {
        $dd = $db->query($myymd);
        if ($dd->num_rows != 0) // recode
            while ($ddrow = $dd->fetch_assoc()) {
                $dday[] = $ddrow;
            }
    }

    if (isset($mon) && count($dday) > 0) {
        $mysql_tem1 = "SELECT count(topics.id) as numrecode FROM  topics, users WHERE topics.user_id = users.id AND YEAR(topics.date) = '" . $year . "' AND MONTHNAME(topics.date) = '" . $mon . "'" . $order2 . $order3;
        arsort($dday);
        foreach ($dday as $id => $val) {
            $valday = $val['day'];
            $mysql_tem = $mysql_tem1 . " AND DAY(topics.date) = '" . $valday . "';";//" GROUP BY topics.id;";

            PRINT "SQL num recode : $mysql_tem <br>";

            $resul_num_topics_full_date = $db->query($mysql_tem);
            if ($resul_num_topics_full_date->num_rows != 0)
                while ($dymdrow = $resul_num_topics_full_date->fetch_assoc()) {
                    $dymd[] = $dymdrow;
                }

            else
                $dymd[$id] = null;
        }
    }

// array filter forums and filter user
    //$arrayforum = array();
    $arrayuser = array();
    /*
    if(count($cfilter) >0 && isset($cfilter)){
        arsort($cfilter);
        foreach ($cfilter as $id) {
            $myfsql = "SELECT id, name FROM forums WHERE id =" . $id . ";";
            $fresult =$db->query($myfsql);
            if($fresult ->num_rows!=0){
                while($frow_name = $fresult ->fetch_assoc()){
                    $arrayforum[] = $frow_name;
                }
            }
        }
    }
    */
    if (count($ufilter) > 0 && isset($ufilter)) {
        arsort($ufilter);
        foreach ($ufilter as $id) {
            $myusersql = "SELECT id, username FROM users WHERE id =" . $id . ";";
            $myuserresult = $db->query($myusersql);
            if ($myuserresult->num_rows != 0) {
                while ($frow_user_name = $myuserresult->fetch_assoc()) {
                    $arrayuser[] = $frow_user_name;
                }
            }
        }
    }

//-------------------------test my select------------------------
//$ndraft = $total;
    echo "order: <br><br><br> " . $order . "<br>";
//echo "------------------------------------------------------------------<br>";
//echo "orderw: <br> " . $orderw . "<br>";

    if (!getOption('num_center_pagination'))
        $adjacents = 3; // num lastpage center
    else
        $adjacents = getOption('num_center_pagination');


    if ($page)
        $start = ($page - 1) * $per_page; //first item to display on this page
    else {
        $start = 0;
    }

    /* Setup page vars for display. */
    if ($page == 0) $page = 1; //if no page var is given, default to 1.
    $prev = $page - 1; //previous page is current page - 1
    $next = $page + 1; //next page is current page + 1
    $lastpage = ceil($total / $per_page); //lastpage.
    $lpm1 = $lastpage - 1; //last page minus 1

// ---------------------my select view recode--------------------------
    $ordershow = $order;
    $ordershow .= " LIMIT $start ,$per_page;";


//----------------num total show view---------------------
    $dataresult = array();
    $sql_query_num = $db->query($ordershow);
    if ($sql_query_num->num_rows != 0)
        while ($datadrow = $sql_query_num->fetch_assoc()) {
            $dataresult[] = $datadrow;
        }

//------------------------------------


    /* CREATE THE PAGINATION */

    $pagination = "";
    if ($lastpage > 1) {
        $pagination .= "<div class='light-theme simple-pagination pagination'> <ul>";

        if ($page > 1) {
            $pagination .= "<li><a href=" . cn_url_modify('mod=editnews', "page=$prev") . " class='page-link prev'>Prev</a></li>";
        } elseif ($page == 1)
            $pagination .= "<li><a rel='nofollow' href='' class='current'>Prev</a></li>";

        if ($lastpage < 7 + ($adjacents * 2)) { // so trang < 13 = so bt hien thi
            for ($counter = 1; $counter <= $lastpage; $counter++) {
                if ($counter == $page)
                    $pagination .= "<li><a rel='nofollow' href='#' class='current'>$counter</a></li>";
                else
                    $pagination .= "<li><a href=" . cn_url_modify('mod=editnews', "page=$counter") . " class='page-link'>$counter</a></li>";
            }
        } elseif ($lastpage > 5 + ($adjacents * 2)) { //enough pages to hide some so trang >11
            //close to beginning; only hide later pages
            if ($page < 1 + ($adjacents * 2)) { //  hien tai < 7...... => hientai 1 2 3 4 5 6 7 => hien 1 2 3 4 5 6 7 8 9
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) { //$counter < 9 + (2 tr cuoi)
                    if ($counter == $page)
                        $pagination .= "<li><a rel='nofollow' href='#' class='current'>$counter</a></li>";
                    else
                        $pagination .= "<li><a href=" . cn_url_modify('mod=editnews', "page=$counter") . " class='page-link'>$counter</a></li>";
                }

                $pagination .= "<li>...</li>";
                $pagination .= "<li><a href=" . cn_url_modify('mod=editnews', "page=$lpm1") . " class='page-link'>$lpm1</a></li>";
                $pagination .= "<li><a href=" . cn_url_modify('mod=editnews', "page=$lastpage") . " class='page-link'>$lastpage</a></li>";
            } //in middle; hide some front and some back
            elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) { // so tr - 6 > hientai  hienta > 6

                $pagination .= "<li><a href=" . cn_url_modify('mod=editnews', "page=1") . " class='page-link'>1</a></li>";        // trang dau 1
                $pagination .= "<li><a href=" . cn_url_modify('mod=editnews', "page=2") . " class='page-link'>2</a></li>";        // trang thu 2
                $pagination .= "<li>...</li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) { // 1 2 3 hientai 5 6 7  (tong 7)

                    if ($counter == $page)
                        $pagination .= "<li><a rel='nofollow' href='#' class='current'>$counter</a></li>";
                    else
                        $pagination .= "<li><a href=" . cn_url_modify('mod=editnews', "page=$counter") . " class='page-link'>$counter</a></li>";
                }

                $pagination .= "<li>...</li>";

                $pagination .= "<li><a href=" . cn_url_modify('mod=editnews', "page=$lpm1") . " class='page-link'>$lpm1</a></li>"; // trang cuoi - 1
                $pagination .= "<li><a href=" . cn_url_modify('mod=editnews', "page=$lastpage") . " class='page-link'>$lastpage</a></li>";  // trang cuoi

            } //close to end; only hide early pages
            else {
                $pagination .= "<li><a href=" . cn_url_modify('mod=editnews', "page=1") . " class='page-link'>1</a></li>";
                $pagination .= "<li><a href=" . cn_url_modify('mod=editnews', "page=2") . " class='page-link'>2</a></li>";
                $pagination .= "<li>...</li>";

                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {  // chi so = tong - 8; chi so < tong class="current"
                    if ($counter == $page) {
                        $pagination .= "<li><a rel='nofollow' href='#' class='current'>$counter</a></li>";
                    } else {
                        $pagination .= "<li><a href=" . cn_url_modify('mod=editnews', "page=$counter") . " class='page-link'>$counter</a></li>";
                    }
                }
            }
        }

        //next button
        if (($page >= 1) && $page < $lastpage) {
            $pagination .= "<li><a href=" . cn_url_modify('mod=editnews', "page=$next") . " class='page-link'>Next</a></li>";
        } elseif ($page == $lastpage) {
            $pagination .= "<li><a rel='nofollow' href='' class='current'>Next</a></li>";
        }

        $pagination .= "</ul></div>\n";
    }

//------------------------------------------------------
    print "----------------------------- <br>";
    print "F_cn_url_modify 1873 msql order: $order <br>";
    print "----------------------------- <br>";
    print "F_cn_url_modify 1873 msql orderw: $orderw <br>";
    print "----------------------------- <br>";
    print "F_cn_url_modify 1873 msql ordershow:  $ordershow<br>";
    print "-----------------------------F_cn_url_modify 1873 -----------------------------------------<br>";
    print "F_cn_url_modify 1883 tong : $total <br>";
    print "F_cn_url_modify 1883 tong nhap : $numdraft <br>";

    foreach ($dyear as $vl => $k) {
        print "F_cn_url_modify 1737 select year: $vl => " . $k['year'] . " <br>";
    }
    foreach ($dmon as $vl => $k) {
        print "F_cn_url_modify 1741 select mon: $vl => " . $k['mon'] . " <br>";
    }
    foreach ($dday as $vl => $k) {
        print "F_cn_url_modify 1744 select day: $vl => " . $k['day'] . " <br>";
    }

    foreach ($dymd as $vl => $k) {
        print "F_cn_url_modify 1747 select day: $vl => " . $k['numrecode'] . " <br>";
    }

    foreach ($dataresult as $vl => $k) {
        print "F_cn_url_modify 1887 data: $vl => " . $k['id'] . " <br>";
    }
    //------------------------------------------------------


    return array($dyear, $dmon, $dday, $dymd, $arrayuser, $dataresult, $total, $numdraft, $pagination);

    /*
    // Prepare vars
    // ------------------

    if ($only_active) { $source = ''; }

    $overall  = 0;
    $ufilter  = $FlatDB->load_users_id($ufilter);
    $date_out = separateString($by_date, '-');

    // Match news by page-alias
    // -------------------
    if ($page_alias)
    {
        if ($_id = bt_get_id($page_alias, 'pg_ts'))
        {
            $FlatDB->list = array($_id => array());
        }
    }
    // Preloading indexes
    // ------------------
    else
    {
        if ($source === '') {
            $FlatDB->load_by();
        }
        elseif ($source === 'archive') {
            $FlatDB->load_by("archive-$archive_id.txt");
        }
        elseif ($source === 'draft') {
            $FlatDB->load_by('idraft.txt');
        }
        elseif ($source === 'A2') {
            $FlatDB->load_overall();
        }
        else {
            die("CN Internal error: source not recognized\n");
        }

        // Expand required data
        $FlatDB->load_ext_by(array
        (
            'tg'     => $tag, // title or sort by tags
            'title'  => (strtolower($sort) === 'title'), // sort by title
            'author' => ($sort === 'author'), // sort by author name
        ));

        // Filtering data
        // ----------------

        // $cfilter, $ufilter - intersect (one match) filter by category and user_id
        // $nocat   = if has, and $cfilter is empty, stay news withot category only
        // $date_out = '[Y]-[m]-[d]' if present, stay only this date (-,Y,Y-m,Y-m-d)
        // $nlpros  = if present, show prospected (postponed) news

        $FlatDB->filters($cfilter, $ufilter, $tag, $nocat, $date_out, $nlpros);
        $FlatDB->sorting($sort, $dir);

        // Pagination
        // ----------
        $overall = count($FlatDB->list);
        $FlatDB->slicing($st, $per_page);
    }

    // Get news entries
    $entries = $FlatDB->load_entries();

    // Get news structure
    // -------------------------

    $qtree   = array();
    $dirs    = scan_dir(cn_path_construct(SERVDIR, 'cdata', 'news'), '^[\d\-]+\.php$');
    foreach ($dirs as $tc) {
        if (preg_match('/^([\d\-]+)\.php$/i', $tc, $c)) {
            $qtree[$c[1]] = 0;
        }
    }

    // meta-info
    $rev = array(
        'qtree'       => $qtree,
        'overall'     => $overall,
        'cpostponed'  => $FlatDB->_item_postponed
    );

    return array($entries, $rev);
    */
}


// Since 2.0: Make 'Top menu'
function cn_get_menu()
{
    $modules = hook('core/cn_get_menu', array
    (
        'editconfig' => array('Cd', 'Config'),
        'editconfig&opt=category' => array('Cc', 'Edit Catagoris'),
        'editforums' => array('Cc', 'Edit Forum'),
        'addnews' => array('Can', 'Add Topic'),
        'editnews' => array('Can', 'Edit Topic', NULL, 'source,year,mon,day,sort,dir'), //can => add; new cvn => view
        'editcomment' => array('Com', 'Edit Comment'),
        'help' => array('', 'Help/About', 'about'),
        'logout' => array('', 'Logout', 'logout'),
    ));

    if (getOption('main_site'))
        $modules['my_site'] = getOption('main_site');

    $result = '<ul>';
    $mod = REQ('mod', 'GPG');

    foreach ($modules as $mod_key => $var) {
        if (!is_array($var)) {
            $result .= '<li><a href="' . cn_htmlspecialchars($var) . '" target="_blank">' . i18n('Visit site') . '</a></li>';
            continue;
        }

        $acl = isset($var[0]) ? $var[0] : false;
        $name = isset($var[1]) ? $var[1] : '';
        $title = isset($var[2]) ? $var[2] : '';
        $app = isset($var[3]) ? $var[3] : '';

        print "F_cn_url_modify 1539 get acl: $acl <br>";
        //exit();
        if ($acl && !test($acl))
            continue;

        if (isset($title) && $title) $action = '&amp;action=' . $title; else $action = '';
        if ($mod == $mod_key) $select = ' active '; else $select = '';

        // Append urls for menu (preserve place)
        if (isset($app) && $app) {
            $actions = array();
            $mv = separateString($app);

            foreach ($mv as $vx)
                if ($dt = REQ($vx))
                    $actions[] = "$vx=" . urlencode($dt);

            if ($actions) $action .= '&amp;' . join('&amp;', $actions);
        }

        $result .= '<li class = "' . $select . '"><a href="' . PHP_SELF . '?mod=' . $mod_key . $action . '">' . i18n($name) . '</a></li>';
    }

    $result .= "</ul>";

    return $result;
}


function getMember()
{
    // Not authorized
    if (empty($_SESSION['users'])) {
        return NULL;
    }

    // No in cache
    if ($member = getMemcache('#member')) {
        return $member;
    }

    echo "$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ " . $_SESSION['users'] . "<br>";
    mcache_set('#member', $user = db_user_by_name($_SESSION['users']));
    //------------------------------------
    foreach ($user as $d => $s) {
        print "F_cn_url_modify 2148 bien user: $d =>" . $s . "<br>";
    }
    //exit();
    //------------------------------------
    return $user;
}


// Since 1.5.1: Validate email
function check_email($email)
{
    return (preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $email));
}

// Since 2.0: Cutenews login routines
function cn_login()
{

    global $db;

    // bien = t1 ? t2 : F => t1 sai thi t1 = F;
    $logged_username = isset($_SESSION['users']) ? $_SESSION['users'] : FALSE;

    if ($logged_username == false) echo "F_cn_url_modify 1608 bien kiem login bi sai <br>";

    //exit();

    // Check user exists. If user logged, but not exists, logout now
    if ($logged_username && !db_user_by_name($logged_username)) {
        cn_logout();
    }

    $is_logged = false;

    list($action) = GET('action', 'GET,POST');
    list($username, $pwd, $remember) = GET('username, password, rememberme', 'POST');

    // users not authorized now
    if (!$logged_username) {
        // last url for return after users logged in
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $_SESSION['RQU'] = preg_replace('/[^\/\.\?\=\&a-z_0-9]/i', '', $_SERVER['REQUEST_URI']);
        }

        print "F_cn_url_modify 1629 bien sesseion old url: " . $_SESSION['RQU'] . "<br>";


        if ($action == 'dologin') {
            if ($username && $pwd) {


                $name = strip_tags($username);
                $name = mysqli_real_escape_string($db, $name);

                //$password = strip_tags($pwd);
                //$password = mysqli_real_escape_string($db,$password);

                $member = db_user_by_name($name);

                //-------------------------------------------
                foreach ($member as $e => $g)
                    print "F_cn_url_modify 1639 Sai $e => $g <br>";
                //exit();

                //$pawd = md5($password);

                //$sql = "SELECT username, password, ban FROM admins WHERE username = '" . $name . "' AND password = '" . $pawd . "' LIMIT 0,1;";
                //$sql = "SELECT username, password, ban, numlogin FROM admins WHERE username = '" . $name . "' LIMIT 0,1;";// AND password = '" . $pawd . "' LIMIT 0,1;";


                if (!isset($config_login_ban)) {
                    $config_login_ban = 5;
                }

                $compares = hash_generate($pwd);

                if (!isset($member['pass'])) {
                    $member['pass'] = '';
                }

                //if($numrows >= 1) {
                //----------------------------------------------------
                //$get_ban_time = isset($row['ban']) ? (int)$row['ban'] : 0;
                //$get_ban_time = $row['ban'];


                //$ban_time = isset($row['ban']) ? (int)$row['ban'] : 0;
                $ban_time = isset($member['Ban']) ? (int)$member['Ban'] : 0;

                // ban limit
                if ($ban_time && $ban_time > time()) {
                    msg_info('Too frequent queries. Wait ' . ($ban_time - time() . ' sec.'));
                }

                //------------------------------------
                //echo "<br>pass dang nhap: " . $password . "<br>";
                //echo "<br> Time: " . time() . "<br>";
                //echo "bantime: " . $member['ban'] . "<br>";
                //echo "pass csdl: " . $row['password'] . "<br>";
                //foreach($compares as $d =>$g){
                //print "kt: $d => $g <br>";
                //}
                //exit();
                //------------------------------------
                if (!isset($member['pass'])) {
                    $member['pass'] = '';
                }
                $numlogin = isset($member['numlogin']) ? (int)$member['numlogin'] : 0;

                //if ($numrows >= 1 && in_array($row['password'], $compares) && (((time() - $ban_time) > 6*3600) || (($config_login_ban - $row['numlogin']) > 0))){
                if (in_array($member['pass'], $compares) && (((time() - $ban_time) > 6 * 3600) || (($config_login_ban - $member['numlogin']) > 0))) {
                    $is_logged = true;

                    // set users to session
                    $_SESSION['users'] = $name;
                    //$_SESSION['users'] = true;

                    echo "F_cn_url_modify 1795 set name : $name <br>";
                    echo " F_cn_url_modify 1796 set sesseion uset sw: " . $_SESSION['users'] . "<br>";
                    //exit();
                    // Save remember flag
                    $_SESSION['@rem'] = $remember;

                    if ($remember) {
                        cn_cookie_remember();
                    }

                    // save last login status, clear ban
                    //db_user_update($username, 'lts='.time(), 'ban=0');
                    $myupban = "UPDATE `admins` SET `ban`=0, numlogin = 1, lastdate = NOW() WHERE username = '$name';";
                    echo "msyql: " . $myupban;
                    //exit();
                    $db->query($myupban);


                    // send return header (if exists)
                    if (isset($_SESSION['RQU'])) {
                        cn_relocation($_SESSION['RQU']);
                    }
                } else {
                    cn_throw_message("Invalid password or login", 'e');

                    //if($numrows >= 1){
                    cn_user_log('User "' . substr($name, 0, 32) . '" (' . CLIENT_IP . ') login failed');

                    //db_user_update($username, 'ban='.(time() + getOption('ban_attempts')));
                    // ------------------------
                    //echo "ban gi option: " . time();
                    //echo "ban gi option: " . time() + getOption('ban_attempts');


                    //$numlogin = isset($row['numlogin']) ? (int)$row['numlogin'] : 0;
                    //$set_ban = isset($set_ban) ? (int)$set_ban : 0;

                    /*
                    if($config_login_ban < $numlogin)
                        $set_ban = time();
                    else
                        $set_ban = time() - 6*3600;
                    */

                    //$numlogin = $member['numlogin'];
                    //-----------------------------------------------

                    // LOGIN BAN
                    if ($config_login_ban > 0 && ($config_login_ban - $numlogin) <= 0 && (time() - $ban_time) < 6 * 3600) {
                        $minutez = ceil((6 * 3600 - (time() - $ban_time)) / 60);
                        $hourz = round($minutez / 60, 2);
                        $ban_title = "LOGIN DENIED";
                        $showtext = "You have tried to log in too many times. Your ban will be removed in {x} minutes (= {y} hours).";
                        msg('error', $ban_title, str_replace(array('{x}', '{y}'), array($minutez, $hourz), $showtext));
                    }
                    //-----------------------------------------------
                    $numlogin++;

                    $myup = "UPDATE `admins` SET `ban`=" . (time() + getOption('ban_attempts')) . ", numlogin = '" . $numlogin . "' WHERE username = '$name';";
                    echo "select update false: $myup <br>";
                    $db->query($myup);
                }

                //}
            } else {
                cn_throw_message('Enter login or password', 'e');
            }
        }
    } else {
        $is_logged = true;
    }
    // --------

    //print "F_cn_url_modify bat action: $action <br>";
    //exit();
    if ($action == 'logout') {
        print " F_cn_url_modify 1779 goi logout <br>";
        //exit();
        $is_logged = false;
        cn_logout();
    }

    // clear require url
    if ($is_logged && isset($_SESSION['RQU'])) {
        unset($_SESSION['RQU']);
    }


    return $is_logged;
}

// Since 2.0.3: Logout users and clean session
function cn_logout($relocation = PHP_SELF)
{
    cn_cookie_unset();
    session_unset();
    session_destroy();
    cn_relocation($relocation);
}

// Since 2.0: Save auth data for Guest users
function cn_guest_auth($name, $email, $client = TRUE)
{
    $_SESSION['guest_name'] = $name;
    $_SESSION['guest_email'] = $email;
}

// Since 2.0: Show login form
function cn_login_form($admin = TRUE)
{
    if ($admin) {
        echoheader("users", i18n("Please Login"));
    }

    echo exec_tpl('auth/login');

    if ($admin) {
        echofooter();
        die();
    }
}

// Since 2.0: Show register form
function cn_register_form($admin = TRUE)
{
    global $_SESS;

    //$flatDb = new FlatDB();

    // Restore active status
    if (isset($_GET['lostpass']) && $_GET['lostpass']) {
        $d_string = base64_decode($_GET['lostpass']);
        $d_string = xxtea_decrypt($d_string, MD5(CLIENT_IP) . getOption('#crypt_salt'));
        $d_string = substr($d_string, 64);

        if ($d_string) {
            list(, $d_username) = explode(' ', $d_string, 2);

            // All OK: authorize users
            $_SESSION['users'] = $d_username;

            cn_relocation(cn_url_modify('lostpass'));
            die();
        }

        msg_info('Fail: invalid string');
    }

    // Resend activation
    if (request_type('POST') && isset($_POST['register']) && isset($_POST['lostpass'])) {
        $users = db_user_by_name(REQ('username'));

        if (is_null($users)) {
            msg_info('User not exists');
        }

        $email = isset($users['email']) ? $users['email'] : '';

        // Check users name & mail
        if ($users && $email && $email == REQ('email')) {
            $rand = '';
            $set = 'qwertyuiop[],./!@#$%^&*()_asdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
            for ($i = 0; $i < 64; $i++) $rand .= $set[mt_rand() % strlen($set)];

            $secret = str_replace(' ', '', REQ('secret'));

            $url = getOption('http_script_dir') . '?lostpass=' . urlencode(base64_encode(xxtea_encrypt($rand . $secret . ' ' . REQ('username'), MD5(CLIENT_IP) . getOption('#crypt_salt'))));
            cn_send_mail($users['email'], i18n('Resend activation link'), cn_replace_text(cn_get_template('resend_activate_account', 'mail'), '%username%, %url%, %secret%', $users['name'], $url, $secret));

            msg_info('For you send activate link');
        }

        msg_info('Enter required field: email');
    }

    // is not registration form
    if (is_null(REQ('register', 'GET')))
        return FALSE;

    // Lost password: disabled registration - no affected
    if (!is_null(REQ('lostpass', 'GET'))) {
        $Action = 'Lost password';
        $template = 'auth/lost';
    } else {
        if (getOption('allow_registration')) {
            $Register_OK = FALSE;
            $errors = array();
            list($regusername, $regnickname, $regpassword, $confirm, $regemail, $captcha) = GET('regusername, regnickname, regpassword, confirm, regemail, captcha', "POST");

            // Do register
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($regusername === '') $errors[] = i18n("Username field can't be blank");
                if ($regemail === '') $errors[] = i18n("Email field can't be blank");
                if ($regpassword === '') $errors[] = i18n("Password field can't be blank");
                if (!preg_match('/[\w]\@[\w]/i', $regemail)) $errors[] = i18n("Email is invalid");

                if ($regpassword !== $confirm) $errors[] = i18n("Confirm password not match");
                if ($captcha !== $_SESSION['CSW']) $errors[] = i18n("Captcha not match");

                if (strlen($regpassword) < 3) $errors[] = i18n('Too short password');

                // Do register
                if (empty($errors)) {
                    // get real users in index file
                    $users = user_lookup($regusername);

                    if (is_null($users)) {
                        $users = db_user_by($regemail);

                        if (is_null($users)) {
                            $pass = SHA256_hash($regpassword);
                            $acl_groupid_default = intval(getOption('registration_level'));

                            //db_user_add($regusername, $acl_groupid_default);
                            //db_user_update($regusername, "email=$regemail", "name=$regusername", "nick=$regnickname", "pass=$pass", "acl=$acl_groupid_default");

                            $Register_OK = TRUE;
                        } else {
                            $errors[] = i18n("Email already exists");
                        }
                    } else {
                        $errors[] = i18n("Username already exists");
                    }
                }

                // Registration OK, authorize users
                if ($Register_OK === TRUE) {
                    $_SESSION['users'] = $regusername;

                    // Clean old data
                    if (isset($_SESSION['RQU'])) {
                        unset($_SESSION['RQU']);
                    }

                    if (isset($_SESSION['CSW'])) {
                        unset($_SESSION['CSW']);
                    }

                    // Send notify about register
                    if (getOption('notify_registration')) {
                        cn_send_mail(getOption('notify_email'), i18n("New registration"), i18n("users %1 (email: %2) registered", $regusername, $regemail));
                    }

                    header('Location: ' . PHP_SELF);
                    die();
                }
            }
            cn_assign('errors_result, regusername, regnickname, regemail', $errors, $regusername, $regnickname, $regemail);
        } else {
            msg_info(i18n('Registration disabled'));
        }

        $Action = 'Register users';
        $template = 'auth/register';
    }

    if (empty($template)) {
        return false;
    }

    if ($admin) {
        echoheader('Register', $Action);
    }

    echo exec_tpl($template);

    if ($admin) {
        echofooter();
        die();
    }

    return TRUE;
}


// Since 2.0: Add message
function cn_throw_message($msg, $area = 'n')
{
    $es = getMemcache('msg:stor');

    if (!isset($es[$area])) $es[$area] = array();
    $es[$area][] = i18n($msg);

    mcache_set('msg:stor', $es);

    return FALSE;
}


// Since 2.0: Get messages
function cn_get_message($area, $method = 's') // s-show, c-count
{

    $es = getMemcache('msg:stor');
    if (isset($es[$area])) {
        if ($method == 's') return $es[$area];
        elseif ($method == 'c') return count($es[$area]);
    }
    return null;
}


// Since 2.0; HTML show errors
function cn_snippet_messages($area = 'new')
{
    //exit();
    $delay = 7500;
    $result = '';

    for ($i = 0; $i < strlen($area); $i++) {
        $messages = cn_get_message($area[$i], 's');

        $type = 'notify';
        if ($area[$i] == 'e') {
            $type = 'error';
        } elseif ($area[$i] == 'w') {
            $type = 'warnings';
        }

        if ($messages) {
            $result .= '<div class="cn_' . $type . '_list">';
            foreach ($messages as $msg) {
                $NID = 'notify_' . ctime() . mt_rand();
                $result .= '<div class="cn_' . $type . '_item" id="' . $NID . '"><div><b>' . date('H:i:s', ctime()) . '</b> ' . $msg . '</div></div>';
                $result .= '<script>notify_auto_hide("' . $NID . '", ' . $delay . ');</script>';

                $delay += 1000;
            }
            $result .= '</div>';
        }
    }

    if ($result) {
        echo '<div class="cn_notify_overall">' . $result . '</div>';
    }
}

// Custoem bqn msyql category into insert table forums
function cn_category_insert($category_id, $category_name, $category_memo, $category_icon, $cat_acl, $category_parent, $category_description)
{ // chua duoc goi toi
    global $db;
//$db->set_charset("utf8");
    $msew = "INSERT INTO `forums`(`id`, `name_forum`, `memo_forum`, `icon_forum`, `acl_forum`, `parent_forum`, `level_forum`, `ac_forum`, `description_forum`) VALUES('"
        //$addsql = "INSERT INTO `admins`(`id`, `username`, `password`, `email`, `nick`, `e-hide`, `acl_forum` , `avatar`, `ban`, `numlogin`, `lastdate`, `more`) VALUES('"
        . $category_id //id
        . "', '" . $category_name //name_forum
        . "', '" . $category_memo //memo_forum
        . "', '" . $category_icon //icon_forum
        . "', '" . $cat_acl //acl_forum
        . "', '" . intval($category_parent) //parent_forum
        . "', '" . '' //level_forum
        . "', '" . '' //ac_forum
        . "', '" . $category_description
        . "');"; //description_forum

    echo "F_cn_url_modify 2698 mysql insert table forums: $msew <br>";
    //exit();

    if ($db->query($msew)) return true;
    else return false;
    //die ('Topic_Error:'. mysqli_error());
}

// Custoem bqn msyql category into update table forums
function cn_category_update($category_id, $category_name, $category_memo, $category_icon, $cat_acl, $category_parent, $category_level, $category_ac, $category_description)
{ // chua duoc goi toi
    global $db;
//$db->set_charset("utf8");
    $mesw = "UPDATE `forums` SET `name_forum`='"
        . $category_name //name
        . "', `memo_forum`='" . $category_memo //memo
        . "', `icon_forum`='" . $category_icon //icon
        . "', `acl_forum`='" . $cat_acl //acl
        . "', `parent_forum`='" . $category_parent //parent
        . "', `level_forum`='" . $category_level //level
        . "', `ac_forum`='" . $category_ac //ac_forum
        . "', `description_forum`='" . $category_description
        . "' WHERE id = '$category_id';"; //lastdate


    echo "F_cn_url_modify 2723 mysql update table forums: $mesw <br>";
    //exit();

    if ($db->query($mesw)) return true;
    else return false;
    //die ('Topic_Error:'. mysqli_error());
}

// Custoem bqn msyql category into tree
function cn_category_struct_display($categories_c)
{

    global $db;
    //$categories_c = array();
    $gddf = $db->query("SELECT * FROM `forums`;");
    while ($catford = $gddf->fetch_assoc()) //fetch_assoc //fetch_array
        $categories_re[] = $catford;

    if (!empty($categories_re)) {
        foreach ($categories_re as $cm => $hh) {
            $_cm = $hh['id'];
            $categories[$_cm]['id'] = $hh['id'];
            $categories[$_cm]['name_forum'] = $hh['name_forum'];
            $categories[$_cm]['memo_forum'] = $hh['memo_forum'];
            $categories[$_cm]['icon_forum'] = $hh['icon_forum'];
            $categories[$_cm]['acl_forum'] = $hh['acl_forum'];
            $categories[$_cm]['parent_forum'] = $hh['parent_forum'];
            $categories[$_cm]['level_forum'] = $hh['level_forum'];
            $categories[$_cm]['ac_forum'] = $hh['ac_forum'];
            $categories[$_cm]['description_forum'] = $hh['description_forum'];
        }

        //list($rge)= cn_category_struct($categories);
        //return $rge;

        return cn_category_struct($categories);
    } else
        return $categories_c;
}


// Since 2.0: Organize category into tree
function cn_category_struct($cats, $nc = array(), $parent = 0, $level = 0)
{
    $ic = array();
    $lc = array();

    foreach ($cats as $id => $vc) {
        $id_xd = $cats[$id]['id'];
        if ($id == '#') continue;
        if ($vc['parent_forum'] == $parent) {
            $nc[$id_xd] = $vc;
            $nc[$id_xd]['level_forum'] = $level;

            // get childrens nodes
            list($nc, $ch) = cn_category_struct($cats, $nc, $id_xd, $level + 1); // bqn
            //list($nc, $ch) = cn_category_struct($cats, $nc, $vc['id'], $level + 1);

            // all childrens for node
            $nc[$id_xd]['ac_forum'] = $ch;

            // linear child (current)
            $lc[] = $id_xd;        //bqn
            //$lc[] = $vc['id'];

            // all inner childs
            $ic = array_unique(array_merge($ic, $ch));
        }
    }

    return array($nc, array_merge($ic, $lc));
}


//----------------------------------E login-----------------------------------------------


// Displays header skin
// $image = img@custom_style_tpl
function echoheader($image, $header_text, $bread_crumbs = false)
{
    global $skin_header, $lang_content_type, $skin_menu, $skin_prefix, $_SESS, $_SERV_SESS;


    $header_time = date('H:i:s | d, M, Y', ctime());

    $customs = explode("@", $image);
    $image = isset($customs[0]) ? $customs[0] : '';
    $custom_style = isset($customs[1]) ? $customs[1] : false;
    $custom_js = isset($customs[2]) ? $customs[2] : false;

    if (isset($_SESSION['users'])) {
        $skin_header = preg_replace("/{menu}/", $skin_menu, $skin_header);
    } else {
        $skin_header = preg_replace("/{menu}/", "<div style='padding: 5px;'><a href='" . PHP_SELF . "'>" . VERSION_NAME . "</a></div>", $skin_header);
    }

    //$skin_header = get_skin($skin_header);
    $skin_header = str_replace('{title}', ($header_text ? $header_text . ' / ' : '') . 'CuteNews', $skin_header);
    $skin_header = str_replace("{image-name}", $skin_prefix . $image, $skin_header);
    $skin_header = str_replace("{header-text}", $header_text, $skin_header);
    $skin_header = str_replace("{header-time}", $header_time, $skin_header);
    $skin_header = str_replace("{content-type}", $lang_content_type, $skin_header);
    $skin_header = str_replace("{breadcrumbs}", $bread_crumbs, $skin_header);

    if ($custom_style) {
        $custom_style = read_tpl($custom_style);
    }
    $skin_header = str_replace("{CustomStyle}", $custom_style, $skin_header);

    if ($custom_js) {
        $custom_js = '<script type="text/javascript">' . read_tpl($custom_js) . '</script>';
    }
    $skin_header = str_replace("{CustomJS}", $custom_js, $skin_header);

    echo $skin_header;
}

//function echofooter()
//{
//    global $is_loged_in, $skin_footer, $lang_content_type, $skin_menu, $config_adminemail, $config_admin;
//
//    if ($is_loged_in == TRUE)
//        $skin_footer = str_replace("{menu}", $skin_menu, $skin_footer);
//    else $skin_footer = str_replace("{menu}", " &nbsp; ", $skin_footer);
//
//    //$skin_footer = get_skin($skin_footer);
//    //$skin_footer = str_replace("{content-type}", $lang_content_type, $skin_footer);
//    $skin_footer = str_replace("{exec-time}", round(microtime(true) - BQN_MU, 3), $skin_footer);
//    $skin_footer = str_replace("{year-time}", date("Y"), $skin_footer);
//    $skin_footer = str_replace("{email-name}", $config_adminemail, $skin_footer);
//    $skin_footer = str_replace("{byname}", $config_admin, $skin_footer);
//
//    die($skin_footer);
//}


// Since 2.0: Set GET params
function cn_set_GET($e)
{
    $ex = separateString($e);
    foreach ($ex as $id) {
        if ($dt = REQ($id, 'GPG')) {
            if (is_array($dt)) {
                //use only string
                $dt = array_pop($dt);
            }

            $idp = explode('=', $id, 2);
            $id = isset($idp[0]) ? $idp[0] : false;
            $def = isset($idp[1]) ? $idp[1] : false;

            // By default, skip this
            if (isset($def) && $def && strtolower($def) == strtolower($dt)) {
                continue;
            }

            if ($id) {
                $_GET[trim($id)] = trim($dt);
            }
        }
    }
}

//time
function ctime()
{
    date_default_timezone_set("UTC");
    return (time() + 3600 * getOption('date_adjust'));
}


// Hello skin!
function get_skin($skin)
{
    $licensed = false;
    if (!file_exists(cn_path_construct(SERVDIR, 'cdata') . 'reg.php')) {
        $stts = base64_decode('KHVucmVnaXN0ZXJlZCk=');
    } else {
        include(SERVDIR . '/cdata/reg.php');
        if (isset($reg_site_key) == false) {
            $reg_site_key = false;
        }

        $mmbrid = null;
        if (preg_match('/\\A(\\w{6})-\\w{6}-\\w{6}\\z/', $reg_site_key, $mmbrid)) {
            if (!isset($reg_display_name) or !$reg_display_name or $reg_display_name == '') {
                $stts = "<!-- (-$mmbrid[1]-) -->";
            } else {
                $stts = "<label title='(-$mmbrid[1]-)'>" . base64_decode('TGljZW5zZWQgdG86IA==') . $reg_display_name . '</label>';
            }
            $licensed = true;
        } else {
            $stts = '!' . base64_decode('KHVucmVnaXN0ZXJlZCk=') . '!';
        }
    }

    $msn = bd_config('c2tpbg==');
    $cr = bd_config('e2NvcHlyaWdodHN9');
    $lct = bd_config('PGRpdiBzdHlsZT0iZm9udC1zaXplOiA5cHgiPlBvd2VyZWQgYnkgPGEgc3R5bGU9ImZvbnQtc2l6ZTogOXB4IiBocmVmPSJodHRwOi8vY3V0ZXBocC5jb20vY3V0ZW5ld3MvIiB0YXJnZXQ9Il9ibGFuayI+Q3V0ZU5ld3Mge2N2ZXJzaW9ufTwvYT4gJmNvcHk7IDIwMDImbmRhc2g7MjAxNCA8YSBzdHlsZT0iZm9udC1zaXplOiA5cHgiIGhyZWY9Imh0dHA6Ly9jdXRlcGhwLmNvbS8iIHRhcmdldD0iX2JsYW5rIj5DdXRlUEhQPC9hPi48YnI+e2wtc3RhdHVzfTwvZGl2Pg==');
    $lct = preg_replace("/{l-status}/", $stts, $lct);
    //$lct  = preg_replace("/{cversion}/", VERSION, $lct);

    if ($licensed == true) {
        $lct = false;
    }
    $$msn = preg_replace("/$cr/", $lct, $$msn);

    return $$msn;
}

// Since 1.4.x
function bd_config($str)
{
    return base64_decode($str);
}


// Since 1.5.1: Simply read template file
function read_tpl($tpl = 'index')
{
    // get from cache
    $cached = getMemcache("tpl:$tpl");
    if ($cached) {
        return $cached;
    }

    // Get asset path
    if (preg_match('/\.(css|js)/i', $tpl)) {
        $fine = '';
    } else {
        $fine = '.tpl';
    }

    // Get plugin path
    if ($tpl[0] == '/') {
        $open = cn_path_construct(SERVDIR, 'cdata', 'plugins') . substr($tpl, 1) . $fine;
    } else {
        $open = SKIN . DIRECTORY_SEPARATOR . ($tpl ? $tpl : 'default') . $fine;
    }

    // Try open
    $not_open = false;
    $r = fopen($open, 'r') or $not_open = true;
    if ($not_open) {
        return false;
    }

    ob_start();
    fpassthru($r);
    $ob = ob_get_clean();
    fclose($r);

    // caching file
    mcache_set("tpl:$tpl", $ob);
    return $ob;
}


//Since 2.0.3 crossplatform path generator
function cn_path_construct()
{
    $args = array();
    $arg_list = func_get_args();

    foreach ($arg_list as $varg) {
        if ($varg !== '') {
            $args[] = $varg;
        }
    }

    return implode(DIRECTORY_SEPARATOR, $args) . DIRECTORY_SEPARATOR;
}


// Since 2.0: Get option from #CFG or [%site][<opt_name>]
// Usage: #level1/level2/.../levelN or 'option_name' from %site
function getOption($opt_name = '')
{
    $cfg = getMemcache('config');

    if ($opt_name === '') {
        return $cfg;
    }
    if ($opt_name[0] == '#') {
        $cfn = separateString(substr($opt_name, 1), '/');
        foreach ($cfn as $id) {
            if (isset($cfg[$id])) {
                $cfg = $cfg[$id];
            } else {
                $cfg = array();
                break;
            }
        }

        return $cfg;
    } else {
        return isset($cfg['%site'][$opt_name]) ? $cfg['%site'][$opt_name] : FALSE;
    }
}

// Since 1.5.3: Set cache variable
function mcache_set($name, $var)
{
    global $_CN_SESS_CACHE;
    $_CN_SESS_CACHE[$name] = $var;
}


// Since 1.5.3: Get variable from cache
function getMemcache($name)
{
    global $_CN_SESS_CACHE;
    return isset($_CN_SESS_CACHE[$name]) ? $_CN_SESS_CACHE[$name] : FALSE;
}


// Since 2.0: Save option to config
// Usage: #level1/level2/.../levelN or 'option_name' from %site
function setoption($opt_name, $var)
{
    $cfg = getMemcache('config');

    if ($opt_name[0] == '#') {
        $c_names = separateString(substr($opt_name, 1), '/');
        $cfg = setoption_rc($c_names, $var, $cfg);
    } else {
        $cfg['%site'][$opt_name] = $var;
    }

    cn_config_save($cfg);
}


// Since 2.0: @Helper recursive function
function setoption_rc($names, $var, $cfg)
{
    $the_name = array_shift($names);

    if (count($names) == 0) {
        $cfg[$the_name] = $var;
    } else {
        if (!isset($cfg[$the_name])) {
            $cfg[$the_name] = '';
        }
        $cfg[$the_name] = setoption_rc($names, $var, $cfg[$the_name]);
    }

    return $cfg;
}


// Since 2.0: Modify inclusion parameters by filter
function cn_translate_active_news($entry, $translate)
{
    global $PHP_SELF, $_bc_PHP_SELF;

    // Reset: If PHP_SELF is not changed
    $PHP_SELF = $_bc_PHP_SELF;

    // Disable Rewrite (once)
    getMemcache(':disable_rw', FALSE);

    if (empty($translate) || !is_array($translate)) {
        return null;
    }
    // Check filters
    $apply = array();
    foreach ($translate as $rule => $changes) {
        list($ID, $RULE) = explode('=', $rule, 2);

        if ($ID == 'category' && array_intersect(separateString($RULE), separateString($entry['c']))) {
            $apply[] = $changes;
        }
    }

    // Apply changes, if exists
    foreach ($apply as $sh) {
        list($ID, $value) = explode('=', $sh, 2);
        if ($ID == 'php_self') {
            $PHP_SELF = $value;
        }
        if ($ID == ':disable_rw') {
            getMemcache(':disable_rw', TRUE);
        }
    }
}

// Since 2.0: Add BreadCrumb
function cn_bc_add($name, $url)
{
    $bc = getMemcache('.breadcrumbs');
    $bc[] = array('name' => $name, 'url' => $url);
    mcache_set('.breadcrumbs', $bc);
}


// Since 1.5.1: More process for template {$args}
function proc_tpl()
{
    $vars = array();
    $extr_args = func_get_args();

    $args = array();
    $tpl = array_shift($extr_args);

    // Parse input arguments
    foreach ($extr_args as $A) {
        if (is_array($A)) {
            foreach ($A as $i => $v) {
                $args[$i] = $v;
            }
        } else {
            list($i, $v) = explode('=', $A, 2);
            $args[$i] = $v;
        }
    }

    // predefined arguments
    $args['PHP_SELF'] = PHP_SELF;

    // Globals are saved too
    foreach ($GLOBALS as $gi => $gv) {
        if (in_array($gi, array('session', '_CN_SESS_CACHE', '_HOOKS', 'HTML_SPECIAL_CHARS', '_SESS', 'GLOBALS', '_ENV', '_REQUEST', '_SERVER', '_FILES', '_COOKIE', '_POST', '_GET'))) {
            continue;
        }

        if (!isset($args[$gi])) {
            $args[$gi] = $gv;
        }
    }

    // reading template
    $d = read_tpl($tpl);

    /*
    * Catch Foreach Cycles. Usage:
    *
    * {foreach from=variable_name}
    *     {$variable_name.} -- display first level (array)
    *     {$variable_name.name} -- display sublevel (struct array->array)
    * {/foreach}
    *
    */

    if (preg_match_all('~{foreach from\=([^}]+)}(.*?){/foreach}~is', $d, $rep, PREG_SET_ORDER)) {
        foreach ($rep as $v) {
            $rpl = false;
            if (is_array($args[$v[1]])) {
                foreach ($args[$v[1]] as $x) {
                    $bulk = $v[2];

                    // String simply replaces {$FromValue.}, Array -> {$FromValue.Precise}
                    if (is_array($x)) {
                        foreach ($x as $ik => $iv) {
                            $bulk = str_replace('{$' . $v[1] . ".$ik}", $iv, $bulk);
                        }
                    } else {
                        $bulk = str_replace('{$' . $v[1] . ".}", $x, $bulk);
                    }

                    $rpl .= $bulk;
                }
            }

            $d = str_replace($v[0], $rpl, $d);
        }
    }

    /*
     * Process template variables. Syntax:
     *
     * {$variable}
     * {$variable|function} -- apply function to variable
     * {$variable|function:param2:param3...} -- more static args
     * {$variable|function:param2:...|function2:param2} == chain 2nd function
     * {"text variable"|func"} = func('text variable')
     *
     */

    if (preg_match_all('/\{(["$])([^\}]+)\}/i', $d, $c, PREG_SET_ORDER)) {
        foreach ($c as $ct) // iterate each var-tpl
        {
            $ctp = explode('|', $ct[2], 2); // extract func + modifiers
            $av = isset($ctp[0]) ? $ctp[0] : '';
            $modify = isset($ctp[1]) ? $ctp[1] : '';

            $var = $args[$av];
            $mods = explode('|', $modify);

            // apply modifier [+params]
            foreach ($mods as $func) {
                if ($func) {
                    $varx = $func = explode(':', $func);

                    // it's variable or string
                    $varx[0] = ($ct[1] == '$') ? $var : substr($av, 0, -1);

                    // process the variable
                    if (function_exists($func[0])) {
                        $var = call_user_func_array($func[0], $varx);
                    }
                }
            }
            // save
            $vars[$ct[0]] = $var;
        }
    }

    // Apply all parameters
    $d = str_replace(array_keys($vars), array_values($vars), $d);

    /*
     * Catch {if} constructions. Usage
     *
     * {if $var1} ... {/if}
     * {if !$var1} ... {/if}
     *
     */

    if (preg_match_all('~{if\s+(.*?)}(.*?){/if}~is', $d, $rep, PREG_SET_ORDER)) {
        foreach ($rep as $vs) {
            $var = 0;
            $vs[1] = trim($vs[1]);
            if ($vs[1][0] == '$') $var = $args[substr($vs[1], 1)];
            elseif ($vs[1][1] == '$') $var = $args[substr($vs[1], 2)];

            // If boolean logic OK, replace
            if ($vs[1][0] == '$' && $var) $d = str_replace($vs[0], $vs[2], $d);
            elseif ($vs[1][0] == '!' && empty($var)) $d = str_replace($vs[0], $vs[2], $d);
            else $d = str_replace($vs[0], false, $d);
        }
    }

    // override process template (filter)
    list($d) = hook('func_proc_tpl', array($d, $tpl, $args));

    // truncate unused
    $d = preg_replace('~{\$[^}]+}+~s', '', $d);

    // code obfuscation
    if (preg_match_all('/<jstidy>(.*?)<\/jstidy>/is', $d, $jt, PREG_SET_ORDER)) {
        foreach ($jt as $jtv) {
            $jsc = preg_replace('/^\s*\/\/.*$/im', '', $jtv[1]); // remove comment
            $jsc = preg_replace("/\s{2,}/is", ' ', str_replace("\n", ' ', $jsc));
            $d = str_replace($jtv[0], $jsc, $d);
        }
    }

    // replace all
    return (hook('return_proc_tpl', $d));
}


// Since 2.0: Language codes initialize
function cn_lang_init()
{
    $lang = getOption('cn_language');
    if (!$lang) {
        $lang = 'en';
    }

    $st = array();
    $ln = file(SERVDIR . '/core/lang/' . $lang . '.txt');
    foreach ($ln as $vi) {
        list($S532, $RS) = explode(': ', trim($vi), 2);
        $st[$S532] = $RS;
    }

    mcache_set('#i18n', $st);
}

// ----------------------------------------------------


// Since 2.0: Execute PHP-template
// 1st argument - template name, other - variables ==> mo file
function exec_tpl()
{
    $args = func_get_args();
    $tpl = preg_replace('/[^a-z0-9_\/]/i', '', array_shift($args));

    $open = SKIN . '/' . ($tpl ? $tpl : 'default') . '.php';

    foreach ($args as $arg) {
        if (is_array($arg)) {
            foreach ($arg as $k0 => $v) {
                $k = "__$k0";
                $$k = $v;
            }
        } else {
            list($k, $v) = explode('=', $arg, 2);

            // <-- make local variable
            $k = "__$k";
            $$k = $v;
        }
    }

    if (file_exists($open)) {
        ob_start();
        include $open;
        $echo = ob_get_clean();
        return $echo;
    }

    return '';
}


// Since 1.5.0: Add hook to system
function add_hook($hook, $func)
{
    global $_HOOKS;

    $prior = 1;
    if ($hook[0] == '+') $hook = substr($hook, 1);
    if ($hook[0] == '-') {
        $prior = 0;
        $hook = substr($hook, 1);
    }

    if (!isset($_HOOKS[$hook])) $_HOOKS[$hook] = array();

    // priority (+/-)
    if ($prior) array_unshift($_HOOKS[$hook], $func); else $_HOOKS[$hook][] = $func;
}

// --------------------------------------------------------------------

// Since 2.0: Read serialized array from php-safe file (or create file)
function cn_touch_get($target)
{
    $fn = cn_touch($target, TRUE);
    $fc = file($fn);
    unset($fc[0]);

    $fc = join('', $fc);

    if (!$fc) {
        $fc = array();
    } else {
        $data = unserialize(base64_decode($fc));
        if ($data === FALSE) {
            $fc = unserialize($fc);
        } else {
            $fc = $data;
        }
    }

    return $fc;
}


// Since 2.0: Create file
function cn_touch($fn, $php_safe = FALSE)
{
    if (!file_exists($fn)) {
        $w = fopen($fn, 'w+');

        if ($php_safe) {
            fwrite($w, "<?php die('Direct call - access denied'); ?>\n");
        }
        fclose($w);
    }

    return $fn;
}


// Since 2.0: Translate phrase to code
function hi18n($ft)
{
    $sph = '';

    $ex = separateString($ft, ' ');
    foreach ($ex as $w) {
        $sx = soundex($w);
        if ($sx[0] === '0') continue;
        $sph .= $sx;
    }

    // long phrases
    return substr($sph, 0, 32);
}

// Since 2.0: Check if first request
function confirm_first()
{
    return isset($_POST['__my_confirm']) ? 0 : 1;
}

// Since 2.0: Users online
function cn_online_counter()
{
    if ($expire = getOption('client_online')) {
        $online = cn_touch_get(cn_path_construct(SERVDIR, 'cdata') . 'online.php');

        $ct = time();
        $uniq = array();
        $online[] = $ct . '|' . CLIENT_IP;

        foreach ($online as $id => $v) {
            print "F_ core 2301 so online: " . $id . "<br>";
            print "so online: " . $v . "<br>";

            if ($id == '%') {
                continue;
            }

            list($t, $ip) = explode('|', $v);
            if ($t < $ct - $expire) {
                unset($online[$id]);
            } else {
                $uniq[$ip]++;
            }
        }

        $online['%'] = $uniq;

        cn_fsave(cn_path_construct(SERVDIR, 'cdata') . 'online.php', $online);
    }
}

// Since 2.0: Save serialized array
function cn_fsave($dest, $data = array())
{
    $fn = $dest;
    $bk = $fn . '-' . mt_rand() . '.bak';

    $w = fopen($bk, 'w+') or die("Can't save data at [$bk]");
    fwrite($w, "<?php die('Direct call - access denied'); ?>\n");
    fwrite($w, base64_encode(serialize($data)));
    fclose($w);

    return rename($bk, $fn);
}


function cn_snippet_ckeditor($ids = '')
{
    // pre-init
    $CKSmiles = $CKBar = array();
    for ($i = 1; $i <= 8; $i++) {
        $ck_bar = getOption("ck_ln{$i}"); // lay 8 row in config
        if ($ck_bar) $CKBar[] = '["' . join('","', explode(',', cn_htmlspecialchars($ck_bar))) . '"]';
    }

    $smiles = explode(',', getOption('smilies'));
    foreach ($smiles as $smile) $CKSmiles[] = "'$smile.gif'";

    $CKSmiles = join(', ', $CKSmiles);
    $CKBar = join(', ', $CKBar);
    $Cklang = getOption('cklang');
    if (empty($Cklang)) $Cklang = 'en';

    // show
    echo '<script src="' . getOption('http_script_dir') . '/core/ckeditor/ckeditor.js"></script>';
    echo '<script type="text/javascript">' . "\n";
    echo "(function() { var settings = {" . "\n";
    echo "skin: 'moono', width: 'auto', height: 350, customConfig: '', language: '$Cklang', entities_latin: false, entities_greek: false, \n";
    echo "toolbar: [ " . hook('settings/CKEDITOR_customize', $CKBar) . " ], \n";

    $add_opt = array();
    $compound = array();
    /*
    //-----------------------------------------
    filebrowserBrowseUrl : 'ckeditor/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl : 'ckeditor/ckfinder/ckfinder.html?type=Images',
    filebrowserFlashBrowseUrl : 'ckeditor/ckfinder/ckfinder.html?type=Flash',
    filebrowserUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    //-----------------------------------------
    */
    $add_opt['filebrowserBrowseUrl'] = PHP_SELF . '?mod=media&opt=inline'; //str server
    $add_opt['filebrowserImageBrowseUrl'] = PHP_SELF . '?mod=media&opt=inline'; //str

    //$add_opt['filebrowserFlashBrowseUrl'] = PHP_SELF.'?mod=media&opt=inline';
    $add_opt['filebrowserUploadUrl'] = PHP_SELF . '?mod=media&opt=media&upload';
    //$add_opt['filebrowserImageUploadUrl'] = PHP_SELF.'?mod=media&opt=inline';
    $add_opt['filebrowserFlashUploadUrl'] = PHP_SELF . '?mod=media&opt=media&upload';

    $add_opt = hook('settings/CKEDITOR_filemanager', $add_opt);
    foreach ($add_opt as $I => $V) $compound[] = "$I: \"$V\"";

    // Insert updated FileBrowser
    echo join(', ', $compound) . '};' . "\n";

    // Smilies
    echo 'CKEDITOR.config.smiley_path = "' . getOption('http_script_dir') . '/skins/emoticons/"; ' . "\n";
    echo 'CKEDITOR.config.smiley_images = [ ' . hook('settings/CKEDITOR_emoticons', $CKSmiles) . ' ];' . "\n";
    echo 'CKEDITOR.config.smiley_descriptions = [];' . "\n";
    echo "CKEDITOR.config.allowedContent = true;";

    $ids = separateString($ids);
    foreach ($ids as $id) {
        echo "CKEDITOR.replace( '" . trim($id) . "', " . hook('settings/CKEDITOR_SetsName', 'settings') . " );" . "\n";
    }

    echo hook('settings/CKEDITOR_Settings');

    echo '})(); </script>';
}


// Since 1.5.2: Make HTML code for postponed date
function make_postponed_date($gstamp = 0)
{
    $_dateD = $_dateM = $_dateY = false;

    // Use current timestamp if no present
    if ($gstamp == 0) {
        $gstamp = ctime();
    }

    $day = date('j', $gstamp);
    $month = date('n', $gstamp);
    $year = date('Y', $gstamp);
    $ml = explode(',', getOption('mon_list'));

    for ($i = 1; $i < 32; $i++) {
        if ($day == $i) {
            $_dateD .= "<option selected value=$i>$i</option>";
        } else {
            $_dateD .= "<option value=$i>$i</option>";
        }
    }

    for ($i = 1; $i < 13; $i++) {
        $timestamp = mktime(0, 0, 0, $i, 1, 2003);
        $curr_mont = date('n', $timestamp) - 1;

        if ($ml && isset($ml[$curr_mont])) {
            $month_name = $ml[$curr_mont];
        } else {
            $month_name = date("M", $timestamp);
        }

        // ---
        if ($month == $i) {
            $_dateM .= "<option selected value=$i>" . $month_name . "</option>";
        } else {
            $_dateM .= "<option value=$i>" . $month_name . "</option>";
        }
    }

    for ($i = 2003; $i < (date('Y') + 8); $i++) {
        if ($year == $i) {
            $_dateY .= "<option selected value=$i>$i</option>";
        } else {
            $_dateY .= "<option value=$i>$i</option>";
        }
    }

    return array($_dateD, $_dateM, $_dateY, date('H', $gstamp), date('i', $gstamp), date('s', $gstamp));
}


// Since 2.0: File users.php not exists, call installation script
function cn_require_install()
{
    global $_SESS, $db;

    if (defined('AREA') && AREA == 'ADMIN') {
        $_SESSION = array();
        include SERVDIR . '/skins/default.skin.php';

        // Submit
        if (request_type('POST')) {
            $username = REQ('username', 'POST');
            $pass1 = REQ('password1', 'POST');
            $pass2 = REQ('password2', 'POST');
            $email = REQ('email', 'POST');

            // Check Username
            if (!$username) {
                cn_throw_message('Enter username', 'e');
            } elseif (strlen($username) < 2) {
                cn_throw_message('Too short username (must be 2 char min)', 'e');
            }

            // Check Password
            if (!$pass1) {
                cn_throw_message('Enter password', 'e');
            } elseif (strlen($pass1) < 4) {
                cn_throw_message('Too short password (must be 4 char min)', 'e');
            }

            // Check email
            if (!check_email($email)) {
                cn_throw_message('Invalid email', 'e');
            }

            if ($pass1 !== $pass2) {
                cn_throw_message("Confirm don't match", 'e');
            }
            // All OK
            if (cn_get_message('e', 'c') == 0) {
                // Add new user
                $Username = stripslashes($username);
                $Username = mysqli_real_escape_string($db, $Username);

                $Email = stripslashes($email);
                $Email = mysqli_real_escape_string($db, $Email);

                $pass = stripslashes($pass1);
                $pass = mysqli_real_escape_string($db, $pass);


                $addsql = "INSERT INTO `admins`(`id`, `username`, `password`, `email`, `nick`, `e-hide`, `acl` , `avatar`, `ban`, `numlogin`, `lastdate`, `more`) VALUES('"
                    . time() //$_POST['username']
                    . "', '" . $Username //$_POST['username']
                    . "', '" . md5($pass) //$_POST['password1']
                    . "', '" . $Email //$_POST['email']
                    . "', '" . '' //nick
                    . "', '" . 'off' //e-hide
                    . "', '" . 1 //acl
                    . "', '" . '' //$_POST['avatar']
                    . "', '" . 0 //ban
                    . "', '" . 0 //numlogin
                    . "', '" . "now()" //lastdate
                    . "', '');"; //lastdate

                echo "addduse: $addsql <br>";
                //exit();
                $db->query($addsql);

                //db_user_add($username, ACL_LEVEL_ADMIN);
                //db_user_update($username, "email=$email", "pass=" . SHA256_hash($pass1));

                // Authorize user
                $_SESSION['user'] = $username;

                // Detect self pathes
                //$SN = dirname($_SERVER['SCRIPT_NAME']);
                //$script_path = "http://".$_SERVER['SERVER_NAME'] . (($SN == '/') ? '' : $SN);

                //$reload = "http://".$_SERVER['SERVER_NAME'] . PHP_SELF; //custom

                setoption('http_script_dir', URL_PATH . '/admin');
                setoption('uploads_dir', cn_path_construct(ROOT, 'uploads'));
                setoption('uploads_ext', URL_PATH . '/uploads');
                //setoption('rw_layout',       SERVDIR .DIRECTORY_SEPARATOR. 'example.php');

                //print "p1 " . $sn. "<br>";
                //print "p2 " . $script_path. "<br>";
                //print "p3 " . $reload. "<br>";
                //exit();

                // Greets page
                //cn_relocation($reload); //custom
                cn_relocation("http://cutephp.com/thanks.php?referer=" . urlencode(base64_encode('http://' . $_SERVER['SERVER_NAME'] . PHP_SELF)));
            }
        }

        // --- quick check permissions ---
        $pc = array
        (
            'cdata' => FALSE,
            //'uploads'       => FALSE,
            //'cdata/news'    => FALSE,
            //'cdata/btree'   => FALSE,
            //'cdata/users'   => FALSE,
            //'cdata/plugins' => FALSE,
            //'cdata/backup'  => FALSE,
            'log' => FALSE,
        );

        $permission_ok = TRUE;
        foreach ($pc as $id => $_t) {
            $fndir = cn_path_construct(SERVDIR, $id);
            if (is_dir($fndir) && is_writable($fndir)) {
                $pc[$id] = TRUE;
            } else {
                $permission_ok = FALSE;
            }
        }

        cn_assign('pc, permission_ok', $pc, $permission_ok);
        echoheader('-@dashboard/style.css', 'Install CuteNews');
        echo exec_tpl('install');
        echofooter();
    }
}


// Since 2.0: Test User ACL. Test for groups [user may consists requested group]
function test($requested_acl, $requested_user = NULL, $is_self = FALSE)
{
    $user = getMember(); // get user menber session

    // Deny ANY access of unauthorized member
    if (!$user) return FALSE;

    $acl = $user['acl'];
    $grp = getOption('#grp');
    $ra = separateString($requested_acl);

    // This group not exists, deny all
    if (!isset($grp[$acl]))
        return FALSE;

    // Decode ACL, GRP string
    $gp = separateString($grp[$acl]['G']);
    $rc = separateString($grp[$acl]['A']);

    /*
    // ----------------------------------
    print "---------------------------------------------------------------<br>";
    foreach ($ra as $r)
    {
        print "F_cn_url_modify 2740 bien ra: $r <br>";
    }
    print "-----------------------------S _gp----------------------------------<br>";
    foreach ($gp as $r)
    {
        print "F_cn_url_modify 2755 bien gp: $r <br>";
    }
    print "-----------------------------S _rc----------------------------------<br>";
    foreach ($rc as $r)
    {
        print "F_cn_url_modify 2759 bien rc: $r <br>";
    }

    // ----------------------------------
    */
    // ra la bien truyen vao
    // If requested acl not match with real allowed, break
    foreach ($ra as $Ar) {
        if (!in_array($Ar, $rc)) return FALSE;
    }

    // Test group or self
    if ($requested_user) {
        // if self-check, check name requested user and current user
        if ($is_self && $requested_user['name'] !== $user['name'])
            return FALSE;

        // if group check, check: requested uses may be in current user group
        if (!$is_self) {
            if ($gp && !in_array($requested_user['acl'], $gp))
                return FALSE;
            elseif (!$gp)
                return FALSE;
        }
    }

    return TRUE;
}


// Since 2.0: Replace text with holders
function cn_replace_text()
{
    $args = func_get_args();
    $text = array_shift($args);
    $replace_holders = explode(',', array_shift($args));

    foreach ($replace_holders as $holder) {
        $text = str_replace(trim($holder), array_shift($args), $text);
    }

    return $text;
}


// Since 1.5.0: Send Mail
function cn_send_mail($to, $subject, $message, $alt_headers = NULL)
{
    if (!isset($to)) return FALSE;
    if (!$to) return FALSE;

    $tos = separateString($to);
    $from = 'Cutenews <cutenews@' . $_SERVER['SERVER_NAME'] . '>';

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/plain;\r\n";
    $headers .= 'From: ' . $from . "\r\n";
    $headers .= 'Reply-to: ' . $from . "\r\n";
    $headers .= 'Return-Path: ' . $from . "\r\n";
    $headers .= 'Message-ID: <' . md5(uniqid(time())) . '@' . $_SERVER['SERVER_NAME'] . ">\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    $headers .= "Date: " . date('r', time()) . "\r\n";

    if (!is_null($alt_headers)) $headers = $alt_headers;
    foreach ($tos as $v) if ($v) mail($v, $subject, $message, $headers);

    return true;
}


// Since 2.0: Get additional fields in groups
function cn_get_more_fields($defined = array())
{
    $morefields = array();
    $mgrp = getOption('#more_list');

    foreach ($mgrp as $name => $item) {
        if (!($grp = $item['grp'])) $grp = '#basic';
        if (!isset($morefields[$grp])) $morefields[$grp] = array();

        if (isset($defined[$name]))
            $item['#value'] = $defined[$name];

        $morefields[$grp][$name] = $item;
    }
    return array($morefields, $mgrp);
}


// Since 2.0: @bootstrap Make & load configuration file ==>
function cn_config_load()
{
    global $_CN_access;
    //checking permission for load config
    $conf_dir = cn_path_construct(SERVDIR, 'cdata');
    if (!is_dir($conf_dir) || !is_writable($conf_dir)) {
        return false;
    }

    $conf_path = cn_path_construct(SERVDIR, 'cdata') . 'conf.php';
    $cfg = cn_touch_get($conf_path);
    if (!$cfg) {
        if (defined('SHOW_NEWS')) {
            echo 'Sorry, but news not available by technical reason.';
            die();
        } else {
            //echo 'Need convert data - run migration_update_data.php';
            $cfg = cn_touch_get($conf_path, true);

        }
    }

    date_default_timezone_set("UTC"); //HKEY_LOCAL_MACHINE\\SYSTEM\CurrentControlSet\Control\TimeZoneInformation
    $shell = new COM("WScript.Shell") or die("Requires Windows Scripting Host");
    $time_bias = -($shell->RegRead("HKEY_LOCAL_MACHINE\\SYSTEM\\CurrentControlSet\\Control\\TimeZoneInformation\\ActiveTimeBias")) / 60;


    // make site section
    $cfg['%site'] = isset($cfg['%site']) ? $cfg['%site'] : array();

    $default_conf = array
    (
        'skin' => 'default',
        'frontend_encoding' => 'UTF-8',
        'useutf8' => 1,
        'utf8html' => 1,
        'wysiwyg' => 0,
        'news_title_max_long' => 100,
        'date_adjust' => $time_bias,
        'num_center_pagination' => 3,
        'smilies' => 'smile,wink,wassat,tongue,laughing,sad,angry,crying',
        'allow_registration' => 1,
        'registration_level' => 4,
        'config_login_ban' => 5,
        'ban_attempts' => 3,
        'allowed_extensions' => 'gif,jpg,png,bmp,jpe,jpeg',
        'reverse_active' => 0,
        'full_popup' => 0,
        'full_popup_string' => 'HEIGHT=400,WIDTH=650,resizable=yes,scrollbars=yes',
        'show_comments_with_full' => 1,
        'timestamp_active' => 'd M Y',
        'use_captcha' => 1,
        'reverse_c  omments' => 0,
        'flood_time' => 15,
        'comments_std_show' => 1,
        'comment_max_long' => 1500,
        'comments_per_page' => 5,
        'only_registered_comment' => 0,
        'allow_url_instead_mail' => 1,
        'comments_popup' => 0,
        'comments_popup_string' => 'HEIGHT=400,WIDTH=650,resizable=yes,scrollbars=yes',
        'show_full_with_comments' => 1,
        'timestamp_comment' => 'd M Y h:i a',
        'mon_list' => 'January,February,March,April,May,June,July,August,September,October,November,December',
        'week_list' => 'Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
        'active_news_def' => 20,
        'thumbnail_with_upload' => 0,
        'max_thumbnail_width' => 256,
        'auto_news_alias' => 0,
        // 'phpself_full'                  => '',
        // 'phpself_popup'                 => '',
        // 'phpself_paginate'              => '',

        // Notifications
        'notify_registration' => 0,
        'notify_comment' => 0,
        'notify_unapproved' => 0,
        'notify_archive' => 0,
        'notify_postponed' => 0,

        // Social buttons
        'i18n' => 'en_US',
        'gplus_width' => 350,
        'fb_comments' => 3,
        'fb_box_width' => 550,

        // CKEditor settings
        'ck_ln1' => "Source,Maximize,Scayt,PasteText,Undo,Redo,Find,Replace,-,SelectAll,RemoveFormat,NumberedList,BulletedList,Outdent,Indent",
        'ck_ln2' => "Image,Table,HorizontalRule,Smiley",
        'ck_ln3' => "Link,Unlink,Anchor",
        'ck_ln4' => "Format,FontSize,TextColor,BGColor",
        'ck_ln5' => "Bold,Italic,Underline,Strike,Blockquote",
        'ck_ln6' => "JustifyLeft,JustifyCenter,JustifyRight,JustifyBlock",
        'ck_ln7' => "",
        'ck_ln8' => "",

        // Rewrite
        'rw_htaccess' => '',
        'rw_prefix' => '/news/',
    );

    // Set default values
    foreach ($default_conf as $k => $v) {
        if (!isset($cfg['%site'][$k])) {
            $cfg['%site'][$k] = $v;
        }
    }

    // phan quyen

    // Set basic groups
    if (!isset($cfg['grp'])) {
        $cfg['grp'] = array();
    }

    // Make default groups
    $cgrp = file(cn_path_construct(SKIN, 'defaults') . 'groups.tpl');
    foreach ($cgrp as $G) {
        $G = trim($G);
        if ($G[0] === '#') {
            continue;
        }

        list($id, $name, $group, $access) = explode('|', $G);
        $id = intval($id);

        // Is empty row
        if (empty($cfg['grp'][$id])) {
            $cfg['grp'][$id] = array
            (
                'N' => $name,
                'G' => $group,
                '#' => TRUE,
                'A' => ($access === '*') ? $_CN_access['C'] . ',' . $_CN_access['N'] . ',' . $_CN_access['M'] : $access,
            );
        }
    }

    // Admin has ALL privilegies
    $cfg['grp'][1]['A'] = $_CN_access['C'] . ',' . $_CN_access['N'] . ',' . $_CN_access['M'];


    // Set config
    mcache_set('config', $cfg);

    // Make crypt-salt [after config sync]
    if (!getOption('#crypt_salt')) {
        $salt = SHA256_hash(mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand());
        setoption("#crypt_salt", $salt);
    }

    // SET PHAN QUYEN
    if (!getOption('#grp')) {
        setoption("#grp", $cfg['grp']);
    }

    // ---------------- S_custum by bqn -----
    // Detect self pathes
    //$SN = dirname($_SERVER['SCRIPT_NAME']);
    //$script_path = "http://".$_SERVER['SERVER_NAME'] . (($SN == '/') ? '' : $SN);

    //check http_script_dir
    $path_http_script_dir = URL_PATH . '/admin';
    if (getOption('http_script_dir') != $path_http_script_dir)
        setoption('http_script_dir', $path_http_script_dir);

    //check update_dir
    $path_update_dir = cn_path_construct(ROOT, 'uploads');
    if (getOption('uploads_dir') != $path_update_dir)
        setoption('uploads_dir', $path_update_dir);

    //check uploads_ext
    $path_uploads_ext = URL_PATH . '/uploads';
    if (getOption('uploads_ext') != $path_uploads_ext)
        setoption('uploads_ext', $path_uploads_ext);
    // ---------------- E_custum by bqn -----

    return TRUE;
}


// Since 2.0: Save whole config
function cn_config_save($cfg = null)
{
    if ($cfg === null) {
        $cfg = getMemcache('config');
    }

    $fn = cn_path_construct(SERVDIR, 'cdata') . 'conf.php';
    $dest = $fn . '-' . mt_rand() . '.bak';

    // save all config
    $fx = fopen($dest, 'w+');
    fwrite($fx, "<?php die(); ?>\n" . base64_encode(serialize($cfg)));
    fclose($fx);
    rename($dest, $fn); //bat len .....

    mcache_set('config', $cfg);
    return $cfg;
}


// Since 1.5.2: Directory scan
function scan_dir($dir, $cond = '')
{
    $files = array();
    if ($dh = opendir($dir)) {
        while (false !== ($filename = readdir($dh))) {
            if (!in_array($filename, array('.', '..')) && ($cond == '' || $cond && preg_match("/$cond/i", $filename))) {
                $files[] = $filename;
            }
        }
    }
    return $files;
}

// Since 2.0: Check server request type
function request_type($type = 'POST')
{
    return $_SERVER['REQUEST_METHOD'] === $type ? TRUE : FALSE;
}

// Since 2.0: Load & decode rewrite rules
function cn_rewrite_load()
{
    global $PHP_SELF;

    // rewrite module detected
    if (isset($_GET['cn_rewrite_url']) && ($cn_rewrite_url = $_GET['cn_rewrite_url'])) {
        $layout = getOption('rw_layout');

        // Make compatible
        if ($cn_rewrite_url[0] !== '/') {
            $cn_rewrite_url = "/$cn_rewrite_url";
        }

        // Try get target php file
        $request_uri = $_SERVER['REQUEST_URI'];
        $basedir = dirname(getOption('rw_htaccess')) . DIRECTORY_SEPARATOR;

        // Rule matched, test pathes
        if (preg_match('/^(\/[^\?]+)/', $request_uri, $c)) {
            $tf = explode('/', $c[1]);

            // Decremental search
            for ($i = count($tf); $i > 0; $i--) {
                $sp = array_slice($tf, 0, $i);
                $ch = $basedir . join(DIRECTORY_SEPARATOR, $sp) . '.php';

                // PHP-File is Founded!
                if (file_exists($ch)) {
                    $layout = $ch;
                }
            }
        }

        // Decode request URI
        if (preg_match('/\?/', $request_uri)) {
            $RI = preg_replace('/^.*\?/', '', $request_uri);
            $AR = explode('&', $RI);
            foreach ($AR as $v) {
                list($l, $r) = explode('=', $v, 2);
                $_GET[$l] = $r;
            }
        }

        $post_fix = getOption('rw_use_shorten') ? '$' : '\.html';

        // --------
        if (preg_match('/\/tag\-(.*)\/([0-9]+)' . $post_fix . '/i', $cn_rewrite_url, $c)) {
            $_GET['tag'] = $c[1];
            $_GET['start_from'] = $c[2];
        } elseif (preg_match('/\/rss-([0-9]+)' . $post_fix . '/i', $cn_rewrite_url, $c)) {
            $_GET['number'] = $c[1];
            $layout = SERVDIR . 'rss.php';
        } elseif (preg_match('/\/print\-([0-9a-z_\-\.]+)' . $post_fix . '/i', $cn_rewrite_url, $c)) {
            $_GET['id'] = $c[1];
            $layout = SERVDIR . 'print.php';
        } elseif (preg_match('/\/comments\-([0-9a-z_\-\.]+)-(\d+)' . $post_fix . '/i', $cn_rewrite_url, $c)) {
            $_GET['id'] = $c[1];
            $_GET['start_from'] = $c[2];
            $_GET['subaction'] = 'showcomments';
        } elseif (preg_match('/\/comments\-([0-9a-z_\-\.]+)' . $post_fix . '/i', $cn_rewrite_url, $c)) {
            $_GET['id'] = $c[1];
            $_GET['subaction'] = 'showcomments';
        } elseif (preg_match('/\/list\-(\d+)' . $post_fix . '/i', $cn_rewrite_url, $c)) {
            $_GET['start_from'] = $c[1];
        } elseif (preg_match('/\/archive\-(\d+)-(\d+)' . $post_fix . '/i', $cn_rewrite_url, $c)) {
            $_GET['archive'] = $c[1];
            $_GET['start_from'] = $c[2];
        } elseif (preg_match('/\/archive\-(\d+)' . $post_fix . '/i', $cn_rewrite_url, $c)) {
            $_GET['archive'] = $c[1];
        } elseif (preg_match('/\/tag\-(.*)' . $post_fix . '/i', $cn_rewrite_url, $c)) {
            $_GET['tag'] = $c[1];
        } elseif (preg_match('/\/([0-9a-z_\-\.]+)' . $post_fix . '/i', $cn_rewrite_url, $c)) {
            $_GET['id'] = $c[1];
        } else {
            header("HTTP/1.0 404 Not Found");
            die("404 Not Found");
        }

        define('CN_REWRITE', $layout);
        define('PHP_SELF', pathinfo(str_replace($basedir, '', $layout), PATHINFO_BASENAME));
    } else {
        define('PHP_SELF', $_SERVER["SCRIPT_NAME"]);
        define('CN_REWRITE', FALSE);
    }

    // const PHPSELF = SCRIPT_NAME ($PHP_SELF user may replace)
    if (!isset($PHP_SELF) && empty($PHP_SELF)) {
        $PHP_SELF = PHP_SELF;
    }
}
