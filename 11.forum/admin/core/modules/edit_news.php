<?php if (!defined('BQN_MU')) { die('Access restricted'); }

add_hook('index/invoke_module', '*edit_news_invoke');

function edit_news_invoke()
{
    list($action) = GET('act', 'GPG');

    // [DETECT ACTION]
    if ($action == 'edit') 
    {
        edit_news_action_edit();
    }
    elseif ($action == 'massaction') 
    {
        edit_news_action_massaction();
    }
    elseif ($action == 'delete') 
    {
        edit_news_delete();
    }
    else 
    {
        edit_news_action_list();
    }

    die();
}

function edit_news_action_list()
{
//require_once SERVDIR . '/core/config.php';
global $db;	
list($mod, $act, $page, $per_page, $source, $ndraft) = GET('mod, act, page, per_page, source, ndraft', 'GETPOST'); // cho duong dan GET('mod, act', 'GETPOST');  
list($sort, $dir, $YS, $MS, $DS, $year, $mon, $day) = GET('sort, dir, year_selected, mon_selected, day_selected, year, mon, day', 'GETPOST'); // sap xep theo sort (ngay comment tac gia)
    
//list($myy, $myym, $myymd, $order, $ordershow) = GET('$sqlyear, $sqlyearmon, $sqlyearmonday, $sqloder, $sqlordershow', 'GETPOST');
list($add_forum, $add_user, $rm_forum, $rm_user, $com_filter) = GET('forum_filters, user_filters, rm_forum_filter, rm_user_filter, com_filter', 'GET');


// defaults
    //$has_next = FALSE;
    //$page  = intval($page);
    //$ctime = ctime();
    $nocat = FALSE;

    if (intval($per_page) == 0)
    {
        $per_page = 25;
    }
    
    if ($sort == '')
    {
        $sort = 'date';
    }
    
    if ($sort == 'date' && !$dir)
    {
        $dir = 'd';
    }
    
    if ($dir == '')
    {
        $dir = 'a';
	}
	if(empty($source) || !isset($source))
		$source == '';
		
	
	if(empty($_GET['forum_filters'])) $forum_filters = 0;
	//if(empty($myym)) $myym = '';
	//if(empty($myymd)) $myymd = '';
	

	// --- changes in acp filters ---
    list($cfilter, $ufilter) = cn_cookie_unpack('filter_forum, filter_user');

    if ($add_forum){
        $sp = spsep($add_forum);
        foreach ($sp as $id){
            $cfilter[$id] = $id;
        }
    }
    
    if ($add_user){
        $sp = spsep($add_user);
        foreach ($sp as $id) {
            $ufilter[$id] = $id;
        }
    }

    if ($rm_forum){
        $sp = spsep($rm_forum);
        foreach ($sp as $id) {
            unset($cfilter[$id]);
        }
    }

    if ($rm_user){
        $sp = spsep($rm_user);
        foreach ($sp as $id) {
            unset($ufilter[$id]);
        }
    }        

    // Add concrete filter
    /*
	if ($cat_filter){
        if ($cat_filter !== '-')
        {
            $filter = intval($cat_filter);
            if (test_cat($filter))
            {
                $cfilter[$filter]=$filter;
            }
        }
        else
        {
            $nocat = TRUE;
        }
    }
    */
	//if(!empty($cfilter) && !empty($ufilter))
    cn_cookie_pack('filter_forum, filter_user', $cfilter, $ufilter);
	
	$opts = array
    (
        'source'     => $source,
        //'archive_id' => $archive_id,
        'sort'       => $sort,
        'dir'        => $dir,
        'page'      => $page,
        'per_page'   => $per_page,
        'cfilter'    => $cfilter,
        'ufilter'    => $ufilter,
        //'nocat'      => $nocat,
        //'nlpros'     => TRUE, // load prospected anyway
        //'by_date'    => "$YS-$MS-$DS",
        'year'    => $year,//custom
        'mon'    => $mon,
        'day'    => $day,
    );

    list($dyear, $dmon, $dday, $dymd, $ufilter_name, $dataresult, $total, $numdraft, $pagination) = cn_get_news($opts);
    //list($dcat, $dforum) = cn_get_catforum();
$dcat = array(); $dforum= array();

	/*
    // ----------------------S _ Mysql select------------------------------
	// _year _ month _dat
	$myy = "SELECT DISTINCT YEAR(date) as year FROM topics ORDER BY year DESC;";
	if(isset($_GET['year'])) {
		$YS = $_GET['year'];
		$myym = "SELECT DISTINCT MONTHNAME(date) as mon FROM topics WHERE YEAR(date) = '" . $YS . "' ORDER BY mon DESC;";
		if(isset($_GET['mon'])){
			$MS = $_GET['mon'];
			$myymd = "SELECT DISTINCT DAY(date) as day FROM topics WHERE YEAR(date) = '" . $YS . "' AND MONTHNAME(date) = '" . $MS . "' ORDER BY day DESC;";
			if(isset($_GET['day']))
				$DS = $_GET['day'];
		}
	}
	
	//none sql
	$order1 = "SELECT topics.id AS topicid, (SELECT name FROM `forums` WHERE topics.forum_id = forums.id) AS nameforum, (SELECT count(*) FROM `messages` WHERE messages.topic_id = topics.id) AS com, topics.*, users.username, messages.id AS messagesid, messages.date AS messagesdate, messages.user_id AS messagesuser_id FROM messages, topics, users WHERE topics.user_id = users.id"; 
	// if active or draft
	if($source ==''){
		$order2 = " AND topics.active ='1'";
	}
	else
		$order2 = " AND topics.active ='0'";

	// array cfilter (topics)
	$order3 = '';
	if(!empty($cfilter)){
		arsort($cfilter);
		$checkok = true;
		foreach($cfilter as $id){
			if($checkok){
				$order3 .= " AND (topics.forum_id = '$id'";
				$checkok = false;
			}
			else
				$order3 .= " OR topics.forum_id = '$id'";
		}
		$order3 .= ")";
	}
	//array ucfirst (user)
	if(!empty($ufilter)){
		arsort($ufilter);
		$checkok = true;
		foreach($ufilter as $uid){
			if($checkok){
				$order3 .= " AND (users.id = '$uid'";
				$checkok = false;
			}
			else
				$order3 .= " OR users.id = '$uid'";
		}
		$order3 .= ")";
	}
						
	//year=2015&mon=September&day=27
	$order4 = '';
	if (isset($_GET['year'])){
		$order4 .= " AND YEAR(topics.date) = '$YS'"; 
		if(isset($_GET['mon'])){
			$order4 .= " AND MONTHNAME(topics.date) = '$MS'";
			if(isset($_GET['day']))
				$order4 .= " AND DAY(topics.date) = '$DS'";
		}
	}

	//sort _date _ num comment _ author
	if ($sort == 'date'){
		if($dir == 'd')
			$order4 .= " GROUP BY topics.id ORDER BY topics.date DESC"; 
		else if($dir == 'a')
			$order4 .= " GROUP BY topics.id ORDER BY topics.date ASC";
	}
	else if($sort == 'author'){
		if($dir == 'd')
			$order4 .= " GROUP BY topics.id ORDER BY users.username DESC"; 
		else if($dir == 'a')
			$order4 .= " GROUP BY topics.id ORDER BY users.username ASC";
	}
	else if($sort == 'comments' ){
		if($dir == 'd')
			$order4 .= " GROUP BY topics.id ORDER BY com DESC"; 
		else if($dir == 'a')
			$order4 .= " GROUP BY topics.id ORDER BY com ASC";
	}

	// ----------------------End _ Mysql select------------------------------
	
// ----------------------my select Active or ndraft------------------------------
	$order = $order1.$order2.$order3.$order4;

	$sqlpagina = $db -> query($order); 
	$total = $sqlpagina ->num_rows; //total recode

//-----------------------my se total ndraft------------------------------------------
 
$orderw = $order1." AND topics.active = '0'" . $order3 . $order4 . ";";
$sqlndraft = $db -> query($orderw); 
$ndraft = $sqlndraft ->num_rows; // recode

//-------------------------sum recode toptipc full year mont day my select------------------------

$sum_recode_topics = $order1.$order2.$order3;

//-------------------------test my select------------------------
//$ndraft = $total;
//echo "order: <br> " . $order . "<br>";
//echo "------------------------------------------------------------------<br>";
//echo "orderw: <br> " . $orderw . "<br>";


$adjacents = 3; // num lastpage center

if($page)
	$start = ($page - 1) * $per_page; //first item to display on this page
else{
	$start = 0;
}

// Setup page vars for display. 
if ($page == 0) $page = 1; //if no page var is given, default to 1.
$prev = $page - 1; //previous page is current page - 1
$next = $page + 1; //next page is current page + 1
$lastpage = ceil($total/$per_page); //lastpage.
$lpm1 = $lastpage - 1; //last page minus 1

// ---------------------my select view recode--------------------------
$ordershow = $order;
$ordershow .= " LIMIT $start ,$per_page;";

//----------------num total show view---------------------
$sql_query_num = $db->query($ordershow);
$show_num = $sql_query_num -> num_rows;
//------------------------------------


// CREATE THE PAGINATION 

$pagination = "";
if($lastpage > 1){ 
	$pagination .= "<div class='light-theme simple-pagination pagination'> <ul>";
	
	if ($page > 1) {
		$pagination.= "<li><a href=".cn_url_modify('mod=editnews', "page=$prev")." class='page-link prev'>Prev</a></li>"; 
	}
	elseif($page ==1)
		$pagination.= "<li><a rel='nofollow' href='' class='current'>Prev</a></li>"; 
	
	if ($lastpage < 7 + ($adjacents * 2)) { // so trang < 13 = so bt hien thi
		for ($counter = 1; $counter <= $lastpage; $counter++){
			if ($counter == $page)
				$pagination.= "<li><a rel='nofollow' href='#' class='current'>$counter</a></li>";
			else
				$pagination.= "<li><a href=".cn_url_modify('mod=editnews', "page=$counter")." class='page-link'>$counter</a></li>"; 
		}
	}
	elseif($lastpage > 5 + ($adjacents * 2)){ //enough pages to hide some so trang >11
		//close to beginning; only hide later pages
		if($page < 1 + ($adjacents * 2)) { //  hien tai < 7...... => hientai 1 2 3 4 5 6 7 => hien 1 2 3 4 5 6 7 8 9
			for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){ //$counter < 9 + (2 tr cuoi)
				if ($counter == $page)
					$pagination.= "<li><a rel='nofollow' href='#' class='current'>$counter</a></li>";
				else
					$pagination.= "<li><a href=".cn_url_modify('mod=editnews', "page=$counter")." class='page-link'>$counter</a></li>"; 
			}
			
			$pagination.= "<li>...</li>";
			$pagination.= "<li><a href=".cn_url_modify('mod=editnews', "page=$lpm1")." class='page-link'>$lpm1</a></li>";
			$pagination.= "<li><a href=".cn_url_modify('mod=editnews', "page=$lastpage")." class='page-link'>$lastpage</a></li>"; 
		}
		//in middle; hide some front and some back
		elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){ // so tr - 6 > hientai  hienta > 6
			
			$pagination.= "<li><a href=".cn_url_modify('mod=editnews', "page=1")." class='page-link'>1</a></li>"; 		// trang dau 1
			$pagination.= "<li><a href=".cn_url_modify('mod=editnews', "page=2")." class='page-link'>2</a></li>";	 	// trang thu 2
			$pagination.= "<li>...</li>";
			for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){ // 1 2 3 hientai 5 6 7  (tong 7)
				
				if ($counter == $page)
					$pagination.= "<li><a rel='nofollow' href='#' class='current'>$counter</a></li>";
				else
					$pagination.= "<li><a href=".cn_url_modify('mod=editnews', "page=$counter")." class='page-link'>$counter</a></li>"; 
			}
			
			$pagination.= "<li>...</li>";
			
			$pagination.= "<li><a href=".cn_url_modify('mod=editnews', "page=$lpm1")." class='page-link'>$lpm1</a></li>"; // trang cuoi - 1 
			$pagination.= "<li><a href=".cn_url_modify('mod=editnews', "page=$lastpage")." class='page-link'>$lastpage</a></li>";  // trang cuoi 
			
		}
			//close to end; only hide early pages
		else{
			$pagination.= "<li><a href=".cn_url_modify('mod=editnews', "page=1")." class='page-link'>1</a></li>";
			$pagination.= "<li><a href=".cn_url_modify('mod=editnews', "page=2")." class='page-link'>2</a></li>";
			$pagination.= "<li>...</li>";
			
			for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){  // chi so = tong - 8; chi so < tong class="current"
				if ($counter == $page){
					$pagination.= "<li><a rel='nofollow' href='#' class='current'>$counter</a></li>";
				}
				else{
					$pagination.= "<li><a href=".cn_url_modify('mod=editnews', "page=$counter")." class='page-link'>$counter</a></li>"; 
				}
			}
		}
	}

	//next button
	if (($page >= 1) && $page < $lastpage){
		$pagination.= "<li><a href=".cn_url_modify('mod=editnews', "page=$next")." class='page-link'>Next</a></li>";
	}
	elseif($page == $lastpage){
		$pagination.= "<li><a rel='nofollow' href='' class='current'>Next</a></li>";
	}
	
	$pagination.= "</ul></div>\n"; 
}

*/

foreach ($dataresult as $id => $entry){
	$can = FALSE;
	//$nv_user = db_user_by_name($entry['username']);
	//$nv_user = db_user_by_name($entry['username']);

	// User not exists, deny, except admins
	//if (!$nv_user && !test('Nva')){
		//$can = FALSE;
	//}
	//else
		//if (test('Nvs', $nv_user, TRUE) || test('Nvg', $nv_user) || test('Nva'))
		if (test('Nva'))
	{
		$can = test_cat($entry['forum_id']);
	}

	//$dataresult[$id]['user']       = $entry['u'];
	//$dataresult[$id]['date']       = $YS ? date('M, d H:i', $id) : date('M, d Y H:i', $id);
	//$dataresult[$id]['date_full']  = date('Y M d, H:i:s', $id);
	//$dataresult[$id]['user']       = $entry['u'];
	//$dataresult[$id]['comments']   = count($entry['co']);
	//$dataresult[$id]['title']      = $entry['t'];
	//$dataresult[$id]['cats']       = spsep($entry['c']);
	//$dataresult[$id]['is_pros']    = $id > $ctime ? TRUE : FALSE;
	$dataresult[$id]['can']        = $can;
/*
	foreach($nv_user as $d => $fg){		
		print "--------------------------------------------<br>";
		print "F_edit_news 392 Array nv_user: $d => $fg <br>";
		//foreach($fg as $df => $fq)
			//print "F_edit_news 396 Array nv_user: $df => $fq <br>";
		print "--------------------------------------------<br>";
	}
	*/
}

//print "F_edit_news 392 Array nv_user: $nv_user <br>";



foreach($dataresult as $d => $fg){		
		print "--------------------------------------------<br>";
		print "F_edit_news 369 Array entries: $d <br>";
		foreach($fg as $df => $fq)
			print "F_edit_news 371 Array entries: $df => $fq <br>";
		print "--------------------------------------------<br>";
	}


// ----------------------------------------------------
		// clear differs for cn_url_*
	
	unset($_GET['forum_filters'], $_GET['user_filters'], $_GET['rm_forum_filter'], $_GET['rm_user_filter']);
   
     cn_assign('mod, act, sort, dir, per_page,  page,  forums_filters, users_filters, source, entries_total, num_showview, numdraft',
              $mod, $act, $sort, $dir, $per_page, $page,  $cfilter, $ufilter_name, $source, $total, count($dataresult), $numdraft);
	
    cn_assign('year_selected, mon_selected, day_selected, arrayyear, arraymon, arrayday, arraynumrecode, datalist, pagination, cat_label, forum_label',
				$year, $mon, $day, $dyear, $dmon, $dday, $dymd, $dataresult, $pagination, $dcat, $dforum);
	
	
    
	//echo exec_tpl('header');
	echoheader('editnews@editnews/main.css', 'News list');
	echo exec_tpl('editnews/edit_new');
	echofooter();
    // ----------------------------------------------------
}


