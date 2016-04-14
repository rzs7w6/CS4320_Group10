

<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 16/4/2
 * Time: 23:10
 */

require_once ("SqlUtiles.php");


if(empty($_POST['w_name'])||empty($_POST['description'])||empty($_POST['tel'])||empty($_POST['email'])||empty($_POST['pub_date'])){
    echo "<script>alert('This part cannot be empty！');parent.location.href='add_job.html'; </script>";
    exit;
}
$util=new SqlUtils();
$util->insert_com_work([$_POST['email'],$_POST['w_name'],$_POST['description'],$_POST['tel'],$_POST['pub_date'],$_COOKIE['user_id']]);

header("Location:index.php");
exit;
?>