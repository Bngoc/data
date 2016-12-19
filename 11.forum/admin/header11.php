<?php 
	include_once("security.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . '/forum/config.php');	
	//session_start();
	//list($act, $preview) = GET('act, preview', 'GETPOST');  
	
	echo "act: " . $act;
	//if(!isset($_SESSION['ADMIN']))
		//Header('Location:' . $config_basedir . '/admin/2.php');
	//else{
		//echo $_SESSION['ADMIN'];
?>

<!doctype html>
<html lang='en'>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="shortcut icon" href="/forum/images/icon/favicon.ico">
	<title>CineForums</title>
	
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="/forum/css/adstyles.css">
   <script src="/forum/js/jquerys/jquery-latest.min.js" type="text/javascript"></script>
<!-- -------------------------------------------- -->
	<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> --><!-- ??? -->
	<script type="text/javascript" src="/forum/js/jquerys/jquery-2.1.0.min.js"></script>
	<!--<script src="/forum/js/jquerys/jquery.min.js" type="text/javascript"></script> --> <!-- bi loi het check del -->
	
	
	<script type="text/javascript">$(function(){$(window).scroll(function(){if($(this).scrollTop()!=0){$('#bttop').fadeIn();}else{$('#bttop').fadeOut();}});$('#bttop').click(function(){$('body,html').animate({scrollTop:10},200);});});</script>
	
	<script type="text/javascript" src="/forum/js/jquerys/clock.js"></script>
	<script type="text/javascript" src="/forum/js/jquerys/bncustom.js"></script> 
	
	
	<link rel="stylesheet" href="/forum/css/bootstrap.min.css">
	<!--<script src="/forum/js/jquerys/jquery.min1.js" type="text/javascript"></script> <!-- chay menu noi dung -->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css"> bo -->
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>  bo ma van chay ??-->
	<script src="/forum/js/jquerys/bootstrap.min.js"></script>
	
	
	<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> --> <!-- loi menu cai func pagi -->
	<!--<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script> <!--- bi loi ca menu lam phan trang - --> 
	<!--link rel="stylesheet" href="/forum/css/styles.css" type="text/css"-->
	
	<!-- phan trang --
	<script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
	<!-- end pt -->
	
	<link rel="stylesheet" href="/forum/admin/images/css.css" type="text/css">
	<link rel="stylesheet" href="/forum/css/headerfooter.css" type="text/css">
	<!--link rel="stylesheet" href="/forum/css/stylesheet.css" type="text/css" /-->
	<script type="text/javascript">
		$(document).ready(function(){
			$('#sedit').click(function(){
				$('#ed').toggle();
			});
		});
		
		function checkDelete(){
			return confirm('Are you sure to delete?');
		};

	</script>
	
	
	<script type="text/javascript">
		
		$(document).ready(function(){
			
		//var url = window.location.href;
		//alert(url);

        //$('.menu a[href="'+url+'"]').addClass('current_page_item');

			$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) { //'a[data-toggle="tab"]
				localStorage.setItem('activeTab', $(e.target).attr('name'));
				//alert($(e.target).attr('name'));
			});
			var activeTab = localStorage.getItem('activeTab');
			if(activeTab){
				$('#cssmenu a[name="' + activeTab + '"]').tab('show');
			}
			
			//alert(activeTab);
			
			
			$('#cssmenu a').click(function(e) {
				e.preventDefault();
				
				//$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) { //'a[data-toggle="tab"]
						//localStorage.setItem('activeTab', $(e.target).attr('id'));
				//});
				//alert(activeTab);
				if ($(this).closest("li").attr("class") == "active"){ //detection for current tab
					
				 return       
				}
				else{             
				$(".left_forums .col_1").hide(); //Hide all content
				//$("#cssmenu li").attr("class",""); //Reset id's
				//$(this).parent().attr("class","active"); // Activate this
				$('.' + $(this).attr('name')).fadeIn(); // Show content for current tab
				}
			});
		});
	</script>
	
	<script>
		/* ------------------------
		
		/* ------------------*/
		/*\
		$(document).ready(function() {
			//$(".content div").hide(); // Initially hide all content
			//$("#cssmenu li:first").attr("class","active"); // Activate first tab
			//$(".content div:first").fadeIn(); // Show first tab content
			
			
			$('#cssmenu a').click(function(e) {
				e.preventDefault();
				//if ($(this).closest("li").attr("class") == "active"){ //detection for current tab
				 //return       
				//}
				//else
				{             
				$(".content div").hide(); //Hide all content
				//$("#cssmenu li").attr("class",""); //Reset id's
				//$(this).parent().attr("class","active"); // Activate this
				$('.' + $(this).attr('name')).fadeIn(); // Show content for current tab
				}
			});
		});
		// ----------------- 
		
		

		
		//----------------
	
	/* ********** mau *** */
	/*
	$(document).ready(function() {
		$("#content div").hide(); // Initially hide all content
		$("#tabs li:first").attr("id","current"); // Activate first tab
		$("#content div:first").fadeIn(); // Show first tab content

		$('#tabs a').click(function(e) {
			e.preventDefault();
			if ($(this).closest("li").attr("id") == "current"){ //detection for current tab
			 return       
			}
			else{             
			$("#content div").hide(); //Hide all content
			$("#tabs li").attr("id",""); //Reset id's
			$(this).parent().attr("id","current"); // Activate this
			$('#' + $(this).attr('name')).fadeIn(); // Show content for current tab
			}
		});
	});
	*/
	
	
