google.charts.load('current', { 'packages': ['gauge'] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

    var data = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['%', 0]
    ]);

    var options = {
        //width: 400, height: 120,
        redFrom: 90, redTo: 100,
        yellowFrom: 75, yellowTo: 90,
        minorTicks: 5
    };

    var chart = new google.visualization.Gauge(document.getElementById('gauge_div2'));

    chart.draw(data, options);

    setInterval(function () {

        $.post("reloj/reloj2/consulta.php",{id:1}, function (respuesta) {
            data.setValue(0, 1, respuesta);
            chart.draw(data, options);
        });
    }, 3000);
}