<?php if (!defined('BQN_MU')) { die('Access restricted'); }

// hooks
add_hook('index/invoke_module', '*add_news_invoke');

function add_news_invoke()
{
list($mod, $act, $page, $per_page) = GET('mod, act, page, per_page', 'GETPOST'); // cho duong dan GET('mod, act', 'GETPOST');  
list($sort, $dir, $YS, $MS, $DS) = GET('sort, dir, year_selected, mon_selected, day_selected', 'GETPOST'); // sap xep theo sort (ngay comment tac gia)
    

list($add_forum, $add_user, $rm_forum, $rm_user, $com_filter) = GET('forum_filters, user_filters, rm_forum_filter, rm_user_filter, com_filter', 'GET');


// defaults
    //$has_next = FALSE;
    //$page  = intval($page);
    //$ctime = ctime();
    $nocat = FALSE;

    if ($per_page == 0)
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
	if(empty($_GET['forum_filters'])) $forum_filters = 0;
	if(empty($_GET['start'])) $start = 0;
	
	
    

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
    cn_cookie_pack('filter_forum, filter_user', $cfilter, $ufilter);
	
	
			
	
	
    // ----------------------------------------------------
	$order = "SELECT topics.id AS topicid, (SELECT name FROM `forums` WHERE topics.forum_id = forums.id) AS nameforum,(SELECT count(*) FROM `messages` WHERE messages.topic_id = topics.id) AS com, topics.*, users.username, messages.id AS messagesid, messages.date AS messagesdate, messages.user_id AS messagesuser_id FROM messages, topics, users WHERE messages.topic_id = topics.id AND topics.user_id = users.id "; // topics.forum_id =  GROUP BY messages.topic_id ORDER BY maxdate DESC;";
					
					
					if(!empty($cfilter)){
						arsort($cfilter);
						$checkok = true;
						foreach($cfilter as $id){
							if($checkok){
								$order .= " AND (topics.forum_id = '$id'";
								$checkok = false;
							}
							else
								$order .= " OR topics.forum_id = '$id'";
						}
						$order .= ")";
					}
					if(!empty($ufilter)){
						arsort($ufilter);
						$checkok = true;
						foreach($ufilter as $uid){
							if($checkok){
								$order .= " AND (users.id = '$uid'";
								$checkok = false;
							}
							else
								$order .= " OR users.id = '$uid'";
						}
						$order .= ")";
					}
					
					
					
					//year=2015&mon=September&day=27
					
					if (isset($_GET['year'])){
						$order .= " AND YEAR(topics.date) = '$YS'"; 
						if(isset($_GET['mon'])){
							$order .= " AND MONTHNAME(topics.date) = '$MS'";
							if(isset($_GET['day']))
								$order .= " AND DAY(topics.date) = '$DS'";
						}
					}
					
					if ($sort == 'date'){
						if($dir == 'd')
							$order .= " GROUP BY messages.topic_id ORDER BY topics.date DESC"; 
						else if($dir == 'a')
							$order .= " GROUP BY messages.topic_id ORDER BY topics.date ASC";
					}
					else if($sort == 'author'){
						if($dir == 'd')
							$order .= " GROUP BY messages.topic_id ORDER BY users.username DESC"; 
						else if($dir == 'a')
							$order .= " GROUP BY messages.topic_id ORDER BY users.username ASC";
					}
					else if($sort == 'comments' ){
						if($dir == 'd')
							$order .= " GROUP BY messages.topic_id ORDER BY com DESC"; 
						else if($dir == 'a')
							$order .= " GROUP BY messages.topic_id ORDER BY com ASC";
					}
// ----------------------------------------------------
$sqlpagina = $db -> query($order); 
$total = $sqlpagina ->num_rows;

 
/*
 if ($_cn <= $number || !$number)
{
    $_enable_pagination = FALSE;
}

*/
$adjacents = 3;
//$targetpage = "pagination.php"; //your file name ==> cn_url_modify
//$limit = 12; //how many items to show per page ==> per_page

//$page = (isset($_GET['per_page']) ? $_GET['page']:0);
//$page = (isset($_GET['page']) ? $_GET['page']:0);



if($page)
	$start = ($page - 1) * $per_page; //first item to display on this page
else{
	$start = 0;
}

/* Setup page vars for display. */
if ($page == 0) $page = 1; //if no page var is given, default to 1.
$prev = $page - 1; //previous page is current page - 1
$next = $page + 1; //next page is current page + 1
$lastpage = ceil($total/$per_page); //lastpage.
$lpm1 = $lastpage - 1; //last page minus 1


$ordershow = $order;
$ordershow .= " LIMIT $start ,$per_page;";
//$sql_query = $db->query($sql2);

echo " start: " . $start . "<br>";
echo " per_page: " . $per_page . "<br>";
echo " page: " . $page . "<br>";

/* CREATE THE PAGINATION */

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





// ----------------------------------------------------
		// clear differs for cn_url_*
	
	unset($_GET['forum_filters'], $_GET['user_filters'], $_GET['rm_forum_filter'], $_GET['rm_user_filter']);
   
     cn_assign('mod, act, sort, dir, start, per_page,  page,  forums_filters, users_filters',
              $mod, $act, $sort, $dir, $start, $per_page, $page,  $cfilter, $ufilter);
	
    cn_assign('year_selected, mon_selected, day_selected',
				$YS, $MS, $DS);
    
	
    // ----------------------------------------------------
}