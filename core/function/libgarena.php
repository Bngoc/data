<?php
define("ewEncoding", "ISO-8859-1", true);

/*
	$paging = new pagintion_temp();

	$paging->class_pagination = "light-theme simple-pagination pagination";// ĐẶT CLASS CHO THÀNH PHẦN PHÂN TRANG THEO Ý MUỐN
	$paging->class_active = "current"; // TEN CLASS Active
	$paging-> page = $page;// TRANG HIỆN TẠI
    $paging-> total = $total; // TONG SO RECORD
    $paging-> per_page=$per_page; // SỐ RECORD TRÊN 1 TRANG default = 10
    $paging-> adjacents = $adjacents; // SỐ PAGE  CENTER DEFAULT = 3
    $paging-> name_page ='page'; // GET NAMEPAGE  LẤY GIÁ TRỊ PAGE THÔNG QUA PHƯƠNG THỨC POST OR GET
    $paging-> name_per_page ='per_page'; // GET NAMEPAGE  LẤY GIÁ TRỊ PAGE THÔNG QUA PHƯƠNG THỨC POST OR GET
    $paging-> cn_url_modify = 'mod=editnews';//	THÔNG SỐ SUA URL VOI FUNCTION CN_URL_MODIFY

	//goi...
	$get_paging= $paging->Load();
	*/

// PRE 1 2 3 ... 4 5 6 7 8 9 10 ... 13 14 NEXT 	// 14 PAGE
class pagintion_temp
{
    public $total; // TONG SO PAGE
    public $per_page = 10; // SỐ RECORD TRÊN 1 TRANG default = 10
    public $adjacents = 3; // SỐ PAGE  CENTER
    public $page; // SỐ PAGE
    public $name_page = 'page'; // GET NAME PAGE
    public $name_per_page = 'per_page'; // GET NAME PER PAGE
    public $url_modify = '';//cn_url_modify('mod=cashshop', '__item', '_id', 'do=action', "opt=".$opt);//	THÔNG SỐ SUA URL VOI FUNCTION CN_URL_MODIFY
    public $class_pagination = 'light-theme simple-pagination pagination'; // TÊN CÁC CLASS
    public $class_active = 'current'; // TEN CLASS Active
    public $isAjax = false;

    private $start;
    private $prev;
    private $next;
    private $lastpage;
    private $lpm1;
    private $variablesParam = '&amp;';
    private $nameAjax = 'href';

    public function Load()
    {

        //if($this->page)
        //$this -> start = ($this ->page - 1) * $this ->per_page; //first item to display on this page
        //else{
        //$this ->start = 0;
        //}

        /* Setup page vars for display. */
        if ($this->page == 0) $this->page = 1; //if no page var is given, default to 1.
        $this->prev = $this->page - 1; //previous page is $this->class_active page - 1
        $this->next = $this->page + 1; //next page is $this->class_active page + 1
        $this->lastpage = ceil($this->total / $this->per_page); //lastpage.
        $this->lpm1 = $this->lastpage - 1; //last page minus 1

        if ($this->url_modify == '') $this->variablesParam = '?';
        if ($this->isAjax) $this->nameAjax = 'fhref';

        /* CREATE THE PAGINATION */

        $pagination = "";
        if ($this->lastpage > 1) {
            $pagination .= "<div class='$this->class_pagination'> <ul>";

            if ($this->page > 1) {
                $pagination .= "<li><a $this->nameAjax=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $this->prev . " class='callAjax page-link prev' title='Prev'>Prev</a></li>";
            } elseif ($this->page == 1)
                $pagination .= "<li><a rel='nofollow' $this->nameAjax='' class='callAjax $this->class_active' title='Prev'>Prev</a></li>";

            if ($this->lastpage < 7 + ($this->adjacents * 2)) { // so trang < 13 = so bt hien thi
                for ($counter = 1; $counter <= $this->lastpage; $counter++) {
                    if ($counter == $this->page)
                        $pagination .= "<li><a rel='nofollow' $this->nameAjax='#' class='callAjax $this->class_active' title='Page number $counter'>$counter</a></li>";
                    else
                        $pagination .= "<li><a $this->nameAjax=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $counter . " class='callAjax page-link' title='Page number $counter'>$counter</a></li>";
                }
            } elseif ($this->lastpage > 5 + ($this->adjacents * 2)) { //enough pages to hide some so trang >11
                //close to beginning; only hide later pages
                if ($this->page < 1 + ($this->adjacents * 2)) { //  hien tai < 7...... => hientai 1 2 3 4 5 6 7 => hien 1 2 3 4 5 6 7 8 9
                    for ($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++) { //$counter < 9 + (2 tr cuoi)
                        if ($counter == $this->page)
                            $pagination .= "<li><a rel='nofollow' $this->nameAjax='#' class='callAjax $this->class_active' title='Page number $counter'>$counter</a></li>";
                        else
                            $pagination .= "<li><a $this->nameAjax=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $counter . " class='callAjax page-link' title='Page number $counter'>$counter</a></li>";
                    }

                    $pagination .= "<li>...</li>";
                    $pagination .= "<li><a $this->nameAjax=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $this->lpm1 . " class='callAjax page-link' title='Page number $this->lpm1'>$this->lpm1</a></li>";
                    $pagination .= "<li><a $this->nameAjax=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $this->lastpage . " class='callAjax page-link' title='Page number $this->lastpage'>$this->lastpage</a></li>";
                } //in middle; hide some front and some back
                elseif ($this->lastpage - ($this->adjacents * 2) > $this->page && $this->page > ($this->adjacents * 2)) { // so tr - 6 > hientai  hienta > 6

                    $pagination .= "<li><a $this->nameAjax=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . 1 . " class='callAjax page-link' title='1'>1</a></li>";        // trang dau 1
                    $pagination .= "<li><a $this->nameAjax=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . 2 . " class='callAjax page-link' title='2'>2</a></li>";        // trang thu 2
                    $pagination .= "<li>...</li>";
                    for ($counter = $this->page - $this->adjacents; $counter <= $this->page + $this->adjacents; $counter++) { // 1 2 3 hientai 5 6 7  (tong 7)

                        if ($counter == $this->page)
                            $pagination .= "<li><a rel='nofollow' $this->nameAjax='#' class='callAjax $this->class_active' title='Page number $counter'>$counter</a></li>";
                        else
                            $pagination .= "<li><a $this->nameAjax=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $counter . " class='callAjax page-link' title='Page number $counter'>$counter</a></li>";
                    }

                    $pagination .= "<li>...</li>";

                    $pagination .= "<li><a $this->nameAjax=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $this->lpm1 . " class='callAjax page-link' title='Page number $this->lpm1'>$this->lpm1</a></li>"; // trang cuoi - 1
                    $pagination .= "<li><a $this->nameAjax=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $this->lastpage . " class='callAjax page-link' title='Page number $this->lastpage'>$this->lastpage</a></li>";  // trang cuoi

                } //close to end; only hide early pages
                else {
                    $pagination .= "<li><a $this->nameAjax=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . 1 . " class='callAjax page-link' title='1'>1</a></li>";
                    $pagination .= "<li><a $this->nameAjax=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . 2 . " class='callAjaxpage-link' title='2'>2</a></li>";
                    $pagination .= "<li>...</li>";

                    for ($counter = $this->lastpage - (2 + ($this->adjacents * 2)); $counter <= $this->lastpage; $counter++) {  // chi so = tong - 8; chi so < tong class="$this->class_active"
                        if ($counter == $this->page) {
                            $pagination .= "<li><a rel='nofollow' $this->nameAjax='#' class='callAjax $this->class_active' title='Page number $counter'>$counter</a></li>";
                        } else {
                            $pagination .= "<li><a $this->nameAjax=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $counter . " class='callAjax page-link' title='Page number $counter'>$counter</a></li>";
                        }
                    }
                }
            }

            //next button
            if (($this->page >= 1) && $this->page < $this->lastpage) {
                $pagination .= "<li><a $this->nameAjax=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $this->next . " class='callAjax page-link' title='Next'>Next</a></li>";
            } elseif ($this->page == $this->lastpage) {
                $pagination .= "<li><a rel='nofollow' $this->nameAjax='' class='callAjax $this->class_active' title='Next'>Next</a></li>";
            }

            $pagination .= "</ul></div>\n";
        }
        return $pagination;
    }
}

