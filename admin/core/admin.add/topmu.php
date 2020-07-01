<?php
	include("security.php");
include_once('../config.php');
$top_type = $_GET['top_type'];
if(empty($top_type)){ $top_type = ''; }
$top_per_page = 15;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/tooltip.css" rel="stylesheet" type="text/css">
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
<table width="100%" cellspacing="1" cellpadding="3" border="0" bgcolor="#0000ff">
<tr bgcolor="#ffffcc" >
	<td align="center">#</td>
	<td align="center">Nhân vật</td>
	<td align="center">(RS/RL)</td>
	<td align="center">Class</td>
	<td align="center">Tình trạng</td>
</tr>

<?
$fpage = intval($_GET['page']);
if(empty($fpage)){ $fpage = 1; }
$fstart = ($fpage-1)*$top_per_page; 
$fstart = round($fstart,0);
$rank = $fstart;

$query = "SELECT AccountID,Name,Resets,Class,Clevel,Strength,Dexterity,Vitality,Energy,MapNumber,MapPosX,MapPosY,PkLevel,PkCount,Leadership,LevelUpPoint,relifes FROM Character ";
if ($top_type == 'DW') { $query .= "Where Class = 0 or Class = 1 or Class = 2 "; }
if ($top_type == 'DK') { $query .= "Where Class = 16 or Class = 17 or Class = 18 "; }
if ($top_type == 'Elf') { $query .= "Where Class = 32 or Class = 33 or Class = 34 "; }
if ($top_type == 'MG') { $query .= "Where Class = 48 OR Class = 49 OR Class = 50 "; }
if ($top_type == 'DL') { $query .= "Where Class = 64 OR Class = 65 OR Class = 66 "; }
if ($top_type == 'Su.M') { $query .= "Where Class = 80 or Class = 81 or Class = 82 "; }
$query .= "ORDER BY relifes DESC, resets DESC , cLevel DESC";
$result = $db->SelectLimit($query, $top_per_page, $fstart);

