<?php
$file_edit = 'config/config_napthe.php';
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
	
	$use_napcard_vtc = $_POST['use_napcard_vtc'];		$content .= "\$use_napcard_vtc	= $use_napcard_vtc;\n";
	$use_napcard_gate = $_POST['use_napcard_gate'];		$content .= "\$use_napcard_gate	= $use_napcard_gate;\n";
	$use_napcard_viettel = $_POST['use_napcard_viettel'];		$content .= "\$use_napcard_viettel	= $use_napcard_viettel;\n";
	$use_napcard_mobi = $_POST['use_napcard_mobi'];		$content .= "\$use_napcard_mobi	= $use_napcard_mobi;\n";
	$use_napcard_vina = $_POST['use_napcard_vina'];		$content .= "\$use_napcard_vina	= $use_napcard_vina;\n";
	
		//Khống chế số lần nạp Card trong ngày
	$reset_1 = $_POST['reset_1'];				$content .= "\$reset_1	= $reset_1;\n";
	$slg_card_1 = $_POST['slg_card_1'];			$content .= "\$slg_card_1	= $slg_card_1;\n";
	
	$reset_2 = $_POST['reset_2'];				$content .= "\$reset_2	= $reset_2;\n";
	$slg_card_2 = $_POST['slg_card_2'];			$content .= "\$slg_card_2	= $slg_card_2;\n";
	
	$reset_3 = $_POST['reset_3'];				$content .= "\$reset_3	= $reset_3;\n";
	$slg_card_3 = $_POST['slg_card_3'];			$content .= "\$slg_card_3	= $slg_card_3;\n";
	
	$reset_4 = $_POST['reset_4'];				$content .= "\$reset_4	= $reset_4;\n";
	$slg_card_4 = $_POST['slg_card_4'];			$content .= "\$slg_card_4	= $slg_card_4;\n";
	
	$slg_card_max = $_POST['slg_card_max'];		$content .= "\$slg_card_max	= $slg_card_max;\n";
		//Khuyến mại nạp V.Point
	$khuyenmai = $_POST['khuyenmai'];			$content .= "\$khuyenmai	= $khuyenmai;\n";
	$khuyenmai_phantram = $_POST['khuyenmai_phantram'];	$content .= "\$khuyenmai_phantram	= $khuyenmai_phantram;\n";
	
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
						<td width="100">Thẻ VTC : </td>
						<td>Tắt <input name="use_napcard_vtc" type="radio" value="0" <?php if($use_napcard_vtc==0) echo "checked='checked'"; ?>/> 
						Bật <input name="use_napcard_vtc" type="radio" value="1" <?php if($use_napcard_vtc==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td width="100">Thẻ Gate : </td>
						<td>Tắt <input name="use_napcard_gate" type="radio" value="0" <?php if($use_napcard_gate==0) echo "checked='checked'"; ?>/> 
						Bật <input name="use_napcard_gate" type="radio" value="1" <?php if($use_napcard_gate==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td>Thẻ Viettel : </td>
						<td>Tắt <input name="use_napcard_viettel" type="radio" value="0" <?php if($use_napcard_viettel==0) echo "checked='checked'"; ?>/> 
						Bật <input name="use_napcard_viettel" type="radio" value="1" <?php if($use_napcard_viettel==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td>Thẻ Mobi : </td>
						<td>Tắt <input name="use_napcard_mobi" type="radio" value="0" <?php if($use_napcard_mobi==0) echo "checked='checked'"; ?>/> 
						Bật <input name="use_napcard_mobi" type="radio" value="1" <?php if($use_napcard_mobi==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td>Thẻ Vina : </td>
						<td>Tắt <input name="use_napcard_vina" type="radio" value="0" <?php if($use_napcard_vina==0) echo "checked='checked'"; ?>/> 
						Bật <input name="use_napcard_vina" type="radio" value="1" <?php if($use_napcard_vina==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					
					<tr><td colspan="2"><b>Khống chế số lần nạp thẻ trong ngày</b><br>
					- Reset < <input type="text" name="reset_1" value="<?php echo $reset_1; ?>" size="3"/> được Nạp tối đa <input type="text" name="slg_card_1" value="<?php echo $slg_card_1; ?>" size="3"/> thẻ / ngày<br>
					- Reset < <input type="text" name="reset_2" value="<?php echo $reset_2; ?>" size="3"/> được Nạp tối đa <input type="text" name="slg_card_2" value="<?php echo $slg_card_2; ?>" size="3"/> thẻ / ngày<br>
					- Reset < <input type="text" name="reset_3" value="<?php echo $reset_3; ?>" size="3"/> được Nạp tối đa <input type="text" name="slg_card_3" value="<?php echo $slg_card_3; ?>" size="3"/> thẻ / ngày<br>
					- Reset < <input type="text" name="reset_4" value="<?php echo $reset_4; ?>" size="3"/> được Nạp tối đa <input type="text" name="slg_card_4" value="<?php echo $slg_card_4; ?>" size="3"/> thẻ / ngày<br>
					- Số thẻ nạp Tối đa : <input type="text" name="slg_card_max" value="<?php echo $slg_card_max; ?>" size="3"/> thẻ / ngày<br>
					<br>
					
					<b>Khuyến mại nạp Vpoint : </b>
					Tắt <input name="khuyenmai" type="radio" value="0" <?php if($khuyenmai==0) echo "checked='checked'"; ?>/> 
					Bật <input name="khuyenmai" type="radio" value="1" <?php if($khuyenmai==1) echo "checked='checked'"; ?>/>
					<br>
					Tỷ lệ khuyến mại : <input type="text" name="khuyenmai_phantram" value="<?php echo $khuyenmai_phantram; ?>" size="3"/> %
						
					</td></tr>
					
					
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
	  
