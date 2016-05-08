<!DOCTYPE html>
<html>
<head>
    <title>Super LinkedIn</title>
    <link rel="stylesheet" type="text/css" href="css/index2.css"/>
    <link rel="stylesheet" type="text/css" href="css/forms.css"/>
    <link rel="stylesheet" type="text/css" href="css/semantic.min.css"/>
</head>
<body>
    <div class="ui fixed menu">
        <div class="header item">Super LinkedIn</div>
        <div class="right menu">
            <a class="item" href="index.php">Home</a>
            <a class="item" href="logout.php">Logout</a>
        </div>
    </div>
    <div id="main_content">
            <div style="width: 45%; margin: auto auto">
                    <h1 class="ui dividing header" style="text-align: left">Contact administrator</h3>
                    <form action="add_complain.php" method="post">
                        <?php
                        echo "<input type=\"hidden\" name=\"c_id\" value='$_GET[c_id]'>";
                        echo "<input type=\"hidden\" name=\"u_id\" value='$_COOKIE[user_id]'>";
                        ?>
                    <textarea rows="10" cols="94" name="content"></textarea><br/>
                    <input type="submit" class="ui fluid primary button" value="Send"/>
            </form>
            </div>
<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 16/4/5
 * Time: 00:14
 */


require_once ("SqlUtiles.php");


if(empty($_POST['content'])&&isset($_GET['u_id'])){
    echo "<script>alert('Complaint cannot be empty！');parent.location.href='add_complain.php?c_id=$_POST[c_id]&u_id=$_POST[u_id]'; </script>";
    exit;
} else if(!empty($_POST['content'])){
    $util=new SqlUtils();
    $util->insert_complain([$_POST['c_id'],$_POST['u_id'],$_POST['content'],time(),0]);
    header("Location:index.php");
    exit;
}

?>
</body>
</html>
