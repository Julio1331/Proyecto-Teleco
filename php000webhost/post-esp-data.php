<?php



$servername = "localhost";

// REPLACE with your Database name
$dbname = "id13218228_lecturadatos";
// REPLACE with Database user
$username = "id13218228_julio";
// REPLACE with Database user password
$password = "4XY8C-9sQdac+]48";//anotado

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$api_key=  $temp = $hum = $mov = "";

$fecha = date("d-m-Y");
$hora = date("H:i:s");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {

        $temp = test_input($_POST["temp"]);
        $hum = test_input($_POST["hum"]);
        $mov = test_input($_POST["mov"]);
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        //inserción tabla dth11
        $sql = "INSERT INTO dth11 (temp, hum, fecha, hora)
        VALUES ('" . $temp . "', '" . $hum . "', '" . $fecha. "', '" . $hora. "')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        //inserción tabla hc-sr501
        $sql1 = "INSERT INTO hcsr501 (mov, fecha, hora)
        VALUES ('" . $mov . "', '" . $fecha. "', '" . $hora. "')";
        
        if ($conn->query($sql1) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>