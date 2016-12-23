<?php if (!defined('BQN_MU')) { die('Access restricted'); }

// ACL: basic access control level
define('ACL_LEVEL_ADMIN', 1);
define('ACL_LEVEL_EDITOR', 2);
define('ACL_LEVEL_JOURNALIST', 3);
define('ACL_LEVEL_COMMENTER', 4);
define('ACL_LEVEL_BANNED', 5);

/**
 * @return bool
 */
function db_installed_check()
{
    global $db_new;

    if (!isset($db_new)) {
        die ('Không có kết nối đến Server!');
    }

    $result = $db_new->Execute("SELECT * FROM Account_Info WHERE [AdLevel]=1");
    if ($result->RecordCount()) {
        return true;
    } else {
        cn_require_install();
    }
}

// bo -- chua dung ???????????
function view_info_char($account)
{
    global $db_new;
    $str_ = '';
    if (!empty($account)) {
        $result = $db_new->Execute("SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'");
        if ($result === false) return 'Error';
        if ($result->numrows() != 0) {
            $row = $result->fetchrow();
            $coun_row = count($row);
            for ($i = 0; $i < $coun_row; $i++) {
                if (!empty($row[$i])) {
                    switch (getoption('server_type')) {
                        case "scf":
                            $query_info_char = $db_new->Execute("SELECT Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,SCFPCPoints FROM Character WHERE Name='$row[$i]'");
                            if ($query_info_char === false) continue;
                            break;
                        case "ori":
                            $query_info_char = $db_new->Execute("SELECT Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,PCPoints FROM Character WHERE Name='$row[$i]'");
                            if ($query_info_char === false) continue;
                            break;
                        default:
                            $query_info_char = $db_new->Execute("SELECT Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,SCFPCPoints FROM Character WHERE Name='$row[$i]'");
                            if ($query_info_char === false) continue;
                            break;
                    }
                    if ($query_info_char->numrows() != 0) {
                        $info_char = $query_info_char->fetchrow();
                        $class[] = $info_char['Class'];
                        $level[] = $info_char['cLevel'];
                        $str[] = $info_char['Strength'];
                        $dex[] = $info_char['Dexterity'];
                        $vit[] = $info_char['Vitality'];
                        $ene[] = $info_char['Energy'];
                        $com[] = $info_char['Leadership'];
                        $reset[] = $info_char['Resets'];
                        $relife[] = $info_char['Relifes'];
                        $point[] = $info_char['LevelUpPoint'];
                        $point_dutru[] = $info_char['pointdutru'];
                        $uythac[] = $info_char['uythacoffline_stat'];
                        $point_uythac[] = $info_char['PointUyThac'];
                        $pcpoint[] = $info_char['SCFPCPoints'];
                    }

                    $str_ .= "$row[$i]|$class[$i]|$level[$i]|$str[$i]|$dex[$i]|$vit[$i]|$ene[$i]|$com[$i]|$reset[$i]|$relife[$i]|$point[0]|$point_dutru[0]|$uythac[0]|$point_uythac[0]|$pcpoint[0]||";
                }
            }
        }
    }
    return substr($str_, 0, -2);
}

function view_character($account)
{
    global $db_new;
    if (!empty($account)) {
        kiemtra_acc($account);

        $result = $db_new->Execute($myQuery = "SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'") or cn_writelog($myQuery, 'e');

        if ($result) {
            if ($result->numrows() != 0) {
                $row = $result->fetchrow();

                foreach ($row as $i => $vl) {
                    if (!empty($row[$i])) {
                        switch (getoption('server_type')) {
                            case "scf":
                                $query_info_char = $db_new->Execute("SELECT Name,Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,SCFPCPoints,AccountID,NoResetInDay,Money,Top50,Resets_Time,UyThac,Inventory AS image,PkLevel,PkCount,MapNumber,IsThuePoint,TimeThuePoint FROM Character WHERE Name='$vl'");
                                if ($query_info_char === false) continue;
                                break;
                            case "ori":
                                $query_info_char = $db_new->Execute("SELECT Name,Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,PCPoints,AccountID,NoResetInDay,Money,Top50,Resets_Time,UyThac,Inventory AS image,PkLevel,PkCount,MapNumber,IsThuePoint,TimeThuePoint FROM Character WHERE Name='$vl'");
                                if ($query_info_char === false) continue;
                                break;
                            default:
                                $query_info_char = $db_new->Execute("SELECT Name,Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,SCFPCPoints,AccountID,NoResetInDay,Money,Top50,Resets_Time,UyThac,Inventory AS image,PkLevel,PkCount,MapNumber,IsThuePoint,TimeThuePoint FROM Character WHERE Name='$vl'");
                                if ($query_info_char === false) continue;
                                break;
                        }

                        $info_char_[] = $query_info_char->fetchrow();
                    }
                }
            }
        }
    }

    return isset($info_char_) ? $info_char_ : array();
}

function view_bank($account)
{
    if (!empty($account)) {
        $_data = array();
        $result = do_select_character('MEMB_INFO', 'bank,vpoint,jewel_chao,jewel_cre,jewel_blue,gcoin,gcoin_km', "memb___id='$account'", '');

        if ($result)
            foreach ($result as $key => $var)
                $_data[] = Array('bank' => $var['bank'], 'vp' => $var['vpoint'], 'chaos' => $var['jewel_chao'], 'cre' => $var['jewel_cre'], 'blue' => $var['jewel_blue'], 'gc' => $var['gcoin'], 'gc_km' => $var['gcoin_km']);
    }

    return isset($_data) ? $_data : array();
}

function view_warehouse($account)
{
    global $db_new;
    $str_ = '';
    if (!empty($account)) {
        $warehouse_result_s = $db_new->Execute("SELECT Items,Money,pw,AccountID FROM warehouse WHERE AccountID = '$account'");
        if ($warehouse_result_s === false) return null;
        if ($warehouse_result_s->numrows() < 1) return null;
        $warehouse_result_1 = $warehouse_result_s->fetchrow();
        //$accountid_ = $warehouse_result_1[0];
        //$item_no = $item_no.$warehouse_result_1[0];
        $item_no = $warehouse_result_1[0];
        $item_no = bin2hex($item_no);
        $okj_1 = strlen($item_no);
        $item_no = strtoupper($item_no);
        $item_no = substr($item_no, 0, 3840);
        $accountid_ = $warehouse_result_1[3];
        $money = $warehouse_result_1[1];
        $password = $warehouse_result_1[2];

        $str_ = "$item_no||$money||$password||$accountid_";
    }
    return $str_;
}

