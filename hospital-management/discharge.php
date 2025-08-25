<?php
include("adheader.php");
include("dbconnection.php");

if(isset($_POST['submit'])) {
    // Discharge the admitted patient
    $admissionid = mysqli_real_escape_string($con, $_POST['admissionid']);
    $patientid = mysqli_real_escape_string($con, $_POST['patientid']);
    $roomid = mysqli_real_escape_string($con, $_POST['roomid']);
    $dischargedate = mysqli_real_escape_string($con, $_POST['dischargedate']);
    
    // Update patient status to Active and set discharge date
    $sqlUpdatePatient = "UPDATE patient SET status='Active' WHERE patientid='$patientid'";
    $resultUpdatePatient = mysqli_query($con, $sqlUpdatePatient);
    
    // Increment the number of available beds in the room
    $sqlUpdateRoom = "UPDATE room SET noofavailbed = noofavailbed + 1 WHERE roomid='$roomid'";
    $resultUpdateRoom = mysqli_query($con, $sqlUpdateRoom);
    
    // Update discharge date in the admit table
    $sqlUpdateAdmit = "UPDATE admit SET dischargedate='$dischargedate' WHERE admissionid='$admissionid'";
    $resultUpdateAdmit = mysqli_query($con, $sqlUpdateAdmit);
    
    if($resultUpdatePatient && $resultUpdateRoom && $resultUpdateAdmit) {
        echo "<script>alert('Patient discharged successfully...');</script>";
    } else {
        echo mysqli_error($con);
    }
}

// Fetch admitted patients with status 'Admitted'
$sqlAdmittedPatients = "SELECT admit.*, patient.patientname, room.roomtype FROM admit 
                        INNER JOIN patient ON admit.patientid = patient.patientid
                        INNER JOIN room ON admit.roomid = room.roomid
                        WHERE patient.status = 'Admitted'";
$resultAdmittedPatients = mysqli_query($con, $sqlAdmittedPatients);
?>

<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center">Discharge Admitted Patients</h2>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                   
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-basic-example">
                            <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Admission Date</th>
                                    <th>Room Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while($row = mysqli_fetch_assoc($resultAdmittedPatients)) {
                                    echo "<tr>";
                                    echo "<td>".$row['patientname']."</td>";
                                    echo "<td>".$row['admissiondate']."</td>";
                                    echo "<td>".$row['roomtype']."</td>";
                                    echo "<td><form method='post'><input type='hidden' name='admissionid' value='".$row['admissionid']."'><input type='hidden' name='patientid' value='".$row['patientid']."'><input type='hidden' name='roomid' value='".$row['roomid']."'><input type='date' name='dischargedate' required><button type='submit' name='submit'  class='btn btn-sm btn-raised bg-blush'>Discharge</button></form></td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'adfooter.php'; ?>
