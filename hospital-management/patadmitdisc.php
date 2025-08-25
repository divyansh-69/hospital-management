<?php
include("adheader.php");
include("dbconnection.php");

// Check if the user is logged in and retrieve their patient ID from the session
session_start();
if(!isset($_SESSION['patientid'])) {
    // Redirect to login page or display an error message
    header("Location: patientlogin.php");
    exit();
}
$patient_id = $_SESSION['patientid'];

?>

<div class="wrapper col2">
  <div id="breadcrumb">
    <ul>
    </ul>
  </div>
</div>
<div class="wrapper col4">
  <div id="container">
    <h1>View Admit/Discharge Records</h1>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Patient Name</th>
          <th>Doctor Name</th>
          <th>Admission Date</th>
          <th>Discharge Date</th>
          <th>Room ID</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT admit.*, patient.patientname, doctor.doctorname FROM admit 
                INNER JOIN patient ON admit.patientid = patient.patientid
                INNER JOIN doctor ON admit.doctorid = doctor.doctorid
                WHERE admit.patientid='$patient_id'";
        $qsql = mysqli_query($con, $sql);
        while($rs = mysqli_fetch_array($qsql)) {
            echo "<tr>
                    <td>{$rs['patientname']}</td>
                    <td>{$rs['doctorname']}</td>
                    <td>{$rs['admissiondate']}</td>
                    <td>{$rs['dischargedate']}</td>
                    <td>{$rs['roomid']}</td>
                </tr>";
        }
        ?>
      </tbody>
    </table>
    <p>&nbsp;</p>
  </div>
</div>
<div class="clear"></div>
</div>
<?php
include("adfooter.php");
?>
