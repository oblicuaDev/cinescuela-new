<?php 
    $jsonString = file_get_contents('php://input');
    $moviesIds = json_decode($jsonString, true);
    include '../includes/config.php';
    $movies = $sdk->getPeliculas($moviesIds);
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
?>
