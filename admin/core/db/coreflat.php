<?php if (!defined('BQN_MU')) {
    die('Access restricted');
}

// ACL: basic access control level
define('ACL_LEVEL_ADMIN', 1);
define('ACL_LEVEL_EDITOR', 2);
define('ACL_LEVEL_JOURNALIST', 3);
define('ACL_LEVEL_COMMENTER', 4);
define('ACL_LEVEL_BANNED', 5);

function db_installed_check()
{
    global $dbSa;

    if (!isset($dbSa)) {
        die ('Không có kết nối đến Server!');
    }

    $result = $dbSa->Execute("SELECT * FROM Admin WHERE [AdLevel]=1");
//    $result = $dbSa->Execute("SELECT COUNT(*) as numCount FROM Admin");

//    if ($result) {
    if ($result->RecordCount()) {
        return true;
    } else {
        cn_require_install();
    }
}

// Since 2.0: Get user by any indexed field (id, ...) [x2 slowed, than by_name]
function db_user_by($eid, $match = 'id')
{
    global $dbSa;

    //name
    if ($match == 'user') {
        $username = strip_tags($eid);
        $username = mysqli_real_escape_string($dbSa, $username);
        $mysqlname = "SELECT * FROM admins WHERE username = '" . $username . "';";
        $result = $dbSa->query($mysqlname);
        if ($num_rows = $result->num_rows >= 1) {
            while ($row = mysqli_fetch_array($dbSa, $result)) {
                $unique_array[] = array('name' => $row['username'], 'email' => $row['email'], 'acl' => $row['acl']);
            }
            /*$result_rows = $result->fetch_assoc();
                                
            $acc = Array(
                'id' => $result_rows['id'],
                'name' => $result_rows['username'],
                'pass' => $result_rows['password'],
                'email' => $result_rows['email'],
                'avatar' => $result_rows['avatar'],
                'date' => date('Y-m-d H:i:s', $result_rows['id']),
                'ban' => $result_rows['ban'],
                'numlogin' => $result_rows['numlogin'],
                'lastdate' => $result_rows['lastdate'],
            );*/
        } else
            return NULL;

        return $unique_array['name'];
    }
    //email
    if ($match == 'email') {
        $email = strip_tags($eid);
        $email = mysqli_real_escape_string($dbSa, $email);
        $mysqlname = "SELECT username,email FROM admins WHERE email = '" . $email . "';";
        $result = $dbSa->query($mysqlname);
        if ($num_rows = $result->num_rows >= 1) {
            //$result_rows = $result->fetch_assoc();

            while ($row = mysqli_fetch_array($dbSa, $result)) {
                $unique_array[] = array('name' => $row['username'], 'email' => $row['email'], 'acl' => $row['acl']);
            }
            /*
            }
            $acc = Array(
                'id' => $result_rows['id'],
                'name' => $result_rows['username'],
                'pass' => $result_rows['password'],
                'email' => $result_rows['email'],
                'avatar' => $result_rows['avatar'],
                'date' => date('Y-m-d H:i:s', $result_rows['id']),
                'ban' => $result_rows['ban'],
                'numlogin' => $result_rows['numlogin'],
                'lastdate' => $result_rows['lastdate'],
            );*/
        } else
            return NULL;

        return $unique_array['email'];
    }

    //$pdata = array();


    return NULL;
    /*
    $cu = cn_touch_get(SERVDIR. path_construct('cdata','users',substr(md5($eid), 0, 2).'.php'));

    // Translate id -> name [reference]
    if (!isset($cu[$match][$eid]))
    {
        return NULL;
    }
    else
    {
        return db_user_by_name($cu[$match][$eid]);
    }
    */
}

