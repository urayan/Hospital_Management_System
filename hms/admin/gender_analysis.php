<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['id'] == 0)) {
    header('location:logout.php');
} else {

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Admin | APPOINTMENT ANALYSIS</title>

        <link
            href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic"
            rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
        <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
        <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
        <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
        <link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
        <link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
        <link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
        <link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="assets/css/styles.css">
        <link rel="stylesheet" href="assets/css/plugins.css">
        <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
    </head>

    <body>
        <div id="app">
            <?php include('include/sidebar.php'); ?>
            <div class="app-content">
                <?php include('include/header.php'); ?>
                <div class="main-content">
                    <div class="wrap-content container" id="container">
                        <!-- start: PAGE TITLE -->
                        <section id="page-title">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h1 class="mainTitle">Admin | GENDER BASED ANALYSIS</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li>
                                        <span>Admin</span>
                                    </li>
                                    <li class="active">
                                        <span>GENDER BASED ANALYSIS</span>
                                    </li>
                                </ol>
                            </div>
                        </section>
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="tittle-w3-agileits mb-4">Alanysis Chart</h4>
                                    <?php
                                    $fdate = $_POST['fromdate'];
                                    ?>

                                    <?php

                                    $sql = "SELECT YEAR(a.appointmentDate) AS year,SUM(CASE WHEN u.gender = 'male' THEN 1 ELSE 0 END) AS male_count,SUM(CASE WHEN u.gender = 'female' THEN 1 ELSE 0 END) AS female_count FROM users u JOIN appointment a ON u.id = a.userid GROUP BY YEAR(a.appointmentDate)";
                                    $result = mysqli_query($con, $sql);
                                    $row = mysqli_fetch_array($result);
                                    $dataPoints1 = array();
                                    $dataPoints2 = array();
                                    while ($row) {
                                        $tmp1 = array("label" => $row[0], "y" => $row[1]);
                                        $tmp2 = array("label" => $row[0], "y" => $row[2]);
                                        array_push($dataPoints1, $tmp1);
                                        array_push($dataPoints2, $tmp2);
                                        $row = mysqli_fetch_array($result);
                                    }

                                    ?>

                                    <!DOCTYPE HTML>
                                    <html>

                                    <head>
                                        <script>
                                            window.onload = function () {

                                                var chart = new CanvasJS.Chart("chartContainer", {
                                                    animationEnabled: true,
                                                    theme: "light2",
                                                    title: {
                                                        text: "Graph for the appointments according to gender"
                                                    },
                                                    axisY: {
                                                        includeZero: true
                                                    },
                                                    legend: {
                                                        cursor: "pointer",
                                                        verticalAlign: "center",
                                                        horizontalAlign: "right",
                                                        itemclick: toggleDataSeries
                                                    },
                                                    data: [{
                                                        type: "column",
                                                        name: "Male",
                                                        indexLabel: "{y}",
                                                        yValueFormatString: "#0.##",
                                                        showInLegend: true,
                                                        dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
                                                    }, {
                                                        type: "column",
                                                        name: "Female",
                                                        indexLabel: "{y}",
                                                        yValueFormatString: "#0.##",
                                                        showInLegend: true,
                                                        dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
                                                    }]
                                                });
                                                chart.render();

                                                function toggleDataSeries(e) {
                                                    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                                        e.dataSeries.visible = false;
                                                    }
                                                    else {
                                                        e.dataSeries.visible = true;
                                                    }
                                                    chart.render();
                                                }

                                            }
                                        </script>
                                    </head>

                                    <body>
                                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                                        <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
                                    </body>
                                

                                    </html>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- start: FOOTER -->
        <?php include('include/footer.php'); ?>
        <!-- end: FOOTER -->

        <!-- start: SETTINGS -->
        <?php include('include/setting.php'); ?>

        <!-- end: SETTINGS -->
        </div>
        <!-- start: MAIN JAVASCRIPTS -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="vendor/modernizr/modernizr.js"></script>
        <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
        <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="vendor/switchery/switchery.min.js"></script>
        <!-- end: MAIN JAVASCRIPTS -->
        <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        <script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
        <script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
        <script src="vendor/autosize/autosize.min.js"></script>
        <script src="vendor/selectFx/classie.js"></script>
        <script src="vendor/selectFx/selectFx.js"></script>
        <script src="vendor/select2/select2.min.js"></script>
        <script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
        <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        <!-- start: CLIP-TWO JAVASCRIPTS -->
        <script src="assets/js/main.js"></script>
        <!-- start: JavaScript Event Handlers for this page -->
        <script src="assets/js/form-elements.js"></script>
        <script>
            jQuery(document).ready(function () {
                Main.init();
                FormElements.init();
            });
        </script>
        <!-- end: JavaScript Event Handlers for this page -->
        <!-- end: CLIP-TWO JAVASCRIPTS -->
    </body>

    </html>
<?php } ?>