// Since 2.0: Edit news section
// ---------------------------------------------------------------------------------------------------------------------
function edit_news_action_edit()
{
	/*
    $preview_html   = $preview_html_full = '';
    $ID             = $gstamp = intval(REQ('id', 'GETPOST'));

    list($status, $preview) = GET('m, preview');
    list($vConcat, $vTags, $faddm, $archive_id, $source)  = GET('concat, tags, faddm, archive_id, source', 'GETPOST');

    // get news part by day
    $news = db_news_load(db_get_nloc($ID));

    if ($ID == 0)
    {
        msg_info("Can't edit news without ID");
    }

    if (!isset($news[$ID]))
    {
        msg_info("News entry not found!");
    }

    // load entry
    $entry    = $news[$ID];
    $oldentry = $entry;

    // disallowed by category
    if (!test_cat($entry['c']))
    {
        msg_info("You can't view entry. Category disallow");
    }

    // set status message
    if ($status == 'added')
    {
        cn_throw_message('News was added');
    }
    if ($status == 'moved') 
    {
        cn_throw_message('Moved to another time');
    }

    // load more fields
    list($morefields) = cn_get_more_fields($entry['mf']);

    // do save news?
    if (request_type('POST'))
    {
        // check exists news
        if (isset($news[$ID]))
        {
            // extract data
            $entry = $storent = $news[$ID];

            // Prepare text
            list($title, $page, $category, $short_story, $full_story, $if_use_html, $postpone_draft) = GET('title, page, category, short_story, full_story, if_use_html, postpone_draft', 'GETPOST');

            // Change date?
            list($from_date_hour, $from_date_minutes, $from_date_seconds, $from_date_month, $from_date_day, $from_date_year) = GET('from_date_hour, from_date_minutes, from_date_seconds, from_date_month, from_date_day, from_date_year', 'GETPOST');
            $c_time = intval(mktime($from_date_hour, $from_date_minutes, $from_date_seconds, $from_date_month, $from_date_day, $from_date_year));

            // sanitize page name
            $page = preg_replace('/[^a-z0-9_\.]/i', '-', $page);

            if (empty($page) && !empty($title) && getoption('auto_news_alias'))
            {
                $page = strtolower(preg_replace('/[^a-z0-9_\.]/i', '-', cn_transliterate($title)));
            }            
            // current source is archive, active (postponed) or draft news
            $draft_target = ($postpone_draft === 'draft');

            // User can't post active news
            if (test('Bd') && $draft_target !== 'draft') 
            {
                $draft_target = 'draft';
            }

            // if archive_id is present, unable send to draft
            $current_source = $archive_id ? "archive-$archive_id" : ($source == 'draft' ? 'draft' : '');
            $target_source  = $archive_id ? "archive-$archive_id" : ($draft_target ? 'draft' : '');
            $if_use_html    = $if_use_html ? TRUE : (getoption('use_wysiwyg') ? TRUE : FALSE);

            $entry['t'] = cn_htmlclear($title);
            $entry['c'] = is_array($category) ? join(',', $category) : $category;
            $entry['s'] = cn_htmlclear($short_story);
            $entry['f'] = cn_htmlclear($full_story);
            $entry['ht'] = $if_use_html;
            $entry['st'] = $draft_target ? 'd' : '';
            $entry['pg'] = $page;
            $entry['cc'] = $vConcat ? TRUE : FALSE;
            $entry['tg'] = strip_tags($vTags);

            // apply more field (for news & frontend)
            list($entry, $disallow_message) = cn_more_fields_apply($entry, $faddm);
            list($morefields) = cn_get_more_fields($faddm);

            // has message from function
            if ($disallow_message)
            {
                cn_throw_message($disallow_message, 'e');
            }

            // Make preview
            if ($preview)
            {
                //correct preview links
                $gstamp = $entry['id'] = $c_time;
                $preview_html=  preg_replace('/href="(.*?)"/', 'href="#"', entry_make($entry, 'active'));
                $preview_html_full= preg_replace('/href="(.*?)"/', 'href="#"',entry_make($entry, 'full'));                                
            }
            // Save new data
            elseif (REQ('do_editsave', 'POST'))
            {
                if (!getoption('disable_title') && empty($title))
                {
                    cn_throw_message('The title cannot be blank', 'e');
                }

                if (!getoption('disable_short') && empty($short_story))
                {
                    cn_throw_message('The story cannot be blank', 'e');
                }

                // Check for change alias
                $pgts = bt_get_id($ID, 'ts_pg');
                if ($pgts && $pgts !== $page)
                {
                    if ($page)
                    {
                        if (bt_get_id($page, 'pg_ts'))
                        {
                            cn_throw_message('For other news page alias already exists!', 'e');
                        }
                    }
                    else
                    {
                        bt_del_id($pgts, 'pg_ts');
                        bt_del_id($ID, 'ts_pg');
                    }
                }

                // no errors in a[rticle] area
                if (cn_get_message('e', 'c') == 0)
                {
                    $FlatDB  = new FlatDB();

                    $ida = db_index_load($current_source);
                    $idd = db_index_load($target_source);

                    // Time is changed
                    if ($c_time != intval($ID))
                    {
                        // Load next block (or current)
                        $next = db_news_load(db_get_nloc($c_time));

                        if (isset($next[$c_time]))
                        {
                            cn_throw_message('The article time already busy, select another', 'e');
                        }
                        else
                        {
                            // set new time
                            $entry['id'] = $c_time;
                            $next[$c_time] = $entry;

                            // remove old news [from source / dest]
                            if (isset($news[$ID])) 
                            {
                                unset($news[$ID]);
                            }
                            
                            if (isset($next[$ID])) 
                            {
                                unset($next[$ID]);
                            }

                            // remove old index
                            if (isset($idd[$ID])) 
                            {
                                unset($idd[$ID]);
                            }

                            // Delete old indexes
                            $_ts_id = bt_get_id($ID, 'nts_id');
                            bt_del_id($ID, 'nts_id');

                            // Update
                            bt_set_id($_ts_id, $c_time, 'nid_ts');
                            bt_set_id($c_time, $_ts_id, 'nts_id');

                            // save 2 blocks
                            db_save_news($news, db_get_nloc($ID));
                            db_save_news($next, db_get_nloc($c_time));

                            cn_throw_message('News moved from <b>'.date('Y-m-d H:i:s', $ID).'</b> to <b>'.date('Y-m-d H:i:s', $c_time).'</b>');
                        }
                    }
                    else
                    {
                        $news[$ID] = $entry;
                        db_save_news($news, db_get_nloc($ID));

                        cn_throw_message('News was edited');
                    }

                    // Update page aliases
                    $_ts_pg = bt_get_id($ID, 'ts_pg');

                    bt_del_id($ID, 'ts_pg');
                    bt_del_id($_ts_pg, 'pg_ts');

                    if ($page)
                    {
                        bt_set_id($c_time, $page, 'ts_pg');
                        bt_set_id($page, $c_time, 'pg_ts');
                    }

                    // 1) remove from old index
                    if (isset($ida[$ID]))
                    {
                        unset($ida[$ID]);
                    }
                    
                    // 2) add new index
                    $idd[$c_time] = db_index_create($entry);

                    // 3) sync indexes
                    db_index_save($ida, $current_source);   db_index_update_overall($current_source);
                    db_index_save($idd, $target_source);    db_index_update_overall($target_source);

                    // ------
                    // UPDATE categories
                    $FlatDB->cn_remove_categories($storent['c'], $storent['id']);
                    $FlatDB->cn_add_categories($entry['c'], $c_time);

                    // UPDATE tags
                    $FlatDB->cn_remove_tags($storent['tg'], $storent['id']);
                    $FlatDB->cn_add_tags($entry['tg'], $c_time);

                    // UPDATE date / id storage [with comments count]
                    $FlatDB->cn_update_date($entry['id'], $storent['id'], count($storent['co']));
                    // ------
                }
            }
        }
        else
        {
            msg_info("News entry not found or has been deleted");
        }
    }

    if(empty($entry['pg'])&&isset($entry['t'])&& getoption('auto_news_alias'))
    {
        $entry['pg']=  strtolower(preg_replace('/[^a-z0-9_\.]/i', '-', cn_transliterate($entry['t'])));
    }        
    // Assign template vars
    $category      = spsep($entry['c']);
    $categories    = cn_get_categories();    
    $title         =isset($entry['t'])? $entry['t']:'';
    $short_story   =isset($entry['s'])? $entry['s']:'';
    $page          =isset($entry['pg'])? $entry['pg']:'';
    $full_story    =isset($entry['f'])? $entry['f']:'';
    $is_draft      =isset($entry['st'])? $entry['st'] == 'd':false;
    $vConcat       =isset($entry['cc'])? $entry['cc']:'';
    $vTags         =isset($entry['tg'])? $entry['tg']:'';
    $if_use_html   =  isset($entry['ht'])? $entry['ht']:false;
    $is_active_html =test('Csr');
    cn_assign
    (
        'categories, vCategory, vTitle, vPage, vShort, vFull, vUseHtml, preview_html, preview_html_full, gstamp, is_draft, vConcat, vTags, morefields, archive_id, is_active_html',
        $categories, $category, $title, $page, $short_story, $full_story, $if_use_html, $preview_html, $preview_html_full, $gstamp, $is_draft, $vConcat, $vTags, $morefields, $archive_id, $is_active_html
    );
	*/
    cn_assign("EDITMODE", 1);

    // show edit page
    echoheader("addedit@addedit/main.css", i18n("Edit news"));
	echo exec_tpl('addedit/main'); 
	echofooter();
}

