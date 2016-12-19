<?php
$file_edit = 'config/config_napthe_viettel.php';
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

if($action == 'edit')
{
	$content = "<?php\n";
	
	$use_card10k = $_POST['use_card10k'];		$content .= "\$use_card10k	= $use_card10k;\n";
	$use_card20k = $_POST['use_card20k'];		$content .= "\$use_card20k	= $use_card20k;\n";
	$use_card30k = $_POST['use_card30k'];		$content .= "\$use_card30k	= $use_card30k;\n";
	$use_card50k = $_POST['use_card50k'];		$content .= "\$use_card50k	= $use_card50k;\n";
	$use_card100k = $_POST['use_card100k'];		$content .= "\$use_card100k	= $use_card100k;\n";
	$use_card200k = $_POST['use_card200k'];		$content .= "\$use_card200k	= $use_card200k;\n";
	$use_card300k = $_POST['use_card300k'];		$content .= "\$menhgia300000	= $use_card300k;\n";
	$use_card500k = $_POST['use_card500k'];		$content .= "\$use_card500k	= $use_card500k;\n";
	
	$menhgia10000 = $_POST['menhgia10000'];		$content .= "\$menhgia10000	= $menhgia10000;\n";
	$menhgia20000 = $_POST['menhgia20000'];		$content .= "\$menhgia20000	= $menhgia20000;\n";
	$menhgia30000 = $_POST['menhgia30000'];		$content .= "\$menhgia30000	= $menhgia30000;\n";
	$menhgia50000 = $_POST['menhgia50000'];		$content .= "\$menhgia50000	= $menhgia50000;\n";
	$menhgia100000 = $_POST['menhgia100000'];	$content .= "\$menhgia100000	= $menhgia100000;\n";
	$menhgia200000 = $_POST['menhgia200000'];	$content .= "\$menhgia200000	= $menhgia200000;\n";
	$menhgia300000 = $_POST['menhgia300000'];	$content .= "\$menhgia300000	= $menhgia300000;\n";
	$menhgia500000 = $_POST['menhgia500000'];	$content .= "\$menhgia500000	= $menhgia500000;\n";
	
	$content .= "?>";
	
	require_once('admin/function.php');
	replacecontent($file_edit,$content);
	if (!$usehost) replacecontent($file_edit_sv,$content);
	
	$notice = "<center><font color='red'>Sửa thành công</font></center>";
}

include($file_edit);
?>
<script type="text/javascript">
    function ConvertNumeric(me)
    {
        txt= me.firstChild;
        var arr=new Array();
        var strPass = txt.value;

        var strLength = strPass.length;
        var Achar = strPass.charAt((strLength) - 1); 
        var cCode = CalcKeyCode(Achar);
        if (cCode < 48 || cCode > 57 ) 
        {
        var myNumber = txt.value.substring(0, (strLength) - 1);
        txt.value = myNumber; 
        return;
        } 
                
        arr=strPass.split("."); 
        var numeric='';
        for(var i=0;i<arr.length;i++)
        {
        numeric+=arr[i];
        }      

        txt.value=numberFormat(numeric) ; 
        }
        function CalcKeyCode(aChar) 
        {
        var character = aChar.substring(0,1);
        var code = aChar.charCodeAt(0);
        return code;
        }

        function numberFormat(nStr)
        {
        nStr += '';
        x = nStr.split(',');
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1))
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
        return x1 + x2;
    }
</script>

		<div id="center-column">
			<div class="top-bar">
				<h1>Cấu Hình Nạp thẻ</h1>
			</div><br>
			Tập tin <?php echo "<b>".$file_edit."</b> : ".$can_write; ?><?php if (!$usehost) {?><br>
			Tập tin <?php echo "<b>".$file_edit_sv."</b> : ".$can_write_sv; ?><?php }?>
		  <div class="select-bar"></div>
			<div class="table">
