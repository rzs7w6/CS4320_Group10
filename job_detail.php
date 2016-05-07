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
<?php
require_once ("SqlUtiles.php");

if(!empty($_GET['j_id'])){
    $util=new SqlUtils();

    $res=$util->query_job_by_id($_GET['j_id']);
    if($res->rowCount()>0){
        $res=$res->fetch();
    }
}

?>
        <div>
            <div class="ui two column grid">
                <div class="column">
                    <h3 class="ui dividing header">Job Information</h3>
                    <form class="ui form">
                    <div class="field">
                        <label>Job Name</label>
                        <?php
                        echo '<input type="text" name="first-name" value="'.$res[w_name].'" disabled class="disabled">';
                        ?>
                    </div>
                    <div class="field">
                        <label>Description</label>
                        <?php
                        echo "<textarea rows='10' cols='40' disabled class='disabled'>$res[description]</textarea>";
                        ?>
                    </div>
                    <div class="field">
                        <label>Email</label>
                        <?php
                        echo '<input type="text" name="first-name" value="'.$res[email].'" disabled class="disabled">';
                        ?>
                    </div>
                    <div class="field">
                        <label>Telephone</label>
                        <?php
                        echo '<input type="text" name="first-name" value="'.$res[tel].'" disabled class="disabled">';
                        ?>
                    </div>
                    <div class="field">
                        <label>Job Publication Date</label>
                        <?php
                        echo '<input type="date" name="first-name" value="'.$res[pub_date].'" disabled class="disabled">';
                        ?>
                    </div>
                    <a href='employee.php?c_id=<?php echo($_GET[c_id]); ?>' class='ui primary fluid button'>Apply for Job</a>
                </div>
                <div class="column">
                    <h3 class="ui dividing header">Your Tools</h3>
                    <ul class="ui list">
                    <?php
                    if(!empty($_COOKIE['role_type'])&&$_COOKIE['role_type']==2) {
                    ?>
                        <div class="item">
                            <i class="right triangle icon"></i>
                            <a class="content" href="index.hp">Return Home</a>
                        </div>
                        <div class="item">
                            <i class="right triangle icon"></i>
                            <a class="content" href="add_job.html">Contact Company</a>
                        </div>
                        <div class="item">
                            <i class="right triangle icon"></i>
                            <a class="content" href="add_job.html">Contact Administrator</a>
                        </div>
                        <div class="item">
                            <i class="right triangle icon"></i>
                            <a class="content" href="add_job.html">Update your information for this application</a>
                        </div>
                    <?php
                    } else {
                        echo '<div class="ui basic segment" id="company_messages_empty" style="color: grey; font-size: 15px; font-weight: bold">';
                        echo 'No tools to show.';
                        echo '</div>';
                    }
                    ?>
                    </ul>
            </div>
        </div>
    </div>
</body>
</html>
