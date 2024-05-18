<?php 
    include '../includes/config.php';
    $tematicas = $sdk->getTematicas();
    echo json_encode($tematicas); 
?>