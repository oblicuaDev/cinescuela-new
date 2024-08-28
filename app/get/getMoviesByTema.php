<?php 
    $jsonString = file_get_contents('php://input');
    $temasIds = json_decode($jsonString, true);
    include '../includes/config.php';
    $movies = $sdk->getPeliculas('', 1, 20, ['field'=>'tematicas','value'=> $temasIds]);
    echo json_encode($movies['response']); 
?>
