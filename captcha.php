<?php

include('core/init.php');

require_once SERVDIR . '/core/captcha/phptextClass.php';
/*create class object*/
$phptextObj = new phptextClass();

$phptextObj->path_Url = SERVDIR;
if (isset($_GET['cap']) && $_GET['cap'] == 'web') {
    $phptextObj->nameSession = 'captcha_web';
} else {
    $phptextObj->nameSession = 'captcha_code';
}

$phptextObj->phpcaptcha('#fff', '#328ae4', 134, 30, 5, 30);

?>