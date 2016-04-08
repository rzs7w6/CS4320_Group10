


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
    <?php
    echo "<a href=\"contact_user.php?u_id=$_GET[u_id]\">Send notice</a> | <a href=\"index.php\">Home</a>";
    ?>
</div>

<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 16/4/4
 * Time: 23:49
 */


require_once ("SqlUtiles.php");

if(empty($_GET['u_id'])){
    if(empty($_POST['user_name'])||empty($_POST['password'])){
        echo "<script>alert('User ID cannot be empty');parent.location.href='index.php'; </script>";
        exit;
    }
}

$util=new SqlUtils();

$res=$util->query_user_info($_GET['u_id']);

if($res->rowCount()>0){


    $res=$res->fetch();
    echo "<div>User Name <input type='text' name='real_name' value='$res[real_name]'></div>";
    echo "<div>Job Name <input type='text' name='w_name' value='$res[w_name]'></div>
        <div>Job space <input type='text' name='w_space' value='$res[w_space]'></div>
        <div>School space <input type='text' name='s_space' value='$res[s_space]'></div>
        <div>School Name <input type='text' name='s_name' value='$res[s_name]'></div>
        <div>School Start date <input type='date' name='s_s_date' value='$res[s_s_date]'></div>
        <div>School End date <input type='date' name='s_e_date' value='$res[s_e_date]'></div>
        <div>Experience Job name <input type='text' name='e_w_name' value='$res[e_w_name]'></div>
        <div>Experience Job Space <input type='text' name='e_w_space' value='$res[e_w_space]'></div>
        <div>Experience Start date <input type='date' name='e_s_date' value='$res[e_s_date]'></div>
        <div>Experience end date <input type='date' name='e_e_date' value='$res[e_e_date]'></div>
        <div>Languages";

    if($res['languages']=='english'){
        echo "<input type='languages' name='e_e_date' value='english'>";
    }
    else
    {
        echo "<input type='languages' name='e_e_date' value='chinese'>";
    }


    echo "</div><div>Degree";

    if($res['degree']=='below college'){
        echo "<input  name='degree' value='below college'>";
    }
    else if($res['degree']=='undergradute'){
        echo "<input  name='degree' value='undergradute'>";
    }
    else if($res['degree']=='Master'){
        echo "<input  name='degree' value='Master'>";
    }
    else{
        echo "<input  name='degree' value='Phd'>";
    }


        echo "</div><div>Skills <textarea rows='20' cols='70' name='skills'>$res[skills]</textarea></div>";

        echo "<div>Telphone <input type='tel' name='tel' value='$res[tel]'></div>";

}
else{
    header("Location:add_user_info.html");
    exit;
}