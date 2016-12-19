<?php

require("header.php");

$verifystring = urldecode($_GET['verify']);
$verifyemail = urldecode($_GET['email']);

$sql = "SELECT id active FROM users WHERE verifystring = '" . $verifystring . "' AND email = '" . $verifyemail . "';";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);

if($numrows == 1) {
	$row = mysql_fetch_assoc($result);
	if($row['active'] == 1) {
        echo "Your account has already been activated.";
	}
    else {
	$sql = "UPDATE users SET active = 1 WHERE id = " . $row['id'];
	$result = mysql_query($sql);

	echo "Your account has now been verified. You can now <a href='login.php'>log in</a>";
	  }
}
else {
	echo "Oops !Your account could not be activated. Please recheck the link or contact the system administrator.";
}

echo $verifystring;

require("footer.php");

?>

