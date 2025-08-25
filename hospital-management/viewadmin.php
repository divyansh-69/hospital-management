<?php
include("adformheader.php");
include("dbconnection.php");

if(isset($_GET['delid'])) {
    $delid = $_GET['delid'];
    $sql = "DELETE FROM admin WHERE adminid='$delid'";
    $qsql = mysqli_query($con, $sql);
    if(mysqli_affected_rows($con) == 1) {
        echo "<script>alert('Admin record deleted successfully..');</script>";
    }
}
?>

<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center">View Admin</h2>
    </div>
</div>

<div class="card">
    <section class="container">
        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
            <thead>
                <tr>
                    <th width="12%" height="40">Admin Name</th>
                    <th width="11%">Login ID</th>
                    <th width="12%">Status</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM admin";
                $qsql = mysqli_query($con, $sql);
                while($rs = mysqli_fetch_array($qsql)) {
                    echo "<tr>
                            <td>$rs[adminname]</td>
                            <td>$rs[loginid]</td>
                            <td>$rs[status]</td>
                            <td>
                                <a href='admin.php?editid=$rs[adminid]' class='btn btn-raised g-bg-cyan'>Edit</a>
                                <a href='viewadmin.php?delid=$rs[adminid]' class='btn btn-raised g-bg-blush2'>Delete</a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</div>

<?php
include("adformfooter.php");
?>
