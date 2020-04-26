<!DOCTYPE html>
<html><body>
<?php

$servername = "localhost";

// REPLACE with your Database name
$dbname = "id13218228_lecturadatos";
// REPLACE with Database user
$username = "id13218228_julio";
// REPLACE with Database user password
$password = "4XY8C-9sQdac+]48";//anotado

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM dth11 ORDER BY id_TH DESC";

echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <td>ID</td> 
        <td>Temp</td> 
        <td>Hum</td> 
        <td>fecha</td> 
        <td>hora</td>
      </tr>';
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_id_TH = $row["id_TH"];
        $row_sensor = $row["temp"];
        $row_location = $row["hum"];
        $row_value1 = $row["fecha"];
        $row_value2 = $row["hora"]; 
        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));
      
        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 4 hours"));
      
        echo '<tr> 
                <td>' . $row_id_TH . '</td> 
                <td>' . $row_sensor . '</td> 
                <td>' . $row_location . '</td> 
                <td>' . $row_value1 . '</td> 
                <td>' . $row_value2 . '</td>
              </tr>';
    }
    $result->free();
    
    // ---------------------------------------------
    
    $sql1 = "SELECT * FROM hcsr501 ORDER BY id_mov DESC";
    
    echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <td>ID</td> 
        <td>mov</td> 
        <td>fecha</td> 
        <td>hora</td>
      </tr>';
 
if ($result1 = $conn->query($sql1)) {
    while ($row1 = $result1->fetch_assoc()) {
        $row1_id_mov = $row1["id_mov"];
        $row1_movim = $row1["mov"];
        $row1_fecha = $row1["fecha"];
        $row1_hora = $row1["hora"]; 

      
        echo '<tr> 
                <td>' . $row1_id_mov . '</td> 
                <td>' . $row1_movim . '</td> 
                <td>' . $row1_fecha . '</td> 
                <td>' . $row1_hora . '</td> 
              </tr>';
    }
    $result1->free();
}

$conn->close();
?> 
</table>
</body>
</html>