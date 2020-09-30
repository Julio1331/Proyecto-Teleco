<?php
require_once('conexion.php');

$usuario = $_POST['usuario'];
$pass = $_POST['pass'];

$sql = "SELECT usuario, pass FROM usuario";
 $result = mysqli_query($con, $sql);

 if (mysqli_num_rows($result) > 0) {
     // output data of each row
     while($row = mysqli_fetch_assoc($result)) {
        if(($usuario === $row['usuario']) && ($pass === $row['pass'])) {
            session_start();
            $_SESSION["usuario"] = $usuario;
            header("Location: panel.php");
        }
        else {
            echo "Datos incorrectos";
        }
     }
 } else {
     echo "0 results";
 }
?>

