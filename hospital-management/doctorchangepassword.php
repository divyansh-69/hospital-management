<?php
include("adheader.php");
include("dbconnection.php");

// Check if form is submitted
if(isset($_POST['submit'])) {
    // Sanitize input to prevent SQL injection
    $oldpassword = mysqli_real_escape_string($con, $_POST['oldpassword']);
    $newpassword = mysqli_real_escape_string($con, $_POST['newpassword']);
    
    // Get the current doctor's ID from session
    $doctorid = isset($_SESSION['doctorid']) ? $_SESSION['doctorid'] : '';

    // Check if old password matches
    $sql = "UPDATE doctor SET password='$newpassword' WHERE password='$oldpassword' AND doctorid='$doctorid'";
    $qsql = mysqli_query($con, $sql);
    if(mysqli_affected_rows($con) == 1) {
        echo "<script>alert('Password has been updated successfully..');</script>";
    } else {
        echo "<script>alert('Failed to update password..');</script>";		
    }
}
?>

<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center"> Doctor's Password</h2>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <form method="post" action="" name="frmdoctchangepass" onsubmit="return validateform1()" style="padding: 10px">
                    <div class="form-group">
                        <label>Old Password</label>
                        <div class="form-line">
                            <input class="form-control" type="password" name="oldpassword" id="oldpassword" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <div class="form-line">
                            <input class="form-control" type="password" name="newpassword" id="newpassword" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <div class="form-line">
                            <input class="form-control" type="password" name="password" id="password" />
                        </div>
                    </div>
                    <input class="btn btn-raised g-bg-cyan" type="submit" name="submit" id="submit" value="Submit" />
                </form>
                <p>&nbsp;</p>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
</div>
<?php
include("adfooter.php");
?>

<script type="application/javascript">
function validateform1() {
    if (document.frmdoctchangepass.oldpassword.value == "") {
        alert("Old password should not be empty..");
        document.frmdoctchangepass.oldpassword.focus();
        return false;
    } else if (document.frmdoctchangepass.newpassword.value == "") {
        alert("New Password should not be empty..");
        document.frmdoctchangepass.newpassword.focus();
        return false;
    } else if (document.frmdoctchangepass.newpassword.value.length < 8) {
        alert("New Password length should be more than 8 characters...");
        document.frmdoctchangepass.newpassword.focus();
        return false;
    } else if (document.frmdoctchangepass.newpassword.value != document.frmdoctchangepass.password.value) {
        alert("New Password and confirm password should be equal..");
        document.frmdoctchangepass.password.focus();
        return false;
    } else {
        return true;
    }
}
</script>
