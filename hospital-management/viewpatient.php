<?php
include("adformheader.php");
include("dbconnection.php");

// Check if form is submitted
if(isset($_POST['submit'])) {
    $patientid = $_POST['patientid'];
    
    // File upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["pdfFile"]["name"]);
    
    if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $target_file)) {
        // File uploaded successfully, now update the database with the file path
        $sql = "UPDATE patient SET report_file = '$target_file' WHERE patientid='$patientid'";
        $qsql = mysqli_query($con, $sql);
        if($qsql) {
            echo "<script>alert('Report uploaded successfully.');</script>";
        } else {
            echo "<script>alert('Error uploading report.');</script>";
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

?>

<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center">View Patient Records</h2>
    </div>

    <div class="card">
        <section class="container">
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <thead>
                    <tr>
                        <th width="15%" height="36"><div align="center">Name</div></th>
                        <th width="20%"><div align="center">Admission</div></th>
                        <th width="28%"><div align="center">Address, Contact</div></th>    
                        <th width="20%"><div align="center">Patient Profile</div></th>
                        <th width="17%"><div align="center">Action</div></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql ="SELECT * FROM patient";
                    $qsql = mysqli_query($con,$sql);
                    while($rs = mysqli_fetch_array($qsql)) {
                        echo "<tr>
                            <td>{$rs['patientname']}<br>
                            <strong>Login ID :</strong> {$rs['loginid']} </td>
                            <td>
                            <strong>Date</strong>: &nbsp;{$rs['admissiondate']}<br>
                            <strong>Time</strong>: &nbsp;{$rs['admissiontime']}</td>
                            <td>{$rs['address']}<br>{$rs['city']} -  &nbsp;{$rs['pincode']}<br>
                            Mob No. - {$rs['mobileno']}</td>
                            <td><strong>Blood group</strong> - {$rs['bloodgroup']}<br>
                            <strong>Gender</strong> - &nbsp;{$rs['gender']}<br>
                            <strong>DOB</strong> - &nbsp;{$rs['dob']}</td>
                            <td align='center'>Status - {$rs['status']} <br>
                            <a href='patient.php?editid={$rs['patientid']}' class='btn btn-sm btn-raised bg-green'>Edit</a>
                            <a href='viewpatient.php?delid={$rs['patientid']}' class='btn btn-sm btn-raised bg-blush'>Delete</a> <hr>
                            <a href='patientreport.php?patientid={$rs['patientid']}' class='btn btn-sm btn-raised bg-cyan'>View Report</a>
                            <form action='' method='post' enctype='multipart/form-data'>
                                <input type='file' name='pdfFile' accept='.pdf' required>
                                <input type='hidden' name='patientid' value='{$rs['patientid']}'>
                                <input type='submit' name='submit' value='Upload Report'>
                            </form>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>
</div>

<?php
include("adformfooter.php");
?>
