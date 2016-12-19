<?php
$file_edit = 'config/config_reset.php';
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
	
	$cap_reset_max = $_POST['cap_reset_max'];		$content .= "\$cap_reset_max	= $cap_reset_max;\n";
	$log_reset	=	$_POST['log_reset'];		$content .= "\$log_reset	= $log_reset;\n";

	$reset_cap_0 = 0;		$content .= "\$reset_cap_0	= $reset_cap_0;\n";
//Reset từ cấp 0 tới Cấp 1
$reset_cap_1 = $_POST['reset_cap_1'];		$content .= "\$reset_cap_1	= $reset_cap_1;\n\t";
	$level_cap_1 = $_POST['level_cap_1'];		$content .= "\$level_cap_1	= $level_cap_1;\t";
	$zen_cap_1 = $_POST['zen_cap_1'];		$content .= "\$zen_cap_1	= $zen_cap_1;\t";
	$time_reset_next_1 = $_POST['time_reset_next_1'];		$content .= "\$time_reset_next_1	= $time_reset_next_1;\n\t";
	$chao_cap_1 = $_POST['chao_cap_1'];		$content .= "\$chao_cap_1	= $chao_cap_1;\t";
	$cre_cap_1 = $_POST['cre_cap_1'];		$content .= "\$cre_cap_1	= $cre_cap_1;\t";
	$blue_cap_1 = $_POST['blue_cap_1'];		$content .= "\$blue_cap_1	= $blue_cap_1;\n\t";
	$point_cap_1 = $_POST['point_cap_1'];		$content .= "\$point_cap_1	= $point_cap_1;\t";
	$ml_cap_1 = $_POST['ml_cap_1'];		$content .= "\$ml_cap_1	= $ml_cap_1;\n";
//Reset từ lần Cấp 1 tới Cấp 2
$reset_cap_2 = $_POST['reset_cap_2'];		$content .= "\$reset_cap_2	= $reset_cap_2;\n\t";
	$level_cap_2 = $_POST['level_cap_2'];		$content .= "\$level_cap_2	= $level_cap_2;\t";	
	$zen_cap_2 = $_POST['zen_cap_2'];		$content .= "\$zen_cap_2	= $zen_cap_2;\t";
	$time_reset_next_2 = $_POST['time_reset_next_2'];		$content .= "\$time_reset_next_2	= $time_reset_next_2;\n\t";
	$chao_cap_2 = $_POST['chao_cap_2'];		$content .= "\$chao_cap_2	= $chao_cap_2;\t";
	$cre_cap_2 = $_POST['cre_cap_2'];		$content .= "\$cre_cap_2	= $cre_cap_2;\t";
	$blue_cap_2 = $_POST['blue_cap_2'];		$content .= "\$blue_cap_2	= $blue_cap_2;\n\t";
	$point_cap_2 = $_POST['point_cap_2'];		$content .= "\$point_cap_2	= $point_cap_2;\t";
	$ml_cap_2 = $_POST['ml_cap_2'];		$content .= "\$ml_cap_2	= $ml_cap_2;\n";
//Reset từ lần Cấp 2 tới Cấp 3
$reset_cap_3 = $_POST['reset_cap_3'];		$content .= "\$reset_cap_3	= $reset_cap_3;\n\t";
	$level_cap_3 = $_POST['level_cap_3'];		$content .= "\$level_cap_3	= $level_cap_3;\t";
	$zen_cap_3 = $_POST['zen_cap_3'];		$content .= "\$zen_cap_3	= $zen_cap_3;\t";
	$time_reset_next_3 = $_POST['time_reset_next_3'];		$content .= "\$time_reset_next_3	= $time_reset_next_3;\n\t";
	$chao_cap_3 = $_POST['chao_cap_3'];		$content .= "\$chao_cap_3	= $chao_cap_3;\t";
	$cre_cap_3 = $_POST['cre_cap_3'];		$content .= "\$cre_cap_3	= $cre_cap_3;\t";
	$blue_cap_3 = $_POST['blue_cap_3'];		$content .= "\$blue_cap_3	= $blue_cap_3;\n\t";
	$point_cap_3 = $_POST['point_cap_3'];		$content .= "\$point_cap_3	= $point_cap_3;\t";
	$ml_cap_3 = $_POST['ml_cap_3'];		$content .= "\$ml_cap_3	= $ml_cap_3;\n";
//Reset từ lần Cấp 3 tới Cấp 4
$reset_cap_4 = $_POST['reset_cap_4'];		$content .= "\$reset_cap_4	= $reset_cap_4;\n\t";
	$level_cap_4 = $_POST['level_cap_4'];		$content .= "\$level_cap_4	= $level_cap_4;\t";
	$zen_cap_4 = $_POST['zen_cap_4'];		$content .= "\$zen_cap_4	= $zen_cap_4;\t";
	$time_reset_next_4 = $_POST['time_reset_next_4'];		$content .= "\$time_reset_next_4	= $time_reset_next_4;\n\t";
	$chao_cap_4 = $_POST['chao_cap_4'];		$content .= "\$chao_cap_4	= $chao_cap_4;\t";
	$cre_cap_4 = $_POST['cre_cap_4'];		$content .= "\$cre_cap_4	= $cre_cap_4;\t";
	$blue_cap_4 = $_POST['blue_cap_4'];		$content .= "\$blue_cap_4	= $blue_cap_4;\n\t";
	$point_cap_4 = $_POST['point_cap_4'];		$content .= "\$point_cap_4	= $point_cap_4;\t";
	$ml_cap_4 = $_POST['ml_cap_4'];		$content .= "\$ml_cap_4	= $ml_cap_4;\n";
