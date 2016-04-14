<style>
    h3{
        margin-top: 50px;
        color: red;
        text-align: center;
    }
</style>


<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 16/4/2
 * Time: 20:20
 */

require_once ("SqlUtiles.php");



if(empty($_POST['user_name'])||empty($_POST['password'])){
    echo "<script>alert('User ID and password cannot be empty');parent.location.href='login.html'; </script>";
    exit;
}

$util=new SqlUtils();
$res=$util->query_login($_POST['user_name'],$_POST['password'],$_POST['type']);
if($res){
    header("Location:index.php");
    exit;
}

echo "<script>alert('User ID or password are wrong, please try again');parent.location.href='login.html'; </script>";
exit;

?>