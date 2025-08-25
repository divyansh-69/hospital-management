<?php
include("dbconnection.php");

if(isset($_POST['submit'])) {
    // Get patient ID from the form
    $patientid = $_POST['patientid'];

    // File upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["pdfFile"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["pdfFile"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only PDF files
    if($fileType != "pdf") {
        echo "Sorry, only PDF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $target_file)) {
            // File uploaded successfully, now insert the file path into the database
            $pdfFilePath = $target_file;
            // Insert PDF file path into the database
            $sql = "INSERT INTO patient_reports (patientid, report_path) VALUES ('$patientid', '$pdfFilePath')";
            $result = mysqli_query($con, $sql);
            if($result) {
                echo "The file " . htmlspecialchars(basename($_FILES["pdfFile"]["name"])) . " has been uploaded and report added.";
            } else {
                echo "Error: Unable to add report to the database.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