//Reset từ lần Cấp 4 tới Cấp 5
$reset_cap_5 = $_POST['reset_cap_5'];		$content .= "\$reset_cap_5	= $reset_cap_5;\n\t";
	$level_cap_5 = $_POST['level_cap_5'];		$content .= "\$level_cap_5	= $level_cap_5;\t";
	$zen_cap_5 = $_POST['zen_cap_5'];		$content .= "\$zen_cap_5	= $zen_cap_5;\t";
	$time_reset_next_5 = $_POST['time_reset_next_5'];		$content .= "\$time_reset_next_5	= $time_reset_next_5;\n\t";
	$chao_cap_5 = $_POST['chao_cap_5'];		$content .= "\$chao_cap_5	= $chao_cap_5;\t";
	$cre_cap_5 = $_POST['cre_cap_5'];		$content .= "\$cre_cap_5	= $cre_cap_5;\t";
	$blue_cap_5 = $_POST['blue_cap_5'];		$content .= "\$blue_cap_5	= $blue_cap_5;\n\t";
	$point_cap_5 = $_POST['point_cap_5'];		$content .= "\$point_cap_5	= $point_cap_5;\t";
	$ml_cap_5 = $_POST['ml_cap_5'];		$content .= "\$ml_cap_5	= $ml_cap_5;\n";
//Reset từ lần Cấp 5 tới Cấp 6
$reset_cap_6 = $_POST['reset_cap_6'];		$content .= "\$reset_cap_6	= $reset_cap_6;\n\t";
	$level_cap_6 = $_POST['level_cap_6'];		$content .= "\$level_cap_6	= $level_cap_6;\t";
	$zen_cap_6 = $_POST['zen_cap_6'];		$content .= "\$zen_cap_6	= $zen_cap_6;\t";
	$time_reset_next_6 = $_POST['time_reset_next_6'];		$content .= "\$time_reset_next_6	= $time_reset_next_6;\n\t";
	$chao_cap_6 = $_POST['chao_cap_6'];		$content .= "\$chao_cap_6	= $chao_cap_6;\t";
	$cre_cap_6 = $_POST['cre_cap_6'];		$content .= "\$cre_cap_6	= $cre_cap_6;\t";
	$blue_cap_6 = $_POST['blue_cap_6'];		$content .= "\$blue_cap_6	= $blue_cap_6;\n\t";
	$point_cap_6 = $_POST['point_cap_6'];		$content .= "\$point_cap_6	= $point_cap_6;\t";
	$ml_cap_6 = $_POST['ml_cap_6'];		$content .= "\$ml_cap_6	= $ml_cap_6;\n";
//Reset từ lần Cấp 6 tới Cấp 7
$reset_cap_7 = $_POST['reset_cap_7'];		$content .= "\$reset_cap_7	= $reset_cap_7;\n\t";
	$level_cap_7 = $_POST['level_cap_7'];		$content .= "\$level_cap_7	= $level_cap_7;\t";
	$zen_cap_7 = $_POST['zen_cap_7'];		$content .= "\$zen_cap_7	= $zen_cap_7;\t";
	$time_reset_next_7 = $_POST['time_reset_next_7'];		$content .= "\$time_reset_next_7	= $time_reset_next_7;\n\t";
	$chao_cap_7 = $_POST['chao_cap_7'];		$content .= "\$chao_cap_7	= $chao_cap_7;\t";
	$cre_cap_7 = $_POST['cre_cap_7'];		$content .= "\$cre_cap_7	= $cre_cap_7;\t";
	$blue_cap_7 = $_POST['blue_cap_7'];		$content .= "\$blue_cap_7	= $blue_cap_7;\n\t";
	$point_cap_7 = $_POST['point_cap_7'];		$content .= "\$point_cap_7	= $point_cap_7;\t";
	$ml_cap_7 = $_POST['ml_cap_7'];		$content .= "\$ml_cap_7	= $ml_cap_7;\n";
//Reset từ lần Cấp 7 tới Cấp 8
$reset_cap_8 = $_POST['reset_cap_8'];		$content .= "\$reset_cap_8	= $reset_cap_8;\n\t";
	$level_cap_8 = $_POST['level_cap_8'];		$content .= "\$level_cap_8	= $level_cap_8;\t";
	$zen_cap_8 = $_POST['zen_cap_8'];		$content .= "\$zen_cap_8	= $zen_cap_8;\t";
	$time_reset_next_8 = $_POST['time_reset_next_8'];		$content .= "\$time_reset_next_8	= $time_reset_next_8;\n\t";
	$chao_cap_8 = $_POST['chao_cap_8'];		$content .= "\$chao_cap_8	= $chao_cap_8;\t";
	$cre_cap_8 = $_POST['cre_cap_8'];		$content .= "\$cre_cap_8	= $cre_cap_8;\t";
	$blue_cap_8 = $_POST['blue_cap_8'];		$content .= "\$blue_cap_8	= $blue_cap_8;\n\t";
	$point_cap_8 = $_POST['point_cap_8'];		$content .= "\$point_cap_8	= $point_cap_8;\t";
	$ml_cap_8 = $_POST['ml_cap_8'];		$content .= "\$ml_cap_8	= $ml_cap_8;\n";
