<?php if (!defined('BQN_MU')) {
    die('Access restricted');
}

/**
 * @return bool
 */
function db_installed_check()
{
    global $db_new;

    if (!isset($db_new)) {
        return false;
    }

    $result = $db_new->Execute("SELECT * FROM Account_Info WHERE [AdLevel]=1");
    if ($result->RecordCount()) {
        return true;
    }

    return false;
}

function view_info_char($account)
{
    global $db_new;
    $str_ = '';
    if (!empty($account)) {
        $result = $db_new->Execute("SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'");
        if ($result === false) {
            return 'Error';
        }
        if ($result->numrows() != 0) {
            $row = $result->fetchrow();
            $coun_row = count($row);
            for ($i = 0; $i < $coun_row; $i++) {
                if (!empty($row[$i])) {
                    switch (getOption('server_type')) {
                        case "scf":
                            $query_info_char = $db_new->Execute("SELECT Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,SCFPCPoints FROM Character WHERE Name='$row[$i]'");
                            if ($query_info_char === false) {
                                continue;
                            }
                            break;
                        case "ori":
                            $query_info_char = $db_new->Execute("SELECT Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,PCPoints FROM Character WHERE Name='$row[$i]'");
                            if ($query_info_char === false) {
                                continue;
                            }
                            break;
                        default:
                            $query_info_char = $db_new->Execute("SELECT Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,SCFPCPoints FROM Character WHERE Name='$row[$i]'");
                            if ($query_info_char === false) {
                                continue;
                            }
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
        check_by_account($account);

        $result = $db_new->Execute($myQuery = "SELECT GameID1,GameID2,GameID3,GameID4,GameID5 FROM AccountCharacter WHERE Id='$account'") or cn_write_log($myQuery, 'e');

        if ($result) {
            if ($result->numrows() != 0) {
                $row = $result->fetchrow();

                foreach ($row as $i => $vl) {
                    if (!empty($row[$i])) {
                        switch (getOption('server_type')) {
                            case "scf":
                                $query_info_char = $db_new->Execute("SELECT Name,Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,SCFPCPoints,AccountID,NoResetInDay,Money,Top50,Resets_Time,UyThac,Inventory AS image,PkLevel,PkCount,MapNumber,IsThuePoint,TimeThuePoint FROM Character WHERE Name='$vl'");
                                if ($query_info_char === false) {
                                    continue;
                                }
                                break;
                            case "ori":
                                $query_info_char = $db_new->Execute("SELECT Name,Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,PCPoints,AccountID,NoResetInDay,Money,Top50,Resets_Time,UyThac,Inventory AS image,PkLevel,PkCount,MapNumber,IsThuePoint,TimeThuePoint FROM Character WHERE Name='$vl'");
                                if ($query_info_char === false) {
                                    continue;
                                }
                                break;
                            default:
                                $query_info_char = $db_new->Execute("SELECT Name,Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,SCFPCPoints,AccountID,NoResetInDay,Money,Top50,Resets_Time,UyThac,Inventory AS image,PkLevel,PkCount,MapNumber,IsThuePoint,TimeThuePoint FROM Character WHERE Name='$vl'");
                                if ($query_info_char === false) {
                                    continue;
                                }
                                break;
                        }

                        $info_char_[] = $query_info_char->fetchrow();
                    }
                }
            }
        }
    }

    if (getOption('debugSql')) {
        cn_write_log($myQuery);
    }

    return isset($info_char_) ? $info_char_ : array();
}

function view_bank($account)
{
    if (!empty($account)) {
        $result = do_select_character('MEMB_INFO', 'bank,vpoint,jewel_chao,jewel_cre,jewel_blue,gcoin,gcoin_km,jewel_feather,[WCoin],[WCoinP],[GoblinCoin]', "memb___id='$account'", '');

        if ($result) {
            foreach ($result as $key => $var) {
                $_data[] = array(
                    'bank' => $var['bank'],
                    'vp' => $var['vpoint'],
                    'chaos' => $var['jewel_chao'],
                    'cre' => $var['jewel_cre'],
                    'blue' => $var['jewel_blue'],
                    'gc' => $var['gcoin'],
                    'gc_km' => $var['gcoin_km'],
                    'feather' => $var['jewel_feather'],
                    'wCoin' => $var['WCoin'],
                    'wCoinP' => $var['WCoinP'],
                    'goblinCoin' => $var['GoblinCoin']
                );
            }
        }
    }

    if (getOption('debugSql')) {
        cn_write_log('MEMB_INFO', 'bank,vpoint,jewel_chao,jewel_cre,jewel_blue,gcoin,gcoin_km,jewel_feather,[WCoin],[WCoinP],[GoblinCoin]', "memb___id='$account'", '');
    }

    return isset($_data) ? $_data : array();
}


function point_tax($sub = '')
{
    //Kiểm tra những nhân vật đã thuê Point và xử lý khi hết thời gian
    $result_ = do_select_character('Character', 'Name,TimeThuePoint,AccountID', "IsThuePoint=1 AND AccountID ='" . $sub . "'");
    if (!empty($result_)) {
        if ($result_[0]['TimeThuePoint'] <= ctime()) {
            //exit();
            //Check Online
            $online_check = do_select_character('MEMB_STAT', '[ServerName]', "memb___id='" . $result_[0]['Name'] . "' AND ConnectStat=1");
            if (!empty($online_check)) {
                //Check Doi NV
                $doinv_check = do_select_character('AccountCharacter', '*', "Id='" . $result_[0]['AccountID'] . "' AND GameIDC='" . $result_[0]['name'] . "'");
                if (empty($doinv_check)) {
                    do_update_character('Character', 'IsThuePoint=0', 'PointThue=0', "Name:'" . $result_[0]['Name'] . "'");
                }
            } else {
                do_update_character('Character', 'IsThuePoint=0', 'PointThue=0', "Name:'" . $result_[0]['Name'] . "'");
            }
        }
    }
}

function mssql_real_escape_string($s)
{
    if (get_magic_quotes_gpc()) {
        $s = stripcslashes($s);
    }
    $s = str_replace("'", "''", $s);
    return $s;
}

// Since 2.0: Get user by id
function db_user_admin_by_name($name)
{
    // TODO
    if ($name) {
        $name = strtolower($name);
        $username = strip_tags($name);
        $username = mssql_real_escape_string($username);

        $result_rows = do_select_character('Account_Info', 'memb___id,memb__pwd,tel__numb,phon_numb,mail_addr,fpas_ques,fpas_answ,memb__pwd2,memb__pwdmd5,acl,ban_login,num_login,pass2', "memb___id='$username'");
        if ($result_rows) {
            foreach ($result_rows as $sd => $ds) {
                $pdata = array(
                    'user_name' => $ds['memb___id'],
                    'pass_web' => $ds['memb__pwdmd5'],
                    'memb__pwdmd5' => $ds['memb__pwdmd5'],
                    'pass_game' => $ds['memb__pwd'],
                    'tel_num' => $ds['tel__numb'],
                    'phon_num' => $ds['phon_numb'],
                    'email' => $ds['mail_addr'],
                    'question' => $ds['fpas_ques'],
                    'answer' => $ds['fpas_answ'],
                    'pass_verify' => $ds['memb__pwd2'],
                    'acl' => $ds['acl'],
                    'ban_login' => $ds['ban_login'],
                    'num_login' => $ds['num_login'],
                    'pass2' => $ds['pass2']
                );
            }
        }
    }

    if (getOption('debugSql')) {
        cn_write_log('MEMB_INFO', 'memb___id,memb__pwd,tel__numb,phon_numb,mail_addr,fpas_ques,fpas_answ,memb__pwd2,memb__pwdmd5,acl,ban_login,num_login,pass2', "memb___id='$username'");
    }

    return isset($pdata) ? $pdata : array();
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
                $pdata = array(
                    'user_name' => $ds['memb___id'],
                    'pass_web' => $ds['memb__pwdmd5'],
                    'memb__pwdmd5' => $ds['memb__pwdmd5'],
                    'pass_game' => $ds['memb__pwd'],
                    'tel_num' => $ds['tel__numb'],
                    'phon_num' => $ds['phon_numb'],
                    'email' => $ds['mail_addr'],
                    'question' => $ds['fpas_ques'],
                    'answer' => $ds['fpas_answ'],
                    'pass_verify' => $ds['memb__pwd2'],
                    'acl' => $ds['acl'],
                    'ban_login' => $ds['ban_login'],
                    'num_login' => $ds['num_login'],
                    'pass2' => $ds['pass2']
                );
            }
        }
    }

    if (getOption('debugSql')) {
        cn_write_log('MEMB_INFO', 'memb___id,memb__pwd,tel__numb,phon_numb,mail_addr,fpas_ques,fpas_answ,memb__pwd2,memb__pwdmd5,acl,ban_login,num_login,pass2', "memb___id='$username'");
    }

    return isset($pdata) ? $pdata : array();
}

/**
 * @param string $other
 * @param array $options
 * @return array|bool
 */
function do_select_other($other = '', $options = [])
{
    global $db_new;
    $rs_data = [];
    if ($other) {
        $other = trim($other);
        $check = $db_new->Execute($other) or cn_write_log($other, 'e');
        if ($check) {
            while ($row = $check->fetchrow()) {
                array_push($rs_data, $row);
            }
        }
    } else {
        return false;
    }

    if (isset($options['debugSql']) && $options['debugSql']) {
        cn_write_log($other);
    }

    return $rs_data;
}

/**
 * @param string $other
 * @return bool
 */
function do_update_other($other = '')
{
    global $db_new;

    if ($other) {
        $other = trim($other);
        $check = $db_new->Execute($other) or cn_write_log($other, 'e');

        if ($check) {
            if (getOption('debugSql')) {
                cn_write_log($other);
            }

            return true;
        }
    } else {
        return false;
    }
}

//'table','abc, abc2, ...','a1=1 and ab = 2 or ad =12,...',' orther ',
function do_select_character($table, $col, $where = '', $other = '')
{
    global $db_new;
    if (!$table) {
        return false;
    }
    $table = trim($table);
    $_col = separateString($col);

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
    if ($str_col[0] != '*') {
        $str_col = substr($str_col, 0, -1);
    }

    if ($where) {
        $where = trim($where);
        $str_where = "WHERE $where";
    } else {
        $str_where = $where;
    }

    if ($other) {
        $other = trim($other);
    }

    if ($str_col && $table) {
        $check = $db_new->Execute("SELECT $str_col FROM $table $str_where $other") or cn_write_log("SELECT $str_col FROM $table $str_where $other", 'e');
        if ($check) {
            while ($row = $check->fetchrow()) {
                $rs_data[] = $row;
            }
        }
    }

    if (getOption('debugSql')) {
        cn_write_log("SELECT $str_col FROM $table $str_where $other");
    }

    return isset($rs_data) ? $rs_data : array();
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

    // Get table array first
    $user_table = array_shift($args);
    // 1. name table update
    if (!$user_table) {
        return false;
    }

    // Format $v = [email=user_email]
    foreach ($args as $v) {
        list($a, $b) = explode('=', $v, 2);
        if ($a) {
            $cp_data[$a] = $b;
        }
    }

    if (!empty($cp_data)) {
        $key_ids = array_keys($cp_data);
    }

    if (!empty($key_ids)) {
        foreach ($key_ids as $v) {
            $gr_col .= "$v,";
        }
    }

    foreach ($cp_data as $key => $val) {
        $gr_cont .= "$val,";
    }

    if (strlen($gr_col) > 1) {
        $key_up_col = substr($gr_col, 0, -1);
    }

    if (strlen($gr_cont) > 1) {
        $val_up_cont = substr($gr_cont, 0, -1);
    }

    if ($key_up_col && $val_up_cont && $user_table) {

//        $db_new->BeginTrans();
        $check = $db_new->Execute("INSERT INTO $user_table ($key_up_col) VALUES ($val_up_cont)") or cn_write_log("INSERT INTO $user_table ($key_up_col) VALUES ($val_up_cont)", 'e');

        if ($check) {
            $db_new->CompleteTrans();

            if (getOption('debugSql')) {
                cn_write_log("INSERT INTO $user_table ($key_up_col) VALUES ($val_up_cont)");
            }

            return true;
        } else {
            $db_new->RollbackTrans();
        }
    }

    return false;
}

function do_insert_other($myQueryInsert)
{
    global $db_new;
    if (empty($myQueryInsert)) {
        return false;
    }

    $check = $db_new->Execute($myQueryInsert) or cn_write_log($myQueryInsert, 'e');

    if ($check) {
        $db_new->CompleteTrans();

        if (getOption('debugSql')) {
            cn_write_log($myQueryInsert);
        }
        return true;
    } else {
        $db_new->RollbackTrans();
    }

    return false;
}

// sign table, mutile cont (abc=abc1,...N, abc2:abc3... N)
//1. table => SQL
//2: ... n => Col = val		=> update SQL
//3. ... n => Col : val 	=> WHRER Contine (AND ... AND ...)
function do_update_character()
{
    global $db_new;
    $gr_col = $gr_cont = '';
    $args = func_get_args();                    //1.name, 2.email="user_email", 3.nick="$user_nic", 4.pass="24242424ggsgsgs"
    $user_table = array_shift($args);           // get name array frist

    if (!$user_table) {                            //1. name //table update/
        return false;
    }

    foreach ($args as $v) {                     //$v = [email=user_email] >, >=, <>, <, <=, (= :)
        if (strpos($v, '=') !== false) {
            $gr_col .= "$v,";
        } elseif (strpos($v, ':') !== false) {
            $df = str_replace(':', '=', $v);
            $gr_cont .= "$df AND ";
        } elseif (strpos($v, '>') !== false) {
            $gr_cont .= "$v AND ";
        } elseif (strpos($v, '>=') !== false) {
            $gr_cont .= "$v AND ";
        } elseif (strpos($v, '<>') !== false) {
            $gr_cont .= "$v AND ";
        } elseif (strpos($v, '<') !== false) {
            $gr_cont .= "$v AND ";
        } elseif (strpos($v, '<=') !== false) {
            $gr_cont .= "$df AND ";
        }

        //else continue;
    }

    if (strlen($gr_col) > 1) {
        $val_up_col = substr($gr_col, 0, -1);
    }
    if (strlen($gr_cont) > 5) {
        $val_up_cont = substr($gr_cont, 0, -5);
    }

    if ($val_up_col && $val_up_cont && $user_table) {
        $check = $db_new->Execute("UPDATE $user_table SET $val_up_col WHERE $val_up_cont") or cn_write_log("UPDATE $user_table SET $val_up_col WHERE $val_up_cont", 'e');
        if ($check) {
            if (getOption('debugSql')) {
                cn_write_log("UPDATE $user_table SET $val_up_col WHERE $val_up_cont");
            }
            return true;
        }
    }
    return false;
}


/**
 * @param $myQuery
 * @return bool
 */
function do_delete_char($myQuery)
{
    global $db_new;

    if ($myQuery) {
        $myQuery = trim($myQuery);
        $check = $db_new->Execute($myQuery) or cn_write_log($myQuery, 'e');
        if ($check) {
            if (getOption('debugSql')) {
                cn_write_log($myQuery);
            }
            return true;
        }
    } else {
        return false;
    }

    return false;
}


/**
 * @param $requestData
 * @return array|bool|null
 */
function db_get_member_account($requestData)
{
    $clause = @$requestData["clause"];
    $isCheck = @$requestData["isCheck"];
    $options = @$requestData["options"];
    if ($clause) {
        $usx = do_select_other("SELECT Top 1 * FROM Account_Info WHERE " . $clause . " ORDER BY ID DESC", $options);

        if (!is_array($usx) || !$usx || !count($usx)) {
            return null;
        }

        if ($isCheck) {
            if ($usx) {
                return true;
            } else {
                return false;
            }
        }
        $usx[0]['pass'] = $usx[0]['Pwd'];
        return $usx[0];
    }

    return null;
}

/**
 * return Query SQL auto update ranking column Top50
 */
function run_schedule_ranking_character_top()
{
    global $db_new;
    if (empty($db_new)) {
        echo "\n \t----------------------------------------------------------------- \n";
        echo "\t Loi, I need config DB after admin login in system \n";
        echo "\t-----------------------------------------------------------------";
        return;
    }
    $myQueryRankingTop = "SELECT Top 125 [Name] FROM Character ORDER BY relifes DESC, resets DESC, cLevel DESC";
    $resultRankingTop = do_select_other($myQueryRankingTop);

    if ($resultRankingTop) {
        do_update_character('Character', 'Top50=0', 'Top50>0');
        $myQueryUpdate = 'UPDATE Character SET top50 = CASE Name';
        foreach ($resultRankingTop as $key => $items) {
            $myQueryUpdate .= ' WHEN \'' . $items['Name'] . '\' THEN ' . ($key + 1);
        }
        $myQueryUpdate .= ' END';
        $checkUpdate = do_update_other($myQueryUpdate);
        //if (!$chekUpdate) cn_write_log($myQueryUpdate, 'e');
    }
}

function run_schedule_on_off_point_character()
{
    $checkResultOnOff = do_select_other("SELECT AccountID, [Name], [Uythac], [uythacoffline_stat], [PhutUyThacOn_dutru], [PhutUyThacOff_dutru], [PointUyThac]  FROM Character WHERE Uythac = 0 OR uythacoffline_stat = 0");
    $itemID = '';

    foreach ($checkResultOnOff as $k => $items) {
//        $myQueryUpdate = 'UPDATE Character SET PhutUyThacOn_dutru = Uythac, PhutUyThacOff_dutru = uythacoffline_stat, PointUyThac = CASE';
        $myQueryUpdate = 'UPDATE Character SET';

        $itemID .= '\'' . $items['Name'] . '\',';
        if ($items['Uythac'] == 0 && $items['uythacoffline_stat'] == 1) {
            // Status OFF
            $myQueryUpdate .= ' PhutUyThacOn_dutru = CASE';
            $myQueryUpdate .= ' WHEN Name=\'' . $items['Name'] . '\' AND Uythac=0 AND uythacoffline_stat=1 THEN ' . (($items['PhutUyThacOn_dutru'] > 0) ? floor($items['PhutUyThacOn_dutru'] * (0.95)) : 0);
            $myQueryUpdate .= ' END, PointUyThac = CASE';
            $myQueryUpdate .= ' WHEN Name=\'' . $items['Name'] . '\' AND Uythac=0 AND uythacoffline_stat=1 THEN ' . (($items['PointUyThac'] > 0) ? floor($items['PointUyThac'] * (0.9)) : 0);
        } elseif ($items['Uythac'] == 1 && $items['uythacoffline_stat'] == 0) {
            //Status ON
            $myQueryUpdate .= ' PhutUyThacOff_dutru = CASE';
            $myQueryUpdate .= ' WHEN Name=\'' . $items['Name'] . '\' AND Uythac=1 AND uythacoffline_stat=0 THEN ' . (($items['PhutUyThacOff_dutru'] > 0) ? floor($items['PhutUyThacOff_dutru'] * (0.95)) : 0);
            $myQueryUpdate .= ' END, PointUyThac = CASE';
            $myQueryUpdate .= ' WHEN Name=\'' . $items['Name'] . '\' AND Uythac=1 AND uythacoffline_stat=0 THEN ' . (($items['PointUyThac'] > 0) ? floor($items['PointUyThac'] * (0.9)) : 0);
        } elseif ($items['Uythac'] == 0 && $items['uythacoffline_stat'] == 0) {
            //None
            $myQueryUpdate .= ' PhutUyThacOn_dutru = CASE';
            $myQueryUpdate .= ' WHEN Name=\'' . $items['Name'] . '\' AND Uythac=0 AND uythacoffline_stat=0 THEN ' . (($items['PhutUyThacOn_dutru'] > 0) ? floor($items['PhutUyThacOn_dutru'] * (0.95)) : 0);
            $myQueryUpdate .= ' END, PhutUyThacOff_dutru = CASE';
            $myQueryUpdate .= ' WHEN Name=\'' . $items['Name'] . '\' AND Uythac=0 AND uythacoffline_stat=0 THEN ' . (($items['PhutUyThacOff_dutru'] > 0) ? floor($items['PhutUyThacOff_dutru'] * (0.95)) : 0);

            $myQueryUpdate .= ' END, PointUyThac = CASE';
            $myQueryUpdate .= ' WHEN Name=\'' . $items['Name'] . '\' AND Uythac=0 AND uythacoffline_stat=0 THEN ' . (($items['PointUyThac'] > 0) ? floor($items['PointUyThac'] * (0.9)) : 0);
        }

        $myQueryUpdate .= ' END WHERE Name =\'' . $items['Name'] . '\'';
        //echo $myQueryUpdate;
        $checkUpdate = do_update_other($myQueryUpdate);
        if (!$checkUpdate) {
            echo '--> Err Update - Uy Thac';
        }
    }
}

//-------------------------------------------------------------------------------------------------------------------------------
function check_change_cls($account, $character)
{
    global $db_new;
    $sql_doinv_check = $db_new->Execute("SELECT * FROM AccountCharacter WHERE Id='$account' AND GameIDC='$character'");
    if ($sql_doinv_check->numrows() > 0) {
        return false;
    }
    return true;
}

function check_card_number($card_num)
{
    if (preg_match("[^a-zA-Z0-9$]", $card_num)) {
        echo "Du lieu loi : $card_num . Chi duoc su dung ki tu a-z, A-Z va (1-9).";
        exit();
    }
}

function check_symbol_num($account)
{
    if (preg_match("[^0-9$]", $account)) {
        echo "Du lieu loi : $account . Chi duoc su dung so (1-9).";
        exit();
    }
}

function check_symbol($account)
{
    if (preg_match("[^a-zA-Z0-9_$]", $account)) {
        echo "Du lieu loi : $account . Chi duoc su dung ki tu a-z, A-Z, so (1-9) va dau _.";
        exit();
    }
}

function check_email_db($email)
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

function check_by_account($account)
{
    if (!empty($account)) {
        $username_check = do_select_character('MEMB_INFO', 'memb___id', "memb___id='$account'", '');
        if (count($username_check) < 1) {
            return true;
        }
    }
    return false;
}

function check_log_game($account)
{
    global $db_new;

    if (!empty($account)) {
        $sql_loggame_check = $db_new->Execute("SELECT * FROM MEMB_STAT WHERE memb___id='$account'");
        $loggame_check = $sql_loggame_check->numrows();
        if ($loggame_check < 1) {
            return true;
        } //echo "Tài khoản phải vào Game tạo ít nhất 1 nhân vật mới có thể đăng nhập.";
    }
    return false;
}

function check_block_account($account)
{
    global $db_new;

    if (!empty($account)) {
        $sql_blockacc_check = $db_new->Execute("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$account' AND bloc_code='1'");
        if (!$sql_blockacc_check) {
            return false;
        }
        $blockacc_check = $sql_blockacc_check->numrows();
        if ($blockacc_check > 0) {
            return true;
        }/// "Tài khoản đang bị khóa.";
    }
    return false;
}

function check_ques_ans($account, $question, $answer)
{
    global $db_new;
    $sql_ques_ans_check = $db_new->Execute("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$account' AND fpas_ques='$question' AND fpas_answ='$answer'");
    if (!$sql_ques_ans_check) {
        return '';
    }
    $ques_ans_check = $sql_ques_ans_check->numrows();
    if ($ques_ans_check <= 0) {
        echo "Câu hỏi hoặc câu trả lời bí mật không đúng.";
        exit();
    }
}

function check_alphabet_character($account, $character)
{
    global $db_new;
    $sql_name_check = $db_new->Execute("SELECT Name FROM Character WHERE Name='$character' AND AccountID = '$account'");
    $character_check = $sql_name_check->numrows();
    if ($character_check <= 0) {
        echo "$character : Tên nhân vật sai.";
        exit();
    }
}

function check_block_char($account, $character)
{
    global $db_new;
    $sql_block_check = $db_new->Execute("SELECT Name FROM Character WHERE Name='$character' AND CtlCode='" . PK_CTL_CODE_BLOCK . "' AND AccountID='$account'");
    $block_check = $sql_block_check->numrows();
    if ($block_check > 0) {
        echo "Nhân vật đang bị khóa.";
        exit();
    }
}

function check_change_account($account, $character)
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


function check_pass2($login, $pass2)
{
    global $db_new;
    $sql_pw_check = $db_new->Execute("SELECT * FROM MEMB_INFO WHERE pass2='$pass2' and memb___id='$login'");
    $pw_check = $sql_pw_check->numrows();
    if ($pw_check <= 0) {
        echo "Mật khẩu cấp 2 không đúng.";
        exit();
    }
}

function check_GM($account)
{
    //global $gm;
    global $db_new;

    if (!empty($account)) {
        $sql_gm_check = $db_new->Execute("SELECT * FROM Character WHERE AccountID='$account' AND (CtlCode=" . PK_CTL_CODE_GAME_MASTER_8 . " or CtlCode=" . PK_CTL_CODE_GAME_MASTER_8 . ")");
        $gm_check = $sql_gm_check->numrows();
        if ($gm_check <= 0) {
            return true;        // 'NoGM';
        }
    }

    return false;                            // 'isGM';
}

function check_ranking($account)
{
    //global $ranking;
    global $db_new;
    if (!empty($account)) {
        $sql_ranking_check = $db_new->Execute("SELECT * FROM Character WHERE AccountID='$account' AND (Resets>50 or Relifes>0 or cLevel>400)");
        $ranking_check = $sql_ranking_check->numrows();
        if ($ranking_check <= 0) {
            return true;
        }            //'NoRanking';
    }

    //'isRanking';
    return false;
}

function check_daily($account)
{
    global $dl;
    global $db_new;
    $sql_daily_check = $db_new->Execute("SELECT * FROM DaiLy WHERE accdl='$account'");
    $daily_check = $sql_daily_check->numrows();

    if ($daily_check <= 0) {
        $dl = 'NoDL';
    } else {
        $dl = 'isDL';
    }
}

function check_top_month($character)
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
            // End Nếu TOP1 tháng lớn hơn TOP1 tháng trong Character thì Update TOP
        }
    }
}

