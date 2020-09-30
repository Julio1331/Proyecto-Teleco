<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Temperatura', 0],
          ['Humedad', 0],
        ]);

        var options = {
          width: 400, height: 400,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

        chart.draw(data, options);

        setInterval(function() {
          data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
          chart.draw(data, options);
        }, 1300);
      }


//VIEJO
// google.charts.load('current', { 'packages': ['gauge'] });
// google.charts.setOnLoadCallback(drawGauge);

// var gaugeOptions = {
//     min: 0, max: 50, yellowFrom: 35, yellowTo: 41,
//     redFrom: 41, redTo: 50, minorTicks: 5
// };
// var gauge;

// function drawGauge() {
//     gaugeData = new google.visualization.DataTable();
//     gaugeData.addColumn('number', '°C');
//     //   gaugeData.addColumn('number', 'Torpedo');
//     gaugeData.addRows(2);
//     gaugeData.setCell(0, 0, 50);//acá va el ultimo dato leido de la BD
//     //   gaugeData.setCell(0, 1, 80);

//     gauge = new google.visualization.Gauge(document.getElementById('gauge_div1'));
//     gauge.draw(gaugeData, gaugeOptions);
// }

// function changeTemp(dir) {
//     gaugeData.setValue(0, 0, gaugeData.getValue(0, 0) + dir * 25);
//     //   gaugeData.setValue(0, 1, gaugeData.getValue(0, 1) + dir * 20);
//     gauge.draw(gaugeData, gaugeOptions);
// }