//Reset từ lần Cấp 8 tới Cấp 9
$reset_cap_9 = $_POST['reset_cap_9'];		$content .= "\$reset_cap_9	= $reset_cap_9;\n\t";
	$level_cap_9 = $_POST['level_cap_9'];		$content .= "\$level_cap_9	= $level_cap_9;\t";
	$zen_cap_9 = $_POST['zen_cap_9'];		$content .= "\$zen_cap_9	= $zen_cap_9;\t";
	$time_reset_next_9 = $_POST['time_reset_next_9'];		$content .= "\$time_reset_next_9	= $time_reset_next_9;\n\t";
	$chao_cap_9 = $_POST['chao_cap_9'];		$content .= "\$chao_cap_9	= $chao_cap_9;\t";
	$cre_cap_9 = $_POST['cre_cap_9'];		$content .= "\$cre_cap_9	= $cre_cap_9;\t";
	$blue_cap_9 = $_POST['blue_cap_9'];		$content .= "\$blue_cap_9	= $blue_cap_9;\n\t";
	$point_cap_9 = $_POST['point_cap_9'];		$content .= "\$point_cap_9	= $point_cap_9;\t";
	$ml_cap_9 = $_POST['ml_cap_9'];		$content .= "\$ml_cap_9	= $ml_cap_9;\n";
//Reset từ lần Cấp 9 tới Cấp 10
$reset_cap_10 = $_POST['reset_cap_10'];		$content .= "\$reset_cap_10	= $reset_cap_10;\n\t";
	$level_cap_10 = $_POST['level_cap_10'];		$content .= "\$level_cap_10	= $level_cap_10;\t";
	$zen_cap_10 = $_POST['zen_cap_10'];		$content .= "\$zen_cap_10	= $zen_cap_10;\t";
	$time_reset_next_10 = $_POST['time_reset_next_10'];		$content .= "\$time_reset_next_10	= $time_reset_next_10;\n\t";
	$chao_cap_10 = $_POST['chao_cap_10'];		$content .= "\$chao_cap_10	= $chao_cap_10;\t";
	$cre_cap_10 = $_POST['cre_cap_10'];		$content .= "\$cre_cap_10	= $cre_cap_10;\t";
	$blue_cap_10 = $_POST['blue_cap_10'];		$content .= "\$blue_cap_10	= $blue_cap_10;\n\t";
	$point_cap_10 = $_POST['point_cap_10'];		$content .= "\$point_cap_10	= $point_cap_10;\t";
	$ml_cap_10 = $_POST['ml_cap_10'];		$content .= "\$ml_cap_10	= $ml_cap_10;\n";
//Reset từ lần Cấp 10 tới Cấp 11
$reset_cap_11 = $_POST['reset_cap_11'];		$content .= "\$reset_cap_11	= $reset_cap_11;\n\t";
	$level_cap_11 = $_POST['level_cap_11'];		$content .= "\$level_cap_11	= $level_cap_11;\t";
	$zen_cap_11 = $_POST['zen_cap_11'];		$content .= "\$zen_cap_11	= $zen_cap_11;\t";
	$time_reset_next_11 = $_POST['time_reset_next_11'];		$content .= "\$time_reset_next_11	= $time_reset_next_11;\n\t";
	$chao_cap_11 = $_POST['chao_cap_11'];		$content .= "\$chao_cap_11	= $chao_cap_11;\t";
	$cre_cap_11 = $_POST['cre_cap_11'];		$content .= "\$cre_cap_11	= $cre_cap_11;\t";
	$blue_cap_11 = $_POST['blue_cap_11'];		$content .= "\$blue_cap_11	= $blue_cap_11;\n\t";
	$point_cap_11 = $_POST['point_cap_11'];		$content .= "\$point_cap_11	= $point_cap_11;\t";
	$ml_cap_11 = $_POST['ml_cap_11'];		$content .= "\$ml_cap_11	= $ml_cap_11;\n";
//Reset từ lần Cấp 11 tới Cấp 12
$reset_cap_12 = $_POST['reset_cap_12'];		$content .= "\$reset_cap_12	= $reset_cap_12;\n\t";
	$level_cap_12 = $_POST['level_cap_12'];		$content .= "\$level_cap_12	= $level_cap_12;\t";
	$zen_cap_12 = $_POST['zen_cap_12'];		$content .= "\$zen_cap_12	= $zen_cap_12;\t";
	$time_reset_next_12 = $_POST['time_reset_next_12'];		$content .= "\$time_reset_next_12	= $time_reset_next_12;\n\t";
	$chao_cap_12 = $_POST['chao_cap_12'];		$content .= "\$chao_cap_12	= $chao_cap_12;\t";
	$cre_cap_12 = $_POST['cre_cap_12'];		$content .= "\$cre_cap_12	= $cre_cap_12;\t";
	$blue_cap_12 = $_POST['blue_cap_12'];		$content .= "\$blue_cap_12	= $blue_cap_12;\n\t";
	$point_cap_12 = $_POST['point_cap_12'];		$content .= "\$point_cap_12	= $point_cap_12;\t";
	$ml_cap_12 = $_POST['ml_cap_12'];		$content .= "\$ml_cap_12	= $ml_cap_12;\n";
