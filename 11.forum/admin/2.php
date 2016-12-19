<?php 
//include_once("security.php");
//include_once($_SERVER['DOCUMENT_ROOT'] . '/forum/config.php');

  //session_start();
  //if(isset($_SESSION['ADMIN']) && !empty($_SESSION['ADMIN'])){
    // header('location:' . $_SERVER['DOCUMENT_ROOT'] . '/forum/admin.php');
  //}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<script type="text/javascript" src="jquery.js"></script>-->
<script type="text/javascript" src="/forum/js/jquerys/jquery-2.1.0.min.js"></script>
<!--<link rel="stylesheet" href="styles.css" type="text/css" />-->
<style>
/* CSS Document */
*{margin:0 auto;padding:0;}
.clearfloat{clear:both;line-height:0;height:0;font-size:1px;}

html {border: 0 none;margin: 0;padding: 0;}
body, div, span, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, code, del, dfn, em, img, q, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, dialog, figure, footer, header, hgroup, nav, section {border: 0 none;font: inherit;margin: 0;padding: 0;vertical-align: baseline;}
h3 {font-size: 1em;line-height: 1;margin-bottom: 1em;text-decoration: none;}

article, aside, details, figcaption, figure, dialog, footer, header, hgroup, menu, nav, section {display: block;}
body {line-height: 1.5;color: #666666;font-family:inherit;font-size: 75%;}
a img {border: none;}
button{margin:0 auto; border:none;}
li, ol, ul{list-style-type:none;}

.clearfix:after, form:after {
	content: ".";
	display: block;
	height: 0;
	clear: both;
	visibility: hidden;
}
.lgtent {
	background: #f9f9f9;
	background: -moz-linear-gradient(top,  rgba(248,248,248,1) 0%, rgba(249,249,249,1) 100%);
	background: -webkit-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
	background: -o-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
	background: -ms-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
	background: linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f8f8f8', endColorstr='#f9f9f9',GradientType=0 );
	-webkit-box-shadow: 0 1px 0 #fff inset;
	-moz-box-shadow: 0 1px 0 #fff inset;
	-ms-box-shadow: 0 1px 0 #fff inset;
	-o-box-shadow: 0 1px 0 #fff inset;
	box-shadow: 0 1px 0 #fff inset;
	border: 1px solid #c4c6ca;
	margin: 20px auto;
	padding: 10px 0 0;
	position: relative;
	text-shadow: 0 1px 0 #fff;
	width: 320px;
	z-index: 1;
}


.lgtent h1 {
	color: #7E7E7E;
	/*font: bold 25px Helvetica, Arial, sans-serif;*/
	letter-spacing: -0.05em;
	line-height: 20px;
	/*margin: 10px 0 30px;*/
	text-align: center;
	font-size: 20px;
}
.lgtent h1:before,
.lgtent h1:after {
	content: "";
	height: 1px;
	position: absolute;
	top: 10px;
	width: 27%;
}
.lgtent h1:after {
	background: rgb(126,126,126);
	background: -moz-linear-gradient(left,  rgba(126,126,126,1) 0%, rgba(255,255,255,1) 100%);
	background: -webkit-linear-gradient(left,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
	background: -o-linear-gradient(left,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
	background: -ms-linear-gradient(left,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
	background: linear-gradient(left,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
    right: 0;
}
.lgtent h1:before {
	background: rgb(126,126,126);
	background: -moz-linear-gradient(right,  rgba(126,126,126,1) 0%, rgba(255,255,255,1) 100%);
	background: -webkit-linear-gradient(right,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
	background: -o-linear-gradient(right,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
	background: -ms-linear-gradient(right,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
	background: linear-gradient(right,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
    left: 0;
}

div#add_err {
    font-size: 15px;
    color: red;
    margin: 20px 0;
}
.lgtent p.foru {
    color: #999;
    font-size: 13px;
    margin: 0 0 10px 0;
    text-align: center;
}
.lgtent p.foru a{
    color: #999;
}

.lgtent p.foru a:hover{
    color: #004a80;
	text-decoration: underline;
}

.lgtent:after,
.lgtent:before {
	background: #f9f9f9;
	background: -moz-linear-gradient(top,  rgba(248,248,248,1) 0%, rgba(249,249,249,1) 100%);
	background: -webkit-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
	background: -o-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
	background: -ms-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
	background: linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f8f8f8', endColorstr='#f9f9f9',GradientType=0 );
	border: 1px solid #c4c6ca;
	content: "";
	display: block;
	height: 100%;
	left: -1px;
	position: absolute;
	width: 100%;
}
.lgtent:after {
	-webkit-transform: rotate(2deg);
	-moz-transform: rotate(2deg);
	-ms-transform: rotate(2deg);
	-o-transform: rotate(2deg);
	transform: rotate(2deg);
	top: 0;
	z-index: -1;
}
.lgtent:before {
	content: attr(data-icon);
	font-family: FontomasCustomRegular;
	-webkit-transform: rotate(-3deg);
	-moz-transform: rotate(-3deg);
	-ms-transform: rotate(-3deg);
	-o-transform: rotate(-3deg);
	transform: rotate(-3deg);
	top: 0;
	z-index: -2;
}
.lgtent form { margin: 0 20px; position: relative }
.lgtent form input[type="text"],
.lgtent form input[type="password"] {
	background: #eae7e7 url("/forum/images/icon/8bcLQqF.png") no-repeat;
}

 
.lgtent form input[type="text"],
.lgtent form input[type="password"] {
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	-ms-border-radius: 3px;
	-o-border-radius: 3px;
	border-radius: 3px;
	-webkit-box-shadow: 0 1px 0 #fff, 0 -2px 5px rgba(0,0,0,0.08) inset;
	-moz-box-shadow: 0 1px 0 #fff, 0 -2px 5px rgba(0,0,0,0.08) inset;
	-ms-box-shadow: 0 1px 0 #fff, 0 -2px 5px rgba(0,0,0,0.08) inset;
	-o-box-shadow: 0 1px 0 #fff, 0 -2px 5px rgba(0,0,0,0.08) inset;
	box-shadow: 0 1px 0 #fff, 0 -2px 5px rgba(0,0,0,0.08) inset;
	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	-ms-transition: all 0.5s ease;
	-o-transition: all 0.5s ease;
	transition: all 0.5s ease;
	border: 1px solid #c8c8c8;
	color: #777;
	/*font: 13px Helvetica, Arial, sans-serif; */
	margin: 0 0 10px;
	padding: 11px 10px 15px 40px;
	width: 100%;
    float: left;
}
.lgtent form input[type="text"]:focus,
.lgtent form input[type="password"]:focus {
	-webkit-box-shadow: 0 0 2px #ed1c24 inset;
	-moz-box-shadow: 0 0 2px #ed1c24 inset;
	-ms-box-shadow: 0 0 2px #ed1c24 inset;
	-o-box-shadow: 0 0 2px #ed1c24 inset;
	box-shadow: 0 0 2px #ed1c24 inset;
	background-color: #fff;
	border: 1px solid #ed1c24;
	outline: none;
}
#username { background-position: 10px 10px !important }
#password { background-position: 10px -53px !important }

.lgtent form input[type="submit"],
.lgtent form input[type="button"] {
	background: rgb(254,231,154);
	background: -moz-linear-gradient(top,  rgba(254,231,154,1) 0%, rgba(254,193,81,1) 100%);
	background: -webkit-linear-gradient(top,  rgba(254,231,154,1) 0%,rgba(254,193,81,1) 100%);
	background: -o-linear-gradient(top,  rgba(254,231,154,1) 0%,rgba(254,193,81,1) 100%);
	background: -ms-linear-gradient(top,  rgba(254,231,154,1) 0%,rgba(254,193,81,1) 100%);
	background: linear-gradient(top,  rgba(254,231,154,1) 0%,rgba(254,193,81,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fee79a', endColorstr='#fec151',GradientType=0 );
	-webkit-border-radius: 30px;
	-moz-border-radius: 30px;
	-ms-border-radius: 30px;
	-o-border-radius: 30px;
	border-radius: 30px;
	-webkit-box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
	-moz-box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
	-ms-box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
	-o-box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
	box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
	border: 1px solid #D69E31;
	color: #85592e;
	cursor: pointer;
	float: right;
	/*font: bold 15px Helvetica, Arial, sans-serif; */
	height: 35px;
	margin: 5px 0 20px 3px;   
	position: relative;
	text-shadow: 0 1px 0 rgba(255,255,255,0.5);
	width: 115px;
}
.lgtent form input[type="submit"]:hover,
.lgtent form input[type="button"]:hover {
	background: rgb(254,193,81);
	background: -moz-linear-gradient(top,  rgba(254,193,81,1) 0%, rgba(254,231,154,1) 100%);
	background: -webkit-linear-gradient(top,  rgba(254,193,81,1) 0%,rgba(254,231,154,1) 100%);
	background: -o-linear-gradient(top,  rgba(254,193,81,1) 0%,rgba(254,231,154,1) 100%);
	background: -ms-linear-gradient(top,  rgba(254,193,81,1) 0%,rgba(254,231,154,1) 100%);
	background: linear-gradient(top,  rgba(254,193,81,1) 0%,rgba(254,231,154,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fec151', endColorstr='#fee79a',GradientType=0 );
}


/* xoa */
.popupf
{
   position: fixed;
   width: 100%;
   opacity: 0.9;
   top:0px;
   min-height:200px;
   height:100%;
   z-index: 100;
   background: rgba(223, 221, 221, 0.63);
   font-size: 20px;
   text-align: center;
   display:none;
   
}
#login_form
{
	/*position:absolute;
	width:300px;
	top:100px;
	left:45%;
	background-color:#DDD;
	padding:10px;
	margin: 25% auto;*/
	border:1px solid #AAA;
	display:block;
	z-index:101;
	-moz-border-radius: 10px;
	-moz-box-shadow: 0 0 10px #aaa;
	-webkit-border-radius: 10px;
	-webkit-box-shadow: 0 0 10px #aaa;
}

/* end xoa */
</style>
<title>Popup Login</title>

<script type="text/javascript">
$(document).ready(function(){
	//$("#login_a").click(function(){
        $("#shadow").fadeIn("normal");
        $("#login_form").fadeIn("normal");
        $("#user_name").focus();
	//});
	$("#cancel_hide").click(function(){
        $("#login_form").fadeOut("normal");
        $("#shadow").fadeOut();
		window.location ='../';
   });
   
   $("#adlogin").click(function(){
    
        username=$("#username").val();
        password=$("#password").val();
         $.ajax({
            type: "POST",
            url: "login.php",
            data: "names="+username+"&pwds="+password,
            success: function(html){
              if(html=='true'){
                //$("#login_form").fadeOut("normal");
				//$("#shadow").fadeOut();
				//$("#profile").html("<a href='logout.php' id='logout'>Logout</a>");
				var location = <?php $_SERVER['DOCUMENT_ROOT'] ?>'/forum/admin.php';
				window.location = location;
              }
			  else{
                    $("#add_err").html("Wrong username or password");
              }
            },
            beforeSend:function(){
                 $("#add_err").html("Loading...")
            }
        });
         return false;
    });
});
</script>

</head>
<body>

	<div style="margin:0 auto;width:100%;">
		<div id="login_form" class="lgtent" >
			<form action="" method="post" autocomplete="on">
				<h1>Login Form</h1>
				<p class="foru"> To log in on the <a href ="<?php echo $config_basedir ?>/index.php" title="<?php echo $config_forumsname ?>"><?php echo $config_forumsname; ?> </a> forums, fill in the form below.</p>
				<div class="err" id="add_err"></div>
				<div style=" text-align: center; ">
					<input type="text" name="username" required ="" title="Username" placeholder="Username" required="" id="username" />
					<input type="password" name="password" required = "" title="Password" placeholder="Password" required="" id="password" />
				</div>
				<div>
					<input type="submit" id="adlogin" title="Log in" name="submit" value="Log in" />
					<input type="button" id="cancel_hide" title="Cancel" value="Cancel" />
				</div>
			</form><!-- form -->
		</div><!-- lgtent -->
	</div>
	<div id="shadow" class="popup"></div>


<!--
	<div id="profile">
    	
	</div>
	
    <div id="login_form">
        <div class="err" id="add_err"></div>
    	<form action="login.php">
			<label>User Name:</label>
			<input type="text" id="user_name" name="user_name" />
			<label>Password:</label>
			<input type="password" id="password" name="password" />
			<label></label><br/>
			<input type="submit" id="login" value="Login" />
			<input type="button" id="cancel_hide" value="Cancel" />
		</form>
    </div>
	<div id="shadow" class="popup"></div>
	-->
</body>
</html>