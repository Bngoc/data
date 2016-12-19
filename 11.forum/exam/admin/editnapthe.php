<?php
$act = $_GET['act'];
switch ($act) {
	case 'vtc': include('editnapthe/vtc.php'); break;
	case 'gate': include('editnapthe/gate.php'); break;
	case 'viettel': include('editnapthe/viettel.php'); break;
	case 'mobi': include('editnapthe/mobi.php'); break;
	case 'vina': include('editnapthe/vina.php'); break;
	default: include('editnapthe/editnapthe.php'); break;
}
?>