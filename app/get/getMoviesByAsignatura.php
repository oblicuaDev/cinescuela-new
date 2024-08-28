<?php 
    $jsonString = file_get_contents('php://input');
    $asignaturaIds = json_decode($jsonString, true);
    include '../includes/config.php';
    $movies = $sdk->getPeliculas('', 1, 20, ['field'=>'asignaturas','value'=>$asignaturaIds]);
    echo json_encode($movies['response']); 
?>
