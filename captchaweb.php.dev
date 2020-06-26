<?php
include('core/init.php');

require_once MODULE_ADM . '/core/captcha/phptextClass.php';
//echo MODULE_ADM .'/core/captcha/phptextClass.php'; die();
$phptextObj = new phptextClass();
$phptextObj->path_Url = MODULE_ADM;
$phptextObj->nameSession = 'captcha_web';

$phptextObj->phpcaptcha('#fff', '#328ae4', 134, 30, 5, 30);
