<?php
include("adheader.php");
include("dbconnection.php");

if(isset($_POST['submit'])) {
    if(isset($_GET['editid'])) {
        // Update existing admission record
        $admissionid = mysqli_real_escape_string($con, $_GET['editid']);
        $patientid = mysqli_real_escape_string($con, $_POST['select4']);
        $admissiondate = mysqli_real_escape_string($con, $_POST['admissiondate']);
        $doctorid = mysqli_real_escape_string($con, $_POST['select6']);
        $roomid = mysqli_real_escape_string($con, $_POST['select7']);

        // Update the admit table
        $sql ="UPDATE admit SET patientid='$patientid', admissiondate='$admissiondate', doctorid='$doctorid', roomid='$roomid' WHERE admissionid='$admissionid'";
        
        if($qsql = mysqli_query($con, $sql)) {
            echo "<script>alert('Admission record updated successfully...');</script>";
        } else {
            echo mysqli_error($con);
        }	
    } else {
        // Insert new admission record
        $patientid = mysqli_real_escape_string($con, $_POST['select4']);
        $admissiondate = mysqli_real_escape_string($con, $_POST['admissiondate']);
        $doctorid = mysqli_real_escape_string($con, $_POST['select6']);
        $roomid = mysqli_real_escape_string($con, $_POST['select7']);
        
        // Check if there are available beds in the selected room
        $sqlCheckBeds = "SELECT noofavailbed FROM room WHERE roomid='$roomid'";
        $resultCheckBeds = mysqli_query($con, $sqlCheckBeds);
        $rowCheckBeds = mysqli_fetch_assoc($resultCheckBeds);
        $availableBeds = $rowCheckBeds['noofavailbed'];
        
        if ($availableBeds > 0) {
            // Update the patient status
            $sqlUpdatePatient = "UPDATE patient SET status='Admitted' WHERE patientid='$patientid'";
            $resultUpdatePatient = mysqli_query($con, $sqlUpdatePatient);
            
            // Insert into admit table
            $sqlInsertAdmit = "INSERT INTO admit(patientid, admissiondate, doctorid, roomid) values('$patientid', '$admissiondate', '$doctorid', '$roomid')";
            $resultInsertAdmit = mysqli_query($con, $sqlInsertAdmit);
            
            // Decrease the number of available beds in the room
            $sqlUpdateRoom = "UPDATE room SET noofavailbed = noofavailbed - 1 WHERE roomid='$roomid'";
            $resultUpdateRoom = mysqli_query($con, $sqlUpdateRoom);
            
            echo "<script>alert('Patient admitted successfully...');</script>";
        } else {
            echo "<script>alert('No available beds in the selected room.');</script>";
        }
    }
}

if(isset($_GET['editid'])) {
	$editid = mysqli_real_escape_string($con, $_GET['editid']);
	$sql="SELECT * FROM admit WHERE admissionid='$editid'";
	$qsql = mysqli_query($con, $sql);
	$rsedit = mysqli_fetch_array($qsql);
}
?>

<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center">Admit Patient</h2>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Patient Admission Information </h2>
                </div>
                <form method="post" action="" name="frmadmit" onSubmit="return validateform()">
                    <input type="hidden" name="select2" value="Offline">
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <?php
                                        if(isset($_GET['patid'])) {
                                            $patid = mysqli_real_escape_string($con, $_GET['patid']);
                                            $sqlpatient= "SELECT * FROM patient WHERE patientid='$patid'";
                                            $qsqlpatient = mysqli_query($con, $sqlpatient);
                                            $rspatient = mysqli_fetch_array($qsqlpatient);
                                            echo $rspatient['patientname'] . " (Patient ID - $rspatient[patientid])";
                                            echo "<input type='hidden' name='select4' value='$rspatient[patientid]'>";
                                        } else {
                                            ?>
                                            <select name="select4" id="select4" class=" form-control show-tick">
                                                <option value="">Select Patient</option>
                                                <?php
                                                $sqlpatient= "SELECT * FROM patient WHERE status='Active'";
                                                $qsqlpatient = mysqli_query($con, $sqlpatient);
                                                while($rspatient = mysqli_fetch_array($qsqlpatient)) {
                                                    if($rspatient['patientid'] == $rsedit['patientid']) {
                                                        echo "<option value='$rspatient[patientid]' selected>$rspatient[patientid] - $rspatient[patientname]</option>";
                                                    } else {
                                                        echo "<option value='$rspatient[patientid]'>$rspatient[patientid] - $rspatient[patientname]</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <div class="row clearfix">
                            <div class="col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input class="form-control" type="date" name="admissiondate" id="admissiondate" value="<?php echo $rsedit['admissiondate']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select name="select6" id="select6" class=" form-control show-tick">
                                            <option value="">Select Doctor</option>
                                            <?php
                                            $sqldoctor= "SELECT * FROM doctor INNER JOIN department ON department.departmentid=doctor.departmentid WHERE doctor.status='Active'";
                                            $qsqldoctor = mysqli_query($con, $sqldoctor);
                                            while($rsdoctor = mysqli_fetch_array($qsqldoctor)) {
                                                if($rsdoctor['doctorid'] == $rsedit['doctorid']) {
                                                    echo "<option value='$rsdoctor[doctorid]' selected>$rsdoctor[doctorname] ( $rsdoctor[departmentname] ) </option>";
                                                } else {
                                                    echo "<option value='$rsdoctor[doctorid]'>$rsdoctor[doctorname] ( $rsdoctor[departmentname] )</option>";				
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select name="select7" id="select7" class=" form-control show-tick">
                                            <option value="">Select Room</option>
                                            <?php
                                            $sqlRooms = "SELECT * FROM room WHERE status='Active'";
                                            $queryRooms = mysqli_query($con, $sqlRooms);
                                            while($room = mysqli_fetch_assoc($queryRooms)) {
                                                if($room['roomid'] == $rsedit['roomid']) {
                                                    echo "<option value='".$room['roomid']."' selected>".$room['roomtype']."</option>";
                                                } else {
                                                    echo "<option value='".$room['roomid']."'>".$room['roomtype']."</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <input type="submit" class="btn btn-raised g-bg-cyan" name="submit" id="submit" value="Submit" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'adfooter.php'; ?>


<script type="application/javascript">
function validateform() {
    if (document.frmadmit.select4.value == "") {
        alert("Patient name should not be empty..");
        document.frmadmit.select4.focus();
        return false;
    } else if (document.frmadmit.admissiondate.value == "") {
        alert("Admission date should not be empty..");
        document.frmadmit.admissiondate.focus();
        return false;
    } else if (document.frmadmit.select6.value == "") {
        alert("Doctor name should not be empty..");
        document.frmadmit.select6.focus();
        return false;
    } else if (document.frmadmit.select7.value == "") {
        alert("Room should not be empty..");
        document.frmadmit.select7.focus();
        return false;
    } else {
        return true;
    }
}
</script>
