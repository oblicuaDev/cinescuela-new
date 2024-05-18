<?php 
    include '../includes/config.php';
    $novedades = $sdk->getNovedades();
    echo json_encode($novedades); 
?>