function point_tax($acc = '')
{

    //Kiểm tra những nhân vật đã thuê Point và xử lý khi hết thời gian

    $result_ = do_select_character('Character', 'Name,TimeThuePoint,AccountID', "IsThuePoint=1 AND AccountID ='" . $acc . "'");
    foreach ($result_ as $k => $val) {
        if ($val[1] <= ctime()) {
            //exit();
            //Check Online
            $online_check = do_select_character('MEMB_STAT', '*', "memb___id='$val[2]' AND ConnectStat=1");
            if (0 < count($online_check)) {
                //Check Doi NV
                $doinv_check = do_select_character('AccountCharacter', '*', "Id='$val[2]' AND GameIDC='$val[0]'");
                if (count($doinv_check) < 1) {
                    //$query_update = "UPDATE Character SET Clevel=400,Resets=Resets-1,IsThuePoint=2,LevelUpPoint=0,pointdutru=0,Strength=26,Dexterity=26,Vitality=26,Energy=26,Life=110,MaxLife=110,Mana=60,MaxMana=60,Leadership=0 WHERE Name='$check_thuepoint[0]'";
                    //$run_update = $db_new->Execute($query_update);
                    do_update_character('Character', 'IsThuePoint=0', 'PointThue=0', "Name:'$val[0]'");
                }
            } else {
                do_update_character('Character', 'IsThuePoint=0', 'PointThue=0', "Name:'$val[0]'");
                //$query_update = "UPDATE Character SET Clevel=400,Resets=Resets-1,IsThuePoint=2,LevelUpPoint=0,pointdutru=0,Strength=26,Dexterity=26,Vitality=26,Energy=26,Life=110,MaxLife=110,Mana=60,MaxMana=60,Leadership=0 WHERE Name='$check_thuepoint[0]'";
                //$run_update = $db_new->Execute($query_update);
            }
        }
    }
    /*
    $result_check_thuepoint = $db_new->Execute("SELECT Name,TimeThuePoint,AccountID FROM Character Where IsThuePoint=1");
    while($check_thuepoint = $result_check_thuepoint->fetchrow()) {
        if ( $check_thuepoint[1] <= ctime() ) {
            //Check Online
            $sql_online_check = $db_new->Execute("SELECT * FROM MEMB_STAT WHERE memb___id='$check_thuepoint[2]' AND ConnectStat=1");
            if (0 < $online_check = $sql_online_check->numrows()) {
                //Check Doi NV
                $sql_doinv_check = $db_new->Execute("SELECT * FROM AccountCharacter WHERE Id='$check_thuepoint[2]' AND GameIDC='$check_thuepoint[0]'");
                if (1 > $doinv_check = $sql_doinv_check->numrows()) {
                    $query_update = "UPDATE Character SET Clevel=400,Resets=Resets-1,IsThuePoint=2,LevelUpPoint=0,pointdutru=0,Strength=26,Dexterity=26,Vitality=26,Energy=26,Life=110,MaxLife=110,Mana=60,MaxMana=60,Leadership=0 WHERE Name='$check_thuepoint[0]'";
                    $run_update = $db_new->Execute($query_update);
                }
            }
            else {
                $query_update = "UPDATE Character SET Clevel=400,Resets=Resets-1,IsThuePoint=2,LevelUpPoint=0,pointdutru=0,Strength=26,Dexterity=26,Vitality=26,Energy=26,Life=110,MaxLife=110,Mana=60,MaxMana=60,Leadership=0 WHERE Name='$check_thuepoint[0]'";
                $run_update = $db_new->Execute($query_update);
            }
        }
    }
/*
//$arr_deleonline = do_select_character('Character','UyThac','uythaconline_time','PointUyThac','UyThacOnline_Daily',"Name:'$sub'",'');
    //if(date("Y-M-d", $deleon_time) != date("Y-M-d", ctime())){ $UyThacOnline_Daily = 0;}
    global $db_new;
    $str_ = '';
    if(!empty($account)){
        if (getoption('type_acc') == 1) kiemtra_kituso($account);
        else kiemtra_kitudacbiet($account);

        kiemtra_kitudacbiet($password);

        kiemtra_pass($account,$password);

        kiemtra_acc($account);
        kiemtra_block_acc($account);
        kiemtra_ranking($account);
        kiemtra_GM($account);
        kiemtra_loggame($account);

        $result = $db_new->Execute("SELECT thehe FROM MEMB_INFO WHERE memb___id='$account'");
        if($result === false) return 'Error';
        $row = $result->fetchrow();

        $str_ = "OK||$gm||$ranking||$row[0]";
    }
    return $str_;
    */
}

function mssql_real_escape_string($s)
{
    if (get_magic_quotes_gpc()) $s = stripcslashes($s);
    $s = str_replace("'", "''", $s);
    return $s;
}

// Since 2.0: Get user by id
function db_user_by_name($name)
{
    if ($name) {
        $name = strtolower($name);
        $username = strip_tags($name);
        $username = mssql_real_escape_string($username);

        //$result_rows = do_select_character('MEMB_INFO','memb___id','memb__pwd','tel__numb','phon_numb','mail_addr','fpas_ques','fpas_answ','memb__pwd2','memb__pwdmd5','acl','ban_login','num_login','pass2',"memb___id:'$username'",'');
        $result_rows = do_select_character('MEMB_INFO', 'memb___id,memb__pwd,tel__numb,phon_numb,mail_addr,fpas_ques,fpas_answ,memb__pwd2,memb__pwdmd5,acl,ban_login,num_login,pass2', "memb___id='$username'");
        if ($result_rows) {
            foreach ($result_rows as $sd => $ds) {
                $pdata = Array(
                    'user_name' => $ds['memb___id'],
                    'pass_game' => $ds['memb__pwd'],
                    'tel_num' => $ds['tel__numb'],
                    'phon_num' => $ds['phon_numb'],
                    'email' => $ds['mail_addr'],
                    'question' => $ds['fpas_ques'],
                    'answer' => $ds['fpas_answ'],
                    'pass_verify' => $ds['memb__pwd2'],
                    'pass_web' => $ds['memb__pwdmd5'],
                    'acl' => $ds['acl'],
                    'ban_login' => $ds['ban_login'],
                    'num_login' => $ds['num_login'],
                    'pass2' => $ds['pass2']
                );
            }
        }
    }
    return isset($pdata) ? $pdata : array();
}

/**
 * retrun array mix
 */
function do_select_orther($orther = '')
{
    global $db_new;

    if ($orther) {
        $orther = trim($orther);
        $check = $db_new->Execute("$orther") or cn_writelog($orther, 'e');
        if ($check) {
            while ($row = $check->fetchrow()) {
                $rs_data[] = $row;
            }
        }
    } else return FALSE;
    return isset($rs_data) ? $rs_data : array();
}

/**
 * @param string $orther
 * @return bool
 */
function do_update_orther($orther = '')
{
    global $db_new;

    if ($orther) {
        $orther = trim($orther);
        $check = $db_new->Execute("$orther") or cn_writelog($orther, 'e');
        if ($check) return true;
    } else return FALSE;
}

//'table','abc, abc2, ...','a1=1 and ab = 2 or ad =12,...',' orther ',
function do_select_character($table, $col, $where = '', $orther = '')
{
    global $db_new;
    if (!$table) return FALSE;
    $table = trim($table);
    $_col = spsep($col);

    $str_col = $str_where = '';
    foreach ($_col as $var) {
        $var = trim($var);
        if ($var == '*') {
            $str_col = '*';
            break;
        } else {
            $str_col .= "$var,";
        }
    }
    if ($str_col[0] != '*') $str_col = substr($str_col, 0, -1);

    if ($where) {
        $where = trim($where);
        $str_where = "WHERE $where";
    } else $str_where = $where;

    if ($orther) $orther = trim($orther);

    if ($str_col && $table) {
        $check = $db_new->Execute("SELECT $str_col FROM $table $str_where $orther") or cn_writelog("SELECT $str_col FROM $table $str_where $orther", 'e');
        if ($check) {
            while ($row = $check->fetchrow()) {
                $rs_data[] = $row;
            }
        }
    }

    return isset($rs_data) ? $rs_data : array();
}

