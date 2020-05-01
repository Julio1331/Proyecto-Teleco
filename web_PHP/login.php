<?php
require_once('conexion.php');

$usuario = $_POST['usuario'];
$pass = $_POST['pass'];

$sql = "SELECT usuario, pass FROM usuario"; 
$query = $con -> prepare($sql); 
$query -> execute(); 
$results = $query -> fetchAll(PDO::FETCH_OBJ); 

if($query -> rowCount() > 0)   { 
foreach($results as $result) { 
    echo $result -> usuario;
    echo $result -> pass;
    if(($result -> usuario === $usuario)  && ($result -> pass === $pass)){
        header("Location: panel.html");
    } else {
        echo '<script type="text/JavaScript">  
     window.alert("Datos Incorrectos"); 
     window.location= "login.html";
     </script>' 
; 
        //sleep(7);
        // header("Location: login.html");
    }
    // echo "<tr>
// <td>".$result -> usuario."</td>
// <td>".$result -> pass."</td>
// </tr>";
   }
}
?>
 