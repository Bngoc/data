<?php
function addcontent($filename,$content)
{
	$fp = fopen($filename, "a+");  
	fputs ($fp, "$content");  
	fclose($fp);
}

function replacecontent($filename,$content)
{
	$fp = fopen($filename, "w");  
	fputs ($fp, "$content");  
	fclose($fp);
}

function readcontent($filename)
{
	$fp = fopen($filename, "r");
	while (!feof($fp)) {
		$line[] = fgets($fp,1000);
	}
	fclose($fp);
	return $line;
}

function shop_load($filename)
{
	$stt = 0;
	if(is_file($filename)) {
		$fopen_host = fopen($filename, "r");
		
		while (!feof($fopen_host)) {
			$get_item = fgets($fopen_host,200);
			$get_item = preg_replace('(\n)', '', $get_item);
			if($get_item) {
				$item_info = explode('|', $get_item);
				
				$check_stat = substr($get_item,0,2);
				if($check_stat == '//') $stat = 0;
				else $stat = 1;
				
				$stt++;
				
				$item_read[] = array (
					'stt'	=> $stt,
					'code'	=> $item_info[0],
					'name'	=> $item_info[1],
					'price'	=> $item_info[2],
					'img'	=> $item_info[3],
					'stat'	=> $stat
				);
			}
		}
	} else $fopen_host = fopen($filename, "w");
	fclose($fopen_host);
	return $item_read;
}

function display_shop($item_read,$act)
{
	$stt = count($item_read);
	
	$content = "<table width='100%' border='0' cellpadding='3' cellspacing='1' bgcolor='#9999FF'>
		<tr bgcolor='#FFFFFF' >
			<td align='center'>#</td>
			<td align='center'>Đồ vật</td>
			<td align='center'>Giá <br />
		    (V.Point)</td>
		    <td align='center'>Hình</td>
		    <td align='center' width='50'>&nbsp;</td>
		</tr>";
	for($i=0;$i<$stt;$i++) {
		$content .= "<tr bgcolor='#FFFFFF' >
			<td align='center'>".$item_read[$i][stt]."</td>
			<td align='center'>".$item_read[$i][name]."</td>
			<td align='center'>".number_format($item_read[$i][price], 0, ',', '.')."</td>
			<td align='center'><img src='images/".$act."/".$item_read[$i][img]."'></td>
			<td align='center'><a href='admin.php?mod=editwebshop&act=".$act."&page=edit&item=".$item_read[$i][stt]."' target='_self'>Sửa</a> / <a href='admin.php?mod=editwebshop&act=".$act."&page=del&item=".$item_read[$i][stt]."' target='_self'>Xóa</a></td>
		</tr>";
	}
	$content .= "</table>";
	
	echo $content;
}
?>