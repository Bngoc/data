<?php
$file_edit = 'config/Items_Data.txt';
if(!is_file($file_edit)) 
{ 
	$fp_host = fopen($file_edit, "w");
	fclose($fp_host);
}

if(is_writable($file_edit))	{ $can_write = "<font color=green>Có thể ghi</font>"; $accept = 1;}
	else { $can_write = "<font color=red>Không thể ghi - Hãy sử dụng chương trình FTP FileZilla chuyển <b>File permission</b> sang 666</font>"; $accept = 0; }

if (!$usehost) {
	$file_edit_sv = $server_path;
	$file_edit_sv .= $file_edit;
	if(!is_file($file_edit_sv)) 
	{ 
		$fp_host = fopen($file_edit_sv, "w");
		fclose($fp_host);
	}
	if(is_writable($file_edit_sv))	{ $can_write_sv = "<font color=green>Có thể ghi</font>"; $accept = 1;}
		else { $can_write_sv = "<font color=red>Không thể ghi - Hãy sử dụng chương trình FTP FileZilla chuyển <b>File permission</b> sang 666</font>"; $accept = 0; }
}

$action = $_POST[action];

if($action == 'add')
{
	$group = $_POST['Group'];
	$id = $_POST['Id'];
	$name = $_POST['Name'];
	$x = $_POST['X'];
	$y = $_POST['Y'];
	$set1 = $_POST['SetOption1'];
	$set2 = $_POST['SetOption2'];
	$image = sprintf("%02d",$group,00).sprintf("%03d",$id,000)."00";
	$content = $image."|".$group."|".$id."|".$name."|".$x."|".$y."|".$set1."|".$set2."|\n";
	
	require_once('admin/function.php');
	addcontent($file_edit,$content);
	if (!$usehost) addcontent($file_edit_sv,$content);
	$name = str_replace(" ","_",$name);
	$form_data = "image=$image&group=$group&id=$id&name=$name&x=$x&y=$y&set1=$set1&set2=$set2&passtransfer=$passtransfer";
	$show_reponse = @file_get_contents($server_url."/do_adddata.php?".$form_data);
	
	$notice = "<center><font color='red'>$show_reponse</font></center>";
}
?>
		<div id="center-column">
			<div class="top-bar">
				<h1>Cấu Hình WebSite</h1>
			</div><br>
			Tập tin <?php echo "<b>".$file_edit."</b> : ".$can_write; ?><?php if (!$usehost) {?><br>
			Tập tin <?php echo "<b>".$file_edit_sv."</b> : ".$can_write_sv; ?><?php }?>
		  <div class="select-bar"></div>
			<div class="table">
