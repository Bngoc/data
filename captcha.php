<?php
include('core/init.php');

require_once SERVDIR . '/core/captcha/phptextClass.php';
// Create class object
$phpTextObj = new phptextClass();

$phpTextObj->path_Url = SERVDIR;
if (isset($_GET['cap']) && $_GET['cap'] == 'web') {
    $phpTextObj->nameSession = 'captcha_web';
} else {
    $phpTextObj->nameSession = 'captcha_code';
}

$phpTextObj->phpcaptcha('#fff', '#328ae4', 134, 30, 5, 30);