//Reset từ lần Cấp 12 tới Cấp 13
$reset_cap_13 = $_POST['reset_cap_13'];		$content .= "\$reset_cap_13	= $reset_cap_13;\n\t";
	$level_cap_13 = $_POST['level_cap_13'];		$content .= "\$level_cap_13	= $level_cap_13;\t";
	$zen_cap_13 = $_POST['zen_cap_13'];		$content .= "\$zen_cap_13	= $zen_cap_13;\t";
	$time_reset_next_13 = $_POST['time_reset_next_13'];		$content .= "\$time_reset_next_13	= $time_reset_next_13;\n\t";
	$chao_cap_13 = $_POST['chao_cap_13'];		$content .= "\$chao_cap_13	= $chao_cap_13;\t";
	$cre_cap_13 = $_POST['cre_cap_13'];		$content .= "\$cre_cap_13	= $cre_cap_13;\t";
	$blue_cap_13 = $_POST['blue_cap_13'];		$content .= "\$blue_cap_13	= $blue_cap_13;\n\t";
	$point_cap_13 = $_POST['point_cap_13'];		$content .= "\$point_cap_13	= $point_cap_13;\t";
	$ml_cap_13 = $_POST['ml_cap_13'];		$content .= "\$ml_cap_13	= $ml_cap_13;\n";
//Reset từ lần Cấp 13 tới Cấp 14
$reset_cap_14 = $_POST['reset_cap_14'];		$content .= "\$reset_cap_14	= $reset_cap_14;\n\t";
	$level_cap_14 = $_POST['level_cap_14'];		$content .= "\$level_cap_14	= $level_cap_14;\t";
	$zen_cap_14 = $_POST['zen_cap_14'];		$content .= "\$zen_cap_14	= $zen_cap_14;\t";
	$time_reset_next_14 = $_POST['time_reset_next_14'];		$content .= "\$time_reset_next_14	= $time_reset_next_14;\n\t";
	$chao_cap_14 = $_POST['chao_cap_14'];		$content .= "\$chao_cap_14	= $chao_cap_14;\t";
	$cre_cap_14 = $_POST['cre_cap_14'];		$content .= "\$cre_cap_14	= $cre_cap_14;\t";
	$blue_cap_14 = $_POST['blue_cap_14'];		$content .= "\$blue_cap_14	= $blue_cap_14;\n\t";
	$point_cap_14 = $_POST['point_cap_14'];		$content .= "\$point_cap_14	= $point_cap_14;\t";
	$ml_cap_14 = $_POST['ml_cap_14'];		$content .= "\$ml_cap_14	= $ml_cap_14;\n";
//Reset từ lần Cấp 14 tới Cấp 15
$reset_cap_15 = $_POST['reset_cap_15'];		$content .= "\$reset_cap_15	= $reset_cap_15;\n\t";
	$level_cap_15 = $_POST['level_cap_15'];		$content .= "\$level_cap_15	= $level_cap_15;\t";
	$zen_cap_15 = $_POST['zen_cap_15'];		$content .= "\$zen_cap_15	= $zen_cap_15;\t";
	$time_reset_next_15 = $_POST['time_reset_next_15'];		$content .= "\$time_reset_next_15	= $time_reset_next_15;\n\t";
	$chao_cap_15 = $_POST['chao_cap_15'];		$content .= "\$chao_cap_15	= $chao_cap_15;\t";
	$cre_cap_15 = $_POST['cre_cap_15'];		$content .= "\$cre_cap_15	= $cre_cap_15;\t";
	$blue_cap_15 = $_POST['blue_cap_15'];		$content .= "\$blue_cap_15	= $blue_cap_15;\n\t";
	$point_cap_15 = $_POST['point_cap_15'];		$content .= "\$point_cap_15	= $point_cap_15;\t";
	$ml_cap_15 = $_POST['ml_cap_15'];		$content .= "\$ml_cap_15	= $ml_cap_15;\n";
