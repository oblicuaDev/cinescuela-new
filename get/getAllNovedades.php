<?php 
    $jsonString = file_get_contents('php://input');
    $moviesIds = json_decode($jsonString, true);
    include '../includes/config.php';
    // $ids = "", $page = 1, $per_page = 50, $extra = []
    $movies = $sdk->getAllNovedades("", isset($_GET['page']) ? $_GET['page'] : 1, 15, ["order"=> "asc"]);
    echo json_encode($movies['response']);
?>