/**
 * @param $array
 * @param $_url
 * @param $page
 * @param $per_page
 * @param int $adjacents
 * @param string $name_per_page
 * @param string $name_page
 * @param string $class_active
 * @param string $class_pagination
 * @return array
 */
function cn_arr_pagina($array, $_url, $page, $per_page, $adjacents = 3, $name_per_page = 'per_page', $name_page = 'page', $class_active = 'current', $class_pagination = 'light-theme simple-pagination pagination')
{
    //$paging-> total = $total = count($array); // TONG SO PAGE
    //$paging-> cn_url_modify = $cn_url_modify;
    $arr = array();
    $paging = new pagintion_temp();

    $paging->class_pagination = $class_pagination;// ĐẶT CLASS CHO THÀNH PHẦN PHÂN TRANG THEO Ý MUỐN
    $paging->class_active = $class_active; // TEN CLASS Active
    $paging->page = $page;        // TRANG
    $paging->total = $total = count($array); // TONG SO RECODE
    $paging->per_page = $per_page; // SỐ RECODE TRÊN 1 TRANG default = 10
    $paging->adjacents = $adjacents; // SỐ PAGE  CENTER DEFAULT = 3
    $paging->name_page = $name_page; // GET NAMEPAGE  LẤY GIÁ TRỊ PAGE THÔNG QUA PHƯƠNG THỨC POST OR GET
    $paging->name_per_page = $name_per_page; // GET NAMEPAGE  LẤY GIÁ TRỊ PAGE THÔNG QUA PHƯƠNG THỨC POST OR GET
    $paging->url_modify = $_url;//	THÔNG SỐ SUA URL VOI FUNCTION CN_URL_MODIFY

    if ($page <= 0) $page_end = $per_page;
    else if ($page != 0) $page_end = $per_page * $page;

    $page_frist = (--$page_end) - $per_page;

    $_id = 0;
    //for($id = 0; $id < $total; $id++){
    foreach ($array as $key => $raw) {
        //if($id > $page_end) break;
        if ($page_frist < $_id && $_id <= $page_end) $arr[$key] = $array[$key];
        ++$_id;
    }

    //goi...
    $get_paging = $paging->Load();

    return array($arr, $get_paging);
}

function cn_arr_paginaAjax($array, $_url, $page, $per_page, $isCallAjax = true, $adjacents = 3, $name_per_page = 'per_page', $name_page = 'page', $class_active = 'current', $class_pagination = 'light-theme simple-pagination pagination')
{
    $arr = array();
    $paging = new pagintion_temp();

    $paging->class_pagination = $class_pagination;  // ĐẶT CLASS CHO THÀNH PHẦN PHÂN TRANG THEO Ý MUỐN
    $paging->class_active = $class_active;          // TEN CLASS Active
    $paging->page = $page;                          // TRANG
    $paging->total = $total = count($array);        // TONG SO RECODE
    $paging->per_page = $per_page;                  // SỐ RECODE TRÊN 1 TRANG default = 10
    $paging->adjacents = $adjacents;                // SỐ PAGE  CENTER DEFAULT = 3
    $paging->name_page = $name_page;                // GET NAMEPAGE  LẤY GIÁ TRỊ PAGE THÔNG QUA PHƯƠNG THỨC POST OR GET
    $paging->name_per_page = $name_per_page;        // GET NAMEPAGE  LẤY GIÁ TRỊ PAGE THÔNG QUA PHƯƠNG THỨC POST OR GET
    $paging->url_modify = $_url;                    //	THÔNG SỐ SUA URL VOI FUNCTION CN_URL_MODIFY
    $paging->isAjax = $isCallAjax;                  //	Call Ajax

    if ($page <= 0) $page_end = $per_page;
    else if ($page != 0) $page_end = $per_page * $page;

    $page_frist = (--$page_end) - $per_page;

    $_id = 0;
    foreach ($array as $key => $raw) {
        if ($page_frist < $_id && $_id <= $page_end) $arr[$key] = $array[$key];
        ++$_id;
    }

    $get_paging = $paging->Load();

    return array($arr, $get_paging);
}

/**
 * @param $countArray
 * @param $_url
 * @param $page
 * @param $per_page
 * @param int $adjacents
 * @param string $name_per_page
 * @param string $name_page
 * @param string $class_active
 * @param string $class_pagination
 * @return string
 */
