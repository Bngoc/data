<?php
$page = $_GET['page'];

switch ($act) {
	case 'shop_armor': 
		$file_edit = 'config/shop_armor.txt';
		$folder_img = 'shop_armor';
		$tilte = "Cửa hàng Giáp trụ";
		break;
	case 'shop_wings': 
		$file_edit = 'config/shop_wings.txt';
		$folder_img = 'shop_wings';
		$tilte = "Cửa hàng Cánh";
		break;
	case 'shop_ringpendants': 
		$file_edit = 'config/shop_ringpendants.txt';
		$folder_img = 'shop_ringpendants';
		$tilte = "Cửa hàng Trang sức";
		break;
	case 'shop_shields': 
		$file_edit = 'config/shop_shields.txt';
		$folder_img = 'shop_shields';
		$tilte = "Cửa hàng Khiên";
		break;
	case 'shop_crossbows': 
		$file_edit = 'config/shop_crossbows.txt';
		$folder_img = 'shop_crossbows';
		$tilte = "Cửa hàng Cung - Nỏ";
		break;
	case 'shop_weapons': 
		$file_edit = 'config/shop_weapons.txt';
		$folder_img = 'shop_weapons';
		$tilte = "Cửa hàng Đao - Kiếm";
		break;
	case 'shop_scepters': 
		$file_edit = 'config/shop_scepters.txt';
		$folder_img = 'shop_scepters';
		$tilte = "Cửa hàng Quyền trượng";
		break;
	case 'shop_staffs': 
		$file_edit = 'config/shop_staffs.txt';
		$folder_img = 'shop_staffs';
		$tilte = "Cửa hàng Gậy";
		break;
	case 'shop_spears': 
		$file_edit = 'config/shop_spears.txt';
		$folder_img = 'shop_spears';
		$tilte = "Cửa hàng Thương - Giáo";
		break;
	case 'shop_fenrir': 
		$file_edit = 'config/shop_fenrir.txt';
		$folder_img = 'shop_fenrir';
		$tilte = "Cửa hàng Linh hồn sói tinh";
		break;
	case 'shop_eventticket': 
		$file_edit = 'config/shop_eventticket.txt';
		$folder_img = 'shop_eventticket';
		$tilte = "Cửa hàng Vé sự kiện";
		break;
	case 'shop_orther': 
		$file_edit = 'config/shop_orther.txt';
		$folder_img = 'shop_orther';
		$tilte = "Cửa hàng Các loại khác";
		break;
	default: $file_edit = ''; break;
}

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

if($accept==0) $show_accept = "disabled='disabled'";
else $show_accept = "";

require_once('admin/function.php');


$action = $_POST[action];

switch ($action)
{
	case 'add':
		$code = $_POST['code'];
		$name = $_POST['name'];
		$price = $_POST['price'];
		$img = $_POST['img'];
		
		$content = "\n".$code."|".$name."|".$price."|".$img."|";
		
		addcontent($file_edit,$content);
		if (!$usehost) addcontent($file_edit_sv,$content);
		
		$notice = "<center><b><font color='red'>Đã Thêm</font></b></center>";
		break;
	
	case 'edit':
		$item = $_POST['item'];
		$code = $_POST['code'];
		$name = $_POST['name'];
		$price = $_POST['price'];
		$img = $_POST['img'];
		
		$item_get = shop_load($file_edit);
		
		$item_get[$item][code] = $code;
		$item_get[$item][name] = $name;
		$item_get[$item][price] = $price;
		$item_get[$item][img] = $img;
		
		$slg_item = count($item_get);
		$content = '';
		for($i=0;$i<$slg_item;$i++)
		{
			$content .= $item_get[$i][code]."|".$item_get[$i][name]."|".$item_get[$i][price]."|".$item_get[$i][img]."|";
			if($i<($slg_item-1)) $content .= "\n";
		}
		
		replacecontent($file_edit,$content);
		if (!$usehost) replacecontent($file_edit_sv,$content);
		
		$notice = "<center><b><font color='red'>Đã Sửa</font></b></center>";
		break;
	
	case 'del':
		$item = $_POST['item'];
		
		$item_get = shop_load($file_edit);
		$slg_item = count($item_get);
		$content = '';
		for($i=0;$i<$slg_item;$i++)
		{
			if($i != $item)
			{
				$content .= $item_get[$i][code]."|".$item_get[$i][name]."|".$item_get[$i][price]."|".$item_get[$i][img]."|";
			if( $i<($slg_item-1) ) $content .= "\n";
			}
		}
		replacecontent($file_edit,$content);
		if (!$usehost) replacecontent($file_edit_sv,$content);
		$notice = "<center><b><font color='red'>Đã Xóa</font></b></center>";
		break;
}


$item_read = shop_load($file_edit);
?>
		<div id="center-column">
			<div class="top-bar">
				<h1>Cấu Hình <?php echo $tilte; ?></h1>
			</div><br>
				Tập tin <?php echo "<b>".$file_edit."</b> : ".$can_write; ?><?php if (!$usehost) {?><br>
				Tập tin <?php echo "<b>".$file_edit_sv."</b> : ".$can_write_sv; ?><?php }?>
		  <div class="select-bar"></div>
			<div class="table">
<?php 
if($notice) echo $notice;

