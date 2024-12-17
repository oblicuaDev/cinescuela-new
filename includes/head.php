<?php 
    $lang = $_GET['lang'];
    include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?=$sdk->create_metas(isset($_GET['seo']) ? $_GET['seo'] : '8695', isset($_GET['type']) ? $_GET['type'] : 'pages')?>
    <base href="/">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css?v=<?=time()?>">
    <script src="js/jquery-1.8.3.min.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-S9RTSZPKJE"></script>
    <script>

    window.dataLayer = window.dataLayer || [];

    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    

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
	<script>
        gtag('config', 'TAG_ID', {'user_id': '<?=$_SESSION['logged']['cod_us']."-".$_SESSION['logged']['usu_us']?>'}); 
    </script>
	<? }else { ?>
	<script>gtag('config', 'G-S9RTSZPKJE');</script>
	<? } ?>
    <? if($_SESSION['logged']['cod_us']>0){ ?>
        <? }else{
        if (!empty($_SERVER['HTTP_CLIENT_IP'])){
                $ip_address = $_SERVER['HTTP_CLIENT_IP'];
            }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }else{
                $ip_address = $_SERVER['REMOTE_ADDR'];
            }
        ?>
        <script>
                $(()=>{
                    $.get('verify?ip=<?php echo $ip_address; ?>',resp=>{
                        if (resp.message == 1 && resp.ID != "") {
                            // window.location.href = language+"/usuario/"+get_alias(resp.name);
                            window.location.href = `/app/es/inicio`;
                        }
                    });
                });
            </script>
            <? } ?>
   
    <script>
        let lang = "<?=$lang?>";
        let windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth || 0;
    </script>
    <script> ga('send', 'pageview'); </script>
</head>

<body class="<?=$bodyClass?> cinescuela-page">