<?php
include("adformheader.php");
include("dbconnection.php");
if(isset($_GET['delid']))
{
    $delid = $_GET['delid'];
    $sql ="DELETE FROM doctor_timings WHERE doctor_timings_id='$delid'";
    $qsql = mysqli_query($con,$sql);
    if(mysqli_affected_rows($con) == 1)
    {
        echo "<script>alert('Doctor timings record deleted successfully.');</script>";
    }
}
?>
<div class="container-fluid">
  <div class="block-header">
    <h2 class="text-center">View Doctor Timings</h2>
  </div>
  <div class="card">
    <section class="container">
      <table class="table table-bordered table-striped table-hover js-exportable dataTable">
        <thead>
          <tr>
            <th>Doctor</th>
            <th>Timings available</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql ="SELECT * FROM doctor_timings WHERE doctorid='$_SESSION[doctorid]'";
          $qsql = mysqli_query($con,$sql);
          while($rs = mysqli_fetch_array($qsql))
          {
              $sqldoctor = "SELECT * FROM doctor WHERE doctorid='$rs[doctorid]'";
              $qsqldoctor = mysqli_query($con,$sqldoctor);
              $rsdoctor = mysqli_fetch_array($qsqldoctor);
              
              echo "<tr>
              <td>&nbsp;$rsdoctor[doctorname]</td>
              <td>&nbsp;$rs[start_time] - $rs[end_time]</td>
              <td>&nbsp;$rs[status]</td>
              <td width='250'>&nbsp;<a href='doctortimings.php?editid=$rs[doctor_timings_id]' class='btn btn-raised btn-sm g-bg-cyan'>Edit</a>  <a href='viewdoctortimings.php?delid=$rs[doctor_timings_id]' class='btn btn-raised btn-sm g-bg-blush2'>Delete</a> </td>
              </tr>";
          }
          ?>
        </tbody>
      </table>
    </section>
  </div>
</div>
<?php
include("adformfooter.php");
?>
