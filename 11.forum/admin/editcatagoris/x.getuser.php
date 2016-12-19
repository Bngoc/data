<?php
include_once("security.php");
session_start();

require_once("../config.php");
require('../includes/functions.php');
?>

<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
$row_per_page=3;

$q = intval($_GET['q']);
echo "q:" .$q;
exit();
//$catsql1 = "SELECT * FROM topics WHERE forum_id=". $q .";";
$catresult1 =$db->query($catsql1);
$numrows =$catresult1 ->num_rows;
// ------------------------------------------
if ($numrows>$row_per_page) 
	$page=ceil($numrows/$row_per_page);
else $page=1; //nếu số dòng trong CSDL nhỏ hơn hoặc bằng số dòng trên 1 trang thì chỉ có 1 trang để hiển thị

if(isset($_GET['start']) && (int)$_GET['start'])
 $start=$_GET['start']; //dòng bắt đầu từ nơi ta muốn lấy
else $start=0;

$limitrows=$db ->query("SELECT * FROM topics WHERE forum_id=" . $q . " order by id asc limit " .$start . "," . $row_per_page . ";"); //bắt đầu lấy dữ liệu (^)_(^)
//-- ------------------------------------------  -->
if($numrows==0){
	echo"<font style='color:red'>Non-Object!</font>";
}
else{

/*
$con = mysqli_connect('localhost','peter','abc123','my_db');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"ajax_demo");
$sql="SELECT * FROM user WHERE id = '".$q."'";
$result = mysqli_query($con,$sql);
*/
	echo "<table>
	<tr>
	<th>ID</th>
	<th>Date</th>
	<th>User_id</th>
	<th>Forum_id</th>
	<th>Subject</th>
	</tr>";
	while($catrow1 = $limitrows ->fetch_assoc()){ 
		echo "<tr>";
		echo "<td>" . $catrow1['id'] . "</td>";
		echo "<td>" . $catrow1['date'] . "</td>";
		echo "<td>" . $catrow1['user_id'] . "</td>";
		echo "<td>" . $catrow1['forum_id'] . "</td>";
		echo "<td>" . $catrow1['subject'] . "</td>";
		echo "</tr>";
	}
}
echo "</table>";
//mysqli_close($con);
$page_cr=($start/$row_per_page)+1;
for($i=1;$i<=$page;$i++){
	if ($page_cr!=$i) echo "<div class='phantrang'><a href='admin.php?mod=Catagoris&act=delcat&id=" . $q ."&start=".$row_per_page*($i-1)."'>$i&nbsp;</a>"."</div>";
	else echo "<div class='phantrang'>".$i." "."</div>";
}
?>
</body>
</html>