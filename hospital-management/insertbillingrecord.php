<?php
include("dbconnection.php");

// Get current date and time
$dt = date("Y-m-d");
$tim = date("H:i:s");

// Get the last appointment ID for the patient
$sqlappointment1 = "SELECT MAX(appointmentid) FROM appointment WHERE patientid='$_GET[patientid]' AND (status='Active' OR status='Approved')";
$qsqlappointment1 = mysqli_query($con, $sqlappointment1);
$rsappointment1 = mysqli_fetch_array($qsqlappointment1);

// Check if there are any billing records for the last appointment
$sql = "SELECT * FROM billing WHERE appointmentid='$rsappointment1[0]'";
$qsql = mysqli_query($con, $sql);
$rsbill = mysqli_fetch_array($qsql);

// If no billing records found, create a new billing record
if(mysqli_num_rows($qsql) == 0) {
    $sql = "INSERT INTO billing(patientid, appointmentid, billingdate, billingtime, discount, taxamount, discountreason, discharge_time, discharge_date) VALUES ('$_GET[patientid]', '$rsappointment1[0]', '$dt', '$tim', '0', '0', '', '', '')";
    $qsql = mysqli_query($con, $sql);
    $billid = mysqli_insert_id($con);
} else {
    $billid = $rsbill['id']; // Assuming the primary key column is named 'id'
}

// Process different types of bills
switch($billtype) {
    case "Room Rent":
        if($roomid != "") {
            $sqlroomtariff = "SELECT * FROM room WHERE roomid='$roomid'";
            $qsqlroomtariff = mysqli_query($con, $sqlroomtariff);
            $rsroomtariff = mysqli_fetch_array($qsqlroomtariff);
            
            $sql = "INSERT INTO billing_records(billingid, bill_type_id, bill_type, bill_amount, bill_date, status) VALUES ('$billid', '$roomid', 'Room Rent', '$rsroomtariff[room_tariff]', '$dt', 'Active')";
            $qsql = mysqli_query($con, $sql);
        }
        break;
    
    case "Doctor Charge":
        // Process Doctor Charge and Treatment Cost
        // Assuming $doctorid and $treatmentid are set before this point
        // Insert Consultancy Charge
        $sqldoctor = "SELECT * FROM doctor WHERE doctorid='$doctorid'";
        $qsqldoctor = mysqli_query($con, $sqldoctor);
        $rsdoctor = mysqli_fetch_array($qsqldoctor);
        
        $sqlconsu = "SELECT * FROM billing_records WHERE billingid='$billid' AND bill_type_id='$doctorid' AND bill_type='Consultancy Charge'";
        $qsqlcunsu = mysqli_query($con, $sqlconsu);
        
        if(mysqli_num_rows($qsqlcunsu) == 0) {
            $sql = "INSERT INTO billing_records(billingid, bill_type_id, bill_type, bill_amount, bill_date, status) VALUES ('$billid', '$doctorid', 'Consultancy Charge', '$rsdoctor[consultancy_charge]', '$dt', 'Active')";
            $qsql = mysqli_query($con, $sql);
        }
        
        // Insert Treatment Cost
        $sqltreatment = "SELECT * FROM treatment WHERE treatmentid='$treatmentid'";
        $qsqltreatment = mysqli_query($con, $sqltreatment);
        $rstreatment = mysqli_fetch_array($qsqltreatment);
        
        $sql = "INSERT INTO billing_records(billingid, bill_type_id, bill_type, bill_amount, bill_date, status) VALUES ('$billid', '$treatmentid', 'Treatment', '$rstreatment[treatment_cost]', '$dt', 'Active')";
        $qsql = mysqli_query($con, $sql);
        break;

    case "Prescription charge":
        // Process Prescription charge
        // Assuming $prescriptionid and $presamt are set before this point
        $sql = "INSERT INTO billing_records(billingid, bill_type_id, bill_type, bill_amount, bill_date, status) VALUES ('$billid', '$prescriptionid', 'Prescription Charge', '$presamt', '$dt', 'Active')";
        $qsql = mysqli_query($con, $sql);
        break;

    case "Prescription update":
        // Update Prescription charge
        // Assuming $prescriptionid is set before this point
        $sqlprescription_records = "SELECT SUM(cost * unit) FROM prescription_records WHERE prescription_id='$prescriptionid'";
        $qsqlprescription_records = mysqli_query($con, $sqlprescription_records);
        $rsprescription_records = mysqli_fetch_array($qsqlprescription_records);
        
        $sql = "UPDATE billing_records SET bill_amount='$rsprescription_records[0]' WHERE bill_type_id ='$prescriptionid'";
        $qsql = mysqli_query($con, $sql);
        break;

    case "Consultancy Charge":
        // Process Consultancy Charge
        // Assuming $doctorid and $billamt are set before this point
        $sql = "INSERT INTO billing_records(billingid, bill_type_id, bill_type, bill_amount, bill_date, status) VALUES ('$billid', '$doctorid', 'Consultancy Charge', '$billamt', '$dt', 'Active')";
        $qsql = mysqli_query($con, $sql);
        break;

    case "Service Charge":
        // Process Service Charge
        // Assuming $servicetypeid is set before this point
        $sqlservice_type = "SELECT * FROM service_type WHERE service_type_id='$servicetypeid'";
        $qsqlservice_type = mysqli_query($con, $sqlservice_type);
        $rsservice_type = mysqli_fetch_array($qsqlservice_type);
        $servicecharge = $rsservice_type['servicecharge'] + $_POST['amount'];
        
        $sql = "INSERT INTO billing_records(billingid, bill_type_id, bill_type, bill_amount, bill_date, status) VALUES ('$billid', '$servicetypeid', 'Service Charge', '$servicecharge', '$_POST[date]', 'Active')";
        $qsql = mysqli_query($con, $sql);
        
        echo "<script>alert('Service charge added successfully..');</script>";
        break;

    default:
        // Handle other cases or errors
        break;
}
?>
