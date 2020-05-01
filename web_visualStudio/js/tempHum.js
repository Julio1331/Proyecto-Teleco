// script del gráfico de torta 3d temperatura

google.charts.load("current", { packages: ["corechart"] });
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Promedio de Temperatura', 'Días por Intervalo'],
        ['0°C a 10°C', 11],
        ['10°C a 15°C', 8],
        ['15°C a 20°C', 9],
        ['20°C a 25°C', 7],
        ['25°C a 30°C', 7],
        ['30°C a 35°C', 7],
        ['35°C a 40°C', 7],
        ['40°C a 50°C', 7]
    ]);
    var options = {
        title: 'Distribución de Temperaturas',
        is3D: true,
    };
    var chart = new google.visualization.PieChart(document.getElementById('temp'));
    chart.draw(data, options);
}


// script del gráfico de torta 3d humedad

google.charts.load("current", { packages: ["corechart"] });
google.charts.setOnLoadCallback(drawChart1);
function drawChart1() {
    var data = google.visualization.arrayToDataTable([
        ['Promedio de Temperatura', 'Días por Intervalo'],
        ['0% a 10°%', 11],
        ['10% a 20%', 8],
        ['20% a 30%', 9],
        ['30% a 40%', 7],
        ['40% a 50%', 7],
        ['50% a 60%', 7],
        ['60% a 70%', 7],
        ['70% a 80%', 7],
        ['80% a 90%', 7],
        ['90% a 100%', 7]
    ]);
    var options = {
        title: 'Distribución de Humedad',
        is3D: true,
    };
    var chart = new google.visualization.PieChart(document.getElementById('hum'));
    chart.draw(data, options);
}


// comienza script del gráfico cartesiano

google.charts.load('current', { packages: ['corechart', 'line'] });
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

    var data = new google.visualization.DataTable();
    data.addColumn('number', 'X');
    data.addColumn('number', 'Temperatura');
    data.addColumn('number', 'Humedad');

    data.addRows([
        [0, 0, 2], [1, 10, 45], [2, 23, 34], [3, 17, 25], [4, 18, 21], [5, 9, 21],
        [6, 11, 15], [7, 27, 14], [8, 33, 35], [9, 40, 55], [10, 32, 41], [11, 35, 25],
        [12, 30, 15], [13, 40, 23], [14, 42, 12], [15, 47, 11], [16, 44, 14], [17, 48, 55]

    ]);

    var options = {
        hAxis: {
            title: 'Días'
        },
        vAxis: {
            title: 'Temperatura °C'
        }
    };

    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

    chart.draw(data, options);
}