// sign table, mutile cont (abc,abc1... N OR *, abc2:abc3,... N, (ORDER ..... or null))
//1. table => SQL
//2: ... n => Col => select SQL 
//3. ... n => Col : val, col (>, <=, ...) val 	=> WHRER Contine
function do_select_character1()
{
    global $db_new;
    $gr_col = $gr_cont = '';
    $args = func_get_args();            //1.name, 2.email="user_email", 3.nick:"$user_nic", 4.pass:"2gs" OR //1.name, *, 3.nick:"$user_nic", 4.pass:"2gs"
    $user_table = array_shift($args);        // get table array frist
    $user_order = array_pop($args);        // get order array last

    if (!$user_table) //1. name //table update/
        return FALSE;

    foreach ($args as $v) {  //$v = [email=user_email] /// ???? and (hgghgh or hghhjjh)
        if (strpos($v, ':') !== false) {
            $df = str_replace(':', '=', $v);
            $gr_cont .= "$df AND ";
        } elseif (strpos($v, '>') !== false)
            $gr_cont .= "$v AND ";
        elseif (strpos($v, '>=') !== false)
            $gr_cont .= "$v AND ";
        elseif (strpos($v, '<>') !== false)
            $gr_cont .= "$v AND ";
        elseif (strpos($v, '<') !== false)
            $gr_cont .= "$v AND ";
        elseif (strpos($v, '<=') !== false)
            $gr_cont .= "$df AND ";
        elseif (strpos($v, '*') !== false)
            $gr_col = "*";
        else
            $gr_col .= "$v,";
    }
    //1. gr_cont co ... cut .. 	pop co .. where >> y
    //2. gr_cont co ... cut .. 	pop ko .. where >> y
    //3. gr_cont ko ...			pop co ..		>> y
    //4. gr_cont ko ...			pop ko ..		>> y

    if (!empty($gr_cont)) {
        //if(strlen($gr_cont) > 5)
        $gr_cont = substr($gr_cont, 0, -5);
        //$val_up_cont = substr($gr_cont,0, -5);
        if (!empty($user_order)) $val_up_cont = "WHERE " . $gr_cont . ' ' . $user_order;
        else $val_up_cont = "WHERE " . $gr_cont;
    } else {
        if (!empty($user_order)) $val_up_cont = $user_order;
        else $val_up_cont = '';
    }

    if (strpos($gr_col, '*') === false) { // sai
        if (strlen($gr_col) > 1)
            $val_up_col = substr($gr_col, 0, -1);
    } else
        $val_up_col = $gr_col;

    if ($val_up_col && $user_table) {
        $check = $db_new->Execute("SELECT $val_up_col FROM $user_table $val_up_cont") or cn_writelog("SELECT $val_up_col FROM $user_table $val_up_cont", 'e');
        if ($check)
            while ($row = $check->fetchrow()) {
                $rs_data[] = $row;
            }
    }
    return isset($rs_data) ? $rs_data : array();

    return null;
}

// sign table, mutile cont (abc=abc1,... N)
//1. table => SQL
//2: ... n => Col = val 	=> INSERT SQL 
function do_insert_character()
{
    global $db_new;
    $gr_col = $gr_cont = '';
    $cp_data = array();
    $args = func_get_args();
    $user_table = array_shift($args);        // get table array frist

    if (!$user_table) //1. name //table update/
        return FALSE;

    foreach ($args as $v) { //$v = [email=user_email]
        list($a, $b) = explode('=', $v, 2);
        if ($a)
            $cp_data[$a] = $b;        // VD: email = user_email
    }

    if (!empty($cp_data))
        $key_ids = array_keys($cp_data);    //get key cp_data

    if (!empty($key_ids))
        foreach ($key_ids as $v)
            $gr_col .= "$v,";

    foreach ($cp_data as $key => $val)
        $gr_cont .= "$val,";

    if (strlen($gr_col) > 1)
        $key_up_col = substr($gr_col, 0, -1);

    if (strlen($gr_cont) > 1)
        $val_up_cont = substr($gr_cont, 0, -1);

    if ($key_up_col && $val_up_cont && $user_table) {

//        $db_new->BeginTrans();
        //msg_err()
        $check = $db_new->Execute("INSERT INTO $user_table ($key_up_col) VALUES ($val_up_cont)") or cn_writelog("INSERT INTO $user_table ($key_up_col) VALUES ($val_up_cont)", 'e');

        if ($check) {
            $db_new->CompleteTrans();
            return TRUE;
        } else {
            $db_new->RollbackTrans();
        }
    }
    return FALSE;
}

//// check later
//1. table => SQL
//2: ... n => where		=> arrry[] = array('Column' => Val)
//3. ... n => where 	=> WHRER Contine (AND ... AND ...)
function do_update_character1($user_table, $array, $where = '')
{
    global $db_new;
    //$gr_col = $gr_cont = '';
    //$args = func_get_args(); 			//1.name, 2.email="user_email", 3.nick="$user_nic", 4.pass="24242424ggsgsgs"
    //$user_table = array_shift($args);		// get name array frist

    if (!$user_table) //1. name //table update/
        return FALSE;
    //$gr_cont ='';
    if ($where) $where = "WHERE " . $where;

    foreach ($array as $hj) {
        $gr_col = '';

        foreach ($hj as $key => $var) $gr_col .= "$key=$var,";

        $gr_col = substr($gr_col, 0, -1);


        /*
        foreach ($args as $v){  //$v = [email=user_email] >, >=, <>, <, <=, (= :)
            if(strpos($v,'=') !== false)
                $gr_col .= "$v,";
            elseif(strpos($v,':') !== false){
                $df = str_replace(':','=', $v);
                $gr_cont .= "$df AND ";
            }
            elseif(strpos($v,'>') !== false)
                $gr_cont .= "$v AND ";
            elseif(strpos($v,'>=') !== false)
                $gr_cont .= "$v AND ";
            elseif(strpos($v,'<>') !== false)
                $gr_cont .= "$v AND ";
            elseif(strpos($v,'<') !== false)
                $gr_cont .= "$v AND ";
            elseif(strpos($v,'<=') !== false)
                $gr_cont .= "$df AND ";

            //else continue;
        }

        if(strlen($gr_col) > 1)
            $val_up_col = substr($gr_col,0, -1);
        if(strlen($gr_cont) > 5)
            $val_up_cont = substr($gr_cont,0, -5);
        */
        echo "453 ==>>> UPDATE $user_table SET $gr_col $where <br>";
        if ($gr_col && $user_table) {
            $check = $db_new->Execute("UPDATE $user_table SET $gr_col $where") or msg_err("Error >>>> UPDATE ... UPDATE $user_table SET $gr_col $where");
            if (!$check)
                return TRUE;
        } else
            return FALSE;
    }
}

// sign table, mutile cont (abc=abc1,...N, abc2:abc3... N)
//1. table => SQL
//2: ... n => Col = val		=> update SQL
//3. ... n => Col : val 	=> WHRER Contine (AND ... AND ...)
function do_update_character()
{
    global $db_new;
    $gr_col = $gr_cont = '';
    $args = func_get_args();            //1.name, 2.email="user_email", 3.nick="$user_nic", 4.pass="24242424ggsgsgs"
    $user_table = array_shift($args);        // get name array frist

    if (!$user_table) //1. name //table update/
        return FALSE;

    foreach ($args as $v) {  //$v = [email=user_email] >, >=, <>, <, <=, (= :)
        if (strpos($v, '=') !== false)
            $gr_col .= "$v,";
        elseif (strpos($v, ':') !== false) {
            $df = str_replace(':', '=', $v);
            $gr_cont .= "$df AND ";
        } elseif (strpos($v, '>') !== false)
            $gr_cont .= "$v AND ";
        elseif (strpos($v, '>=') !== false)
            $gr_cont .= "$v AND ";
        elseif (strpos($v, '<>') !== false)
            $gr_cont .= "$v AND ";
        elseif (strpos($v, '<') !== false)
            $gr_cont .= "$v AND ";
        elseif (strpos($v, '<=') !== false)
            $gr_cont .= "$df AND ";

        //else continue;
    }

    if (strlen($gr_col) > 1)
        $val_up_col = substr($gr_col, 0, -1);
    if (strlen($gr_cont) > 5) $val_up_cont = substr($gr_cont, 0, -5);

    if ($val_up_col && $val_up_cont && $user_table) {
        $check = $db_new->Execute("UPDATE $user_table SET $val_up_col WHERE $val_up_cont") or cn_writelog("UPDATE $user_table SET $val_up_col WHERE $val_up_cont", 'e');
        if ($check)
            return TRUE;
    }
    return FALSE;
}


