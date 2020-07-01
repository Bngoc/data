<?php
	include("security.php");
include_once('../config.php');
include_once('../config_dongbo.php');
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link href="css/tooltip.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#F9E7CF">
<div id="dhtmltooltip"></div>
<img id="dhtmlpointer" src="images/tooltiparrow.gif">
<table width="100%" cellspacing="1" cellpadding="3" border="0" bgcolor="#0000ff">
<tr bgcolor="#ffffcc" >
	<td align="center">#</td>
	<td align="center">Tài khoản</td>
	<td align="center">Nhân vật</td>
	<td align="center">(RS/RL - Level)</td>
	<td align="center">Reset cuối</td>
	<td align="center">Class</td>
	<td align="center">Point hiện tại</td>
	<td align="center">Point RS + LV</td>
	<td align="center">Chênh Point</td>
	<td align="center">Thuê Point</td>
	<td align="center">Point Thuê</td>
</tr>

<?
	$query = "SELECT AccountID,Name,Resets,Relifes,Class,Clevel,Strength,Dexterity,Vitality,Energy,Leadership,LevelUpPoint,pointdutru,IsThuePoint,ResetVIP,PointThue FROM Character ORDER BY relifes DESC, resets DESC , cLevel DESC";

	$result = $db->Execute($query);
