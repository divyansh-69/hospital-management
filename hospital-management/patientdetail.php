<?php
include("dbconnection.php");

// Handle form submission
if(isset($_POST['submitpat'])) {
    // Escape user inputs to prevent SQL injection
    $patientname = mysqli_real_escape_string($con, $_POST['patientname']);
    $admissiondate = mysqli_real_escape_string($con, $_POST['admissiondate']);
    $admissiontime = mysqli_real_escape_string($con, $_POST['admissiontime']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $mobilenumber = mysqli_real_escape_string($con, $_POST['mobilenumber']);
    $gender = mysqli_real_escape_string($con, $_POST['select']);
    $dob = mysqli_real_escape_string($con, $_POST['dateofbirth']);
    
    // Perform insert query
    $sql ="INSERT INTO patient(patientname,admissiondate,admissiontime,address,mobileno,gender,dob) 
           VALUES('$patientname','$admissiondate','$admissiontime','$address','$mobilenumber','$gender','$dob')";
    
    if($qsql = mysqli_query($con, $sql)) {
        echo "<script>alert('Patients record inserted successfully...');</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

if(isset($_GET['editid'])) {
    // Fetch patient details for editing
    $sql = "SELECT * FROM patient WHERE patientid='" . $_GET['editid'] . "'";
    $qsql = mysqli_query($con, $sql);
    $rsedit = mysqli_fetch_array($qsql);
}
?>
      
<?php
if(isset($_GET['patientid'])) {
    $sqlpatient = "SELECT * FROM patient WHERE patientid='" . $_GET['patientid'] . "'";
    $qsqlpatient = mysqli_query($con, $sqlpatient);
    $rspatient = mysqli_fetch_array($qsqlpatient);
?>

<table class="table table-bordered table-striped">
    <tbody>
        <tr>
            <td width="16%"><strong>Patient Name</strong></td>
            <td width="34%">&nbsp;<?php echo $rspatient['patientname']; ?></td>
            <td width="16%"><strong>Patient ID</strong></td>
            <td width="34%">&nbsp;<?php echo $rspatient['patientid']; ?></td>
        </tr>
        <tr>
            <td><strong>Address</strong></td>
            <td>&nbsp;<?php echo $rspatient['address']; ?></td>
            <td><strong>Gender</strong></td>
            <td>&nbsp;<?php echo $rspatient['gender']; ?></td>
</tr>
<tr>
    <td><strong>Contact Number</strong></td>
    <td>&nbsp;<?php echo $rspatient['mobileno']; ?></td>
    <td><strong>Date Of Birth </strong></td>
    <td>&nbsp;<?php echo $rspatient['dob']; ?></td>
</tr>
</tbody>
</table>
<?php
}
?>

<script type="application/javascript">
function validateform() {
    if(document.frmpatdet.patientname.value == "") {
        alert("Patient name should not be empty..");
        document.frmpatdet.patientname.focus();
        return false;
    } else if(document.frmpatdet.patientid.value == "") {
        alert("Patient ID should not be empty..");
        document.frmpatdet.patientid.focus();
        return false;
    } else if(document.frmpatdet.address.value == "") {
        alert("Address should not be empty..");
        document.frmpatdet.address.focus();
        return false;
    } else if(document.frmpatdet.select.value == "") {
        alert("Gender should not be empty..");
        document.frmpatdet.select.focus();
        return false;
    } else if(document.frmpatdet.mobilenumber.value == "") {
        alert("Contact number should not be empty..");
        document.frmpatdet.mobilenumber.focus();
        return false;
    } else if(document.frmpatdet.dateofbirth.value == "") {
        alert("Date Of Birth should not be empty..");
        document.frmpatdet.dateofbirth.focus();
        return false;
    } else {
        return true;
    }
}
</script>