function cn_countArr_pagination($countArray, $_url, $page, $per_page, $adjacents = 3, $name_per_page = 'per_page', $name_page = 'page', $class_active = 'current', $class_pagination = 'light-theme simple-pagination pagination')
{
    $paging = new pagintion_temp();

    $paging->class_pagination = $class_pagination;// ĐẶT CLASS CHO THÀNH PHẦN PHÂN TRANG THEO Ý MUỐN
    $paging->class_active = $class_active; // TEN CLASS Active
    $paging->page = $page;        // TRANG
    $paging->total = $countArray; // TONG SO RECODE
    $paging->per_page = $per_page; // SỐ RECODE TRÊN 1 TRANG default = 10
    $paging->adjacents = $adjacents; // SỐ PAGE  CENTER DEFAULT = 3
    $paging->name_page = $name_page; // GET NAMEPAGE  LẤY GIÁ TRỊ PAGE THÔNG QUA PHƯƠNG THỨC POST OR GET
    $paging->name_per_page = $name_per_page; // GET NAMEPAGE  LẤY GIÁ TRỊ PAGE THÔNG QUA PHƯƠNG THỨC POST OR GET
    $paging->url_modify = $_url; //	THÔNG SỐ SUA URL VOI FUNCTION CN_URL_MODIFY

    return $paging->Load();
}

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

    if ($user) {
        $member = $user;
    } else {
        if (isset($_SESSION['mu_Account'])) {
            $member = $_SESSION['mu_Account'];
            if (empty($member)) $member = $_SESSION['mu_Gamer'];
        }
    }

    if (empty($member)) $member = 'UNKNOWN';

    if (isset($_SERVER['REMOTE_ADDR'])) {
        if (($remote_addr = $_SERVER['REMOTE_ADDR']) == '') {
            $remote_addr = "REMOTE_ADDR_UNKNOWN";
        }
    } else {
        $remote_addr = 'REMOTE_ADDR_UNKNOWN';
    }

    if (isset($_SERVER['REQUEST_URI'])) {
        if (($request_uri = $_SERVER['REQUEST_URI']) == '') {
            $request_uri = "REQUEST_URI_UNKNOWN";
        }
    } else {
        $request_uri = "REQUEST_URI_UNKNOWN";
    }

    $date = date("Y-m-d H:i:s a", ctime());
    $ul = ROOT . "/admin/log/system/error_dump.log";
    cn_touch($ul);
    $fileContents = file_get_contents($ul);
    file_put_contents($ul, $status . "\t" . $date . "\t" . $member . "\t" . $remote_addr . "\t" . $request_uri . "\t" . $content . "\n" . $fileContents);

//    if (!file_exists($ul = cn_path_construct(ROOT, '/admin/log/system/') . 'error_dump.log')) {
//        fclose(fopen($ul, 'w+'));
//    }
//    if ($fd = @fopen($ul, "a")) {
//        $result = fputcsv($fd, array($status, $date, $member, $remote_addr, $request_uri, $content), "\t");
//        fclose($fd);
//    }
}

function cn_ewConvertToUtf8($str)
{
    return cn_ewConvert(ewEncoding, "UTF-8", $str);
}

function cn_ewConvertFromUtf8($str)
{
    $str = cn_sanitizeTitle($str);
    return cn_ewConvert("UTF-8", ewEncoding, $str);
}

function cn_ewConvert($from, $to, $str)
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

function cn_sanitizeTitle($string)
{
    if (!$string) return false;
    $utf8 = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'd' => 'đ|Đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );
    foreach ($utf8 as $ascii => $uni) $string = preg_replace("/($uni)/i", $ascii, $string);
    $string = cn_utf8Url($string);
    return $string;
}

function cn_utf8Url($string)
{
    $string = strtolower($string);
    $string = str_replace("ß", "ss", $string);
    $string = str_replace("%", "", $string);
    $string = preg_replace("/[^_a-zA-Z0-9 -]/", "", $string);
    $string = str_replace(array('%20', ' '), '-', $string);
    $string = str_replace("----", "-", $string);
    $string = str_replace("---", "-", $string);
    $string = str_replace("--", "-", $string);
    return $string;
}

function echoArr($arr)
{
    echo '<pre>';
    var_dump($arr);
    echo '</pre>';
}

function mcs()
{
    global $dbg_microtime;
    $dbg_microtime = microtime(1);
}

function mce()
{
    global $dbg_microtime;
    dbg("Microtime: " . (microtime(1) - $dbg_microtime));
    $dbg_microtime = microtime(1);
}

// Since 2.0: Since time format
function time_since_format($diff)
{
    $out = array();

    if ($diff > 31557600) {
        $out['y'] = intval($diff / 31557600);
        $diff %= 31557600;
    } // years
    if ($diff > 2629800) {
        $out['mon'] = intval($diff / 2629800);
        $diff %= 2629800;
    } // month
    if ($diff > 86400) {
        $out['d'] = intval($diff / 86400);
        $diff %= 86400;
    } // days
    if ($diff > 3600) {
        $out['h'] = intval($diff / 3600);
        $diff %= 3600;
    } // hours
    if ($diff > 60) {
        $out['m'] = intval($diff / 60);
        $diff %= 60;
    } // minutes
    if ($diff > 0) {
        $out['s'] = $diff;
    } // seconds

    return $out;
}

