<?php 
    include '../includes/config.php';
    $asignatura = $sdk->getAsignaturas($_GET['id']);
    echo json_encode($asignatura); 
?>