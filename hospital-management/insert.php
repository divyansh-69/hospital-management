<?php
session_start();
error_reporting(0);
include("dbconnection.php"); // Assuming this file contains the database connection details
$dt = date("Y-m-d");
$tim = date("H:i:s");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>HMS - Admin</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="assets/plugins/morrisjs/morris.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="assets/css/main.css" rel="stylesheet">
    <!-- Swift Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="assets/css/themes/all-themes.css" rel="stylesheet" />
    <!-- Bootstrap Material Datetime Picker Css -->
</head>

<body class="theme-cyan">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-cyan">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

    <!-- Morphing Search  -->

    <!-- Top Bar -->
    <nav class="navbar clearHeader">
        <div class="col-12">
            <div class="navbar-header"> <a href="javascript:void(0);" class="bars"></a> <a class="navbar-brand"
                    href="#">Hospital Management System</a> </div>
            <ul class="nav navbar-nav navbar-right">
                <!-- Notifications -->
                <li>
                    <a data-placement="bottom" title="Full Screen" href="logout.php"><i
                            class="zmdi zmdi-sign-in"></i></a>
                </li>

            </ul>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <?php
            if (isset($_SESSION['adminid'])) {
            ?>
                <!--Admin Menu -->
                <div class="menu">
                    <ul class="list" style="overflow: hidden; width: auto; height: calc(-184px + 100vh);">
                        <li class="header">MAIN NAVIGATION</li>
                        <li class="active open"><a href="adminaccount.php"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>

                        <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-calendar-check"></i><span>Profile</span> </a>
                            <ul class="ml-menu">
                                <li><a href="adminprofile.php">Admin Profile</a></li>
                                <li><a href="adminchangepassword.php">Change Password</a></li>
                                <li><a href="admin.php">Add Admin</a></li>
                                <li><a href="viewadmin.php">View Admin</a></li>
                            </ul>
                        </li>

                        <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-calendar-check"></i><span>Appointment</span> </a>
                            <ul class="ml-menu">
                                <li><a href="appointment.php">New Appointment</a></li>
                                <li><a href="viewappointmentpending.php">View Pending Appointments</a></li>
                                <li><a href="viewappointmentapproved.php">View Approved Appointments</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-add"></i><span>Doctors</span> </a>
                            <ul class="ml-menu">
                                <li><a href="doctor.php">Add Doctor</a></li>
                                <li><a href="viewdoctor.php">View Doctor</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-o"></i><span>Patients</span> </a>
                            <ul class="ml-menu">
                                <li><a href="patient.php">Add Patient</a></li>
                                <li><a href="viewpatient.php">View Patient Records</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle toggled waves-effect waves-block"><i class="zmdi zmdi-copy"></i><span>Service</span> </a>
                            <ul class="ml-menu" style="display: block;">
                            <li><a href="treatment.php">Add Treatment type</a></li>
                            <li><a href="viewtreatment.php">View Treatment types</a></li>
                            <li><a href="billing.php">View Billing</a></li>
                            <li><a href="viewroom.php" >View Room</a></li>
                            <li><a href="admitdischarge.php" class=" waves-effect waves-block">Admit & Discharge</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- Admin Menu -->
            <?php } ?>

        </aside>
        <!-- #END# Left Sidebar -->

    </section>
    <section class="content home">
        <!DOCTYPE html>
        <html>

        <head>
            <title>Bill Page</title>
        </head>

        <body>
            <center>
                <?php
                $conn = mysqli_connect("localhost", "root", "", "ohmsphp");
                if ($conn === false) {
                    die("ERROR: Could not connect. " . mysqli_connect_error());
                }

                // Check if all required fields are set in the request
                if (isset($_REQUEST['billing_id']) && isset($_REQUEST['patient_id']) && isset($_REQUEST['date']) && isset($_REQUEST['bill_amount'])) {
                    $billing_id = $_REQUEST['billing_id'];
                    $patient_id = $_REQUEST['patient_id'];
                    $billing_date = $_REQUEST['date'];
                    $bill_amount = $_REQUEST['bill_amount'];

                    $sql = "INSERT INTO billing1 (billingid, patient_id, date, bill_amount) 
                            VALUES ('$billing_id', '$patient_id', '$billing_date', '$bill_amount')";

                    if (mysqli_query($conn, $sql)) {
                        // Start table markup
                        echo "<table style='border-collapse: collapse; width: 100%;'>";

                        // Table header
                        echo "<tr>";
                        echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Billing ID</th>";
                        echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Patient ID</th>";
                        echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Billing Date</th>";
                        echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Bill Amount</th>";
                        echo "</tr>";

                        // Table row with data
                        echo "<tr>";
                        echo "<td style='border: 1px solid #ddd; padding: 8px;'>$billing_id</td>";
                        echo "<td style='border: 1px solid #ddd; padding: 8px;'>$patient_id</td>";
                        echo "<td style='border: 1px solid #ddd; padding: 8px;'>$billing_date</td>";
                        echo "<td style='border: 1px solid #ddd; padding: 8px;'>$bill_amount</td>";
                        echo "</tr>";

                        // End table markup
                        echo "</table>";
                    } else {
                        echo "ERROR: Unable to execute $sql. " . mysqli_error($conn);
                    }
                } else {
                    echo "ERROR: Required fields are missing.";
                }

                mysqli_close($conn);
                ?>
            </center>
        </body>

        </html>
        <?php
        include("adfooter.php");
        ?>