function cn_analysis_code32($string, $title, $price, $image_mh)
{
    if ($string == 'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF' ||
        $string == 'ffffffffffffffffffffffffffffffff' || strlen($string) != 32
    ) {
        return '';
    }
    // analysis Item 32
    $id = hexdec(substr($string, 0, 2));                        // Item ID
    $group = hexdec(substr($string, 18, 2));                    // Item Type
    $group = $group / 16;                                       // Item Type
    $option = hexdec(substr($string, 2, 2));                    // Item Level/Skill/Option Data
////----------------------------------------------------
    $optionTemp = hexdec(substr($string, 2, 2));              // Item Level/Skill/Option Data
    $optionClone1 = floor($optionTemp / 8);
    $optionClone = ceil($optionClone1 % 8);

    if ($optionClone) {
        $optionTemp14 = floor(hexdec(substr($string, 14, 2)) / 8);
        $optionTemp14Clone = ceil($optionTemp14 % 8);
        $optionClone = abs($optionClone - $optionTemp14Clone);
    }
//    echo 'substr2 -> ' . substr($string, 2, 2) .' -Item22 -> ' . $optionTemp . '  -sub14=> ' . substr($string, 14, 2) . '  -Temp14-> ' . $optionTemp14 . '  -optionClone-> ' .  $optionClone . '<br>';
//    //----------------------------------------------------
//

    $durability = hexdec(substr($string, 4, 2));                // Item Durability
    $serial = substr($string, 6, 8);                            // Item SKey
    $exc_option = hexdec(substr($string, 14, 2));               // Item Excellent Info/ Option
    $ancient = hexdec(substr($string, 16, 2));                  // Ancient data
    $harmony = hexdec(substr($string, 20, 2));

    $socket_slot[0] = hexdec(substr($string, 22, 2));           // Socket data
    $socket_slot[1] = hexdec(substr($string, 24, 2));           // Socket data
    $socket_slot[2] = hexdec(substr($string, 26, 2));           // Socket data
    $socket_slot[3] = hexdec(substr($string, 28, 2));           // Socket data
    $socket_slot[4] = hexdec(substr($string, 30, 2));           // Socket data

    $output = array(
        'info' => '',
        'name' => '',
        'image' => '',
        'x' => '',
        'y' => '',
        'set1' => '',
        'set2' => '',
        'id' => '',
        'group' => '',
        'title' => '',
        'price' => '',
        'code32' => '',
        'image_mh' => ''
    );
    $items_data = getoption('#items_data');
    if (!isset($items_data[$group . '.' . $id])) return $output;
    //if (!in_array($group . '.' . $id, array_keys($items_data))) return array();
    //$rendeImg = renderImageItencode($group, $id);

    // Điều chỉnh Item Thần
    if ($ancient == 4) $ancient = 5;
    if ($ancient == 9) $ancient = 10;
    // Kiểm tra Item có tuyệt chiêu
    if ($option < 128) {
        $skill = '';
    } else {
        $skill = '<font color=#8CB0EA>Vũ khí có tuyệt chiêu</font><br>';
        $option = $option - 128;
    }
    // Kiểm tra Cấp độ Item
    $item_level = floor($option / 8);
    $option = $option - $item_level * 8;

    // Kiểm tra Item luck
    if ($option < 4) {
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
                $item_socket .= '<br>Socket ' . ($key + 1) . ': (Chưa khảm dòng socket)';
            } elseif (!empty($val)) {
                $item_socket .= '<br>Socket ' . ($key + 1) . ': ' . $socket_type[$val];
            }
        }
    }

    $arrHarmony = array(
        0 => array(
            16 => '2', 17 => '3', 17 => '3', 18 => '4',
            19 => '5', 20 => '6', 21 => '7', 22 => '9',
            23 => '11', 24 => '12', 25 => '14', 26 => '15',
            27 => '16', 28 => '17', 29 => '20', 30 => '100000', 31 => '110000'
        ),
        1 => array(
            32 => '3', 33 => '4', 34 => '5', 35 => '6',
            36 => '7', 37 => '8', 38 => '10', 39 => '12',
            40 => '14', 41 => '17', 42 => '20', 43 => '23',
            44 => '26', 45 => '29', 46 => '100000', 47 => '110000'
        ),
        2 => array(
            48 => '6', 49 => '8', 50 => '10', 51 => '12',
            52 => '14', 53 => '16', 54 => '20', 55 => '23',
            56 => '26', 57 => '29', 58 => '32', 59 => '35',
            60 => '37', 61 => '40', 62 => '100000', 63 => '110000'
        ),
        3 => array(
            64 => '6', 65 => '8', 66 => '10', 67 => '12',
            68 => '14', 69 => '16', 70 => '20', 71 => '23',
            72 => '26', 73 => '29', 74 => '32', 75 => '35',
            76 => '37', 77 => '40', 78 => '100000', 79 => '110000'
        ),
        4 => array(
            80 => '0', 81 => '0', 82 => '0', 83 => '0',
            84 => '0', 85 => '0', 86 => '7', 87 => '8',
            88 => '9', 89 => '11', 90 => '12', 91 => '14',
            92 => '16', 93 => '19', 94 => '0', 95 => '0'
        ),
        5 => array(
            96 => '0', 97 => '0', 98 => '0', 99 => '0',
            100 => '0', 101 => '0', 102 => '12', 103 => '14',
            104 => '16', 105 => '18', 106 => '20', 107 => '22',
            108 => '24', 109 => '30', 110 => '0', 111 => '0'
        ),
        6 => array(
            112 => '0', 113 => '0', 114 => '0', 115 => '0',
            116 => '0', 117 => '0', 118 => '0', 119 => '0',
            120 => '0', 121 => '12', 122 => '14', 123 => '16',
            124 => '18', 125 => '22', 126 => '0', 127 => '0'
        ),
        7 => array(
            128 => '0', 129 => '0', 130 => '0', 131 => '0',
            132 => '0', 133 => '0', 134 => '0', 135 => '0',
            136 => '0', 137 => '5', 138 => '7', 139 => '9',
            140 => '11', 141 => '14', 142 => '0', 143 => '0'
        ),
        8 => array(
            144 => '0', 145 => '0', 146 => '0', 147 => '0',
            148 => '0', 149 => '0', 150 => '0', 151 => '0',
            152 => '0', 153 => '3', 154 => '5', 155 => '7',
            156 => '9', 157 => '10', 158 => '0', 159 => '0'
        ),
        9 => array(
            160 => '0', 161 => '0', 162 => '0', 163 => '0',
            164 => '0', 165 => '0', 166 => '0', 167 => '0',
            168 => '0', 169 => '0', 170 => '0', 171 => '0',
            172 => '0', 173 => '10', 174 => '0', 175 => '0'
        )
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

    foreach ($arrHarmony as $key => $its) {
        foreach ($its as $k => $val) {
            if ($k == $harmony) {
                $item_harmony .= $val;
                break;
            }
        }
    }

    $item_read = $items_data[$group . '.' . $id];

    $item_name = $item_read['Name'];
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
        }
        if ($iopx2 == 1) {
            $item_name .= ' + Phòng thủ';
        }
        if ($iopx3 == 1) {
            $item_name .= ' Hoàng Kim';
            $color = '#F4CB3F';
        }
    } else if ($item_exc != '') {//Item Excellent
        //Item Harmony
        if ($harmony > 0) $item_name = 'Tử Âm ' . $item_name;
        $item_name = 'Hoàn Hảo ' . $item_name;
        $color = '#2FF387';
    }
    // Item Thần
    if ($ancient > 0) {
        $item_name = 'Item Thần' . ' ' . $ancient_set . ' ' . $item_name;
        $color = '#2347F3';
    }
    // Item Socket
    if ($item_socket != '') {
        $color = '#AA1EAA';
    }

    if ($item_level == 0 || $durability == 0) $item_level = '';
    else $item_level = ' +' . $item_level;
    $serial = 'Serial: ' . $serial . '<br>';
    $durability = 'Độ bền: ' . $durability . '<br>';
    if ($harmony > 0) $item_harmony = '<font color=#C8C800>' . $item_harmony . '</font><br>'; else $item_harmony = '';
    $item_exc = '<font color=#2FF387>' . $item_exc . '</font><br>';
    $item_socket = '<font color=#AA1EAA>' . $item_socket . '</font><br>';
    $item_info = '<div class="_info" style="padding: 10px;"><center><strong><span style=color:#FFFEFE; font-size: 13px;>';
    $item_info .= '<font color=' . $color . '>' . $item_name . $item_level . '</font><br>'
        . $serial . $durability . $luck . $skill . $item_option . $item_harmony . $item_exc . $item_socket . '</span></strong></center></div>';

    $output['info'] = $item_info;
    $output['name'] = $item_name . "<font color=maroon> <i>(" . $title . ") </i></font>";
    $output['image'] = cn_renderImageItemCode($group, $id, $optionClone);
    $output['x'] = $item_read['X'];
    $output['y'] = $item_read['Y'];
    $output['set1'] = $item_read['SET1'];
    $output['set2'] = $item_read['SET2'];
    $output['id'] = $item_read['ID'];
    $output['group'] = $item_read['G'];
    $output['title'] = $title;
    $output['price'] = $price;
    $output['code32'] = $string;
    $output['image_mh'] = $image_mh;
    $output['option'] = $optionClone;

    return $output;
}

