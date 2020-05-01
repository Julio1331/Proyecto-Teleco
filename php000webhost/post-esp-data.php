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

$api_key=  $temp = $hum = $mov = $gas = $aire = "";

$fecha = date("Y-m-d");
$hora = date("H:i:s");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {

        $temp = test_input($_POST["temp"]);
        $hum = test_input($_POST["hum"]);
        $mov = test_input($_POST["mov"]);
        $gas = test_input($_POST["gas"]);
        $aire = test_input($_POST["aire"]);
        
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
        
        //inserción tabla hcsr501
        $sql1 = "INSERT INTO hcsr501 (mov, fecha, hora)
        VALUES ('" . $mov . "', '" . $fecha. "', '" . $hora. "')";
        
        if ($conn->query($sql1) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql1 . "<br>" . $conn->error;
        }
        
        //inserción tabla mq1
        $sql2 = "INSERT INTO mq1 (gas, fecha, hora)
        VALUES ('" . $gas . "', '" . $fecha. "', '" . $hora. "')";
        
        if ($conn->query($sql2) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
        
        //inserción tabla mq2
        $sql3 = "INSERT INTO mq2 (aire, fecha, hora)
        VALUES ('" . $aire . "', '" . $fecha. "', '" . $hora. "')";
        
        if ($conn->query($sql3) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql3 . "<br>" . $conn->error;
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