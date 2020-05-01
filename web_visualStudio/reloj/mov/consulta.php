<?php
//este archivo hace la consulta de el ultimo valor de temperatura a la tabla y 
//lo deja cargado en array
require_once "conexion.php";

$sql = "SELECT * FROM hcsr501 order by id_mov DESC limit 1";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //echo $row["temp"];
        $valor = (int)$row["mov"];
        //echo $valor;
        echo json_encode($valor);
    }
} 
?>
