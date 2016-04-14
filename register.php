<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 16/4/2
 * Time: 21:34
 */

require_once ("SqlUtiles.php");

if(empty($_POST['user_name'])||empty($_POST['password'])||empty($_POST['email'])){
    echo "<script>alert('User ID, password, e-mail address cannot be empty');parent.location.href='register.html'; </script>";
    exit;
}

$util =new SqlUtils();
$res='';
if($_POST['type']==2){
    $res=$util->insert_user([$_POST['user_name'],$_POST['password'],$_POST['email']]);
}else{
    $res=$util->insert_company([$_POST['user_name'],$_POST['password'],$_POST['email']]);

}
if(!$res){
    echo "<script>alert('Regiser failed, please try again');parent.location.href='register.html'; </script>";
    exit;
}
header("Location:login.html");
exit;


?>