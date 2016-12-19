<?php
include_once("security.php");
session_start();

require_once("../config.php");
require('../includes/functions.php');


if(isset($_SESSION['ADMIN']) == FALSE) {
	header("Location: " . $config_basedir . "/admin.php?ref=forum");
}

if($_REQUEST ){//|| (isset($_GET['start']) && (int)$_GET['start'])){
	$id = $_REQUEST['id'];
	

$row_per_page=3;//<span class="Apple-tab-span" style="white-space: pre;"> </span>; //Số dòng trên 1 trang

/*
if ($rows>$row_per_page) 
	$page=ceil($rows/$row_per_page);
else $page=1; //nếu số dòng trong CSDL nhỏ hơn hoặc bằng số dòng trên 1 trang thì chỉ có 1 trang để hiển thị

if(isset($_GET['start']) && (int)$_GET['start'])
     $start=$_GET['start']; //dòng bắt đầu từ nơi ta muốn lấy
else $start=0;

$sql=mysql_query("select * from dangky order by id asc limit $start,$row_per_page"); //bắt đầu lấy dữ liệu (^)_(^)
*/
?>

<form name="form1" method="post" action="">
	<li>
	<span><input class="checkbx" name="checkbox[]" type="checkbox" id="checkbox[]" value=""></span>
	<span class ="cotid" >ID</span>
	<span class ="cotid">Date</span>
	<span class ="cotname">User_Id</span>
	<span class ="cotdescri">Forum_Id</span>
	<span class ="cotdescri">Subject</span>
	<li>
	<?php
		$catsql1 = "SELECT * FROM topics WHERE forum_id=" . $id . ";";
		$catresult1 =$db->query($catsql1);
		$numrows =$catresult1 ->num_rows;
	// ------------------------------------------
	
	if ($numrows>$row_per_page) 
		$page=ceil($numrows/$row_per_page);
	else $page=1; //nếu số dòng trong CSDL nhỏ hơn hoặc bằng số dòng trên 1 trang thì chỉ có 1 trang để hiển thị

	if(isset($_GET['start']) && (int)$_GET['start'])
		 $start=$_GET['start']; //dòng bắt đầu từ nơi ta muốn lấy
	else $start=0;
	
	$limitrows=$db ->query("SELECT * FROM topics WHERE forum_id=" . $id . " order by id asc limit " .$start . "," . $row_per_page . ";"); //bắt đầu lấy dữ liệu (^)_(^)
	//-- ------------------------------------------  -->
	if($numrows==0){
		echo"<font style='color:red'>Non-Object!</font>";
	}
	else{
		while($catrow1 = $limitrows ->fetch_assoc()){
	?>
	<li>
		<span><input name="checkbox[]" type="checkbox" id="checkbox[]" value="<? echo $catrow1['id']; ?>"></span>
		<span class ="cotid" ><?php echo $catrow1['id']; ?></span>
		<span class ="cotid"><?php echo $catrow1['date']; ?></span>
		<span class ="cotname"><?php echo $catrow1['user_id']; ?></span>
		<span class ="cotname"><?php echo $catrow1['forum_id']; ?></span>
		<span class ="cotdescri"><?php echo $catrow1['subject']; ?></span>
	</li>

	<?php
		}
	}
		$page_cr=($start/$row_per_page)+1;
		for($i=1;$i<=$page;$i++){
			if ($page_cr!=$i) echo "<div class='phantrang'><a href='ad.php?mod=Catagoris&act=delcat&id=" . $id ."&start=".$row_per_page*($i-1)."'>$i&nbsp;</a>"."</div>";
			else echo "<div class='phantrang'>".$i." "."</div>";
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
}
?>