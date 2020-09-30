<?php
    header('Content-Type: application/json');
    $pdo=new PDO("mysql:dbname=id13218228_lecturadatos;host=localhost","root","");
    //co2
    $statement= $pdo->prepare("SELECT aire FROM mq2 ORDER BY id_C DESC LIMIT 0,1");
    $statement -> execute();
    $result=$statement->fetchAll(PDO::FETCH_ASSOC);
    $json=json_encode($result);
    echo $json;
?>