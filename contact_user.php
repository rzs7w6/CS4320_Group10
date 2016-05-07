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
                    <h1 class="ui dividing header">Contact user</h3>
                    <form action="contact_user.php" method="post">
                    <?php
                        echo "<input type=\"hidden\" name=\"to_id\" value='$_GET[u_id]'>";
                        echo "<input type=\"hidden\" name=\"from_id\" value='$_COOKIE[user_id]'>";
                    ?>
                    <textarea rows="10" cols="94" name="notice"></textarea><br/>
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

if(!empty($_POST['notice'])){
    $util=new SqlUtils();
    $util->insert_notice([$_POST['from_id'],$_POST['to_id'],$_POST['notice'],time(),0]);
    header("Location:index.php");
    exit;
}
?>
</body>
</html>
