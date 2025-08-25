<?php
include("adformheader.php");
include("dbconnection.php");

if(isset($_GET['delid'])) {
    $delid = $_GET['delid'];
    $sql = "DELETE FROM doctor WHERE doctorid='$delid'";
    $qsql = mysqli_query($con, $sql);
    if(mysqli_affected_rows($con) == 1) {
        echo "<script>alert('Doctor record deleted successfully.');</script>";
    }
}
?>
<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center">View Available Doctors</h2>
    </div>
    <div class="card">
        <section class="container">
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Department</th>
                        <th>LoginID</th>
                        <th>Consultancy Charge</th>
                        <th>Education</th>
                        <th>Experience</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM doctor";
                    $qsql = mysqli_query($con, $sql);
                    while($rs = mysqli_fetch_array($qsql)) {
                        $sqldept = "SELECT * FROM department WHERE departmentid='$rs[departmentid]'";
                        $qsqldept = mysqli_query($con, $sqldept);
                        $rsdept = mysqli_fetch_array($qsqldept);
                        echo "<tr>
                                <td>$rs[doctorname]</td>
                                <td>$rs[mobileno]</td>
                                <td>$rsdept[departmentname]</td>
                                <td>$rs[loginid]</td>
                                <td>$rs[consultancy_charge]</td>
                                <td>$rs[education]</td>
                                <td>$rs[experience] year</td>
                                <td>$rs[status]</td>
                                <td>
                                    <a href='doctor.php?editid=$rs[doctorid]' class='btn btn-sm btn-raised g-bg-cyan'>Edit</a>
                                    <a href='viewdoctor.php?delid=$rs[doctorid]' class='btn btn-sm btn-raised g-bg-blush2'>Delete</a>
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
