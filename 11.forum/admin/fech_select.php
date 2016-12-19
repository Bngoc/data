<?php
include_once("security.php");
session_start();

require_once("../config.php");
require('../includes/functions.php');


if(isset($_SESSION['ADMIN']) == FALSE) {
	header("Location: " . $config_basedir . "/admin.php?ref=forum");
}

if($_REQUEST){
	//$id = intval($_GET['id']);
	$id = $_REQUEST['id'];
?>

<form name="form1" method="post" action="">
	<span><input class="checkbx" name="checkbox[]" type="checkbox" id="checkbox[]" value=""></span>
	<span class ="cotid" >ID</span>
	<span class ="cotid">Cat_id</span>
	<span class ="cotname">Name</span>
	<!--span class ="cotdescri">Description</span-->
	<?php
	$catsql1 = "SELECT * FROM forums WHERE cat_id=" . $id . ";";
	$catresult1 =$db->query($catsql1);
	if($catresult1 ->num_rows==0){
		echo"<font style='color:red'>Non-Object!</font>";
	}
	else{
		while($catrow1 = $catresult1 ->fetch_assoc()){
	?>
	<li>
		<span><input name="checkbox[]" type="checkbox" id="checkbox[]" value="<? echo $catrow1['id']; ?>"></span>
		<span class ="cotid" ><?php echo $catrow1['id']; ?></span>
		<span class ="cotid"><?php echo $catrow1['cat_id']; ?></span>
		<span class ="cotname"><?php echo $catrow1['name']; ?></span>
		<!--span class ="cotdescri"><?php //echo $catrow1['description']; ?></span-->
	</li>

	<?php
	}
		}
	?>

	<li>
	<span><input name="delete" type="submit" id="delete" value="Delete"></span>
	</li>

	<?php
		/*
	// Check if delete button active, start this 
	if($delete){
	for($i=0;$i<$count;$i++){
	$del_id = $checkbox[$i];
	$sql = "DELETE FROM $tbl_name WHERE id='$del_id'";
	$result = mysql_query($sql);
	}
	// if successful redirect to delete_multiple.php 
	if($result){
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=delete_multiple.php\">";
	}
	}
	mysql_close();
	*/?>

</form>

<?php
//}
?>