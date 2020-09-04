google.charts.load('current', { 'packages': ['gauge'] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

    var data = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['ppm', 0]
    ]);

    var options = {
        //width: 400, height: 120,
        redFrom: 150, redTo: 1024,
        yellowFrom: 75, yellowTo: 150,
        greenFrom: 0, greenTo: 75,
        minorTicks: 5 , max: 1024
    };

    var chart = new google.visualization.Gauge(document.getElementById('gauge_div4'));

    chart.draw(data, options);

    setInterval(function () {

        $.post("reloj/reloj4/consulta.php",{id:1}, function (respuesta) {
            data.setValue(0, 1, respuesta);
            chart.draw(data, options);
        });
    }, 3000);
}