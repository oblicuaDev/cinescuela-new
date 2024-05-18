<?php 
    include '../includes/config.php';
    $extra = [];
    if($_GET['year']){
        $extra = ['field'=>'ano_del_ciclo', 'value'=>$_GET['year']];
    }
    $ciclos = $sdk->getCiclos(isset($_GET['id']) ? $_GET['id'] : "",1,100,$extra);
    echo json_encode($ciclos); 
?>