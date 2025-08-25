<?php
include("header.php");
include("dbconnection.php");

// Check if patient ID is provided
if(isset($_GET['patient_id'])) {
    // Sanitize the input to prevent SQL injection
    $patient_id = mysqli_real_escape_string($con, $_GET['patient_id']);

    // Fetch billing information from the database based on patient ID
    $query = "SELECT * FROM billing1 WHERE patient_id = '$patient_id'";
    $result = mysqli_query($con, $query);

    // Check if billing information is found
    if(mysqli_num_rows($result) > 0) {
        $billing_info = mysqli_fetch_assoc($result);
    } else {
        $error_message = "No billing information found for this patient.";
    }
} else {
    $error_message = "Patient ID not provided.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Bill</title>
</head>
<body>
<div class="wrapper col2">
  <div id="breadcrumb">
    <ul>
      <li class="first">View Bill</li>
    </ul>
  </div>
</div>

<div class="wrapper col4">
  <div id="container">
    <h1>Bill Information</h1>
    <?php if(isset($billing_info)): ?>
    <table>
        <tr>
            <td>Patient ID:</td>
            <td><?php echo $billing_info['patient_id']; ?></td>
        </tr>
        <tr>
            <td>Appointment ID:</td>
            <td><?php echo $billing_info['appointment_id']; ?></td>
        </tr>
        <tr>
            <td>Billing Date:</td>
            <td><?php echo $billing_info['billing_date']; ?></td>
        </tr>
        <tr>
            <td>Bill Amount:</td>
            <td><?php echo $billing_info['bill_amount']; ?></td>
        </tr>
    </table>
    <?php else: ?>
    <p><?php echo isset($error_message) ? $error_message : ''; ?></p>
    <?php endif; ?>
  </div>
</div>

<?php
include("footer.php");
?>
</body>
</html>
