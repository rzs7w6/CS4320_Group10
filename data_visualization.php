<?php
$servername = "localhost";
$username = "root";
$password = "Mn234!";

try {
    $conn = null;
    $conn = new PDO("mysql:host=$servername;dbname=superlinkedin", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

    $sth = $conn->prepare("SELECT * FROM workinfo.user");
    $sth->execute();

    $user = $sth->rowCount();
    $sth = $conn->prepare("SELECT * FROM workinfo.company");
    $sth->execute();
    $company = $sth->rowCount();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Visualization</title>
    <link rel="stylesheet" type="text/css" href="css/login.css"/>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="Chart.js/dist/Chart.bundle.js"></script>
    <style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
    </style>

</head>
<body>
    <a href="login.html" style="position: absolute; left: 10; color: white;">Return to login</a>
    <div id="main2" style="position: absolute; left: 25%; margin-top: 05%">
    <img id="imgHeader" src="img/logo.png" style="width:50%; margin-bottom: 5%;"alt="Super LinkedIn"/>
    <div id="container" style="background-color: rgba(255,255,255,0.95); border-radius: 25px; margin-bottom: 10%;">
        <canvas id="canvas"></canvas>
    </div>
    <script>
	var users = <?php print($user)?>;
	var companies = <?php print($company)?>;

        var GROUPS = ["Users", "Companies"];
        var barChartData = {
            labels: ["Users", "Companies"],
            datasets: [{
                label: 'SuperLinkedIn Participation',
                fillColor: "green",
                strokeColor: "green",
                highlightFill: "green",
                highlightStroke: "green",
                data:[users, companies, 0]
        }]
        };

        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myBar = new Chart(ctx, {
                scaleBeginAtZero: true,
                type: 'bar',
                data: barChartData,
                options: {
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each bar to be 2px wide and green
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                            borderColor: '#0066CC',
                            borderSkipped: 'bottom'
                        }
                    },
                    responsive: true,
                    scaleBeginAtZero : true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'SuperLinkedIn Data'
                    }
                }
            });
        };
    </script>

    <div id="footer">
    </div>
    </div>
</body>
</html>
