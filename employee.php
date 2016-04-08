<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 16/4/3
 * Time: 01:39
 */

require_once ("SqlUtiles.php");


$utils=new SqlUtils();
$utils->insert_notice([$_COOKIE['user_id'],$_GET['c_id'],$_COOKIE['user_name']."The job you want",time(),0]);
header("Location:index.php");
exit;