while($row = $result->fetchrow()) {
$query2="Select ConnectStat,ServerName from MEMB_STAT where memb___id='$row[0]'";
$result2 = $db->Execute($query2);
$row2 = $result2->fetchrow();

$query3="Select GameIDC from AccountCharacter where Id='$row[0]'";
$result3 = $db->Execute($query3);
$row3 = $result3->fetchrow();

$rank = $rank+1;

if ($row[5] < 0) {$row[5] = $row[5]+65536;}
if ($row[6] < 0) {$row[6] = $row[6]+65536;}
if ($row[7] < 0) {$row[7] = $row[7]+65536;}
if ($row[8] < 0) {$row[8] = $row[8]+65536;}
if ($row[14] < 0) {$row[14] = $row[14]+65536;}

if ($row[3] != 64 OR $row[3] != 65 OR $row[3] != 66) {
		$total_stat = $row[5] + $row[6] + $row[7] + $row[8];
}
else {$total_stat = $row[5] + $row[6] + $row[7] + $row[8] + $row[14];}


if ($row[12] == 1){$PkLevel = 'Siêu Anh Hùng';}
elseif ($row[12] == 2){$PkLevel = 'Anh Hùng';}
elseif ($row[12] == 3){$PkLevel = 'Dân Thường';}
elseif ($row[12] == 4){$PkLevel = 'Sát Thủ';}
elseif ($row[12] == 5){$PkLevel = 'Sát Thủ Khát Máu';}
elseif ($row[12] == 6){$PkLevel = 'Sát Thủ Điên Cuồng';}

if($row[3] == 0){ $row[3] ='DW'; $nv_Class = 'Dark Wizark';
}
if($row[3] == 1){ $row[3] ='SM'; $nv_Class = 'Soul Master';
}
if($row[3] == 2){ $row[3] ='GM'; $nv_Class = 'Grand Master';
}

if($row[3] == 16){ $row[3] ='DK'; $nv_Class = 'Dark Knight';
}
if($row[3] == 17){ $row[3] ='BK'; $nv_Class = 'Blade Knight';
}
if($row[3] == 18){ $row[3] ='BM'; $nv_Class = 'Blade Master';
}

if($row[3] == 32){ $row[3] ='Elf'; $nv_Class = 'Elf';
}
if($row[3] == 33){ $row[3] ='ME'; $nv_Class = 'Muse Elf';
}
if($row[3] == 34){ $row[3] ='HE';  $nv_Class = 'Hight Elf';
}

if($row[3] == 48){ $row[3] ='MG'; $nv_Class = 'Magic Gladiator';
}
if($row[3] == 49){ $row[3] ='DM'; $nv_Class = 'Duel Master';
}
if($row[3] == 50){ $row[3] ='DM'; $nv_Class = 'Duel Master';
}

if($row[3] == 64){ $row[3] ='DL'; $nv_Class = 'DarkLord';
}
if($row[3] == 65){ $row[3] ='LE'; $nv_Class = 'Lord Emperor';
}
if($row[3] == 66){ $row[3] ='LE'; $nv_Class = 'Lord Emperor';
}

if($row[3] == 80){ $row[3] ='S.M'; $nv_Class = 'Sumonner';
}
if($row[3] == 81){ $row[3] ='B.S'; $nv_Class = 'Bloody Summoner';
}
if($row[3] == 82){ $row[3] ='Di.M'; $nv_Class = 'Dimension Master';
}

if($row[9] == 0){ $row[9] = 'Lorencia';
}
if($row[9] == 1){ $row[9] = 'Dungeon';
}
if($row[9] == 2){ $row[9] = 'Davias';
}
if($row[9] == 3){ $row[9] = 'Noria';
}
if($row[9] == 4){ $row[9] = 'LostTower';
}
if($row[9] == 5){ $row[9] = 'Exile';
}
if($row[9] == 6){ $row[9] = 'Stadium';
}
if($row[9] == 7){ $row[9] = 'Atlans';
}
if($row[9] == 8){ $row[9] = 'Tarkan';
}
if($row[9] == 9){ $row[9] = 'DevilSquare';
}
if($row[9] == 10){ $row[9] = 'Icarus';
}
if($row[9] == 11){ $row[9] = 'BloodCastle 1';
}
if($row[9] == 12){ $row[9] = 'BloodCastle 2';
}
if($row[9] == 13){ $row[9] = 'BloodCastle 3';
}
if($row[9] == 14){ $row[9] = 'BloodCastle 4';
}
if($row[9] == 15){ $row[9] = 'BloodCastle 5';
}
if($row[9] == 16){ $row[9] = 'BloodCastle 6';
}
if($row[9] == 17){ $row[9] = 'BloodCastle 7';
}
if($row[9] == 18){ $row[9] = 'ChaosCastle 1';
}
if($row[9] == 19){ $row[9] = 'ChaosCastle 2';
}
if($row[9] == 20){ $row[9] = 'ChaosCastle 3';
}
if($row[9] == 21){ $row[9] = 'ChaosCastle 4';
}
if($row[9] == 22){ $row[9] = 'ChaosCastle 5';
}
if($row[9] == 23){ $row[9] = 'ChaosCastle 6';
}
if($row[9] == 24){ $row[9] = 'Kalima 1';
}
if($row[9] == 25){ $row[9] = 'Kalima 2';
}
if($row[9] == 26){ $row[9] = 'Kalima 3';
}
if($row[9] == 27){ $row[9] = 'Kalima 4';
}
if($row[9] == 28){ $row[9] = 'Kalima 5';
}
if($row[9] == 29){ $row[9] = 'Kalima 6';
}
if($row[9] == 30){ $row[9] = 'Loren Deep';
}
if($row[9] == 31){ $row[9] = 'Land Of Trials';
}
if($row[9] == 32){ $row[9] = 'Devil Square';
}
if($row[9] == 33){ $row[9] = 'Aida';
}
if($row[9] == 34){ $row[9] = 'CryWolf';
}
if($row[9] == 35){ $row[9] = 'Devil Square';
}
if($row[9] == 36){ $row[9] = 'Kalima 7';
}
if($row2[7] == 37){ $row2[7] = 'Kantru 1';
}
if($row2[7] == 38){ $row2[7] = 'Kantru 2';
}
if($row2[7] == 39){ $row2[7] = 'Kantru Ref';
}
if($row2[7] == 40){ $row2[7] = 'Heaven Gate';
}
if($row2[7] == 41){ $row2[7] = 'Season3_MAP';
}
if($row2[7] == 42){ $row2[7] = 'Season3_MAP';
}
if($row2[7] == 46){ $row2[7] = 'Season3_MAP';
}


if($row2[0] == 0 || $row3[0] <> $row[1]){ 
	$row2[0] ='<font color="Blue">Offline</font>';
	echo"<tr bgcolor='#F9E7CF' >
		<td align='center'>$rank</td>
		<td align='center'><a href='#' onMouseOut='hidetip();' onMouseOver=\"showtip('Class: $nv_Class. Level: $row[4].<br>ReLife: $row[16]. Reset: $row[2].<br>Tổng số Point sử dụng: $total_stat.<br>Point dư: $row[15].<br>Tinh trang: $PkLevel.<br>Giet nguoi: $row[13].');\">$row[1]</a></td>
		<td align='center'><font color=blue>$row[2]</font>/<font color=red>$row[16]</font></td>
		<td align='center'>$nv_Class</td>
		<td align='center'>$row2[0]</td>
	</tr>";

}
if($row2[0] == 1 && $row3[0] == $row[1]){ 
	$row2[0] ='<font color="Red"><b>Online</b></font>';
	echo"<tr bgcolor='#F9E7CF' >
		<td align='center'>$rank</td>
		<td align='center'><a href='#' onMouseOut='hidetip();' onMouseOver=\"showtip('Class: $nv_Class. Level: $row[4].<br>ReLife: $row[16]. Reset: $row[2].<br>Tổng số Point sử dụng: $total_stat.<br>Point dư: $row[15].<br>Tinh trang: $PkLevel.<br>Giet nguoi: $row[13].<br>Server: $row2[1].<br>Map: $row[9], Tọa độ: $row[10],$row[11]');\">$row[1]</a></td>
		<td align='center'><font color=blue>$row[2]</font>/<font color=red>$row[16]</font></td>
		<td align='center'>$nv_Class</td>
		<td align='center'>$row2[0]</td>
	</tr>";
}
	
} 
?>
											
</table>
<center><b>Trang</b>: <a href="?top_type=<?php echo $top_type; ?>&page=1">[1]</a> <a href="?top_type=<?php echo $top_type; ?>&page=2">[2]</a> <a href="?top_type=<?php echo $top_type; ?>&page=3">[3]</a> <a href="?top_type=<?php echo $top_type; ?>&page=4">[4]</a> <a href="?top_type=<?php echo $top_type; ?>&page=5">[5]</a> <a href="?top_type=<?php echo $top_type; ?>&page=6">[6]</a> <a href="?top_type=<?php echo $top_type; ?>&page=7">[7]</a> <a href="?top_type=<?php echo $top_type; ?>&page=8">[8]</a> <a href="?top_type=<?php echo $top_type; ?>&page=9">[9]</a> <a href="?top_type=<?php echo $top_type; ?>&page=10">[10]</a></center>
<script type="text/javascript" src="js/tooltip.js"></script>
</body>