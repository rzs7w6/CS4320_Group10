


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
 * Time: 22:11
 */

require_once ("SqlUtiles.php");
if(empty($_GET['from_id'])||empty($_GET['to_id'])){
    echo "<script>alert('Message cannot be empty');parent.location.href='index.php'; </script>";
    exit;
}


$util=new SqlUtils();

echo "<p>发送给:$_GET[to_name]</p>";

?>
<h3>Send Notice:</h3>
<form action="add_notice.php" method="post">
    <?php
    echo "<input type=\"hidden\" name=\"to_id\" value='$_GET[from_id]'>";
    echo "<input type=\"hidden\" name=\"from_id\" value='$_GET[to_id]'>";
    ?>
    <div><textarea rows="20" cols="70" name="notice"></textarea></div>
    <div style="margin-left: 160px;margin-top: 20px;"><input type="submit" value="Send"></div>

</form>
