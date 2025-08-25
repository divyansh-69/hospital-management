<?php
session_start();
error_reporting(0);
include("dbconnection.php");

// Fetch bills for the logged-in patient
if(isset($_SESSION['patientid'])) {
    $sql = "SELECT * FROM billing1 WHERE patient_id='{$_SESSION['patientid']}'";
    $result = mysqli_query($con, $sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>HMS - View Bill</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="assets/css/main.css" rel="stylesheet">
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

    <!-- Top Bar -->
    <nav class="navbar clearHeader">
        <div class="col-12">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="#">Hospital Management System</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a data-placement="bottom" title="Logout" href="logout.php"><i class="zmdi zmdi-sign-in"></i></a></li>
            </ul>
        </div>
    </nav>
    <!-- #Top Bar -->

    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <?php if(isset($_SESSION['patientid'])): ?>
                <div class="menu">
                    <ul class="list">
                        <li class="header">MAIN NAVIGATION</li>
                        <li class="active open"><a href="patientaccount.php"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
                        <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-calendar-check"></i><span>Profile</span></a>
                            <ul class="ml-menu">
                                <li><a href="patientprofile.php">View Profile</a></li>
                                <li><a href="patientchangepassword.php">Change Password</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-calendar-check"></i><span>Appointment</span></a>
                            <ul class="ml-menu">
                                <li><a href="patientappointment.php">Add Appointment</a></li>
                                <li><a href="viewappointment.php">View Appointments</a></li>
                                <li><a href="patviewbill.php">Billing</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-add"></i><span>Prescription</span></a>
                            <ul class="ml-menu">
                                <li><a href="patviewprescription.php">View Prescription Records</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-o"></i><span>Treatment</span></a>
                            <ul class="ml-menu">
                                <li><a href="viewtreatmentrecord.php">View Treatment Records</a></li>
                                <li><a href="viewroom.php">View Room</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </aside>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content home">
        <div class="container-fluid">
            <div class="block-header">
                <h2 class="text-center">View Bill</h2>
            </div>
            <?php while($bill = mysqli_fetch_assoc($result)): ?>
                <?php
                    // Fetch patient details for each bill
                    $sqlPatient = "SELECT * FROM patient WHERE patientid='{$bill['patient_id']}'";
                    $resultPatient = mysqli_query($con, $sqlPatient);
                    $patient = mysqli_fetch_assoc($resultPatient);
                ?>
                <div class="card" style="padding: 10px">
                    <section class="container">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Billing ID</th>
                                    <th>Patient</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $bill['billingid']; ?></td>
                                    <td><?php echo $patient['patientname']; ?></td>
                                    <td><?php echo $bill['date']; ?></td>
                                    <td><?php echo $bill['bill_amount']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="button" class="btn btn-lg" value="Print" onclick="printBill()"/>
                    </section>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <?php include("adfooter.php"); ?>

    <script>
        function printBill() {
            window.print();
        }
    </script>
</body>
</html>
