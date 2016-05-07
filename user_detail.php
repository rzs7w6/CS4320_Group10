<!DOCTYPE html>
<html>
<head>
    <title>Super LinkedIn</title>
    <link rel="stylesheet" type="text/css" href="css/index2.css"/>
    <link rel="stylesheet" type="text/css" href="css/forms.css"/>
    <link rel="stylesheet" type="text/css" href="css/semantic.min.css"/>
</head>
<body>
    <?php
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
    } else {
        header("Location:add_user_info.html");
        exit;
    }
    ?>
    <div class="ui fixed menu">
        <div class="header item">Super LinkedIn</div>
        <div class="right menu">
            <a class="item" href="index.php">Home</a>
            <a class="item" href="logout.php">Logout</a>
        </div>
    </div>
    <div id="main_content">
    <div class="ui segment" id="application">
        <h2 class="ui header">User Application</h2>
        <form class="ui form">
        <div class="field">
            <label>Username</label>
            <?php
            echo '<input type="text" name="first-name" value="'.$res[real_name].'" disabled class="disabled">';
            ?>
        </div>
        <div class="field">
            <label>Job Title</label>
            <?php
            echo '<input type="text" name="first-name" value="'.$res[w_name].'" disabled class="disabled">';
            ?>
        </div>
        <div class="field">
            <label>Job Space</label>
            <?php
            echo '<input type="text" name="first-name" value="'.$res[w_space].'" disabled class="disabled">';
            ?>
        </div>
        <div class="field">
            <label>School space</label>
            <?php
            echo '<input type="text" name="first-name" value="'.$res[s_space].'" disabled class="disabled">';
            ?>
        </div>
        <div class="field">
            <label>School name</label>
            <?php
            echo '<input type="text" name="first-name" value="'.$res[s_name].'" disabled class="disabled">';
            ?>
        </div>
        <div class="field">
            <label>School Start Date</label>
            <?php
            echo '<input type="date" name="first-name" value="'.$res[s_s_date].'" disabled class="disabled">';
            ?>
        </div>
        <div class="field">
            <label>School End Date</label>
            <?php
            echo '<input type="date" name="first-name" value="'.$res[s_e_date].'" disabled class="disabled">';
            ?>
        </div>
        <div class="field">
            <label>Experience Job Name</label>
            <?php
            echo '<input type="text" name="first-name" value="'.$res[e_w_name].'" disabled class="disabled">';
            ?>
        </div>
        <div class="field">
            <label>Experience Job Space</label>
            <?php
            echo '<input type="text" name="first-name" value="'.$res[e_w_space].'" disabled class="disabled">';
            ?>
        </div>
        <div class="field">
            <label>Experience Start Date</label>
            <?php
            echo '<input type="date" name="first-name" value="'.$res[e_s_date].'" disabled class="disabled">';
            ?>
        </div>
        <div class="field">
            <label>Experience End Date</label>
            <?php
            echo '<input type="date" name="first-name" value="'.$res[e_e_date].'" disabled class="disabled">';
            ?>
        </div>
        <div class="field">
            <label>Language</label>
            <?php
            echo '<input type="text" name="first-name" value="'.$res[languages].'" disabled class="disabled">';
            ?>
        </div>
        <div class="field">
            <label>Degree</label>
            <?php
            $val = '';
            if($res['degree']=='below college') {
                $val = 'Less than college';
            } else if($res['degree']=='undergradute') {
                $val = 'Undergraduate';
            } else if($res['degree']=='Master') {
                $val = 'Master';
            } else {
                $val = 'PhD';
            }
            echo '<input type="text" name="first-name" value="'.$val.'" disabled class="disabled">';
            ?>
        </div>
        <div class="field">
            <label>Skills</label>
            <textarea rows='20' cols='70' name='skills' disabled>
            <?php echo($res[skills]); ?>
            </textarea>
        </div>
        <div class="field">
            <label>Telephone</label>
            <?php
            echo '<input type="tel" name="first-name" value="'.$res[tel].'" disabled class="disabled">';
            ?>
        </div>
        </form>
    </div>
    <div class="ui segment">
        <div class="ui two column grid">
            <div class="column">
                <a class="ui large fluid primary button" href="contact_user.php?u_id=<?php echo($_GET[u_id]);?>">Contact applicant</a>
            </div>
            <div class="column">
                <a class="ui large fluid button" href="javascript:history.back()">Go back</a>
            </div>
        </div>
    </div>
    </div>
</body>
</html>
