<?PHP

global $skin_header, $skin_menu, $skin_footer, $skin_prefix;

$skin_prefix = "";

// ********************************************************************************
// Skin MENU
// ********************************************************************************

$skin_menu = cn_get_menu() . '<div style="clear:both;"></div>';
$setpath_default = getoption('http_script_dir');    // 	=> http://localhost/bqn/data <=> /bqn/data
$setpath_root_ = URL_PATH_;                            //	=> /bqn/data
$setpath_root_admin = URL_PATH;                        //	=> /bqn/data/admin
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
    <link rel="shortcut icon" type="image/ico" href="/images/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="/admin/skins/default.css">
	<link rel="stylesheet" href="/skins/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="/skins/font-awesome.min.css" type="text/css">

    <style type="text/css"><!-- {CustomStyle} --></style>
	
	<script type="text/javascript" src="/js/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="/js/clock.js"></script>
	
	<script type="text/javascript" src="js/angular.min.js"></script>
	<script type="text/javascript" src="js/ui-bootstrap-tpls-0.11.2.min.js"></script>
	<script type="text/javascript" src="js/angular-route.min.js"></script>
	<script type="text/javascript" src="js/angular-animate.min.js"></script>
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
		<span style="color: #888888; font-size: 15px;">Copyright &copy; {year-time}&nbsp; Convert by &nbsp;</span>{convertby}
	</div>
</div>
	<script type="text/javascript" src="/library/wz_tooltip.js"></script>
	<script type="text/javascript" src="/js/topxTip.js"></script>
    <script type="text/javascript" src="/skins/cute.js"></script>
    
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

?>