function cn_getCodeItem($string = '')
{
    $output = array('id' => '', 'group' => '', 'level' => '', 'serial' => '');
    if (empty($string) || strlen($string) != 32) {
        return $output;
    }
    // Phân tich Mã Item 32 số
    $id = hexdec(substr($string, 0, 2));    // Item ID
    $group = hexdec(substr($string, 18, 2));    // Item Type
    $group = $group / 16;
    $option = hexdec(substr($string, 2, 2));    // Item Level/Skill/Option Data
    $level = floor($option / 8);

    $serial = substr($string, 6, 8);

    $output['id'] = $id;
    $output['group'] = $group;
    $output['level'] = $level;
    $output['serial'] = $serial;

    return $output;
}

function cn_CheckSlotWarehouse($warehouse, $itemX, $itemY)
{
    $items_data = getoption('#items_data');
    $a = array();
    for ($c = 0; $c < 8; $c++) {
        for ($r = 0; $r < 15; $r++) {
            $a[$r][$c] = 0;
        }
    }

    $lenghtwarehouse = strlen($warehouse);
    $_idY = 0;
    $_idX = -1;
    for ($c = 0; $c < $lenghtwarehouse; $c += 32) {
        $res = substr($warehouse, $c, 32);

        if ($_idY % 8 == 0) {
            ++$_idX;
            $_idY = 0;
        }
        $item32 = cn_getCodeItem($res);
        if (isset($items_data[$item32['group'] . '.' . $item32['id']])) {
            $item_data = $items_data[$item32['group'] . '.' . $item32['id']];
            for ($jt = 0; $jt < $item_data['X']; $jt++) {
                for ($it = 0; $it < $item_data['Y']; $it++) {
                    $a[$_idX + $it][$_idY + $jt] = 1;
                }
            }
        }
        ++$_idY;
    }

    $paramentX = $itemX;
    $paramentY = $itemY;
    $ValueResult = array();

    for ($i = 0; $i < 15; $i++) {
        for ($j = 0; $j < 8; $j++) {
            $checkFrist = false;
            if (!$checkFrist) {
                $checkValueResult = array('resultX' => $i, 'resultY' => $j);
                $checkFrist = true;
            }
            if ($a[$i][$j] == 0 && (($paramentY + $i) <= 15) && (8 >= ($j + $paramentX))) {
                for ($x = 0; $x < $paramentX; $x++) {
                    for ($_y = 0; $_y < $paramentY; $_y++) {
                        if ($paramentX > $paramentX) {
                            if ($a[$x + $i][$_y + $j] == 1) {
                                $checkXY = false;
                                break;
                            }
                            if ($a[$x + $i][$_y + $j] == 0) {
                                $checkXY = true;
                            }
                        } else {
                            if ($a[$_y + $i][$x + $j] == 1) {
                                $checkXY = false;
                                break;
                            }
                            if ($a[$_y + $i][$x + $j] == 0) {
                                $checkXY = true;
                            }
                        }
                    }
                }

                if ($checkXY) {
                    $ValueResult = $checkValueResult;
                    break;
                }
            }
        }
        if ($checkXY) {
            break;
        }
    }
    if (empty($ValueResult)) return 3840;
    $result = $ValueResult['resultX'] * 8 + $ValueResult['resultY'];

    return $result;
}

function cn_CheckSlotInventory($inventory, $itemX, $itemY)
{
    $items_data = getoption('#items_data');
    $a = array();
    for ($c = 0; $c < 8; $c++) {
        for ($r = 0; $r < 8; $r++) {
            $a[$r][$c] = 0;
        }
    }

    $lenghtwarehouse = strlen($inventory);
    $_idY = 0;
    $_idX = -1;
    for ($c = 0; $c < $lenghtwarehouse; $c += 32) {
        $res = substr($inventory, $c, 32);

        if ($_idY % 8 == 0) {
            ++$_idX;
            $_idY = 0;
        }
        $item32 = cn_getCodeItem($res);
        if (isset($items_data[$item32['group'] . '.' . $item32['id']])) {
            $item_data = $items_data[$item32['group'] . '.' . $item32['id']];
            for ($jt = 0; $jt < $item_data['X']; $jt++) {
                for ($it = 0; $it < $item_data['Y']; $it++) {
                    $a[$_idX + $it][$_idY + $jt] = 1;
                }
            }
        }
        ++$_idY;
    }

    $paramentX = $itemX;
    $paramentY = $itemY;
    $ValueResult = array();

    for ($i = 0; $i < 8; $i++) {
        for ($j = 0; $j < 8; $j++) {
            $checkFrist = false;
            if (!$checkFrist) {
                $checkValueResult = array('resultX' => $i, 'resultY' => $j);
                $checkFrist = true;
            }
            if ($a[$i][$j] == 0 && (($paramentY + $i) <= 8) && (8 >= ($j + $paramentX))) {
                for ($x = 0; $x < $paramentX; $x++) {
                    for ($_y = 0; $_y < $paramentY; $_y++) {
                        if ($paramentX > $paramentX) {
                            if ($a[$x + $i][$_y + $j] == 1) {
                                $checkXY = false;
                                break;
                            }
                            if ($a[$x + $i][$_y + $j] == 0) {
                                $checkXY = true;
                            }
                        } else {
                            if ($a[$_y + $i][$x + $j] == 1) {
                                $checkXY = false;
                                break;
                            }
                            if ($a[$_y + $i][$x + $j] == 0) {
                                $checkXY = true;
                            }
                        }
                    }
                }

                if ($checkXY) {
                    $ValueResult = $checkValueResult;
                    break;
                }
            }
        }
        if ($checkXY) {
            break;
        }
    }
    if (empty($ValueResult)) return 2048;
    $result = $ValueResult['resultX'] * 8 + $ValueResult['resultY'];

    return $result;
}


function cn_renderImageItemCode($group, $id, $optImg)
{
    $group = (string)$group;
    $id = (string)$id;
    $optImg = (string)$optImg;

    if (strlen($optImg) == 7){
        return (string)$optImg;
    }

    $strGroup = $strId = $strImg = '';
    if (strlen($group) == 1) $strGroup = '0' . $group;
    else if (strlen($group) == 2) $strGroup = $group;

    if (strlen($id) == 1) $strId = '00' . $id;
    else if (strlen($id) == 2) $strId = '0' . $id;
    else if (strlen($id) == 3) $strId = $id;

    if (empty($optImg)) {
        $strImg = '00';
    }

    if (strlen($optImg) == 1) {
        $strImg = '0' . $optImg;
    } elseif (strlen($optImg) == 2) {
        $strImg = $optImg;
    }

    return (string)$strGroup . $strId . $strImg;
}