// Since 2.0: Get user by id
function db_user_by_name($name)//, $index = FALSE)
{

    global $dbSa;

    $username = strip_tags($name);
    $username = mysqli_real_escape_string($dbSa, $username);

    $pdata = array();
    $mysqlname = "SELECT * FROM admins WHERE username = '" . $username . "' LIMIT 0,1;"; //AND password = '" . $pawd . "' LIMIT 0,1;";

    $result = $dbSa->query($mysqlname);
    if ($num_rows = $result->num_rows != 0) {
        //$pdata = Array(
        $result_rows = $result->fetch_assoc();

        $pdata = Array(
            'id' => $result_rows['id'],
            'name' => $result_rows['username'],
            'pass' => $result_rows['password'],
            'email' => $result_rows['email'],
            'nick' => $result_rows['nick'],
            'e-hide' => $result_rows['e-hide'],
            'acl' => $result_rows['acl'],
            'avatar' => $result_rows['avatar'],
            'date' => date('Y-m-d H:i:s', $result_rows['id']),
            'ban' => $result_rows['ban'],
            'numlogin' => $result_rows['numlogin'],
            'lastdate' => $result_rows['lastdate'],
            'more' => $result_rows['more'],
        );

        //);
    } else
        return NULL;

    /*
    if (!isset($pdata['acc'][$name]))
    {
        return NULL;
    }
    
    $putdata = $cu['acc'][$name];    
    
    foreach($putdata as $e =>$g)
        print "F_config 223 Sai $e => $g <br>";
    //exit();
    */
    //return $putdata;
    return $pdata;
    /*
    $uex = array();

    // Get from php-serialized array
    $cu = cn_touch_get(SERVDIR. path_construct('cdata','users',substr(md5($name), 0, 2).'.php'));

    // Check at index
    if ($index)
    {
        $rd = fopen(cn_touch(SERVDIR . path_construct('cdata', 'users', 'users.txt')), 'r');
        while ($a = fgets($rd))
        {
            list($uid) = explode(':', 2);
            $uex[base_convert($uid, 36, 10)] = TRUE;
        }
        fclose($rd);

        // user exists, but not in index
        if (isset($cu['name'][$name]) && !isset($uex[ $cu['name'][$name]['id'] ]))
        {
            return NULL;
        }
    }

    if (!isset($cu['name'][$name]))
    {
        return NULL;
    }

    // Decode serialized more data
    $pdata = $cu['name'][$name];    
    if (isset($pdata['more']) && $pdata['more'])
    {
        $pdata['more'] = unserialize(base64_decode($pdata['more']));
    }
    else
    {
        $pdata['more'] = array();
    }

    return $pdata;
    */
}

// Since 2.0.3: Lookup users in index
// 1) Fetch user list
// 2) Test any user by name
function user_lookup($name)
{
    global $dbSa;

    $username = strip_tags($name);
    $username = mysqli_real_escape_string($dbSa, $username);

    //$options_list = array();
    $mysqlname = "SELECT id, username FROM admins WHERE username = '" . $username . "' LIMIT 0,1;"; //AND password = '" . $pawd . "' LIMIT 0,1;";

    echo "MYSQL ad_user_by_name 110 . $mysqlname <br>";
    $result = $dbSa->query($mysqlname);
    if ($num_rows = $result->num_rows != 0) {

        $result_rows = $result->fetch_assoc();

        $options_list = Array(
            'id' => $result_rows['id'],
            'name' => $result_rows['username'],
            'mail' => $result_rows['email'],
        );


        return $options_list;

    } else
        return NULL;

    /*
    $users = db_user_list();

    foreach ($users as $uid => $acl)
    {
        $user = db_user_by($uid);
        if (isset($user['name']) && $user['name'] == $username)
        {
            return $user;
        }
    }

    return null;
    */
}

/*


// Since 2.0: Fetch index
function db_user_list()
{
	global $dbSa;
	
	//$username = strip_tags($name);
	//$username = mysqli_real_escape_string($dbSa,$username);
	
	$options_list = array();
	$mysqlname = "SELECT id, username FROM admins;"// WHERE username = '" . $username . "' LIMIT 0,1;"; //AND password = '" . $pawd . "' LIMIT 0,1;";
	
	echo "MYSQL ad_user_by_name 110 . $mysqlname <br>";
	$result = $dbSa->query($mysqlname);
	if($num_rows = $result->num_rows != 0){
		$options_list = Array(
		while($result_rows = $result->fetch_assoc()){
		
			"'$result_rows['username']'" => Array(
				'id' => $result_rows['id'],
				'name' => $result_rows['username'],
			),
		}
	);
	}
	
	return $options_list;
	
	/*
    $fn = cn_touch(SERVDIR. path_construct('cdata','users.txt'));

    $ls = array();
    $fc = file($fn);
    foreach ($fc as $v)
    {
        list($id, $acl) = explode(':', $v, 2);
        $ls[base_convert($id, 36, 10)] = array('acl' => $acl);
    }

    return $ls;
	
}
//-----------------------------------------------------------------------
Array
(
    [name] => Array
        (
            [bqngoc119] => Array
                (
                    [id] => 1445183723
                    [name] => bqngoc119
                    [acl] => 1
                    [email] => bqngo@sddf.egf
                    [pass] => 96768216545c539b71475cb58bef9a801decb2e94428695a98897a49f9d536c4
                    [cnt] => 17
                    [ban] => 0
                    [lts] => 1446232970
                    [more] => YToyOntzOjQ6InNpdGUiO3M6MjI6ImZhY2Vib29rLmNvbS9icW5nb2MxMTkiO3M6NToiYWJvdXQiO3M6NjA6Ij46Ojo6Ojo6Ojo6Ojo6Ojo6Ojo6Ojo6Ojo6Ojo6Ojo6Ojo6Ojo6Ojo6Ojo6Ojo6Ojo6Ojo6Ojo6Ojo6PCI7fQ==
                    [avatar] => avatar_bqngoc119_smallimage.jpg
                    [nick] => bqn
                    [e-hide] => on
                )

        )

)

//-----------------------------------------------------------------------
*/