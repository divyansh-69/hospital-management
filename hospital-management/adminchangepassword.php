<?php
include("adheader.php");
include("dbconnection.php");
session_start();

if(isset($_POST['submit'])) {
    $old_password = mysqli_real_escape_string($con, $_POST['oldpassword']);
    $new_password = mysqli_real_escape_string($con, $_POST['newpassword']);

    // Hash the new password before updating
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $sql = "UPDATE admin SET password='$hashed_password' WHERE adminid='$_SESSION[adminid]' AND password='$old_password'";
    $qsql = mysqli_query($con, $sql);

    if(mysqli_affected_rows($con) == 1) {
        echo "<div class='alert alert-success'>Password updated successfully</div>";
    } else {
        echo "<div class='alert alert-warning'>Failed to update password</div>";
    }
}
?>

<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center">Admin's Password</h2>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <form method="post" action="" name="frmadminprofile" onSubmit="return validateform1()">
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-12">   
                                <div class="form-group">
                                    <div class="form-line">
                                        <input class="form-control" type="password" name="oldpassword" id="oldpassword" placeholder="Old Password" required />
                                    </div>
                                </div>
                            </div>	
                        </div>
                        <div class="row clearfix"> 
                            <div class="col-sm-12">                           
                                <div class="form-group">
                                    <div class="form-line">
                                        <input class="form-control" type="password" name="newpassword" id="newpassword" placeholder="New Password" required />
                                    </div>
                                </div>    
                            </div>                      
                        </div>  
                        <div class="row clearfix"> 
                            <div class="col-sm-12">                              
                                <div class="form-group">
                                    <div class="form-line">
                                        <input class="form-control" type="password" name="password" id="password" placeholder="Confirm Password" required />
                                    </div>
                                </div>
                            </div>                          
                        </div>                     
                        <div class="col-sm-12">
                            <input type="submit" class="btn btn-raised g-bg-cyan" name="submit" id="submit" value="Submit" />
                        </div>
                    </div>
                </form>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>

<?php
include("adfooter.php");
?>

<script type="application/javascript">
function validateform1() {
    var oldPassword = document.getElementById("oldpassword").value;
    var newPassword = document.getElementById("newpassword").value;
    var confirmPassword = document.getElementById("password").value;

    if(oldPassword == "") {
        alert("Old password should not be empty.");
        return false;
    } else if(newPassword == "") {
        alert("New Password should not be empty.");
        return false;
    } else if(newPassword.length < 8) {
        alert("New Password length should be more than 8 characters.");
        return false;
    } else if(newPassword != confirmPassword) {
        alert("New Password and Confirm Password should be equal.");
        return false;
    } else {
        return true;
    }
}
</script>
