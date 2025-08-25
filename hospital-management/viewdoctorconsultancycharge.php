<?php
include("adformheader.php");
include("dbconnection.php");

if(isset($_GET['delid'])) {
    $delid = $_GET['delid'];
    $sql = "DELETE FROM treatment_records WHERE appointmentid='$delid'";
    $qsql = mysqli_query($con, $sql);
    if(mysqli_affected_rows($con) == 1) {
        echo "<script>alert('Appointment record deleted successfully.');</script>";
    }
}
?>
<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center">View Doctor Consultancy Charges</h2>
    </div>
    <div class="card">
        <section class="container">
            <table class="table table-bordered table-striped table-hover js-exportable dataTable">
                <thead>
                    <tr>
                        <th width="97">Date</th>
                        <th width="245">Description</th>
                        <th width="86">Bill Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM billing_records WHERE bill_type='Consultancy Charge' AND bill_type_id='$_SESSION[doctorid]'";
                    $qsql = mysqli_query($con, $sql);
                    $billamt = 0;
                    while($rs = mysqli_fetch_array($qsql)) {
                        echo "<tr>
                                <td>$rs[bill_date]</td>
                                <td>$rs[bill_type]";
                        
                        if($rs['bill_type'] == "Service Charge") {
                            $sqlservice_type = "SELECT * FROM service_type WHERE service_type_id='$rs[bill_type_id]'";
                            $qsqlservice_type = mysqli_query($con, $sqlservice_type);
                            $rsservice_type = mysqli_fetch_array($qsqlservice_type);
                            echo " - " . $rsservice_type['service_type'];
                        }
                        
                        if($rs['bill_type'] == "Room Rent") {
                            $sqlroom = "SELECT * FROM room WHERE roomid='$rs[bill_type_id]'";
                            $qsqlroom = mysqli_query($con, $sqlroom);
                            $rsroom = mysqli_fetch_array($qsqlroom);
                            echo " : " . $rsroom['roomtype'] . " - Room No. " . $rsroom['roomno'];
                        }
                        
                        if($rs['bill_type'] == "Consultancy Charge") {
                            $sqldoctor = "SELECT * FROM doctor WHERE doctorid='$rs[bill_type_id]'";
                            $qsqldoctor = mysqli_query($con, $sqldoctor);
                            $rsdoctor = mysqli_fetch_array($qsqldoctor);
                            echo " - Mr." . $rsdoctor['doctorname'];
                        }
                        
                        if($rs['bill_type'] == "Treatment Cost") {
                            $sqltreatment = "SELECT * FROM treatment WHERE treatmentid='$rs[bill_type_id]'";
                            $qsqltreatment = mysqli_query($con, $sqltreatment);
                            $rstreatment = mysqli_fetch_array($qsqltreatment);
                            echo " - " . $rstreatment['treatmenttype'];
                        }
                        
                        if($rs['bill_type'] == "Prescription charge") {
                            $sqlprescription = "SELECT * FROM prescription WHERE treatmentid='$rs[bill_type_id]'";
                            $qsqlprescription = mysqli_query($con, $sqlprescription);
                            $rsprescription = mysqli_fetch_array($qsqlprescription);
                            
                            $sqltreatment_record = "SELECT * FROM treatment_records WHERE treatmentid='$rsprescription[treatment_records_id]'";
                            $qsqltreatment_record = mysqli_query($con, $sqltreatment_record);
                            $rstreatment_record = mysqli_fetch_array($qsqltreatment_record);
                            
                            $sqltreatment = "SELECT * FROM treatment WHERE treatmentid='$rstreatment_record[treatmentid]'";
                            $qsqltreatment = mysqli_query($con, $sqltreatment);
                            $rstreatment = mysqli_fetch_array($qsqltreatment);
                            
                            echo " - " . $rstreatment['treatmenttype'];
                        }
                        
                        echo "</td><td>₹ $rs[bill_amount]</td></tr>";
                        $billamt += $rs['bill_amount'];
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td>Total Earnings :</td>
                        <td>₹ <?php echo $billamt; ?></td>
                    </tr>
                </tfoot>
            </table>
        </section>
    </div>
</div>
<?php
include("adformfooter.php");
?>
