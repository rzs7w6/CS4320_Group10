



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

require_once ("SqlUtiles.php");





if(empty($_POST['content'])&&isset($_GET['u_id'])){
    echo "<script>alert('Complaint cannot be empty！');parent.location.href='add_complain.php?c_id=$_POST[c_id]&u_id=$_POST[u_id]'; </script>";
    exit;
}
else if(!empty($_POST['content'])){
    $util=new SqlUtils();
    $util->insert_complain([$_POST['c_id'],$_POST['u_id'],$_POST['content'],time(),0]);
    header("Location:index.php");
    exit;
}



?>


<h3>Complain:</h3>
<form action="add_complain.php" method="post">
    <?php
    echo "<input type=\"hidden\" name=\"c_id\" value='$_GET[c_id]'>";
    echo "<input type=\"hidden\" name=\"u_id\" value='$_COOKIE[user_id]'>";
    ?>
<div><textarea rows="20" cols="70" name="content"></textarea></div>
<div style="margin-left: 160px;margin-top: 20px;"><input type="submit" value="Complain"></div>