$rank = 0;
while( $row = $result->fetchrow() ) 	{

if ($row[6] < 0) {$row[6] = $row[6]+65536;}
if ($row[7] < 0) {$row[7] = $row[7]+65536;}
if ($row[8] < 0) {$row[8] = $row[8]+65536;}
if ($row[9] < 0) {$row[9] = $row[9]+65536;}
if ($row[10] < 0) {$row[10] = $row[10]+65536;}

if ( $row[4] == 64 OR $row[4] == 65 OR $row[4] == 66 ) {
		$point_now = $row[6] + $row[7] + $row[8] + $row[9] + $row[10] + $row[11] + $row[12];
}
else { $point_now = $row[6] + $row[7] + $row[8] + $row[9] + $row[11] + $row[12]; }

if($row[4] == 0){ $row[4] ='DW'; $Class = 'Dark Wizark';
}
if($row[4] == 1){ $row[4] ='SM'; $Class = 'Soul Master';
}
if($row[4] == 2){ $row[4] ='GM'; $Class = 'Grand Master';
}

if($row[4] == 16){ $row[4] ='DK'; $Class = 'Dark Knight';
}
if($row[4] == 17){ $row[4] ='BK'; $Class = 'Blade Knight';
}
if($row[4] == 18){ $row[4] ='BM'; $Class = 'Blade Master';
}

if($row[4] == 32){ $row[4] ='Elf'; $Class = 'Elf';
}
if($row[4] == 33){ $row[4] ='ME'; $Class = 'Muse Elf';
}
if($row[4] == 34){ $row[4] ='HE';  $Class = 'Hight Elf';
}

if($row[4] == 48){ $row[4] ='MG'; $Class = 'Magic Gladiator';
}
if($row[4] == 49){ $row[4] ='DM'; $Class = 'Duel Master';
}
if($row[4] == 50){ $row[4] ='DM'; $Class = 'Duel Master';
}

if($row[4] == 64){ $row[4] ='DL'; $Class = 'DarkLord';
}
if($row[4] == 65){ $row[4] ='LE'; $Class = 'Lord Emperor';
}
if($row[4] == 66){ $row[4] ='LE'; $Class = 'Lord Emperor';
}

if($row[4] == 80){ $row[4] ='S.M'; $Class = 'Sumonner';
}
if($row[4] == 81){ $row[4] ='B.S'; $Class = 'Bloody Summoner';
}
if($row[4] == 82){ $row[4] ='Di.M'; $Class = 'Dimension Master';
}

//Kiểm tra Point ReLife
switch ($row[3]) {
	case 0:
		$point_relifes = 0;
		$ml_relifes = 0;
		break;
	case 1:
		$point_relifes = $rl_point_relife1;
		$ml_relifes = $rl_ml_relife1;
		break;
	case 2:
		$point_relifes = $rl_point_relife2;
		$ml_relifes = $rl_ml_relife2;
		break;
	case 3:
		$point_relifes = $rl_point_relife3;
		$ml_relifes = $rl_ml_relife3;
		break;
	case 4:
		$point_relifes = $rl_point_relife4;
		$ml_relifes = $rl_ml_relife4;
		break;
	case 5:
		$point_relifes = $rl_point_relife5;
		$ml_relifes = $rl_ml_relife5;
		break;
	case 6:
		$point_relifes = $rl_point_relife6;
		$ml_relifes = $rl_ml_relife6;
		break;
	case 7;
		$point_relifes = $rl_point_relife7;
		$ml_relifes = $rl_ml_relife7;
		break;
	case 8:
		$point_relifes = $rl_point_relife8;
		$ml_relifes = $rl_ml_relife8;
		break;
	case 9:
		$point_relifes = $rl_point_relife9;
		$ml_relifes = $rl_ml_relife9;
		break;
	case 10:
		$point_relifes = $rl_point_relife10;
		$ml_relifes = $rl_ml_relife10;
		break;
}

// Công thức tính Point Reset
$resets = $row[2]-1;

//Nếu là Reset VIP
if ($row[14] == 1) {
	//Reset lần 1
	if ($resets <= $reset_cap_0)
		{
			$resetpoint=$point_relifes+$point_cap_1_vip;
			$leadership = $ml_relifes+$ml_cap_1_vip;
		}
	//Reset cấp 1
	elseif ($resets < $reset_cap_1)
		{
			$resetpoint=$point_relifes+$point_cap_1_vip+$resets*$point_cap_1_vip;
			$leadership = $ml_relifes+$ml_relifes+$ml_cap_1_vip+$resets*$ml_cap_1_vip;
		}
	//Reset cấp 1 -> 2
	elseif ($resets >= $reset_cap_1 AND $resets < $reset_cap_2)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($resets-($reset_cap_1-1))*$point_cap_2_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($resets-($reset_cap_1-1))*$ml_cap_2_vip;
		}
	//Reset cấp 2 -> 3
	elseif ($resets >= $reset_cap_2 AND $resets < $reset_cap_3)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($resets-($reset_cap_2-1))*$point_cap_3_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($resets-($reset_cap_2-1))*$ml_cap_3_vip;
		}
	//Reset cấp 3 -> 4
	elseif ($resets >= $reset_cap_3 AND $resets < $reset_cap_4)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($point_cap_3_vip*($reset_cap_3-$reset_cap_2))+($resets-($reset_cap_3-1))*$point_cap_4_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($ml_cap_3_vip*($reset_cap_3-$reset_cap_2))+($resets-($reset_cap_3-1))*$ml_cap_4_vip;
		}
	//Reset cấp 4 -> 5
	elseif ($resets >= $reset_cap_4 AND $resets < $reset_cap_5)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($point_cap_3_vip*($reset_cap_3-$reset_cap_2))+($point_cap_4_vip*($reset_cap_4-$reset_cap_3))+($resets-($reset_cap_4-1))*$point_cap_5_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($ml_cap_3_vip*($reset_cap_3-$reset_cap_2))+($ml_cap_4_vip*($reset_cap_4-$reset_cap_3))+($resets-($reset_cap_4-1))*$ml_cap_5_vip;
		}
	//Reset cấp 5 -> 6
	elseif ($resets >= $reset_cap_5 AND $resets < $reset_cap_6)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($point_cap_3_vip*($reset_cap_3-$reset_cap_2))+($point_cap_4_vip*($reset_cap_4-$reset_cap_3))+($point_cap_5_vip*($reset_cap_5-$reset_cap_4))+($resets-($reset_cap_5-1))*$point_cap_6_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($ml_cap_3_vip*($reset_cap_3-$reset_cap_2))+($ml_cap_4_vip*($reset_cap_4-$reset_cap_3))+($ml_cap_5_vip*($reset_cap_5-$reset_cap_4))+($resets-($reset_cap_5-1))*$ml_cap_6_vip;
		}
	//Reset cấp 6 -> 7
	elseif ($resets >= $reset_cap_6 AND $resets < $reset_cap_7)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($point_cap_3_vip*($reset_cap_3-$reset_cap_2))+($point_cap_4_vip*($reset_cap_4-$reset_cap_3))+($point_cap_5_vip*($reset_cap_5-$reset_cap_4))+($point_cap_6_vip*($reset_cap_6-$reset_cap_5))+($resets-($reset_cap_6-1))*$point_cap_7_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($ml_cap_3_vip*($reset_cap_3-$reset_cap_2))+($ml_cap_4_vip*($reset_cap_4-$reset_cap_3))+($ml_cap_5_vip*($reset_cap_5-$reset_cap_4))+($ml_cap_6_vip*($reset_cap_6-$reset_cap_5))+($resets-($reset_cap_6-1))*$ml_cap_7_vip;
		}
	//Reset cấp 7 -> 8
	elseif ($resets >= $reset_cap_7 AND $resets < $reset_cap_8)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($point_cap_3_vip*($reset_cap_3-$reset_cap_2))+($point_cap_4_vip*($reset_cap_4-$reset_cap_3))+($point_cap_5_vip*($reset_cap_5-$reset_cap_4))+($point_cap_6_vip*($reset_cap_6-$reset_cap_5))+($point_cap_7_vip*($reset_cap_7-$reset_cap_6))+($resets-($reset_cap_7-1))*$point_cap_8_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($ml_cap_3_vip*($reset_cap_3-$reset_cap_2))+($ml_cap_4_vip*($reset_cap_4-$reset_cap_3))+($ml_cap_5_vip*($reset_cap_5-$reset_cap_4))+($ml_cap_6_vip*($reset_cap_6-$reset_cap_5))+($ml_cap_7_vip*($reset_cap_7-$reset_cap_6))+($resets-($reset_cap_7-1))*$ml_cap_8_vip;
		}
	//Reset cấp 8 -> 9
	elseif ($resets >= $reset_cap_8 AND $resets < $reset_cap_9)
		 {
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($point_cap_3_vip*($reset_cap_3-$reset_cap_2))+($point_cap_4_vip*($reset_cap_4-$reset_cap_3))+($point_cap_5_vip*($reset_cap_5-$reset_cap_4))+($point_cap_6_vip*($reset_cap_6-$reset_cap_5))+($point_cap_7_vip*($reset_cap_7-$reset_cap_6))+($point_cap_8_vip*($reset_cap_8-$reset_cap_7))+($resets-($reset_cap_8-1))*$point_cap_9_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($ml_cap_3_vip*($reset_cap_3-$reset_cap_2))+($ml_cap_4_vip*($reset_cap_4-$reset_cap_3))+($ml_cap_5_vip*($reset_cap_5-$reset_cap_4))+($ml_cap_6_vip*($reset_cap_6-$reset_cap_5))+($ml_cap_7_vip*($reset_cap_7-$reset_cap_6))+($ml_cap_8_vip*($reset_cap_8-$reset_cap_7))+($resets-($reset_cap_8-1))*$ml_cap_9_vip;
		}
	//Reset cấp 9 -> 10
	elseif ($resets >= $reset_cap_9 AND $resets < $reset_cap_10)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($point_cap_3_vip*($reset_cap_3-$reset_cap_2))+($point_cap_4_vip*($reset_cap_4-$reset_cap_3))+($point_cap_5_vip*($reset_cap_5-$reset_cap_4))+($point_cap_6_vip*($reset_cap_6-$reset_cap_5))+($point_cap_7_vip*($reset_cap_7-$reset_cap_6))+($point_cap_8_vip*($reset_cap_8-$reset_cap_7))+($point_cap_9_vip*($reset_cap_9-$reset_cap_8))+($resets-($reset_cap_9-1))*$point_cap_10_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($ml_cap_3_vip*($reset_cap_3-$reset_cap_2))+($ml_cap_4_vip*($reset_cap_4-$reset_cap_3))+($ml_cap_5_vip*($reset_cap_5-$reset_cap_4))+($ml_cap_6_vip*($reset_cap_6-$reset_cap_5))+($ml_cap_7_vip*($reset_cap_7-$reset_cap_6))+($ml_cap_8_vip*($reset_cap_8-$reset_cap_7))+($ml_cap_9_vip*($reset_cap_9-$reset_cap_8))+($resets-($reset_cap_9-1))*$ml_cap_10_vip;
		 }
	//Reset cấp 10 -> 11
	elseif ($resets >= $reset_cap_10 AND $resets < $reset_cap_11)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($point_cap_3_vip*($reset_cap_3-$reset_cap_2))+($point_cap_4_vip*($reset_cap_4-$reset_cap_3))+($point_cap_5_vip*($reset_cap_5-$reset_cap_4))+($point_cap_6_vip*($reset_cap_6-$reset_cap_5))+($point_cap_7_vip*($reset_cap_7-$reset_cap_6))+($point_cap_8_vip*($reset_cap_8-$reset_cap_7))+($point_cap_9_vip*($reset_cap_9-$reset_cap_8))+($point_cap_10_vip*($reset_cap_10-$reset_cap_9))+($resets-($reset_cap_10-1))*$point_cap_11_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($ml_cap_3_vip*($reset_cap_3-$reset_cap_2))+($ml_cap_4_vip*($reset_cap_4-$reset_cap_3))+($ml_cap_5_vip*($reset_cap_5-$reset_cap_4))+($ml_cap_6_vip*($reset_cap_6-$reset_cap_5))+($ml_cap_7_vip*($reset_cap_7-$reset_cap_6))+($ml_cap_8_vip*($reset_cap_8-$reset_cap_7))+($ml_cap_9_vip*($reset_cap_9-$reset_cap_8))+($ml_cap_10_vip*($reset_cap_10-$reset_cap_9))+($resets-($reset_cap_10-1))*$ml_cap_11_vip;
		}
	//Reset cấp 11 -> 12
	elseif ($resets >= $reset_cap_11 AND $resets < $reset_cap_12)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($point_cap_3_vip*($reset_cap_3-$reset_cap_2))+($point_cap_4_vip*($reset_cap_4-$reset_cap_3))+($point_cap_5_vip*($reset_cap_5-$reset_cap_4))+($point_cap_6_vip*($reset_cap_6-$reset_cap_5))+($point_cap_7_vip*($reset_cap_7-$reset_cap_6))+($point_cap_8_vip*($reset_cap_8-$reset_cap_7))+($point_cap_9_vip*($reset_cap_9-$reset_cap_8))+($point_cap_10_vip*($reset_cap_10-$reset_cap_9))+($point_cap_11_vip*($reset_cap_11-$reset_cap_10))+($resets-($reset_cap_11-1))*$point_cap_12_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($ml_cap_3_vip*($reset_cap_3-$reset_cap_2))+($ml_cap_4_vip*($reset_cap_4-$reset_cap_3))+($ml_cap_5_vip*($reset_cap_5-$reset_cap_4))+($ml_cap_6_vip*($reset_cap_6-$reset_cap_5))+($ml_cap_7_vip*($reset_cap_7-$reset_cap_6))+($ml_cap_8_vip*($reset_cap_8-$reset_cap_7))+($ml_cap_9_vip*($reset_cap_9-$reset_cap_8))+($ml_cap_10_vip*($reset_cap_10-$reset_cap_9))+($ml_cap_11_vip*($reset_cap_11-$reset_cap_10))+($resets-($reset_cap_11-1))*$ml_cap_12_vip;
		 }
	//Reset cấp 12 -> 13
	elseif ($resets >= $reset_cap_12 AND $resets < $reset_cap_13)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($point_cap_3_vip*($reset_cap_3-$reset_cap_2))+($point_cap_4_vip*($reset_cap_4-$reset_cap_3))+($point_cap_5_vip*($reset_cap_5-$reset_cap_4))+($point_cap_6_vip*($reset_cap_6-$reset_cap_5))+($point_cap_7_vip*($reset_cap_7-$reset_cap_6))+($point_cap_8_vip*($reset_cap_8-$reset_cap_7))+($point_cap_9_vip*($reset_cap_9-$reset_cap_8))+($point_cap_10_vip*($reset_cap_10-$reset_cap_9))+($point_cap_11_vip*($reset_cap_11-$reset_cap_10))+($point_cap_12_vip*($reset_cap_12-$reset_cap_11))+($resets-($reset_cap_12-1))*$point_cap_13_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($ml_cap_3_vip*($reset_cap_3-$reset_cap_2))+($ml_cap_4_vip*($reset_cap_4-$reset_cap_3))+($ml_cap_5_vip*($reset_cap_5-$reset_cap_4))+($ml_cap_6_vip*($reset_cap_6-$reset_cap_5))+($ml_cap_7_vip*($reset_cap_7-$reset_cap_6))+($ml_cap_8_vip*($reset_cap_8-$reset_cap_7))+($ml_cap_9_vip*($reset_cap_9-$reset_cap_8))+($ml_cap_10_vip*($reset_cap_10-$reset_cap_9))+($ml_cap_11_vip*($reset_cap_11-$reset_cap_10))+($ml_cap_12_vip*($reset_cap_12-$reset_cap_11))+($resets-($reset_cap_12-1))*$ml_cap_13_vip;
		}
	//Reset cấp 13 -> 14
	elseif ($resets >= $reset_cap_13 AND $resets < $reset_cap_14)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($point_cap_3_vip*($reset_cap_3-$reset_cap_2))+($point_cap_4_vip*($reset_cap_4-$reset_cap_3))+($point_cap_5_vip*($reset_cap_5-$reset_cap_4))+($point_cap_6_vip*($reset_cap_6-$reset_cap_5))+($point_cap_7_vip*($reset_cap_7-$reset_cap_6))+($point_cap_8_vip*($reset_cap_8-$reset_cap_7))+($point_cap_9_vip*($reset_cap_9-$reset_cap_8))+($point_cap_10_vip*($reset_cap_10-$reset_cap_9))+($point_cap_11_vip*($reset_cap_11-$reset_cap_10))+($point_cap_12_vip*($reset_cap_12-$reset_cap_11))+($point_cap_13_vip*($reset_cap_13-$reset_cap_12))+($resets-($reset_cap_13-1))*$point_cap_14_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($ml_cap_3_vip*($reset_cap_3-$reset_cap_2))+($ml_cap_4_vip*($reset_cap_4-$reset_cap_3))+($ml_cap_5_vip*($reset_cap_5-$reset_cap_4))+($ml_cap_6_vip*($reset_cap_6-$reset_cap_5))+($ml_cap_7_vip*($reset_cap_7-$reset_cap_6))+($ml_cap_8_vip*($reset_cap_8-$reset_cap_7))+($ml_cap_9_vip*($reset_cap_9-$reset_cap_8))+($ml_cap_10_vip*($reset_cap_10-$reset_cap_9))+($ml_cap_11_vip*($reset_cap_11-$reset_cap_10))+($ml_cap_12_vip*($reset_cap_12-$reset_cap_11))+($ml_cap_13_vip*($reset_cap_13-$reset_cap_12))+($resets-($reset_cap_13-1))*$ml_cap_14_vip;
		}
	//Reset cấp 14 -> 15
	elseif ($resets >= $reset_cap_14 AND $resets < $reset_cap_15)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($point_cap_3_vip*($reset_cap_3-$reset_cap_2))+($point_cap_4_vip*($reset_cap_4-$reset_cap_3))+($point_cap_5_vip*($reset_cap_5-$reset_cap_4))+($point_cap_6_vip*($reset_cap_6-$reset_cap_5))+($point_cap_7_vip*($reset_cap_7-$reset_cap_6))+($point_cap_8_vip*($reset_cap_8-$reset_cap_7))+($point_cap_9_vip*($reset_cap_9-$reset_cap_8))+($point_cap_10_vip*($reset_cap_10-$reset_cap_9))+($point_cap_11_vip*($reset_cap_11-$reset_cap_10))+($point_cap_12_vip*($reset_cap_12-$reset_cap_11))+($point_cap_13_vip*($reset_cap_13-$reset_cap_12))+($point_cap_14_vip*($reset_cap_14-$reset_cap_13))+($resets-($reset_cap_14-1))*$point_cap_15_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($ml_cap_3_vip*($reset_cap_3-$reset_cap_2))+($ml_cap_4_vip*($reset_cap_4-$reset_cap_3))+($ml_cap_5_vip*($reset_cap_5-$reset_cap_4))+($ml_cap_6_vip*($reset_cap_6-$reset_cap_5))+($ml_cap_7_vip*($reset_cap_7-$reset_cap_6))+($ml_cap_8_vip*($reset_cap_8-$reset_cap_7))+($ml_cap_9_vip*($reset_cap_9-$reset_cap_8))+($ml_cap_10_vip*($reset_cap_10-$reset_cap_9))+($ml_cap_11_vip*($reset_cap_11-$reset_cap_10))+($ml_cap_12_vip*($reset_cap_12-$reset_cap_11))+($ml_cap_13_vip*($reset_cap_13-$reset_cap_12))+($ml_cap_14_vip*($reset_cap_14-$reset_cap_13))+($resets-($reset_cap_14-1))*$ml_cap_15_vip;
		}
	//Reset cấp 15 -> 16
	elseif ($resets >= $reset_cap_15 AND $resets < $reset_cap_16)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($point_cap_3_vip*($reset_cap_3-$reset_cap_2))+($point_cap_4_vip*($reset_cap_4-$reset_cap_3))+($point_cap_5_vip*($reset_cap_5-$reset_cap_4))+($point_cap_6_vip*($reset_cap_6-$reset_cap_5))+($point_cap_7_vip*($reset_cap_7-$reset_cap_6))+($point_cap_8_vip*($reset_cap_8-$reset_cap_7))+($point_cap_9_vip*($reset_cap_9-$reset_cap_8))+($point_cap_10_vip*($reset_cap_10-$reset_cap_9))+($point_cap_11_vip*($reset_cap_11-$reset_cap_10))+($point_cap_12_vip*($reset_cap_12-$reset_cap_11))+($point_cap_13_vip*($reset_cap_13-$reset_cap_12))+($point_cap_14_vip*($reset_cap_14-$reset_cap_13))+($point_cap_15_vip*($reset_cap_15-$reset_cap_14))+($resets-($reset_cap_15-1))*$point_cap_16_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($ml_cap_3_vip*($reset_cap_3-$reset_cap_2))+($ml_cap_4_vip*($reset_cap_4-$reset_cap_3))+($ml_cap_5_vip*($reset_cap_5-$reset_cap_4))+($ml_cap_6_vip*($reset_cap_6-$reset_cap_5))+($ml_cap_7_vip*($reset_cap_7-$reset_cap_6))+($ml_cap_8_vip*($reset_cap_8-$reset_cap_7))+($ml_cap_9_vip*($reset_cap_9-$reset_cap_8))+($ml_cap_10_vip*($reset_cap_10-$reset_cap_9))+($ml_cap_11_vip*($reset_cap_11-$reset_cap_10))+($ml_cap_12_vip*($reset_cap_12-$reset_cap_11))+($ml_cap_13_vip*($reset_cap_13-$reset_cap_12))+($ml_cap_14_vip*($reset_cap_14-$reset_cap_13))+($ml_cap_15_vip*($reset_cap_15-$reset_cap_14))+($resets-($reset_cap_15-1))*$ml_cap_16_vip;
		}
	//Reset cấp 16 -> 17
	elseif ($resets >= $reset_cap_16 AND $resets < $reset_cap_17)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($point_cap_3_vip*($reset_cap_3-$reset_cap_2))+($point_cap_4_vip*($reset_cap_4-$reset_cap_3))+($point_cap_5_vip*($reset_cap_5-$reset_cap_4))+($point_cap_6_vip*($reset_cap_6-$reset_cap_5))+($point_cap_7_vip*($reset_cap_7-$reset_cap_6))+($point_cap_8_vip*($reset_cap_8-$reset_cap_7))+($point_cap_9_vip*($reset_cap_9-$reset_cap_8))+($point_cap_10_vip*($reset_cap_10-$reset_cap_9))+($point_cap_11_vip*($reset_cap_11-$reset_cap_10))+($point_cap_12_vip*($reset_cap_12-$reset_cap_11))+($point_cap_13_vip*($reset_cap_13-$reset_cap_12))+($point_cap_14_vip*($reset_cap_14-$reset_cap_13))+($point_cap_15_vip*($reset_cap_15-$reset_cap_14))+($point_cap_16_vip*($reset_cap_16-$reset_cap_15))+($resets-($reset_cap_16-1))*$point_cap_17_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($ml_cap_3_vip*($reset_cap_3-$reset_cap_2))+($ml_cap_4_vip*($reset_cap_4-$reset_cap_3))+($ml_cap_5_vip*($reset_cap_5-$reset_cap_4))+($ml_cap_6_vip*($reset_cap_6-$reset_cap_5))+($ml_cap_7_vip*($reset_cap_7-$reset_cap_6))+($ml_cap_8_vip*($reset_cap_8-$reset_cap_7))+($ml_cap_9_vip*($reset_cap_9-$reset_cap_8))+($ml_cap_10_vip*($reset_cap_10-$reset_cap_9))+($ml_cap_11_vip*($reset_cap_11-$reset_cap_10))+($ml_cap_12_vip*($reset_cap_12-$reset_cap_11))+($ml_cap_13_vip*($reset_cap_13-$reset_cap_12))+($ml_cap_14_vip*($reset_cap_14-$reset_cap_13))+($ml_cap_15_vip*($reset_cap_15-$reset_cap_14))+($ml_cap_16_vip*($reset_cap_16-$reset_cap_15))+($resets-($reset_cap_16-1))*$ml_cap_17_vip;
		}
	//Reset cấp 17 -> 18
	elseif ($resets >= $reset_cap_17 AND $resets < $reset_cap_18)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($point_cap_3_vip*($reset_cap_3-$reset_cap_2))+($point_cap_4_vip*($reset_cap_4-$reset_cap_3))+($point_cap_5_vip*($reset_cap_5-$reset_cap_4))+($point_cap_6_vip*($reset_cap_6-$reset_cap_5))+($point_cap_7_vip*($reset_cap_7-$reset_cap_6))+($point_cap_8_vip*($reset_cap_8-$reset_cap_7))+($point_cap_9_vip*($reset_cap_9-$reset_cap_8))+($point_cap_10_vip*($reset_cap_10-$reset_cap_9))+($point_cap_11_vip*($reset_cap_11-$reset_cap_10))+($point_cap_12_vip*($reset_cap_12-$reset_cap_11))+($point_cap_13_vip*($reset_cap_13-$reset_cap_12))+($point_cap_14_vip*($reset_cap_14-$reset_cap_13))+($point_cap_15_vip*($reset_cap_15-$reset_cap_14))+($point_cap_16_vip*($reset_cap_16-$reset_cap_15))+($point_cap_17_vip*($reset_cap_17-$reset_cap_16))+($resets-($reset_cap_17-1))*$point_cap_18_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($ml_cap_3_vip*($reset_cap_3-$reset_cap_2))+($ml_cap_4_vip*($reset_cap_4-$reset_cap_3))+($ml_cap_5_vip*($reset_cap_5-$reset_cap_4))+($ml_cap_6_vip*($reset_cap_6-$reset_cap_5))+($ml_cap_7_vip*($reset_cap_7-$reset_cap_6))+($ml_cap_8_vip*($reset_cap_8-$reset_cap_7))+($ml_cap_9_vip*($reset_cap_9-$reset_cap_8))+($ml_cap_10_vip*($reset_cap_10-$reset_cap_9))+($ml_cap_11_vip*($reset_cap_11-$reset_cap_10))+($ml_cap_12_vip*($reset_cap_12-$reset_cap_11))+($ml_cap_13_vip*($reset_cap_13-$reset_cap_12))+($ml_cap_14_vip*($reset_cap_14-$reset_cap_13))+($ml_cap_15_vip*($reset_cap_15-$reset_cap_14))+($ml_cap_16_vip*($reset_cap_16-$reset_cap_15))+($ml_cap_17_vip*($reset_cap_17-$reset_cap_16))+($resets-($reset_cap_17-1))*$ml_cap_18_vip;
		}
	//Reset cấp 18 -> 19
	elseif ($resets >= $reset_cap_18 AND $resets < $reset_cap_19)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($point_cap_3_vip*($reset_cap_3-$reset_cap_2))+($point_cap_4_vip*($reset_cap_4-$reset_cap_3))+($point_cap_5_vip*($reset_cap_5-$reset_cap_4))+($point_cap_6_vip*($reset_cap_6-$reset_cap_5))+($point_cap_7_vip*($reset_cap_7-$reset_cap_6))+($point_cap_8_vip*($reset_cap_8-$reset_cap_7))+($point_cap_9_vip*($reset_cap_9-$reset_cap_8))+($point_cap_10_vip*($reset_cap_10-$reset_cap_9))+($point_cap_11_vip*($reset_cap_11-$reset_cap_10))+($point_cap_12_vip*($reset_cap_12-$reset_cap_11))+($point_cap_13_vip*($reset_cap_13-$reset_cap_12))+($point_cap_14_vip*($reset_cap_14-$reset_cap_13))+($point_cap_15_vip*($reset_cap_15-$reset_cap_14))+($point_cap_16_vip*($reset_cap_16-$reset_cap_15))+($point_cap_17_vip*($reset_cap_17-$reset_cap_16))+($point_cap_18_vip*($reset_cap_18-$reset_cap_17))+($resets-($reset_cap_18-1))*$point_cap_19_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($ml_cap_3_vip*($reset_cap_3-$reset_cap_2))+($ml_cap_4_vip*($reset_cap_4-$reset_cap_3))+($ml_cap_5_vip*($reset_cap_5-$reset_cap_4))+($ml_cap_6_vip*($reset_cap_6-$reset_cap_5))+($ml_cap_7_vip*($reset_cap_7-$reset_cap_6))+($ml_cap_8_vip*($reset_cap_8-$reset_cap_7))+($ml_cap_9_vip*($reset_cap_9-$reset_cap_8))+($ml_cap_10_vip*($reset_cap_10-$reset_cap_9))+($ml_cap_11_vip*($reset_cap_11-$reset_cap_10))+($ml_cap_12_vip*($reset_cap_12-$reset_cap_11))+($ml_cap_13_vip*($reset_cap_13-$reset_cap_12))+($ml_cap_14_vip*($reset_cap_14-$reset_cap_13))+($ml_cap_15_vip*($reset_cap_15-$reset_cap_14))+($ml_cap_16_vip*($reset_cap_16-$reset_cap_15))+($ml_cap_17_vip*($reset_cap_17-$reset_cap_16))+($ml_cap_18_vip*($reset_cap_18-$reset_cap_17))+($resets-($reset_cap_18-1))*$ml_cap_19_vip;
		}
	//Reset cấp 19 -> 20
	elseif ($resets >= $reset_cap_19 AND $resets < $reset_cap_20)
		{
			$resetpoint=$point_relifes+($point_cap_1_vip*$reset_cap_1)+($point_cap_2_vip*($reset_cap_2-$reset_cap_1))+($point_cap_3_vip*($reset_cap_3-$reset_cap_2))+($point_cap_4_vip*($reset_cap_4-$reset_cap_3))+($point_cap_5_vip*($reset_cap_5-$reset_cap_4))+($point_cap_6_vip*($reset_cap_6-$reset_cap_5))+($point_cap_7_vip*($reset_cap_7-$reset_cap_6))+($point_cap_8_vip*($reset_cap_8-$reset_cap_7))+($point_cap_9_vip*($reset_cap_9-$reset_cap_8))+($point_cap_10_vip*($reset_cap_10-$reset_cap_9))+($point_cap_11_vip*($reset_cap_11-$reset_cap_10))+($point_cap_12_vip*($reset_cap_12-$reset_cap_11))+($point_cap_13_vip*($reset_cap_13-$reset_cap_12))+($point_cap_14_vip*($reset_cap_14-$reset_cap_13))+($point_cap_15_vip*($reset_cap_15-$reset_cap_14))+($point_cap_16_vip*($reset_cap_16-$reset_cap_15))+($point_cap_17_vip*($reset_cap_17-$reset_cap_16))+($point_cap_18_vip*($reset_cap_18-$reset_cap_17))+($point_cap_19_vip*($reset_cap_19-$reset_cap_18))+($resets-($reset_cap_19-1))*$point_cap_20_vip;
			$leadership=$ml_relifes+($ml_cap_1_vip*$reset_cap_1)+($ml_cap_2_vip*($reset_cap_2-$reset_cap_1))+($ml_cap_3_vip*($reset_cap_3-$reset_cap_2))+($ml_cap_4_vip*($reset_cap_4-$reset_cap_3))+($ml_cap_5_vip*($reset_cap_5-$reset_cap_4))+($ml_cap_6_vip*($reset_cap_6-$reset_cap_5))+($ml_cap_7_vip*($reset_cap_7-$reset_cap_6))+($ml_cap_8_vip*($reset_cap_8-$reset_cap_7))+($ml_cap_9_vip*($reset_cap_9-$reset_cap_8))+($ml_cap_10_vip*($reset_cap_10-$reset_cap_9))+($ml_cap_11_vip*($reset_cap_11-$reset_cap_10))+($ml_cap_12_vip*($reset_cap_12-$reset_cap_11))+($ml_cap_13_vip*($reset_cap_13-$reset_cap_12))+($ml_cap_14_vip*($reset_cap_14-$reset_cap_13))+($ml_cap_15_vip*($reset_cap_15-$reset_cap_14))+($ml_cap_16_vip*($reset_cap_16-$reset_cap_15))+($ml_cap_17_vip*($reset_cap_17-$reset_cap_16))+($ml_cap_18_vip*($reset_cap_18-$reset_cap_17))+($ml_cap_19_vip*($reset_cap_19-$reset_cap_18))+($resets-($reset_cap_19-1))*$ml_cap_20_vip;
		}
}
// Nếu là Reset thường
elseif ( $row[14] == 0) {
	// Reset lần 1
	if ($resets <= $reset_cap_0)
		{
			$resetpoint=$point_relifes+$point_cap_1;
			$leadership = $ml_relifes+$ml_cap_1;
		}
	//Reset cấp 1
	elseif ($resets < $reset_cap_1)
		{
			$resetpoint=$point_relifes+$point_cap_1+$resets*$point_cap_1;
			$leadership = $ml_relifes+$ml_relifes+$ml_cap_1+$resets*$ml_cap_1;
		}
	//Reset cấp 1 -> 2
	elseif ($resets >= $reset_cap_1 AND $resets < $reset_cap_2)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($resets-($reset_cap_1-1))*$point_cap_2;
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($resets-($reset_cap_1-1))*$ml_cap_2;
		}
	//Reset cấp 2 -> 3
	elseif ($resets >= $reset_cap_2 AND $resets < $reset_cap_3)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($resets-($reset_cap_2-1))*$point_cap_3;
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($resets-($reset_cap_2-1))*$ml_cap_3;
		}
	//Reset cấp 3 -> 4
	elseif ($resets >= $reset_cap_3 AND $resets < $reset_cap_4)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($point_cap_3*($reset_cap_3-$reset_cap_2))+($resets-($reset_cap_3-1))*$point_cap_4;
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($ml_cap_3*($reset_cap_3-$reset_cap_2))+($resets-($reset_cap_3-1))*$ml_cap_4;
		}
	//Reset cấp 4 -> 5
	elseif ($resets >= $reset_cap_4 AND $resets < $reset_cap_5)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($point_cap_3*($reset_cap_3-$reset_cap_2))+($point_cap_4*($reset_cap_4-$reset_cap_3))+($resets-($reset_cap_4-1))*$point_cap_5;
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($ml_cap_3*($reset_cap_3-$reset_cap_2))+($ml_cap_4*($reset_cap_4-$reset_cap_3))+($resets-($reset_cap_4-1))*$ml_cap_5;
		}
	//Reset cấp 5 -> 6
	elseif ($resets >= $reset_cap_5 AND $resets < $reset_cap_6)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($point_cap_3*($reset_cap_3-$reset_cap_2))+($point_cap_4*($reset_cap_4-$reset_cap_3))+($point_cap_5*($reset_cap_5-$reset_cap_4))+($resets-($reset_cap_5-1))*$point_cap_6;
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($ml_cap_3*($reset_cap_3-$reset_cap_2))+($ml_cap_4*($reset_cap_4-$reset_cap_3))+($ml_cap_5*($reset_cap_5-$reset_cap_4))+($resets-($reset_cap_5-1))*$ml_cap_6;
		}
	//Reset cấp 6 -> 7
	elseif ($resets >= $reset_cap_6 AND $resets < $reset_cap_7)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($point_cap_3*($reset_cap_3-$reset_cap_2))+($point_cap_4*($reset_cap_4-$reset_cap_3))+($point_cap_5*($reset_cap_5-$reset_cap_4))+($point_cap_6*($reset_cap_6-$reset_cap_5))+($resets-($reset_cap_6-1))*$point_cap_7;
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($ml_cap_3*($reset_cap_3-$reset_cap_2))+($ml_cap_4*($reset_cap_4-$reset_cap_3))+($ml_cap_5*($reset_cap_5-$reset_cap_4))+($ml_cap_6*($reset_cap_6-$reset_cap_5))+($resets-($reset_cap_6-1))*$ml_cap_7;
		}
	//Reset cấp 7 -> 8
	elseif ($resets >= $reset_cap_7 AND $resets < $reset_cap_8)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($point_cap_3*($reset_cap_3-$reset_cap_2))+($point_cap_4*($reset_cap_4-$reset_cap_3))+($point_cap_5*($reset_cap_5-$reset_cap_4))+($point_cap_6*($reset_cap_6-$reset_cap_5))+($point_cap_7*($reset_cap_7-$reset_cap_6))+($resets-($reset_cap_7-1))*$point_cap_8;
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($ml_cap_3*($reset_cap_3-$reset_cap_2))+($ml_cap_4*($reset_cap_4-$reset_cap_3))+($ml_cap_5*($reset_cap_5-$reset_cap_4))+($ml_cap_6*($reset_cap_6-$reset_cap_5))+($ml_cap_7*($reset_cap_7-$reset_cap_6))+($resets-($reset_cap_7-1))*$ml_cap_8;
		}
	//Reset cấp 8 -> 9
	elseif ($resets >= $reset_cap_8 AND $resets < $reset_cap_9)
		 {
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($point_cap_3*($reset_cap_3-$reset_cap_2))+($point_cap_4*($reset_cap_4-$reset_cap_3))+($point_cap_5*($reset_cap_5-$reset_cap_4))+($point_cap_6*($reset_cap_6-$reset_cap_5))+($point_cap_7*($reset_cap_7-$reset_cap_6))+($point_cap_8*($reset_cap_8-$reset_cap_7))+($resets-($reset_cap_8-1))*$point_cap_9;
			
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($ml_cap_3*($reset_cap_3-$reset_cap_2))+($ml_cap_4*($reset_cap_4-$reset_cap_3))+($ml_cap_5*($reset_cap_5-$reset_cap_4))+($ml_cap_6*($reset_cap_6-$reset_cap_5))+($ml_cap_7*($reset_cap_7-$reset_cap_6))+($ml_cap_8*($reset_cap_8-$reset_cap_7))+($resets-($reset_cap_8-1))*$ml_cap_9;
		}
	//Reset cấp 9 -> 10
	elseif ($resets >= $reset_cap_9 AND $resets < $reset_cap_10)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($point_cap_3*($reset_cap_3-$reset_cap_2))+($point_cap_4*($reset_cap_4-$reset_cap_3))+($point_cap_5*($reset_cap_5-$reset_cap_4))+($point_cap_6*($reset_cap_6-$reset_cap_5))+($point_cap_7*($reset_cap_7-$reset_cap_6))+($point_cap_8*($reset_cap_8-$reset_cap_7))+($point_cap_9*($reset_cap_9-$reset_cap_8))+($resets-($reset_cap_9-1))*$point_cap_10;
			
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($ml_cap_3*($reset_cap_3-$reset_cap_2))+($ml_cap_4*($reset_cap_4-$reset_cap_3))+($ml_cap_5*($reset_cap_5-$reset_cap_4))+($ml_cap_6*($reset_cap_6-$reset_cap_5))+($ml_cap_7*($reset_cap_7-$reset_cap_6))+($ml_cap_8*($reset_cap_8-$reset_cap_7))+($ml_cap_9*($reset_cap_9-$reset_cap_8))+($resets-($reset_cap_9-1))*$ml_cap_10;
		 }
	//Reset cấp 10 -> 11
	elseif ($resets >= $reset_cap_10 AND $resets < $reset_cap_11)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($point_cap_3*($reset_cap_3-$reset_cap_2))+($point_cap_4*($reset_cap_4-$reset_cap_3))+($point_cap_5*($reset_cap_5-$reset_cap_4))+($point_cap_6*($reset_cap_6-$reset_cap_5))+($point_cap_7*($reset_cap_7-$reset_cap_6))+($point_cap_8*($reset_cap_8-$reset_cap_7))+($point_cap_9*($reset_cap_9-$reset_cap_8))+($point_cap_10*($reset_cap_10-$reset_cap_9))+($resets-($reset_cap_10-1))*$point_cap_11;
			
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($ml_cap_3*($reset_cap_3-$reset_cap_2))+($ml_cap_4*($reset_cap_4-$reset_cap_3))+($ml_cap_5*($reset_cap_5-$reset_cap_4))+($ml_cap_6*($reset_cap_6-$reset_cap_5))+($ml_cap_7*($reset_cap_7-$reset_cap_6))+($ml_cap_8*($reset_cap_8-$reset_cap_7))+($ml_cap_9*($reset_cap_9-$reset_cap_8))+($ml_cap_10*($reset_cap_10-$reset_cap_9))+($resets-($reset_cap_10-1))*$ml_cap_11;
		}
	//Reset cấp 11 -> 12
	elseif ($resets >= $reset_cap_11 AND $resets < $reset_cap_12)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($point_cap_3*($reset_cap_3-$reset_cap_2))+($point_cap_4*($reset_cap_4-$reset_cap_3))+($point_cap_5*($reset_cap_5-$reset_cap_4))+($point_cap_6*($reset_cap_6-$reset_cap_5))+($point_cap_7*($reset_cap_7-$reset_cap_6))+($point_cap_8*($reset_cap_8-$reset_cap_7))+($point_cap_9*($reset_cap_9-$reset_cap_8))+($point_cap_10*($reset_cap_10-$reset_cap_9))+($point_cap_11*($reset_cap_11-$reset_cap_10))+($resets-($reset_cap_11-1))*$point_cap_12;
			
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($ml_cap_3*($reset_cap_3-$reset_cap_2))+($ml_cap_4*($reset_cap_4-$reset_cap_3))+($ml_cap_5*($reset_cap_5-$reset_cap_4))+($ml_cap_6*($reset_cap_6-$reset_cap_5))+($ml_cap_7*($reset_cap_7-$reset_cap_6))+($ml_cap_8*($reset_cap_8-$reset_cap_7))+($ml_cap_9*($reset_cap_9-$reset_cap_8))+($ml_cap_10*($reset_cap_10-$reset_cap_9))+($ml_cap_11*($reset_cap_11-$reset_cap_10))+($resets-($reset_cap_11-1))*$ml_cap_12;
		 }
	//Reset cấp 12 -> 13
	elseif ($resets >= $reset_cap_12 AND $resets < $reset_cap_13)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($point_cap_3*($reset_cap_3-$reset_cap_2))+($point_cap_4*($reset_cap_4-$reset_cap_3))+($point_cap_5*($reset_cap_5-$reset_cap_4))+($point_cap_6*($reset_cap_6-$reset_cap_5))+($point_cap_7*($reset_cap_7-$reset_cap_6))+($point_cap_8*($reset_cap_8-$reset_cap_7))+($point_cap_9*($reset_cap_9-$reset_cap_8))+($point_cap_10*($reset_cap_10-$reset_cap_9))+($point_cap_11*($reset_cap_11-$reset_cap_10))+($point_cap_12*($reset_cap_12-$reset_cap_11))+($resets-($reset_cap_12-1))*$point_cap_13;
			
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($ml_cap_3*($reset_cap_3-$reset_cap_2))+($ml_cap_4*($reset_cap_4-$reset_cap_3))+($ml_cap_5*($reset_cap_5-$reset_cap_4))+($ml_cap_6*($reset_cap_6-$reset_cap_5))+($ml_cap_7*($reset_cap_7-$reset_cap_6))+($ml_cap_8*($reset_cap_8-$reset_cap_7))+($ml_cap_9*($reset_cap_9-$reset_cap_8))+($ml_cap_10*($reset_cap_10-$reset_cap_9))+($ml_cap_11*($reset_cap_11-$reset_cap_10))+($ml_cap_12*($reset_cap_12-$reset_cap_11))+($resets-($reset_cap_12-1))*$ml_cap_13;
		}
	//Reset cấp 13 -> 14
	elseif ($resets >= $reset_cap_13 AND $resets < $reset_cap_14)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($point_cap_3*($reset_cap_3-$reset_cap_2))+($point_cap_4*($reset_cap_4-$reset_cap_3))+($point_cap_5*($reset_cap_5-$reset_cap_4))+($point_cap_6*($reset_cap_6-$reset_cap_5))+($point_cap_7*($reset_cap_7-$reset_cap_6))+($point_cap_8*($reset_cap_8-$reset_cap_7))+($point_cap_9*($reset_cap_9-$reset_cap_8))+($point_cap_10*($reset_cap_10-$reset_cap_9))+($point_cap_11*($reset_cap_11-$reset_cap_10))+($point_cap_12*($reset_cap_12-$reset_cap_11))+($point_cap_13*($reset_cap_13-$reset_cap_12))+($resets-($reset_cap_13-1))*$point_cap_14;
			
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($ml_cap_3*($reset_cap_3-$reset_cap_2))+($ml_cap_4*($reset_cap_4-$reset_cap_3))+($ml_cap_5*($reset_cap_5-$reset_cap_4))+($ml_cap_6*($reset_cap_6-$reset_cap_5))+($ml_cap_7*($reset_cap_7-$reset_cap_6))+($ml_cap_8*($reset_cap_8-$reset_cap_7))+($ml_cap_9*($reset_cap_9-$reset_cap_8))+($ml_cap_10*($reset_cap_10-$reset_cap_9))+($ml_cap_11*($reset_cap_11-$reset_cap_10))+($ml_cap_12*($reset_cap_12-$reset_cap_11))+($ml_cap_13*($reset_cap_13-$reset_cap_12))+($resets-($reset_cap_13-1))*$ml_cap_14;
		}
	//Reset cấp 14 -> 15
	elseif ($resets >= $reset_cap_14 AND $resets < $reset_cap_15)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($point_cap_3*($reset_cap_3-$reset_cap_2))+($point_cap_4*($reset_cap_4-$reset_cap_3))+($point_cap_5*($reset_cap_5-$reset_cap_4))+($point_cap_6*($reset_cap_6-$reset_cap_5))+($point_cap_7*($reset_cap_7-$reset_cap_6))+($point_cap_8*($reset_cap_8-$reset_cap_7))+($point_cap_9*($reset_cap_9-$reset_cap_8))+($point_cap_10*($reset_cap_10-$reset_cap_9))+($point_cap_11*($reset_cap_11-$reset_cap_10))+($point_cap_12*($reset_cap_12-$reset_cap_11))+($point_cap_13*($reset_cap_13-$reset_cap_12))+($point_cap_14*($reset_cap_14-$reset_cap_13))+($resets-($reset_cap_14-1))*$point_cap_15;
			
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($ml_cap_3*($reset_cap_3-$reset_cap_2))+($ml_cap_4*($reset_cap_4-$reset_cap_3))+($ml_cap_5*($reset_cap_5-$reset_cap_4))+($ml_cap_6*($reset_cap_6-$reset_cap_5))+($ml_cap_7*($reset_cap_7-$reset_cap_6))+($ml_cap_8*($reset_cap_8-$reset_cap_7))+($ml_cap_9*($reset_cap_9-$reset_cap_8))+($ml_cap_10*($reset_cap_10-$reset_cap_9))+($ml_cap_11*($reset_cap_11-$reset_cap_10))+($ml_cap_12*($reset_cap_12-$reset_cap_11))+($ml_cap_13*($reset_cap_13-$reset_cap_12))+($ml_cap_14*($reset_cap_14-$reset_cap_13))+($resets-($reset_cap_14-1))*$ml_cap_15;
		}
	//Reset cấp 15 -> 16
	elseif ($resets >= $reset_cap_15 AND $resets < $reset_cap_16)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($point_cap_3*($reset_cap_3-$reset_cap_2))+($point_cap_4*($reset_cap_4-$reset_cap_3))+($point_cap_5*($reset_cap_5-$reset_cap_4))+($point_cap_6*($reset_cap_6-$reset_cap_5))+($point_cap_7*($reset_cap_7-$reset_cap_6))+($point_cap_8*($reset_cap_8-$reset_cap_7))+($point_cap_9*($reset_cap_9-$reset_cap_8))+($point_cap_10*($reset_cap_10-$reset_cap_9))+($point_cap_11*($reset_cap_11-$reset_cap_10))+($point_cap_12*($reset_cap_12-$reset_cap_11))+($point_cap_13*($reset_cap_13-$reset_cap_12))+($point_cap_14*($reset_cap_14-$reset_cap_13))+($point_cap_15*($reset_cap_15-$reset_cap_14))+($resets-($reset_cap_15-1))*$point_cap_16;
			
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($ml_cap_3*($reset_cap_3-$reset_cap_2))+($ml_cap_4*($reset_cap_4-$reset_cap_3))+($ml_cap_5*($reset_cap_5-$reset_cap_4))+($ml_cap_6*($reset_cap_6-$reset_cap_5))+($ml_cap_7*($reset_cap_7-$reset_cap_6))+($ml_cap_8*($reset_cap_8-$reset_cap_7))+($ml_cap_9*($reset_cap_9-$reset_cap_8))+($ml_cap_10*($reset_cap_10-$reset_cap_9))+($ml_cap_11*($reset_cap_11-$reset_cap_10))+($ml_cap_12*($reset_cap_12-$reset_cap_11))+($ml_cap_13*($reset_cap_13-$reset_cap_12))+($ml_cap_14*($reset_cap_14-$reset_cap_13))+($ml_cap_15*($reset_cap_15-$reset_cap_14))+($resets-($reset_cap_15-1))*$ml_cap_16;
		}
	//Reset cấp 16 -> 17
	elseif ($resets >= $reset_cap_16 AND $resets < $reset_cap_17)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($point_cap_3*($reset_cap_3-$reset_cap_2))+($point_cap_4*($reset_cap_4-$reset_cap_3))+($point_cap_5*($reset_cap_5-$reset_cap_4))+($point_cap_6*($reset_cap_6-$reset_cap_5))+($point_cap_7*($reset_cap_7-$reset_cap_6))+($point_cap_8*($reset_cap_8-$reset_cap_7))+($point_cap_9*($reset_cap_9-$reset_cap_8))+($point_cap_10*($reset_cap_10-$reset_cap_9))+($point_cap_11*($reset_cap_11-$reset_cap_10))+($point_cap_12*($reset_cap_12-$reset_cap_11))+($point_cap_13*($reset_cap_13-$reset_cap_12))+($point_cap_14*($reset_cap_14-$reset_cap_13))+($point_cap_15*($reset_cap_15-$reset_cap_14))+($point_cap_16*($reset_cap_16-$reset_cap_15))+($resets-($reset_cap_16-1))*$point_cap_17;
			
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($ml_cap_3*($reset_cap_3-$reset_cap_2))+($ml_cap_4*($reset_cap_4-$reset_cap_3))+($ml_cap_5*($reset_cap_5-$reset_cap_4))+($ml_cap_6*($reset_cap_6-$reset_cap_5))+($ml_cap_7*($reset_cap_7-$reset_cap_6))+($ml_cap_8*($reset_cap_8-$reset_cap_7))+($ml_cap_9*($reset_cap_9-$reset_cap_8))+($ml_cap_10*($reset_cap_10-$reset_cap_9))+($ml_cap_11*($reset_cap_11-$reset_cap_10))+($ml_cap_12*($reset_cap_12-$reset_cap_11))+($ml_cap_13*($reset_cap_13-$reset_cap_12))+($ml_cap_14*($reset_cap_14-$reset_cap_13))+($ml_cap_15*($reset_cap_15-$reset_cap_14))+($ml_cap_16*($reset_cap_16-$reset_cap_15))+($resets-($reset_cap_16-1))*$ml_cap_17;
		}
	//Reset cấp 17 -> 18
	elseif ($resets >= $reset_cap_17 AND $resets < $reset_cap_18)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($point_cap_3*($reset_cap_3-$reset_cap_2))+($point_cap_4*($reset_cap_4-$reset_cap_3))+($point_cap_5*($reset_cap_5-$reset_cap_4))+($point_cap_6*($reset_cap_6-$reset_cap_5))+($point_cap_7*($reset_cap_7-$reset_cap_6))+($point_cap_8*($reset_cap_8-$reset_cap_7))+($point_cap_9*($reset_cap_9-$reset_cap_8))+($point_cap_10*($reset_cap_10-$reset_cap_9))+($point_cap_11*($reset_cap_11-$reset_cap_10))+($point_cap_12*($reset_cap_12-$reset_cap_11))+($point_cap_13*($reset_cap_13-$reset_cap_12))+($point_cap_14*($reset_cap_14-$reset_cap_13))+($point_cap_15*($reset_cap_15-$reset_cap_14))+($point_cap_16*($reset_cap_16-$reset_cap_15))+($point_cap_17*($reset_cap_17-$reset_cap_16))+($resets-($reset_cap_17-1))*$point_cap_18;
			
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($ml_cap_3*($reset_cap_3-$reset_cap_2))+($ml_cap_4*($reset_cap_4-$reset_cap_3))+($ml_cap_5*($reset_cap_5-$reset_cap_4))+($ml_cap_6*($reset_cap_6-$reset_cap_5))+($ml_cap_7*($reset_cap_7-$reset_cap_6))+($ml_cap_8*($reset_cap_8-$reset_cap_7))+($ml_cap_9*($reset_cap_9-$reset_cap_8))+($ml_cap_10*($reset_cap_10-$reset_cap_9))+($ml_cap_11*($reset_cap_11-$reset_cap_10))+($ml_cap_12*($reset_cap_12-$reset_cap_11))+($ml_cap_13*($reset_cap_13-$reset_cap_12))+($ml_cap_14*($reset_cap_14-$reset_cap_13))+($ml_cap_15*($reset_cap_15-$reset_cap_14))+($ml_cap_16*($reset_cap_16-$reset_cap_15))+($ml_cap_17*($reset_cap_17-$reset_cap_16))+($resets-($reset_cap_17-1))*$ml_cap_18;
		}
	//Reset cấp 18 -> 19
	elseif ($resets >= $reset_cap_18 AND $resets < $reset_cap_19)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($point_cap_3*($reset_cap_3-$reset_cap_2))+($point_cap_4*($reset_cap_4-$reset_cap_3))+($point_cap_5*($reset_cap_5-$reset_cap_4))+($point_cap_6*($reset_cap_6-$reset_cap_5))+($point_cap_7*($reset_cap_7-$reset_cap_6))+($point_cap_8*($reset_cap_8-$reset_cap_7))+($point_cap_9*($reset_cap_9-$reset_cap_8))+($point_cap_10*($reset_cap_10-$reset_cap_9))+($point_cap_11*($reset_cap_11-$reset_cap_10))+($point_cap_12*($reset_cap_12-$reset_cap_11))+($point_cap_13*($reset_cap_13-$reset_cap_12))+($point_cap_14*($reset_cap_14-$reset_cap_13))+($point_cap_15*($reset_cap_15-$reset_cap_14))+($point_cap_16*($reset_cap_16-$reset_cap_15))+($point_cap_17*($reset_cap_17-$reset_cap_16))+($point_cap_18*($reset_cap_18-$reset_cap_17))+($resets-($reset_cap_18-1))*$point_cap_19;
			
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($ml_cap_3*($reset_cap_3-$reset_cap_2))+($ml_cap_4*($reset_cap_4-$reset_cap_3))+($ml_cap_5*($reset_cap_5-$reset_cap_4))+($ml_cap_6*($reset_cap_6-$reset_cap_5))+($ml_cap_7*($reset_cap_7-$reset_cap_6))+($ml_cap_8*($reset_cap_8-$reset_cap_7))+($ml_cap_9*($reset_cap_9-$reset_cap_8))+($ml_cap_10*($reset_cap_10-$reset_cap_9))+($ml_cap_11*($reset_cap_11-$reset_cap_10))+($ml_cap_12*($reset_cap_12-$reset_cap_11))+($ml_cap_13*($reset_cap_13-$reset_cap_12))+($ml_cap_14*($reset_cap_14-$reset_cap_13))+($ml_cap_15*($reset_cap_15-$reset_cap_14))+($ml_cap_16*($reset_cap_16-$reset_cap_15))+($ml_cap_17*($reset_cap_17-$reset_cap_16))+($ml_cap_18*($reset_cap_18-$reset_cap_17))+($resets-($reset_cap_18-1))*$ml_cap_19;
		}
	//Reset cấp 19 -> 20
	elseif ($resets >= $reset_cap_19 AND $resets < $reset_cap_20)
		{
			$resetpoint=$point_relifes+($point_cap_1*$reset_cap_1)+($point_cap_2*($reset_cap_2-$reset_cap_1))+($point_cap_3*($reset_cap_3-$reset_cap_2))+($point_cap_4*($reset_cap_4-$reset_cap_3))+($point_cap_5*($reset_cap_5-$reset_cap_4))+($point_cap_6*($reset_cap_6-$reset_cap_5))+($point_cap_7*($reset_cap_7-$reset_cap_6))+($point_cap_8*($reset_cap_8-$reset_cap_7))+($point_cap_9*($reset_cap_9-$reset_cap_8))+($point_cap_10*($reset_cap_10-$reset_cap_9))+($point_cap_11*($reset_cap_11-$reset_cap_10))+($point_cap_12*($reset_cap_12-$reset_cap_11))+($point_cap_13*($reset_cap_13-$reset_cap_12))+($point_cap_14*($reset_cap_14-$reset_cap_13))+($point_cap_15*($reset_cap_15-$reset_cap_14))+($point_cap_16*($reset_cap_16-$reset_cap_15))+($point_cap_17*($reset_cap_17-$reset_cap_16))+($point_cap_18*($reset_cap_18-$reset_cap_17))+($point_cap_19*($reset_cap_19-$reset_cap_18))+($resets-($reset_cap_19-1))*$point_cap_20;
			
			$leadership=$ml_relifes+($ml_cap_1*$reset_cap_1)+($ml_cap_2*($reset_cap_2-$reset_cap_1))+($ml_cap_3*($reset_cap_3-$reset_cap_2))+($ml_cap_4*($reset_cap_4-$reset_cap_3))+($ml_cap_5*($reset_cap_5-$reset_cap_4))+($ml_cap_6*($reset_cap_6-$reset_cap_5))+($ml_cap_7*($reset_cap_7-$reset_cap_6))+($ml_cap_8*($reset_cap_8-$reset_cap_7))+($ml_cap_9*($reset_cap_9-$reset_cap_8))+($ml_cap_10*($reset_cap_10-$reset_cap_9))+($ml_cap_11*($reset_cap_11-$reset_cap_10))+($ml_cap_12*($reset_cap_12-$reset_cap_11))+($ml_cap_13*($reset_cap_13-$reset_cap_12))+($ml_cap_14*($reset_cap_14-$reset_cap_13))+($ml_cap_15*($reset_cap_15-$reset_cap_14))+($ml_cap_16*($reset_cap_16-$reset_cap_15))+($ml_cap_17*($reset_cap_17-$reset_cap_16))+($ml_cap_18*($reset_cap_18-$reset_cap_17))+($ml_cap_19*($reset_cap_19-$reset_cap_18))+($resets-($reset_cap_19-1))*$ml_cap_20;
		}
}

	if ( $row[4] == 64 OR $row[4] == 65 OR $row[4] == 66 ) {
		$point_reset = $resetpoint + $leadership;
}
else { $point_reset = $resetpoint; }

