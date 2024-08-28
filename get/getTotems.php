<?php 
    $jsonString = file_get_contents('php://input');
    $body = json_decode($jsonString, true);
    include '../includes/config.php';
    var_dump($body['movieid']);
    $totems = $sdk->getTotems($body['movieid']);

    // Imprimir el nuevo array como JSON
    echo json_encode($totems); 
?>