/**
 * @param $myQuery
 * @return bool
 */
function do_delete_char($myQuery){
    global $db_new;

    if ($myQuery) {
        $myQuery = trim($myQuery);
        $check = $db_new->Execute("$myQuery") or cn_writelog($myQuery, 'e');
        if ($check) {
            return true;
        }
    } else return false;

    return false;
}

function do_selc_char($account, $character)
{ //??

    global $db_new;
    //$str_ = '';
    //$pk_level = $row = $master_check = $class_stat =array();
    if (!empty($account)) {
        //kiemtra_hackreset($account,$character);
        //kemtra_doinv($account,$character);
        //kiemtra_online($account);			//PkCount,Money FROM Character WHERE PkCount>0 and Name='$character'"

        $pklevel_check = $db_new->Execute("SELECT PkLevel, PkCount, Money FROM Character WHERE Name='$character'");
        if ($pklevel_check === false) $pk_level = array();
        $pk_level = $pklevel_check->fetchrow() or $pk_level = array();

        $result = $db_new->Execute("SELECT Clevel,Resets,Money,LevelUpPoint,Class,Relifes,NoResetInDay,Resets_Time FROM Character WHERE Name='$character'");
        if ($result === false) $row = array();
        $row = $result->fetchrow() or $row = array();

        switch (getoption('server_type')) {
            case "scf":
                $sql_master_check = $db_new->Execute("SELECT SCFMasterLevel FROM Character WHERE Name='$character'");
                if ($sql_master_check === false) return 'Error';
                break;
            case "ori":
                $sql_master_check = $db_new->Execute("SELECT MASTER_LEVEL FROM T_MasterLevelSystem WHERE CHAR_NAME='$character'");
                if ($sql_master_check === false) return 'Error';
                break;
            default:
                $sql_master_check = $db_new->Execute("SELECT SCFMasterLevel FROM Character WHERE Name='$character'");
                if ($sql_master_check === false) return 'Error';
                break;
        }
        $master_check = $sql_master_check->fetchrow() or $master_check = array();

        $sql_class_check = $db_new->Execute("SELECT Strength,Dexterity,Vitality,Energy,Life,MaxLife,Mana,MaxMana,MapNumber,MapPosX,MapPosY,Leadership FROM DefaultClassType WHERE Class='$row[4]' Or Class='$row[4]'-1 Or Class='$row[4]'-2 Or Class='$row[4]'-3");
        if ($sql_class_check === false) $class_stat = array();
        $class_stat = $sql_class_check->fetchrow() or $class_stat = array();
        if ($class_stat) {
            $arr_class['Strength'] = $class_stat['Strength'];
            $arr_class['Dexterity'] = $class_stat['Dexterity'];
            $arr_class['Vitality'] = $class_stat['Vitality'];
            $arr_class['Energy'] = $class_stat['Energy'];
            $arr_class['Life'] = $class_stat['Life'];
            $arr_class['MaxLife'] = $class_stat['MaxLife'];
            $arr_class['Mana'] = $class_stat['Mana'];
            $arr_class['MaxMana'] = $class_stat['MaxMana'];
            $arr_class['MapNumber'] = $class_stat['MapNumber'];
            $arr_class['MapPosX'] = $class_stat['MapPosX'];
            $arr_class['MapPosY'] = $class_stat['MapPosY'];
            $arr_class['Leadership'] = $class_stat['Leadership'];
        }
    }

    $pk_level_ = isset($pk_level) ? $pk_level : array();
    $row_ = isset($row) ? $row : array();
    $master_check_ = isset($master_check) ? $master_check : array();
    $arr_class_ = isset($arr_class) ? $arr_class : array();

    return array($pk_level_, $row_, $master_check_, $arr_class_);
}


/**
 * @param  name
 * return array info manager Account
 * return bool exits name in Account_info
 */
function db_membget_account($clause, $colClause ='[UserAcc]', $ischek = FALSE)
{
    if ($clause) {
        $usx = do_select_orther("SELECT Top 1 * FROM Account_Info WHERE ". $colClause ."='". $clause . "' ORDER BY ID DESC");

        if (!is_array($usx) || !$usx) {
            return null;
        }

        if ($ischek) {
            if ($usx) {
                return true;
            } else {
                return false;
            }
        }
        $result = [
            'id' => $usx[0]['id'],
            'user_Account' => trim($usx[0]['UserAcc']),
            'pass' => $usx[0]['Pwd'],
            'acl' => $usx[0]['AdLevel'],
            'ban' => $usx[0]['Ban'],
            'numLogin' => $usx[0]['NumLogin'],
            'email' => $usx[0]['Email'],
            'lastDate' => $usx[0]['Lastdate'],
            'time_At' => $usx[0]['Time_At'],
            'hash' => $usx[0]['hash']
        ];

        return $result;
    }
    return null;
}

function rankingCharaterTop(){
    $myQueryRankingTop = "SELECT Top 50 [Name] FROM Character ORDER BY relifes DESC, resets DESC , cLevel DESC";
    $resultRankingTop = do_select_orther($myQueryRankingTop);

    if ($resultRankingTop) {
        do_update_character('Character', 'Top50=0', 'Top50>0');
        $myQueryUpdate = 'UPDATE Character SET top50 = CASE Name';
        foreach ($resultRankingTop as $key => $items) {
            $myQueryUpdate .= ' WHEN \'' . $items['Name'] . '\' THEN ' . ($key + 1);
        }
        $myQueryUpdate .= ' END';
        $chekUpdate = do_update_orther($myQueryUpdate);
        //if (!$chekUpdate) cn_writelog($myQueryUpdate, 'e');
    }
    echoArr($resultRankingTop);
}

//-------------------------------------------------------------------------------------------------------------------------------
function kiemtra_cardnumber($card_num)
{
    if (preg_match("[^a-zA-Z0-9$]", $card_num)) {
        echo "Du lieu loi : $card_num . Chi duoc su dung ki tu a-z, A-Z va (1-9).";
        exit();
    }
}

function kiemtra_kituso($account)
{
    if (preg_match("[^0-9$]", $account)) {
        echo "Du lieu loi : $account . Chi duoc su dung so (1-9).";
        exit();
    }
}

function kiemtra_kitudacbiet($account)
{
    if (preg_match("[^a-zA-Z0-9_$]", $account)) {
        echo "Du lieu loi : $account . Chi duoc su dung ki tu a-z, A-Z, so (1-9) va dau _.";
        exit();
    }
}

function kiemtra_email($email)
{
    if (preg_match("[^a-zA-Z0-9\.@_-$]", $email)) {
        echo "Email Khong duoc su dung nhung ky tu dac biet.";
        exit();
    }
    if (!preg_match("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[\.a-z]{2,6}$", $email)) {
        echo "Dia chi Email khong dung. Xin vui long kiem tra lai.";
        exit();
    }
}

function kiemtra_acc($account)
{
    //global $db_new;
    //exit();
    if (!empty($account)) {
        $username_check = do_select_character('MEMB_INFO', 'memb___id', "memb___id='$account'", '');
        //$username_check = $sql_username_check->numrows();

        if (count($username_check) < 1)
            return true;            // "Tài khoản không tồn tại.";
    }
    return false;
}

function kiemtra_loggame($account)
{
    global $db_new;

    if (!empty($account)) {
        $sql_loggame_check = $db_new->Execute("SELECT * FROM MEMB_STAT WHERE memb___id='$account'");
        $loggame_check = $sql_loggame_check->numrows();
        if ($loggame_check < 1)
            return true; //echo "Tài khoản phải vào Game tạo ít nhất 1 nhân vật mới có thể đăng nhập.";
    }
    return false;
}

