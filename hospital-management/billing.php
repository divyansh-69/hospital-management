<?php
session_start();
error_reporting(0);
include("dbconnection.php");
$dt = date("Y-m-d");
$tim = date("H:i:s");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>HMS</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<!-- JQuery DataTable Css -->
<link href="assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="assets/css/main.css" rel="stylesheet">
<!-- Custom Css -->

<!-- Swift Themes. You can choose a theme from css/themes instead of get all themes -->
<link href="assets/css/themes/all-themes.css" rel="stylesheet" />
<link rel="stylesheet" href="sweetalert2.min.css">
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
                if(isset($_SESSION['adminid']))
                {
            ?>
            <!--Admin Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="active open"><a href="adminaccount.php"><i
                                class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>


                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-calendar-check"></i><span>Profile</span> </a>
                        <ul class="ml-menu">
                            <li><a href="adminprofile.php">Admin Profile</a></li>
                            <li><a href="adminchangepassword.php">Change Password</a></li>
                            <li><a href="admin.php">Add Admin</a></li>
                            <li><a href="viewadmin.php">View Admin</a></li>
                        </ul>
                    </li>

                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-calendar-check"></i><span>Appointment</span> </a>
                        <ul class="ml-menu">
                            <li><a href="appointment.php">New Appointment</a></li>
                            <li><a href="viewappointmentpending.php">View Pending Appointments</a>
                            </li>
                            <li><a href="viewappointmentapproved.php">View Approved
                                    Appointments</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-account-add"></i><span>Doctors</span> </a>
                        <ul class="ml-menu">
                            <li><a href="doctor.php">Add Doctor</a>
                            </li>
                            <li><a href="viewdoctor.php">View Doctor</a></li>
                           
                        </ul>
                    </li>
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-account-o"></i><span>Patients</span> </a>
                        <ul class="ml-menu">
                            <li><a href="patient.php">Add Patient</a></li>
                            <li><a href="viewpatient.php">View Patient Records</a></li>
                        </ul>
                    </li>


                    <li> <a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-settings-square"></i><span>Service</span> </a>
                        <ul class="ml-menu">
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

<?php
include("dbconnection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Billing Record</title>
</head>
<body>
    <center>
        <h1>Add new Billing Record</h1>
        <form action="insert.php" method="post">
        <label for="billingId">Billing ID:</label>
        <input type="text" name="billing_id" id="billingId">

            <p>
                <label for="patientId">Patient ID:</label>
                <input type="text" name="patient_id" id="patientId">
            </p>
            <p>
                <label for="date">Date:</label>
                <input type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>">
            </p>
            <p>
                <label for="billAmount">Bill Amount:</label>
                <input type="text" name="bill_amount" id="billAmount">
            </p>
            <input type="submit" name="submit" value="Add Billing Record">
        </form>
    </center>
</body>
</html>


<?php
include("adfooter.php");
?>

