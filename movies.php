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
                <div class="swiper-slide"
                    style="background-image:url(<?=$sdk->replaceUrl($post->acf->imagen_pelicula)?>);	">
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
                    <a href="javascript:;" onclick="getInfoMovie(bannerMovie)" data-fancybox=""
                        data-src="#dialog-content" class="btn btn-secondary">Mas información</a>
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
            foreach ($posts["response"] as $post) { ?>
        <li>
            <a href="<?=$_GET['lang']?>/pelicula/<?=$sdk->get_alias($post->title->rendered)?>-<?=$post->id?>">
                <img loading="lazy" class="lazyload" src="https://picsum.photos/20/20"
                    data-src="<?=$sdk->replaceUrl($post->acf->imagen_pelicula)?>" alt="<?=$post->title->rendered?>">
                <img loading="lazy" class="lazyload movieLogo" src="https://picsum.photos/20/20"
                    data-src="<?=$sdk->replaceUrl($post->acf->logo_de_la_pelicula)?>" alt="Logo Pelicula">
            </a>
        </li>
        <?php }
        }
        ?>

    </ul>
    <div id="sentinel"></div>
</main>
<?php include 'includes/footer.php'; ?>