</script>
<!-- -------------------------------------------- -->
<!--ul id="tabs">
    <li><a href="#" name="tab1">T1/a></li>
    <li><a href="#" name="tab2">T2</a></li>
</ul>

<div id="content"> 
    <div id="tab1">
    TAB 1 CONTENT
    </div>

    <div id="tab2">
    TAB 2 CONTENT
    </div>
</div-->
<!-- --------------------Header menu--------------------- -->
</head>
<body>

<div class="header">
	<div class="span-26 user-menu">
		<div class="user-inner">
			<div id="nonLogin" style="display:block">
				<ul>
					<?php if(isset($_SESSION['ADMIN'])){?>
					<li class="lg-facebook">
						<!--a href="" class="" > <!--data-gps-track="profile_summary.click()">-->
							<div class="gravatar" style="display: inline-block;" title="<?php echo $_SESSION['ADMIN'] ?>">
							<img src="https://graph.facebook.com/100006110288487/picture?type=large" alt="" width="24" height="24" class="avatar-me js-avatar-me"></div>
						<!--/a-->
							<div class="links-container" style="display: inline-block;">
									<a href="admin/adlogout.php" title="Logout" id='logout'>Logout</a>
							</div>
						
						
					</li>
						<?php }
						else {?>
						
						
							<!--<a id="login_a" href="#">login</a>-->
						<!--
					<li class="lg-normal">
						<div class="pao divbox">
							<a href="javascript:void(0)">
								 <span>Đăng nhập</span>
								 <i class="down"></i>
							</a>
						</div>
						<div class="box_login showbox" style="display: none;">
							<div class="box_login1">
							 <div class="loginUser">
								 <label>Email hoặc username</label>
								 <span><input type="text" name="loginUser" id="loginUser" value="" placeholder="Username or Email"></span>
							 </div>
							 <div class="loginPass">
								 <label>Mật khẩu</label>
								 <span><input type="password" name="loginPass" id="loginPass" value="" placeholder="Password"></span>
							 </div>
							 <div class="fotgetPass">
								 <a href="#"><span>Quên mật khẩu</span></a>
								 <a href="#"><span>Đăng ký</span></a>
							 </div>
							 <div class="btnEnter">
								 <a rel="" href="#">Đăng nhập</a>
							 </div>
							</div>
							<div style="text-align: center;clearfloat: both;padding-top: 10px;color:#c00" id="loginmessage"></div>
							<div class="box_login2">
								 <span class="line"></span>
								 <span class="line1"></span>
								 <span class="title">Hoặc</span>
								 <a class="img_login-fb" href="#"><img border="0" title="login facebook" alt="login facebook" src="/forum/images/icon/img-facebook.png"></a>
							</div>
						</div>
					</li>
					-->
					<!------Login: Facebook------- -->
					<li class="lg-facebook"><a rel="nofollow" href="#"><img border="0" title="login facebook" alt="login facebook" src="/forum/images/icon/login-fb.jpg"></a></li>
				<?php } ?>
				</ul>
				
			 </div>
		</div>
	</div>
	
	<!-- ------------- -->
	<div class="span-26 chon">
            	<div class="logo">
                	<a href="./" title="Trung tĂ¢m thá»i trang chĂ­nh hĂ£ng uy tĂ­n hĂ&nbsp;ng Ä‘áº§u viá»‡t nam"></a>
                </div>
                
                <div class="search">
                	<div class="tukhoa">
                    	<ul>
                        	<li>
                            	<span>Từ khóa thông dụng</span>
                                <div class="tugoiy" style="">
                                	<a title="hong hanh" href="#" class="topKeyword_link">hong hanh (237)</a>
                                    <a title="Ă¡o sÆ¡ mi blue exchange" href="#" class="topKeyword_link">Ă¡o sÆ¡ mi blue exchange (249)</a>
                                    <a title="ao thun nam" href="#" class="topKeyword_link">ao thun nam (2610)</a>
                                    <a title="ba lĂ´" href="#" class="topKeyword_link">ba lĂ´ (72)</a>
                                    <a title="huy hoĂ&nbsp;ng" href="#" class="topKeyword_link">huy hoĂ&nbsp;ng (148)</a>
                                    <a title="quá»³nh bĂ¬nh phuong" href="#" class="topKeyword_link">quá»³nh bĂ¬nh phuong (55)</a>
                                    <a title="quáº§n kaki nam viá»‡t tiáº¿n" href="#" class="topKeyword_link">quáº§n kaki nam viá»‡t tiáº¿n (51)</a>
                                    <a title="ao the thao" href="#">ao the thao (122)</a>
                                    <a title="GiĂ&nbsp;y Aldo quai chĂ©o" href="#" class="topKeyword_link">GiĂ&nbsp;y Aldo quai chĂ©o (12)</a>
                                    <a title="ao dam oci mau den" href="#" class="topKeyword_link">ao dam oci mau den (36)</a>
                                </div>
                            </li>
                        </ul>
                    </div>
					 <form class="searchbox" method="get" action="search.php">
						<button type="submit" class="isearch"></button>
						<div id="p_scents"><p class="iconsearch"><input type="text" class="" id="txtQuery" value="" name="q" placeholder="Nhập từ khóa tìm kiếm"></p></div>
						<button id="button" type="submit" class="tksearch"></button>
					</form>
                    <!--div class="searchbox" method="get" action="search.php?q=">
                    	<p class="isearch" onclick="doSearch()" ></p>
                        <div id="p_scents">
                            <p class="iconsearch">            
                                <!--input id="txtQuery" type="text" value="" placeholder="Nháº­p tĂªn thÆ°Æ¡ng hiá»‡u, mĂ£ hoáº·c Ä‘áº·c Ä‘iá»ƒm sáº£n pháº©m" maxlength="100" /-->
								<!--input name="q" type="text" id="txtQuery" maxlength="100" value="<br />
