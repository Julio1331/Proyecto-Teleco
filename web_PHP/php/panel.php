<?php
session_start();
?>
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

    <link rel="stylesheet" href="../css/estilos.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- <script src="../js/reloj/reloj.js"></script>
    <script src="../js/reloj/reloj2.js"></script>
    <script src="../js/reloj/reloj3.js"></script>
    <script src="../js/reloj/reloj4.js"></script> -->

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
                                <a class="nav-link" href="cerrarsesion.php">Cerrar Sesión</a>
                            </li> -->
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
                <div class="row superior">
                    <!-- primera fila de contenidos  -->
                    <div class="col-sm-6">
                        <!-- temperatura -->
                        <h2><i class="fas fa-temperature-high"></i> Temperatura</h2>
                        <div>
                            <script type="text/javascript">
                                google.charts.load('current', { 'packages': ['gauge'] });
                                google.charts.setOnLoadCallback(drawChart);

                                function drawChart() {

                                    var data = google.visualization.arrayToDataTable([
                                        ['Label', 'Value'],
                                        ['°C', 0]
                                    ]);

                                    var options = {
                                        width: 200, height: 200,
                                        redFrom: 90, redTo: 100,
                                        yellowFrom: 75, yellowTo: 90,
                                        minorTicks: 5
                                    };

                                    var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

                                    chart.draw(data, options);

                                    //ACTUALIZA EL VALOR DE LOS RELOJES CADA 1300 mseg
                                    setInterval(function () {
                                        var JSON = $.ajax({
                                            url: "http://localhost/web_php/php/traedatostemp.php",
                                            dataType: 'json',
                                            async: false
                                        }).responseText;
                                        var respuesta = jQuery.parseJSON(JSON);
                                        data.setValue(0, 1, respuesta[0].temp);
                                        // data.setValue(1, 1, respuesta[0].hum);
                                        chart.draw(data, options);
                                    }, 1300);//cada media hora

                                    //CARGA EL ÚLTIMO VALOR DE LA BASE DE DATOS AL ENTRAR A LA PÁGINA, Y NO LOS ACTUALIZA A MENOS QUE SE RECARGE 
                                        // var JSON = $.ajax({
                                        //     url: "http://localhost/web_php/php/traedatostemp.php",
                                        //     dataType: 'json',
                                        //     async: false
                                        // }).responseText;
                                        // var respuesta = jQuery.parseJSON(JSON);
                                        // data.setValue(0, 1, respuesta[0].temp);
                                        // chart.draw(data, options);
                                }
                            </script>
                            <div id="chart_div" style="width: 400px; height: auto;"></div>
                            <!-- <div id="gauge_div1" style="width:auto; height: auto;"></div>  // el style no es necesario se se colocan las propiedades en auto porque ya estan por default -->
                            <!-- <input type="button" value="Go Faster" onclick="changeTemp(1)" />
                            <input type="button" value="Slow down" onclick="changeTemp(-1)" /> -->
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- humedad -->
                        <h2><i class="fas fa-tint"></i> Humedad</h2>
                        <div>
                            <script type="text/javascript">
                                google.charts.load('current', { 'packages': ['gauge'] });
                                google.charts.setOnLoadCallback(drawChart);

                                function drawChart() {

                                    var data = google.visualization.arrayToDataTable([
                                        ['Label', 'Value'],
                                        ['%', 0]
                                    ]);

                                    var options = {
                                        width: 200, height: 200,
                                        redFrom: 90, redTo: 100,
                                        yellowFrom: 75, yellowTo: 90,
                                        minorTicks: 5
                                    };

                                    var chart = new google.visualization.Gauge(document.getElementById('chart_div1'));

                                    chart.draw(data, options);

                                    //ACTUALIZA EL VALOR DE LOS RELOJES CADA 1300 mseg
                                    setInterval(function () {
                                        var JSON = $.ajax({
                                            url: "http://localhost/web_php/php/traedatoshum.php",
                                            dataType: 'json',
                                            async: false
                                        }).responseText;
                                        var respuesta = jQuery.parseJSON(JSON);
                                        data.setValue(0, 1, respuesta[0].hum);
                                        chart.draw(data, options);
                                    }, 1300);//cada media hora

                                    //CARGA EL ÚLTIMO VALOR DE LA BASE DE DATOS AL ENTRAR A LA PÁGINA, Y NO LOS ACTUALIZA A MENOS QUE SE RECARGE 
                                        // var JSON = $.ajax({
                                        //     url: "http://localhost/web_php/php/traedatoshum.php",
                                        //     dataType: 'json',
                                        //     async: false
                                        // }).responseText;
                                        // var respuesta = jQuery.parseJSON(JSON);
                                        // data.setValue(0, 1, respuesta[0].hum);
                                        // chart.draw(data, options);
                                }
                            </script>
                            <div id="chart_div1" style="width: 400px; height: auto;"></div>
                            <!-- <div id="gauge_div1" style="width:auto; height: auto;"></div>  // el style no es necesario se se colocan las propiedades en auto porque ya estan por default -->
                            <!-- <input type="button" value="Go Faster" onclick="changeTemp(1)" />
                            <input type="button" value="Slow down" onclick="changeTemp(-1)" /> -->
                        </div>
                        <!-- <div id="gauge_div2" style="width:auto; height: auto;"></div> -->
                    </div>
                </div>
                <div class="row inferior">
                    <!-- segunda fila de contenidos  -->
                    <div class="col-sm-6">
                        <!-- gas -->
                        <h2><i class="fas fa-skull-crossbones"></i> Gas Natural</h2>
                        <script type="text/javascript">
                            google.charts.load('current', { 'packages': ['gauge'] });
                            google.charts.setOnLoadCallback(drawChart);

                            function drawChart() {

                                var data = google.visualization.arrayToDataTable([
                                    ['Label', 'Value'],
                                    ['ppm', 0]
                                ]);

                                var options = {
                                    width: 200, height: 200,
                                    redFrom: 90, redTo: 100,
                                    yellowFrom: 75, yellowTo: 90,
                                    minorTicks: 5
                                };

                                var chart = new google.visualization.Gauge(document.getElementById('chart_div2'));

                                chart.draw(data, options);

                                //ACTUALIZA EL VALOR DE LOS RELOJES CADA 1300 mseg 
                                setInterval(function () {
                                    var JSON = $.ajax({
                                        url: "http://localhost/web_php/php/traedatosgas.php",
                                        dataType: 'json',
                                        async: false
                                    }).responseText;
                                    var respuesta = jQuery.parseJSON(JSON);
                                    data.setValue(0, 1, respuesta[0].gas);
                                    chart.draw(data, options);
                                }, 1300);//cada media hora


                                //CARGA EL ÚLTIMO VALOR DE LA BASE DE DATOS AL ENTRAR A LA PÁGINA, Y NO LOS ACTUALIZA A MENOS QUE SE RECARGE 
                                    // var JSON = $.ajax({
                                    //     url: "http://localhost/web_php/php/traedatosgas.php",
                                    //     dataType: 'json',
                                    //     async: false
                                    // }).responseText;
                                    // var respuesta = jQuery.parseJSON(JSON);
                                    // data.setValue(0, 1, respuesta[0].gas);
                                    // chart.draw(data, options);
                            }
                        </script>
                        <div id="chart_div2" style="width: 400px; height: auto;"></div>
                        <!-- <div id="gauge_div3" style="width:auto; height: auto;"></div> -->
                    </div>
                    <div class="col-sm-6">
                        <h2><i class="fas fa-smog"></i> CO</h2>
                        <script type="text/javascript">
                            google.charts.load('current', { 'packages': ['gauge'] });
                            google.charts.setOnLoadCallback(drawChart);

                            function drawChart() {

                                var data = google.visualization.arrayToDataTable([
                                    ['Label', 'Value'],
                                    ['ppm', 0]
                                ]);

                                var options = {
                                    width: 200, height: 200,
                                    redFrom: 90, redTo: 100,
                                    yellowFrom: 75, yellowTo: 90,
                                    minorTicks: 5
                                };

                                var chart = new google.visualization.Gauge(document.getElementById('chart_div3'));

                                chart.draw(data, options);


                                //ACTUALIZA EL VALOR DE LOS RELOJES CADA 1300 mseg
                                setInterval(function () {
                                    var JSON = $.ajax({
                                        url: "http://localhost/web_php/php/traedatosco2.php",
                                        dataType: 'json',
                                        async: false
                                    }).responseText;
                                    var respuesta = jQuery.parseJSON(JSON);
                                    data.setValue(0, 1, respuesta[0].aire);
                                    chart.draw(data, options);
                                }, 1300);//cada media hora

                                //CARGA EL ÚLTIMO VALOR DE LA BASE DE DATOS AL ENTRAR A LA PÁGINA, Y NO LOS ACTUALIZA A MENOS QUE SE RECARGE
                                    // var JSON = $.ajax({
                                    //     url: "http://localhost/web_php/php/traedatosco2.php",
                                    //     dataType: 'json',
                                    //     async: false
                                    // }).responseText;
                                    // var respuesta = jQuery.parseJSON(JSON);
                                    // data.setValue(0, 1, respuesta[0].aire);
                                    // chart.draw(data, options);
                            }
                        </script>
                        <div id="chart_div3" style="width: 400px; height: auto;"></div>
                        <!-- <div id="gauge_div4" style="width:auto; height: auto;"></div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>