

<style>
    body{
        margin: 0px;
        padding:0px;
        margin-left: 10px;
        margin-right: 10px;
    }
    h1{
        text-align: center;
        margin-top: 20px;

    }
    h3{
        text-align: left;
    }
    input[type='checkbox']{
        margin-left: 10px;
    }
    a:hover{
        cursor: pointer;
        text-decoration: none;
    }
    input[type='text']{
        width: 25%;
        height:30px;
    }
    .right{
        text-align: right;
    }
    .right :hover{
        text-decoration: none;
    }
    a{
        text-decoration: none;
    }
    label{
        margin-left: 3px;
        /*background-color: aquamarine;*/
        /*border: 1px solid wheat;*/
    }
    .left{
        float: left;
        border: 1px solid olivedrab;
        width: 20%;
        height:300px;
        /*background-color: red;*/
    }
    .not-fri{
        float: right;
        border: 1px solid;
        width: 20%;
        height: 300px;
    }
    .center{
        float: left;
        border: 1px solid;
        width: 50%;
        margin-left: 5%;
        height: 300px;
    }
    .left-dis{
        margin-left: 30px;
        line-height: 20px;
    }

</style>

<div class="right">
    <?php
    session_start();
        if(!empty($_COOKIE['role_type'])&&$_COOKIE['role_type']==3){
            echo "<h4><a href=\"add_job.html\">Add job</a> | ";
        }


    ?>
    <a href="logout.php">Logout</a></h4>
</div>
<h1>Home page</h1>
<h3>Search</h3>
<form method="post" action="index.php">
    <?php
    if(!isset($_POST['key'])){
        $_SESSION['key']='';
    }
    else{
        $_SESSION['key']=$_POST['key'];
    }
        echo "<input type='text' name='key' value='$_SESSION[key]'><input type='submit' value='Search'>";
    ?>
</form>

<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 16/4/2
 * Time: 10:25
 */
require_once ("SqlUtiles.php");



if(empty($_COOKIE['user_id'])){
    echo "<h3>You are not currently login. <a href='login.html'>Please login first.</a></h3>";
    exit;
}

if(!empty($_COOKIE['role_type'])){
    $utils=new SqlUtils();
    $key='';
    if(!empty($_POST['key'])){
        $key=$_POST['key'];

    }
    $res=$utils->query_by_type($_COOKIE['user_id'],$_COOKIE['role_type'],$key);
    switch($_COOKIE['role_type']){
        case 1:
            echo "<h4>Admin:</h4><form method='post' action='delete_user.php'>";

            if(!empty($res['user'])){
                foreach($res['user'] as $r){
                    echo "<input type='checkbox' name='user_id[]' value='$r[id]'><label>$r[user_name]</label>";
                }
            }
            echo "<br><input type='submit' value='Remove'></form><h4>Company:</h4><form method='post' action='delete_com.php'>";
            if(!empty($res['com'])){
                foreach($res['com'] as $r){
                    echo "<input type='checkbox' name='com_id[]' value='$r[id]'><label>$r[com_name]</label>";
                }
            }
            echo "<br><input type='submit' value='Remove'></form><h4>Complains:</h4>";
            if(!empty($res['complain'])){
                foreach($res['complain'] as $r){
                    $user=$res['user'];
                    $u_id=$r['u_id'];
                    $user_name=$user[$u_id];
                    $com=$res['com'];
                    $c_id=$r['com_id'];
                    $com_name=$com[$c_id];
                    echo"<div>Time: <strong>$r[com_date]</strong> complainer:<strong>$user_name[user_name]&nbsp; &nbsp; &nbsp;
</strong> Complaineed:  &nbsp; &nbsp; &nbsp;<strong>$com_name[com_name]</strong>
<div>
<label>Content:</label> <textarea rows='20' cols='70'>$r[content]</textarea>
</div></div>";
                }
            }
            break;
        case 2:
            echo "<h4>User</h4>";
            echo "<div class='left'>
<h4>Friend:</h4><ul>";
            foreach($res['fri'] as $r){
                echo "<li value='$r[id]'>$r[user_name]";
                if($r['is_read']==0){
                    echo "<br><a href='query_notice.php?from_id=$r[from_id]&to_id=$_COOKIE[user_id]&from_name=$r[user_name]' class='left-dis'>Watch notice</a>";
                }
                else if($r['is_read']==2){
                    echo "<br>$r[comment]:<a href='is_angree.php?from_id=$r[from_id]&tag=1' class='left-dis'>agree</a><a href='is_angree.php?from_id=$r[from_id]&tag=0' class='left-dis'>reject</a>";
                }

                echo "<br><a href='chat.php?to_id=$r[from_id]&from_id=$_COOKIE[user_id]&to_name=$r[user_name]' class='left-dis'>Send notice</a></li>";
            }
            echo "</ul></div><div class='center'>";

            foreach($res['job'] as $r){
                echo "<a href='job_detail.php?c_id=$r[c_id]&j_id=$r[id]'>$r[w_name]</a> | ";
            }
            echo "</div>";
            echo "<div class='not-fri'><h4>You may known!</h4><ul>";
            foreach ($res['not_fri'] as $r) {
                echo "<li value='$r[u_id]'>$r[real_name]";
                echo "<a href='add_friend.php?to_id=$r[u_id]' class='left-dis'>Add</a></li>";
            }

            echo "</ul></div><div class='left'><h4>The message sent by company:</h4><ul>";
            foreach ($res['c_u'] as $r) {
                echo "<li value='$r[from_id]'>$r[content]";
            }
            echo "</ul></div>";




            break;
        case 3:

            echo "<h4>Company notice</h4>";
//            echo "<div class='left'><h4>Friend:</h4><ul>";
//            foreach($res['fri'] as $r){
//                echo "<li value='$r[u_id]'>$r[real_name]</li>";
//            }
//            echo "</ul></div>";
            echo "<div class='center' style='width: 80%;'>";

            foreach($res['user'] as $r){
                echo "<a href='user_detail.php?u_id=$r[u_id]&c_id=$_COOKIE[user_id]'>$r[real_name]----$r[w_name]</a> | ";
            }

            echo "</div><div class='left'><h4>The message sent by user:</h4><ul>";
            foreach ($res['u_c'] as $r) {
                echo "<li value='$r[from_id]'>$r[content]";
            }
            echo "</div>";

            break;
    }
}

?>


