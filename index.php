<html>
<head>
    <title>Super LinkedIn</title>
    <link rel="stylesheet" type="text/css" href="css/index2.css"/>
    <link rel="stylesheet" type="text/css" href="css/semantic.min.css"/>
</head>
<body>
    <div class="ui fixed menu">
        <div class="header item">Super LinkedIn</div>
        <div class="right menu">
            <div class="item">
                <form method="post" action="index.php" id="header_form">
                <div class="ui transparent icon input">
                    <i class="search icon"></i>
                    <?php
                        if(!isset($_POST['key'])){
                            $_SESSION['key']='';
                        }
                        else{
                            $_SESSION['key']=$_POST['key'];
                        }
                            echo "<input type='text' placeholder='Search' name='key' value='$_SESSION[key]'><input type='submit' style='position: absolute; left: -9999px'>";
                    ?>
                </div>
                </form>
            </div>
            <a class="item" href="logout.php">Logout</a>
        </div>
    </div>
    <div id="main_content">
        <div class="ui two column grid" style="position: relative">
            <div class="column" id="welcome">
                <h1>Welcome!</h1>
                <div class="content">
                    You're currently logged in as
                    <?php
                        switch($_COOKIE['role_type']) {
                            case 1:
                                echo "an admin.";
                                break;
                            case 2:
                                echo "a user.";
                                break;
                            case 3:
                                echo "a company.";
                                break;
                        }
                    ?>
                </div>
            </div>
            <div class="column">
                <h3 class="ui dividing header">Your Tools</h3>
                    <ul class="ui list">
                        <?php
                        switch($_COOKIE['role_type']) {
                            case 1: // admin
                               echo '<div class="item">';
                                echo '<i class="right triangle icon"></i>';
                                echo '<a class="content" href="data_visualization.php">Visualize site data</a>';
                                echo '</div>';
                                break;
                            case 2: // user
                                echo '<div class="ui basic segment" id="company_messages_empty" style="color: grey; font-size: 15px; font-weight: bold">';
                                echo 'No tools to show.';
                                echo '</div>';
                                break;
                            case 3: // company
                                echo '<div class="item">';
                                echo '<i class="right triangle icon"></i>';
                                echo '<a class="content" href="add_job.html">Add a job</a>';
                                echo '</div>';
                                break;
                        }
                        ?>
                    </ul>
            </div>
        </div>

<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 16/4/2
 * Time: 10:25
 */
require_once ("SqlUtiles.php");

if(empty($_COOKIE['user_id'])){
    header("Location: login.html");
}

