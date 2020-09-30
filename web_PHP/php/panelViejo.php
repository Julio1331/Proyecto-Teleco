<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


        <script src="http://code.jquery.com/jquery-latest.js"></script>
    <link rel="stylesheet" href="css/estilos.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="reloj/reloj1/reloj.js"></script>
    <script src="reloj/reloj2/reloj2.js"></script>
    <script src="reloj/reloj3/reloj3.js"></script>
    <script src="reloj/reloj4/reloj4.js"></script>

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
                                <a class="nav-link" href="panel.htm">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="tempyhum.htm">Temperatura - Humedad</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="co2Gas.htm">Gas - CO2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="mov.htm">Movimiento</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Configuración</a>
                            </li>
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
                        <h2>Panel General</h2>
                    </div>
                </div>
                <div class="row">
                    <!-- primera fila de contenidos  -->
                    <div class="col-sm-6">
                        <!-- temperatura -->
                        <h2><i class="fas fa-temperature-high"></i> Temperatura</h2>
                        <div>
                            <div id="gauge_div1" style="width:auto; height: auto;"></div>
                            <!-- // el style no es necesario se se colocan las propiedades en auto porque ya estan por default -->
                            <!-- <input type="button" value="Go Faster" onclick="changeTemp(1)" />
                            <input type="button" value="Slow down" onclick="changeTemp(-1)" /> -->
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- humedad -->
                        <h2><i class="fas fa-tint"></i> Humedad</h2>
                        <div id="gauge_div2" style="width:auto; height: auto;"></div>
                    </div>
                </div>
                <div class="row inferior">
                    <!-- segunda fila de contenidos  -->
                    <div class="col-sm-4">
                        <!-- gas -->
                        <h2><i class="fas fa-skull-crossbones"></i> Gas Natural</h2>
                        <div id="gauge_div3" style="width:auto; height: auto;"></div>
                    </div>
                    <div class="col-sm-4">
                        <h2><i class="fas fa-running"></i> Movimiento</h2>
                        

                        
                        <div  class="icono">
                           <?php
                           

                        
                           $servername = "localhost";
                           $username = "root";
                           $password = "";
                           $dbname = "id13218228_lecturadatos";
                           
                           // Create connection
                           $con = mysqli_connect($servername, $username, $password, $dbname);
                           // Check connection
                           if (!$con) {
                               die("Connection failed: " . mysqli_connect_error());
                           }  
                           

                                $sql = "SELECT mov FROM hcsr501 order by id_mov DESC limit 1";
                                $result = mysqli_query($con, $sql);
                                
                                if (mysqli_num_rows($result) > 0) {
                                    // output data of each row
                                    while($row = mysqli_fetch_assoc($result)) {
                                        // echo " Name: " . $row["mov"].  "<br>";
                                        if( $row["mov"] === '0'){
                                            echo "<i class='fas fa-male'></i>";
                                        }else{
                                           echo "<i class='fas fa-running'></i>";
                                        }
                                    }
                                } else {
                                    echo "0 results";
                                }
                                
                                mysqli_close($con);
                            ?>
                        </div>
                     
                        <!-- <i class="fas fa-male"></i> PERSONA SIN MOVIMIENTO CAMBIAR CON ENABLE DISABLED DEPENDIENDO DE VALOR EN LA BASE DE DATOS OBTENIDO-->

                    </div>
                    <div class="col-sm-4">
                        <h2><i class="fas fa-smog"></i> CO2</h2>
                        <div id="gauge_div4" style="width:auto; height: auto;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>