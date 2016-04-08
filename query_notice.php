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
 * Date: 16/4/4
 * Time: 21:47
 */



require_once ("SqlUtiles.php");
if(empty($_GET['from_id'])||empty($_GET['to_id'])){
    echo "<script>alert('您好，查看消息用户不能为空！');parent.location.href='index.php'; </script>";
    exit;
}

$util=new SqlUtils();
$res=$util->query_notice($_GET['to_id'],$_GET['from_id'],2,0);

echo "<p>发送者:$_GET[from_name]</p>";
foreach ($res as $re) {
    echo "<label>消息是:</label> $re[comment]";
}

?>
<h3>Send Notice:</h3>
<form action="add_notice.php" method="post">
    <?php
    echo "<input type='hidden' name='to_id' value='$_GET[from_id]'>";
    echo "<input type='hidden' name='from_id' value='$_GET[to_id]'>";
    ?>
    <div><textarea rows="20" cols="70" name="notice"></textarea></div>
    <div style="margin-left: 160px;margin-top: 20px;"><input type="submit" value="Send"></div>

</form>
