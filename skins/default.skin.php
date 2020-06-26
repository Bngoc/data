<?php

require_once  ROOT .'/core/ProcessCoreWeb.php';
$coreWeb = new ProcessCoreWeb();

global $skin_header_web, $skin_menu_web, $skin_menu_none, $skin_footer_web, $skin_content_web, $skin_menu_TopMoney, $skin_menu_TopAccount;
global $defaultVerifyMyChar, $defaultVerifyAjax;
$skin_prefix = "";

// ********************************************************************************
// Skin MENU
// ********************************************************************************

$skin_menu_web = $coreWeb->cn_get_menu() . '<div style="clear:both;"></div>';
$skin_menu_none = $coreWeb->cn_get_menu_none() . '<div style="clear:both;"></div>';
$setpath_default = getOption('http_script_dir');

$description = getOption('description');
$keywords = getOption('keywords');
$patchImg = URL_PATH_IMG;

// ********************************************************************************
// Skin HEADER WEB
// ********************************************************************************

$skin_header_web = <<<HTML
<!DOCTYPE HTML>
<html lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta http-equiv="imagetoolbar" content="no" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta name="description" content="{title}/$description"/>
<meta name="keywords" content="{title}/$keywords" />
<meta name="robots" content="{title}" />
<title>{title}</title>

<link rel="shortcut icon" type="image/ico" href="public/images/web/favicon.ico"/>
<link rel="stylesheet" href="/public/css/web/style.css" type="text/css" />
<link rel="stylesheet" href="/public/css/web/main.css" type="text/css"/>
<link rel="stylesheet" href="/public/css/web/sub.css" type="text/css"/>
<link rel="stylesheet" href="/public/css/bootstrap.min.css" type="text/css"/>

<script type="text/javascript" src="/public/js/jquery-2.1.0.min.js"></script>


    {CustomJS}
    <style type="text/css"><!-- {CustomStyle} --></style>
</head>

<div id="gp_bar">
    <div class="w-menu-top">
        {top}
    </div>
</div>

<div id="wrapper">

    <div id="page_wrapper1">
        <div id="page_wrapper2">
    		<script language="JavaScript" type="text/javascript" src="/public/js/web/stmenu.js"></script>

		<div class="clear"></div>
		<div id="main_header">
		    <div class="download_home" title="Download"><a href="#" title="Download"></a></div>
         </div>
		 <div id="menu">
		    <ul class="menu">
                <li class="home" title="Home"><a href="#">Home</a></li>
                <li class="news" title="News"><a href="#">Tin tức</a></li>
                <li class="services"><a href="#">Hướng Dẫn</a></li>
                <li class="contact"><a href="#">Xếp Hạng</a></li>
                <li class="contact"><a href="#">Thư Viện</a></li>
            </ul>
        </div>

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
				<div class="hotrotructuyen"></div>
			</div><!-- end anchor  -->
		</div><!-- end leftcol  -->
	<!-- ================END LEFTCOL=================-->

	<div id="mainsubcol">
HTML;

// ********************************************************************************
// Skin FOOTER WEB
// ********************************************************************************

$skin_footer_web = <<<HTML
	</div> <!-- end mainsubcol -->
	</div> <!-- end main -->

		<div class="clear"></div>
		</div> <!-- page_wrapper2 -->

	</div> <!-- page_wrapper1 -->
	</div> <!-- page_wrapper1 -->

 <!-- ---------------end body-------------------- -->


</div> <!-- wrapper -->


<div style="clear:both;"></div>
<div id="footer" style="float:left">
	<div id="bttop" style="display: block;">BACK TO TOP</div>

	<div style="text-align: center;">
		<span style="color: #888888; font-size: 15px;">Execution time: {exec-time} s.<br>
		<span style="color: #888888; font-size: 15px;">Copyright &copy; {year-time}&nbsp; Convert by &nbsp;</span><a href="mailto:{email-name}">{byname}
	</div>
</div>

    <script type="text/javascript" src="/public/js/cute.js"></script>
    <script type="text/javascript" src="/public/library/wz_tooltip.js"></script>
	<script type="text/javascript" src="/public/js/topxTip.js"></script>
    <script type="text/javascript" src="/public/library/jsCheckForm.js"></script>

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
</body></html>
HTML;

