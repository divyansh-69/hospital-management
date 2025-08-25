<?php
include("header.php");
include("dbconnection.php");

if(isset($_GET['delid'])) {
    $delid = $_GET['delid'];
    $sql ="DELETE FROM prescription WHERE prescriptionid='$delid'";
    $qsql = mysqli_query($con, $sql);
    if(mysqli_affected_rows($con) == 1) {
        echo "<script>alert('Prescription deleted successfully.');</script>";
    }
}

?>

<div class="wrapper col2">
    <div id="breadcrumb">
        <ul>
            <li class="first">View Prescription</li>
        </ul>
    </div>
</div>

<div class="wrapper col4">
    <div id="container">
        <h1>View Prescription record</h1>

        <?php
        $sql = "SELECT * FROM prescription";
        $qsql = mysqli_query($con, $sql);

        while($rs = mysqli_fetch_array($qsql)) {
            $sqlpatient = "SELECT * FROM patient WHERE patientid='$rs[patientid]'";
            $qsqlpatient = mysqli_query($con, $sqlpatient);
            $rspatient = mysqli_fetch_array($qsqlpatient);

            $sqldoctor = "SELECT * FROM doctor WHERE doctorid='$rs[doctorid]'";
            $qsqldoctor = mysqli_query($con, $sqldoctor);
            $rsdoctor = mysqli_fetch_array($qsqldoctor);
        ?>			

        <table width="200" border="3">
            <tbody>
                <tr>
                    <td><strong>Doctor</strong></td>
                    <td><strong>Patient</strong></td>
                    <td><strong>Prescription Date</strong></td>
                    <td><strong>Status</strong></td>
                </tr>

                <?php
                    echo "<tr>
                        <td>&nbsp;{$rsdoctor['doctorname']}</td>
                        <td>&nbsp;{$rspatient['patientname']}</td>
                        <td>&nbsp;{$rs['prescriptiondate']}</td>
                        <td>&nbsp;{$rs['status']}</td>
                    </tr>";
                ?>
            </tbody>
        </table>

        <h1>View Prescription record</h1>

        <table width="200" border="3">
            <tbody>
                <tr>
                    <td>Medicine</td>
                    <td>Cost</td>
                    <td>Unit</td>
                    <td>Dosage</td>
                </tr>

                <?php
                $prescriptionId = $rs['prescriptionid'];
                $sqlPrescriptionRecords ="SELECT * FROM prescription_records WHERE prescription_id='$prescriptionId'";
                $qsqlPrescriptionRecords = mysqli_query($con, $sqlPrescriptionRecords);

                while($rsPrescriptionRecords = mysqli_fetch_array($qsqlPrescriptionRecords)) {
                    echo "<tr>
                        <td>&nbsp;{$rsPrescriptionRecords['medicine_name']}</td>
                        <td>&nbsp;{$rsPrescriptionRecords['cost']}</td>
                        <td>&nbsp;{$rsPrescriptionRecords['unit']}</td>
                        <td>&nbsp;{$rsPrescriptionRecords['dosage']}</td>
                    </tr>";
                }
                ?>
                
                <tr>
                    <td colspan="4">
                        <div align="center">
                            <input type="submit" name="print" id="print" value="Print" onclick="myFunction()"/>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <?php
        }
        ?>

        <p>&nbsp;</p>
    </div>
</div>

<?php
include("footer.php");
?>
