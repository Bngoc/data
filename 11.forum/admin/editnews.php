<?php
if(!empty($_GET['act'])){
	$act = $_GET['act'];
	switch ($act) {
		//case 'vtc': include('editnapthe/vtc.php'); break;
		case 'edit': include('editnews/edit.php'); break;
		case 'del': include('editnews/del.php'); break;
		//case 'mobi': include('editnapthe/mobi.php'); break;
		//case 'vina': include('editnapthe/vina.php'); break;
		//default: include('editnapthe/editnapthe.php'); break;
		default: break;
	}
}
else
	include('checkwrite.php');
?>