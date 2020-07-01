<?php
	include("security.php");
include_once('../config.php');

SESSION_start();
if ($_POST[submit]) {
	$pass_online = md5($_POST[online]);
	if ($pass_online == "$passcode") $_SESSION['online'] = "$passcode";
}
if (!$_SESSION['online'] || $_SESSION['online'] != "$passcode") {
	echo "<center><form action='' method=post>
	Code: <input type=password name=online> <input type=submit name=submit value=Submit>
	</form></center>
	";
	exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/tooltip.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.body {
	font-size: 14px;
}
tr {
	font-size: 14px;
}
td {
	font-size: 14px;
}
a:link,a:visited,a:hover,a:active {
	text-decoration: none;
}
-->
</style>
</head>
<body bgcolor="#FFFFFF">
<div id="dhtmltooltip"></div>
<img id="dhtmlpointer" src="images/tooltiparrow.gif">
<table cellspacing='2' width='100%' border='0'>
	<tr>
		<td><a href='index.php' target='_self'>Quản lý MU</a></td>
		<td><a href='cardphone.php' target='_self'>Nạp thẻ</a></td>
		<td><a href='view_card.php' target='_self'>Xem thẻ</a></td>
		<td><a href='online.php' target='_self'>Đang Online</a></td>
		<td><a href='topmu.php' target='_self'>TOP MU</a></td>
		<td><a href='../log/' target='_self'>LOG MU</a></td>
	</tr>
</table>
<hr>
<?php

	$fpage = intval($_GET['page']);
	if(empty($fpage)){ $fpage = 1; }

	$query_total_acc = "SELECT Count(*) FROM MEMB_INFO";
	$result_total_acc = $db->Execute($query_total_acc);
	$total_acc = $result_total_acc->fetchrow();

	$query_total_char = "SELECT Count(*) FROM Character";
	$result_total_char = $db->Execute($query_total_char);
	$total_char = $result_total_char->fetchrow();
	
	$query = "Select memb___id,ServerName from Memb_Stat where ConnectStat='1' order by ServerName ASC";
	$result = $db->Execute($query);
	$total_char_online = $result->numrows();

$count_SV	=	count($server);
	for ($i=0;$i<$count_SV;$i++) {
		$query_Sub[$i] = "Select * from Memb_Stat where ConnectStat='1' and ServerName='$server[$i]'";
		$result_Sub[$i] = $db->Execute($query_Sub[$i]);
		$total_char_online_Sub[$i] = $result_Sub[$i]->numrows();
	}
?>

<table width="100%" cellspacing="1" cellpadding="3" border="0" bgcolor="#0000ff">
<tr bgcolor="#ffffcc" >
	<td colspan="7" align="center">
		Tài khoản: <b><font color="red"><?php echo "$total_acc[0]"; ?></font></b> | Nhân vật: <b><font color="red"><?php echo "$total_char[0]"; ?></font></b> | Đang chơi: <b><font color="red"><?php echo "$total_char_online"; ?></font></b><br>
		<table width="80%" cellspacing="2" cellpadding="3" border="0">
			<tr>
				<?php for($i=0;$i<$count_SV;$i++) { ?>
				<td align="center"><?php echo $server[$i]; ?> : <b><font color="red"><?php echo $total_char_online_Sub[$i]; ?></font></b></td>
				<?php } ?>
			</tr>
		</table>
	</td>
</tr>
<tr bgcolor="#ffffcc" >
	<td align="center">#</td>
	<td align="center">Nhân vật</td>
	<td align="center">ReLife</td>
	<td align="center">ReSet</td>
	<td align="center">Class</td>
	<td align="center">Server</td>
	<td align="center">Map</td>
</tr>


<?php
	$startpage = ($fpage-1)*15;
	$endpage = $fpage*15-1;

for($i=0;$i<$total_char_online;++$i)
{
$row = $result->fetchrow();

if ($i>=$startpage && $i<=$endpage) {

$query3="Select GameIDC from AccountCharacter where Id='$row[0]'";
$result3 = $db->Execute($query3);
$row3 = $result3->fetchrow();

$query2="Select Resets,Class,Clevel,Strength,Dexterity,Vitality,Energy,MapNumber,MapPosX,MapPosY,PkLevel,PkCount,Leadership,LevelUpPoint,ctlcode,relifes from Character where Name='$row3[0]'";
$result2 = $db->Execute($query2);
$row2 = $result2->fetchrow();

$rank = $i+1;

if ($row2[3] < 0) {$row2[3] = $row2[3]+65536;}
if ($row2[4] < 0) {$row2[4] = $row2[4]+65536;}
if ($row2[5] < 0) {$row2[5] = $row2[5]+65536;}
if ($row2[6] < 0) {$row2[6] = $row2[6]+65536;}
if ($row2[12] < 0) {$row2[12] = $row2[12]+65536;}

if ($row[3] != 64) {
		$total_stat = $row2[3] + $row2[4] + $row2[5] + $row2[6];
}
else {$total_stat = $row2[3] + $row2[4] + $row2[5] + $row2[6] + $row2[12];}

if ($row2[10] == 1){$PkLevel = 'Siêu Anh Hùng';}
elseif ($row2[10] == 2){$PkLevel = 'Anh Hùng';}
elseif ($row2[10] == 3){$PkLevel = 'Dân Thường';}
elseif ($row2[10] == 4){$PkLevel = 'Sát Thủ';}
elseif ($row2[10] == 5){$PkLevel = 'Sát Thủ Khát Máu';}
elseif ($row2[10] == 6){$PkLevel = 'Sát Thủ Điên Cuồng';}

if($row2[1] == 0){ $row2[1] ='Dark Wizard';
}
if($row2[1] == 1){ $row2[1] ='Soul Master';
}
if($row2[1] == 2){ $row2[1] ='Grand Master';
}
if($row2[1] == 16){ $row2[1] ='Dark Knight';
}
if($row2[1] == 17){ $row2[1] ='Blade Knight';
}
if($row2[1] == 18){ $row2[1] ='Blade Master';
}
if($row2[1] == 32){ $row2[1] ='Elf';
}
if($row2[1] == 33){ $row2[1] ='Muse Elf';
}
if($row2[1] == 34){ $row2[1] ='Hight Elf';
}
if($row2[1] == 48){ $row2[1] ='Magic Gladiator';
}
if($row2[1] == 49){ $row2[1] ='Duel Master';
}
if($row2[1] == 64){ $row2[1] ='DarkLord';
}
if($row2[1] == 65){ $row2[1] ='Lord Emperor';
}
if($row2[1] == 80){ $row2[1] ='Sumoner';
}
if($row2[1] == 81){ $row2[1] ='Bloody Summoner';
}
if($row2[1] == 82){ $row2[1] ='Dimension Master';
}

if($row2[7] == 0){ $row2[7] = 'Lorencia';
}
if($row2[7] == 1){ $row2[7] = 'Dungeon';
}
if($row2[7] == 2){ $row2[7] = 'Davias';
}
if($row2[7] == 3){ $row2[7] = 'Noria';
}
if($row2[7] == 4){ $row2[7] = 'LostTower';
}
if($row2[7] == 5){ $row2[7] = 'Exile';
}
if($row2[7] == 6){ $row2[7] = 'Stadium';
}
if($row2[7] == 7){ $row2[7] = 'Atlans';
}
if($row2[7] == 8){ $row2[7] = 'Tarkan';
}
if($row2[7] == 9){ $row2[7] = 'DevilSquare 1-2-3-4';
}
if($row2[7] == 10){ $row2[7] = 'Icarus';
}
if($row2[7] == 11){ $row2[7] = 'BloodCastle 1';
}
if($row2[7] == 12){ $row2[7] = 'BloodCastle 2';
}
if($row2[7] == 13){ $row2[7] = 'BloodCastle 3';
}
if($row2[7] == 14){ $row2[7] = 'BloodCastle 4';
}
if($row2[7] == 15){ $row2[7] = 'BloodCastle 5';
}
if($row2[7] == 16){ $row2[7] = 'BloodCastle 6';
}
if($row2[7] == 17){ $row2[7] = 'BloodCastle 7';
}
if($row2[7] == 18){ $row2[7] = 'ChaosCastle 1';
}
if($row2[7] == 19){ $row2[7] = 'ChaosCastle 2';
}
if($row2[7] == 20){ $row2[7] = 'ChaosCastle 3';
}
if($row2[7] == 21){ $row2[7] = 'ChaosCastle 4';
}
if($row2[7] == 22){ $row2[7] = 'ChaosCastle 5';
}
if($row2[7] == 23){ $row2[7] = 'ChaosCastle 6';
}
if($row2[7] == 24){ $row2[7] = 'Kalima 1';
}
if($row2[7] == 25){ $row2[7] = 'Kalima 2';
}
if($row2[7] == 26){ $row2[7] = 'Kalima 3';
}
if($row2[7] == 27){ $row2[7] = 'Kalima 4';
}
if($row2[7] == 28){ $row2[7] = 'Kalima 5';
}
if($row2[7] == 29){ $row2[7] = 'Kalima 6';
}
if($row2[7] == 30){ $row2[7] = 'Loren Deep';
}
if($row2[7] == 31){ $row2[7] = 'Land Of Trials';
}
if($row2[7] == 32){ $row2[7] = 'Devil Square 5-6';
}
if($row2[7] == 33){ $row2[7] = 'Aida';
}
if($row2[7] == 34){ $row2[7] = 'CryWolf';
}
if($row2[7] == 35){ $row2[7] = 'Devil Square';
}
if($row2[7] == 36){ $row2[7] = 'Kalima 7';
}
if($row2[7] == 37){ $row2[7] = 'Kantru 1';
}
if($row2[7] == 38){ $row2[7] = 'Kantru 2';
}
if($row2[7] == 39){ $row2[7] = 'Kantru Ref';
}
if($row2[7] == 40){ $row2[7] = 'Silent Map';
}
if($row2[7] == 41){ $row2[7] = 'Balgass Barrack';
}
if($row2[7] == 42){ $row2[7] = 'Balgass Refuge';
}
if($row2[7] == 45){ $row2[7] = 'Illusion Temple 1';
}
if($row2[7] == 46){ $row2[7] = 'Illusion Temple 2';
}
if($row2[7] == 47){ $row2[7] = 'Illusion Temple 3';
}
if($row2[7] == 48){ $row2[7] = 'Illusion Temple 4';
}
if($row2[7] == 49){ $row2[7] = 'Illusion Temple 5';
}
if($row2[7] == 50){ $row2[7] = 'Illusion Temple 6';
}
if($row2[7] == 51){ $row2[7] = 'Elbeland';
}
if($row2[7] == 56){ $row2[7] = 'Map 56';
}
if($row2[7] == 57){ $row2[7] = 'Raklion';
}
if($row2[7] == 58){ $row2[7] = 'Map 58';
}

	if($row2[14] != 8){ 
	echo"<tr bgcolor='#F9E7CF' >
		<td align='center'>$rank</td>
		<td align='center'><a href='#' onMouseOut='hidetip();' onMouseOver=\"showtip('Level: $row2[2]. Tổng số Point sử dụng: $total_stat, Point dư: $row2[13]. Tình trạng: $PkLevel, Giết người: $row2[11].');\">$row3[0]</a></td>
		<td align='center'>$row2[15]</td>
		<td align='center'>$row2[0]</td>
		<td align='center'>$row2[1]</td>
		<td align='center'>$row[1]</td>
		<td align='center'>$row2[7]: $row2[8] , $row2[9]</td>
	</tr>";
	}
} 
}
		
?>
												
</table>
<br>
<center>
<?php
$totalpages = ($total_char_online-1) / 15; 
		$totalpages = floor($totalpages)+1; 
		$c = 0;
		if ($totalpages > 0) {
			echo "Trang: [".$totalpages."] ";
		}
		while($c<$totalpages){
			$page = $c + 1;
			if($_GET['page']==$page){
				echo "[$page] ";
			}else{//else 
				echo "<a href=\"?page=$page\">[$page] </a> ";
			} 
			$c = $c+1; 
		} 
?>
</center>
<script type="text/javascript" src="js/tooltip.js"></script>
</body>
</html>