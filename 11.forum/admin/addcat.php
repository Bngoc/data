<?php
include_once("security.php");
session_start();
//require('admin/sseeccuu.php');
require("../config.php");
require("../includes/functions.php");

if(isset($_SESSION['ADMIN']) == FALSE) {
	header("Location: " . $config_basedir . "/admin.php?ref=cat");
}

if($_POST['submit']) {

	$catsql = "INSERT INTO categories(name) VALUES('" . $_POST['cat'] . "');";	
	$db ->query($catsql);

	header("Location: " . $config_basedir);
}
else {
	require("../header.php");

?>
	<h2>Add a new category</h2>
	<?php echo pf_script_with_get($SCRIPT_NAME); ?>
	<form action="" method="post">
	<table>
	<tr>
		<td>Category</td>
		<td><input type="text" name="cat"></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Add Category!"></td>
	</tr>
	</table>
	</form>

<?php
}

require("../footer.php");

?>