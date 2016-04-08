<style>
    textarea{
        vertical-align: top;
    }
    strong{
        color: saddlebrown;
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
    .employee{
        /*border: 1px solid;*/
        border-radius: 0px 2px;
        display: block;
        width:90px;
        height: 30px;
        line-height: 30px;
        text-decoration: none;
        background-color: lightgoldenrodyellow;
        color: black;
        text-align: center;
    }
</style>
<?php
if(!empty($_COOKIE['role_type'])&&$_COOKIE['role_type']==2){
    echo "<div class='right'><h4><a href=\"contact_user.php?u_id=$_GET[c_id]\">Contact US</a> | <a href=\"index.php\">Home</a>|<a href='add_complain.php?c_id=$_GET[c_id]'>Complain</a>|<a href=\"add_user_info.html\">Add User info</a></h4></div>";
}
?>
<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 16/4/3
 * Time: 01:17
 */
require_once ("SqlUtiles.php");

if(!empty($_GET['j_id'])){
    $util=new SqlUtils();

    $res=$util->query_job_by_id($_GET['j_id']);
    if($res->rowCount()>0){
        $res=$res->fetch();
        echo "<div><span>Job Name:&nbsp;&nbsp;</span> <strong>$res[w_name]</strong>
<br>
Job description: &nbsp;&nbsp;<textarea rows='10' cols='40' disabled>$res[description]</textarea>
<br>
Job Email: &nbsp;&nbsp;<strong>$res[email]</strong>
<br>
Job Tel: &nbsp;&nbsp;<strong>$res[tel]</strong>
<br>

Job Publish Date: &nbsp;&nbsp;<strong>$res[pub_date]</strong>
<br>";
        echo "<a href='employee.php?c_id=$_GET[c_id]' class='employee'>The job you want apply</a>

</div>";
    }
}