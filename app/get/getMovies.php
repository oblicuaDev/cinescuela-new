<?php 
    $jsonString = file_get_contents('php://input');
    $moviesIds = json_decode($jsonString, true);
    include '../includes/config.php';
    // $ids = "", $page = 1, $per_page = 50, $extra = []
    $movies = $sdk->getPeliculas(isset($moviesIds) ? $moviesIds: "", isset($_GET['page']) ? $_GET['page'] : 1, 15,['order'=>'asc',"orderby"=>"acompanamiento_pedagogico_privado"]);
    if(isset($movies['response'])){
        echo json_encode($movies['response']); 

    }else{
        // Array para almacenar solo los contenidos de 'response'
        $responseContents = array();
        // Iterar sobre cada película y extraer el contenido de 'response'
        foreach ($movies as $movie) {
            // Verificar si 'response' está presente y no es nulo
            if (isset($movie['response'])) {
                // Agregar el contenido de 'response' al nuevo array
                $responseContents[] = $movie['response'];
            }
        }
        // Imprimir el nuevo array como JSON
        echo json_encode($responseContents); 

    }
?>
