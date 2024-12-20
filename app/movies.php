<?php 
    $bodyClass = "movies";
    include 'includes/head.php';
    include 'includes/header.php';
    $destacadosParams = ['field' => 'pelicula_destacada,pelicula_frances', 'value' => '1,' . ($lang == 'es' ? 0 : 1)];
    $destacados = $sdk->getPeliculas("", $currentPage, 2, $destacadosParams);
    $destacados = $destacados["response"];
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $lang = isset($_GET['lang']) ? $_GET['lang'] : "es";

    // Obtener películas para la página actual
    $postsParams = ['field' => 'pelicula_destacada,pelicula_frances', 'value' => '0,' . ($lang == 'es' ? 0 : 1),'order'=>'asc'];
    $posts = $sdk->getPeliculas("", $currentPage, 15, $postsParams);
?>
<script>
    const totalPages = <?= $posts['total_pages'] ?>; 
</script>
<main>
    <div class="banner">
        <!-- Slider main container -->
        <div class="swiper swiperHome">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <?php for($i=0;$i<count($destacados);$i++){ $post = $destacados[$i]; ?>
                <div class="swiper-slide">
                    <picture>
                        <source media="(max-width: 1023px)" srcset="<?=$sdk->replaceUrl($post->acf->afiche)?>">
                        <img src="<?=$sdk->replaceUrl($post->acf->imagen_pelicula)?>" alt="<?=$post->title->rendered?>" id="logo">
                    </picture>
                    <div class="container">
            <div class="overlay">
                <img src="<?= $post->acf->logo_de_la_pelicula?>" alt="Logo Pelicula">
                <?= $post->content->rendered?>
                <div class="actions">
                    <?php 
                    $theme = false;
                if ( $post->related_cinescuela_ap) {
                        $acomp =  $post->related_cinescuela_ap;
                        if ($acomp->acf_fields) {
                            $theme = $acomp->acf_fields->presentaciones->tema_light;
                        }
                        }else if(count( $post->related_cinescuela_ap) > 0){
                        $acomp =  $post->related_cinescuela_ap[0];
                        if ($acomp->acf_fields) {
                            $theme = $acomp->acf_fields->presentaciones->tema_light;
                            }
                        }
                ?>
                    <a href="<?=$lang?>/pelicula/<?=$sdk->get_alias( $post->title->rendered)?>-<?= $post->id?>"
                        class="btn btn-primary">Reproducir película</a>
                    <a href="<?=$_GET['lang']?>/pelicula/<?=$sdk->get_alias($post->title->rendered)?>-<?=$post->id?>" class="btn btn-secondary">Mas información</a>
                </div>
            </div>
        </div>
                </div>
                <?php } ?>
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>
        </div>

        
    </div>
    <ul class="movies-list container " id="movie-container">
        <?php
        if (is_array($posts["response"])) {
            foreach ($posts["response"] as $post) { 
                $post_json = json_encode($post);
                $post_json_escaped = htmlspecialchars($post_json, ENT_QUOTES, 'UTF-8');
                $theme = false;
                $acomp = isset($movie['related_cinescuela_ap'][0]) ? $movie['related_cinescuela_ap'][0] : (isset($movie['related_cinescuela_ap']) ? $movie['related_cinescuela_ap'] : null);
            if (isset($acomp['acf_fields']['presentaciones']['tema_light'])) {
                $theme = $acomp['acf_fields']['presentaciones']['tema_light'];
            }
                ?>
        <li onclick="getInfoMovie(<?= $post_json_escaped ?>)">
            <a data-temalight="<?=$theme?>" href="javascript:;" data-fancybox="" data-src="#dialog-content" onClick="ga('send', 'event', 'Películas', 'click', '<?=$post->title->rendered?>')">
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