function kiemtra_block_acc($account)
{
    global $db_new;

    if (!empty($account)) {
        $sql_blockacc_check = $db_new->Execute("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$account' AND bloc_code='1'");
        if (!$sql_blockacc_check) return false;
        $blockacc_check = $sql_blockacc_check->numrows();
        if ($blockacc_check > 0)
            return true;/// "Tài khoản đang bị khóa.";
    }
    return false;
}

function kiemtra_ques_ans($account, $question, $answer)
{
    global $db_new;
    $sql_ques_ans_check = $db_new->Execute("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$account' AND fpas_ques='$question' AND fpas_answ='$answer'");
    if (!$sql_ques_ans_check) return '';
    $ques_ans_check = $sql_ques_ans_check->numrows();
    if ($ques_ans_check <= 0) {
        echo "Câu hỏi hoặc câu trả lời bí mật không đúng.";
        exit();
    }
}

//function kiemtra_pass($account, $password)
//{
//    global $db_new;
//    if ($server_md5 == 1) {
//        $sql_pw_check = $db_new->Execute("SELECT * FROM MEMB_INFO WHERE memb__pwd=[dbo].[fn_md5]('$password','$account') AND memb___id='$account'");
//    } else {
//        $sql_pw_check = $db_new->Execute("SELECT * FROM MEMB_INFO WHERE memb__pwd='$password' AND memb___id='$account'");
//    }
//    $pw_check = $sql_pw_check->numrows();
//    if ($pw_check <= 0) {
//        echo "Mật khẩu không đúng.";
//        exit();
//    }
//}

function kiemtra_char($account, $character)
{
    global $db_new;
    $sql_name_check = $db_new->Execute("SELECT Name FROM Character WHERE Name='$character' AND AccountID = '$account'");
    $character_check = $sql_name_check->numrows();
    if ($character_check <= 0) {
        echo "$character : Tên nhân vật sai.";
        exit();
    }
}

function kiemtra_block_char($account, $character)
{
    global $db_new;
    $sql_block_check = $db_new->Execute("SELECT Name FROM Character WHERE Name='$character' AND CtlCode='1' AND AccountID='$account'");
    $block_check = $sql_block_check->numrows();
    if ($block_check > 0) {
        echo "Nhân vật đang bị khóa.";
        exit();
    }
}

function kiemtra_online($account)
{
    global $db_new;
    $sql_online_check = $db_new->Execute("SELECT * FROM MEMB_STAT WHERE memb___id='$account' AND ConnectStat='1'");
    $online_check = $sql_online_check->numrows();
    if ($online_check > 0) {
        echo "Nhân vật chưa thoát Game. Hãy thoát Game trước khi thực hiện chức năng này.";
        exit();
    }
}

function kiemtra_doinv($account, $character)
{
    global $db_new;
    $sql_doinv_check = $db_new->Execute("SELECT * FROM AccountCharacter WHERE Id='$account' AND GameIDC='$character'");
    $doinv_check = $sql_doinv_check->numrows();
    if ($doinv_check > 0) {
        echo "Nhân vật chọn không được là nhân vật thoát ra sau cùng. Hãy vào Game và chọn nhân vật khác trước khi thực hiện chức năng này.";
        exit();
    }
}

function check_online($account)
{
    global $db_new;
    $sql_online_check = $db_new->Execute("SELECT * FROM MEMB_STAT WHERE memb___id='$account' AND ConnectStat='1'");
    if ($sql_online_check->numrows() > 0) {
        return true;
    }
    return false;
}

function check_changecls($account, $character)
{
    global $db_new;
    $sql_doinv_check = $db_new->Execute("SELECT * FROM AccountCharacter WHERE Id='$account' AND GameIDC='$character'");
    if ($sql_doinv_check->numrows() > 0) {
        return false;
    }
    return true;
}

function kiemtra_pass2($login, $pass2)
{
    global $db_new;
    $sql_pw_check = $db_new->Execute("SELECT * FROM MEMB_INFO WHERE pass2='$pass2' and memb___id='$login'");
    $pw_check = $sql_pw_check->numrows();
    if ($pw_check <= 0) {
        echo "Mật khẩu cấp 2 không đúng.";
        exit();
    }
}

function kiemtra_GM($account)
{
    //global $gm;
    global $db_new;

    if (!empty($account)) {
        $sql_gm_check = $db_new->Execute("SELECT * FROM Character WHERE AccountID='$account' AND (CtlCode=8 or CtlCode=32)");
        $gm_check = $sql_gm_check->numrows();
        if ($gm_check <= 0) return true;        // 'NoGM';
    }
    return false;                            // 'isGM';
}

function kiemtra_ranking($account)
{
    //global $ranking;
    global $db_new;
    if (!empty($account)) {
        $sql_ranking_check = $db_new->Execute("SELECT * FROM Character WHERE AccountID='$account' AND (Resets>50 or Relifes>0 or cLevel>400)");
        $ranking_check = $sql_ranking_check->numrows();
        if ($ranking_check <= 0) return true;            //'NoRanking';
    }
    return false;                                        //'isRanking';
}

function kiemtra_daily($account)
{
    global $dl;
    global $db_new;
    $sql_daily_check = $db_new->Execute("SELECT * FROM DaiLy WHERE accdl='$account'");
    $daily_check = $sql_daily_check->numrows();
    if ($daily_check <= 0) $dl = 'NoDL';
    else $dl = 'isDL';
}

function kiemtra_hackreset($account, $character)
{
    global $db_new;
    $time_check = ctime() - 60;
    $sql_hack_check = $db_new->Execute("SELECT Name FROM Character WHERE Resets_Time>'$time_check' AND Clevel = '400'");
    while ($hack_check = $sql_hack_check->fetchrow()) {
        $xuly_hack = $db_new->Execute("Update Character SET Resets=Resets-1,NoResetInDay=NoResetInDay-1,NoResetInMonth=NoResetInMonth-1,Resets_Time=$time_check WHERE Name='$hack_check[0]'");
        if ($hack_check[0] == $character) {
            echo "Nhân vật $character đã thực hiện hành vi Hack Reset. Bạn đã bị trừ 1 lần Reset";
            exit();
        }
    }
}

function kiemtra_hackvpoint($account)
{
    global $db_new;
    $time_check = $timestamp - 60;
    $sql_vpoint_check = $db_new->Execute("SELECT vpoint FROM MEMB_INFO WHERE memb___id = '$account'");
    $vpoint_check = $sql_vpoint_check->fetchrow();
    $sql_hack_check = $db_new->Execute("SELECT memb___id FROM MEMB_INFO WHERE Transfer_Time>'$time_check' AND vpoint=$vpoint_check[0]");
    while ($hack_check = $sql_hack_check->fetchrow()) {
        $xuly_hack = $db_new->Execute("UPDATE MEMB_INFO SET vpoint=vpoint-10000,Transfer_Time='$time_check' WHERE memb___id='$hack_check[0]'");
        if ($hack_check[0] == $character) {
            echo "Tài khoản $account đã thực hiện hành vi Hack V.Point. Bạn đã bị trừ 10.000 V.Point";
            exit();
        }
    }
}

