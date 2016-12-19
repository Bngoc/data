<?php if (!defined('BQN_MU')) { die('Access restricted'); }

session_start();

require("../config.php");
require("../includes/functions.php");

/*
// ------------------------------------------------------------
$gh = pf_script_with_get($SCRIPT_NAME); echo "SCRIPT_NAME_ham: " . $gh . "<br>"; 
$ghh = pf_script_with_get($_SERVER['REQUEST_URI']); echo "REQUEST_URI_SCRIPT_NAME: " . $ghh . "<br>"; //exit();
$ghh = pf_script_with_get($_SERVER['HTTP_REFERER']); echo "HTTP_REFERER_SCRIPT_NAME: " . $ghh . "<br>"; //exit();
echo 'SCRIPT_NAME: '. $_SERVER['SCRIPT_NAME'].'<br>';
echo 'HTTP_REFERER: '. $_SERVER['HTTP_REFERER'].'<br>';
echo 'PHP_SELF: '. $_SERVER['PHP_SELF'].'<br>';
echo 'REQUEST_URI: '. $_SERVER['REQUEST_URI'].'<br>';
echo 'PATH_INFO: '. $_SERVER['PATH_INFO'].'<br>';
// ------------------------------------------------------------
*/

$forchecksql = "SELECT * FROM forums;";
$forcheckresult = mysqli_query($db,$forchecksql);
$forchecknumrows = $forcheckresult->num_rows;

if($forchecknumrows == 0) {
	header("Location: " . $config_basedir);
}

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
	$validforum = 0;
}

//if(isset($_SESSION['USERNAME']) == FALSE){
	//header("Location: " . $config_basedir . "/login.php?ref=newpost&id=" . $validforum);
//}

 // exit();
  
if((isset($_SESSION['USERNAME']) == FALSE) && (isset($_SESSION['ADMIN']) == false)){ //bqn
	header("Location: " . $config_basedir . "/modules/login.php?ref=newpost&id=" . $validforum);
	
}


if(isset($_POST['submit'])) {
	if($validforum == 0) {
		$topicsql = "INSERT INTO topics(date, user_id, forum_id, subject) VALUES(NOW()
			, " . $_SESSION['USERID'] 
			. ", " . $_POST['forum']
			. ", '" . $_POST['subject']
			. "');";
	}
	else {
			$topicsql = "INSERT INTO topics(date, user_id, forum_id, subject) VALUES(NOW()
			, " . $_SESSION['USERID']
			. ", " . $validforum
			. ", '" . $_POST['subject']
			. "');";
	}
	//echo $topicsql;
	//mysql_query($topicsql);
	
	if(!mysqli_query($db,$topicsql)){ //bqn
		die ('Topic_Error:'. mysqli_error()) ;//bqn
	}
	
	$topicid = $db->insert_id; //ham vua set id
	
	//echo $topicid; exit();
	$messagesql = "INSERT INTO messages(date, user_id, topic_id, subject, body) VALUES(NOW()
		, " . $_SESSION['USERID']
		. ", " . $topicid //mysqli_insert_id()
		. ", '" . $_POST['subject']
		. "', '" . $_POST['body']	
		. "');";
	//echo $messagesql;exit();
	//mysql_query($messagesql);
	if(mysqli_query($db,$messagesql)){ //if (!$db->multi_query($sql))
		header("Location: " . $config_basedir . "/modules/viewmessages.php?id=" . $topicid);
	}
	else{
		die("Messager_Error: " . mysqli_error());
	}
}
else {
	require("../header.php");

	if($validforum != 0) {
		$namesql = "SELECT name FROM forums WHERE id =" . $validforum . " ORDER BY name;";
		$nameresult = mysqli_query($db,$namesql);
		$namerow = $nameresult->fetch_assoc();
		
		echo "<h2>Post new message to the " . $namerow['name'] . " forum</h2>";
	}
	else {
		echo "<h2>Post a new message</h2>";
	}


?>
	<form action="" method="post">
	<?php echo pf_script_with_get($SCRIPT_NAME); ?>
	<table>
	<?php
	
	if($validforum == 0) {
		$forumssql = "SELECT * FROM forums ORDER BY name;";
		$forumsresult = $db->query($forumssql);
	?>
		<tr>
			<td>Forum</td>
			<td>
			<select name="forum">
			<?php
			while($forumsrow = $forumsresult->fetch_assoc()) {
				echo "<option value='" . $forumsrow['id'] . "'>" . $forumsrow['name'] . "</option>";
			}
			?>
			</select>
			</td>
		</tr>
	<?php
	}
	?>
	
	<tr>
		<td>Subject</td>
		<td><input type="text" name="subject"></td>
	</tr>
	<tr>
		<td>Body</td>
		<td><textarea name="body" rows="10" cols="50"></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Post!"></td>
	</tr>
	</table>
	</form>

<?php
}


require("../footer.php");

?>