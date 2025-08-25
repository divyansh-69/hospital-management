<table class="table table-bordered table-striped">
    <tbody>
        <tr>
            <th>Doctor</th>
            <th>Patient</th>
            <th>Prescription Date</th>
            
        </tr>
        <?php
        $sql ="SELECT * FROM prescription WHERE patientid='$_GET[patientid]'";
        $qsql = mysqli_query($con,$sql);
        while($rs = mysqli_fetch_array($qsql))
        {
            $sqlpatient = "SELECT * FROM patient WHERE patientid='$rs[patientid]'";
            $qsqlpatient = mysqli_query($con,$sqlpatient);
            $rspatient = mysqli_fetch_array($qsqlpatient);
            
            $sqldoctor = "SELECT * FROM doctor WHERE doctorid='$rs[doctorid]'";
            $qsqldoctor = mysqli_query($con,$sqldoctor);
            $rsdoctor = mysqli_fetch_array($qsqldoctor);

            echo "<tr>
                    <td>&nbsp;$rsdoctor[doctorname]</td>
                    <td>&nbsp;$rspatient[patientname]</td>
                    <td>&nbsp;$rs[prescriptiondate]</td>
                   
                </tr>";
        }
        ?>    
    </tbody>
</table>

