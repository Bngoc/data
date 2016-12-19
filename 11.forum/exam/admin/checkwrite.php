<?php
//Kiểm tra quyền Ghi File
$file[]	=	'modules/ranking/top.txt';
$file[]	=	'modules/ranking/top_DK.txt';
$file[]	=	'modules/ranking/top_DL.txt';
$file[]	=	'modules/ranking/top_DW.txt';
$file[]	=	'modules/ranking/top_ELF.txt';
$file[]	=	'modules/ranking/top_MG.txt';
$file[]	=	'modules/ranking/top_SuM.txt';
$file[]	=	'modules/ranking/top_RF.txt';
$file[]	=	'modules/ranking/topMonth.txt';
$file[]	=	'modules/ranking/topGuild.txt';

$file[]	=	'config/config_chucnang.php';
$file[]	=	'config/config_changeclass.php';
$file[]	=	'config/config_gioihanrs.php';
$file[]	=	'config/config_hotrotanthu.php';
$file[]	=	'config/config_napthe.php';
$file[]	=	'config/config_pk.php';
$file[]	=	'config/config_relife.php';
$file[]	=	'config/config_reset.php';
$file[]	=	'config/config_resetvip.php';
$file[]	=	'config/config_taypoint.php';
$file[]	=	'config/config_uythacoffline.php';
$file[]	=	'config/config_uythac_reset.php';
$file[]	=	'config/config_uythac_resetvip.php';

$file[]	=	'config/shop_armor.txt';
$file[]	=	'config/shop_wings.txt';
$file[]	=	'config/shop_ringpendants.txt';
$file[]	=	'config/shop_shields.txt';
$file[]	=	'config/shop_crossbows.txt';
$file[]	=	'config/shop_weapons.txt';
$file[]	=	'config/shop_scepters.txt';
$file[]	=	'config/shop_staffs.txt';
$file[]	=	'config/shop_spears.txt';
$file[]	=	'config/shop_fenrir.txt';
$file[]	=	'config/shop_eventticket.txt';
$file[]	=	'config/shop_orther.txt';

$folder[] = 'firewall';
$folder[] = 'modules/ranking';

$count_file = count($file);
$cound_folder = count($folder);
?>
		<div id="center-column">
			<div class="top-bar">
				<h1>Contents</h1>
			</div><br>
		  <div class="select-bar"></div>
			<div class="table">
			<center>
				Để <b>file</b> có thể ghi : Vui lòng sử dụng chương trình <a href='http://filezilla-project.org/download.php' target='_blank'><b>FileZilla</b></a> chuyển <b>File permission</b> sang <b>666</b><br>
				Để <b>thư mục</b> có thể ghi : Vui lòng sử dụng chương trình <a href='http://filezilla-project.org/download.php' target='_blank'><b>FileZilla</b></a> chuyển <b>File permission</b> sang <b>777</b><br>
				<img src="images/chmod.jpg">
			</center>
<?php
				for ($i=0;$i<$cound_folder;$i++)
					{
						if(is_writable($folder[$i]))	{ $can_write = "<font color=green>Có thể ghi</font>"; }
						else { $can_write = "<font color=red>Chuyển <b>File permission</b> của Folder <b>$file[$i]</b> sang <b>777</b></font>"; }
						echo "- Folder <b>$folder[$i]</b> : $can_write<br>";
					}
				echo '<br>';
				for ($i=0;$i<$count_file;$i++)
					{
						if(is_writable($file[$i]))	{ $can_write = "<font color=green>Có thể ghi</font>"; }
						else { $can_write = "<font color=red>Chuyển <b>File permission</b> của file <b>$file[$i]</b> sang <b>666</b></font>"; }
						echo "- File <b>$file[$i]</b> : $can_write<br>";
					}
					
?>
			</div>
		</div>
		<div id="right-column">
			<strong class="h">INFO</strong>
			<div class="box">Detect
and eliminate viruses and Trojan horses, even new and unknown ones.
Detect and eliminate viruses and Trojan horses, even new and </div>
	  </div>