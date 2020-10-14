<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CO y Gas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/boton.css">


    <!-- script del gráfico de torta 3d -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- fin del script del gráfico de torta 3d -->
    <script src="js/co2Gas.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <!-- menu de navegación -->
                <nav class="navbar flex-column navbar-expand-md bg-dark navbar-dark ">
                    <a class="navbar-brand" href="#">Menú</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="collapsibleNavbar">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="panel.php">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="tempyhum.php">Temperatura - Humedad</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="co2Gas.php">Gas - CO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="mov.php">Movimiento</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#">Configuración</a>
                            </li> -->
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#">Cerrar Sesión</a>
                            </li> -->
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="col-sm-10">
                <div class="row backgroundColor">
                    <div class="col-sm-12">
                        <h2>CO y GAS</h2>
                    </div>
                </div>
                <div class="row backgroundColor2">
                    <div class="col-sm-12">
                        <h3 class="historial">Historial</h3>
                    </div>
                </div>
                <div class="row graficosTorta">
                    <div class="col-sm-12 datetime">
                        <h5>Seleccione Día </h5>
                        <form action="co2Gas.php" method="post">
                            <input name='dia' type='date' id='myDate' value=''>
                            <button type="submit">Buscar</button>
                            <?php
                                error_reporting(0);
                                $dia=$_POST['dia'];
                                echo $dia;
                                error_reporting(E_ALL);
                            ?>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>GAS</th>
                                    <th>CO</th>
                                </tr>
                            </thead>
                            <?php
                                //traigo co y gas
                                require_once('conexion.php');
                                $sql = "SELECT * FROM mq1 WHERE fecha='$dia' ORDER BY id_G DESC LIMIT 12";
                                $result = mysqli_query($con, $sql);
                                // 
                                $sql1 = "SELECT * FROM mq2 WHERE fecha='$dia' ORDER BY id_C DESC LIMIT 12";
                                $result1 = mysqli_query($con, $sql1);

                                if((mysqli_num_rows($result) > 0) && (mysqli_num_rows($result1) > 0)){
                                    while(($row = mysqli_fetch_assoc($result)) && ($row1 = mysqli_fetch_assoc($result1))){
                                        echo "<tbody>";
                                        echo "<tr>";
                                        echo "<td>".$row['fecha']."</td>"; //contenido del echo se modifica
                                        echo "<td>".$row['hora']."</td>"; //contenido del echo se modifica
                                        echo "<td>".$row['gas']." ppm</td>"; //contenido del echo se modifica
                                        echo "<td>".$row1['aire']." ppm</td>"; //contenido del echo se modifica                                        
                                        echo "</tr>";
                                        echo "</tbody>";
                                    }
                                }else{
                                    echo "0 result";
                                }
                            ?>
                        </table>
                    </div>
                    <div class="col-sm-3">
                        <table class="table">
                            <tbody id="sborde">
                                <?php
                                    $sql2 = "SELECT MAX(gas) FROM mq1 WHERE fecha='$dia' ";
                                    $result2 = mysqli_query($con, $sql2);
                                    if (mysqli_num_rows($result2) > 0){
                                        while($row = mysqli_fetch_assoc($result2)) {
                                            // echo "id: " . $row["id"]. " - Temp: " . $row["temp"].  "<br>";
                                            echo "<tr>";
                                            echo "<th>Máximo</td>"; //contenido del echo se modifica
                                            echo "<td>".$row['MAX(gas)']." ppm</td>"; //contenido del echo se modifica
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                    $sql3 = "SELECT MAX(aire) FROM mq2 WHERE fecha='$dia' ";
                                    $result3 = mysqli_query($con, $sql3);
                                    if (mysqli_num_rows($result3) > 0){
                                        while($row2 = mysqli_fetch_assoc($result3)) {
                                            // echo "id: " . $row["id"]. " - Temp: " . $row["temp"].  "<br>";
                                            echo "<td>".$row2['MAX(aire)']." ppm</td>"; //contenido del echo se modifica
                                        }
                                    } else {
                                        echo "0 results";
                                    }     
                                ?>
                            </tbody>
                            <tbody id="sborde">
                                <?php
                                    $sql4 = "SELECT MIN(gas) FROM mq1 WHERE fecha='$dia' ";
                                    $result4 = mysqli_query($con, $sql4);
                                    if (mysqli_num_rows($result4) > 0){
                                        while($row = mysqli_fetch_assoc($result4)) {
                                            // echo "id: " . $row["id"]. " - Temp: " . $row["temp"].  "<br>";
                                            echo "<tr>";
                                            echo "<th>Mínimo</td>"; //contenido del echo se modifica
                                            echo "<td>".$row['MIN(gas)']." ppm</td>"; //contenido del echo se modifica
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                    $sql5 = "SELECT MIN(aire) FROM mq2 WHERE fecha='$dia' ";
                                    $result5 = mysqli_query($con, $sql5);
                                    if (mysqli_num_rows($result5) > 0){
                                        while($row2 = mysqli_fetch_assoc($result5)) {
                                            // echo "id: " . $row["id"]. " - Temp: " . $row["temp"].  "<br>";
                                            echo "<td>".$row2['MIN(aire)']." ppm</td>"; //contenido del echo se modifica
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                ?>
                            </tbody>
                            <tbody id="sborde">
                                <?php
                                    //Promedio
                                    $sql6 = "SELECT AVG(gas) FROM mq1 WHERE fecha='$dia' ";
                                    $result6 = mysqli_query($con, $sql6);
                                    if (mysqli_num_rows($result6) > 0){
                                        while($row = mysqli_fetch_assoc($result6)) {
                                            // echo "id: " . $row["id"]. " - Temp: " . $row["temp"].  "<br>";
                                            echo "<tr>";
                                            echo "<th>Promedio</td>"; //contenido del echo se modifica
                                            echo "<td>".round($row['AVG(gas)'], 2)." ppm</td>"; //contenido del echo se modifica
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                    $sql7 = "SELECT AVG(aire) FROM mq2 WHERE fecha='$dia' ";
                                    $result7 = mysqli_query($con, $sql7);
                                    if (mysqli_num_rows($result7) > 0){
                                        while($row2 = mysqli_fetch_assoc($result7)) {
                                            // echo "id: " . $row["id"]. " - Temp: " . $row["temp"].  "<br>";
                                            echo "<td>".round($row2['AVG(aire)'], 2)." ppm</td>"; //contenido del echo se modifica
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>