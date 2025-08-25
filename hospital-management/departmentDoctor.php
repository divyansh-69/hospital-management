<?php
session_start();
include("dbconnection.php");

// Prevent SQL injection by sanitizing input
$deptId = isset($_GET['deptid']) ? intval($_GET['deptid']) : 0;
$deptId = mysqli_real_escape_string($con, $deptId);

$sql = "SELECT * FROM doctor WHERE departmentid='$deptId'";
$qsql = mysqli_query($con, $sql);

// Initialize select options variable
$selectOptions = "<option value=''>Select doctor</option>";

while($qsql1 = mysqli_fetch_array($qsql)) {
    $selectOptions .= "<option value='$qsql1[doctorid]'>$qsql1[doctorname]</option>";
}

// Output select options
echo "<select class='selectpicker' name='doct' id='doct'>$selectOptions</select>";
?>
