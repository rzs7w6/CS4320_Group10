<style>
    h3{
        text-align: center;
        margin-top: 50px;
    }
</style>


<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 16/4/3
 * Time: 15:42
 */


require_once ("SqlUtiles.php");

if(empty($_GET['to_id'])){
    echo "<script>alert('Add user cannot be empty！');parent.location.href='index.php'; </script>";
    exit;

}

$util=new SqlUtils();
$util->add_friend([$_COOKIE[user_id],$_GET['to_id'],2,$_COOKIE['user_name'].'send you a friend request',2]);
header("Location:index.php");
exit;