function kiemtra_topmonth($character)
{
    global $db_new;
    $check_month = $db_new->Execute("SELECT * FROM TopMonth WHERE Month='$month' AND Year='$year'");
    $result_check = $check_month->numrows();
//Begin Nếu chưa có TOP tháng hiện tại thì tạo danh sách TOP mới
    if ($result_check < 1) {
        $query_topmonth = "SELECT AccountID,Name,NoResetInMonth FROM Character ORDER BY NoResetInMonth DESC, relifes DESC, resets DESC , cLevel DESC";
        $result_topmonth = $db_new->SELECTLimit($query_topmonth, 10, 0);
        $stt = 0;
        while ($topmonth = $result_topmonth->fetchrow()) {
            $stt = $stt + 1;
            $query_inserttop = "INSERT INTO TopMonth (stt,acc,Name,resets,Month,Year) VALUES ('$stt','$topmonth[0]','$topmonth[1]','$topmonth[2]','$month','$year')";
            $run_inserttop = $db_new->Execute($query_inserttop);
        }
    } //End Nếu chưa có TOP tháng hiện tại thì tạo danh sách TOP mới
    else {
        $query_checktop10 = $db_new->Execute("SELECT resets FROM TopMonth WHERE Month='$month' AND Year='$year' AND stt='10'");
        $checktop10 = $query_checktop10->fetchrow();
        $query_checkNoResetInMonth_OfName = $db_new->Execute("SELECT NoResetInMonth FROM Character WHERE Name='$character'");
        $checkNoResetInMonth_OfName = $query_checkNoResetInMonth_OfName->fetchrow();
//Begin Nếu TOP10 tháng nhỏ hơn nhân vật Reset thì Update TOP
        if ($checktop10[0] < ($checkNoResetInMonth_OfName[0])) {
            $query_topmonth = "SELECT AccountID,Name,NoResetInMonth FROM Character ORDER BY NoResetInMonth DESC, relifes DESC, resets DESC , cLevel DESC";
            $result_topmonth = $db_new->SELECTLimit($query_topmonth, 10, 0);
            $stt = 0;
            while ($topmonth = $result_topmonth->fetchrow()) {
                $stt = $stt + 1;
                $query_updatetop = "UPDATE TopMonth SET [acc]='$topmonth[0]',[Name]='$topmonth[1]',[resets]='$topmonth[2]' WHERE stt='$stt' AND Month='$month' AND Year='$year'";
                $run_updatetop = $db_new->Execute($query_updatetop);
            }
        } //End Nếu TOP10 tháng nhỏ hơn nhân vật Reset thì Update TOP
        else {
            $query_checktop1 = $db_new->Execute("SELECT resets FROM TopMonth WHERE Month='$month' AND Year='$year' AND stt='1'");
            $checktop1 = $query_checktop1->fetchrow();
            $query_checkNoResetInMonth_TOP1 = "SELECT NoResetInMonth FROM Character ORDER BY NoResetInMonth DESC, relifes DESC, resets DESC , cLevel DESC";
            $result_checkNoResetInMonth_TOP1 = $db_new->SELECTLimit($query_checkNoResetInMonth_TOP1, 1, 0);
            $checkNoResetInMonth_TOP1 = $result_checkNoResetInMonth_TOP1->fetchrow();
//Begin Nếu TOP1 tháng lớn hơn TOP1 tháng trong Character thì Update TOP
            if ($checktop1[0] > $checkNoResetInMonth_TOP1[0]) {
                $query_topmonth = "SELECT AccountID,Name,NoResetInMonth FROM Character ORDER BY NoResetInMonth DESC, relifes DESC, resets DESC , cLevel DESC";
                $result_topmonth = $db_new->SELECTLimit($query_topmonth, 10, 0);
                $stt = 0;
                while ($topmonth = $result_topmonth->fetchrow()) {
                    $stt = $stt + 1;
                    $query_updatetop = "UPDATE TopMonth SET [acc]='$topmonth[0]',[Name]='$topmonth[1]',[resets]='$topmonth[2]' WHERE stt='$stt' AND Month='$month' AND Year='$year'";
                    $run_updatetop = $db_new->Execute($query_updatetop);
                }
            }
//End Nếu TOP1 tháng lớn hơn TOP1 tháng trong Character thì Update TOP
        }
    }
}

function top50()
{
    //global $db_new;
    $dt_time = do_select_character('Check_Action', 'time', "action='TOP50'", '');
    //check_top50_query = "SELECT time FROM Check_Action WHERE action='Top50'";
    //    $check_top50_result = $db_new->Execute($check_top50_query);
    //        check_queryerror($check_top50_query, $check_top50_result);
    //    $check_top50 = $check_top50_result->fetchrow();
    //Reset số lần RS trong tháng khi sang tháng mới
    $time_ = ctime();
    //$time_ = ;
    //$time_top50 = ;
    if (date("d", $dt_time[0][0]) != date("d", $time_)) {
        //Update Time check
        do_update_character('Check_Action', "time=$time_", "action:'Top50'");
        //$update_time_result = $db_new->Execute($update_time_query);
        //check_queryerror($update_time_query, $update_time_result);
        // Neu khong phai ngay dau tien
        //if($dt_time[0] != 0) {
        //Reset TOP 50
        do_update_character('Character', 'Top50=0', 'Top50>0');
        /*
        $resettop50_result = $db_new->Execute($resettop50_query);
             check_queryerror($resettop50_query, $resettop50_result);


         $thehemax_query = "SELECT TOP1, thehe FROM MEMB_INFO ORDER BY thehe DESC";
         $thehemax_result = $db_new->Execute($thehemax_query);
             check_queryerror($thehemax_query, $thehemax_result);
         $thehemax_fetch = $thehemax_result->FetchRow();
         $thehemax = $thehemax_fetch[0];
         */
        //for($i=1; $i<=$thehemax; $i++) {

        $arr_top50 = do_select_character('Character', 'Name', '', 'ORDER BY Relifes DESC, Resets DESC , cLevel DESC');
        //$query_top50 = "SELECT Name FROM Character ORDER BY Relifes DESC, Resets DESC , cLevel DESC";
        //$result_top50 = $db_new->Execute("SELECT Name FROM Character ORDER BY Relifes DESC, Resets DESC , cLevel DESC");
        //$top = 1;
        foreach ($arr_top50 as $top => $val) {
            $top++;
            do_update_character('Character', "Top50=$top", "Name:'$val[0]'");
        }
        //}
        //}
    }
}


