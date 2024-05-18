<?php 
    include '../includes/config.php';
    $edades = $sdk->getEdades($_GET['id']);
    echo json_encode($edades); 
?>