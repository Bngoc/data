<?php
if(!empty($_GET['act'])){
	$act = $_GET['act'];
	switch ($act) {
		case 'addcat': include('editcatagoris/addcat.php'); break;
		case 'editcat': include('editcatagoris/editcat.php'); break;
		case 'delcat': 
			include('editcatagoris/delcat.php');
			//if(isset($_GET['get']) =="getuser"){
				//include('editcatagoris/getuser.php');
			//}
		break;
		case 'delc': include('editcatagoris/delc.php'); break;
		//case 'relife': include('editchar/adm_relife.php'); break;
		//case 'uythacoffline': include('editchar/adm_uythacoffline.php'); break;
		//case 'uythac_reset': include('editchar/adm_uythac_reset.php'); break;
		//case 'uythac_resetvip': include('editchar/adm_uythac_resetvip.php'); break;
		//case 'ruatoi': include('editchar/adm_ruatoi.php'); break;
		//case 'taydiem': include('editchar/adm_taydiem.php'); break;
		//case 'thuepoint': include('editchar/adm_thuepoint.php'); break;
		//case 'changeclass': include('editchar/adm_changeclass.php'); break;
		//case 'changename': include('editchar/adm_changename.php'); break;
		default: break;
	}
}
else
	include('checkwrite.php');
?>