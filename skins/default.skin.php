<?PHP

global $skin_header, $skin_menu, $skin_menu_none, $skin_footer, $abccc, $skin_top;

$skin_prefix = "";

// ********************************************************************************
// Skin MENU
// ********************************************************************************

$skin_menu = cn_get_menu() . '<div style="clear:both;"></div>';
$skin_menu_none = cn_get_menu_none() . '<div style="clear:both;"></div>';
$setpath_default = getoption('http_script_dir');

$description = getoption('description');
$keywords = getoption('keywords');

// ********************************************************************************
// Skin HEADER
// ********************************************************************************

$skin_header = <<<HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta http-equiv="imagetoolbar" content="no" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta name="description" content="$description"/>
<meta name="keywords" content="$keywords" />

<link rel="shortcut icon" type="image/ico" href="$setpath_default/images/favicon.ico"/>
<!-- <link rel="stylesheet" type="text/css" href="http://localhost/bqn/data/library/common.css" /> -->

<link rel="stylesheet" href="$setpath_default/skins/style.css" type="text/css" />
<link rel="stylesheet" href="$setpath_default/skins/main.css" type="text/css"/>
<link rel="stylesheet" href="$setpath_default/skins/sub.css" type="text/css"/>


<!--link media="all" href="/images/widget43.css" type="text/css" rel="stylesheet" /> -->

	<script type="text/javascript" src="$setpath_default/js/jquery-2.1.0.min.js"></script>
<!--<script type="text/javascript" src="$setpath_default/library/vietvbb_topx.js"></script>-->
<!--<script type="text/javascript" src="$setpath_default/library/wz_tooltip.js"></script>-->
<script type="text/javascript" src="$setpath_default/library/jsCheckForm.js"></script>
<!--	
<script src="ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="http://localhost/bqn/data/images/referrer.js"></script>
<script language="javascript" src="http://localhost/bqn/data/images/features.js" type="text/javascript"></script>

<script type="text/javascript" src="http://localhost/bqn/data/images/jquery-latest.pack.js"></script>
<script type="text/javascript" src="http://localhost/bqn/data/images/jquery.pngFix.js"></script>

<!--
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
-->
<script type="text/javascript" src="$setpath_default/images/main.js"></script>
<!--
<script type="text/javascript">
    jQuery(function() { jQuery(document).pngFix(); });
</script>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


-->
    <title>{title}</title>
    <script type="text/javascript" src="$setpath_default/skins/cute.js"></script>
    {CustomJS}
    <style type="text/css"><!-- {CustomStyle} --></style>
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
		function moveScroller() {
			var move = function() {
				var st = $(window).scrollTop();
				var ot = $("#leftcol-anchor").offset().top;
				var s = $("#anchor");
				var submain = $("#mainsubcol");
				if(st > ot) {
					s.css({
						position: "fixed",
						top: "45px"
					});
					submain.css({
						float:"right",
					});
				} else {
					if(st < ot) {
						s.css({
							position: "relative",
							top: ""
						});
						submain.css({
						float:"left",
					 });
					}
				}
			};
			$(window).scroll(move);
			move();
		}
		
	</script>
<script type="text/javascript"> 
  $(function() {
    moveScroller();
  });
</script> 

</head>
<!--
<body style="margin: 0px;">
<div id="dhtmltooltip"></div>
<img id="dhtmlpointer" src="http://localhost/bqn/data/images/tooltiparrow.gif">
<div id="absolute">
<script type="text/javascript" src="http://localhost/bqn/data/images/mootools.js"></script>

<style type="text/css">

</div>
-->
<div id="gp_bar">
    <div class="w-menu-top">
        {top}
    </div>
