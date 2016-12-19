<?php
$act = $_GET['act'];
switch ($act) {
	case 'reset': include('editchar/adm_reset.php'); break;
	case 'resetvip': include('editchar/adm_resetvip.php'); break;
	case 'gioihanrs': include('editchar/adm_gioihanrs.php'); break;
	case 'hotrotanthu': include('editchar/adm_hotrotanthu.php'); break;
	case 'relife': include('editchar/adm_relife.php'); break;
	case 'uythacoffline': include('editchar/adm_uythacoffline.php'); break;
	case 'uythac_reset': include('editchar/adm_uythac_reset.php'); break;
	case 'uythac_resetvip': include('editchar/adm_uythac_resetvip.php'); break;
	case 'ruatoi': include('editchar/adm_ruatoi.php'); break;
	case 'taydiem': include('editchar/adm_taydiem.php'); break;
	case 'thuepoint': include('editchar/adm_thuepoint.php'); break;
	case 'changeclass': include('editchar/adm_changeclass.php'); break;
	case 'changename': include('editchar/adm_changename.php'); break;
	default: include('checkwrite.php'); break;
}
?>