<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 16/4/2
 * Time: 23:11
 */

require_once ("SqlUtiles.php");


if(empty($_POST['real_name'])||empty($_POST['w_name'])||empty($_POST['w_space'])||empty($_POST['s_space'])||empty($_POST['s_name'])||empty($_POST['s_s_date'])||empty($_POST['s_e_date'])||empty($_POST['e_w_name'])||empty($_POST['e_w_space'])||empty($_POST['e_s_date'])||empty($_POST['e_e_date'])||empty($_POST['languages'])||empty($_POST['skills'])||empty($_POST['degree'])||empty($_POST['tel'])){
    echo "<script>alert('This part cannot be empty');parent.location.href='add_job.html'; </script>";
    exit;
}
$util=new SqlUtils();
$util->insert_user_info([$_POST['real_name'],$_POST['w_name'],$_POST['w_space'],$_POST['s_space'],$_POST['s_name'],$_POST['s_s_date'],$_POST['s_e_date'],$_POST['e_w_name'],$_POST['e_w_space'],$_POST['e_s_date'],$_POST['e_e_date'],$_POST['languages'],$_POST['skills'],$_POST['degree'],$_POST['tel'],$_COOKIE['user_id']]);

header("Location:index.php");
exit;
?>