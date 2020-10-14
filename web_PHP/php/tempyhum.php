<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temperatura y Humedad</title>
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
    <script src="js/tempHum.js"></script>
    <?php  ?>
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
                        <h2>Temperatura y Humedad</h2>
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
                        <form action="tempyhum.php" method="post">
                        <input name='dia' type='date' id='myDate'  value="">
                        <button type="submit" value="listo">Buscar</button>
                        
                        <?php
                                error_reporting(0);
                                $dia=$_POST['dia'];
                                echo $dia;
                                error_reporting(E_ALL);
                                // $dia=$_POST['dia'];
                                // echo $dia;
                        
                                         
                            
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
                                    <th>Temperatura</th>
                                    <th>Humedad</th>
                                </tr>
                            </thead>
                        <?php 
                        //traigo temp
                        require_once('conexion.php');
                        $sql = "SELECT * FROM dth11 WHERE fecha='$dia' ORDER BY id_TH DESC LIMIT 12";
                        $result = mysqli_query($con, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                            while($row = mysqli_fetch_assoc($result)) {
                                // echo "id: " . $row["id"]. " - Temp: " . $row["temp"].  "<br>";
                                echo "<tbody>";
                                echo "<tr>";
                                echo "<td>".$row['fecha']."</td>"; //contenido del echo se modifica
                                echo "<td>".$row['hora']."</td>"; //contenido del echo se modifica
                                echo "<td>".$row['temp']." °C</td>"; //contenido del echo se modifica
                                echo "<td>".$row['hum']." %</td>"; //contenido del echo se modifica
                                echo "</tr>";
                                echo "</tbody>";
                            }
                        } else {
                            echo "0 results";
                        }
                        ?>
                        </table> 
                    </div>
                    <div class="col-sm-3">
                        <table class="table">
                            <tbody id="sborde">
                           
                            <?php
                                $sql1 = "SELECT MAX(temp) FROM dth11 WHERE fecha='$dia' ";
                                $result1 = mysqli_query($con, $sql1);
                                if (mysqli_num_rows($result1) > 0) {
                                    // output data of each row
                                    while($row = mysqli_fetch_assoc($result1)) {
                                        // echo "id: " . $row["id"]. " - Temp: " . $row["temp"].  "<br>";
                                    
                                        echo "<tr>";
                                        echo "<th>Máximo</td>"; //contenido del echo se modifica
                                        echo "<td>".$row['MAX(temp)']." °C</td>"; //contenido del echo se modifica
                                    }
                                } else {
                                    echo "0 results";
                                }
                                $sql2 = "SELECT MAX(hum) FROM dth11 WHERE fecha='$dia' ";
                                $result2 = mysqli_query($con, $sql2);
                                if (mysqli_num_rows($result2) > 0) {
                                    // output data of each row
                                    while($row2 = mysqli_fetch_assoc($result2)) {
                                        // echo "id: " . $row["id"]. " - Temp: " . $row["temp"].  "<br>";
                                        echo "<td>".$row2['MAX(hum)']." %</td>"; //contenido del echo se modifica
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "0 results";
                                }
                            ?>
                            </tbody>
                            <tbody id="sborde">
                            <?php
                                $sql3 = "SELECT MIN(temp) FROM dth11 WHERE fecha='$dia' ";
                                $result3 = mysqli_query($con, $sql3);
                                if (mysqli_num_rows($result3) > 0) {
                                    // output data of each row
                                    while($row3 = mysqli_fetch_assoc($result3)) {
                                        // echo "id: " . $row["id"]. " - Temp: " . $row["temp"].  "<br>";
                                    
                                        echo "<tr>";
                                        echo "<th>Mínimo</td>"; //contenido del echo se modifica
                                        echo "<td>".$row3['MIN(temp)']." °C</td>"; //contenido del echo se modifica
                                    }
                                } else {
                                    echo "0 results";
                                }
                                $sql4 = "SELECT MIN(hum) FROM dth11 WHERE fecha='$dia' ";
                                $result4 = mysqli_query($con, $sql4);
                                if (mysqli_num_rows($result4) > 0) {
                                    // output data of each row
                                    while($row4 = mysqli_fetch_assoc($result4)) {
                                        // echo "id: " . $row["id"]. " - Temp: " . $row["temp"].  "<br>";
                                        echo "<td>".$row4['MIN(hum)']." %</td>"; //contenido del echo se modifica
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "0 results";
                                }
                            ?>
                            <!-- <tbody id="sborde">
                                <tr>
                                    <th>Mínimo</th>
                                    <td>°C</td>
                                    <td>H%</td>
                                </tr> -->
                            </tbody>
                            <tbody id="sborde">
                            <?php
                                $sql5 = "SELECT AVG(temp) FROM dth11 WHERE fecha='$dia' ";
                                $result5 = mysqli_query($con, $sql5);
                                if (mysqli_num_rows($result5) > 0) {
                                    // output data of each row
                                    while($row5 = mysqli_fetch_assoc($result5)) {
                                        // echo "id: " . $row["id"]. " - Temp: " . $row["temp"].  "<br>";
                                        
                                        echo "<tr>";
                                        echo "<th>Promedio</td>"; //contenido del echo se modifica
                                        echo "<td>".round($row5['AVG(temp)'], 2)." °C</td>"; //contenido del echo se modifica
                                        // $data1 = bcdiv($valor, '1', 1);
                                    }
                                } else {
                                    echo "0 results";
                                }
                                $sql6 = "SELECT AVG(hum) FROM dth11 WHERE fecha='$dia' ";
                                $result6 = mysqli_query($con, $sql6);
                                if (mysqli_num_rows($result6) > 0) {
                                    // output data of each row
                                    while($row6 = mysqli_fetch_assoc($result6)) {
                                        // echo "id: " . $row["id"]. " - Temp: " . $row["temp"].  "<br>";
                                        echo "<td>".round($row6['AVG(hum)'], 2)." %</td>"; //contenido del echo se modifica
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "0 results";
                                }
                            ?>
                                <!-- <tr>
                                    <th>Promedio</th>
                                    <td>°C</td>
                                    <td>H%</td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>