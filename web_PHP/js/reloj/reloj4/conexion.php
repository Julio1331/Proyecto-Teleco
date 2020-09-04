<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "id13218228_lecturadatos";

// Create connection
$con = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}  
?>