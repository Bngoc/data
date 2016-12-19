<?php define('BQN_MU',	true);

session_start();
include("../config.php");
require_once("../includes/functions.php");

/*
// ------------------------------------------------------------
//$gh = pf_script_with_get($SCRIPT_NAME); echo "SCRIPT_NAME_ham: " . $gh . "<br>"; 
$ghh = pf_script_with_get($_SERVER['HTTP_REFERER']); echo "HTTP_REFERER_SCRIPT_NAME: " . $ghh . "<br>"; //exit();
$ghh = pf_script_with_get($_SERVER['REQUEST_URI']); echo "REQUEST_URI_SCRIPT_NAME: " . $ghh . "<br>"; //exit();
echo 'SCRIPT_NAME: '. $_SERVER['SCRIPT_NAME'].'<br>';
echo 'HTTP_REFERER: '. $_SERVER['HTTP_REFERER'].'<br>';
echo 'PHP_SELF: '. $_SERVER['PHP_SELF'].'<br>';
echo 'REQUEST_URI: '. $_SERVER['REQUEST_URI'].'<br>';
echo 'PATH_INFO: '. $_SERVER['PATH_INFO'].'<br>';
// ------------------------------------------------------------
*/

$_SESSION['URL'] = $_SERVER['REQUEST_URI'];

if(isset($_GET['id']) == TRUE) {
	if(is_numeric($_GET['id']) == FALSE) {
		$error = 1;
	}

	if(isset($error) == 1) {
		header("Location: " . $config_basedir);
	}
	else {
		$validtopic = $_GET['id'];
	}
}
else {
	header("Location: " . $config_basedir);
}


echo $validtopic;
require("../header.php");


$topicsql = "SELECT topics.subject, topics.forum_id, forums.name FROM topics, forums WHERE topics.forum_id = forums.id AND topics.id = " . $validtopic . ";";
$topicresult = $db->query($topicsql);

$topicrow = $topicresult ->fetch_assoc();

echo "<h2>" . $topicrow['subject'] . "</h2>";

echo "<a href='../index.php'>" . $config_forumsname . " forums</a> -> <a href='viewforum.php?id=" . $topicrow['forum_id'] . "'>" . $topicrow['name'] . "</a>	<br /><br />";

//if(isset($_SESSION['USERNAME']) == TRUE){
	//$threadsql = "SELECT messages.*, users.username FROM messages, users WHERE messages.user_id = users.id AND messages.topic_id = " . $validtopic . " ORDER BY messages.date;";
	//$messnumrows = mysql_num_rows($threadresult);
//}

$threadsql = "SELECT messages.*, users.username FROM messages, users WHERE messages.user_id = users.id AND messages.topic_id = " . $validtopic . " ORDER BY messages.date;";
$threadresult = $db->query($threadsql);
$messnumrows = $threadresult->num_rows;
//echo $validforum;
//echo $topicresult[0];
//echo "so dong: $topicnumrows";
//exit();
if($messnumrows == 0) {
	echo "<table width='300px'><tr><td>No messages!</td></tr></table>";
}
else{
echo "<table>";

if(isset($_SESSION['USERNAME'])){
	$iduser = $_SESSION['USERID'];
	$checbool = true;
}



while($threadrow = $threadresult->fetch_assoc()) {
	//[<a href='delete.php?func=thread&id=" . $topicrow['topicid'] . "&forum=" . $validforum . "'>X</a>] - 
	echo "<tr class='head'><td>";
	if(isset($_SESSION['ADMIN']) == TRUE){ //||(isset($_SESSION['USERADMIN']) == 'Admin')){
		echo"
			<a href='../admin/delete.php?func=mes&id=" . $threadrow['id'] . "&messages=" . $validtopic . "'  onclick= 'return checkDelete()' title= '[Delete]" . $threadrow['subject'] . "'>X</a> -
		";
		echo"
			<a href='../admin/update.php?func=mess&id=" . $threadrow['id'] . "&messages=" . $validtopic . "' title= '[Edit]" . $threadrow['subject'] . "'>Edit</a> -
		";
	}
	
	if(isset($_SESSION['USERADMIN'])){
		if($checbool){
			echo"
				<a href='delete.php?func=deformess&id=" . $validtopic . "&forum=" . 0 . "'  onclick= 'return checkDelete()' title= '[Delete]" . $threadrow['subject'] . "'> X </a> -
			";
				//<a href='delete.php?func=delmess&id=" . $threadrow['id'] . "&messages=" . $validtopic . "'  onclick= 'return checkDelete()' title= '[Delete]" . $threadrow['subject'] . "'>X</a> -
			
			echo"
				<a href='update.php?func=uformess&id=" . $threadrow['id'] . "&messages=" . $validtopic . "' title= '[Edit]" . $threadrow['subject'] . "'>Edit</a> -
			";
			$checbool = false;
		}
		else{
			echo"
				<a href='delete.php?func=dmess&id=" . $threadrow['id'] . "&messages=" . $validtopic . "'  onclick= 'return checkDelete()' title= '[Delete]" . $threadrow['subject'] . "'>X</a> -
			";
			echo"
				<a href='update.php?func=umess&id=" . $threadrow['id'] . "&messages=" . $validtopic . "' title= '[Edit]" . $threadrow['subject'] . "'>Edit</a> -
			";
		}
	}
	else if(isset($_SESSION['USERNAME']) == TRUE){
		if($checbool){
			if($iduser == $threadrow['user_id']){
				echo "
					<a href='delete.php?func=deformess&id=" . $validtopic . "&forum=" . 0 . "'  onclick= 'return checkDelete()' title= '[Delete]" . $threadrow['subject'] . "'> X </a> -
				";
					//<a href='delete.php?func=delmess&id=" . $threadrow['id'] . "&messages=" . $validtopic . "'  onclick= 'return checkDelete()' title= '[Delete]" . $threadrow['subject'] . "'>X</a> -
				
				echo "
					<a href='update.php?func=uformess&id=" . $threadrow['id'] . "&messages=" . $validtopic . "' title= '[Edit]" . $threadrow['subject'] . "'>Edit</a> -
				";
			}
			$checbool = false;
		}
		else{
			if($iduser == $threadrow['user_id']){
				echo"
					<a href='delete.php?func=dmess&id=" . $threadrow['id'] . "&messages=" . $validtopic . "'  onclick= 'return checkDelete()' title= '[Delete]" . $threadrow['subject'] . "'>X</a> -
				";
				echo"
					<a href='update.php?func=umess&id=" . $threadrow['id'] . "&messages=" . $validtopic . "' title= '[Edit]" . $threadrow['subject'] . "'>Edit</a> -
				";
			}
		}
	}
	
	echo"
		  <strong>Posted by <i>" . $threadrow['username'] . "</i> on " . date("Y-m-d h:ia", strtotime($threadrow['date'])) . " - <i>" . $threadrow['subject'] . "</i></strong></td>
	    </tr>";
	echo "<tr><td>" . $threadrow['body']. "</td></tr>";
	echo "<tr></tr>";
}

echo "<tr><td>[<a href='reply.php?id=" . $validtopic . "'>reply</a>]</td></tr>";

echo "</table>";
}

require("../footer.php");

?>