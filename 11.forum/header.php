<?php //if (!defined('BQN_MU')) { die('Access restricted'); }
	require_once("config.php");
	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--<title>Thời trang quần áo phụ kiện hàng hiệu chính hãng tại Chon vn</title> -->
    <link rel="shortcut icon" href="images/icon/favicon.ico">
	<title><?php echo $config_forumsname; ?></title>
	
	<script type="text/javascript" src="js/jquerys/jquery-2.1.0.min.js"></script>
	
	<script src="js/jquerys/jquery.min.js" type="text/javascript"></script>
	
	<script type='text/javascript'>$(function(){$(window).scroll(function(){if($(this).scrollTop()!=0){$('#bttop').fadeIn();}else{$('#bttop').fadeOut();}});$('#bttop').click(function(){$('body,html').animate({scrollTop:10},200);});});</script>
	
	<script type="text/javascript" src="js/jquerys/clock.js"></script>
	
	<link rel="stylesheet" href="css/headerfooter.css" type="text/css" />
	<link rel="stylesheet" href="css/stylesheet.css" type="text/css" />
	<script type="text/javascript">
				$(document).ready(function(){
					$('#sedit').click(function(){
						$('#ed').toggle();
					});
				});
				
				function checkDelete(){
					return confirm('Are you sure to delete?');
				};
				/*
				$(document).ready(function(){
					$('p').click(function(){
						alert('The paragraph was clicked.');
					});
				
				});
				*/
</script>	
</head>
<body>
<div id="header">
<h1><?php echo $config_forumsname; ?></h1>
<div class="giohethong">
	<span id="date-time" style="margin-left:12px">Sunday, September 27 2015 | 20:36:57</span>
	<script type="text/javascript">window.onload = date_time('date-time');</script>
</div>
</div>

<div id="menu">
[<a href="/forum/index.php"><img  src="/forum/images/icon/home_beach_hover.png">Home</a>]
[<a href="/forum/modules/newtopic.php">New Topic</a>]


<?php

if(isset($_SESSION['ADMIN']) == TRUE){
	echo "[<a href='/forum/admin/adlogout.php'>Logout</a>]";
	echo "Chao $_SESSION[ADMIN]";
}
else
if(isset($_SESSION['USERNAME']) == TRUE) {
		echo "[<a href='/forum/modules/logout.php'>Logout</a>]";
		echo "Chao $_SESSION[USERNAME]";
}
else {
	echo "[<a href='/forum/modules/login.php'>Login</a>]";
	echo "[<a href='/forum/modules/register.php'>Register</a>]";
}
?>


</div>
<div id="container">
<div id="main">

