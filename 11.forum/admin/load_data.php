<?php
session_start();
require_once('../config.php');

//if(isset($_POST["q"]))
	//$q = $_POST["q"];

// Kiem tra thong so --> bqn
//echo "q = " . $q . "<br>";
//$_POST["q"] =1;$_POST["page"] =1;
//echo $config_basedir . "<br>";
$_POST["page"] =1;

// KIỂM TRA TỒN TẠI PAGE HAY KHÔNG
if(isset($_POST["page"]))
{
	// ĐƯA 2 FILE VÀO TRANG & KHỞI TẠO CLASS
	require_once "../includes/paging_ajax.php";
	$paging = new paging_ajax();
	
	
	// ĐẶT CLASS CHO THÀNH PHẦN PHÂN TRANG THEO Ý MUỐN
	$paging->class_pagination = "pagination";
	$paging->class_active = "active";
	$paging->class_inactive = "inactive";
	$paging->class_go_button = "go_button";
	$paging->class_text_total = "total";
	$paging->class_txt_goto = "txt_go_button";

	// KHỞI TẠO SỐ PHẦN TỬ TRÊN TRANG
    $paging->per_page = 2; 	
    
    // LẤY GIÁ TRỊ PAGE THÔNG QUA PHƯƠNG THỨC POST
    $paging->page = $_POST["page"];
    
	
    // VIẾT CÂU TRUY VẤN & LẤY KẾT QUẢ TRẢ VỀ
	if(!empty($_POST["q"])){
		$q = $_POST["q"];
		$_SESSION['md'] = $q;
		$paging->text_sql = "SELECT * FROM topics Where forum_id=" . $q;
		//echo "thuc thi func if";
	}
	else{
		$paging->text_sql = "SELECT * FROM topics";
		$_SESSION['md'] =0;
	}
    $result_pag_data = $paging->GetResult();
	
	//echo "q = " . $q . "<br>";
	//echo " trang " . $paging->page . " <br>";
	//echo $paging->text_sql . " <br>";
	//echo $paging->GetResult() . " <br>";
	//echo $result_pag_data; exit();
	
	
    // BIẾN CHỨA KẾT QUẢ TRẢ VỀ
	$message = "";
	if($result_pag_data->num_rows == 0){
		$message.="<font style='color:red'>Non-Object!</font>";
	}
	else{
		// DUYỆT MẢNG LẤY KẾT QUẢ mysqli_fetch_array
		while ($row = mysqli_fetch_array($result_pag_data, MYSQLI_ASSOC)) { // //$row = $result_pag_data->fetch_array
			$message .= "<li><strong>" . $row['id'] . "</strong> " . $row['date'] . " " . $row['user_id'] . " " . $row['forum_id'] . " " . $row['subject'] . "</li>" ;
		}
	}
	// ĐƯA KẾT QUẢ VÀO PHƯƠNG THỨC LOAD() TRONG LỚP PAGING_AJAX
	$paging->data = "<div class='data'>" . $message;// . ""; // Content for Data    
	echo $paging->Load();  // KẾT QUẢ TRẢ VỀ
		
} 

