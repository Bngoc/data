<?php
include('core/init.php');

require_once SERVDIR . '/core/captcha/phptextClass.php';
// Create class object
$phptextObj = new phptextClass();

$phptextObj->phpcaptcha('#fff', '#328ae4', 134, 30, 5, 30);