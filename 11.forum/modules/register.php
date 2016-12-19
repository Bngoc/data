<?php

require("../config.php");
//include('../admin/MyLogPHP.class.php');
//$log = new MyLogPHP('../log/register.log.csv');
session_start();

ini_set('display_errors', 1);
ini_set("display_errors", "/forum/php-error.log");
//error_reporting(E_ERROR | E_WARNING | E_PARSE); 
//$db = mysql_connect($dbhost, $dbuser, $dbpassword);
//mysql_select_db($dbdatabase, $db);

//$Password = stripslashes($Password);
//$Email = mysql_real_escape_string($Email);
//$Password = mysql_real_escape_string($Password);


if(isset($_POST['submit'])) {
		$Username = stripslashes($_POST['username']);
		$Username = mysql_real_escape_string($Username);
		
		$Email = stripslashes($_POST['email']);
		$Email = mysql_real_escape_string($Email);
		
		$Password1 = stripslashes($_POST['password1']);
		$Password1 = mysql_real_escape_string($Password1);
		
		$Password2 = stripslashes($_POST['password2']);
		$Password2 = mysql_real_escape_string($Password2);
	
	if($_POST['password1'] == $_POST['password2']) {
		$checksql = "SELECT * FROM users WHERE username = '" . $Username . "' OR email = '" . $Email . "';";
		//echo $checksql; exit();
		$checkresult = $db->query($checksql);
		$checknumrows = $checkresult->num_rows;
		
		if($checknumrows >= 1) {
			header("Location: " . $config_basedir . "/register.php?error=taken");	
		}
		else {
			for($i = 0; $i < 16; $i++) {
				$randomstring .= chr(mt_rand(32,126));
			}

			$verifyurl = "http://127.0.0.1/forum/verify.php";
			$verifystring = urlencode($randomstring);
			$verifyemail = urlencode($Email);
			$validusername = $Username;

			$sql = "INSERT INTO users(username, password, email, verifystring, active) VALUES('"
				. $Username //$_POST['username']
				. "', '" . $Password1 //$_POST['password1']
				. "', '" . $Email //$_POST['email']
				. "', '" . addslashes($randomstring)
				. "', 0);";
			
			$db->query($sql);
			//$log -> debug(mysql_query($sql),'DB');
			

			//$headers = 'From:noreply@yourwebsite.com' . "\r\n"; // Set from headers
			//mail($to, $subject, $message, $headers); // Send our email
			
			/*
			$mail_body='
			
			Hi $validusername,
			Thanks for signing up!
			Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
			------------------------
			Username: '. $Username'] .'
			Password: '. $Password1 .'
			------------------------

			Please click on the following link to verify you new account:
			$verifyurl?email=$verifyemail&verify=$verifystring
			';
			*/
			
			$mail_body=<<<_MAIL_

Hi $validusername,

Please click on the following link to verify you new account:

$verifyurl?email=$verifyemail&verify=$verifystring

_MAIL_;
			if(mail($Email, $config_forumsname . " User verification", $mail_body)){
			//if(mail($_POST['email'], $config_forumsname . " User verification", $mail_body)){
				echo "send";
			}
			else{
				echo "no send";
			}
			//$logfile = dirname(dirname(__FILE__)) . './log/mail.log';

			require("header.php");
			echo "<center> Thank you for registering! A confirmation email has been sent to <font color='red'>" . $_POST['email'] . "</font>. Please follow the link in the email to validate your account.</center>";
		}
	}
	else {
		header("Location: " . $config_basedir . "/register.php?error=pass");
	}
}
else {
	require("../header.php");
	require('checkuesr_register.php');
	
	switch($_GET['error']) {
		case "pass":
			echo "<center>Passwords do not match!</center>";
		break;

		case "taken":
			echo "<center>Username taken, please use another.</center>";
		break;

		case "no":
			echo "<center>Incorrect login details!</center>";
		break;

	}
?>
	<script type="text/javascript">

		 function checkForm(form){
			/*if(form.username.value == "") {
			  alert("Error: Username cannot be blank!");
			  form.username.focus();
			  return false;
			}*/
			re = /^\w+$/;
			if(!re.test(form.username.value)) {
			  alert("Error: Username must contain only letters, numbers and underscores!");
			  form.username.focus();
			  return false;
			}
			if(form.password1.value == form.username.value) {
				alert("Error: Password must be different from Username!");
				form.password1.focus();
				return false;
			 }
			 /*
			if(form.password11.value != "" && form.password11.value == form.password2.value) {
			  if(form.password1.value.length < 6) {
				alert("Error: Password must contain at least six characters!");
				form.password1.focus();
				return false;
			  }
			  /*
			  if(form.password1.value == form.username.value) {
				alert("Error: Password must be different from Username!");
				form.password1.focus();
				return false;
			  }
			  */
			  /*
			  re = /[0-9]/;
			  if(!re.test(form.password1.value)) {
				alert("Error: password must contain at least one number (0-9)!");
				form.password1.focus();
				return false;
			  }
			  re = /[a-z]/;
			  if(!re.test(form.password1.value)) {
				alert("Error: password must contain at least one lowercase letter (a-z)!");
				form.password1.focus();
				return false;
			  }
			  re = /[A-Z]/;
			  if(!re.test(form.password1.value)) {
				alert("Error: password must contain at least one uppercase letter (A-Z)!");
				form.password1.focus();
				return false;
			  }
			} else {
			  alert("Error: Please check that you've entered and confirmed your password!");
			  form.password1.focus();
			  return false;
			}
			*/
			//alert("You entered a valid password: " + form.password1.value);
			return true;
		  }

	</script>


	<div id="content" class="">
		<form  action="" autocomplete="on" method="POST" onsubmit="return checkForm(this)"> 
			<h1> Register Form</h1> 
			
			<p class="foru"> To register on the <a href ="<?php echo $config_basedir ?>/index.php"><?php echo $config_forumsname; ?> </a> forums, fill in the form below.</p>
			<div style=" text-align: center; ">
			<p> 
				<label class=""  data-icon="u">Your username</label> <!--^[a-zA-Z][a-zA-Z0-9-_\.]{6,20}$  ^[a-zA-Z0-9]{6,20}$  ^[a-z][a-zA-Z0-9]{6,20}$ -->
				<span id="availability_status" class ="valu_status"></span>
				<input title="Username must be between (6,20) characters" name="username" id="username" required="required" pattern="^[a-zA-Z0-9-_\.]{6,20}$" type="text" placeholder="mysuperusername690" />
				
			</p>
			<p> 
				<label  class="" data-icon="e" > Your email</label>
				<span id="avaitatus" class="valu_status"></span>
				<input  title="Email" id="email" name="email" required="required" type="email" placeholder="mysupermail@mail.com"/> 
				
			</p>
			<p> 
				<label class="youpasswd" data-icon="p">Your password </label>
				<input title="Length >7, Password must contain 1 uppercase, lowercase and number" name="password1" id="password" required="required" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" onchange="form.password2.pattern = this.value" type="password" placeholder="eg. X8df!90EO"/>
			</p>
			<p> 
				<label class="youpasswd" data-icon="p">Please confirm your password </label>
				<input title="Please confirm your password" name="password2" id="password" required="required" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" type="password" placeholder="eg. X8df!90EO"/>
			</p>
			</div>
				<div class = "fos" ><input type="submit" name="submit" value="Register"/></div>
				<p class="golin">
				Already a member ?
				<a href="login.php" > Go and log in </a>
				</p>
				
		</form>
	</div>
<?php
}

require("../footer.php");

?>