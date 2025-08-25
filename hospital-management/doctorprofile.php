<?php
include("adheader.php");
include("dbconnection.php");

if(isset($_POST['submit'])) {
    if(isset($_SESSION['doctorid'])) {
        $sql ="UPDATE doctor SET doctorname='{$_POST['doctorname']}', mobileno='{$_POST['mobilenumber']}', departmentid='{$_POST['select3']}', loginid='{$_POST['loginid']}', education='{$_POST['education']}', experience='{$_POST['experience']}', consultancy_charge='{$_POST['consultancy_charge']}' WHERE doctorid='{$_SESSION['doctorid']}'";
        if($qsql = mysqli_query($con, $sql)) {
            echo "<script>alert('Doctor profile updated successfully...');</script>";
        } else {
            echo mysqli_error($con);
        }   
    } else {
        $sql ="INSERT INTO doctor(doctorname, mobileno, departmentid, loginid, password, status, education, experience) values('{$_POST['doctorname']}', '{$_POST['mobilenumber']}', '{$_POST['select3']}', '{$_POST['loginid']}', '{$_POST['password']}', '{$_POST['select']}', '{$_POST['education']}', '{$_POST['experience']}')";
        if($qsql = mysqli_query($con, $sql)) {
            echo "<script>alert('Doctor record inserted successfully...');</script>";
        } else {
            echo mysqli_error($con);
        }
    }
}

if(isset($_SESSION['doctorid'])) {
    $sql="SELECT * FROM doctor WHERE doctorid='{$_SESSION['doctorid']}' ";
    $qsql = mysqli_query($con, $sql);
    $rsedit = mysqli_fetch_array($qsql);
}
?>

<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center"> Doctor's Profile</h2>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <form method="post" action="" name="frmdoctprfl" onSubmit="return validateform()" style="padding: 10px">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Doctor Name</label>
                                <div class="form-line">
                                    <input class="form-control" type="text" name="doctorname" id="doctorname" value="<?php echo $rsedit['doctorname']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Mobile Number</label>
                                <div class="form-line">
                                    <input class="form-control" type="text" name="mobilenumber" id="mobilenumber" value="<?php echo $rsedit['mobileno']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Department</label>
                                <div class="form-line">
                                    <select name="select3" id="select3" class="form-control show-tick">
                                        <option value="">Select</option>
                                        <?php
                                        $sqldepartment = "SELECT * FROM department WHERE status='Active'";
                                        $qsqldepartment = mysqli_query($con, $sqldepartment);
                                        while($rsdepartment = mysqli_fetch_array($qsqldepartment)) {
                                            $selected = ($rsdepartment['departmentid'] == $rsedit['departmentid']) ? "selected" : "";
                                            echo "<option value='{$rsdepartment['departmentid']}' $selected>{$rsdepartment['departmentname']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Other form fields here -->
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Consultancy charge</label>
                                <div class="form-line">
                                    <input class="form-control" type="text" name="consultancy_charge" id="consultancy_charge" value="<?php echo $rsedit['consultancy_charge']; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <input class="btn btn-raised" type="submit" name="submit" id="submit" value="Submit" />
                </form>
                <p>&nbsp;</p>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php
include("adfooter.php");
?>

<script type="application/javascript">
// Validation script here
</script>