if ( $row[13] == 1 ) { 
	if ($row[15] > 0) {
		$pointthue = $row[15];
	} else {
		switch($row[3]) {
			case 0: $pointthue = 20000; break;
			case 1: $pointthue = 30000; break;
			case 2: $pointthue = 40000; break;
			case 3: $pointthue = 50000; break;
			default: $pointthue = 50000; break;
		}
	}
} else $pointthue = 0;

	
$point_lv = 7*$row[5];

$point_chenh = $point_now - ($point_reset + $point_lv + $pointthue);

if ( $point_chenh > 5000 ) {
	$rank = $rank+1;
	
	if ( $row[13] == 0 ) { $thuepoint = 'Không'; $pointthue = ''; }
	elseif ( $row[13] == 1 ) { $thuepoint = 'Có'; }
	
	if ( ($row[13] == 1) ) { 
		if ( ($point_chenh - $thuepoint_max) > 10000 ) {
		$point_chenh = "<font color='red'>$point_chenh</font>"; }
	}
	else {
		if ( $point_chenh > 15000 ) { $point_chenh = "<font color='red'>$point_chenh</font>"; }
		elseif ( $point_chenh > 10000 ) { $point_chenh = "<font color='orange'>$point_chenh</font>"; }
	}
	
	if ($row[14] == 1) {
		$reset_type = 'VIP';
	} else $reset_type = 'Thường';
	
	echo "<tr bgcolor='#F9E7CF' >
		<td align='center'>$rank</td>
		<td align='center'>$row[0]</td>
		<td align='center'>$row[1]</td>
		<td align='center'><font color='blue'>$row[2]</font>/<font color='red'>$row[3]</font> - $row[5]</td>
		<td align='center'>$reset_type</td>
		<td align='center'>$Class</td>
		<td align='center'>$point_now</td>
		<td align='center'>$point_reset</td>
		<td align='center'>$point_chenh</td>
		<td align='center'>$thuepoint</td>
		<td align='center'>$pointthue</td>
	</tr>";
}
} 
?>
</table>
<script type="text/javascript" src="js/tooltip.js"></script>
</body>
</html>