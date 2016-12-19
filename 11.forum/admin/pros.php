<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/forum/config.php");
$message=array();
if(isset($_POST['names']) && !empty($_POST['names'])){
    $uname=mysqli_real_escape_string($db,$_POST['names']);
}else{
    $message[]='Please enter username';
}

if(isset($_POST['pwds']) && !empty($_POST['pwds'])){
    $password=mysqli_real_escape_string($db,$_POST['pwds']);
}else{
    $message[]='Please enter password';
}

$countError=count($message);

if($countError > 0){
     for($i=0;$i<$countError;$i++){
              echo ucwords($message[$i]).'<br/><br/>';
     }
}else{
    $query="select * from admins where username='$uname' and password='$password'";

    $res=mysqli_query($db,$query);
    $checkUser= $res->num_rows;
    if($checkUser > 0){
         $_SESSION['ADMIN']=true;
         $_SESSION['ADMIN']=$uname;
         echo 'true';
    }else{
         echo ucwords('please enter correct user details');
    }
}
?>

