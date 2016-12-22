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

function cn_analysis_code32($string, $title, $price, $image_mh)
{
    if ($string == 'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF' ||
        $string == 'ffffffffffffffffffffffffffffffff' || strlen($string) != 32) {
        return '';
    }
    // analysis Item 32
    $id = hexdec(substr($string, 0, 2));                // Item ID
    $group = (hexdec(substr($string, 18, 2)) / 16);     // Item Type
    $option = hexdec(substr($string, 2, 2));            // Item Level/Skill/Option Data
    $durability = hexdec(substr($string, 4, 2));        // Item Durability
    $serial = substr($string, 6, 8);                    // Item SKey
    $exc_option = hexdec(substr($string, 14, 2));       // Item Excellent Info/ Option
    $ancient = hexdec(substr($string, 16, 2));          // Ancient data
    $harmony = hexdec(substr($string, 20, 2));

    $socket_slot[0] = hexdec(substr($string, 22, 2));    // Socket data
    $socket_slot[1] = hexdec(substr($string, 24, 2));    // Socket data
    $socket_slot[2] = hexdec(substr($string, 26, 2));    // Socket data
    $socket_slot[3] = hexdec(substr($string, 28, 2));    // Socket data
    $socket_slot[4] = hexdec(substr($string, 30, 2));    // Socket data

    // Điều chỉnh Item Thần
    if ($ancient == 4) $ancient = 5;
    if ($ancient == 9) $ancient = 10;
    // Kiểm tra Item có tuyệt chiêu
    if ($option < 128){
        $skill = '';
    } else {
        $skill = '<font color=#8CB0EA>Vũ khí có tuyệt chiêu</font><br>';
        $option = $option - 128;
    }
    // Kiểm tra Cấp độ Item
    $item_level = floor($option / 8);
    $option = $option - $item_level * 8;

    // Kiểm tra Item luck
    if ($option < 4){
        $luck = '';
    } else {
        $luck = '<font color=#8CB0EA>May Mắn (Tỉ lệ ép Ngọc Tâm Linh + 25%)<br>May Mắn (Sát thương tối đa + 5%)</font><br>';
        $option = $option - 4;
    }
    // Kiểm tra Excellent Option
    if ($exc_option >= 64) {
        $option += 4;
        $exc_option += -64;
    }
    if ($exc_option < 32) {
        $iopx6 = 0;
    } else {
        $iopx6 = 1;
        $exc_option += -32;
    }
    if ($exc_option < 16) {
        $iopx5 = 0;
    } else {
        $iopx5 = 1;
        $exc_option += -16;
    }
    if ($exc_option < 8) {
        $iopx4 = 0;
    } else {
        $iopx4 = 1;
        $exc_option += -8;
    }
    if ($exc_option < 4) {
        $iopx3 = 0;
    } else {
        $iopx3 = 1;
        $exc_option += -4;
    }
    if ($exc_option < 2) {
        $iopx2 = 0;
    } else {
        $iopx2 = 1;
        $exc_option += -2;
    }
    if ($exc_option < 1) {
        $iopx1 = 0;
    } else {
        $iopx1 = 1;
        $exc_option += -1;
    }

    if ($group < 6) $item_type = 0;
    else if ($group == 6) $item_type = 1;
    else if ($group < 12) $item_type = 2;
    else if ($group == 12 || ($group == 13 && $id == 30)) $item_type = 3;
    else if ($group == 13 && ($id == 8 || $id == 9 || $id == 21 || $id == 22 || $id == 23 || $id == 24 || $id == 39 || $id == 40 || $id == 41)) $item_type = 4;
    else if ($group == 13 && ($id == 12 || $id == 13 || $id == 25 || $id == 26 || $id == 27 || $id == 28)) $item_type = 5;
    else if ($group == 13 && $id == 37) $item_type = 6;
    else $item_type = null;
    $item_exc = '';

    switch ($item_type) {
        case 0 :
            $op1 = 'Tăng lượng MANA khi giết quái (MANA/8)';
            $op2 = 'Tăng lượng LIFE khi giết quái (LIFE/8)';
            $op3 = 'Tốc độ tấn công +7';
            $op4 = 'Tăng lực tấn công 2%';
            $op5 = 'Tăng lực tấn công (Cấp độ/20)';
            $op6 = 'Khả năng xuất hiện lực tấn công hoàn hảo +10%';
            $option_type = 'Tăng thêm sát thương';
            $option_bonus = $option * 4;
            break;
        case 1:
            $op1 = 'Lượng ZEN rơi ra khi giết quái +40%';
            $op2 = 'Khả năng xuất hiện phòng thủ hoàn hảo +10%';
            $op3 = 'Phản hồi sát thương +5%';
            $op4 = 'Giảm sát thương +4%';
            $op5 = 'Lượng MANA tối đa +4%';
            $op6 = 'Lượng HP tối đa +4%';
            $option_type = 'Tăng thêm phòng thủ';
            $option_bonus = $option * 5;
            break;
        case 2:
            $op1 = 'Lượng ZEN rơi ra khi giết quái +40%';
            $op2 = 'Khả năng xuất hiện phòng thủ hoàn hảo +10%';
            $op3 = 'Phản hồi sát thương +5%';
            $op4 = 'Giảm sát thương +4%';
            $op5 = 'Lượng MANA tối đa +4%';
            $op6 = 'Lượng HP tối đa +4%';
            $option_type = 'Tăng thêm phòng thủ';
            $option_bonus = $option * 4;
            $skill = '';
            break;
        case 3:
            $op1 = '+ 115 Lượng HP tối đa';
            $op2 = '+ 115 Lượng MP tối đa';
            $op3 = 'Khả năng loại bỏ phòng thủ đối phương +3%';
            $op4 = '+ 50 Lực hành động tối đa';
            $op5 = 'Tốc độ tấn công +7';
            $op6 = '';
            $option_type = 'Tự động hồi phục HP';
            $option_bonus = $option . '%';
            $skill = '';
            $nocolor = true;
            break;
        case 4:
            $op1 = 'Lượng HP tối đa 4%';
            $op2 = 'Lượng MANA tối đa 4%';
            $op3 = 'Giảm sát thương +4%';
            $op4 = 'Phản hồi sát thương +5%';
            $op5 = 'Khả năng xuất hiện phòng thủ hoàn hảo +10%';
            $op6 = 'Lượng ZEN rơi ra khi giết quái +40%';
            $option_type = 'Tự động hồi phục HP';
            $option_bonus = $option . '%';
            $skill = '';
            break;
        case 5:
            $op1 = 'Khả năng xuất hiện lực tấn công hoàn hảo +10%';
            $op2 = 'Tăng lực tấn công (Cấp độ/20)';
            $op3 = 'Tăng lực tấn công 2%';
            $op4 = 'Tốc độ tấn công +7';
            $op5 = 'Tăng lượng LIFE khi giết quái (LIFE/8)';
            $op6 = 'Tăng lượng MANA khi giết quái (MANA/8)';
            $option_type = 'Tự động hồi phục HP';
            $option_bonus = $option . '%';
            $skill = '';
            break;
        case 6:
            $op1 = 'Gia tăng mức phá hủy +10%<br>Tăng tốc độ di chuyển';
            $op2 = 'Gia tăng mức phòng thủ +10%<br>Tăng tốc độ di chuyển';
            $op3 = 'Tăng tốc độ di chuyển';
            $op4 = '';
            $op5 = '';
            $op6 = '';
            $option_type = '';
            $option_bonus = '';
            $skill = 'Tuyệt chiêu Bão Điện (MANA:50)';
            break;
        default:
            $op1 = '';
            $op2 = '';
            $op3 = '';
            $op4 = '';
            $op5 = '';
            $op6 = '';
            $option_type = '';
            $option_bonus = '';
            $skill = '';
            $nocolor = true;
    }
    if ($option_bonus != 0) $item_option = '<font color=#9AADD5>' . $option_type . ' +' . $option_bonus . '</font><br>'; else $item_option = '';
    if ($iopx1 == 1) $item_exc .= '<br>' . $op1;
    if ($iopx2 == 1) $item_exc .= '<br>' . $op2;
    if ($iopx3 == 1) $item_exc .= '<br>' . $op3;
    if ($iopx4 == 1) $item_exc .= '<br>' . $op4;
    if ($iopx5 == 1) $item_exc .= '<br>' . $op5;
    if ($iopx6 == 1) $item_exc .= '<br>' . $op6;

    $socket_type = array(
        1 => 'Lửa (Tăng tấn công/phép thuật (theo Level) + 20',
        2 => 'Lửa (Tăng tốc độ tấn công) + 7',
        3 => 'Lửa (Tăng tấn công/phép thuật tối đa) + 30',
        4 => 'Lửa (Tăng tấn công/phép thuật tối thiểu) + 20',
        5 => 'Lửa (Tăng tấn công/phép thuật) + 20',
        6 => 'Lửa (Giảm lượng AG khi dùng kỹ năng) + 40',
        11 => 'Nước (Tăng tỷ lệ phòng thủ) + 10',
        12 => 'Nước (Tăng sức phòng thủ) + 30',
        13 => 'Nước (Tăng khả năng phòng vệ của khiên) + 7',
        14 => 'Nước (Giảm sát thương) + 4',
        15 => 'Nước (Phản hồi sát thương) + 5',
        17 => 'Băng (Tăng khả năng hồi phục HP khi giết quái vật) + 8',
        18 => 'Băng (Tăng khả năng hồi phục Mana khi giết quái vật) + 8',
        19 => 'Băng (Tăng sức sát thương kỹ năng) + 37',
        20 => 'Băng (Tăng lực tấn công) + 25',
        21 => 'Băng (Tăng độ bền vật phẩm) + 30',
        22 => 'Gió (Tự động hồi phục HP) + 8',
        23 => 'Gió (Tăng HP tối đa) + 4',
        24 => 'Gió (Tăng Mana tối đa) + 4',
        25 => 'Gió (Tự động hồi phục Mana) + 7',
        26 => 'Gió (Tăng AG tối đa) + 25',
        27 => 'Gió (Tăng lượng AG) + 3',
        30 => 'Sét (Tăng sát thương hoàn hảo) + 15',
        31 => 'Sét (Tăng tỷ lệ sát thương hoàn hảo) + 10',
        32 => 'Sét (Tăng sát thương chí mạng) + 30',
        33 => 'Sét (Tăng tỷ lệ sát thương chí mạng) + 8',
        37 => 'Đất (Tăng thể lực) + 30',
        51 => 'Lửa (Tăng tấn công/phép thuật (theo Level) + 400',
        52 => 'Lửa (Tăng tốc độ đánh) + 1',
        53 => 'Lửa (Tăng tấn công/phép thuật tối đa) + 1',
        54 => 'Lửa (Tăng tấn công/phép thuật tối thiểu) + 1',
        55 => 'Lửa (Tăng tấn công/phép thuật) + 1',
        56 => 'Lửa (Giảm lượng AG khi dùng kỹ năng) + 1',
        61 => 'Nước (Tăng tỷ lệ phòng thủ) + 1',
        62 => 'Nước (Tăng sức phòng thủ) + 1',
        63 => 'Nước (Tăng khả năng phòng vệ của khiên) + 1',
        64 => 'Nước (Giảm sát thương) + 1',
        65 => 'Nước (Phản hồi sát thương) + 1',
        67 => 'Băng (Tăng khả năng hồi phục HP khi giết quái vật) + 49',
        68 => 'Băng (Tăng khả năng hồi phục Mana khi giết quái vật) + 49',
        69 => 'Băng (Tăng sức sát thương kỹ năng) + 1',
        70 => 'Băng (Tăng lực tấn công) + 1',
        71 => 'Băng (Tăng độ bền vật phẩm) + 1',
        72 => 'Gió (Tự động hồi phục HP) + 1',
        73 => 'Gió (Tăng HP tối đa) + 1',
        74 => 'Gió (Tăng Mana tối đa) + 1',
        75 => 'Gió (Tự động hồi phục Mana) + 1',
        76 => 'Gió (Tăng AG tối đa) + 1',
        77 => 'Gió (Tăng lượng AG) + 1',
        80 => 'Sét (Tăng sát thương hoàn hảo) + 1',
        81 => 'Sét (Tăng tỷ lệ sát thương hoàn hảo) + 1',
        82 => 'Sét (Tăng sát thương chí mạng) + 1',
        83 => 'Sét (Tăng tỷ lệ sát thương chí mạng) + 1',
        87 => 'Đất (Tăng thể lực) + 1',
        101 => 'Lửa (Tăng tấn công/phép thuật (theo Level) + 400',
        102 => 'Lửa (Tăng tốc độ đánh) + 1',
        103 => 'Lửa (Tăng tấn công/phép thuật tối đa) + 1',
        104 => 'Lửa (Tăng tấn công/phép thuật tối thiểu) + 1',
        105 => 'Lửa (Tăng tấn công/phép thuật) + 1',
        106 => 'Lửa (Giảm lượng AG khi dùng kỹ năng) + 1',
        111 => 'Nước (Tăng tỷ lệ phòng thủ) + 1',
        112 => 'Nước (Tăng sức phòng thủ) + 1',
        113 => 'Nước (Tăng sức phòng thủ Shield) + 1',
        114 => 'Nước (Giảm sát thương) + 1',
        115 => 'Nước (Phản hồi sát thương) + 1',
        117 => 'Băng (Tăng khả năng hồi phục HP khi giết quái vật) + 50',
        118 => 'Băng (Tăng khả năng hồi phục Mana khi giết quái vật) + 50',
        119 => 'Băng (Tăng sức sát thương kỹ năng) + 1',
        120 => 'Băng (Tăng lực tấn công) + 1',
        121 => 'Băng (Tăng độ bền vật phẩm) + 1',
        122 => 'Gió (Tự động hồi phục HP) + 1',
        123 => 'Gió (Tăng HP tối đa) + 1',
        124 => 'Gió (Tăng Mana tối đa) + 1',
        125 => 'Gió (Tự động hồi phục Mana) + 1',
        126 => 'Gió (Tăng AG tối đa) + 1',
        127 => 'Gió (Tăng lượng AG) + 1',
        130 => 'Sét (Tăng sát thương hoàn hảo) + 1',
        131 => 'Sét (Tăng tỷ lệ sát thương hoàn hảo) + 1',
        132 => 'Sét (Tăng sát thương chí mạng) + 1',
        133 => 'Sét (Tăng tỷ lệ sát thương chí mạng) + 1',
        137 => 'Đất (Tăng thể lực) + 1',
        151 => 'Lửa (Tăng tấn công/phép thuật (theo Level) + 400',
        152 => 'Lửa (Tăng tốc độ đánh) + 1',
        153 => 'Lửa (Tăng tấn công/phép thuật tối đa) + 1',
        154 => 'Lửa (Tăng tấn công/phép thuật tối thiểu) + 1',
        155 => 'Lửa (Tăng tấn công/phép thuật) + 1',
        156 => 'Lửa (Giảm lượng AG khi dùng kỹ năng) + 1',
        161 => 'Nước (Tăng tỷ lệ phòng thủ) + 1',
        162 => 'Nước (Tăng sức phòng thủ) + 1',
        163 => 'Nước (Tăng sức phòng thủ Shield) + 1',
        164 => 'Nước (Giảm sát thương) + 1',
        165 => 'Nước (Phản hồi sát thương) + 1',
        167 => 'Băng (Tăng khả năng hồi phục HP khi giết quái vật) + 51',
        168 => 'Băng (Tăng khả năng hồi phục Mana khi giết quái vật) + 51',
        169 => 'Băng (Tăng sức sát thương kỹ năng) + 1',
        170 => 'Băng (Tăng lực tấn công) + 1',
        171 => 'Băng (Tăng độ bền vật phẩm) + 1',
        172 => 'Gió (Tự động hồi phục HP) + 1',
        173 => 'Gió (Tăng HP tối đa) + 1',
        174 => 'Gió (Tăng Mana tối đa) + 1',
        175 => 'Gió (Tự động hồi phục Mana) + 1',
        176 => 'Gió (Tăng AG tối đa) + 1',
        177 => 'Gió (Tăng lượng AG) + 1',
        180 => 'Sét (Tăng sát thương hoàn hảo) + 1',
        181 => 'Sét (Tăng tỷ lệ sát thương hoàn hảo) + 1',
        182 => 'Sét (Tăng sát thương chí mạng) + 1',
        183 => 'Sét (Tăng tỷ lệ sát thương chí mạng) + 1',
        187 => 'Đất (Tăng thể lực) + 1',
        201 => 'Lửa (Tăng tấn công/phép thuật (theo Level) + 400',
        202 => 'Lửa (Tăng tốc độ đánh) + 1',
        203 => 'Lửa (Tăng tấn công/phép thuật tối đa) + 1',
        204 => 'Lửa (Tăng tấn công/phép thuật tối thiểu) + 1',
        205 => 'Lửa (Tăng tấn công/phép thuật) + 1',
        206 => 'Lửa (Giảm lượng AG khi dùng kỹ năng) + 1',
        211 => 'Nước (Tăng tỷ lệ phòng thủ) + 1',
        212 => 'Nước (Tăng sức phòng thủ) + 1',
        213 => 'Nước (Tăng sức phòng thủ Shield) + 1',
        214 => 'Nước (Giảm sát thương) + 1',
        215 => 'Nước (Phản hồi sát thương) + 1',
        217 => 'Băng (Tăng khả năng hồi phục HP khi giết quái vật) + 52',
        218 => 'Băng (Tăng khả năng hồi phục Mana khi giết quái vật) + 52',
        219 => 'Băng (Tăng sức sát thương kỹ năng) + 1',
        220 => 'Băng (Tăng lực tấn công) + 1',
        221 => 'Băng (Tăng độ bền vật phẩm) + 1',
        222 => 'Gió (Tự động hồi phục HP) + 1',
        223 => 'Gió (Tăng HP tối đa) + 1',
        224 => 'Gió (Tăng Mana tối đa) + 1',
        225 => 'Gió (Tự động hồi phục Mana) + 1',
        226 => 'Gió (Tăng AG tối đa) + 1',
        227 => 'Gió (Tăng lượng AG) + 1',
        230 => 'Sét (Tăng sát thương hoàn hảo) + 1',
        231 => 'Sét (Tăng tỷ lệ sát thương hoàn hảo) + 1',
        232 => 'Sét (Tăng sát thương chí mạng) + 1',
        233 => 'Sét (Tăng tỷ lệ sát thương chí mạng) + 1',
        237 => 'Đất (Tăng thể lực) + 1'
    );

    //Kểm tra Socket Item
    $item_socket = '';
    foreach ($socket_slot as $key => $val) {
        if ($val) {
            if ($val == 255) {
                $item_socket .= '<br>Socket '. ($key + 1) .': (Chưa khảm dòng socket)';
            } else {
                $item_socket .= '<br>Socket '. ($key + 1) .': '. $socket_type[$val];
            }
        }
    }

    $arrHarmony = array(
      16 => '2',
        17 => '3',
        18 => '4',
        19 => '5',
        20 => '6',
        21 => '7',
        22 => '9',
        23 => '11',
        24 => '12',
        25 => '14',
        26 => '15',
        27 => '16',
        28 => '17',
        29 => '20',
        30 => '100000',
        31 => '110000',
        32 => '3',
        33 => '4',
        34 => '5',
        35 => '6',
        36 => '7',
        37 => '8',
        38 => '10',
        39 => '12',
        40 => '14',
        41 => '17',
        42 => '20',
        43 => '23',
        44 => '26',
        45 => '29',
        46 => '100000',
        47 => '110000',
        48 => '6',
        49 => '8',
        50 => '10',
        51 => '12',
        52 => '14',
        53 => '16',
        54 => '20',
        55 => '23',
        56 => '26',
        57 => '29',
        58 => '32',
        59 => '35',
        60 => '37',
        61 => '40',
        62 => '100000',
        63 => '110000',
        64 => '6',
        65 => '8',
        66 => '10',
        67 => '12',
        68 => '14',
        69 => '16',
        70 => '20',
        71 => '23',
        72 => '26',
        73 => '29',
        74 => '32',
        75 => '35',
        76 => '37',
        77 => '40',
        78 => '100000',
        79 => '110000',
        80 => '0',
        81 => '0',
        82 => '0',
        83 => '0',
        84 => '0',
        85 => '0',
        86 => '7',
        87 => '8',
        88 => '9',
        89 => '11',
        90 => '12',
        91 => '14',
        92 => '16',
        93 => '19',
        94 => '0',
        95 => '0',
        96 => '0',
        97 => '0',
        98 => '0',
        99 => '0',
        100 => '0',
        101 => '0',
        102 => '12',
        103 => '14',
        104 => '16',
        105 => '18',
        106 => '20',
        107 => '22',
        108 => '24',
        109 => '30',
        110 => '0',
        111 => '0',
        112 => '0',
        113 => '0',
        114 => '0',
        115 => '0',
        116 => '0',
        117 => '0',
        118 => '0',
        119 => '0',
        120 => '0',
        121 => '12',
        122 => '14',
        123 => '16',
        124 => '18',
        125 => '22',
        126 => '0',
        127 => '0',
        128 => '0',
        129 => '0',
        130 => '0',
        131 => '0',
        132 => '0',
        133 => '0',
        134 => '0',
        135 => '0',
        136 => '0',
        137 => '5',
        138 => '7',
        139 => '9',
        140 => '11',
        141 => '14',
        142 => '0',
        143 => '0',
        144 => '0',
        145 => '0',
        146 => '0',
        147 => '0',
        148 => '0',
        149 => '0',
        150 => '0',
        151 => '0',
        152 => '0',
        153 => '3',
        154 => '5',
        155 => '7',
        156 => '9',
        157 => '10',
        158 => '0',
        159 => '0',
        160 => '0',
        161 => '0',
        162 => '0',
        163 => '0',
        164 => '0',
        165 => '0',
        166 => '0',
        167 => '0',
        168 => '0',
        169 => '0',
        170 => '0',
        171 => '0',
        172 => '0',
        173 => '10',
        174 => '0',
        175 => '0'
    );

    $item_harmony = '';
    if ($harmony < 32) $item_harmony .= 'Lực tấn công tồi thiểu + ';
    else if ($harmony < 48) $item_harmony .= 'Lực tấn công tồi đa + ';
    else if ($harmony < 64) $item_harmony .= 'Điểm Sức mạnh yêu cầu - ';
    else if ($harmony < 80) $item_harmony .= 'Điểm nhanh nhẹn yêu cầu - ';
    else if ($harmony < 96) $item_harmony .= 'Lực tấn công (tối đa, tối thiểu) + ';
    else if ($harmony < 112) $item_harmony .= 'Sát thương trọng kích + ';
    else if ($harmony < 128) $item_harmony .= 'Lực tấn công kĩ năng + ';
    else if ($harmony < 144) $item_harmony .= 'Tỷ lệ tấn công % + ';
    else if ($harmony < 160) $item_harmony .= 'Tỷ lệ SD + ';
    else if ($harmony < 176) $item_harmony .= 'Tỷ lệ loại bỏ SD + ';

    foreach ($arrHarmony as $key => $val) {
        if ($val == $harmony){
            $item_harmony .= $val;
            break;
        }
    }

    $items_data = getoption('#items_data');
echoArr($items_data);
    if (!in_array($group . '.' . $id, array_keys($items_data))) return false;

    $item_read = $items_data[$group . '.' . $id];

    //$item_read = ItemsData($id,$group,$item_level);
    // Tra ID và Group Item để lấy thông tin từ Items_Data.txt

    //'id' => $_item['ID'],
    //'group' => $_item['G'],
    // 'title' => $title,
    //'name' => $_item['Name'],
    //'price' => $price,
    //'image' => $_item['Image'],
    //'x' => $_item['X'],
    //'y' => $_item['Y'],
    //'set1' => $_item['SET1'],
    //'set2' => $_item['SET2'],

    //$item_image = $item_read['Image'];
    //$item_image = $item_read['Image'];
    //$item_image = $item_read['Image'];

    //$item_image = $item_read['Image'];
    $item_name = $item_read['Name'];
    //$item_x = $item_read['X'];
    //$item_y = $item_read['Y'];

    if ($ancient == 5) $ancient_set = $item_read['SET1'];
    else if ($ancient == 10) $ancient_set = $item_read['SET2'];

    //Xử lí màu Tên Item
    $color = 'while'; // White -> Normal Item
    if (($option > 1) || ($luck != '')) $color = '#8CB0EA';
    if ($item_level > 6) $color = '#F4CB3F';
    //$ExclAnci = 0;
    if ($item_type && $item_type == 6) {//Sói tinh
        $color = '#8CB0EA';
        if ($iopx1 == 1) {
            $item_name .= ' + Tấn công';
            //$ExclAnci = 1;
        }
        if ($iopx2 == 1) {
            $item_name .= ' + Phòng thủ';
            //$ExclAnci = 1;
        }
        if ($iopx3 == 1) {
            $item_name .= ' Hoàng Kim';
            $color = '#F4CB3F';
            //$ExclAnci = 1;
        }
    } else if ($item_exc != '') {//Item Excellent
        //Item Harmony
        if ($harmony > 0) $item_name = 'Tử Âm ' . $item_name;
        $item_name = 'Hoàn Hảo ' . $item_name;
        $color = '#2FF387';
        //$ExclAnci = 1;
    }
    // Item Thần
    if ($ancient > 0) {
        $item_name = 'Item Thần' . ' ' . $ancient_set . ' ' . $item_name;
        $color = '#2347F3';
        //$ExclAnci = 2;
    }
    // Item Socket
    if ($item_socket != '') {
        $color = '#AA1EAA';
    }
    //if ($nocolor) $color = '#F4CB3F';
    // Sử lí thông tin Item
    /*
	switch ($ExclAnci) {
		case 1:
			if (file_exists('images/items/EXE/'.$item_image.'.gif')) $item_image = "EXE/".$item_image;
			else $item_image = $item_image;
			break;
		case 2:
			if (file_exists('images/items/ANC/'.$item_image.'.gif')) $item_image = "ANC/".$item_image;
			else $item_image = $item_image;
			break;
		default: $item_image = $item_image; break;
	}
	*/
    //$item_image = ItemImage($id,$group,$ExclAnci,$item_level);

    if ($item_level == 0 || $durability == 0) $item_level = '';
    else $item_level = ' +' . $item_level;
    $serial = 'Serial: ' . $serial . '<br>';
    $durability = 'Độ bền: ' . $durability . '<br>';
    if ($harmony > 0) $item_harmony = '<font color=#C8C800>' . $item_harmony . '</font><br>'; else $item_harmony = '';
    $item_exc = '<font color=#2FF387>' . $item_exc . '</font><br>';
    $item_socket = '<font color=#AA1EAA>' . $item_socket . '</font><br>';
    $item_info = '<div class="_info" style="padding: 10px;"><center><strong><span style=color:#FFFEFE; font-size: 13px;><font color=' . $color . '>' . $item_name . $item_level . '</font><br>'
        . $serial
        . $durability
        . $luck
        . $skill
        . $item_option
        . $item_harmony
        . $item_exc
        . $item_socket . '</span></strong></center></div>';
    $output = array(
        'info' => $item_info,
        'name' => $item_name . "<font color=maroon> <i>(" . $title . ") </i></font>",// $item_read['Name'],
        'image' => $item_read['Image'],
        'x' => $item_read['X'],
        'y' => $item_read['Y'],
        'set1' => $item_read['SET1'],
        'set2' => $item_read['SET2'],
        'id' => $item_read['ID'],
        'group' => $item_read['G'],
        'title' => $title,
        'price' => $price,
        'code32' => $string,
        'image_mh' => $image_mh,
    );
    echoArr($output);
    return $output;
}