//Reset từ lần Cấp 15 tới Cấp 16
$reset_cap_16 = $_POST['reset_cap_16'];		$content .= "\$reset_cap_16	= $reset_cap_16;\n\t";
	$level_cap_16 = $_POST['level_cap_16'];		$content .= "\$level_cap_16	= $level_cap_16;\t";
	$zen_cap_16 = $_POST['zen_cap_16'];		$content .= "\$zen_cap_16	= $zen_cap_16;\t";
	$time_reset_next_16 = $_POST['time_reset_next_16'];		$content .= "\$time_reset_next_16	= $time_reset_next_16;\n\t";
	$chao_cap_16 = $_POST['chao_cap_16'];		$content .= "\$chao_cap_16	= $chao_cap_16;\t";
	$cre_cap_16 = $_POST['cre_cap_16'];		$content .= "\$cre_cap_16	= $cre_cap_16;\t";
	$blue_cap_16 = $_POST['blue_cap_16'];		$content .= "\$blue_cap_16	= $blue_cap_16;\n\t";
	$point_cap_16 = $_POST['point_cap_16'];		$content .= "\$point_cap_16	= $point_cap_16;\t";
	$ml_cap_16 = $_POST['ml_cap_16'];		$content .= "\$ml_cap_16	= $ml_cap_16;\n";
//Reset từ lần Cấp 16 tới Cấp 17
$reset_cap_17 = $_POST['reset_cap_17'];		$content .= "\$reset_cap_17	= $reset_cap_17;\n\t";
	$level_cap_17 = $_POST['level_cap_17'];		$content .= "\$level_cap_17	= $level_cap_17;\t";
	$zen_cap_17 = $_POST['zen_cap_17'];		$content .= "\$zen_cap_17	= $zen_cap_17;\t";
	$time_reset_next_17 = $_POST['time_reset_next_17'];		$content .= "\$time_reset_next_17	= $time_reset_next_17;\n\t";
	$chao_cap_17 = $_POST['chao_cap_17'];		$content .= "\$chao_cap_17	= $chao_cap_17;\t";
	$cre_cap_17 = $_POST['cre_cap_17'];		$content .= "\$cre_cap_17	= $cre_cap_17;\t";
	$blue_cap_17 = $_POST['blue_cap_17'];		$content .= "\$blue_cap_17	= $blue_cap_17;\n\t";
	$point_cap_17 = $_POST['point_cap_17'];		$content .= "\$point_cap_17	= $point_cap_17;\t";
	$ml_cap_17 = $_POST['ml_cap_17'];		$content .= "\$ml_cap_17	= $ml_cap_17;\n";
//Reset từ lần Cấp 17 tới Cấp 18
$reset_cap_18 = $_POST['reset_cap_18'];		$content .= "\$reset_cap_18	= $reset_cap_18;\n\t";
	$level_cap_18 = $_POST['level_cap_18'];		$content .= "\$level_cap_18	= $level_cap_18;\t";
	$zen_cap_18 = $_POST['zen_cap_18'];		$content .= "\$zen_cap_18	= $zen_cap_18;\t";
	$time_reset_next_18 = $_POST['time_reset_next_18'];		$content .= "\$time_reset_next_18	= $time_reset_next_18;\n\t";
	$chao_cap_18 = $_POST['chao_cap_18'];		$content .= "\$chao_cap_18	= $chao_cap_18;\t";
	$cre_cap_18 = $_POST['cre_cap_18'];		$content .= "\$cre_cap_18	= $cre_cap_18;\t";
	$blue_cap_18 = $_POST['blue_cap_18'];		$content .= "\$blue_cap_18	= $blue_cap_18;\n\t";
	$point_cap_18 = $_POST['point_cap_18'];		$content .= "\$point_cap_18	= $point_cap_18;\t";
	$ml_cap_18 = $_POST['ml_cap_18'];		$content .= "\$ml_cap_18	= $ml_cap_18;\n";
//Reset từ lần Cấp 18 tới Cấp 19
$reset_cap_19 = $_POST['reset_cap_19'];		$content .= "\$reset_cap_19	= $reset_cap_19;\n\t";
	$level_cap_19 = $_POST['level_cap_19'];		$content .= "\$level_cap_19	= $level_cap_19;\t";
	$zen_cap_19 = $_POST['zen_cap_19'];		$content .= "\$zen_cap_19	= $zen_cap_19;\t";
	$time_reset_next_19 = $_POST['time_reset_next_19'];		$content .= "\$time_reset_next_19	= $time_reset_next_19;\n\t";
	$chao_cap_19 = $_POST['chao_cap_19'];		$content .= "\$chao_cap_19	= $chao_cap_19;\t";
	$cre_cap_19 = $_POST['cre_cap_19'];		$content .= "\$cre_cap_19	= $cre_cap_19;\t";
	$blue_cap_19 = $_POST['blue_cap_19'];		$content .= "\$blue_cap_19	= $blue_cap_19;\n\t";
	$point_cap_19 = $_POST['point_cap_19'];		$content .= "\$point_cap_19	= $point_cap_19;\t";
	$ml_cap_19 = $_POST['ml_cap_19'];		$content .= "\$ml_cap_19	= $ml_cap_19;\n";