<?php if($notice) echo $notice; ?>
				<form id="editconfig" name="editconfig" method="post" action="">
				<input type="hidden" name="action" value="edit"/>
				<table>
					<tr>
						<td width="100">Thẻ 10.000 VNĐ : </td>
						<td>Tắt <input name="use_card10k" type="radio" value="0" <?php if($use_card10k==0) echo "checked='checked'"; ?>/> 
						Bật <input name="use_card10k" type="radio" value="1" <?php if($use_card10k==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td>Thẻ 20.000 VNĐ : </td>
						<td>Tắt <input name="use_card20k" type="radio" value="0" <?php if($use_card20k==0) echo "checked='checked'"; ?>/> 
						Bật <input name="use_card20k" type="radio" value="1" <?php if($use_card20k==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td>Thẻ 30.000 VNĐ : </td>
						<td>Tắt <input name="use_card30k" type="radio" value="0" <?php if($use_card30k==0) echo "checked='checked'"; ?>/> 
						Bật <input name="use_card30k" type="radio" value="1" <?php if($use_card30k==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td>Thẻ 50.000 VNĐ : </td>
						<td>Tắt <input name="use_card50k" type="radio" value="0" <?php if($use_card50k==0) echo "checked='checked'"; ?>/> 
						Bật <input name="use_card50k" type="radio" value="1" <?php if($use_card50k==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td>Thẻ 100.000 VNĐ : </td>
						<td>Tắt <input name="use_card100k" type="radio" value="0" <?php if($use_card100k==0) echo "checked='checked'"; ?>/> 
						Bật <input name="use_card100k" type="radio" value="1" <?php if($use_card100k==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td>Thẻ 200.000 VNĐ : </td>
						<td>Tắt <input name="use_card200k" type="radio" value="0" <?php if($use_card200k==0) echo "checked='checked'"; ?>/> 
						Bật <input name="use_card200k" type="radio" value="1" <?php if($use_card200k==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td>Thẻ 300.000 VNĐ : </td>
						<td>Tắt <input name="use_card300k" type="radio" value="0" <?php if($use_card300k==0) echo "checked='checked'"; ?>/> 
						Bật <input name="use_card300k" type="radio" value="1" <?php if($use_card300k==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td>Thẻ 500.000 VNĐ : </td>
						<td>Tắt <input name="use_card500k" type="radio" value="0" <?php if($use_card500k==0) echo "checked='checked'"; ?>/> 
						Bật <input name="use_card500k" type="radio" value="1" <?php if($use_card500k==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					<tr>
						<td>Thẻ 10.000 VNĐ : </td>
						<td><div style="float: left;"><input type="text" name="menhgia10000" value="<?php echo $menhgia10000; ?>" size="10"/></div> Vpoint</td>
					</tr>
					<tr>
						<td>Thẻ 20.000 VNĐ : </td>
						<td><div style="float: left;"><input type="text" name="menhgia20000" value="<?php echo $menhgia20000; ?>" size="10"/></div> Vpoint</td>
					</tr>
					<tr>
						<td>Thẻ 30.000 VNĐ : </td>
						<td><div style="float: left;"><input type="text" name="menhgia30000" value="<?php echo $menhgia30000; ?>" size="10"/></div> Vpoint</td>
					</tr>
					<tr>
						<td>Thẻ 50.000 VNĐ : </td>
						<td><div style="float: left;"><input type="text" name="menhgia50000" value="<?php echo $menhgia50000; ?>" size="10"/></div> Vpoint</td>
					</tr>
					<tr>
						<td>Thẻ 100.000 VNĐ : </td>
						<td><div style="float: left;"><input type="text" name="menhgia100000" value="<?php echo $menhgia100000; ?>" size="10"/></div> Vpoint</td>
					</tr>
					<tr>
						<td>Thẻ 200.000 VNĐ : </td>
						<td><div style="float: left;"><input type="text" name="menhgia200000" value="<?php echo $menhgia200000; ?>" size="10"/></div> Vpoint</td>
					</tr>
					<tr>
						<td>Thẻ 300.000 VNĐ : </td>
						<td><div style="float: left;"><input type="text" name="menhgia300000" value="<?php echo $menhgia300000; ?>" size="10"/></div> Vpoint</td>
					</tr>
					<tr>
						<td>Thẻ 500.000 VNĐ : </td>
						<td><div style="float: left;"><input type="text" name="menhgia500000" value="<?php echo $menhgia500000; ?>" size="10"/></div> Vpoint</td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					
					<tr>
						<td>&nbsp;</td>
						<td align="center"><input type="submit" name="Submit" value="Sửa" <?php if($accept=='0') { ?> disabled="disabled" <?php } ?> /></td>
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
	  