/*

//-------------------------------------	
	switch ($action) {
		
			
		case 'view_char':
			$query = "SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'";
			$result = $db_new->Execute( $query );
			$row = $result->fetchrow();
			echo "$row[0]||$row[1]||$row[2]||$row[3]||$row[4]";
			break;
			
		case 'view_acc':
			kiemtra_acc($account);
			$query = $db_new->Execute("SELECT mail_addr,tel__numb,fpas_ques,fpas_answ,vpoint FROM MEMB_INFO WHERE memb___id='$account'");
			$row = $query->fetchrow();
			echo "$row[0]||$row[1]||$row[2]||$row[3]||$row[4]";
			break;
			
		
		case 'view_char':
			$query = "SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'";
			$result = $db_new->Execute( $query );
			$row = $result->fetchrow();
			echo "$row[0]||$row[1]||$row[2]||$row[3]||$row[4]";
			break;
			
		
			
		case 'view_charaddpoint':
			$query = "SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'";
			$result = $db_new->Execute( $query );
			$row = $result->fetchrow();
			for ($i=0;$i<5;++$i) {
				if ( !empty($row[$i]) ) {
					$query_point = $db_new->Execute("SELECT LevelUpPoint FROM Character WHERE Name='$row[$i]'");
					$rs_point = $query_point->fetchrow();
					$point[] = $rs_point[0];
				}
				else { $point[] = 0; }
			}
			echo "$row[0]|$point[0]||$row[1]|$point[1]||$row[2]|$point[2]||$row[3]|$point[3]||$row[4]|$point[4]";
			break;
			
		case 'view_charrutpoint':
			$query = "SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'";
			$result = $db_new->Execute( $query );
			$row = $result->fetchrow();
			for ($i=0;$i<5;++$i) {
				if ( !empty($row[$i]) ) {
					$query_point = $db_new->Execute("SELECT pointdutru FROM Character WHERE Name='$row[$i]'");
					$point = $query_point->fetchrow();
					$point_dutru[] = $point[0];
				}
				else { $point_dutru[] = 0; }
			}
			echo "$row[0]|$point_dutru[0]||$row[1]|$point_dutru[1]||$row[2]|$point_dutru[2]||$row[3]|$point_dutru[3]||$row[4]|$point_dutru[4]";
			break;
			
		case 'view_combo':
			$query = "SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'";
			$result = $db_new->Execute( $query );
			$row = $result->fetchrow();
			for ($i=0;$i<5;++$i) {
				if ( !empty($row[$i]) ) {
					$query_leveldk3 = $db_new->Execute("SELECT Clevel FROM Character WHERE Name='$row[$i]' AND (Class='$class_dw_3' OR Class='$class_dk_3' OR Class='$class_elf_3' OR Class='$class_sum_3' OR Class='$class_rf_2')");
					$rs_leveldk3 = $query_leveldk3->fetchrow();
					$leveldk3[] = $rs_leveldk3[0];
				}
				else { $leveldk3[] = 0; }
			}
			echo "$row[0]|$leveldk3[0]||$row[1]|$leveldk3[1]||$row[2]|$leveldk3[2]||$row[3]|$leveldk3[3]||$row[4]|$leveldk3[4]";
			break;
			
		case 'view_uythacoffline':
			$query = "SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'";
			$result = $db_new->Execute( $query );
			$row = $result->fetchrow();
			for ($i=0;$i<5;++$i) {
				if ( !empty($row[$i]) ) {
					$query_uythacoff = $db_new->Execute("SELECT uythacoffline_stat,uythacoffline_time,PointUyThac FROM Character WHERE Name='$row[$i]'");
					$uythacoff = $query_uythacoff->fetchrow();
					$tinhtrang[] = $uythacoff[0];
					if ( 0 < $uythacoff[1] ) {
						$thoigian[] = floor( ( $timestamp - $uythacoff[1] ) / 60 );
					}
					else {
						$thoigian[] = 0;
					}
					$diem[] = $uythacoff[2];
				}
				else { $tinhtrang[] = 0; $thoigian[] = 0; $diem[] = 0; }
			}
			echo "$row[0]|$tinhtrang[0]|$thoigian[0]|$diem[0]||$row[1]|$tinhtrang[1]|$thoigian[1]|$diem[1]||$row[2]|$tinhtrang[2]|$thoigian[2]|$diem[2]||$row[3]|$tinhtrang[3]|$thoigian[3]|$diem[3]||$row[4]|$tinhtrang[4]|$thoigian[4]|$diem[4]";
			break;
			
		case 'view_charrs_uythac':
			$query = "SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'";
			$result = $db_new->Execute( $query );
			$row = $result->fetchrow();
			for ($i=0;$i<5;++$i) {
				if ( !empty($row[$i]) ) {
					$query_reset = $db_new->Execute("SELECT PointUyThac,Resets FROM Character WHERE Name='$row[$i]'");
					$rs_reset = $query_reset->fetchrow();
					$pointuythac[] = $rs_reset[0];
					$reset[] = $rs_reset[1];
				}
				else { $reset[] = 0; $pointuythac[] = 0; }
			}
			echo "$row[0]|$pointuythac[0]|$reset[0]||$row[1]|$pointuythac[1]|$reset[1]||$row[2]|$pointuythac[2]|$reset[2]||$row[3]|$pointuythac[3]|$reset[3]||$row[4]|$pointuythac[4]|$reset[4]";
			break;
			

			
		case 'view_pcpoint2vpoint':
			$query = "SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'";
			$result = $db_new->Execute( $query );
			$row = $result->fetchrow();
			for ($i=0;$i<5;++$i) {
				if ( !empty($row[$i]) ) {
					switch($server_type) {
						case "scf":
							$query_pcpoint = $db_new->Execute("SELECT SCFPCPoints FROM Character WHERE Name='$row[$i]'");
							break;
						case "ori":
							$query_pcpoint = $db_new->Execute("SELECT PCPoints FROM Character WHERE Name='$row[$i]'");
							break;
						default:
							$query_pcpoint = $db_new->Execute("SELECT SCFPCPoints FROM Character WHERE Name='$row[$i]'");
							break;
					}
					$pcpoint = $query_pcpoint->fetchrow();
					$point[] = $pcpoint[0];
				}
				else { $point[] = 0; }
			}
			echo "$row[0]|$point[0]||$row[1]|$point[1]||$row[2]|$point[2]||$row[3]|$point[3]||$row[4]|$point[4]";
			break;
			
		case 'view_zen2bank':
			$query = "SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'";
			$result = $db_new->Execute( $query );
			$row = $result->fetchrow();
			for ($i=0;$i<5;++$i) {
				if ( !empty($row[$i]) ) {
					$query_zen = $db_new->Execute("SELECT Money FROM Character WHERE Name='$row[$i]'");
					$zen = $query_zen->fetchrow();
					$money[] = $zen[0];
				}
				else { $money[] = 0; }
			}
			echo "$row[0]|$money[0]||$row[1]|$money[1]||$row[2]|$money[2]||$row[3]|$money[3]||$row[4]|$money[4]";
			break;
			
		case 'view_charpk':
			$query = "SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'";
			$result = $db_new->Execute( $query );
			$row = $result->fetchrow();
			for ($i=0;$i<5;++$i) {
				if ( !empty($row[$i]) ) {
					$query_PK = $db_new->Execute("SELECT PkLevel,PkCount FROM Character WHERE Name='$row[$i]'");
					$rs_PK = $query_PK->fetchrow();
					$PkLevel[] = $rs_PK[0];
					$PkCount[] = $rs_PK[1];
				}
				else { $PkLevel[] = 0; $PkCount[] = 0; }
			}
			echo "$row[0]|$PkLevel[0]|$PkCount[0]||$row[1]|$PkLevel[1]|$PkCount[1]||$row[2]|$PkLevel[2]|$PkCount[2]||$row[3]|$PkLevel[3]|$PkCount[3]||$row[4]|$PkLevel[4]|$PkCount[4]";
			break;
			
		case 'view_charchangeclass':
			$query = "SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'";
			$result = $db_new->Execute( $query );
			$row = $result->fetchrow();
			for ($i=0;$i<5;++$i) {
				if ( !empty($row[$i]) ) {
					$query_Class = $db_new->Execute("SELECT Class,Resets,cLevel FROM Character WHERE Name='$row[$i]'");
					$rs_Class = $query_Class->fetchrow();
					$Class[] = $rs_Class[0];
					$Reset[] = $rs_Class[1];
					$Level[] = $rs_Class[2];
				}
				else { $Class[] = 0; $Reset[] = 0; $Level[] = 0; }
			}
			echo "$row[0]|$Class[0]|$Reset[0]|$Level[0]||$row[1]|$Class[1]|$Reset[1]|$Level[1]||$row[2]|$Class[2]|$Reset[2]|$Level[2]||$row[3]|$Class[3]|$Reset[3]|$Level[3]||$row[4]|$Class[4]|$Reset[4]|$Level[4]";
			break;
			
		case 'view_charthuepoint':
			$query = "SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'";
			$result = $db_new->Execute( $query );
			$row = $result->fetchrow();
			for ($i=0;$i<5;++$i) {
				if ( !empty($row[$i]) ) {
					$query_point = $db_new->Execute("SELECT IsThuePoint,TimeThuePoint,PointThue FROM Character WHERE Name='$row[$i]'");
					$point = $query_point->fetchrow();
					$point_status[] = $point[0];
					$point_time[] = $point[1];
					$point_thue[] = $point[2];
				}
				else { $point_status[] = 0; $point_time[] = 0; $point_thue[] = 0; }
			}
			echo "$row[0]|$point_status[0]|$point_time[0]|$point_thue[0]||$row[1]|$point_status[1]|$point_time[1]|$point_thue[1]||$row[2]|$point_status[2]|$point_time[2]|$point_thue[2]||$row[3]|$point_status[3]|$point_time[3]|$point_thue[3]||$row[4]|$point_status[4]|$point_time[4]|$point_thue[4]";
			break;
			
		case 'view_charlockitem':
			$query = "SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'";
			$result = $db_new->Execute( $query );
			$row = $result->fetchrow();
			for ($i=0;$i<5;++$i)
			{
				if ( !empty($row[$i]) ) {
					$query_khoaitem = $db_new->Execute("SELECT IsLockItem FROM Character WHERE Name='$row[$i]'");
					$rs_khoaitem = $query_khoaitem->fetchrow();
					$status_khoado[] = $rs_khoaitem[0];
				}
				else { $status_khoado[] = 0; }
			}
			echo "$row[0]|$status_khoado[0]||$row[1]|$status_khoado[1]||$row[2]|$status_khoado[2]||$row[3]|$status_khoado[3]||$row[4]|$status_khoado[4]";
			break;
			
		case 'view_charrl':
			$query = "SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'";
			$result = $db_new->Execute( $query );
			$row = $result->fetchrow();
			for ($i=0;$i<5;++$i) {
				if ( !empty($row[$i]) ) {
					$query_reset = $db_new->Execute("SELECT cLevel,Resets,ReLifes FROM Character WHERE Name='$row[$i]'");
					$rs_reset = $query_reset->fetchrow();
					$level[] = $rs_reset[0];
					$reset[] = $rs_reset[1];
					$relife[] = $rs_reset[2];
				}
				else { $reset[] = 0; $level[] = 0; }
			}
			echo "$row[0]|$level[0]|$reset[0]|$relife[0]||$row[1]|$level[1]|$reset[1]|$relife[1]||$row[2]|$level[2]|$reset[2]|$relife[2]||$row[3]|$level[3]|$reset[3]|$relife[3]||$row[4]|$level[4]|$reset[4]|$relife[4]";
			break;
			
		case 'view_randomquest':
			$query = "SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'";
			$result = $db_new->Execute( $query );
			$row = $result->fetchrow();
			for ($i=0;$i<5;++$i) {
				if ( !empty($row[$i]) ) {
					$query_nhiemvu = $db_new->Execute("SELECT QuestReg,QuestType,QuestCount FROM Character WHERE Name='$row[$i]'");
					$nhiemvu = $query_nhiemvu->fetchrow();
					$tinhtrang[] = $nhiemvu[0];
					$loai[] = $nhiemvu[1];
					$soluong[] = $nhiemvu[2];
				}
				else { $tinhtrang[] = 0; $loai[] = 0; $soluong[] = 0; }
			}
			echo "$row[0]|$tinhtrang[0]|$loai[0]|$soluong[0]||$row[1]|$tinhtrang[1]|$loai[1]|$soluong[1]||$row[2]|$tinhtrang[2]|$loai[2]|$soluong[2]||$row[3]|$tinhtrang[3]|$loai[3]|$soluong[3]||$row[4]|$tinhtrang[4]|$loai[4]|$soluong[4]";
			break;
			
		case 'view_xosokienthiet':
			$query_xoso = $db_new->Execute("SELECT Account,Num1,Num2,Num3,Num4,Num5,Num6,Num7,Num8,Num9,Num10 FROM XoSoData WHERE Account='$account'");
			$number = $query_xoso->fetchrow();
			for ($i=0;$i<=10;++$i) {
				if (empty($number[$i])) $number[$i] = "Chưa có";
			}
			echo "$number[0]||$number[1]||$number[2]||$number[3]||$number[4]||$number[5]||$number[6]||$number[7]||$number[8]||$number[9]||$number[10]";
			break;
			
		case 'view_vpoint':
			$query_vpoint = $db_new->Execute("SELECT vpoint FROM MEMB_INFO WHERE memb___id='$account'");
			$check_vpoint = $query_vpoint->fetchrow();
			echo $check_vpoint[0];
			break;
			
		case 'view_vpoint_full':
			$query_vpoint_f = $db_new->Execute("SELECT vpoint,gcoin,gcoin_km FROM MEMB_INFO WHERE memb___id='$account'");
			$check_vpoint_f = $query_vpoint_f->fetchrow();
			echo "$check_vpoint_f[0]||$check_vpoint_f[1]||$check_vpoint_f[2]";
			break;
			
		case 'view_zen':
			$query_zen = $db_new->Execute("SELECT bank FROM MEMB_INFO WHERE memb___id='$account'");
			$check_zen = $query_zen->fetchrow();
			echo $check_zen[0];
			break;
			
		
			
		case 'view_infomu':
			$query_total_acc = "SELECT Count(*) FROM MEMB_INFO";
			$result_total_acc = $db_new->Execute($query_total_acc);
			$total_acc = $result_total_acc->fetchrow();
			$query_total_char = "SELECT Count(*) FROM Character";
			$result_total_char = $db_new->Execute($query_total_char);
			$total_char = $result_total_char->fetchrow();
			$query_total_online = "SELECT * FROM MEMB_STAT WHERE ConnectStat='1'";
			$result_total_online = $db_new->Execute($query_total_online);
			$total_online = $result_total_online->numrows();
			echo "$total_acc[0]||$total_char[0]||$total_online";
			break;
			
	}
} //else echo "Error
*/

