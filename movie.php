<?php 
    $bodyClass = "movie";
    include 'includes/head.php';
    include 'includes/header.php';
    $movie = $sdk->getPeliculas($_GET['id'], 1, 1);
    $post_json = json_encode($movie->acf->peliculas_relacionadas);
    // Escapamos las comillas para evitar problemas con el HTML
    $post_json_escaped = htmlspecialchars($post_json, ENT_QUOTES, 'UTF-8');
    if(isset($_SESSION['logged']['perfil_de_usuario'])){
        $moviesIDs = array_map('strval', $_SESSION['logged']['perfil_de_usuario'][0]->peliculas_del_ciclo);
    }

?>

<main data-moviesrel="<?=$post_json_escaped?>" data-movieid="<?=$_GET["id"]?>" >
<div class="banner">
    <picture>
        <source media="(max-width: 1023px)" srcset="<?=$sdk->replaceUrl($movie->acf->afiche)?>">
        <img src="<?=$sdk->replaceUrl($movie->acf->imagen_pelicula)?>" alt="<?=$post->title->rendered?>" id="logo">
    </picture>
    <div class="container">
        <div class="overlay">
            <?php if($movie->acf->logo_de_la_pelicula && $movie->acf->logo_de_la_pelicula != ""){ ?>
                <img src="<?= $sdk->replaceUrl($movie->acf->logo_de_la_pelicula)?>" alt="Logo Pelicula">
            <?php } ?>
            <div class="actions">
                <?php 
                    $theme = false;
                if ( $movie->related_cinescuela_ap) {
                        $acomp =  $movie->related_cinescuela_ap;
                        if ($acomp->acf_fields) {
                            $theme = $acomp->acf_fields->presentaciones->tema_light;
                        }
                        }else if(count( $movie->related_cinescuela_ap) > 0){
                        $acomp =  $movie->related_cinescuela_ap[0];
                        if ($acomp->acf_fields) {
                            $theme = $acomp->acf_fields->presentaciones->tema_light;
                            }
                        }
                ?>
                <?php 

                if(isset($_SESSION['logged']) && $_SESSION['logged']['cod_us'] != NULL){ 
                    ?>
                    <a href="app/<?=$lang?>/pelicula/<?=$sdk->get_alias( $movie->title->rendered)?>-<?= $movie->id?>" class="btn btn-primary">Reproducir película</a>
                <?php 
            }else{ 
                ?>
                    <a href="app/" class="btn btn-primary">Inicia sesión para reproducir</a>
                <?php 
            } 
            ?>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <section class="sinopsis">
            <img src="<?= $sdk->replaceUrl($movie->acf->afiche)?>" alt="<?= $movie->title->rendered?>">
        <article class="info">
            <div class="info-header">
                <h1><?= $movie->title->rendered?></h1>
                <?php 
                    if($movie->acf->grupo_de_ed){
                ?>
                    <div class="clasificacion">
                    <h3>Clasificación</h3>
                    <strong><?= $movie->acf->grupo_de_ed[0]->post_title; ?></strong>
                    </div>
                <?php 
                    }
                ?>
            </div>
            <span class="director"><?= $movie->acf->director_pelicula?></span>
            <span class="pais"><?= $movie->acf->pais_pelicula?> <?= $movie->acf->pais_pelicula?></span>
            <span class="duracion"><?= $movie->acf->duracion_en_minutos?></span>
            <div class="desc">
                <?= $movie->content->rendered?>
            </div>
            <?php 
			if($movie->acf->tiene_acompanamiento){
                if(isset($_SESSION['logged']['cod_us'])){
                    if ($_SESSION['logged']['cod_us'] != "" || $_SESSION['logged']['cod_us'] == "" && !$movie->acf->acompanamiento_pedagogico_privado || in_array(strval($movie->id), $moviesIDs) ) {
                
                     ?>
            <a href="app/<?=$lang?>/acompanamiento-pedagogico/<?=$sdk->get_alias( $movie->title->rendered)?>-<?= $movie->id?>" onClick="gtag('event', 'pelicula_click', {'section': 'Acompañamiento pedagógico','movie_title': 'Película - <?= $movie->title->rendered ?>'});" class="btn btn-primary">Ver el acompañamiento pedagógico</a>
            <?php }else{ ?>
            <a href="app/" class="btn btn-primary">Inicia sesión para ver el acompañamiento pedagógico</a>
            <?php }}} ?>
            <ul class="tags">
                <?php 
                $palabras_array = explode(",", $movie->acf->palabras_clave_de_esta_publicacion);
                $lista_palabras = array_map(function($word) {
                    return "<li>" . htmlspecialchars($word) . "</li>";
                }, $palabras_array);
                $resultado = implode("", $lista_palabras);
                echo $resultado;
                ?>
            </ul>
        </article>
    </section>
    <section class="opinion">
        <article>
            <h2>Nuestra Opinión</h2>
            <?=$movie->acf->opinion?>
        </article>
        <article>
            <h3>Esta Película Incluye</h3>
            <ul>
            <li>
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M2.34375 5.46875C2.34375 4.60581 3.04331 3.90625 3.90625 3.90625H21.0938C21.9567 3.90625 22.6562 4.60581 22.6562 5.46875V19.5312C22.6562 20.3942 21.9567 21.0938 21.0938 21.0938H3.90625C3.04331 21.0938 2.34375 20.3942 2.34375 19.5312V5.46875ZM21.0938 5.46875H3.90625V19.5312H21.0938V5.46875Z" fill="#111111"/><path fill-rule="evenodd" clip-rule="evenodd" d="M12.5 3.90625C12.9315 3.90625 13.2812 4.25603 13.2812 4.6875V20.3125C13.2812 20.744 12.9315 21.0938 12.5 21.0938C12.0685 21.0938 11.7188 20.744 11.7188 20.3125V4.6875C11.7188 4.25603 12.0685 3.90625 12.5 3.90625Z" fill="#111111"/><path fill-rule="evenodd" clip-rule="evenodd" d="M2.34375 7.8125C2.34375 7.38103 2.69353 7.03125 3.125 7.03125H21.875C22.3065 7.03125 22.6562 7.38103 22.6562 7.8125C22.6562 8.24397 22.3065 8.59375 21.875 8.59375H3.125C2.69353 8.59375 2.34375 8.24397 2.34375 7.8125Z" fill="#111111"/><path fill-rule="evenodd" clip-rule="evenodd" d="M2.34375 17.1875C2.34375 16.756 2.69353 16.4062 3.125 16.4062H21.875C22.3065 16.4062 22.6562 16.756 22.6562 17.1875C22.6562 17.619 22.3065 17.9688 21.875 17.9688H3.125C2.69353 17.9688 2.34375 17.619 2.34375 17.1875Z" fill="#111111"/><path fill-rule="evenodd" clip-rule="evenodd" d="M7.8125 3.90625C8.24397 3.90625 8.59375 4.25603 8.59375 4.6875V7.8125C8.59375 8.24397 8.24397 8.59375 7.8125 8.59375C7.38103 8.59375 7.03125 8.24397 7.03125 7.8125V4.6875C7.03125 4.25603 7.38103 3.90625 7.8125 3.90625Z" fill="#111111"/><path fill-rule="evenodd" clip-rule="evenodd" d="M17.1875 3.90625C17.619 3.90625 17.9688 4.25603 17.9688 4.6875V7.8125C17.9688 8.24397 17.619 8.59375 17.1875 8.59375C16.756 8.59375 16.4062 8.24397 16.4062 7.8125V4.6875C16.4062 4.25603 16.756 3.90625 17.1875 3.90625Z" fill="#111111"/><path fill-rule="evenodd" clip-rule="evenodd" d="M7.8125 16.4062C8.24397 16.4062 8.59375 16.756 8.59375 17.1875V20.3125C8.59375 20.744 8.24397 21.0938 7.8125 21.0938C7.38103 21.0938 7.03125 20.744 7.03125 20.3125V17.1875C7.03125 16.756 7.38103 16.4062 7.8125 16.4062Z" fill="#111111"/><path fill-rule="evenodd" clip-rule="evenodd" d="M17.1875 16.4062C17.619 16.4062 17.9688 16.756 17.9688 17.1875V20.3125C17.9688 20.744 17.619 21.0938 17.1875 21.0938C16.756 21.0938 16.4062 20.744 16.4062 20.3125V17.1875C16.4062 16.756 16.756 16.4062 17.1875 16.4062Z" fill="#111111"/></svg>
                <?=$movie->acf->metraje[0]->post_title?> completo
            </li>
            <?php if($movie->acf->tiene_acompanamiento){ ?>
                <li>
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.1324 2.43566C12.3621 2.31311 12.6379 2.31311 12.8676 2.43566L24.5864 8.68566C24.841 8.82144 25 9.08648 25 9.375C25 9.66353 24.841 9.92856 24.5864 10.0643L12.8676 16.3143C12.6379 16.4369 12.3621 16.4369 12.1324 16.3143L0.413603 10.0643C0.159022 9.92856 0 9.66353 0 9.375C0 9.08648 0.159022 8.82144 0.413603 8.68566L12.1324 2.43566ZM2.44141 9.375L12.5 14.7396L22.5586 9.375L12.5 4.01042L2.44141 9.375Z" fill="#111111"/><path fill-rule="evenodd" clip-rule="evenodd" d="M11.8108 9.00751C12.0139 8.6268 12.4871 8.48277 12.8678 8.68582L18.7272 11.8108C18.9818 11.9466 19.1408 12.2116 19.1408 12.5002V23.4377C19.1408 23.8691 18.791 24.2189 18.3595 24.2189C17.9281 24.2189 17.5783 23.8691 17.5783 23.4377V12.9689L12.1325 10.0645C11.7518 9.86145 11.6078 9.38822 11.8108 9.00751Z" fill="#111111"/><path fill-rule="evenodd" clip-rule="evenodd" d="M3.51563 10.0488C3.9471 10.0488 4.29688 10.3986 4.29688 10.8301V16.1523L4.29859 16.1545L4.29855 16.1546C4.87793 16.9328 7.44687 19.9219 12.5 19.9219C17.5531 19.9219 20.1221 16.9328 20.7015 16.1546L20.7031 16.1523V10.8301C20.7031 10.3986 21.0529 10.0488 21.4844 10.0488C21.9159 10.0488 22.2656 10.3986 22.2656 10.8301V16.1621L22.2656 16.1654C22.2642 16.4997 22.1542 16.8245 21.9524 17.0909C21.219 18.0748 18.2413 21.4844 12.5 21.4844C6.75873 21.4844 3.78103 18.0747 3.04765 17.0909C2.84576 16.8245 2.7358 16.4997 2.73439 16.1654L2.73438 16.1621H2.73438V10.8301C2.73438 10.3986 3.08416 10.0488 3.51563 10.0488Z" fill="#111111"/></svg>
                    Modo pedagógico
                </li>
                <li>
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.1324 2.43566C12.3621 2.31311 12.6379 2.31311 12.8676 2.43566L24.5864 8.68566C24.841 8.82144 25 9.08648 25 9.375C25 9.66353 24.841 9.92856 24.5864 10.0643L12.8676 16.3143C12.6379 16.4369 12.3621 16.4369 12.1324 16.3143L0.413603 10.0643C0.159022 9.92856 0 9.66353 0 9.375C0 9.08648 0.159022 8.82144 0.413603 8.68566L12.1324 2.43566ZM2.44141 9.375L12.5 14.7396L22.5586 9.375L12.5 4.01042L2.44141 9.375Z" fill="#111111"/><path fill-rule="evenodd" clip-rule="evenodd" d="M11.8108 9.00751C12.0139 8.6268 12.4871 8.48277 12.8678 8.68582L18.7272 11.8108C18.9818 11.9466 19.1408 12.2116 19.1408 12.5002V23.4377C19.1408 23.8691 18.791 24.2189 18.3595 24.2189C17.9281 24.2189 17.5783 23.8691 17.5783 23.4377V12.9689L12.1325 10.0645C11.7518 9.86145 11.6078 9.38822 11.8108 9.00751Z" fill="#111111"/><path fill-rule="evenodd" clip-rule="evenodd" d="M3.51563 10.0488C3.9471 10.0488 4.29688 10.3986 4.29688 10.8301V16.1523L4.29859 16.1545L4.29855 16.1546C4.87793 16.9328 7.44687 19.9219 12.5 19.9219C17.5531 19.9219 20.1221 16.9328 20.7015 16.1546L20.7031 16.1523V10.8301C20.7031 10.3986 21.0529 10.0488 21.4844 10.0488C21.9159 10.0488 22.2656 10.3986 22.2656 10.8301V16.1621L22.2656 16.1654C22.2642 16.4997 22.1542 16.8245 21.9524 17.0909C21.219 18.0748 18.2413 21.4844 12.5 21.4844C6.75873 21.4844 3.78103 18.0747 3.04765 17.0909C2.84576 16.8245 2.7358 16.4997 2.73439 16.1654L2.73438 16.1621H2.73438V10.8301C2.73438 10.3986 3.08416 10.0488 3.51563 10.0488Z" fill="#111111"/></svg>
                    Acompañamiento pedagógico
                </li>
            <?php } ?>
            <!-- <li>
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.7839 3.1853C13.5064 3.11176 13.2161 3.10029 12.9337 3.15169C12.6513 3.2031 12.3837 3.31612 12.15 3.48271C11.9162 3.64931 11.722 3.86538 11.5813 4.11555C11.4405 4.36573 11.3567 4.64385 11.3356 4.93012L11.3352 4.93563L11.3352 4.93563C11.3081 5.27176 11.3703 5.60909 11.5155 5.91346C11.631 6.15552 11.6142 6.43989 11.4711 6.6667C11.328 6.89352 11.0786 7.03108 10.8104 7.03108H6.24983V11.201C6.24983 11.4691 6.11231 11.7186 5.88555 11.8617C5.65878 12.0048 5.37447 12.0216 5.13241 11.9062C4.8733 11.7827 4.59014 11.7178 4.3031 11.7162C4.01605 11.7146 3.73218 11.7762 3.47168 11.8968C3.21117 12.0173 2.98045 12.1938 2.79592 12.4137C2.61139 12.6336 2.47759 12.8914 2.40405 13.1689C2.33051 13.4464 2.31904 13.7367 2.37044 14.0191C2.42185 14.3015 2.53487 14.5691 2.70146 14.8028C2.86806 15.0366 3.08413 15.2308 3.3343 15.3715C3.58447 15.5123 3.8626 15.5961 4.14887 15.6172L4.15438 15.6176L4.15438 15.6176C4.49052 15.6447 4.82784 15.5825 5.13221 15.4373C5.37427 15.3218 5.65864 15.3386 5.88545 15.4817C6.11227 15.6248 6.24983 15.8742 6.24983 16.1424V20.3123H20.3123V17.1674C20.188 17.1815 20.0627 17.189 19.937 17.1897C19.4203 17.1926 18.9093 17.0816 18.4404 16.8646C17.9715 16.6476 17.5562 16.3299 17.2241 15.9341C16.8919 15.5384 16.6511 15.0742 16.5187 14.5748C16.3863 14.0754 16.3657 13.5529 16.4582 13.0445C16.5507 12.5362 16.7542 12.0545 17.054 11.6337C17.3539 11.213 17.7428 10.8635 18.1932 10.6101C18.6427 10.3572 19.1423 10.2063 19.6567 10.1681C19.8759 10.1507 20.0954 10.1541 20.3123 10.1779V7.03108H15.7518C15.4836 7.03108 15.2342 6.89356 15.0911 6.6668C14.948 6.44003 14.9312 6.15572 15.0466 5.91366C15.1701 5.65455 15.235 5.37139 15.2366 5.08435C15.2382 4.7973 15.1766 4.51343 15.056 4.25293C14.9354 3.99242 14.7589 3.7617 14.5391 3.57717C14.3192 3.39264 14.0613 3.25884 13.7839 3.1853ZM12.6539 1.61445C13.1622 1.52192 13.6847 1.54258 14.1842 1.67495C14.6836 1.80732 15.1477 2.04815 15.5435 2.3803C15.9393 2.71246 16.257 3.12777 16.474 3.59667C16.691 4.06558 16.802 4.57655 16.7991 5.09323C16.7983 5.21894 16.7909 5.34423 16.7768 5.46858H20.3123C20.7267 5.46858 21.1242 5.6332 21.4172 5.92623C21.7102 6.21925 21.8748 6.61668 21.8748 7.03108V11.201C21.8748 11.4692 21.7373 11.7186 21.5105 11.8617C21.2836 12.0048 20.9993 12.0216 20.7572 11.9061C20.4528 11.7609 20.1155 11.6987 19.7794 11.7258L19.7739 11.7262C19.4876 11.7473 19.2095 11.8312 18.9593 11.9719C18.7091 12.1127 18.4931 12.3068 18.3265 12.5406C18.1599 12.7743 18.0468 13.0419 17.9954 13.3244C17.944 13.6068 17.9555 13.897 18.0291 14.1745C18.1026 14.452 18.2364 14.7098 18.4209 14.9297C18.6054 15.1496 18.8362 15.3261 19.0967 15.4466C19.3572 15.5672 19.6411 15.6288 19.9281 15.6272C20.2151 15.6256 20.4983 15.5607 20.7574 15.4372C20.9995 15.3218 21.2838 15.3386 21.5105 15.4817C21.7373 15.6248 21.8748 15.8743 21.8748 16.1424V20.3123C21.8748 20.7267 21.7102 21.1242 21.4172 21.4172C21.1242 21.7102 20.7267 21.8748 20.3123 21.8748H6.24983C5.83543 21.8748 5.438 21.7102 5.14498 21.4172C4.85195 21.1242 4.68733 20.7267 4.68733 20.3123V17.1655C4.47047 17.1893 4.251 17.1928 4.0318 17.1753C3.51741 17.1371 3.01771 16.9862 2.56815 16.7333C2.11784 16.4799 1.72891 16.1304 1.42904 15.7097C1.12917 15.2889 0.925729 14.8072 0.8332 14.2989C0.740671 13.7905 0.761327 13.2681 0.893698 12.7686C1.02607 12.2692 1.2669 11.805 1.59905 11.4093C1.93121 11.0135 2.34652 10.6958 2.81542 10.4788C3.28433 10.2618 3.7953 10.1508 4.31198 10.1537C4.43769 10.1544 4.56298 10.1619 4.68733 10.176V7.03108C4.68733 6.61668 4.85195 6.21925 5.14498 5.92623C5.438 5.6332 5.83543 5.46858 6.24983 5.46858H9.78726C9.76345 5.25167 9.76003 5.03216 9.77752 4.81291C9.81571 4.29857 9.96661 3.79892 10.2195 3.3494C10.4729 2.89909 10.8224 2.51016 11.2431 2.21029C11.6639 1.91042 12.1456 1.70698 12.6539 1.61445Z" fill="#111111"/></svg>
                Tótems de contenido complementario
            </li> -->
            </ul>
        </article>
    
    </section>
    <section class="ciclosRel">
        <h2>Ciclos a los que pertenece</h2>
        <ul class="ciclos-list">

        </ul>
    </section>
    <section class="moviesRel">
        <h2>Películas relacionadas</h2>
        <ul >
        <li class="afiche-movie skeleton"><a href="#"></a></li>
        <li class="afiche-movie skeleton"><a href="#"></a></li>
        <li class="afiche-movie skeleton"><a href="#"></a></li>
        <li class="afiche-movie skeleton"><a href="#"></a></li>
        </ul>
    </section>
</div>
</main>
<?php include 'includes/footer.php'; ?>