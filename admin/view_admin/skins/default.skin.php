<?php
require_once  ROOT_ADMIN .'/ProcessCoreAdmin.php';
$coreAdmin = new ProcessCoreAdmin();

global $skin_header, $skin_menu, $skin_footer, $skin_prefix, $digitalSignature;

$skin_prefix = "";

// ********************************************************************************
// Skin MENU
// ********************************************************************************

$skin_menu = $coreAdmin->cn_get_menu() . '<div style="clear:both;"></div>';
// => http://localhost/bqn/data <=> /bqn/data
$setpath_default = getOption('http_script_dir');
// => /bqn/data
$setpath_root_ = URL_PATH_;
//=> /bqn/data/admin
$setpath_root_admin = URL_PATH;
$digitalSignature = cn_digital_signature_meta(getMember());
// ********************************************************************************
// Skin HEADER
// ********************************************************************************
$skin_header = <<<HTML
<!DOCTYPE HTML>
<html lang="en">
<head>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>{title}</title>
    <meta name="robots" content="noindex" />
    <link rel="shortcut icon" type="image/ico" href="/public/images/admin/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="/public/css/admin/default.css">
	<link rel="stylesheet" href="/public/css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="/public/css/font-awesome.min.css" type="text/css">
	{signature}
    <style type="text/css"><!-- {CustomStyle} --></style>

	<script type="text/javascript" src="/public/js/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="/public/js/clock.js"></script>

	<script type="text/javascript" src="/public/js/admin/angular.min.js"></script>
	<script type="text/javascript" src="/public/js/admin/ui-bootstrap-tpls-0.11.2.min.js"></script>
	<script type="text/javascript" src="/public/js/admin/angular-route.min.js"></script>
	<script type="text/javascript" src="/public/js/admin/angular-animate.min.js"></script>
	<srcipt type="text/javascript">
	</srcipt>
	{CustomJS}
</head>

<body>

<div style="width: 80%; margin: 16px auto 8px auto;" id="wrapper">
	<div style="float: left; width:100%" class ="bodernone">
		<div class="header-text">{header-text}</div>
		<!--<div class="header-time">{header-time}</div> -->
		<div class="giohethong header-time">
			<span id="date-time">{header-time}</span>
			<script type="text/javascript">window.onload = date_time('date-time');</script>
        </div>
		<div id="cssmenu">{menu}</div>
		<div id="contents">

			<div class="breadcrumbs">{breadcrumbs}


HTML;

// ********************************************************************************
// Skin FOOTER
// ********************************************************************************
$skin_footer = <<<HTML
			<div style="clear:both;"></div>
		</div>
		</div>
	</div>
</div>
<!-- FOOTER -->
<div id="footer" style="float:left">
	<div id="bttop" style="display: block;">BACK TO TOP</div>

	<div style="text-align: center;">
		<span style="color: #888888; font-size: 15px;">Execution time: {exec-time} s.<br>
		<span style="color: #888888; font-size: 15px;">Copyright &copy; {year-time}&nbsp; Convert by &nbsp;</span>{byname}
	</div>
</div>
	<script type="text/javascript" src="/public/library/wz_tooltip.js"></script>
	<script type="text/javascript" src="/public/js/topxTip.js"></script>
    <script type="text/javascript" src="/public/js/cute.js"></script>

	<script type="text/javascript">
		$(function(){
			$(window).scroll(function(){
				if($(this).scrollTop()!=0){
					$('#bttop').fadeIn();
					}
					else{
						$('#bttop').fadeOut();
					}
				});
			$('#bttop').click(function(){
				$('body,html').animate({
					scrollTop:10},500);
				});
			});
		</script>

</body></html>
HTML;