// Since 2.0: Archive, Delete, Change category etc.
// ---------------------------------------------------------------------------------------------------------------------
function edit_news_action_massaction()
{
	
    //$FlatDB = new FlatDB();

    list($subaction, $source, $archive_id) = GET('subaction, source, archive_id');

	
    // Mass Delete
    if ($subaction == 'mass_delete')
    {
        //if (!test('Nud'))
        //{
            //cn_throw_message("Operation not permitted for you",'w');
        //}
        
        list($selected_news) = GET('selected_news');

        if (empty($selected_news))
        {
            cn_throw_message("No one news selected", 'e');
        }
        else
        {
            $count = count($selected_news);
            if (confirm_first() && $count == 0)
            {
                cn_throw_message('No none entry selected','e');
            }

			//---------------------------------------
			print "F_edit_news 685 tong so da chon: $count <br>";
			print "F_edit_news 686 lay mui gio:" . getoption('date_adjust') ." <br>";
			foreach($selected_news as $f)
				print "F_edit_news 687: $f  <br>";
			exit();
			//---------------------------------------
            if (confirm_post("Delete selected news ($count)"))
            {
                if ($source == 'archive')
                {
                    $source = 'archive-'.intval($archive_id);
                }

                $idx = db_index_load($source);

                // do delete news
                foreach ($selected_news as $id)
                {
                    $news  = db_news_load(db_get_nloc($id));

                    $storent = $news[$id];

                    if (isset($news[$id]))
                    {
                        unset($news[$id]);
                    }

                    if (isset($idx[$id]))
                    {
                        unset($idx[$id]);
                    }

                    // Remove from meta-index (auto_id)
                    $_ts_id = bt_get_id($id, 'nts_id');
                    bt_del_id($id, 'nts_id');
                    bt_del_id($_ts_id, 'nid_ts');

                    // Remove page alias
                    $_ts_pg = bt_get_id($id, 'ts_pg');
                    bt_del_id($id, 'ts_pg');
                    bt_del_id($_ts_pg, 'pg_ts');

                    // ------
                    if(isset($storent['c']))
                    {
                        $FlatDB->cn_remove_categories($storent['c'], $storent['id']);
                    }

                    if(isset($storent['tg']))
                    {
                        $FlatDB->cn_remove_tags($storent['tg'], $storent['id']);
                    }

                    $FlatDB->cn_update_date(0, $storent['id']);

                    if(isset($storent['u']))
                    {
                        $FlatDB->cn_user_sync($storent['u'], 0, $storent['id']);
                    }
                    // ------

                    // Save block
                    db_save_news($news, db_get_nloc($id));
                }

                db_index_save($idx, $source);
                db_index_update_overall($source);

                // Update archive list
                if ($archive_id)
                {
                    $min = min(array_keys($idx));
                    $max = max(array_keys($idx));
                    $cnt = count($idx);

                    db_archive_meta_update($archive_id, $min, $max, $cnt);
                }

                cn_throw_message('News deleted');
            }
            else
            {
                cn_throw_message("No one entry deleted", 'e');
            }
        }


    }
    // Mass change category
    elseif ($subaction == 'mass_move_to_cat')
    {
        cn_assign('catlist', cn_get_categories());

        $news_ids = GET('selected_news');

        // Disable commit without news
        if (empty($news_ids) || (count($news_ids) == 1 && !$news_ids[0]))
        {
            cn_throw_message("No one news selected", 'e');
        }
        else
        {
            if (confirm_post( exec_tpl('addedit/changecats') ))
            {
                cn_dsi_check();

                list($news_ids, $cats, $source) = GET('selected_news, cats, source', 'POST');
                $nc = news_make_category(array_keys($cats));

                // Load index for update categories
                $idx = db_index_load($source);
                foreach ($news_ids as $id)
                {
                    $loc     = db_get_nloc($id);
                    $entries = db_news_load( $loc );

                    // Catch user trick
                    if (!test_cat($entries[$id]['c']))
                    {
                        cn_throw_message('Not allowed change category for id = '.$id,'w');
                    }

                    $storent = $entries[$id];

                    $idx[$id][0] = $nc;
                    $entries[$id]['c'] = $nc;

                    // ------
                    $FlatDB->cn_remove_categories($storent['c'], $storent['id']);
                    $FlatDB->cn_add_categories($nc, $storent['id']);
                    // ------

                    db_save_news($entries, $loc);
                }

                // Save updated block
                db_index_save($idx, $source);

                cn_throw_message('Successful processed');

            }
            else
            {
                cn_throw_message('Operation declined by user','e');
            }
        }
    }
    // Mass approve action
    elseif ($subaction == 'mass_approve')
    {
        if (!test('Nua'))
        {
            msg_info("Operation not permitted for you");
        }

        list($selected_news) = GET('selected_news');

        if (empty($selected_news))
        {
            cn_throw_message('No one draft selected', 'e');
        }
        else
        {
            $ida = db_index_load('');
            $idd = db_index_load('draft');

            // do approve news
            foreach ($selected_news as $id)
            {
                $news = db_news_load(db_get_nloc($id));
                $news[$id]['st'] = '';

                // 1) remove from draft
                unset($idd[$id]);

                // 2) add to active index
                $ida[$id] = db_index_create($news[$id]);

                // save block
                db_save_news($news, db_get_nloc($id));
            }

            // save indexes
            db_index_save($ida);            db_index_update_overall();
            db_index_save($idd, 'draft');   db_index_update_overall('draft');

            cn_throw_message('News was approved');
        }
    }
    // Bulk switch to HTML
    elseif ($subaction == 'switch_to_html')
    {
        list($selected_news) = GET('selected_news');

        if (empty($selected_news)) {
            cn_throw_message('News not selected', 'e');
        }
        else {
            // do approve news
            foreach ($selected_news as $id)
            {
                $news = db_news_load(db_get_nloc($id));
                $news[$id]['ht'] = TRUE;
                db_save_news($news, db_get_nloc($id));
            }

            cn_throw_message('News was switched to HTML');
        }

    }
    else
    {
        cn_throw_message('Select action to process','w');
    }
    
    edit_news_action_list();
}

