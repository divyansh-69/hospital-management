<?php
include("adheader.php");
include("dbconnection.php");
session_start();

if(isset($_POST['submit'])) {
    $oldPassword = mysqli_real_escape_string($con, $_POST['oldpassword']);
    $newPassword = mysqli_real_escape_string($con, $_POST['newpassword']);
    $confirmPassword = mysqli_real_escape_string($con, $_POST['password']);

    $patientId = mysqli_real_escape_string($con, $_SESSION['patientid']);

    $sql = "SELECT password FROM patient WHERE patientid='$patientId'";
    $result = mysqli_query($con, $sql);

    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];
        
        if(password_verify($oldPassword, $hashedPassword)) {
            if($newPassword === $confirmPassword) {
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateSql = "UPDATE patient SET password='$hashedNewPassword' WHERE patientid='$patientId'";
                $updateResult = mysqli_query($con, $updateSql);
                if($updateResult) {
                    echo "<div class='alert alert-success'>Password has been updated successfully</div>";
                } else {
                    echo "<div class='alert alert-danger'>Update Failed</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>New Password and confirm password should be equal</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Old password is incorrect</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error retrieving patient information</div>";
    }
}

?>

<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center"> Patient's Password</h2>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
               <form method="post" action="" name="frmpatchange" onSubmit="return validateform()"
                    style="padding: 10px">
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
function validateform()
{
    if(document.frmpatchange.oldpassword.value == "")
    {
        alert("Old password should not be empty..");
        document.frmpatchange.oldpassword.focus();
        return false;
    }
    else if(document.frmpatchange.newpassword.value == "")
    {
        alert("New Password should not be empty..");
        document.frmpatchange.newpassword.focus();
        return false;
    }
    else if(document.frmpatchange.newpassword.value.length < 6)
    {
        alert("New Password length should be more than 6 characters...");
        document.frmpatchange.newpassword.focus();
        return false;
    }
    else if(document.frmpatchange.newpassword.value != document.frmpatchange.password.value )
    {
        alert(" New Password and confirm password should be equal..");
        document.frmpatchange.password.focus();
        return false;
    }
    else
    {
        return true;
    }
}
</script>