<font size='1'><table class='xdebug-error xe-notice' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Notice: Undefined variable: ql in C:\wamp\www\chon.vn\index.php on line <i>170</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0593</td><td bgcolor='#eeeeec' align='right'>407888</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='C:\wamp\www\chon.vn\index.php' bgcolor='#eeeeec'>..\index.php<b>:</b>0</td></tr>
</table></font>
" placeholder="Nháº­p tĂªn thÆ°Æ¡ng hiá»‡u, mĂ£ hoáº·c Ä‘áº·c Ä‘iá»ƒm sáº£n pháº©m" class="ui-autocomplete-input" onclick="resetText()" onblur="checkText()">
                            </p>
                        </div>
                        <p class="tksearch" onclick="doSearch()"></p>
                    </div-->
					
                </div>
                
            	<div class="hotline">
                    <p>Hotline:</p>
                    <p class="num">1900­ XX XX XX</p>
            	</div>
                <div class="giohethong">
                    <span id="date-time">Saturday, October 3 2015 | 15:36:04</span>
                    <script type="text/javascript">window.onload = date_time('date-time');</script>
               </div>
                <div class="Share">
                    <p>Chia sẻ</p>
                    <p>
                        <a rel="nofollow" class="facebook" onclick="window.open('http://www.facebook.com/share.php?u='+document.location,'_blank');" style="cursor: pointer;" title="ÄÄƒng lĂªn Facebook"></a> 
                        <a rel="nofollow" class="twitter" onclick="window.open('http://twitter.com/home?status='+document.location,'_blank');" style="cursor: pointer;" title="ÄÄƒng lĂªn Twitter"> </a>
                        <a rel="nofollow" class="googleplus" onclick="window.open('https://plus.google.com/share?url='+document.location,'_blank');" title="ÄÄƒng lĂªn googleplus"></a>
                    </p>
            	</div>
            </div>
	<!-- ------------- -->
	<!--h1>CineForums</h1>
	
	<!--
	<div class ="cmenu">
		<span> <a href ="#"> Login </a>
		<span id="date-time" style="margin-right:12px; float:right">Sunday, September 27 2015 | 20:36:57</span>
		<script type="text/javascript">window.onload = date_time('date-time');</script>
	</div> -->
