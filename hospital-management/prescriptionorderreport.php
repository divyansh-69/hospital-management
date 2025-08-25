<?php
include("header.php");
include("dbconnection.php");

if(isset($_GET['delid'])) {
    $delid = mysqli_real_escape_string($con, $_GET['delid']);
    $sql = "DELETE FROM prescription_records WHERE prescription_record_id='$delid'";
    $qsql = mysqli_query($con, $sql);
    if($qsql && mysqli_affected_rows($con) == 1) {
        echo "<script>alert('Prescription deleted successfully..');</script>";
    } else {
        echo "<script>alert('Failed to delete prescription.');</script>";
    }
}

if(isset($_POST['submit'])) {
    $prescriptionid = mysqli_real_escape_string($con, $_POST['prescriptionid']);
    $medicine = mysqli_real_escape_string($con, $_POST['medicine']);
    $cost = mysqli_real_escape_string($con, $_POST['cost']);
    $unit = mysqli_real_escape_string($con, $_POST['unit']);
    $dosage = mysqli_real_escape_string($con, $_POST['select2']);
    $status = mysqli_real_escape_string($con, $_POST['select']);
    
    if(isset($_GET['editid'])) {
        $editid = mysqli_real_escape_string($con, $_GET['editid']);
        $sql ="UPDATE prescription_records SET prescription_id='$prescriptionid', medicine_name='$medicine', cost='$cost', unit='$unit', dosage='$dosage', status='$status' WHERE prescription_record_id='$editid'";
        $qsql = mysqli_query($con, $sql);
        if($qsql) {
            echo "<script>alert('Prescription record updated successfully...');</script>";
        } else {
            echo "<script>alert('Failed to update prescription record.');</script>";
        }
    } else {
        $sql ="INSERT INTO prescription_records(prescription_id, medicine_name, cost, unit, dosage, status) values('$prescriptionid', '$medicine', '$cost', '$unit', '$dosage', '$status')";
        $qsql = mysqli_query($con, $sql);
        if($qsql) {    
            echo "<script>alert('Prescription record inserted successfully...');</script>";
        } else {
            echo "<script>alert('Failed to insert prescription record.');</script>";
        }
    }
}

if(isset($_GET['editid'])) {
    $editid = mysqli_real_escape_string($con, $_GET['editid']);
    $sql = "SELECT * FROM prescription_records WHERE prescription_record_id='$editid'";
    $qsql = mysqli_query($con, $sql);
    $rsedit = mysqli_fetch_array($qsql);
}

?>

<!-- Your HTML content here -->

<?php
include("footer.php");
?>

<script type="application/javascript">
function validateform() {
    var prescriptionid = document.frmpresrecord.prescriptionid.value;
    var medicine = document.frmpresrecord.medicine.value;
    var cost = document.frmpresrecord.cost.value;
    var unit = document.frmpresrecord.unit.value;
    var dosage = document.frmpresrecord.select2.value;
    var status = document.frmpresrecord.select.value;

    if(prescriptionid == "") {
        alert("Prescription id should not be empty.");
        return false;
    } else if(medicine == "") {
        alert("Medicine field should not be empty.");
        return false;
    } else if(cost == "") {
        alert("Cost should not be empty.");
        return false;
    } else if(unit == "") {
        alert("Unit should not be empty.");
        return false;
    } else if(dosage == "") {
        alert("Dosage should not be empty.");
        return false;
    } else if(status == "") {
        alert("Kindly select the status.");
        return false;
    }
    return true;
}
</script>
