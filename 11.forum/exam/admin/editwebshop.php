<?php
$act = $_GET['act'];
switch ($act) {
	case 'shop_armor': include('editwebshop/adm_shop.php'); break;
	case 'shop_wings': include('editwebshop/adm_shop.php'); break;
	case 'shop_ringpendants': include('editwebshop/adm_shop.php'); break;
	case 'shop_shields': include('editwebshop/adm_shop.php'); break;
	case 'shop_crossbows': include('editwebshop/adm_shop.php'); break;
	case 'shop_weapons': include('editwebshop/adm_shop.php'); break;
	case 'shop_scepters': include('editwebshop/adm_shop.php'); break;
	case 'shop_staffs': include('editwebshop/adm_shop.php'); break;
	case 'shop_spears': include('editwebshop/adm_shop.php'); break;
	case 'shop_fenrir': include('editwebshop/adm_shop.php'); break;
	case 'shop_eventticket': include('editwebshop/adm_shop.php'); break;
	case 'shop_orther': include('editwebshop/adm_shop.php'); break;
	case 'adddata': include('editwebshop/adm_adddata.php'); break;
	default: include('checkwrite.php'); break;
}
?>