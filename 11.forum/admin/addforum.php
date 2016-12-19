<?php
include_once("security.php");
session_start();

require_once("../config.php");
require('../includes/functions.php');


if(isset($_SESSION['ADMIN']) == FALSE) {
	header("Location: " . $config_basedir . "/admin.php?ref=forum");
}

if(isset($_POST['submit'])) {
	$topicsql = "INSERT INTO forums(cat_id, name, description) VALUES("
		. $_POST['cat']
		. ", '" . $_POST['name']
		. "', '" . $_POST['description']
		. "');";
	
	$db->query($topicsql);

	header("Location: " . $config_basedir);
}
else {
	require("../header.php");	
?>
	<h2>Add a new forum</h2>
	
	<form action="" method="post"><?php echo pf_script_with_get($SCRIPT_NAME); ?>
	<table>
	<?php
	
	if($validforum == 0) {
		$forumssql = "SELECT * FROM categories ORDER BY name;";
		$forumsresult = $db->query($forumssql);
	?>
		<tr>
			<td>Forum</td>
			<td>
			<select name="cat">
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
		<td>Name</td>
		<td><input type="text" name="name"></td>
	</tr>
	<tr>
		<td>Description</td>
		<td><textarea name="description" rows="10" cols="50"></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Add Forum!"></td>
	</tr>
	</table>
	</form>

<?php
}

require("../footer.php");

?>