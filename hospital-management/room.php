<?php
include("adformheader.php");
include("dbconnection.php");

if(isset($_POST['submit'])) {
    if(isset($_GET['editid'])) {
        $editid = mysqli_real_escape_string($con, $_GET['editid']);
        $roomtype = mysqli_real_escape_string($con, $_POST['select2']);
        $roomnumber = mysqli_real_escape_string($con, $_POST['roomnumber']);
        $numberofbeds = mysqli_real_escape_string($con, $_POST['numberofbeds']);
        $availbeds = mysqli_real_escape_string($con, $_POST['noofavailbed']);
        $roomtariff = mysqli_real_escape_string($con, $_POST['roomtariff']);
        $status = mysqli_real_escape_string($con, $_POST['select']);
        
        $sql = "UPDATE room SET roomtype='$roomtype', roomno='$roomnumber', noofbeds='$numberofbeds', noofavailbed='$availbeds' room_tariff='$roomtariff', status='$status' WHERE roomid='$editid'";
        
        if($qsql = mysqli_query($con, $sql)) {
            echo "<script>alert('Room record updated successfully...');</script>";
        } else {
            echo "<script>alert('Failed to update room record.');</script>";
            echo mysqli_error($con);
        }   
    } else {
        $roomtype = mysqli_real_escape_string($con, $_POST['select2']);
        $roomnumber = mysqli_real_escape_string($con, $_POST['roomnumber']);
        $numberofbeds = mysqli_real_escape_string($con, $_POST['numberofbeds']);
        $availbeds = mysqli_real_escape_string($con, $_POST['noofavailbed']);
        $roomtariff = mysqli_real_escape_string($con, $_POST['roomtariff']);
        $status = mysqli_real_escape_string($con, $_POST['select']);
        
        $sql = "INSERT INTO room(roomtype, roomno, noofbeds, noofavailbed,  room_tariff, status) VALUES ('$roomtype', '$roomnumber', '$numberofbeds', '$availbeds', '$roomtariff', '$status')";
        
        if($qsql = mysqli_query($con, $sql)) {
            echo "<script>alert('Room record inserted successfully...');</script>";
        } else {
            echo "<script>alert('Failed to insert room record.');</script>";
            echo mysqli_error($con);
        }
    }
}

if(isset($_GET['editid'])) {
    $editid = mysqli_real_escape_string($con, $_GET['editid']);
    $sql = "SELECT * FROM room WHERE roomid='$editid'";
    $qsql = mysqli_query($con, $sql);
    $rsedit = mysqli_fetch_array($qsql);
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
    <h1>Add New Room details record</h1>
    <form method="post" action="" name="frmroom" onSubmit="return validateform()">
      <table width="200" border="3">
        <tbody>
          <tr>
            <td width="34%">Room Type</td>
            <td width="66%">
              <select name="select2" id="select2">
                <option value="">Select</option>
                <?php
                $arr = array("GENERAL WARD","SPECIAL WARD");
                foreach($arr as $val) {
                    if($val == $rsedit['roomtype']) {
                        echo "<option value='$val' selected>$val</option>";
                    } else {
                        echo "<option value='$val'>$val</option>";
                    }
                }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td>Room Number</td>
            <td><input type="text" name="roomnumber" id="roomnumber" value="<?php echo $rsedit['roomno']; ?>"/></td>
          </tr>
          <tr>
            <td>Number of beds</td>
            <td><input type="text" name="numberofbeds" id="numberofbeds" value="<?php echo $rsedit['noofbeds']; ?>"/></td>
          </tr>
          <tr>
            <td>Number of available beds</td>
            <td><input type="text" name="noofavailbed" id="noofavailbed" value="<?php echo $rsedit['noofavailbed']; ?>"/></td>
          </tr>
          <tr>
            <td>Room tariff</td>
            <td><input type="text" name="roomtariff" id="roomtariff" value="<?php echo $rsedit['room_tariff']; ?>"/></td>
          </tr>
          <tr>
            <td>Status</td>
            <td>
              <select name="select" id="select">
                <option value="">Select</option>
                <?php
                $arr = array("Active","Inactive");
                foreach($arr as $val) {
                    if($val == $rsedit['status']) {
                        echo "<option value='$val' selected>$val</option>";
                    } else {
                        echo "<option value='$val'>$val</option>";
                    }
                }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Submit" /></td>
          </tr>
        </tbody>
      </table>
    </form>
    <p>&nbsp;</p>
  </div>
</div>
</div>
<div class="clear"></div>
</div>
</div>
<?php
include("adformfooter.php");
?>
<script type="application/javascript">
function validateform() {
    var roomtype = document.frmroom.select2.value;
    var roomnumber = document.frmroom.roomnumber.value;
    var numberofbeds = document.frmroom.numberofbeds.value;
    var availbeds = document.frmroom.noofavailbed.value;
    var status = document.frmroom.select.value;

    if(roomtype == "") {
        alert("Room type should not be empty.");
        document.frmroom.select2.focus();
        return false;
    } else if(roomnumber == "") {
        alert("Room number should not be empty.");
        document.frmroom.roomnumber.focus();
        return false;
    } else if(isNaN(roomnumber)) {
        alert("Room number should be numeric.");
        document.frmroom.roomnumber.focus();
        return false;
    } else if(numberofbeds == "") {
        alert("Number of beds should not be empty.");
        document.frmroom.numberofbeds.focus();
        return false;
    } else if(isNaN(numberofbeds)) {
        alert("Number of beds should be numeric.");
        document.frmroom.numberofbeds.focus();
        return false;
    } else if(status == "") {
        alert("Please select the status.");
        document.frmroom.select.focus();
        return false;
    } else {
        return true;
    }
}
</script>