if(!empty($_COOKIE['role_type'])){
    $utils=new SqlUtils();
    $key='';
    if(!empty($_POST['key'])){
        $key=$_POST['key'];

    }
    $res=$utils->query_by_type($_COOKIE['user_id'],$_COOKIE['role_type'],$key);
    switch($_COOKIE['role_type']){
        case 1: // Admins(?)
        ?>
            <div class="ui one column grid">
                <div class="column">
                <div class="row">
                    <h3 class="ui dividing header">User complaints</h3>
                    <?php
                        if(!empty($res['complain'])){
                            foreach($res['complain'] as $r){
                                $user=$res['user'];
                                $u_id=$r['u_id'];
                                $user_name=$user[$u_id];
                                $com=$res['com'];
                                $c_id=$r['com_id'];
                                $com_name=$com[$c_id];
                                echo"<div>Time: <strong>$r[com_date]</strong> complainer:<strong>$user_name[user_name]&nbsp; &nbsp; &nbsp;</strong> Complaineed:  &nbsp; &nbsp; &nbsp;<strong>$com_name[com_name]</strong><div><label>Content:</label><textarea rows='20' cols='70'>$r[content]</textarea></div></div>";
                            }
                        } 
                        if(isset($res['complain'])) {
                            echo '<div class="ui basic segment" id="company_messages_empty" style="color: grey; font-size: 15px; font-weight: bold">';
                            echo 'No complaints.';
                            echo '</div>';
                        }
                    ?>
                <div>
                <div class="row">
                    <h3 class="ui dividing header">Admin actions</h3>
                    <div class="ui relaxed two column grid">
                        <div class="column">
                            <h3 class="ui header">Registered users</h3>
                            <form method='post' action='delete_user.php'>
                            <div class="ui relaxed two column grid">
                                <div class="column">
                                    <?php
                                    if(empty($res['user'])) {
                                        echo '<div class="ui basic segment" id="company_messages_empty" style="color: grey; font-size: 15px; font-weight: bold">';
                                        echo 'No users registered.';
                                        echo '</div>';
                                    } else {
                                        foreach($res['user'] as $r){
                                            echo "<input type='checkbox' name='com_id[]' value='$r[id]'><label>$r[user_name]</label></input><br>";
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="middle aligned column">
                                    <input class="ui red button" type='submit' value="Remove"/>
                                </div>
                            </div>
                            </form>
                        </div>
                        <div class="column">
                            <h3 class="ui header">Registered companies</h3>
                            <form method='post' action='delete_com.php'>
                            <div class="ui relaxed two column grid">
                                <div class="column">
                                    <?php
                                    if(empty($res['com'])) {
                                        echo '<div class="ui basic segment" id="company_messages_empty" style="color: grey; font-size: 15px; font-weight: bold">';
                                        echo 'No companies registered.';
                                        echo '</div>';
                                    } else {
                                        foreach($res['com'] as $r){
                                            echo "<input type='checkbox' name='com_id[]' value='$r[id]'><label>$r[com_name]</label></input><br>";
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="middle aligned column">
                                    <input class="ui red button" type='submit' value="Remove"/>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <?php
            break;
        case 2: // Users(?)
        ?>
            <div class="ui three column relaxed grid">
                <div class="column">
                    <div class="row">
                        <h3 class="ui dividing header">Friends</h3>
                        <ul>
                        <?php
                        if(isset($res['fri'])) {
                            echo '<div class="ui basic segment" id="company_messages_empty" style="color: grey; font-size: 15px; font-weight: bold">';
                            echo 'No friend requests.';
                            echo '</div>';
                        } else {
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
                        }
                        ?>
                        </ul>
                    </div>
                    <div class="row">
                        <h3 class="ui dividing header">Company Messages</h3>
                        <ul>
                        <?php
                        if(isset($res['fri'])) {
                            echo '<div class="ui basic segment" id="company_messages_empty" style="color: grey; font-size: 15px; font-weight: bold">';
                            echo 'No company messages.';
                            echo '</div>';
                        } else {
                            foreach ($res['c_u'] as $r) {
                                echo "<li value='$r[from_id]'>$r[content]";
                            }
                        }
                        ?>
                        </ul>
                    </div>
                </div>
                <div class="column">
                    <h3 class="ui dividing header">Available Jobs</h3>
                    <div class="ui list">
                    <?php
                        foreach($res['job'] as $r) {
                            echo '<div class="item">';
                            echo '<i class="right triangle icon"></i>';
                            echo '<a class="content" href="job_detail.php?c_id='.$r[c_id]."&j_id=".$r[id].'">';
                            echo $r[w_name];
                            echo '</a>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="column">
                    <h3 class="ui dividing header">People You May Know</h3>
                    <ul>
                    <?php
                    if(isset($res['not_fri'])) {
                        echo '<div class="ui basic segment" id="company_messages_empty" style="color: grey; font-size: 15px; font-weight: bold">';
                        echo 'No results.';
                        echo '</div>';
                    } else {
                        foreach ($res['not_fri'] as $r) {
                            echo "<li value='$r[u_id]'>$r[real_name]";
                            echo "<a href='add_friend.php?to_id=$r[u_id]' class='left-dis'>Add</a></li>";
                        }
                    }
                    ?>
                    </ul>
                </div>
            </div>
        <?php
            break;
        case 3: // Companies
        ?> 
            <div class="ui two column relaxed grid">
                <div class="column">
                    <h3 class="ui dividing header">Open Applications</h3>
                    <div class="ui list">
                        <?php
                        foreach($res['user'] as $r) {
                            echo '<div class="item">';
                            echo '<i class="right triangle icon"></i>';
                            echo '<a class="content" href="user_detail.php?u_id='.$r[u_id]."&c_id=".$_COOKIE[user_id].'">';
                            echo $r[real_name]." / ".$r[w_name];
                            echo '</a>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="column">
                    <h3 class="ui dividing header">User Messages</h3>
                    <ul class="ui list">
                        <?php
                        if(isset($res['u_c'])) {
                            echo '<div class="ui basic segment" id="company_messages_empty" style="color: grey; font-size: 15px; font-weight: bold">';
                            echo 'No messages.';
                            echo '</div>';
                        } else {
                            foreach($res['u_c'] as $r) {
    
                                echo '<li value="'.$r[from_id].'">'.$r[content].'</li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        <?php
            break;
    }
}

?>
    </div>
</body>
</html>
