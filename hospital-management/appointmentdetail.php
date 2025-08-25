<?php

include("dbconnection.php");

if(isset($_POST['submitapp'])) {
    $appointmenttype = mysqli_real_escape_string($con, $_POST['select']);
    $roomid = mysqli_real_escape_string($con, $_POST['select2']);
    $departmentid = mysqli_real_escape_string($con, $_POST['select3']);
    $appointmentdate = mysqli_real_escape_string($con, $_POST['date']);
    $appointmenttime = mysqli_real_escape_string($con, $_POST['time']);
    $doctorid = mysqli_real_escape_string($con, $_POST['select5']);

    $sql ="INSERT INTO appointment(appointmenttype,roomid,departmentid,appointmentdate,appointmenttime,doctorid) values('$appointmenttype','$roomid','$departmentid','$appointmentdate','$appointmenttime','$doctorid')";
    if($qsql = mysqli_query($con, $sql)) {
        echo "<script>alert('Appointment record inserted successfully...');</script>";
    } else {
        echo mysqli_error($con);
    }
}

if(isset($_GET['editid'])) {
    $editid = mysqli_real_escape_string($con, $_GET['editid']);
    $sql = "SELECT * FROM appointment WHERE appointmentid='$editid'";
    $qsql = mysqli_query($con, $sql);
    $rsedit = mysqli_fetch_array($qsql);
}

$sqlappointment1 = "SELECT max(appointmentid) FROM appointment where patientid='" . mysqli_real_escape_string($con, $_GET['patientid']) . "' AND (status='Active' OR status='Approved')";
$qsqlappointment1 = mysqli_query($con, $sqlappointment1);
$rsappointment1 = mysqli_fetch_array($qsqlappointment1);

if(mysqli_num_rows($qsqlappointment1) == 0) {
    echo "<center><h2>No Appointment records found..</h2></center>";
} else {
    $sqlappointment = "SELECT * FROM appointment where appointmentid='$rsappointment1[0]'";
    $qsqlappointment = mysqli_query($con, $sqlappointment);
    $rsappointment = mysqli_fetch_array($qsqlappointment);

    $sqlroom = "SELECT * FROM room where roomid='$rsappointment[roomid]' ";
    $qsqlroom = mysqli_query($con, $sqlroom);
    $rsroom = mysqli_fetch_array($qsqlroom);

    $sqldepartment = "SELECT * FROM department where departmentid='$rsappointment[departmentid]'";
    $qsqldepartment = mysqli_query($con, $sqldepartment);
    $rsdepartment = mysqli_fetch_array($qsqldepartment);

    $sqldoctor = "SELECT * FROM doctor where doctorid='$rsappointment[doctorid]'";
    $qsqldoctor = mysqli_query($con, $sqldoctor);
    $rsdoctor = mysqli_fetch_array($qsqldoctor);
?>

<table class="table table-bordered table-striped">
    <tr>
        <td>Department</td>
        <td>&nbsp;<?php echo $rsdepartment['departmentname']; ?></td>
    </tr>
    <tr>
        <td>Doctor</td>
        <td>&nbsp;<?php echo $rsdoctor['doctorname']; ?></td>
    </tr>
    <tr>
        <td>Appointment Date</td>
        <td>&nbsp;<?php echo date("d-M-Y",strtotime($rsappointment['appointmentdate'])); ?></td>
    </tr>
    <tr>
        <td>Appointment Time</td>
        <td>&nbsp;<?php echo date("h:i A",strtotime($rsappointment['appointmenttime'])); ?></td>
    </tr>
</table>
<?php
}
?>

<script type="application/javascript">
function validateform() {
    if(document.frmappntdetail.select.value == "") {
        alert("Appointment type should not be empty..");
        document.frmappntdetail.select.focus();
        return false;
    } else if(document.frmappntdetail.select2.value == "") {
        alert("Room type should not be empty..");
        document.frmappntdetail.select2.focus();
        return false;
    } else if(document.frmappntdetail.select3.value == "") {
        alert("Department name should not be empty..");
        document.frmappntdetail.select3.focus();
        return false;
    } else if(document.frmappntdetail.date.value == "") {
        alert("Appointment date should not be empty..");
        document.frmappntdetail.date.focus();
        return false;
    } else if(document.frmappntdetail.time.value == "") {
        alert("Appointment time should not be empty..");
        document.frmappntdetail.time.focus();
        return false;
    } else if(document.frmappntdetail.select5.value == "") {
        alert("Doctor name should not be empty..");
        document.frmappntdetail.select5.focus();
        return false;
    } else {
        return true;
    }
}
</script>
