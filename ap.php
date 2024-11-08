<?php 
    $bodyClass = "ap";
    include 'includes/head.php';
    include 'includes/header.php';
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $lang = isset($_GET['lang']) ? $_GET['lang'] : "es";

    // Obtener películas para la página actual
    $postsParams = ['field' => 'pelicula_frances,tiene_acompanamiento', 'value' => ($lang == 'es' ? 0 : 1).',1','order'=>'asc',"orderby"=>"acompanamiento_pedagogico_privado"];
    $posts = $sdk->getPeliculas("", $currentPage, 15, $postsParams);
?>
<script>
    const totalPages = <?= $posts['total_pages'] ?>; 
</script>
<main >
    <h2>Conoce los acompañamientos pedagógicos disponibles en Cinescuela</h2>
    <ul class="movies-list container " id="movie-container">
        <?php
        if (is_array($posts["response"])) {
            usort($posts["response"], function($a, $b) {
                return $a->acf->acompanamiento_pedagogico_privado <=> $b->acf->acompanamiento_pedagogico_privado;
            });
            foreach ($posts["response"] as $post) { 
            $theme = false;
            $acomp = isset($movie['related_cinescuela_ap'][0]) ? $movie['related_cinescuela_ap'][0] : (isset($movie['related_cinescuela_ap']) ? $movie['related_cinescuela_ap'] : null);
            if (isset($acomp['acf_fields']['presentaciones']['tema_light'])) {
                $theme = $acomp['acf_fields']['presentaciones']['tema_light'];
            }
                ?>
        <li>
            <a data-temalight="<?=$theme?>"
            target="_blank"
            onClick="ga('send', 'event', 'Acompañamiento pedagógico', 'click','Película - <?=$post->title->rendered?>')"
                href="app/<?=$_GET['lang']?>/acompanamiento-pedagogico/<?=$sdk->get_alias($post->title->rendered)?>-<?=$post->id?>">
                <?php if($post->acf->acompanamiento_pedagogico_privado == false){ ?>
                    <div class="corner-ribbon">
                        <span>Acceso libre</span>
                    </div>
                <?php } ?>
                <picture>
                    <source media="(max-width: 1023px)" srcset="<?=$sdk->replaceUrl($post->acf->afiche)?>">
                    <img src="<?=$sdk->replaceUrl($post->acf->imagen_pelicula)?>" alt="<?=$post->title->rendered?>" id="logo">
                </picture>
                <img loading="lazy" class="lazyload movieLogo" src="https://picsum.photos/20/20"
                    data-src="<?=$sdk->replaceUrl($post->acf->logo_de_la_pelicula)?>" alt="Logo Pelicula">
            </a>
        </li>
        <?php }
        }
        ?>

    </ul>
    <div class="loader"></div>
    <div id="sentinel"></div>
</main>
<?php include 'includes/footer.php'; ?>