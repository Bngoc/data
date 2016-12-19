<?php
include("config.php");

$sql = $db -> query("select * from topics"); 
$total = $sql ->num_rows;

/* $pages  = $number ? (intval($_cn / $number) + (($_cn % $number == 0) ? 0 : 1)) : 0; 
if ($_cn <= $number || !$number)
{
    $_enable_pagination = FALSE;
}

*/
$adjacents = 3;
$targetpage = "pagination.php"; //your file name
$limit = 12; //how many items to show per page
$page = (isset($_GET['page']) ? $_GET['page']:0);

if($page){ 
	$start = ($page - 1) * $limit; //first item to display on this page
}
else{
	$start = 0;
}

/* Setup page vars for display. */
if ($page == 0) $page = 1; //if no page var is given, default to 1.
$prev = $page - 1; //previous page is current page - 1
$next = $page + 1; //next page is current page + 1
$lastpage = ceil($total/$limit); //lastpage.
$lpm1 = $lastpage - 1; //last page minus 1

$sql2 = "select * from topics name where 1=1";
$sql2 .= " order by id  limit $start ,$limit ";
$sql_query = $db->query($sql2);


//echo " tong " . $lastpage . "<br>";


/* CREATE THE PAGINATION */

$pagination = "";
if($lastpage > 1){ 
	$pagination .= "<div class='light-theme simple-pagination pagination'> <ul>";
	
	if ($page > 1) {
		$pagination.= "<li><a href=\"$targetpage?page=$prev\" class='page-link prev'>Prev</a></li>"; 
	}
	elseif($page ==1)
		$pagination.= "<li><a rel='nofollow' href='' class='current'>Prev</a></li>"; 
	
	if ($lastpage < 7 + ($adjacents * 2)) { // so trang < 13 = so bt hien thi
		for ($counter = 1; $counter <= $lastpage; $counter++){
			if ($counter == $page)
				$pagination.= "<li><a rel='nofollow' href='#' class='current'>$counter</a></li>";
			else
				$pagination.= "<li><a href=\"$targetpage?page=$counter\" class='page-link'>$counter</a></li>"; 
		}
	}
	elseif($lastpage > 5 + ($adjacents * 2)){ //enough pages to hide some so trang >11
		//close to beginning; only hide later pages
		if($page < 1 + ($adjacents * 2)) { //  hien tai < 7...... => hientai 1 2 3 4 5 6 7 => hien 1 2 3 4 5 6 7 8 9
			for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){ //$counter < 9 + (2 tr cuoi)
				if ($counter == $page)
					$pagination.= "<li><a rel='nofollow' href='#' class='current'>$counter</a></li>";
				else
					$pagination.= "<li><a href=\"$targetpage?page=$counter\" class='page-link'>$counter</a></li>"; 
			}
			
			$pagination.= "<li>...</li>";
			$pagination.= "<li><a href=\"$targetpage?page=$lpm1\" class='page-link'>$lpm1</a></li>";
			$pagination.= "<li><a href=\"$targetpage?page=$lastpage\" class='page-link'>$lastpage</a></li>"; 
		}
		//in middle; hide some front and some back
		elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){ // so tr - 6 > hientai  hienta > 6
			
			$pagination.= "<li><a href=\"$targetpage?page=1\" class='page-link'>1</a></li>"; 		// trang dau 1
			$pagination.= "<li><a href=\"$targetpage?page=2\" class='page-link'>2</a></li>";	 	// trang thu 2
			$pagination.= "<li>...</li>";
			for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){ // 1 2 3 hientai 5 6 7  (tong 7)
				
				if ($counter == $page)
					$pagination.= "<li><a rel='nofollow' href='#' class='current'>$counter</a></li>";
				else
					$pagination.= "<li><a href=\"$targetpage?page=$counter\" class='page-link'>$counter</a></li>"; 
			}
			
			$pagination.= "<li>...</li>";
			
			$pagination.= "<li><a href=\"$targetpage?page=$lpm1\" class='page-link'>$lpm1</a></li>"; // trang cuoi - 1
			$pagination.= "<li><a href=\"$targetpage?page=$lastpage\" class='page-link'>$lastpage</a></li>";  // trang cuoi 
			
		}
			//close to end; only hide early pages
		else{
			$pagination.= "<li><a href=\"$targetpage?page=1\" class='page-link'>1</a></li>";
			$pagination.= "<li><a href=\"$targetpage?page=2\" class='page-link'>2</a></li>";
			$pagination.= "<li>...</li>";
			
			for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){  // chi so = tong - 8; chi so < tong class="current"
				if ($counter == $page){
					$pagination.= "<li><a rel='nofollow' href='#' class='current'>$counter</a></li>";
				}
				else{
					$pagination.= "<li><a href=\"$targetpage?page=$counter\" class='page-link'>$counter</a></li>"; 
				}
			}
		}
	}

	//next button
	if (($page >= 1) && $page < $lastpage){
		$pagination.= "<li><a href=\"$targetpage?page=$next\" class='page-link'>Next</a></li>";
	}
	elseif($page == $lastpage){
		$pagination.= "<li><a rel='nofollow' href='' class='current'>Next</a></li>";
	}
	
	$pagination.= "</ul></div>\n"; 
}


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Pagination</title>
<style>
.pagination1 {
margin:0; 
padding:0;
float:left;
}
.pagination1 ul {
width:600px;
float: right;
list-style: none;
margin:0 0 0 ;
padding:0;
}
.pagination1 li span { line-height:45px; font-weight:bold;}
.pagination1 li {
margin:0 0 0 0;
float:left;
font-size:16px;
text-transform:uppercase;
}
.pagination1 li a {
color:#7f8588;
padding:10px 0 0 0; width:33px; height:33px;
text-decoration:none; text-align:center;
-webkit-border-radius: 5px;
-moz-border-radius: 5px;
display:block;
}
.pagination1 li:last-child a:hover { background:none; color:#7f8588;}
.pagination1 li:first-child a:hover { background:none;color:#7f8588;}
.pagination1 li a:hover {
color:#fff;
text-decoration: none;
display: block;
padding:10px 0 0 0; width:33px; height:33px;
}
.pagination1 li.activepage a { 
color:#fff;
text-decoration: none;
padding: 10px 0 0 0; }

//------------------------------------------------------------
//------------------------------------------------------------
/**
* CSS themes for simplePagination.js
* Author: Flavius Matis - http://flaviusmatis.github.com/
* URL: https://github.com/flaviusmatis/simplePagination.js
*/

.pagination-holder {
    padding: 0px 20px;
    margin: 10px 0px 20px;
}

.simple-pagination {
	display: block;
	overflow: hidden;
	padding: 0 5px 5px 0;
	margin: 0;
}

.simple-pagination ul {
	list-style: none;
	padding: 0;
	margin: 0;
}

.simple-pagination li {
	list-style: none;
	padding: 0;
	margin: 0;
	float: left;
}

/*------------------------------------*\
	Light Theme Styles
\*------------------------------------*/

.light-theme a, .light-theme span {
	float: left;
	text-decoration: none;
	color: #666;
	font-size:14px;
	line-height:24px;
	font-weight: normal;
	text-align: center;
	border: 1px solid #BBB;
	min-width: 14px;
	padding: 0 7px;
	margin: 0 5px 0 0;
	border-radius: 3px;
	box-shadow: 0 1px 2px rgba(0,0,0,0.2);
	background: #efefef; /* Old browsers */
	background: -moz-linear-gradient(top, #ffffff 0%, #efefef 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#efefef)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #ffffff 0%,#efefef 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #ffffff 0%,#efefef 100%); /* Opera11.10+ */
	background: -ms-linear-gradient(top, #ffffff 0%,#efefef 100%); /* IE10+ */
	background: linear-gradient(top, #ffffff 0%,#efefef 100%); /* W3C */
}

.light-theme a.page-link:hover {
	text-decoration: none;
	background: #FCFCFC;
}

.light-theme .current {
	background: #666;
	color: #FFF;
	border-color: #444;
	box-shadow: 0 1px 0 rgba(255,255,255,1), 0 0 2px rgba(0, 0, 0, 0.3) inset;
	cursor: default;
}

.light-theme .ellipse {
	background: none;
	border: none;
	border-radius: 0;
	box-shadow: none;
	font-weight: bold;
	cursor: default;
}

//------------------------------------------------------------


</style>
</head>

<body>

<?php 
	while($curnm = mysqli_fetch_array($sql_query)){
		print $curnm['id']." - ".$curnm['subject']."<br>";
	}

echo $pagination; 
?>
</body>

</html>