// Delete single item
function edit_news_delete()
{
    cn_dsi_check();

    if (!test('Nud'))
    {
        msg_info("Unable to delete news: no permission");
    }

    $FlatDB = new FlatDB();
    list($id, $source) = GET('id, source', 'GET');

    $ida  = db_index_load($source);
    $nloc = db_get_nloc($id);
    $db   = db_news_load($nloc);

    // ------
    $FlatDB->cn_remove_categories($db[$id]['c'], $db[$id]['id']);
    $FlatDB->cn_update_date(0, $db[$id]['id']);
    $FlatDB->cn_user_sync($db[$id]['u'], 0, $db[$id]['id']);
    $FlatDB->cn_remove_tags($db[$id]['tg'], $db[$id]['id']);
    // ------

    unset($db[$id]);
    unset($ida[$id]);

    // Remove from meta-index
    $_ts_id = bt_get_id($id, 'nts_id');
    bt_del_id($id, 'nts_id');
    bt_del_id($_ts_id, 'nid_ts');

    // Remove page alias
    $_ts_pg = bt_get_id($id, 'ts_pg');
    bt_del_id($id, 'ts_pg');
    bt_del_id($_ts_pg, 'pg_ts');


    // save block
    db_save_news($db, $nloc);

    db_index_save($ida, $source);
    db_index_update_overall($source);

    cn_relocation(cn_url_modify(array('reset'), 'mod=editnews', "source=$source"));
}
