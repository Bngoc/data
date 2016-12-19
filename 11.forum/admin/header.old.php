
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="shortcut icon" href="/forum/images/icon/favicon.ico">
	
	<title>CineForums</title>
	
	<script type="text/javascript" src="/forum/js/jquerys/jquery-2.1.0.min.js"></script>
	
	<script src="/forum/js/jquerys/jquery.min.js" type="text/javascript"></script>
	
	<script type="text/javascript">$(function(){$(window).scroll(function(){if($(this).scrollTop()!=0){$('#bttop').fadeIn();}else{$('#bttop').fadeOut();}});$('#bttop').click(function(){$('body,html').animate({scrollTop:10},200);});});</script>
	
	<script type="text/javascript" src="/forum/js/jquerys/clockk.js"></script>
	
	<!--link rel="stylesheet" href="/forum/css/styles.css" type="text/css"-->
	<link rel="stylesheet" href="/forum/admin/images/css.css" type="text/css">
	<link rel="stylesheet" href="/forum/css/headerfooter.css" type="text/css">
	<!--link rel="stylesheet" href="/forum/css/stylesheet.css" type="text/css" /-->
	<style type="text/css">
				$(document).ready(function(){
					$('#sedit').click(function(){
						$('#ed').toggle();
					});
				});
				
				function checkDelete(){
					return confirm('Are you sure to delete?');
				};

	</style>	

</head>
<body>

<div id="header">
	<h1>CineForums</h1>
	
</div>
<div id="container">
<div id="main">

	<div id="menu">
	<!--div id='cssmenu'>
<!--ul>
   <li class='active'><a href='#'>Home</a></li>
   <li><a href='#'>Products</a></li>
   <li><a href='#'>Company</a></li>
   <li><a href='#'>Contact</a></li>
</ul>
</div-->

		<ul id="top-navigation">
			<li <?php if($mod=='editconfig' || !$mod) { ?> class="active" <?php } ?> ><span><span><a href="admin.php?mod=editconfig">Cấu Hình Chung</a></span></span></li>
			<li <?php if($mod=='Catagoris') { ?> class="active" <?php } ?> ><span><span><a href="admin.php?mod=Catagoris">Catagoris</a></span></span></li>
			<li <?php if($mod=='editwebshop') { ?> class="active" <?php } ?> ><span><span><a href="admin.php?mod=editwebshop">Webshop</a></span></span></li>
			<li <?php if($mod=='editnapthe') { ?> class="active" <?php } ?> ><span><span><a href="admin.php?mod=editnapthe">Nạp Thẻ</a></span></span></li>
		</ul>
		<span id="date-time" style="margin-right:12px; float:right">Sunday, September 27 2015 | 20:36:57</span>
		<script type="text/javascript">window.onload = date_time('date-time');</script>
	</div>
	<div class="middle">
	

	