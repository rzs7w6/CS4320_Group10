<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 16/4/3
 * Time: 16:14
 */


require_once ("SqlUtiles.php");


if(empty($_GET['from_id'])){
    echo "<script>alert('User ID cannot be empty！');parent.location.href='index.php'; </script>";
    exit;
}
$util=new SqlUtils();
if($_GET['tag']==0){
    $util->delete_friend([$_GET['from_id'],$_COOKIE['user_id'],2]);

}
else{
    $util->agree_add_friend([$_COOKIE['user_id'],$_GET['from_id'],2,$_COOKIE['user_name']."has approved your firend request"],0);

}
header("Location:index.php");
exit;