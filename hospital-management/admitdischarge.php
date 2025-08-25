<?php
include("adformheader.php");
include("dbconnection.php");

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Sanitize inputs to prevent SQL injection
    $patient_id = mysqli_real_escape_string($con, $_POST['patient_id']);
    $admit_date = mysqli_real_escape_string($con, $_POST['admit_date']);
    $discharge_date = mysqli_real_escape_string($con, $_POST['discharge_date']);
    $room_id = mysqli_real_escape_string($con, $_POST['room_id']);

    // Perform your insert operation here using the sanitized values
    // Make sure to use prepared statements for better security

    // Example query (replace with your actual query):
    $query = "INSERT INTO admit_discharge (patient_id, admit_date, discharge_date, room_id) VALUES ('$patient_id', '$admit_date', '$discharge_date', '$room_id')";
    mysqli_query($con, $query);
    header("Location: viewadmitdischarge.php");
    exit(); 
}
?>

<div class="wrapper col2">
  <div id="breadcrumb">
    <ul>
     
    </ul>
  </div>
</div>

<div class="wrapper col4">
  <div id="container">
    <h1>Admit Discharge</h1>
    <form method="post" action="viewadmitdischarge.php" name="frmadmit" onSubmit="return validateform()">

      <table width="342" border="3">
        <tbody>
          <tr>
            <td>Patient ID</td>
            <td><input type="text" name="patient_id" id="patient_id"></td>
          </tr>
          <tr>
            <td>Admit Date</td>
            <td><input min="<?php echo date("Y-m-d"); ?>" value="<?php echo date("Y-m-d"); ?>" type="date" name="admit_date" id="admit_date"></td>
          </tr>
          <tr>
            <td>Discharge Date</td>
            <td><input min="<?php echo date("Y-m-d"); ?>" value="<?php echo date("Y-m-d"); ?>" type="date" name="discharge_date" id="discharge_date"></td>
          </tr>
          <tr>
            <td>Room ID</td>
            <td><input type="text" name="room_id" id="room_id"></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Submit" /></td>
          </tr>
        </tbody>
      </table>
    </form>

    <?php
    // Fetch and display admit/discharge records or other related information here
    ?>

    <table width="342" border="3">
      <thead>
        
      </thead>
    </table>
    <p>&nbsp;</p>
  </div>
</div>

<script type="application/javascript">
  var numericExpression = /^[0-9]+$/; // Variable to validate only numbers

  function validateform() {
    if (document.frmadmit.patient_id.value == "") {
      alert("Patient ID should not be empty..");
      document.frmadmit.patient_id.focus();
      return false;
    } else if (document.frmadmit.admit_date.value == "") {
      alert("Admit Date should not be empty..");
      document.frmadmit.admit_date.focus();
      return false;
    } else if (document.frmadmit.discharge_date.value == "") {
      alert("Discharge Date should not be empty..");
      document.frmadmit.discharge_date.focus();
      return false;
    } else if (document.frmadmit.room_id.value == "") {
      alert("Room ID should not be empty..");
      document.frmadmit.room_id.focus();
      return false;
    } else if (!document.frmadmit.room_id.value.match(numericExpression)) {
      alert("Room ID should be numeric..");
      document.frmadmit.room_id.focus();
      return false;
    } else {
      return true;
    }
  }
</script>

<?php
include("adformfooter.php");
?>