// --------------------------Forum--------------------------------//
/**
 * @param $other
 * @return array|bool
 */
function do_select_other_forum($other)
{
    global $DbForum;

    if (empty($DbForum)) {
        return;
    }

    if ($other) {
        $other = trim($other);
        $check = $DbForum->Execute("$other") or cn_write_log($other, 'e');
        if ($check) {
            while ($row = $check->fetchrow()) {
                $rs_data[] = $row;
            }
        }
    } else {
        return false;
    }

    return isset($rs_data) ? $rs_data : array();
}

/**
 * @param $other
 * @return bool
 */
function doUpdateOtherForum($other)
{
    global $DbForum;

    if (empty($DbForum)) {
        return;
    }

    $gr_col = $gr_cont = '';
    $args = func_get_args();            //1.name, 2.email="user_email", 3.nick="$user_nic", 4.pass="24242424ggsgsgs"
    $user_table = array_shift($args);        // get name array frist

    if (!$user_table) { //1. name //table update/
        return false;
    }

    foreach ($args as $v) {  //$v = [email=user_email] >, >=, <>, <, <=, (= :)
        if (strpos($v, '=') !== false) {
            $gr_col .= "$v,";
        } elseif (strpos($v, ':') !== false) {
            $df = str_replace(':', '=', $v);
            $gr_cont .= "$df AND ";
        } elseif (strpos($v, '>') !== false) {
            $gr_cont .= "$v AND ";
        } elseif (strpos($v, '>=') !== false) {
            $gr_cont .= "$v AND ";
        } elseif (strpos($v, '<>') !== false) {
            $gr_cont .= "$v AND ";
        } elseif (strpos($v, '<') !== false) {
            $gr_cont .= "$v AND ";
        } elseif (strpos($v, '<=') !== false) {
            $gr_cont .= "$v AND ";
        }

        //else continue;
    }

    if (strlen($gr_col) > 1) {
        $val_up_col = substr($gr_col, 0, -1);
    }
    if (strlen($gr_cont) > 5) {
        $val_up_cont = substr($gr_cont, 0, -5);
    }

    if ($val_up_col && $val_up_cont && $user_table) {
        $check = $DbForum->Execute("UPDATE $user_table SET $val_up_col WHERE $val_up_cont") or cn_write_log("UPDATE $user_table SET $val_up_col WHERE $val_up_cont", 'e');
        if ($check) {
            return true;
        }
    }
    return false;
}

/**
 * @param $myQuery
 * @return bool
 */
function doDeleteOtherForum($myQuery)
{
    global $DbForum;

    if (empty($DbForum)) {
        return;
    }

    if ($myQuery) {
        $myQuery = trim($myQuery);
        $check = $DbForum->Execute("$myQuery") or cn_write_log($myQuery, 'e');
        if ($check) {
            return true;
        }
    } else {
        return false;
    }

    return false;
}


function db_user_update()
{
    // TODO
}
