<?php
require_once __DIR__ . '/Utils/captcha/PhpTextCaptcha.php';

// Create class object
$phpTextObj = new PhpTextCaptcha();

$type = isset($_GET['page']) ? $_GET['page'] : '';
switch ($type) {
    case "web":
    {
        include(__DIR__ . '/core/init.php');
        $phpTextObj->nameSession = 'captcha_web';
        break;
    }
    case "admin":
    {
        include(__DIR__ . '/admin/core/init_admin.php');
        $phpTextObj->nameSession = 'captcha_code';
        break;
    }
    default:
}

$phpTextObj->path_Url = __DIR__ . '/Utils/captcha';

//    if (isset($_GET['cap']) && $_GET['cap'] == 'web') {
//        $phpTextObj->nameSession = 'captcha_web';
//    } else {
//        $phpTextObj->nameSession = 'captcha_code';
//    }

//if (isset($_GET['page']) && $_GET['page'] == 'web') {
//    $phpTextObj->nameSession = 'captcha_web';
//} else {
//    $phpTextObj->nameSession = 'captcha_code';
//}

$phpTextObj->phpCaptcha('#fff', '#328ae4', 134, 30, 5, 30);
