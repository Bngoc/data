<?php
include_once("security.php");
session_start();

require_once("../config.php");
require('../includes/functions.php');


if(isset($_SESSION['ADMIN']) == FALSE) {
	header("Location: " . $config_basedir . "/admin.php?ref=div");
}


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/forum/js/jquerys/jquery-2.1.0.min.js"></script>

<script src="/forum/js/jquerys/jquery-1.10.2.js"></script>
  <script src="/forum/js/jquerys/jquery-ui.js"></script>
  
<script type="text/javascript" src="/forum/js/jquerys/clock.js"></script>  
 <!--script type="text/javascript" src="js/jquery.min.js"></script-->  
<script type='text/javascript'>$(function(){$(window).scroll(function(){if($(this).scrollTop()!=0){$('#bttop').fadeIn();}else{$('#bttop').fadeOut();}});$('#bttop').click(function(){$('body,html').animate({scrollTop:0},200);});});</script>

<link rel="stylesheet" href="/forum/css/stylede.css" type="text/css" />
<!-link rel="stylesheet" href="/forum/css/jquery-ui.css" type="text/css" /-->


</head>
<body>

<!--div class ="comment-reply">
	<div class="comment-inputs">
		<div class="comment-inputs-1">
			<label for="" class="screen-reader-text">TiĂªu Ä‘á»:*</label>
			<input type="text" class="infontitle" id="" name="" disabled="disabled">
			<span id="errorTitle" style="display: none;">*</span>
			 
		</div>
		<div class="comment-inputs-2">
			<label for="" class="screen-reader-text">ÄĂ¡nh giĂ¡:*</label>
			<textarea id="" cols="50" rows="10" name="" disabled="disabled"></textarea>
			<span id="errorDes" style="display: none;">*</span>
			
		</div>
		
		<small id="lblMessage2"></small>
		<small>(*)ThĂ´ng tin báº¯t buá»™c pháº£i nháº­p</small>
		
		<a style="text-decoration: none; display: block;" onClick="CheckSaveComment()" id="btnReview" class="btn_b">ÄĂ¡nh giĂ¡</a>
		<a style="text-decoration: none; display: block;" onClick="DeleteField()" id="btnDelete" class="btn_b">Nháº­p láº¡i</a>  
		<a id="btnLogin" style="text-decoration: block;" class="btn_b" href="dbsvs">ÄÄƒng nháº­p</a>
	</div>
</div>
<!-- --------------------------------------------------------------- -->
<!--div class="clearfloat"></div>
<div class="headtab">
	<ul class="tabs">
		<li><a href="javascript:void(0)" class="setupbn1 active" rel="">Thông tin sản phẩm</a></li>                                
		<li><a href="javascript:void(0)" class="setupbn2" rel=""> Quy định đổi trả hàng</a></li>
	</ul>
</div-->
								
<script>
	$(".setupbn1").click(function() {
		$(".setupbn1").addClass("active");
		$("#tab1").css('display','block');
		$("#tab2").css('display','none');
		$(".setupbn2").removeClass("active");
	});
	$(".setupbn2").click(function() {
		$(".setupbn2").addClass("active");
		$("#tab1").css('display', 'none');
		$("#tab2").css('display', 'block');
		$(".setupbn1").removeClass("active");
	});
</script>
								
<!--div id="tab1" style="display: block;">
	<div class="detail-content">
		<p> ffffffffffffffffffffffffffffffff</p>
	</div>
</div>

<div id="tab2" style="display: block;">
	<div class="return_pd">
		<p> gggggggggggggggggggggggggggg</p>
	</div>
</div>

<div class="clearfloat"></div>
<!----------------------------------------------------------------- -->
<!--div class="wrap-color"><a id="default" style="cursor: pointer;" onClick="getColorImages()" class="activecolor"><img width="20px" height="20px" src="http://localhost/chon.vn/images/imgcontent/s1.3.jpg"></a></div>

<div style="" rel="default" class="divsize">
	<a onClick="getSizeActive('L','default',20);" class="size activesize" title="L-default" style="" rel="20">L</a>
	<a onClick="getSizeActive('M','default',20);" class="size" title="M-default" style="" rel="20">M</a>
	<a onClick="getSizeActive('S','default',20);" class="size" title="S-default" style="" rel="20">S</a>
	<a onClick="getSizeActive('XL','default',20);" class="size" title="XL-default" style="" rel="20">XL</a>
