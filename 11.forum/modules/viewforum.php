<?php define('BQN_MU',	true);

session_start();
require_once("../includes/functions.php");

/*
// ------------------------------------------------------------
$gh = pf_script_with_get($SCRIPT_NAME); echo "SCRIPT_NAME_ham: " . $gh . "<br>"; 
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
		$validforum = $_GET['id'];
	}
}
else {
	header("Location: " . $config_basedir);
}

require("../header.php");
/*
if((isset($_SESSION['USERNAME']) == FALSE) && (isset($_SESSION['ADMIN']) == false)) {
	header("Location: " . $config_basedir . "/login.php?ref=viewforum&id=" . $validforum);
}
*/

$forumsql = "SELECT * FROM forums WHERE id = " . $validforum . ";";
$forumresult = $db ->query($forumsql);

$forumrow = $forumresult ->fetch_assoc();

echo "<h2>" . $forumrow['name'] . "</h2>";

echo "<a href='" . $config_basedir ."/index.php'>" . $config_forumsname . " forums</a><br /><br />";

echo "<a href='newtopic.php?id=" . $validforum . "'>New Topic</a>";
echo "<br /><br />";

$topicsql = "SELECT MAX( messages.date ) AS maxdate, topics.id AS topicid, topics.*, users.* FROM messages, topics, users WHERE messages.topic_id = topics.id AND topics.user_id = users.id  AND topics.forum_id = " . $validforum . " GROUP BY messages.topic_id ORDER BY maxdate DESC;";
$topicresult = $db-> query($topicsql);
$topicnumrows = $topicresult ->num_rows;





//echo $validforum;
//echo $topicresult[0];
//echo "so dong: $topicnumrows";
//exit();
if($topicnumrows == 0) {
	echo "<table width='300px'><tr><td>No topics!</td></tr></table>";
}
else {

	echo "<table>";
	
	echo "<tr>";
	echo "<th>Topic</th>";
	echo "<th>Replies</th>";
	echo "<th>Author</th>";
	echo "<th>Date Posted</th>";
	echo "</tr>";
	if(isset($_SESSION['USERNAME'])){
		$idser = $_SESSION['USERID'];
	}
	while($topicrow = $topicresult ->fetch_assoc()) {
		$msgsql = "SELECT id FROM messages WHERE topic_id = " . $topicrow['topicid'];
		$msgresult = $db->query($msgsql);
		$msgnumrows = $msgresult ->num_rows;
	
		echo "<tr>";
		echo "<td>";
		
		if(isset($_SESSION['ADMIN']) ){
			echo "<a href='../admin/delete.php?func=thread&id=" . $topicrow['topicid'] . "&forum=" . $validforum . "' onclick= 'return checkDelete()' title= '[Delete]" . $topicrow['subject'] . "'>X</a> - ";
		}
		
		if(isset($_SESSION['USERADMIN'])){
			//if( $idser== $topicrow['user_id'])
				echo"
					<a href='delete.php?func=formess&id=" . $topicrow['topicid'] . "&forum=" . $validforum . "'  onclick= 'return checkDelete()' title= '[Delete]" . $topicrow['subject'] . "'> X </a> -
				";
		}
		else if(isset($_SESSION['USERNAME'])){// || isset($_SESSION['USERADMIN'])){
			if( $idser== $topicrow['user_id'])
				echo"
					<a href='delete.php?func=formess&id=" . $topicrow['topicid'] . "&forum=" . $validforum . "'  onclick= 'return checkDelete()' title= '[Delete]" . $topicrow['subject'] . "'> X </a> -
				";
		}
		
		
		echo "<strong><a href='viewmessages.php?id=" . $topicrow['topicid'] . "'>" . $topicrow['subject'] . "</a></td></strong>";
		echo "<td>" . $msgnumrows . "</td>";
		echo "<td>" . $topicrow['username'] . "</td>";
		echo "<td>" . date("Y-m-d h:ia", strtotime($topicrow['date'])) . "</td>"; //Y-m-d h:i:sa //D jS F Y g.iA
		echo "<tr>";
	}
	
	echo "</table>";

}

require("../footer.php");

?>