// ********************************************************************************
// Skin CONTENT WEB
// ********************************************************************************

$skin_content_web = <<<HTML
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

// ********************************************************************************
// Skin MENU TOP INFO MONEY WEB
// ********************************************************************************

$skin_menu_TopMoney = <<<HTML
    <ul class="top-showInfo">
        <li>{nameVpoint}</li>
        <li>{nameGcoin}</li>
        <li>{nameGcKm}</li>
        <li>{nameBule}</li>
        <li>{nameChaos}</li>
        <li>{nameCreate}</li>
        <li>{nameBank}</li>
        <li>{nameFeather}</li>
    </ul>
HTML;

// ********************************************************************************
// Skin MENU TOP INFO ACCOUNT WEB
// ********************************************************************************

$skin_menu_TopAccount = <<<HTML
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

// ********************************************************************************
// Skin MENU TOP INFO ACCOUNT WEB
// ********************************************************************************

$defaultVerifyMyChar = <<<HTML
    <table width="100%" class="pd-top10">
        <tr>
            <td colspan="3" class="">MÃ XÁC NHẬN</td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="$patchImg/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
                <br/></td>
        </tr>

        <tr>
            <td class="bizwebform_col_1"><a href="#" style="border-bottom: 1px dotted #000080;"
                    onclick="getId('captcha_web').src='/captcha.php?page=web&r='+Math.random(); return(false);">
                    Refresh code</a></td>
            <td colspan="" class="bizwebform_col_2" style="padding-left:20px;">
                <div class="vertical-img"><img src="/captcha.php?page=web"
                                               id="captcha_web" alt=""></div>
            </td>
            <td class="bizwebform_col_3"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Nhập mã xác nhận <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input type="text" class="bizwebform" name="verifyCaptcha" required autocomplete="on"
                                                onchange="checkCaptcha(this.value, 'msg_Captcha');"/></td>
            <td class="bizwebform_col_3" id="msg_Captcha"></td>
        </tr>
        <tr>
            <td colspan="3" style="padding:20px; text-align:center"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:center">
                <input type="image" src="$patchImg/capnhat.png" style="padding-right:10px">
                <img style="cursor:pointer" border="0" src="$patchImg/cancel.png"
                     onclick="document.getElementById('verify').reset();" style="padding-left:10px">
            </td>
        </tr>
    </table>
HTML;

// ********************************************************************************
// Skin MENU TOP INFO ACCOUNT WEB
// ********************************************************************************

$defaultVerifyAjax = <<<HTML
    <table width="100%" class="pd-top10">
        <tr>
            <td colspan="3" class="">MÃ XÁC NHẬN</td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="$patchImg/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
                <br/></td>
        </tr>

        <tr>
            <td class="bizwebform_col_1"><a href="#" style="border-bottom: 1px dotted #000080;"
                    onclick="getId('captcha_web').src='/captcha.php?page=web&r='+Math.random(); return(false);">
                    Refresh code</a></td>
            <td colspan="" class="bizwebform_col_2" style="padding-left:20px;">
                <div class="vertical-img"><img src="/captcha.php?page=web"
                                               id="captcha_web" alt=""></div>
            </td>
            <td class="bizwebform_col_3"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Nhập mã xác nhận <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input id="verifyCaptcha" type="text" class="bizwebform" name="verifyCaptcha" required autocomplete="on"
                                                onchange="checkCaptcha(this.value, 'msg_Captcha');"/></td>
            <td class="bizwebform_col_3" id="msg_Captcha"></td>
        </tr>
        <tr>
            <td colspan="3" style="padding:20px; text-align:center"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:center">
                <!--<input type="image" src="$patchImg/capnhat.png" style="padding-right:10px">-->
                <img src="$patchImg/capnhat.png" style="padding-right:10px" alt="update" {nameAction}>
                <img style="cursor:pointer" border="0" src="$patchImg/cancel.png"
                     onclick="document.getElementById('verify').reset();" style="padding-left:10px">
            </td>
        </tr>
    </table>
HTML;
