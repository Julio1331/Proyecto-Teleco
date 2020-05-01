// var express = require('express');
// var app = express();

// app.get('/', function (req, res) {
//    res.send('Hello World');
// })

// var server = app.listen(8081, function () {
//    var host = server.address().address
//    var port = server.address().port
   
//    console.log("Example app listening at http://%s:%s", host, port)
// })
var express = require('express');
var app = express();


app.use(express.static('public'));
app.get('/login.htm', function (req, res) {
   res.sendFile( __dirname + "/" + "login.htm" );
})
app.use(express.static('public'));
app.get('/login.htm', function (req, res) {
   res.sendFile( __dirname + "/" + "login.js" );
})
app.use(express.static('public'));
app.get('/panel.htm', function (req, res) {
   res.sendFile( __dirname + "/" + "panel.htm" );
})
// This responds with "Hello World" on the homepage
app.get('/', function (req, res) {
   console.log("Got a GET request for the homepage");
   res.send('Hello GET');
})

// This responds a POST request for the homepage
app.post('/', function (req, res) {
   console.log("Got a POST request for the homepage");
   res.send('Hello POST');
})

// This responds a DELETE request for the /del_user page.
app.delete('/del_user', function (req, res) {
   console.log("Got a DELETE request for /del_user");
   res.send('Hello DELETE');
})

// This responds a GET request for the /list_user page.
app.get('/list_user', function (req, res) {
   console.log("Got a GET request for /list_user");
   res.send('Page Listing');
})

// This responds a GET request for abcd, abxcd, ab123cd, and so on
app.get('/ab*cd', function(req, res) {   
   console.log("Got a GET request for /ab*cd");
   res.send('<h1>Users</h1>');
})

var server = app.listen(8081, function () {
   var host = server.address().address
   var port = server.address().port
   
   console.log("Example app listening at http://%s:%s", host, port)
})