<?php if($notice) echo $notice; ?>
				<form id="adddata" name="adddata" method="post" action="">
				<input type="hidden" name="action" value="add">
				<table>
					<tr>
						<td width="100" align="right">Group: </td>
						<td><select name="Group" size="1">
								<option value="0">0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
							</select>
						<b><i>Mô tả</i></b> : Group Item</td>
					</tr>
					<tr>
						<td align="right">Id: </td>
						<td><input type="text" name="Id" size="1">
						<b><i>Mô tả</i></b> : Id Item</td>
					</tr>
					<tr>
						<td align="right">Tên: </td>
						<td><input type="text" name="Name">
						<b><i>Mô tả</i></b> : Tên Item</td>
					</tr>
					<tr>
						<td align="right">X: </td>
						<td><input type="text" name="X" size="1">
						<b><i>Mô tả</i></b> : Chiều rộng Item</td>
					</tr>
					<tr>
						<td align="right">Y: </td>
						<td><input type="text" name="Y" size="1">
						<b><i>Mô tả</i></b> : Chiều cao Item</td>
					</tr>
					<tr>
						<td align="right">Tính năng Thần 1: </td>
						<td><select name="SetOption1" size="1">
								<option value="NO">NO</option>
								<option value="Warrior">Warrior</option>
								<option value="Abstract">Abstract</option>
								<option value="Hyperio">Hyperio</option>
								<option value="The Mist">The Mist</option>
								<option value="Eplete">Eplete</option>
								<option value="Berserker">Berserker</option>
								<option value="Garuda">Garuda</option>
								<option value="Cloud">Cloud</option>
								<option value="Kantata">Kantata</option>
								<option value="Rave">Rave</option>
								<option value="Hyon">Hyon</option>
								<option value="Vicius">Vicius</option>
								<option value="Apolo">Apolo</option>
								<option value="Banekeui">Banekeui</option>
								<option value="Evis">Evis</option>
								<option value="Seeley">Seeley</option>
								<option value="Hera">Hera</option>
								<option value="Mine">Mine</option>
								<option value="Anubis">Anubis</option>
								<option value="Isis">Isis</option>
								<option value="Ceto">Ceto</option>
								<option value="Big Dry">Big Dry</option>
								<option value="Gaia">Gaia</option>
								<option value="Phase">Phase</option>
								<option value="Odin">Odin</option>
								<option value="Aelbianui">Aelbianui</option>
								<option value="Argon">Argon</option>
								<option value="Charisteas">Charisteas</option>
								<option value="Gywen">Gywen</option>
								<option value="Aruane">Aruane</option>
								<option value="Gaion">Gaion</option>
								<option value="Muren">Muren</option>
								<option value="Agnis">Agnis</option>
								<option value="Browii">Browii</option>
								<option value="Krono">Krono</option>
								<option value="Semeden">Semeden</option>
							</select>
						<b><i>Mô tả</i></b> : Tính năng Thần của Item</td>
					</tr>
					<tr>
						<td align="right">Tính năng Thần 2: </td>
						<td><select name="SetOption2" size="1">
								<option value="NO">NO</option>
								<option value="Warrior">Warrior</option>
								<option value="Abstract">Abstract</option>
								<option value="Hyperio">Hyperio</option>
								<option value="The Mist">The Mist</option>
								<option value="Eplete">Eplete</option>
								<option value="Berserker">Berserker</option>
								<option value="Garuda">Garuda</option>
								<option value="Cloud">Cloud</option>
								<option value="Kantata">Kantata</option>
								<option value="Rave">Rave</option>
								<option value="Hyon">Hyon</option>
								<option value="Vicius">Vicius</option>
								<option value="Apolo">Apolo</option>
								<option value="Banekeui">Banekeui</option>
								<option value="Evis">Evis</option>
								<option value="Seeley">Seeley</option>
								<option value="Hera">Hera</option>
								<option value="Mine">Mine</option>
								<option value="Anubis">Anubis</option>
								<option value="Isis">Isis</option>
								<option value="Ceto">Ceto</option>
								<option value="Big Dry">Big Dry</option>
								<option value="Gaia">Gaia</option>
								<option value="Phase">Phase</option>
								<option value="Odin">Odin</option>
								<option value="Aelbianui">Aelbianui</option>
								<option value="Argon">Argon</option>
								<option value="Charisteas">Charisteas</option>
								<option value="Gywen">Gywen</option>
								<option value="Aruane">Aruane</option>
								<option value="Gaion">Gaion</option>
								<option value="Muren">Muren</option>
								<option value="Agnis">Agnis</option>
								<option value="Browii">Browii</option>
								<option value="Krono">Krono</option>
								<option value="Semeden">Semeden</option>
							</select>
						<b><i>Mô tả</i></b> : Tính năng Thần của Item</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="center"><input type="submit" name="Submit" value="Thêm" <?php if($accept=='0') { ?> disabled="disabled" <?php } ?> ></td>
					</tr>
				</table>
				</form>
			</div>
		</div>
		<div id="right-column">
			<strong class="h">Thông tin</strong>
			<div class="box">Cấu hình :<br>
			- Tên WebSite<br>
			- Địa chỉ kết nối đến Server</div>
	  </div>
	  
