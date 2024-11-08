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
    <?=$sdk->create_metas(isset($_GET['seo']) ? $_GET['seo'] : '8695', isset($_GET['type']) ? $_GET['type'] : 'pages')?>
    <base href="/app/">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <link rel="stylesheet" href="../css/styles.css?v=<?=time()?>">
    <link rel="stylesheet" href="css/styles.css?v=<?=time()?>">
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date(); a = s.createElement(o),
                m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-29442208-8', 'auto');
        ga('send', 'pageview');

    </script>
     <? if($_SESSION['logged']['cod_us']>0) { ?>
        <script>console.log("<?=$_SESSION['logged']['cod_us']."-".$_SESSION['logged']['usu_us']?>");</script>
        <script>
            // Obtener la URL actual
            let url = new URL(window.location);
            // Agregar o modificar un parámetro de consulta
            function addOrUpdateQueryParam(key, value) {
                // Actualizar el parámetro si ya existe o agregarlo si no
                url.searchParams.set(key, value);

                // Actualizar la URL sin recargar la página
                window.history.pushState({}, '', url);
            }
            // Ejemplo de uso para agregar parámetros dinámicamente
            addOrUpdateQueryParam('usuario', '<?=$_SESSION['logged']['usu_us']?>'); // Agrega el parámetro 'usuario' con el valor '123'

            // Puedes agregar más parámetros o modificar los existentes de esta forma
        </script>
	<script>ga('create', 'UA-29442208-8', { 'userId': '<?=$_SESSION['logged']['cod_us']."-".$_SESSION['logged']['usu_us']?>' });	 </script>
	<? }else { ?>
	<script>ga('create', 'UA-29442208-8','auto');</script>
	<? } ?>
    <script>
        let lang = "<?=$lang?>";
        let windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth || 0;
        function break_session(){
            localStorage.removeItem("datagetTemaIds");
            localStorage.removeItem("datagetAsignaturaIds");
            localStorage.removeItem("lomasvistomovies");
            document.querySelector("#sess").submit();
        }
        const steps = <?=json_encode($sdk->tourSteps["response"])?>;
    </script>
</head>

<body class="<?=$bodyClass?> cinescuela-app">