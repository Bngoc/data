<?php
/**
 * @param content
 * @param User
 * @param info
 * Retrun write log system error
 */
function cn_writelog($content, $info = '', $user = '')
{
    if (!isset($content)) {
        return false;
    }

    switch ($info) {
        case "w":
            $status = 'warnings';
            break;
        case "e":
            $status = 'error';
            break;
        default:
            $status = 'info';
            break;
    }
    $member = 'UNKNOWN';
    if (!isset($user)) {
        $member = member_get()['mu_Account'];
        if(!$member)
            $member = member_get()['mu_Gamer'];
    }

    if (($time = $_SERVER['REQUEST_TIME']) == '') {
        $time = ctime();
    }

    if (($remote_addr = $_SERVER['REMOTE_ADDR']) == '') {
        $remote_addr = "REMOTE_ADDR_UNKNOWN";
    }

    if (($request_uri = $_SERVER['REQUEST_URI']) == '') {
        $request_uri = "REQUEST_URI_UNKNOWN";
    }

    $date = date("Y-m-d H:i:s a", $time);

    if (!file_exists($ul = cn_path_construct(ROOT, '/admin/log/system/') . 'error_dump.log')) {
        fclose(fopen($ul, 'w+'));
    }
    if ($fd = @fopen($ul, "a")) {
        $result = fputcsv($fd, array($status, $date, $member, $remote_addr, $request_uri, $content), "\t");
        fclose($fd);

//        if($result > 0)
//            return array(status => true);
//        else
//            return array(status => false, message => 'Unable to write to '.$logfile.'!');
    }
//    else {
//        return array(status => false, message => 'Unable to open log '.$logfile.'!');
//    }
}

function echoArr($arr){
    echo '<pre>';
    var_dump($arr);
    echo '</pre>';
}