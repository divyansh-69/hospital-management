<?php
include("adheader.php");
include("dbconnection.php");

session_start();
if(!isset($_SESSION['adminid'])) {
    echo "<script>window.location='adminlogin.php';</script>";
}

?>

<div class="container-fluid">
    <div class="block-header">
        <h2>Dashboard</h2>
        <small class="text-muted">Welcome to Admin Panel</small>
    </div>

    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-male-female col-blush"></i> </div>
                <div class="content">
                    <div class="text">Total Patient</div>
                    <div class="number">
                        <?php
                        $sql = "SELECT COUNT(*) AS total FROM patient WHERE status='Active'";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_assoc($result);
                        echo $row['total'];
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-account-circle col-cyan"></i> </div>
                <div class="content">
                    <div class="text">Total Doctor</div>
                    <div class="number">
                        <?php
                        $sql = "SELECT COUNT(*) AS total FROM doctor WHERE status='Active'";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_assoc($result);
                        echo $row['total'];
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-account-box-mail col-blue"></i> </div>
                <div class="content">
                    <div class="text">Total Administrator</div>
                    <div class="number">
                        <?php
                        $sql = "SELECT COUNT(*) AS total FROM admin WHERE status='Active'";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_assoc($result);
                        echo $row['total'];
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-money col-green"></i> </div>
                <div class="content">
                    <div class="text">Hospital Earning</div>
                    <div class="number">₹
                        <?php 
                        $sql = "SELECT SUM(bill_amount) AS total FROM billing_records";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_assoc($result);
                        echo $row['total'];
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clear"></div>
</div>
<?php include("adfooter.php"); ?>
