var mysql = require('mysql');

var con = mysql.createConnection({
    host: "files.000webhost.com",
    user: "id13218228_julio",
    password: "4XY8C-9sQdac+]48",
    database: "id13218228_lecturadatos"
  });

  
  con.connect(function(err) {
    if (err) throw err;
    con.query("SELECT * FROM usuarios", function (err, result, fields) {
      if (err) throw err;
      console.log(result);
    });
  });
