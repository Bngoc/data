<?php

session_start();
define('BQN_MU',	true);
//require("config.php");
require("config.php");
require_once("./includes/functions.php");
require_once './includes/cn_url_modify.php';
/*
// ------------------------------------------------------------
echo "USER: " . $_SERVER['HTTP_USER_AGENT'] . '<br>';
//$gh = pf_script_with_get($SCRIPT_NAME); echo "SCRIPT_NAME_ham: " . $gh . "<br>"; 
$ghh = pf_script_with_get($_SERVER['HTTP_REFERER']); echo "HTTP_REFERER_SCRIPT_NAME: " . $ghh . "<br>"; //exit();
$ghh = pf_script_with_get($_SERVER['REQUEST_URI']); echo "REQUEST_URI_SCRIPT_NAME: " . $ghh . "<br>"; //exit();
echo 'SCRIPT_NAME: '. $_SERVER['SCRIPT_NAME'].'<br>';
echo 'HTTP_REFERER: '. $_SERVER['HTTP_REFERER'].'<br>';
echo 'PHP_SELF: '. $_SERVER['PHP_SELF'].'<br>';
echo 'REQUEST_URI: '. $_SERVER['REQUEST_URI'].'<br>';
//echo 'PATH_INFO: '. $_SERVER['PATH_INFO'].'<br>';
// ------------------------------------------------------------
*/

if( $opensite == 0 ) {
	echo "<center><b> WebSite tam thoi bao tri de nang cap.<br>Mong cac ban quay tro lai sau</b></center>";
	exit();
}


require_once("header.php");
$_SESSION['URL'] = $_SERVER['REQUEST_URI'];

if(isset($_SESSION['ADMIN']) == TRUE) {
	include_once("security.php");
	echo "[<a href='admin/addcat.php'>Add new category</a>]";
	echo "[<a href='admin/addforum.php'>Add new forum</a>]";
	}
else{
	//echo "[<a href='admin.php'>Login</a>]";
}
$dates = 'dates';
echo ' <a href="'.cn_url_modify('mod=ditnews' , 'fffffffffffffffffff') .'" '.($dates == 'dates'?'class="bd"':'').'>date</a> /';
//$kq = $db->execute($catsql);
//$row = $kq->fetchrow();
//echo $row[0] . "_" . $row[1]; //exit();
//$Email = stripslashes($Email);
//$Password = stripslashes($Password);
//$Email = mysql_real_escape_string($Email);
//$Password = mysql_real_escape_string($Password);

$catsql = "SELECT * FROM categories;";
$catresult =$db->query($catsql); //mysqli_query($db,$catsql);

if($catresult ->num_rows==0){
	echo"
		<font style='color:red'>Non-Object!</font>
	";
}
else{
echo "<table cellspacing=0>";

while($catrow = $catresult->fetch_assoc()) { //  while ($row = mysqli_fetch_assoc($result)) {
	
	echo "<tr class='head'><td colspan=2>";
	echo "<strong>" . $catrow['name'] . "</strong></td>";
	
	if(isset($_SESSION['ADMIN'])) {
		include_once("security.php");
		//require_once('header.php');
		echo "
		<td> <a href='admin/delete.php?func=cat&id=" . $catrow['id'] . "' title= '[Delete]" . $catrow['name'] . "' onclick= 'return checkDelete()'>
		<button> X </button></a> - ";
		
		echo "
			<a href='admin/update.php?func=cat&id=" . $catrow['id'] . "' title= '[Edit]" . $catrow['name'] . "'> <button>Edit</button></a> 
		";
		echo "</td>";
		//include('templates/templates_cat.html');
	}
	echo "<tr>";

	$forumsql = "SELECT * FROM forums_1 WHERE cat_id = " . $catrow['id'] . ";";
	$forumresult = mysqli_query($db,$forumsql); //$forumresult = $db ->query($forumsql);
	$forumnumrows = $forumresult->num_rows;
	
	if($forumnumrows == 0) {
		echo "<tr><td>No forums!</td></tr>";
	}
	else {
		while($forumrow =$forumresult->fetch_assoc()) {
			//echo "<tr><td>";
			echo "<tr class=''><td colspan=2>";
			
			echo "<strong><a href='modules/viewforum.php?id=" . $forumrow['id'] . "' title= '" . $forumrow['description'] . "'>" . $forumrow['name'] . "</a></strong>
			<br/><i>" . $forumrow['description'] . "</i>";//"</td>";
			
			
					
			echo "</td>";

			echo "<td>";
			
			if(isset($_SESSION['ADMIN'])) {
				include_once("security.php");
				echo "<a href='admin/delete.php?func=forum&id=" . $forumrow['id'] . "' title= '[Delete]" . $forumrow['name'] . "' onclick= 'return checkDelete()'>X</a> - ";
				
				echo "
					<a href='admin/update.php?func=forus&id=" . $forumrow['id'] . "' title= '[Edit]" . $forumrow['name'] . "' onclick= 'return checkDelete()'> <button>Edit</button></a> 
				";
			}
			echo "</td></tr>";
			
		}
	}
}

echo "</table>";
}
require_once("footer.php");

?>