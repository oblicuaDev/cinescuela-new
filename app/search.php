<?php 
    $bodyClass = "search";
    include 'includes/head.php';
    include 'includes/header.php';
    // Obtener películas para la página actual
    $postsParams = ['field' => 'pelicula_destacada,pelicula_frances', 'value' => '0,' . ($lang == 'es' ? 0 : 1),'order'=>'asc'];
    $postsParams['search'] = urlencode($_GET['s']);
    $title = "<h2>Resultados de Busqueda para: <strong>".$_GET['search-input']."</strong></h2>";
    if (isset($_GET['subject'])) {
        $postsParams['field'] .= ',asignaturas';
        $postsParams['value'] .= ',' . $_GET['subject'];
        $subject = $sdk->query('cinescuela-subjects/'.$_GET['subject']);
        $subject = $subject['response'];
        $title = "<h2>Resultados de Busqueda para: <strong>Asignatura - ".$subject->title->rendered."</strong></h2>";
    }
    
    if (isset($_GET['age'])) {
        $postsParams['field'] .= ',grupo_de_edad';
        $postsParams['value'] .= ',' . $_GET['age'];
        $age = $sdk->query('cinescuela-ge/'.$_GET['age']);
        $age = $age['response'];
        $title = "<h2>Resultados de Busqueda para: <strong>Clasificación - ".$age->title->rendered."</strong></h2>";
    }
    $posts = $sdk->getPeliculas("", $currentPage, 9, $postsParams);
    $posts = $posts['response'];
?>
<main data-searchval="<?=$_GET['search-input']?>" data-asignatura="<?=$_GET['subject']?>" data-clasificacion="<?=$_GET['age']?>">
    <section class="results container">
        <?=$title?>
        <ul class="grid-elements">
            <?php
            for ($i=0; $i < count($posts); $i++) { 
                $post = $posts[$i];
            // Supongamos que $post contiene los datos que deseas pasar a getInfoMovie()
            // Convertimos $post a JSON de forma segura
            $post_json = json_encode($post);

            // Escapamos las comillas para evitar problemas con el HTML
            $post_json_escaped = htmlspecialchars($post_json, ENT_QUOTES, 'UTF-8');
            ?>
            <li onclick="getInfoMovie(<?= $post_json_escaped ?>)">
            <a href="javascript:;" data-fancybox="" data-src="#dialog-content" data-temalight="false">
                <img loading="lazy" class="lazyload" src="<?=$post->acf->imagen_pelicula?>" data-src="<?=$post->acf->imagen_pelicula?>" alt="Logo Pelicula">
                <?php if($post->acf->logo_de_la_pelicula && $post->acf->logo_de_la_pelicula != ""){ ?>
                    <img loading="lazy" class="lazyload movieLogo" src="<?=$post->acf->logo_de_la_pelicula?>" data-src="<?=$post->acf->logo_de_la_pelicula?>" alt="Logo Pelicula">
                <?php } ?>
            </a>
            </li>
            <?php
            }
            ?>
        </ul>
    </section>
</main>
<?php include 'includes/footer.php'; ?>