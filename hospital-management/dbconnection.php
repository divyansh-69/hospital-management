<?php
// Create connection
$con = new mysqli("localhost", "root", "", "ohmsphp");

// Check connection
if ($con->connect_error) {
    die("Failed to connect to MySQL: " . $con->connect_error);
}
?>
