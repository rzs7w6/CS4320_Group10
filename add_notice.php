<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 16/4/4
 * Time: 22:04
 */

require_once ("SqlUtiles.php");
if(empty($_POST['notice'])){
    echo "<script>alert('Message cannot be empty');parent.location.href='index.php'; </script>";
    exit;
}

$util=new SqlUtils();

$util->add_friend([$_POST['from_id'],$_POST['to_id'],2,$_POST['notice'],0]);


header("Location:index.php");
exit;