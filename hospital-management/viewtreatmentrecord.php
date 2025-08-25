<?php
include("adformheader.php");
include("dbconnection.php");

if(isset($_GET['delid'])) {
    $sql = "DELETE FROM treatment_records WHERE appointmentid='{$_GET['delid']}'";
    $qsql = mysqli_query($con, $sql);
    if(mysqli_affected_rows($con) == 1) {
        echo "<script>alert('Appointment record deleted successfully.');</script>";
    }
}
?>

<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center">View new treatment records</h2>
    </div>

    <div class="card">
        <section class="container">
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <thead>
                    <tr>
                        <th width="71">Treatment type</th>
                        <th width="52">Patient</th>
                        <th width="78">Doctor</th>
                        <th width="82">Treatment Description</th>
                        <th width="43">Treatment date</th>
                        <th width="43">Treatment time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM treatment_records WHERE status='Active'";
                    if(isset($_SESSION['patientid'])) {
                        $sql .= " AND patientid='{$_SESSION['patientid']}'"; 
                    }
                    if(isset($_SESSION['doctorid'])) {
                        $sql .= " AND doctorid='{$_SESSION['doctorid']}'";
                    }
                    $qsql = mysqli_query($con, $sql);
                    while($rs = mysqli_fetch_array($qsql)) {
                        $sqlpat = "SELECT * FROM patient WHERE patientid='{$rs['patientid']}'";
                        $qsqlpat = mysqli_query($con, $sqlpat);
                        $rspat = mysqli_fetch_array($qsqlpat);
                        
                        $sqldoc = "SELECT * FROM doctor WHERE doctorid='{$rs['doctorid']}'";
                        $qsqldoc = mysqli_query($con, $sqldoc);
                        $rsdoc = mysqli_fetch_array($qsqldoc);
                        
                        $sqltreatment = "SELECT * FROM treatment WHERE treatmentid='{$rs['treatmentid']}'";
                        $qsqltreatment = mysqli_query($con, $sqltreatment);
                        $rstreatment = mysqli_fetch_array($qsqltreatment);
                        
                        echo "<tr>
                                <td>{$rstreatment['treatmenttype']}</td>
                                <td>{$rspat['patientname']}</td>
                                <td>{$rsdoc['doctorname']}</td>
                                <td>{$rs['treatment_description']}</td>
                                <td>{$rs['treatment_date']}</td>
                                <td>{$rs['treatment_time']}</td>
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