</div>
<div class="clearfloat"></div>

<!----------------------------------------------------------------- -->

<!--div class="Share">
	<p>Chia sẻ:</p>
	<p>
		<a rel="nofollow" class="facebook" onClick="window.open('http://www.facebook.com/share.php?u='+document.location,'_blank');" style="cursor: pointer;" title="Đăng lên Facebook"></a> 
		<a rel="nofollow" class="twitter" onClick="window.open('http://twitter.com/home?status='+document.location,'_blank');" style="cursor: pointer;" title="Đăng lên Twitter"> </a>
		<a rel="nofollow" class="googleplus" onClick="window.open('https://plus.google.com/share?url='+document.location,'_blank');" title="Đăng lên googleplus"></a>
	</p>
</div>
				
<div class="fb-like fb_iframe_widget" data-width="390" data-href="http://www.facebook.com/www.chon.vn/" style="float: right; overflow:inherit;" data-layout="standard" data-action="like" data-show-faces="true" data-share="flase"></div-->



<!----------------------------------------------------------------- -->
<div class="clearfloat"></div>

	<div class="contai" style="">
		
		<div class="tieude">
			<h1>Multi_Del</h1>
			<div align="left" class="">
				<h2 align="justify" class="head_h2_two">
				<span href="#">Giấy chứng nhận ĐKKD số 0310257037 do Sở Kế hoạch và đầu tư Thành phố Hồ Chí Minh cấp lần đầu ngày 17/8/2010</span>
			</h2>
			</div>
			<div class="giohethong">
				<!--span id="date-time">Sunday, September 27 2015 | 20:36:57</span>
				<script type="text/javascript">window.onload = date_time('date-time');</script-->
			</div>
		</div>
		
		<div class ="comment_filter">
			<div class="input text filter">
				
				<div id="tabs">
				  <ul>
					<li><a href="#mod=tabs-1">Categoris</a></li>
					<li><a href="#tabs-2">Forums</a></li>
					<li><a href="#tabs-3">Topics</a></li>
					<li><a href="#tabs-4">Messages</a></li>
					<li><a href="#tabs-5">User</a></li>
				  </ul>
				  <!--          Tabs 1 -------->
				  <div id="tabs-1">
					<div id="" class ="left_forums">
						<div class="col_1">
						<form name="form1" method="post" action="">
						<div class ="tieude formapa">
							<span><input class="checkbx" name="checkbox[]" type="checkbox" id="checkbox[]" value=""></span>
							<span class ="cotid"> ID </span>
							<span class="cotname">Name</span>
						</div>
							<ul class="navgray">
								<?php
								$catsql = "SELECT * FROM categories;";
								$catresult =$db->query($catsql);
								if($catresult ->num_rows==0){
									echo"
										<font style='color:red'>Non-Object!</font>
									";
								}
								else{
									while($catrow = $catresult->fetch_assoc()) {
										//echo $catrow['name']; exit();
								?>
								 <li>
									<input name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $catrow['id']; ?>">
									<span class ="cotid"><?php echo $catrow['id'];?></span>
									<span class="cotname"><?php echo $catrow['name']; ?></span>
									<!--a class="dm_a" href="#" title="Áo kiểu" target="_self">Áo kiểu</a-->
								 </li>
								 <?php 
								 }
								}
								 ?>
								 
							</ul>
						</form>
						 </div>
					</div>
				  </div>
				  <!--          Tabs 2 -------->
				  <div id="tabs-2">
					<div id="" class ="left_forums">
						<div class="col_1">
							<div class="tieude">
								<span style="text-algin:center;"><strong>CATAGORIS</strong> </span>
								<span>
									<select style="width:150px" id="mySelect" name="mySelect" class="cmuc"> <!-- onchange="showUser(this.value)" -->
										<option value="0">--Select--</option>
										<?php 
										//$catsql1 = "SELECT * FROM categories;";
										$catresult1 =$db->query($catsql);
										if($catresult1 ->num_rows==0){
											echo"<font style='color:red'>Non-Object!</font>";
										}
										else{
											
											while($catrow1 = $catresult1 ->fetch_assoc()){
										?>
											<option value="<?php echo $catrow1['id']; ?>"><?php echo $catrow1['name']; ?></option>
										<?php }
										}
										?>										
									</select>
								</span>
								<span style="float:right;"><strong>Delete multiple rows in mysql</strong> </span>
							</div>
							<!--button type="button" onclick="myFunction()">Try it</button><p id="demo"></p-->
							
							<?php 
								$selectOption = $_POST['mySelect'];
								$test = explode('|', $_POST['mySelect']);
								
								//echo $('div.mySelect select').val('val2');
								//$q = intval($_GET['q']); //echo $q;
							?>
							
							<div id="txtHint" class ="sb">
													
							<li>
								<span><input class="checkbx" name="checkbox[]" type="checkbox" id="checkbox[]" value=""></span>
								<span class ="cotid" >ID</span>
								<span class ="cotid">Cat_id</span>
								<span class ="cotname">Name</span>
								<!--span class ="cotdescri">Description</span-->
							</li>
							</div>
								
							<script type="text/javascript">
							
								$(document).ready(function(){
									$(".cmuc").change(function(){
										var id=$(this).val();
										var id = 'id='+ id;
										//alert(cate_name);
										$.ajax({
											type: "POST",
											//url: "fech_select.php",
											url: "fech_select.php",
											data: id,
											cache: false,
											success: function(html)
											{
												$(".sb").html(html);
												//alert("Dang them sub muasam");
											} 
										});
									});
									
									$(".ccmuc").change(function(){
										var id=$(this).val();
										var id = 'id='+ id;
										//alert(cate_name);
										$.ajax({
											type: "POST",
											url: "fech_select_mess.php",
											data: id,
											cache: false,
											success: function(html)
											{
												$(".csb").html(html);
												//alert("Dang them sub muasam");
											} 
										});
									});
									
								});
							</script>
							<!--script type="text/javascript">
								function myFunction(){ //run some code when "onchange" event fires
									var x = document.getElementById("mySelect").value;
									document.getElementById("demo").innerHTML = x;
								}
							</script>
							<script type="text/javascript">
								function showUser(str) {
								  
								  if (str=="") {
									document.getElementById("txtHint").innerHTML="";
									return;
								  } 
								  if (window.XMLHttpRequest) {
									// code for IE7+, Firefox, Chrome, Opera, Safari
									xmlhttp=new XMLHttpRequest();
								  } else { // code for IE6, IE5
									xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
								  }
								  xmlhttp.onreadystatechange=function() {
									if (xmlhttp.readyState==4 && xmlhttp.status==200) {
									  document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
									}
								  }
								  xmlhttp.open("GET","div.php?q="+str,true);
								  xmlhttp.send();
								}
							</script-->
							
							<!--div id="txtHint"><b>Person info will be listed here.</b></div-->
						</div>
					</div>
				</div>
				  <!--          Tabs 3 -------->
				  <div id="tabs-3">
					<div id="" class ="left_forums">
						<div class="col_1">
							<div class="tieude">
									<span style="text-algin:center;"><strong>FORUMS</strong> </span>
									<span>
									<select style="width:150px" id="mySelect" name="" class="ccmuc"> <!-- onchange="showUser(this.value)" -->
										<option value="0">--Select--</option>
										<?php 
										//$catsql = "SELECT * FROM categories;";
										$catresult =$db->query($catsql);
										if($catresult ->num_rows==0){
											echo"<font style='color:red'>Non-Object!</font>";
										}
										else{
											while($catrow = $catresult ->fetch_assoc()){
											?>
											<optgroup label="<?php echo $catrow['name']; ?>">
											<?php
											$catsql1 = "SELECT * FROM forums WHERE cat_id =" . $catrow['id'] . ";";
											$catresult1 =$db->query($catsql1);
											if($catresult1 ->num_rows==0){
												echo"<font style='color:red'>Non-Object!</font>";
											}
											else{
												
												while($catrow1 = $catresult1 ->fetch_assoc()){
											?>
												<option value="<?php echo $catrow1['id']; ?>"><?php echo $catrow1['name']; ?></option>
											<?php 
												}
											}?>
											</optgroup>
											<?php
											}
										}
										?>										
									</select>
									<span>
									<span style="float:right;"><strong>Delete multiple rows in mysql</strong> </span>
								</div>
								
								<div id="txtHint" class ="csb">
													
								<li>
									<span><input class="checkbx" name="checkbox[]" type="checkbox" id="checkbox[]" value=""></span>
									<span class ="cotid" >ID</span>
									<span class ="cotid">Date</span>
									<span class ="cotname">User_Id</span>
									<span class ="cotdescri">Forum_Id</span>
									<span class ="cotdescri">Subject</span>
									<li>
							</div>
								
							</div>
						</div>
				  </div>
					</div>
				  </div>
				  </div>
				  </div>
				  <!--          Tabs 4 -------->
				  <div id="tabs-4">
					<p>tabs 4. </p>
				  </div>
				  <!--          Tabs 5 -------->
				  <div id="tabs-5">
					<p>tabs 5. </p>
				  </div>
				</div>
				<script>
				  $(function() {
					$( "#tabs" ).tabs();
				  });
				  </script>
				
				<!--span id="" class="">Cat</span>
				<span id="" class="">Forums</span>
				<span id="" class="">Topics</span>
				<span id="" class="">Messages</span>
				<span>
				<select enableviewstate="false" style="width:150px" onChange="ChangDropDown()" id="ddlsortExpression" name="">
					<option value="newest">Má»›i nháº¥t</option>										
					<option value="oldest">CÅ© nháº¥t</option>										
					<option value="bestuserratings">ÄĂ¡nh giĂ¡ chung tá»‘t nháº¥t</option>										
					<option value="worstuserratings">ÄĂ¡nh giĂ¡ chung tá»‡ nháº¥t</option>										
					<option value="mosthelpful">ÄĂ¡nh giĂ¡ há»¯u Ă­ch nháº¥t</option>										
					<option value="leasthelpful">ÄĂ¡nh giĂ¡ khĂ´ng há»¯u Ă­ch nháº¥t</option>										
				</select>
				<span-->
				<!--span id="">Forums</span>
				<span>
					<select enableviewstate="false" style="width:150px" onChange="ChangDropDown()" id="ddlsortExpression" name="">
						<optgroup label="Server-side languages">	
							<option value="newest">Má»›i nháº¥t</option>
							<option value="oldest">CÅ© nháº¥t</option>										
							<option value="bestuserratings">ÄĂ¡nh giĂ¡ chung tá»‘t nháº¥t</option>										
							<option value="worstuserratings">ÄĂ¡nh giĂ¡ chung tá»‡ nháº¥t</option>										
							<option value="mosthelpful">ÄĂ¡nh giĂ¡ há»¯u Ă­ch nháº¥t</option>										
							<option value="leasthelpful">ÄĂ¡nh giĂ¡ khĂ´ng há»¯u Ă­ch nháº¥t</option>
							
						</optgroup>
					</select>
				<span-->
				<span id="date-time" class="" style ="float: right;">Sunday, September 27 2015 | 20:36:57</span>
				<script type="text/javascript">window.onload = date_time('date-time');</script>

			
		</div>
		</div>
			<div class ="cstopic" style="background-color:red; height:10px;width: 100%;float: left;">
			</div>
		
	

	<!----------------------------------------------------------------- -->										
	<div class="clearfloat"></div>
	<div id="bttop" style="display: block;">BACK TO TOP</div>											
	 <div class="footer">
		<div class="fcontent">
			<div itemtype="#" itemscope=""><p itemprop="name">Bản quyền &copy; 2012 <a href="#">Chọn.vn</a> - Bản quyền được bảo vệ</p></div>
			<div><p><span>Công ty CPTM Chọn, 339/19 Lê Văn Sỹ, P.13, Q.3</span> &ndash; ĐT:<span> (08) 3526 4733 </span> &ndash; Fax: <span>(08) 3526 4736</span></p></div>
			<p>
				Giấy phép số 49/GP - ICP - STTT cấp ngày 11/06/2012 do sở thông tin truyền thông TP.HCM cấp<br>
				Giấy chứng nhận ĐKKD số 0310257037 do Sở Kế hoạch và đầu tư Thành phố Hồ Chí Minh cấp lần đầu ngày 17/8/2010<br>
				và đăng ký thay đổi lần thứ 4 ngày 12/3/2013.<br><br>
			</p>
		</div>
	</div>
	

<!----------------------------------------------------------------- -->

</body>
</html>