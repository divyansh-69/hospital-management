
<?php
error_reporting(0);
include("dbconnection.php");

if(isset($_GET['medicineid'])) {
    $medicineid = mysqli_real_escape_string($con, $_GET['medicineid']);
    
    $sqlmedicine ="SELECT * FROM medicine WHERE medicineid='$medicineid'";
    $qsqlmedicine = mysqli_query($con, $sqlmedicine);
    $rsmedicine = mysqli_fetch_array($qsqlmedicine);
    
    echo $rsmedicine['medicinecost'];
}
?>