<!-- --------------------Menu--------------------- -->

	<div class="menu">
		<div id='cssmenu'>
			<!--ul>
			   <li class='active'><a href='#'>Home</a></li>
			   <li><a href='#'>Products</a></li>
			   <li><a href='#'>Company</a></li>
			   <li><a href='#'>Contact</a></li>
			   <li><a href='#'>Contact</a></li>
			</ul-->
			<ul class="nav-tabs">
					<li class="active"><a href="#editconfig" data-toggle="tab" name="tab1">Cấu Hình Chung</a></li> <!-- -->
					<li><a href="#editcatagoris" data-toggle="tab" name="tab2" >Catagoris</a></li>
					<li><a href="#editforums" data-toggle="tab" name="tab3" >Forum</a></li>
					<li><a href="#editnews" data-toggle="tab" name="tab4" >Newtopic</a></li>
					<li><a href="#edituser" data-toggle="tab" name="tab5" >User</a></li>
			</ul>
		</div>
		
	</div>
</div>
<!-- --------------------Content--------------------- -->
   


<div id="container">
	<div id="main">	
		<div class="middle ">
			<div style="width:15%;float: left;">
				<div id="left-column" class="tab-content">
					<!-- ********* Cau hinh chung ****** -->
					<div id="editconfig" class="tab-pane fade in active">
						<h3>Chức năng</h3>
						<ul class="nav">
							<li><a href="admin.php?mod=editconfig&amp;act=config">Cấu Hình Web</a></li>
							<li><a href="admin.php?mod=editconfig&amp;act=config_class">Cấu Hình Class</a></li>
							<li><a href="admin.php?mod=editconfig&amp;act=config_chucnang">Cấu hình Chức năng</a></li>
							<li><a href="admin.php?mod=editconfig&amp;act=config_domain">Tên miền chính WebSite</a></li>
							<li><a href="admin.php?mod=editconfig&amp;act=config_antiddos">Hệ thống chống DDOS</a></li>
							<li><a href="admin.php?mod=editconfig&amp;act=activepro">Kích hoạt Phiên Pro</a></li>
							<li class="last"><a href="admin.php?mod=editconfig&amp;act=config_server">Cấu Hình Server</a></li>
						</ul>
					</div>
					<!-- ********* Cau hinh catagoris ****** -->
					<div id="editcatagoris" class="tab-pane fade">
						<h3>Chức năng</h3>
						<ul class="nav">
							<li><a href="admin.php?mod=editcatagoris&act=addcat">Add Cat</a></li>
							<li><a href="admin.php?mod=editcatagoris&act=editcat">Edit cat</a></li>
							<li><a href="admin.php?mod=editcatagoris&act=delcat">Del cat</a></li>
							<li><a href="admin.php?mod=editcatagoris&act=delc">del cl</a></li>
							<li class="last"><a href="admin.php?mod=editcatagoris&act=">Cau hinh catagoris</a></li>
						</ul>
					</div><!-- ********* Cau hinh forum ****** -->
					<div id="editforums" class="tab-pane fade">
						<h3>Chức năng</h3>
						<ul class="nav">
							<li><a href="admin.php?mod=editforums&amp;act=">Add forums</a></li>
							<li><a href="admin.php?mod=editforums&amp;act=">Edit forums</a></li>
							<li><a href="admin.php?mod=editforums&amp;act=">Del forums</a></li>
							<li class="last"><a href="admin.php?mod=editforums&amp;act=">Cau hinh forum</a></li>
						</ul>
					</div>
					<!-- ********* Cau hinh newtopic ****** -->
					<div id="editnews" class="tab-pane fade">
						<h3>Chức năng</h3>
						<ul class="nav">
							
							<li><a href="admin.php?mod=editnews&amp;act=">Add newtopics</a></li>
							<li><a href="admin.php?mod=editnews&amp;act=edit">Edit newtopics</a></li>
							<li><a href="admin.php?mod=editnews&amp;act=del">Del newtopics</a></li>
							<li><a href="admin.php?mod=tt">Cấu Hình ?</a></li>
							<li class="last"><a href="admin.php?mod=editnews&amp;act=">Cau hinh newtopic</a></li>
						</ul>
					</div>
					<!-- ********* Cau hinh user ****** -->
					<div id="edituser" class="tab-pane fade">
						<h3>Chức năng</h3>
						<ul class="nav">
							<li><a href="admin.php?mod=edituser&amp;act=">Cấu Hình tab5</a></li>
							<li><a href="admin.php?mod=edituser&amp;act=">Cấu hình Chức năng</a></li>
							<li><a href="admin.php?mod=edituser&amp;act=">cau hinh ?</a></li>
							<li class="last"><a href="admin.php?mod=edituser&amp;act=">Cấu Hình ?</a></li>
						</ul>
					</div>
					
				</div>
			</div>
			<!--			
			<div style="width:70%;float: left;">
				<div id="center-column">
					
					<div class="top-bar">
						<h1>Contents</h1>
					</div><br>
				  <div class="select-bar"></div>
					<div class="table">
						<center>
							Để <b>file</b> có thể ghi : Vui lòng sử dụng chương trình <a href="http://filezilla-project.org/download.php" target="_blank"><b>FileZilla</b></a> chuyển <b>File permission</b> sang <b>666</b><br>
							Để <b>thư mục</b> có thể ghi : Vui lòng sử dụng chương trình <a href="http://filezilla-project.org/download.php" target="_blank"><b>FileZilla</b></a> chuyển <b>File permission</b> sang <b>777</b><br>
							<img src="images/chmod.jpg">
						</center>
					</div>
					
				</div>
			</div>
			-->	
		<!-- Chen footer 
		
			<div style="width:15%;float: left;">
				<div id="right-column">
					<strong class="h">INFO</strong>
					<div class="box">Detectand eliminate viruses and Trojan horses, even new and unknown ones.Detect and eliminate viruses and Trojan horses, even new and </div>
				</div>
			</div>
		
		</div>
		
	</div>
