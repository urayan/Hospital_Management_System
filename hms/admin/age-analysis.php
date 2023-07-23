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
        <title>Admin | AGE ANALYSIS</title>

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
                                    <h1 class="mainTitle">Admin | AGE ANALYSIS</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li>
                                        <span>Admin</span>
                                    </li>
                                    <li class="active">
                                        <span>AGE ANALYSIS</span>
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
                                    $pattern = "/^2[0-9]{3}$/";
                                    $flag = preg_match($pattern, $fdate);
                                    ?>

                                    <?php

                                    $sql = "SELECT YEAR(CreationDate) AS year, SUM(CASE WHEN PatientAge >= 0 AND PatientAge <= 20 THEN 1 ELSE 0 END) AS range_0_20, SUM(CASE WHEN PatientAge >= 21 AND PatientAge <= 40 THEN 1 ELSE 0 END) AS range_21_40, SUM(CASE WHEN PatientAge >= 41 AND PatientAge <= 60 THEN 1 ELSE 0 END) AS range_41_60, SUM(CASE WHEN PatientAge >= 61 AND PatientAge <= 80 THEN 1 ELSE 0 END) AS range_61_80, SUM(CASE WHEN PatientAge >= 81 AND PatientAge <= 100 THEN 1 ELSE 0 END) AS range_81_100, SUM(CASE WHEN PatientAge > 100 THEN 1 ELSE 0 END) AS range_above_100 FROM tblpatient WHERE YEAR(CreationDate) = '$fdate' GROUP BY YEAR(CreationDate)";
                                    $result = mysqli_query($con, $sql);
                                    $row = mysqli_fetch_array($result);
                                    $dataPoints = array(
                                        array("label" => "0-20", "y" => $row[1]),
                                        array("label" => "21-40", "y" => $row[2]),
                                        array("label" => "41-60", "y" => $row[3]),
                                        array("label" => "61-80", "y" => $row[4]),
                                        array("label" => "81-100", "y" => $row[5]),
                                        array("label" => "100 above", "y" => $row[6])
                                    );


                                    ?>

                                    <script>
                                        window.onload = function () {

                                            var chart = new CanvasJS.Chart("chartContainer", {
                                                animationEnabled: true,
                                                exportEnabled: true,
                                                title: {
                                                    text: "Age analysis Report in year : <?php echo $fdate ?>"
                                                },
                                                subtitles: [{
                                                    text: "<?php if ($flag == 0) {
                                                        echo "Invalid Year";
                                                    } ?>"
                                                }],
                                                data: [{
                                                    type: "pie",
                                                    showInLegend: "true",
                                                    legendText: "{label}",
                                                    indexLabelFontSize: 16,
                                                    indexLabel: "{label} - #percent%",
                                                    yValueFormatString: "฿#,##0",
                                                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                                                }]
                                            });
                                            chart.render();

                                        }
                                    </script>

                                    <body>
                                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                                        <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
                                    </body>
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