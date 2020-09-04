<?php
//este archivo hace la consulta de el ultimo valor de temperatura a la tabla y 
//lo deja cargado en array
require_once "conexion.php";

$sql = "SELECT * FROM mq2 order by id_C DESC limit 1";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        // echo $row["id_G"];
        // echo $row["gas"]; 
        $valor = (int)$row["aire"];
        // echo $valor;
        echo json_encode($valor);
    }
} else {
    echo "0 results";
}
?>
