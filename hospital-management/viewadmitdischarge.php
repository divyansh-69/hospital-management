<?php
include("adheader.php");
include("dbconnection.php");

if(isset($_GET['delid'])) {
    $delid = $_GET['delid'];
    $sql = "DELETE FROM admit_discharge WHERE admit_discharge_id='$delid'";
    $qsql = mysqli_query($con, $sql);
    if(mysqli_affected_rows($con) == 1) {
        echo "<script>alert('Admit/Discharge record deleted successfully.');</script>";
    }
}
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
    <table width="100%" border="3">
      <tbody>
        <tr>
          <th>Admit/Discharge ID</th>
          <th>Patient ID</th>
          <th>Admit Date</th>
          <th>Discharge Date</th>
          <th>Room ID</th>
          <th>Action</th>
        </tr>
        <?php
        $sql = "SELECT * FROM admit_discharge";
        $qsql = mysqli_query($con, $sql);
        while($rs = mysqli_fetch_array($qsql)) {
            echo "<tr>
                    <td>{$rs['admit_discharge_id']}</td>
                    <td>{$rs['patient_id']}</td>
                    <td>{$rs['admit_date']}</td>
                    <td>{$rs['discharge_date']}</td>
                    <td>{$rs['room_id']}</td>
                    <td>
                        <a href='editadmitdischarge.php?editid={$rs['admit_discharge_id']}'>Edit</a> | 
                        <a href='showadmitdischarge.php?delid={$rs['admit_discharge_id']}'>Delete</a>
                    </td>
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