//Reset từ lần Cấp 19 tới Cấp 20
$reset_cap_20 = $_POST['reset_cap_20'];		$content .= "\$reset_cap_20	= $reset_cap_20;\n\t";
	$level_cap_20 = $_POST['level_cap_20'];		$content .= "\$level_cap_20	= $level_cap_20;\t";
	$zen_cap_20 = $_POST['zen_cap_20'];		$content .= "\$zen_cap_20	= $zen_cap_20;\t";
	$time_reset_next_20 = $_POST['time_reset_next_20'];		$content .= "\$time_reset_next_20	= $time_reset_next_20;\n\t";
	$chao_cap_20 = $_POST['chao_cap_20'];		$content .= "\$chao_cap_20	= $chao_cap_20;\t";
	$cre_cap_20 = $_POST['cre_cap_20'];		$content .= "\$cre_cap_20	= $cre_cap_20;\t";
	$blue_cap_20 = $_POST['blue_cap_20'];		$content .= "\$blue_cap_20	= $blue_cap_20;\n\t";
	$point_cap_20 = $_POST['point_cap_20'];		$content .= "\$point_cap_20	= $point_cap_20;\t";
	$ml_cap_20 = $_POST['ml_cap_20'];		$content .= "\$ml_cap_20	= $ml_cap_20;\n";
	
	$content .= "?>";
	
	require_once('admin/function.php');
	replacecontent($file_edit,$content);
	if (!$usehost) replacecontent($file_edit_sv,$content);
	
	$notice = "<center><font color='red'>Sửa thành công</font></center>";
}

include($file_edit);
?>


		<div id="center-column">
			<div class="top-bar">
				<h1>Cấu Hình Reset</h1>
			</div><br>
			Tập tin <?php echo "<b>".$file_edit."</b> : ".$can_write; ?><?php if (!$usehost) {?><br>
			Tập tin <?php echo "<b>".$file_edit_sv."</b> : ".$can_write_sv; ?><?php }?>
		  <div class="select-bar"></div>
			<div class="table">
