<?php
define("ewEncoding", "ISO-8859-1", true);

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

    if ($user){
        $member = $user;
    } else {
        $member = member_get()['mu_Account'];
        if(empty($member)) $member = member_get()['mu_Gamer'];
    }

    if (!isset($member) || empty($member)) $member = 'UNKNOWN';


    if (($remote_addr = $_SERVER['REMOTE_ADDR']) == '') {
        $remote_addr = "REMOTE_ADDR_UNKNOWN";
    }

    if (($request_uri = $_SERVER['REQUEST_URI']) == '') {
        $request_uri = "REQUEST_URI_UNKNOWN";
    }

    $date = date("Y-m-d H:i:s a", ctime());

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

function ewConvertToUtf8($str)
{
    return ewConvert(ewEncoding, "UTF-8", $str);
}

 function ewConvertFromUtf8($str)
 {
     $str = sanitizeTitle($str);
     return ewConvert("UTF-8", ewEncoding, $str);
 }
function ewConvert($from, $to, $str)
{
    if ($from != "" && $to != "" && $from != $to) {
        if (function_exists("iconv")) {
            return iconv($from, $to, $str);
        } elseif (function_exists("mb_convert_encoding")) {
            return mb_convert_encoding($str, $to, $from);
        } else {
            return $str;
        }
    } else {
        return $str;
    }
}

function sanitizeTitle($string) {
    if(!$string) return false;
    $utf8 = array(
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'd'=>'đ|Đ',
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );
    foreach($utf8 as $ascii=>$uni) $string = preg_replace("/($uni)/i",$ascii,$string);
    $string = utf8Url($string);
    return $string;
}

function utf8Url($string){
    $string = strtolower($string);
    $string = str_replace( "ß", "ss", $string);
    $string = str_replace( "%", "", $string);
    $string = preg_replace("/[^_a-zA-Z0-9 -]/", "",$string);
    $string = str_replace(array('%20', ' '), '-', $string);
    $string = str_replace("----","-",$string);
    $string = str_replace("---","-",$string);
    $string = str_replace("--","-",$string);
    return $string;
}

function echoArr($arr){
    echo '<pre>';
    var_dump($arr);
    echo '</pre>';
}