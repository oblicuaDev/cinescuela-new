<?php 
    $lang = $_GET['lang'];
    include '../includes/config.php';
    // if (!isset($_SESSION['json_lan'])){
        $json = $sdk->read_json($json);
        // $_SESSION['json_lan'] = $json;
    // }
    // $json = $_SESSION['json_lan'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <base href="/lab/cinescuela-new/app/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="css/styles.css">
    <script>
        let lang = "<?=$lang?>";
        let windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth || 0;
    </script>
</head>

<body class="<?=$bodyClass?> cinescuela-app">