<?php 
    $bodyClass = "home";
    include 'includes/head.php';
    include 'includes/header.php';
    if (isset($_SESSION[$lang]['peliculas_del_mes'])) {
        $bannerMovie = $_SESSION[$lang]['peliculas_del_mes'];
    } else {
        $bannerMovie = $sdk->getPeliculas($sdk->generalInfo->acf->peliculas_del_mes);
        $_SESSION[$lang]['peliculas_del_mes'] = $bannerMovie;
    }
    // Inicializar el arreglo para almacenar todas las peliculas_top
    $peliculasTopCombinadas = array();

    // Verificar si la variable de sesión está definida y no está vacía
    if (isset($_SESSION['logged']['perfil_de_usuario']) && is_array($_SESSION['logged']['perfil_de_usuario'])) {
        // Recorrer cada perfil de usuario
        foreach ($_SESSION['logged']['perfil_de_usuario'] as $perfil) {
            // Verificar si el perfil tiene el campo acf_fields y peliculas_top
            if (isset($perfil->acf_fields->peliculas_top) && is_array($perfil->acf_fields->peliculas_top)) {
                // Unir los valores del campo peliculas_top al arreglo combinado
                $peliculasTopCombinadas = array_merge($peliculasTopCombinadas, $perfil->acf_fields->peliculas_top);
            }
        }
    }
?>
<script>
    let bannerMovie = <?=json_encode($bannerMovie[0]['response'])?>;
</script>
<main data-ciclo_del_mes="<?= implode(',', $sdk->generalInfo->acf->ciclo_del_mes) ?>" data-peliculas_en_lo_mas_visto="<?= count($peliculasTopCombinadas) > 0 ? implode(',',$peliculasTopCombinadas) : implode(',',$sdk->generalInfo->acf->peliculas_en_lo_mas_visto)?>">
    <div id="player"></div>
    <div class="banner">
        <video autoplay muted loopdata-yt2html5="<?=$bannerMovie[0]['response']->acf->url_trailer?>" poster="<?=$bannerMovie[0]['response']->acf->imagen_pelicula?>" data-posterMobile="<?=$bannerMovie[0]['response']->acf->afiche?>"></video>
        <div class="container">
            <div class="overlay">
                <img src="<?=$bannerMovie[0]['response']->acf->logo_de_la_pelicula?>" alt="Logo Pelicula">
                <?=$bannerMovie[0]['response']->content->rendered?>
                <div class="actions">
                    <?php 
                     $theme = false;
                    if ($bannerMovie[0]['response']->related_cinescuela_ap) {
                            $acomp = $bannerMovie[0]['response']->related_cinescuela_ap;
                           if ($acomp->acf_fields) {
                             $theme = $acomp->acf_fields->presentaciones->tema_light;
                           }
                         }else if(count($bannerMovie[0]['response']->related_cinescuela_ap) > 0){
                            $acomp = $bannerMovie[0]['response']->related_cinescuela_ap[0];
                            if ($acomp->acf_fields) {
                                $theme = $acomp->acf_fields->presentaciones->tema_light;
                              }
                         }
                    ?>
                    <a href="<?=$lang?>/pelicula/<?=$sdk->get_alias($bannerMovie[0]['response']->title->rendered)?>-<?=$bannerMovie[0]['response']->id?>" class="btn btn-primary">Reproducir película</a>
                    <a href="javascript:;" onclick="getInfoMovie(bannerMovie)" data-fancybox="" data-src="#dialog-content" class="btn btn-secondary">Mas información</a>
                </div>
            </div>
            <div class="video-actions">
                <button><svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.48223 5.73223C9.95107 5.26339 10.587 5 11.25 5H28.75C29.413 5 30.0489 5.26339 30.5178 5.73223C30.9866 6.20108 31.25 6.83696 31.25 7.5V35C31.25 35.4544 31.0034 35.873 30.606 36.0933C30.2085 36.3136 29.7228 36.3008 29.3375 36.06L20 30.2241L10.6625 36.06C10.2772 36.3008 9.79148 36.3136 9.39404 36.0933C8.9966 35.873 8.75 35.4544 8.75 35V7.5C8.75 6.83696 9.01339 6.20107 9.48223 5.73223ZM28.75 7.5H11.25L11.25 32.7447L19.3375 27.69C19.7428 27.4367 20.2572 27.4367 20.6625 27.69L28.75 32.7447V7.5Z"
                            fill="currentColor" />
                    </svg>
                </button>
                <button id="sound"><svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M19.4394 3.10169C19.7824 3.2695 20 3.61807 20 4.00001V28C20 28.3819 19.7824 28.7305 19.4394 28.8983C19.0963 29.0661 18.6875 29.0238 18.3861 28.7894L9.65689 22H4C3.46957 22 2.96086 21.7893 2.58579 21.4142C2.21071 21.0391 2 20.5304 2 20V12C2 11.4696 2.21071 10.9609 2.58579 10.5858C2.96086 10.2107 3.46957 10 4 10H9.65689L18.3861 3.21066C18.6875 2.97617 19.0963 2.93389 19.4394 3.10169ZM18 6.04465L10.6139 11.7894C10.4384 11.9259 10.2224 12 10 12H4V20H10C10.2224 20 10.4384 20.0741 10.6139 20.2107L18 25.9554V6.04465Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M30.7071 12.2929C31.0976 12.6834 31.0976 13.3166 30.7071 13.7071L24.7071 19.7071C24.3166 20.0976 23.6834 20.0976 23.2929 19.7071C22.9024 19.3166 22.9024 18.6834 23.2929 18.2929L29.2929 12.2929C29.6834 11.9024 30.3166 11.9024 30.7071 12.2929Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M23.2929 12.2929C23.6834 11.9024 24.3166 11.9024 24.7071 12.2929L30.7071 18.2929C31.0976 18.6834 31.0976 19.3166 30.7071 19.7071C30.3166 20.0976 29.6834 20.0976 29.2929 19.7071L23.2929 13.7071C22.9024 13.3166 22.9024 12.6834 23.2929 12.2929Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M10 10C10.5523 10 11 10.4477 11 11V21C11 21.5523 10.5523 22 10 22C9.44772 22 9 21.5523 9 21V11C9 10.4477 9.44772 10 10 10Z"
                            fill="currentColor" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <section class="carousels container">
        <article id="ciclomes"> 
            <h3>Ciclo del mes</h3>
            <div class="swiper swiperCarousel">
                  <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                </div>
            </div>
        </article>
        <article id="asignatura-line1">
            <h3></h3>
            <div class="swiper swiperCarousel">
                  <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                </div>
            </div>
        </article>
        <article id="tema-line1">
            <h3></h3>
            <div class="swiper swiperCarousel">
                  <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                </div>
            </div>
        </article>
        <article id="lomasvisto">
            <h3 class="uppercase">Lo más visto</h3>
            <div class="swiper swiperTop">
                  <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                </div>
            </div>
        </article>
        <article id="asignatura-line2">
            <h3></h3>
            <div class="swiper swiperCarousel">
                  <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                </div>
            </div>
        </article>
        <article id="tema-line2">
            <h3></h3>
            <div class="swiper swiperCarousel">
                  <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                    <div class="swiper-slide skeleton"></div>
                </div>
            </div>
        </article>
    </section>
</main>
<?php include 'includes/footer.php'; ?>