// Since 2.0: Check CSRF challenge
function cn_dsi_check($isWeb = false)
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

    $member = member_get();

    list(, $username) = explode('-', $key, 2);
    // Get signature
    if (!$isWeb) {
        if ($member['user_Account'] !== $username) die('CSRF attempt! Username invalid');
        $signature = MD5($key . $member['pass'] . MD5(getoption('#crypt_salt')));
    } else {
        if ($member['user_name'] !== $username) die('CSRF attempt! Username invalid ...');
        $signature = MD5($key . $member['pass_web'] . MD5(getoption('#crypt_salt')));
    }

    if ($dsi !== $signature)
        die('CSRF attempt! Signatures not match');
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

// Since 2.0: Generate CSRF stamp (only for members)
// @Param: type = std (input hidden), a (inline in a)
function cn_snippet_digital_signature($type = 'std')
{
    $member = member_get();

    if (isset($member['user_Account'])) $ischeckSession = false;
    else if (isset($member['user_name'])) $ischeckSession = true;
    else return false;

    // Is not member - is fatal error
    if (is_null($member)) die("Exception with generating signature");

    // Make signature
    if (!$ischeckSession) {
        $sign_extr = MD5(time() . mt_rand()) . '-' . $member['user_Account'];
        $signature = MD5($sign_extr . $member['pass'] . MD5(getoption('#crypt_salt')));
    } else {
        $sign_extr = MD5(time() . mt_rand()) . '-' . $member['user_name'];
        $signature = MD5($sign_extr . $member['pass_web'] . MD5(getoption('#crypt_salt')));
    }
    if ($type == 'std') {
        echo '<input type="hidden" name="__signature_key" value="' . cn_htmlspecialchars($sign_extr) . '" />';
        echo '<input type="hidden" name="__signature_dsi" value="' . cn_htmlspecialchars($signature) . '" />';
    } elseif ($type == 'a') {
        return '__signature_dsi_inline=' . $signature . '.' . urlencode($sign_extr);
    }

    return FALSE;
}

function cn_template_class()
{
    // No in cache
    if ($class = mcache_get('#class')) {
        return $class;
    }

    mcache_set('#class', $class = cn_get_template_by('class'));
    return $class;
}

function cn_template_reset()
{
    // No in cache
    if ($_reset = mcache_get('#reset')) {
        return $_reset;
    }

    $reset = cn_get_template_by('reset');
    if (!$reset) {
        return NULL;
    }

    $key_rs = array_keys($reset);
    //$index = 0;
    $options_rs = array();
    for ($id = 0; $id < count($reset); $id += 9) {
        $options_rs[] = array(
            'reset' => $reset[$key_rs[$id]],
            'level' => $reset[$key_rs[$id + 1]],
            'zen' => $reset[$key_rs[$id + 2]],
            'chaos' => $reset[$key_rs[$id + 3]],
            'cre' => $reset[$key_rs[$id + 4]],
            'blue' => $reset[$key_rs[$id + 5]],
            'point' => $reset[$key_rs[$id + 6]],
            'command' => $reset[$key_rs[$id + 7]],
            'time' => $reset[$key_rs[$id + 8]]
        );
        //++$index;
    }
    mcache_set('#reset', $options_rs);
    return $options_rs;
}

function cn_template_resetvip()
{
    // No in cache
    if ($_resetvip = mcache_get('#resetvip')) {
        return $_resetvip;
    }

    $resetvip = cn_get_template_by('reset_vip');
    if (!$resetvip) {
        return NULL;
    }
    $reset = cn_template_reset();
    $key_rsvip = array_keys($resetvip);
    $index = 0;
    for ($id = 0; $id < count($resetvip); $id += 5) {
        $options_rsvip[$index]['reset'] = $reset[$index]['reset'];
        $options_rsvip[$index]['level'] = $resetvip[$key_rsvip[$id]];
        $options_rsvip[$index]['vpoint'] = $resetvip[$key_rsvip[$id + 1]];
        $options_rsvip[$index]['gcoin'] = $resetvip[$key_rsvip[$id + 2]];
        $options_rsvip[$index]['point'] = $resetvip[$key_rsvip[$id + 3]];
        $options_rsvip[$index]['command'] = $resetvip[$key_rsvip[$id + 4]];
        $options_rsvip[$index]['time'] = $reset[$index]['time'];
        ++$index;
    }
    mcache_set('#resetvip', $options_rsvip);

    return $options_rsvip;
}

function cn_template_relife()
{
    // No in cache
    if ($_relife = mcache_get('#relife')) {
        return $_relife;
    }

    $relife = cn_get_template_by('relife');
    if (!$relife) {
        return NULL;
    }

    $key_relife = array_keys($relife);
    $index = 0;
    for ($id = 0; $id < count($relife); $id += 3) {
        $options_rl[$index]['reset'] = $relife[$key_relife[$id]];
        $options_rl[$index]['point'] = $relife[$key_relife[$id + 1]];
        $options_rl[$index]['command'] = $relife[$key_relife[$id + 2]];
        ++$index;
    }
    mcache_set('#relife', $options_rl);

    return $options_rl;
}

function cn_template_uythacrs()
{

    // No in cache
    if ($_uythac_rs = mcache_get('#uythacrs')) {
        return $_uythac_rs;
    }

    $uythac_rs = cn_get_template_by('uythac_reset');
    if (!$uythac_rs) {
        return NULL;
    }
    $reset = cn_template_reset();
    $id = 0;
    foreach ($uythac_rs as $index => $val) {
        $options_uythac_rs[$id]['reset'] = $reset[$id]['reset'];
        $options_uythac_rs[$id]['point'] = $val;
        $options_uythac_rs[$id]['zen'] = $reset[$id]['zen'];
        $options_uythac_rs[$id]['chaos'] = $reset[$id]['chaos'];
        $options_uythac_rs[$id]['cre'] = $reset[$id]['cre'];
        $options_uythac_rs[$id]['blue'] = $reset[$id]['blue'];
        $options_uythac_rs[$id]['time'] = $reset[$id]['time'];
        ++$id;
    }
    mcache_set('#uythacrs', $options_uythac_rs);

    return $options_uythac_rs;
}

function cn_template_uythacrsvip()
{
    // No in cache
    if ($_uythac_rsvip = mcache_get('#uythacrsvip')) {
        return $_uythac_rsvip;
    }

    $uythac_rsvip = cn_get_template_by('uythac_resetvip');
    if (!$uythac_rsvip) {
        return NULL;
    }
    $resetvip = cn_template_resetvip();
    $id = 0;
    foreach ($uythac_rsvip as $index => $val) {
        $options_uythac_rsvip[$id]['reset'] = $resetvip[$id]['reset'];
        $options_uythac_rsvip[$id]['point'] = $val;
        $options_uythac_rsvip[$id]['vpoint'] = $resetvip[$id]['vpoint'];
        $options_uythac_rsvip[$id]['gcoin'] = $resetvip[$id]['gcoin'];
        $options_uythac_rsvip[$id]['time'] = $resetvip[$id]['time'];
        ++$id;
    }
    mcache_set('#uythacrsvip', $options_uythac_rsvip);

    return $options_uythac_rsvip;
}

