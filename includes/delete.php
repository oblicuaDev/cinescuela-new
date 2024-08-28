<?php
$dir = "/home/customer/www/cinescuela.org/public_html/cache";
$log  = "Caché eliminado ".date("F j, Y, g:i a").PHP_EOL.
        "-------------------------".PHP_EOL;
file_put_contents('refresh.log', $log, FILE_APPEND);
deleteDirectory($dir);
function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaciar caches</title>
</head>

<body>
    <h2>La cache ha sido eliminada correctamente</h2>
    <a href="https://webadmin.cinescuela.org/wp-admin/">Volver al administrador</a>
</body>

</html>