</div>

	
<div id="wrapper">
	
    <div id="page_wrapper1">
        <div id="page_wrapper2">		
    		<script language="JavaScript" type="text/javascript" src="$setpath_default/images/stmenu.js"></script>
		
		<div class="clear"></div>  
		<div id="main_header"><script type="text/javascript">flashWrite('$setpath_default/images/allods_effect.swf',958,270,'','','transparent')</script></div>
		 <div id="menu"><script type="text/javascript" src="$setpath_default/images/menubody.js"></script></div>
   
   <div class="clear"></div>  
 
	<div id="main">
		<!-- ================START LEFTCOL=================-->
		<div id="leftcol">
			<div id="leftcol-anchor"></div>
			<div id="anchor">
				<!-- ------------------------------------------- -->
				<div class="loginbx">
					<div class="loginbx_n"></div>
						<div class="loginbx_c">
							{menu}
						</div>
					<div class="loginbx_s"></div>
				</div>
				<!-- ------------------------------------------- --><!-- ------------------------------------------- -->

				<div class="quicklink">
					<div class="quicklink_item"><a href="" onclick="MM_nbGroup('down','group1','Foro','',1)" onmouseover="MM_nbGroup('over','Foro','images/qlink_depoisit-over.png','',1)" onmouseout="MM_nbGroup('out')"><img src="images/11.png" alt="Foro" name="Foro" border="0" id="Home" onload=""></a></div>
					<div class="quicklink_item"><a href="" onclick="MM_nbGroup('down','group1','22','',1)" onmouseover="MM_nbGroup('over','22','images/diendan.png','',1)" onmouseout="MM_nbGroup('out')"><img src="images/22.png" alt="Foro" name="22" border="0" id="Home" onload=""></a></div>
					<div class="quicklink_item"><a href="" onclick="MM_nbGroup('down','group1','33','',1)" onmouseover="MM_nbGroup('over','33','images/dangky1.png','',1)" onmouseout="MM_nbGroup('out')"><img src="images/33.png" alt="Foro" name="33" border="0" id="Home" onload=""></a></div>
					<!--div class="quicklink_item"><a href="/"><img src="/images/qlink_depoisit.png" alt="Webshop phụ kiện" /></a></div-->
					<div class="quicklink_item"><a href="" onclick="MM_nbGroup('down','group1','44','',1)" onmouseover="MM_nbGroup('over','44','images/qlink_cashshop.png','',1)" onmouseout="MM_nbGroup('out')"><img src="images/44.png" alt="Foro" name="44" border="0" id="Home" onload=""></a></div>
					<div class="quicklink_item"><a href="" onclick="MM_nbGroup('down','group1','55','',1)" onmouseover="MM_nbGroup('over','55','images/ws.png','',1)" onmouseout="MM_nbGroup('out')"><img src="images/55.png" alt="Foro" name="55" border="0" id="Home" onload=""></a></div>        				
				</div>
		
				<div class="hotrotructuyen"></div>
				
			</div><!-- end anchor  -->
		</div><!-- end leftcol  -->
	<!-- ================END LEFTCOL=================-->

	<div id="mainsubcol">
HTML;

// ********************************************************************************
// Skin FOOTER
// ********************************************************************************

$skin_footer = <<<HTML
	</div> <!-- end mainsubcol -->
	</div> <!-- end main -->
	
		<div class="clear"></div>       
		</div> <!-- page_wrapper2 -->
      
	</div> <!-- page_wrapper1 -->
	</div> <!-- page_wrapper1 -->
    
 <!-- ---------------end body-------------------- -->
    
	
</div> <!-- wrapper -->
<!--
	<script type="text/javascript" src="library/jsGeneralFunction.js"></script>
	<!-- <script type="text/javascript" src="library/jsCheckForm.js"></script> -->
	<!--<script type="text/javascript" src="$setpath_default/library/Common.js"></script>-->
	<!--<script type="text/javascript" src="$setpath_default/library/jsWarehouse.js"></script>-->
	<!--<script type="text/javascript" src="$setpath_default/library/jsToolTip.js"></script>	-->

<div style="clear:both;"></div>
<div id="footer" style="float:left"> 
	<div id="bttop" style="display: block;">BACK TO TOP</div>	

	<div style="text-align: center;">
		<span style="color: #888888; font-size: 15px;">Execution time: {exec-time} s.<br>
		<span style="color: #888888; font-size: 15px;">Copyright &copy; {year-time}&nbsp; Convert by &nbsp;</span><a href="mailto:{email-name}">{byname}
	</div>
</div>
</body></html>
HTML;

$abccc = <<<HTML
	<!-- ===================START COMMENT==================== -->
		<div id="mainsubcol_content">

			<div id="mainsub_n"></div>
			<div id="mainsub_c">
				<div id="mainsub_content">
					<div id="mainsub_title">
						<font color="#d1a151">{paths_c}</font>
						{paths_menu}
					</div>
					
					<div id="mainsub_ranking_n"></div>
					<div id="mainsub_ranking_c">
						<div id="mainsub_inner_content"> 
							<!-- ================ CONTENT HERE ================ -->
							{content_here}
							<!-- ================ CONTENT HERE ================ //-->
						</div>                  
					</div>
					<div id="mainsub_ranking_s"></div>					
					<div class="clear"></div>              	
				</div>              
			</div>
			<div id="mainsub_s"></div>
			<div class="clear"></div>
	
		</div> 
	<!-- ===================END COMMENT==================== -->          
HTML;

$skin_top = <<<HTML
        <ul class="top-showInfo">
            <li>{nameVpoint}</li>
            <li>{nameGcoin}</li>
            <li>{nameGcKm}</li>
            <li>{nameBule}</li>
            <li>{nameChaos}</li>
            <li>{nameCreate}</li>
            <li>{nameBank}</li>
        </ul>
        <div class="user-inner">
            <div id="nonLogin">
                <ul>
                    <li class="lg-normal">
                        <div class="pao divbox">
                            <a href="#">
                                 {userImg}<span>{userName}<i class="down downup"></i></span>
                            </a>
                        </div>
                    </li>
                    <li class="box_login showbox" style="display: none;">
                        <div class="box-iframe box_1">{changePass}</div>
                        <div class="box-iframe box_1">{changeTel}</div>
                        <div class="box-iframe box_1">{changeEmail}</div>
                        <div class="box-iframe box_1">{changePwd}</div>
                        <div class="box-iframe box_1">{changeSecret}</div>
                        <div class="box-iframe box_1">{changeQA}</div>
                    </li>
                </ul>
            </div>
        </div>
    <div style="clear:both;"></div>
HTML;
?>
