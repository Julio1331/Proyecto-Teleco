<?php
    header('Content-Type: application/json');
    $pdo=new PDO("mysql:dbname=id13218228_lecturadatos;host=localhost","root","");
    //temperatura
    $statement= $pdo->prepare("SELECT temp FROM dth11 ORDER BY id_TH DESC LIMIT 0,1");
    $statement -> execute();
    $result=$statement->fetchAll(PDO::FETCH_ASSOC);
    $json=json_encode($result);
    echo $json;
?>