function cn_template_rslimit1()
{
    // No in cache
    if ($_rslimit1 = mcache_get('#rslimit1')) {
        return $_rslimit1;
    }

    $rslimit1 = cn_get_template_by('gioihan_rs');
    if (!$rslimit1) {
        return NULL;
    }
    $key_rslimit1 = array_keys($rslimit1);
    $id = 0;
    foreach ($rslimit1 as $key => $val) {
        $options_rslimit1[$id]['top'] = $val;//$rslimit1[$key_rslimit1[$id]];
        if (++$id == 6) break;
    }
    mcache_set('#rslimit1', $options_rslimit1);

    return $options_rslimit1;
}

function cn_template_rslimit2()
{
    if ($_rslimit2 = mcache_get('#rslimit2')) {
        return $_rslimit2;
    }

    $rslimit2 = cn_get_template_by('gioihan_rs');
    if (!$rslimit2) {
        return NULL;
    }
    $key_rslimit2 = array_keys($rslimit2);
    $id = 0;
    $index = 0;
    for ($id = 8; $id < count($rslimit2); $id += 4) {
        $options_rslimit2[$index]['day1'] = $rslimit2[$key_rslimit2[6]];
        $options_rslimit2[$index]['day2'] = $rslimit2[$key_rslimit2[7]];
        $options_rslimit2[$index]['col1'] = $rslimit2[$key_rslimit2[$id]];
        $options_rslimit2[$index]['col2'] = $rslimit2[$key_rslimit2[$id + 1]];
        $options_rslimit2[$index]['col3'] = $rslimit2[$key_rslimit2[$id + 2]];
        $options_rslimit2[$index]['col4'] = $rslimit2[$key_rslimit2[$id + 3]];
        ++$index;
    }

    mcache_set('#rslimit2', $options_rslimit2);

    return $options_rslimit2;
}

function cn_template_httt()
{
    // No in cache
    if ($_hotro_tanthu = mcache_get('#hotro_tanthu')) {
        return $_hotro_tanthu;
    }

    $hotro_tanthu = cn_get_template_by('hotro_tanthu');
    if (!$hotro_tanthu) {
        return NULL;
    }
    $key_httt = array_keys($hotro_tanthu);
    $id = 0;
    for ($in_ = 0; $in_ < count($hotro_tanthu); $in_ += 5) {
        $options_httt[$id]['reset_min'] = $hotro_tanthu[$key_httt[$in_]];
        $options_httt[$id]['reset_max'] = $hotro_tanthu[$key_httt[$in_ + 1]];
        $options_httt[$id]['relife_min'] = $hotro_tanthu[$key_httt[$in_ + 2]];
        $options_httt[$id]['relife_max'] = $hotro_tanthu[$key_httt[$in_ + 3]];
        $options_httt[$id]['levelgiam'] = $hotro_tanthu[$key_httt[$in_ + 4]];
        ++$id;
    }
    mcache_set('#hotro_tanthu', $options_httt);

    return $options_httt;
}


// Since 2.0: Get template (if not exists, create from defaults)
function cn_get_template_by($template_name = '')
{
    $templates = getoption('#temp_basic');
    $template_name = strtolower($template_name);

    // User template not exists in config... get from defaults
    if (isset($templates[$template_name])) {
        return $templates[$template_name];
    }
    return false;
}

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

//----------------------------------------------------------------------
function cn_resetDefaultCharater($accountID)
{
    if (empty($accountID)) return false;

    $resultlistChracter = do_select_orther("SELECT * FROM MuOnline.dbo.Character WHERE AccountID='$accountID' AND IsThuePoint =1");

    $arr_class = cn_template_class();
    $options_rs = cn_template_reset();
    $options_rl = cn_template_relife();
    $options_tanthu = cn_template_httt();


    if ($resultlistChracter) {
        foreach ($resultlistChracter as $key => $item) {
            if ((($item['TimeThuePoint'] + 86400) <= ctime()) && $item['IsThuePoint']) {

                $reset_rs = $item['Resets'];
                $class_ = $item['Class'];
                $relife_vl = $item['Relifes'];

                if (getoption('hotrotanthu')) {
                    if (isset($options_tanthu)) {
                        foreach ($options_tanthu as $aq => $qa) {
                            if (($qa['reset_min'] <= $reset_rs && $reset_rs <= $qa['reset_max']) && ($qa['relife_min'] <= $relife_vl && $relife_vl <= $qa['relife_max'])) {
                                $giam_lv = $qa['levelgiam'];
                            }
                        }
                    }
                }
                $reset_rs += isset($giam_lv) ? $giam_lv : 0;

                if (isset($options_rs)) {
                    $ok_loop = false;
                    $resetpoint = $leadership = $rs_index = 0;
                    $i_e = $p_e = $ml_e = 0;
                    foreach ($options_rs as $aq => $qa) {
                        $i_f = $ok_loop ? $i_e : 0;
                        $i_e = $qa['reset'];
                        $p_e = $qa['point'];
                        $ml_e = $qa['command'];
                        $ok_loop = true;

                        if (($reset_rs > $i_f) && ($reset_rs <= $i_e) || ($reset_rs == 0)) {
                            $resetpoint += $qa['point'] * ($reset_rs - $i_f);
                            $leadership += $qa['command'] * ($reset_rs - $i_f);
                            break;
                        }

                        $resetpoint += ($i_e - $i_f) * $p_e;
                        $leadership += ($i_e - $i_f) * $ml_e;
                    }
                }

                if (isset($options_rl)) {
                    foreach ($options_rl as $aq => $qa) {
                        if ($relife_vl == $aq) {
                            $point_relifes = $qa['point'];
                            $ml_relifes = $qa['command'];
                            break;
                        }
                    }

                    $point_relifes = isset($point_relifes) ? $point_relifes : $options_rl[count($options_rl) - 1]['point'];
                    $ml_relifes = isset($ml_relifes) ? $ml_relifes : $options_rl[count($options_rl) - 1]['command'];
                }

                $default_class = do_select_character(
                    'DefaultClassType',
                    $arr_cls = 'Strength,Dexterity,Vitality,Energy,Life,MaxLife,Mana,MaxMana,MapNumber,MapPosX,MapPosY',
                    "Class='$class_' Or Class='$class_'-1 Or Class='$class_'-2 Or Class='$class_'-3"
                );

                $resetpoint = (isset($resetpoint) ? $resetpoint : $item['LevelUpPoint']);
                $leadership = (isset($leadership) ? $leadership : $item['Leadership']);
                $resetpoint += (isset($point_relifes) ? $point_relifes : 0);
                $leadership += (isset($ml_relifes) ? $ml_relifes : 0);

                if ($leadership > 64000) $leadership = 64000;
                if ($resetpoint > 65000) {
                    $pointup = 65000;
                    $resetpoint -= 65000;
                } else {
                    $pointup = $resetpoint;
                    $resetpoint = 0;
                }

                if (($class_ == $arr_class['class_dl_1']) || ($class_ == $arr_class['class_dl_2'])) {
                } else $leadership = 0;

                $get_default_class = '';
                $_arr_cls = spsep($arr_cls);
                foreach ($_arr_cls as $key => $val)
                    $get_default_class .= "$val='" . $default_class[0][$val] . "',";

                $get_default_class = substr($get_default_class, 0, -1);

                //----------------------------------------------------------------
                do_update_character(
                    'Character',
                    'Experience=0',
                    "IsThuePoint=0",
                    "LevelUpPoint=$pointup",
                    "pointdutru=$resetpoint",
                    $get_default_class,
                    "Leadership=$leadership",
                    'MapDir=0',
                    "name:'" . $item['Name'] . "'"
                );

                if ($class_ == $arr_class['class_dw_3'] OR $class_ == $arr_class['class_dk_3'] OR $class_ == $arr_class['class_elf_3']) {
                    do_update_character(
                        'Character',
                        'Quest=0xaaeaffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff',
                        "Name:'" . $item['Name'] . "'"
                    );
                }

                //Add Xoay kiem cho DK
                if ($class_ == $arr_class['class_dk_1'] OR $class_ == $arr_class['class_dk_2'] OR $class_ == $arr_class['class_dk_3'])
                    do_update_character(
                        'Character',
                        'MagicList=0x2c0000430000440000450000460000470000290000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000',
                        "name:'" . $item['Name'] . "'"
                    );

                //Add Mui ten vo tan cho Elf C3
                if ($class_ == $arr_class['class_elf_3'])
                    do_update_character(
                        'Character',
                        'MagicList=0x2e00004300004400004500004600004700004d0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000',
                        "name:'" . $item['Name'] . "'"
                    );

                //Add Skill cho Summoner
                if ($class_ == $arr_class['class_sum_1'] OR $class_ == $arr_class['class_sum_2'] OR $class_ == $arr_class['class_sum_3'])
                    do_update_character(
                        'Character',
                        'MagicList=0xda0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000',
                        "name:'" . $item['Name'] . "'"
                    );
            }
        }
    }

    return false;
}

