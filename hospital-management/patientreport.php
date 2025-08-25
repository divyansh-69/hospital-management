<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Report Panel</title>
    <!-- jQuery Library -->
    <script src="js/jquery.min.js"></script>
    <style>
        /* CSS styles for toggle */
        /* Main toggle */
        .toggle { 
            font-size: 13px;
            line-height: 20px;
            font-family: "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
            background: #ffffff;
            margin-bottom: 10px;
            border: 1px solid #e5e5e5;
            border-radius: 5px;    
        }

        /* Toggle Link text */
        .toggle a.toggle-trigger {
            display: block;
            padding: 10px 20px 15px 20px;
            position: relative;
            text-decoration: none;
            color: #666;
        }

        /* Toggle Link hover state */
        .toggle a.toggle-trigger:hover {
            opacity: .8;
            text-decoration: none;
        }

        /* Toggle link when clicked */
        .toggle a.active {
            text-decoration: none;
            border-bottom: 1px solid #e5e5e5;
            box-shadow: 0 8px 6px -6px #ccc;
            color: #000;
        }

        /* Lets add a "-" before the toggle link */
        .toggle a.toggle-trigger:before {
            content: "-";
            margin-right: 10px;
            font-size: 1.3em;    
        }

        /* When the toggle is active, change the "-" to a "+" */
        .toggle a.active.toggle-trigger:before {
            content: "+";
        }

        /* The content of the toggle */
        .toggle .toggle-content {
            padding: 10px 20px 15px 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="wrapper col2">
        <div id="breadcrumb">
            <h1></h1>
        </div>
    </div>
    <div class="container-fluid">
        <div class="block-header">
            <h2>Patient Report Panel</h2>
        </div>
        <div class="card">
            <p>
                <!-- Toggle #1 -->
                <div class="toggle">
                    <!-- Toggle Link -->
                    <a href="#" title="Title of Toggle" class="toggle-trigger">Patient Profile</a>
                    <!-- Toggle Content to display -->
                    <div class="toggle-content">
                        <p><?php include("patientdetail.php"); ?></p>
                    </div><!-- .toggle-content (end) -->
                </div><!-- .toggle (end) -->

                <!-- Toggle #2 -->
                <div class="toggle">
                    <!-- Toggle Link -->
                    <a href="#" title="Title of Toggle" class="toggle-trigger">Appointment record</a>
                    <!-- Toggle Content to display -->
                    <div class="toggle-content">
                        <p><?php include("appointmentdetail.php"); ?></p>
                    </div><!-- .toggle-content (end) -->
                </div><!-- .toggle (end) -->

                <!-- Toggle #3 -->
                <div class="toggle">
                    <!-- Toggle Link -->
                    <a href="#" title="Title of Toggle" class="toggle-trigger">Treatment record</a>
                    <!-- Toggle Content to display -->
                    <div class="toggle-content">
                        <p><?php include("treatmentdetail.php"); ?></p>
                    </div><!-- .toggle-content (end) -->
                </div><!-- .toggle (end) -->

                <!-- Toggle #4 -->
                <div class="toggle">
                    <!-- Toggle Link -->
                    <a href="#" title="Title of Toggle" class="toggle-trigger">Prescription record</a>
                    <!-- Toggle Content to display -->
                    <div class="toggle-content">
                        <p><?php include("prescriptiondetail.php"); ?></p>
                    </div><!-- .toggle-content (end) -->
                </div><!-- .toggle (end) -->
                
                <!-- Patient Report -->
                <?php
                include("dbconnection.php");

                if(isset($_GET['patientid'])) {
                    $patientid = $_GET['patientid'];
                    
                    // Retrieve patient information from the database
                    $sql = "SELECT * FROM patient WHERE patientid='$patientid'";
                    $qsql = mysqli_query($con, $sql);
                    $rs = mysqli_fetch_assoc($qsql);
                    
                    // Check if patient exists
                    if(!$rs) {
                        echo "<script>alert('Patient not found.');</script>";
                        echo "<script>window.location='viewpatient.php';</script>";
                        exit;
                    }
                    
                    // Retrieve patient's report file path from the database
                    $report_file = $rs['report_file'];
                    
                    if(!empty($report_file)) {
                        // Display the PDF directly on the page using <embed> tag
                        echo "<h2 class='text-center'>Patient Report - {$rs['patientname']}</h2>";
                        echo "<div class='container-fluid'><div class='block-header'><div class='card'>";
                        echo "<section class='container'><div class='text-center'>";
                        echo "<embed src='$report_file' type='application/pdf' width='100%' height='600px'>";
                        echo "</div></section></div></div></div>";
                    } else {
                        echo "<h2 class='text-center'>No report available for {$rs['patientname']}</h2>";
                    }
                } else {
                    echo "<script>alert('Patient ID not provided.');</script>";
                    echo "<script>window.location='viewpatient.php';</script>";
                    exit;
                }
                ?>
            </p>
        </div>
    </div>
</body>
</html>
