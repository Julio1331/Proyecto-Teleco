google.charts.load('current', { 'packages': ['gauge'] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

    var data = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['ppm', 0]
    ]);

    var options = {
        //width: 400, height: 120,
        redFrom: 800, redTo: 10000,
        yellowFrom: 500, yellowTo: 800,
        greenFrom: 0, greenTo: 500,
        minorTicks: 5 , max: 10000
    };

    var chart = new google.visualization.Gauge(document.getElementById('gauge_div3'));

    chart.draw(data, options);

    setInterval(function () {

        $.post("reloj/reloj3/consulta.php",{id:1}, function (respuesta) {
            data.setValue(0, 1, respuesta);
            chart.draw(data, options);
        });
    }, 3000);
}