function cn_zenderMoneyBank($moneyBank)
{
    $strMoneyBank = '';
    if (empty($moneyBank) && $moneyBank != 0) {
        return $strMoneyBank;
    }
    $moneyBankLenght = strlen($moneyBank);
    if ($moneyBankLenght > 9) {
        $subNumberShow = number_format(substr($moneyBank, 0, 4), 0, '.', ',');
        $strMoneyBank .= $subNumberShow . '+E' . ($moneyBankLenght - 1);

    } else {
        $strMoneyBank .= number_format($moneyBank, 0, ',', '.');
    }

    return $strMoneyBank;
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

function cn_ResultDe()
{
    $ctimeAction = getoption('timeWriterLimit');
    $time = ctime();
    $hourTime = date('H:i', $time);
    $id_getResult_De = trim(getoption('id_getResult_De'));
    if ($hourTime < $ctimeAction) {
        # Use the Curl extension to query Google and get back a page of results
        $url = trim(getoption('url_Result_De'));// URL_RESULR_DE;
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $html = curl_exec($ch);
        curl_close($ch);

        # Create a DOM parser object
        $dom = new DOMDocument();

        # Parse the HTML from Google.
        # The @ before the method call suppresses any warnings that
        # loadHTML might throw because of invalid HTML in the page.
        @$dom->loadHTML($html);

//        $xpath = new DomXpath($dom);
//        $div = $xpath->query('//*/p[@class="kqbackground text-center"]')->item(0);
//        $stuffDate = $div->textContent;
//        $stuffDateTime = strtotime(trim(explode(':', $stuffDate)[1]));
//        $stuffDateTimeAction = date('Y-m-d H:i:s', $stuffDateTime);

        $resultPlayDe = $dom->getElementById($id_getResult_De)->nodeValue;
        $resultPlayDe = substr($resultPlayDe, -2);

        $timeYesterday = $time - 86400;
        $dateTime = date('Y-m-d', $timeYesterday);
//        $dateTime = date('Y-m-d', strtotime(date('Y-m-d', $time) . '- 1 days'));

        if ($resultPlayDe || $resultPlayDe == 0) {
            $resultSelect = do_select_orther("SELECT count(*) as nameCount FROM ResultDe WHERE Convert(Date, timesDe)='" . $dateTime . "'");
            if (empty($resultSelect[0]['nameCount'])) {
                do_insert_character(
                    'ResultDe',
                    'ResultDe=' . $resultPlayDe,
                    'timesDe=\'' . date('Y-m-d H:i:s', $timeYesterday) . '\'',
//                    'timesDe=\'' . ((empty($stuffDateTime)) ? date('Y-m-d H:i:s', ($time - 86400)) : $stuffDateTimeAction ). '\'',
                    'OptionResult=\'' . $timeYesterday . '\''
                );

                $showupDate = do_select_orther("SELECT [ID], [AccountID],[WriteDe],[timestamp],[Action], [Vpoint] FROM WriteDe WHERE Convert(Date, timestamp)='$dateTime' AND Action = 1");

                foreach ($showupDate as $key => $items) {
                    $ischeck = false;
                    $ID = trim($items['ID']);
                    $AccountID = trim($items['AccountID']);
                    if (trim($items['WriteDe']) == $resultPlayDe) {
                        $vpointnew = $items['Vpoint'] * 70;
                        do_update_character('MEMB_INFO', "vpoint=vpoint+$vpointnew", "memb___id:'$AccountID'");
                        $ischeck = true;
                    }

                    do_update_character('WriteDe', "Action=0", "Result=" . (($ischeck) ? '1' : '2'), "ID:'$ID'");
                }
            }
        }
        //-----------------------------------------------------------------
        //    $resultPlayDe = $dom->getElementById("rs_0_0")->innertext;
        //    $resultPlayDe = substr($resultPlayDe, -2);

        //    $df = $html->find('table[class=table table-condensed kqcenter table14force background-border table-kq-hover] td');
        //   foreach ($df as $f => $dd){
        //    echo $dd->innertext . '<br>';
        //}
        //-----------------------------------------------------------------
    }
}

/**
 * @param $dirpath
 * @param int $mode
 * @return bool
 */
function makeDirs($dirpath, $mode=0777) {
    return is_dir($dirpath) || mkdir($dirpath, $mode, true);
}