switch ($page)
{
	case 'add': 
		$content = "<center><b>Thêm Item</b></center><br>
			<form id='editconfig' name='editconfig' method='post' action='admin.php?mod=editwebshop&act=".$act."'>
			<input type='hidden' name='action' value='add'/>
			<table width='100%' border='0' cellpadding='3' cellspacing='1' bgcolor='#9999FF'>
				<tr bgcolor='#FFFFFF' >
					<td >Mã Item</td>
					<td ><input type='text' name='code' value='0D0096FC1E7A000000E0000000000000' size='36' maxlength='32'/> (32 mã lấy từ MuMaker)</td>
				</tr>
				<tr bgcolor='#FFFFFF' >
					<td >Tên Item</td>
					<td ><input type='text' name='name' value='Bless' size='30'/> (Chú giải về Item)</td>
				</tr>
				<tr bgcolor='#FFFFFF' >
					<td >Giá Item</td>
					<td ><input type='text' name='price' value='1000' size='5'/> Vpoint</td>
				</tr>
				<tr bgcolor='#FFFFFF' >
					<td >Hình Item</td>
					<td ><input type='text' name='img' value='bless.jpg' size='20'/> Hình nằm trong thư mục <b></i>images/".$folder_img."</i></b></td>
				</tr>
				<tr bgcolor='#FFFFFF' >
					<td >&nbsp;</td>
					<td align='center'><input type='submit' name='Submit' value='Thêm Item' ". $show_accept ." /></td>
				</tr>
			</table>
			</form>";
		echo $content;
		break;
	
	case 'edit': 
		$item = $_GET['item'];
		$item_right = $item - 1;
		$content = "<center><b>Sửa Item</b></center><br>
			<form id='editconfig' name='editconfig' method='post' action='admin.php?mod=editwebshop&act=".$act."'>
			<input type='hidden' name='action' value='edit'/>
			<input type='hidden' name='item' value='".$item_right."'/>
			<table width='100%' border='0' cellpadding='3' cellspacing='1' bgcolor='#9999FF'>
				<tr bgcolor='#FFFFFF' >
					<td >Mã Item</td>
					<td ><input type='text' name='code' value='".$item_read[$item_right][code]."' size='36' maxlength='32'/> (32 mã lấy từ MuMaker)</td>
				</tr>
				<tr bgcolor='#FFFFFF' >
					<td >Tên Item</td>
					<td ><input type='text' name='name' value='".$item_read[$item_right][name]."' size='30'/> (Chú giải về Item)</td>
				</tr>
				<tr bgcolor='#FFFFFF' >
					<td >Giá Item</td>
					<td ><input type='text' name='price' value='".$item_read[$item_right][price]."' size='5'/> Vpoint</td>
				</tr>
				<tr bgcolor='#FFFFFF' >
					<td >Hình Item</td>
					<td ><input type='text' name='img' value='".$item_read[$item_right][img]."' size='20'/> 
					<img src='images/".$folder_img."/".$item_read[$item_right][img]."'>
					<br>Hình nằm trong thư mục <b></i>images/".$folder_img."</i></b></td>
				</tr>
				<tr bgcolor='#FFFFFF' >
					<td >&nbsp;</td>
					<td align='center'><input type='submit' name='Submit' value='Sửa' ". $show_accept ." /></td>
				</tr>
			</table>
			</form>";
		echo $content;
		break;
	
	case 'del':
		$item = $_GET['item'];
		$item_right = $item - 1;
		$content = "<center><b>Xóa Item</b></center><br>
			<form id='delitem' name='delitem' method='post' action='admin.php?mod=editwebshop&act=".$act."'>
			<input type='hidden' name='action' value='del'/>
			<input type='hidden' name='item' value='".$item_right."'/>
			<table width='100%' border='0' cellpadding='3' cellspacing='1' bgcolor='#9999FF'>
				<tr bgcolor='#FFFFFF' >
					<td >Mã Item</td>
					<td >".$item_read[$item_right][code]."</td>
				</tr>
				<tr bgcolor='#FFFFFF' >
					<td >Tên Item</td>
					<td >".$item_read[$item_right][name]."</td>
				</tr>
				<tr bgcolor='#FFFFFF' >
					<td >Giá Item</td>
					<td >".$item_read[$item_right][price]." Vpoint</td>
				</tr>
				<tr bgcolor='#FFFFFF' >
					<td >Hình Item</td>
					<td ><img src='images/".$folder_img."/".$item_read[$item_right][img]."'></td>
				</tr>
				<tr bgcolor='#FFFFFF' >
					<td >&nbsp;</td>
					<td align='center'><input type='submit' name='Submit' value='Xóa' ". $show_accept ." /></td>
				</tr>
			</table>
			</form>";
		echo $content;
		
		break;	
		
	default: 
		echo "<div align='right'><a href='admin.php?mod=editwebshop&act=".$act."&page=add'>+ Thêm Item</a></div><br>";
		display_shop($item_read,$act); 
		break;
	
}

?>
				
			</div>
		</div>
		<div id="right-column">
			<strong class="h">Thông tin</strong>
			<div class="box">Cấu hình :<br>
			- Tên WebSite<br>
			- Địa chỉ kết nối đến Server</div>
	  </div>
	  
