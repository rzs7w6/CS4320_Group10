<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 16/4/4
 * Time: 01:12
 */


require_once ("SqlUtiles.php");


if(empty($_POST['user_id'])){
    echo "<script>alert('Your delection cannot be empty');parent.location.href='index.php'; </script>";
    exit;
}
$util=new SqlUtils();

print_r($_POST['user_id']);
exit;
foreach($_POST['user_id'] as $id){
    $util->delete($id);
}
header("Location:index.php");
exit;