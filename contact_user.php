

<style>
    .div{
        text-align: right;

    }
    a{
        margin-right: 20px;
        text-decoration: none;
    }
</style>
<div class="div">
    <a href="index.php">Home</a>
</div>
<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 16/4/5
 * Time: 00:14
 */


require_once ("SqlUtiles.php");

if(!empty($_POST['notice'])){
    $util=new SqlUtils();
    $util->insert_notice([$_POST['from_id'],$_POST['to_id'],$_POST['notice'],time(),0]);
    header("Location:index.php");
    exit;
}
?>
<h3>Send Notice:</h3>
<form action="contact_user.php" method="post">
    <?php
    echo "<input type=\"hidden\" name=\"to_id\" value='$_GET[u_id]'>";
    echo "<input type=\"hidden\" name=\"from_id\" value='$_COOKIE[user_id]'>";
    ?>
    <div><textarea rows="20" cols="70" name="notice"></textarea></div>
    <div style="margin-left: 160px;margin-top: 20px;"><input type="submit" value="Send"></div>

</form>
