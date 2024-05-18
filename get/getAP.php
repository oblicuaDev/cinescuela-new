<?php 
    include '../includes/config.php';
    $apedag = $sdk->getAP($_GET['id']);
    echo json_encode($apedag); 
?>