// --------------------------Forum--------------------------------//
/**
 * @param $orther
 * @return array|bool
 */
function do_select_ortherForum($orther)
{
    global $db_Forum;

    if ($orther) {
        $orther = trim($orther);
        $check = $db_Forum->Execute("$orther") or cn_writelog($orther, 'e');
        if ($check) {
            while ($row = $check->fetchrow()) {
                $rs_data[] = $row;
            }
        }
    } else return FALSE;
    return isset($rs_data) ? $rs_data : array();
}

/**
 * @param $orther
 * @return bool
 */
function do_update_ortherForum($orther)
{
    global $db_Forum;
    $gr_col = $gr_cont = '';
    $args = func_get_args();            //1.name, 2.email="user_email", 3.nick="$user_nic", 4.pass="24242424ggsgsgs"
    $user_table = array_shift($args);        // get name array frist

    if (!$user_table) //1. name //table update/
        return FALSE;

    foreach ($args as $v) {  //$v = [email=user_email] >, >=, <>, <, <=, (= :)
        if (strpos($v, '=') !== false)
            $gr_col .= "$v,";
        elseif (strpos($v, ':') !== false) {
            $df = str_replace(':', '=', $v);
            $gr_cont .= "$df AND ";
        } elseif (strpos($v, '>') !== false)
            $gr_cont .= "$v AND ";
        elseif (strpos($v, '>=') !== false)
            $gr_cont .= "$v AND ";
        elseif (strpos($v, '<>') !== false)
            $gr_cont .= "$v AND ";
        elseif (strpos($v, '<') !== false)
            $gr_cont .= "$v AND ";
        elseif (strpos($v, '<=') !== false)
            $gr_cont .= "$df AND ";

        //else continue;
    }

    if (strlen($gr_col) > 1)
        $val_up_col = substr($gr_col, 0, -1);
    if (strlen($gr_cont) > 5) $val_up_cont = substr($gr_cont, 0, -5);

    if ($val_up_col && $val_up_cont && $user_table) {
        $check = $db_Forum->Execute("UPDATE $user_table SET $val_up_col WHERE $val_up_cont") or cn_writelog("UPDATE $user_table SET $val_up_col WHERE $val_up_cont", 'e');
        if ($check)
            return TRUE;
    }
    return FALSE;
}

/**
 * @param $myQuery
 * @return bool
 */
function do_delete_ortherForum($myQuery)
{
    global $db_Forum;

    if ($myQuery) {
        $myQuery = trim($myQuery);
        $check = $db_Forum->Execute("$myQuery") or cn_writelog($myQuery, 'e');
        if ($check) {
            return true;
        }
    } else return false;

    return false;
}

?>