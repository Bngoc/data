<?php
if(!empty($_GET['act'])){
$act = $_GET['act'];
	switch ($act) {
		case 'config': include('editconfig/adm_config.php'); break;
		case 'config_antiddos': include('editconfig/adm_config_antiddos.php'); break;
		case 'config_domain': include('editconfig/adm_config_domain.php'); break;
		case 'activepro': include('editconfig/adm_activepro.php'); break;
		case 'config_class': include('editconfig/adm_config_class.php'); break;
		case 'config_chucnang': include('editconfig/adm_config_chucnang.php'); break;
		case 'config_server': include('editconfig/adm_config_server.php'); break;
		default: break;
	}
}
else
	include('checkwrite.php');
?>