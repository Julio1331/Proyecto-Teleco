<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimiento</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/boton.css">
  
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
                                <a class="nav-link" href="co2Gas.php">Gas - CO2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="mov.php">Movimiento</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#">Configuración</a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link" href="#">Cerrar Sesión</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="col-sm-10">
                <div class="row backgroundColor">
                    <div class="col-sm-12">
                        <h2>Movimiento</h2>
                    </div>
                </div>
                <div class="row backgroundColor2" style="height: 10%;">
                    <div class="col-sm-12">
                        <h3 class="historial">Historial</h3>
                    </div>
                </div>
                <div class="row graficosTorta">
                    <div class="col-sm-12 datetime">
                        <h5>Seleccione Día </h5>
                        <form action="mov.php" method="post">
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
                    <div class="col-sm-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Movimiento Detectado</th>
                                </tr>
                            </thead>
                            <?php
                                //traigo movimiento
                                require_once('conexion.php');
                                $sql = "SELECT * FROM hcsr501 WHERE fecha='$dia' ORDER BY id_mov DESC LIMIT 12";
                                $result = mysqli_query($con, $sql);

                                if(mysqli_num_rows($result) > 0){
                                    //output data of each row
                                    while($row = mysqli_fetch_assoc($result)) {
                                        // echo "id: " . $row["id"]. " - Temp: " . $row["temp"].  "<br>";
                                        echo "<tbody>";
                                        echo "<tr>";
                                        echo "<td>".$row['fecha']."</td>"; //contenido del echo se modifica
                                        echo "<td>".$row['hora']."</td>"; //contenido del echo se modifica
                                        if('mov'== 0){
                                            echo "<td> SI </td>"; //contenido del echo se modifica
                                        }else{
                                            echo "<td> NO </td>"; //contenido del echo se modifica
                                        }
                                        // echo "<td>".$row['mov']." </td>"; //contenido del echo se modifica
                                        echo "</tr>";
                                        echo "</tbody>";
                                    }
                                } else {
                                    echo "0 results";
                                }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>