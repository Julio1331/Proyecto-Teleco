<?php
    header('Content-Type: application/json');
    $pdo=new PDO("mysql:dbname=id13218228_lecturadatos;host=localhost","root","");
    //gas
    $statement= $pdo->prepare("SELECT gas FROM mq1 ORDER BY id_G DESC LIMIT 0,1");
    $statement -> execute();
    $result=$statement->fetchAll(PDO::FETCH_ASSOC);
    $json=json_encode($result);
    echo $json;
?>