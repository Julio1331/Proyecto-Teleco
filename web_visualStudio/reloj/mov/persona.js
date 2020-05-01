setInterval(function () {


        $.post("reloj/mov/consulta.php",{id:1}, function (respuesta) {
          
            //var res = JSON.parse(respuesta);     
            //var res = JSON.parse(respuesta);
         //data.setValue(0, 1, res);
            // setValue(0, 1, respuesta);
            // chart.draw(data, options);
            

        });

    }, 3000);

    
