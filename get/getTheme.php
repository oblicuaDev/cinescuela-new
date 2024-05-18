<?php 
    include '../includes/config.php';
    extract($_GET);
    $theme = $sdk->getTheme($id);
    echo json_encode($theme); 
?>