</div>

<!-- --------------------footer--------------------- --
<div id="footer"> 
	<div id="bttop" style="display: block;">BACK TO TOP</div>	
	Copyright © 2015 &nbsp; <a href="mailto:jono AT jonobacon DOT org">Jono Bacon</a>
</div>

<!--
<script type="text/javascript">
	$(document).ready(function() {
		 //var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/")+1);
		 //$("#cssmenu ul li a").each(function(){
			 // if($(this).attr("href") == pgurl || $(this).attr("href") == '' )
			//  $(this).addClass("active");
		// })
		
			
		var url = new String(window.location);
		url =  url.substring(url.lastIndexOf("/")+1);
		alert(url);
		/*<?php
			//if(isset($_GET['mod'])){
			//	$kd =$_GET['mod'];
				//echo "bat mod php: " . $kd;
				//}
		?>
		/*< ? b php echo ==  < ? = * /
*/	
		<?php //if(isset($_GET['mod'])){
			?>
			var mod = "<?php// echo $_GET['mod']?>"; 
			mod = "#"+mod;
			alert(mod);
			
			//$(".content div").hide(); //Hide all content
			//$("#cssmenu li").attr("class",""); //Reset id's
			//$(this).parent().attr("class","active"); // Activate this
			//$('.' + $(this).attr('name')).fadeIn();
			
			$("#cssmenu li").removeClass('active');
			$("#cssmenu li").find("a[href='"+mod+"']").parent().addClass('active');
			
			
			
		<?php
		//}
		//else{
		?>
			//mod = "admin.php?mod=editconfig;
			//$("#cssmenu li").removeClass('active');
			//$("#cssmenu li").find("a[href='"+mod+"']").parent().addClass('active');
		<?php //} ?>
	});
</script>
--

</body>
<html>
-->
<?php
	//}
	?>