<?php if($notice) echo $notice; ?>
				<form id="editconfig" name="editconfig" method="post" action="">
				<input type="hidden" name="action" value="edit"/>
				Số cấp Reset hiển thị dành cho người chơi : <input type="text" name="cap_reset_max" value="<?php echo $cap_reset_max; ?>" size="2"/><br>
				Số cấp Reset nhỏ nhất để ghi Log (Reset lớn hơn sẽ được ghi vào Log) : <input type="text" name="log_reset" value="<?php echo $log_reset; ?>" size="2"/><br><br>
				<i><b>Time</b>: Là khoảng thời gian được phép thực hiện lần Reset tiếp theo (tính theo phút)</i><br><br>
				<table width="100%" border="0" bgcolor="#9999FF">
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp Reset</b></td>
				    <td align="center"><b>Reset</b></td>
				    <td align="center"><b>Level</b></td>
				    <td align="center"><b>Zen</b></td>
				    <td align="center"><b>Chao</b></td>
				    <td align="center"><b>Create</b></td>
				    <td align="center"><b>Blue</b></td>
				    <td align="center"><b>Point</b></td>
				    <td align="center"><b>Mệnh lệnh</b></td>
				    <td align="center"><b>Time</b></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 1</b></td>
				    <td align="center"><?php $reset_cap_0++; echo "$reset_cap_0 - "; ?><input type="text" name="reset_cap_1" value="<?php echo $reset_cap_1; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_1" value="<?php echo $level_cap_1; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_1" value="<?php echo $zen_cap_1; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_1" value="<?php echo $chao_cap_1; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_1" value="<?php echo $cre_cap_1; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_1" value="<?php echo $blue_cap_1; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_1" value="<?php echo $point_cap_1; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_1" value="<?php echo $ml_cap_1; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_1" value="<?php echo $time_reset_next_1; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 2</b></td>
				    <td align="center"><?php $reset_cap_1++; echo "$reset_cap_1 - "; ?><input type="text" name="reset_cap_2" value="<?php echo $reset_cap_2; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_2" value="<?php echo $level_cap_2; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_2" value="<?php echo $zen_cap_2; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_2" value="<?php echo $chao_cap_2; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_2" value="<?php echo $cre_cap_2; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_2" value="<?php echo $blue_cap_2; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_2" value="<?php echo $point_cap_2; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_2" value="<?php echo $ml_cap_2; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_2" value="<?php echo $time_reset_next_2; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 3</b></td>
				    <td align="center"><?php $reset_cap_2++; echo "$reset_cap_2 - "; ?><input type="text" name="reset_cap_3" value="<?php echo $reset_cap_3; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_3" value="<?php echo $level_cap_3; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_3" value="<?php echo $zen_cap_3; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_3" value="<?php echo $chao_cap_3; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_3" value="<?php echo $cre_cap_3; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_3" value="<?php echo $blue_cap_3; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_3" value="<?php echo $point_cap_3; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_3" value="<?php echo $ml_cap_3; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_3" value="<?php echo $time_reset_next_3; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 4</b></td>
				    <td align="center"><?php $reset_cap_3++; echo "$reset_cap_3 - "; ?><input type="text" name="reset_cap_4" value="<?php echo $reset_cap_4; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_4" value="<?php echo $level_cap_4; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_4" value="<?php echo $zen_cap_4; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_4" value="<?php echo $chao_cap_4; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_4" value="<?php echo $cre_cap_4; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_4" value="<?php echo $blue_cap_4; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_4" value="<?php echo $point_cap_4; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_4" value="<?php echo $ml_cap_4; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_4" value="<?php echo $time_reset_next_4; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 5</b></td>
				    <td align="center"><?php $reset_cap_4++; echo "$reset_cap_4 - "; ?><input type="text" name="reset_cap_5" value="<?php echo $reset_cap_5; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_5" value="<?php echo $level_cap_5; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_5" value="<?php echo $zen_cap_5; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_5" value="<?php echo $chao_cap_5; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_5" value="<?php echo $cre_cap_5; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_5" value="<?php echo $blue_cap_5; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_5" value="<?php echo $point_cap_5; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_5" value="<?php echo $ml_cap_5; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_5" value="<?php echo $time_reset_next_5; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 6</b></td>
				    <td align="center"><?php $reset_cap_5++; echo "$reset_cap_5 - "; ?><input type="text" name="reset_cap_6" value="<?php echo $reset_cap_6; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_6" value="<?php echo $level_cap_6; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_6" value="<?php echo $zen_cap_6; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_6" value="<?php echo $chao_cap_6; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_6" value="<?php echo $cre_cap_6; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_6" value="<?php echo $blue_cap_6; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_6" value="<?php echo $point_cap_6; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_6" value="<?php echo $ml_cap_6; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_6" value="<?php echo $time_reset_next_6; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 7</b></td>
				    <td align="center"><?php $reset_cap_6++; echo "$reset_cap_6 - "; ?><input type="text" name="reset_cap_7" value="<?php echo $reset_cap_7; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_7" value="<?php echo $level_cap_7; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_7" value="<?php echo $zen_cap_7; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_7" value="<?php echo $chao_cap_7; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_7" value="<?php echo $cre_cap_7; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_7" value="<?php echo $blue_cap_7; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_7" value="<?php echo $point_cap_7; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_7" value="<?php echo $ml_cap_7; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_7" value="<?php echo $time_reset_next_7; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 8</b></td>
				    <td align="center"><?php $reset_cap_7++; echo "$reset_cap_7 - "; ?><input type="text" name="reset_cap_8" value="<?php echo $reset_cap_8; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_8" value="<?php echo $level_cap_8; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_8" value="<?php echo $zen_cap_8; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_8" value="<?php echo $chao_cap_8; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_8" value="<?php echo $cre_cap_8; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_8" value="<?php echo $blue_cap_8; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_8" value="<?php echo $point_cap_8; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_8" value="<?php echo $ml_cap_8; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_8" value="<?php echo $time_reset_next_8; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 9</b></td>
				    <td align="center"><?php $reset_cap_8++; echo "$reset_cap_8 - "; ?><input type="text" name="reset_cap_9" value="<?php echo $reset_cap_9; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_9" value="<?php echo $level_cap_9; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_9" value="<?php echo $zen_cap_9; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_9" value="<?php echo $chao_cap_9; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_9" value="<?php echo $cre_cap_9; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_9" value="<?php echo $blue_cap_9; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_9" value="<?php echo $point_cap_9; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_9" value="<?php echo $ml_cap_9; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_9" value="<?php echo $time_reset_next_9; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 10</b></td>
				    <td align="center"><?php $reset_cap_9++; echo "$reset_cap_9 - "; ?><input type="text" name="reset_cap_10" value="<?php echo $reset_cap_10; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_10" value="<?php echo $level_cap_10; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_10" value="<?php echo $zen_cap_10; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_10" value="<?php echo $chao_cap_10; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_10" value="<?php echo $cre_cap_10; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_10" value="<?php echo $blue_cap_10; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_10" value="<?php echo $point_cap_10; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_10" value="<?php echo $ml_cap_10; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_10" value="<?php echo $time_reset_next_10; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 11</b></td>
				    <td align="center"><?php $reset_cap_10++; echo "$reset_cap_10 - "; ?><input type="text" name="reset_cap_11" value="<?php echo $reset_cap_11; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_11" value="<?php echo $level_cap_11; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_11" value="<?php echo $zen_cap_11; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_11" value="<?php echo $chao_cap_11; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_11" value="<?php echo $cre_cap_11; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_11" value="<?php echo $blue_cap_11; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_11" value="<?php echo $point_cap_11; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_11" value="<?php echo $ml_cap_11; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_11" value="<?php echo $time_reset_next_11; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 12</b></td>
				    <td align="center"><?php $reset_cap_11++; echo "$reset_cap_11 - "; ?><input type="text" name="reset_cap_12" value="<?php echo $reset_cap_12; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_12" value="<?php echo $level_cap_12; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_12" value="<?php echo $zen_cap_12; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_12" value="<?php echo $chao_cap_12; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_12" value="<?php echo $cre_cap_12; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_12" value="<?php echo $blue_cap_12; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_12" value="<?php echo $point_cap_12; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_12" value="<?php echo $ml_cap_12; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_12" value="<?php echo $time_reset_next_12; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 13</b></td>
				    <td align="center"><?php $reset_cap_12++; echo "$reset_cap_12 - "; ?><input type="text" name="reset_cap_13" value="<?php echo $reset_cap_13; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_13" value="<?php echo $level_cap_13; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_13" value="<?php echo $zen_cap_13; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_13" value="<?php echo $chao_cap_13; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_13" value="<?php echo $cre_cap_13; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_13" value="<?php echo $blue_cap_13; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_13" value="<?php echo $point_cap_13; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_13" value="<?php echo $ml_cap_13; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_13" value="<?php echo $time_reset_next_13; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 14</b></td>
				    <td align="center"><?php $reset_cap_13++; echo "$reset_cap_13 - "; ?><input type="text" name="reset_cap_14" value="<?php echo $reset_cap_14; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_14" value="<?php echo $level_cap_14; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_14" value="<?php echo $zen_cap_14; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_14" value="<?php echo $chao_cap_14; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_14" value="<?php echo $cre_cap_14; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_14" value="<?php echo $blue_cap_14; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_14" value="<?php echo $point_cap_14; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_14" value="<?php echo $ml_cap_14; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_14" value="<?php echo $time_reset_next_14; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 15</b></td>
				    <td align="center"><?php $reset_cap_14++; echo "$reset_cap_14 - "; ?><input type="text" name="reset_cap_15" value="<?php echo $reset_cap_15; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_15" value="<?php echo $level_cap_15; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_15" value="<?php echo $zen_cap_15; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_15" value="<?php echo $chao_cap_15; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_15" value="<?php echo $cre_cap_15; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_15" value="<?php echo $blue_cap_15; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_15" value="<?php echo $point_cap_15; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_15" value="<?php echo $ml_cap_15; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_15" value="<?php echo $time_reset_next_15; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 16</b></td>
				    <td align="center"><?php $reset_cap_15++; echo "$reset_cap_15 - "; ?><input type="text" name="reset_cap_16" value="<?php echo $reset_cap_16; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_16" value="<?php echo $level_cap_16; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_16" value="<?php echo $zen_cap_16; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_16" value="<?php echo $chao_cap_16; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_16" value="<?php echo $cre_cap_16; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_16" value="<?php echo $blue_cap_16; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_16" value="<?php echo $point_cap_16; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_16" value="<?php echo $ml_cap_16; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_16" value="<?php echo $time_reset_next_16; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 17</b></td>
				    <td align="center"><?php $reset_cap_16++; echo "$reset_cap_16 - "; ?><input type="text" name="reset_cap_17" value="<?php echo $reset_cap_17; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_17" value="<?php echo $level_cap_17; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_17" value="<?php echo $zen_cap_17; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_17" value="<?php echo $chao_cap_17; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_17" value="<?php echo $cre_cap_17; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_17" value="<?php echo $blue_cap_17; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_17" value="<?php echo $point_cap_17; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_17" value="<?php echo $ml_cap_17; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_17" value="<?php echo $time_reset_next_17; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 18</b></td>
				    <td align="center"><?php $reset_cap_17++; echo "$reset_cap_17 - "; ?><input type="text" name="reset_cap_18" value="<?php echo $reset_cap_18; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_18" value="<?php echo $level_cap_18; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_18" value="<?php echo $zen_cap_18; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_18" value="<?php echo $chao_cap_18; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_18" value="<?php echo $cre_cap_18; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_18" value="<?php echo $blue_cap_18; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_18" value="<?php echo $point_cap_18; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_18" value="<?php echo $ml_cap_18; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_18" value="<?php echo $time_reset_next_18; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 19</b></td>
				    <td align="center"><?php $reset_cap_18++; echo "$reset_cap_18 - "; ?><input type="text" name="reset_cap_19" value="<?php echo $reset_cap_19; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_19" value="<?php echo $level_cap_19; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_19" value="<?php echo $zen_cap_19; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_19" value="<?php echo $chao_cap_19; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_19" value="<?php echo $cre_cap_19; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_19" value="<?php echo $blue_cap_19; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_19" value="<?php echo $point_cap_19; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_19" value="<?php echo $ml_cap_19; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_19" value="<?php echo $time_reset_next_19; ?>" size="1"/></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td align="center"><b>Cấp 20</b></td>
				    <td align="center"><?php $reset_cap_19++; echo "$reset_cap_19 - "; ?><input type="text" name="reset_cap_20" value="<?php echo $reset_cap_20; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="level_cap_20" value="<?php echo $level_cap_20; ?>" size="2"/></td>
				    <td align="center"><input type="text" name="zen_cap_20" value="<?php echo $zen_cap_20; ?>" size="10"/></td>
				    <td align="center"><input type="text" name="chao_cap_20" value="<?php echo $chao_cap_20; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="cre_cap_20" value="<?php echo $cre_cap_20; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="blue_cap_20" value="<?php echo $blue_cap_20; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="point_cap_20" value="<?php echo $point_cap_20; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="ml_cap_20" value="<?php echo $ml_cap_20; ?>" size="1"/></td>
				    <td align="center"><input type="text" name="time_reset_next_20" value="<?php echo $time_reset_next_20; ?>" size="1"/></td>
				  </tr>
				</table>
				<center><input type="submit" name="Submit" value="Sửa" <?php if($accept=='0') { ?> disabled="disabled" <?php } ?> /></center>
				</form>
			</div>
		</div>
		<div id="right-column">
			<strong class="h">Thông tin</strong>
			<div class="box">Cấu hình :<br>
			- Tên WebSite<br>
			- Địa chỉ kết nối đến Server</div>
	  </div>
	  
