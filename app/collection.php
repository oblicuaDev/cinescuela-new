<?php 
    $bodyClass = "collections";
    include 'includes/head.php';
    include 'includes/header.php';
    $coll = $sdk->getCollections($_GET["id"], 1, 11, []);
    $posts = $sdk->getPeliculas($coll->acf->peliculas, 1, 99, []);
?>

<main>
    <div class="container">
        <h1><?=$coll->title->rendered?></h1>

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
            <a data-temalight="<?=$theme?>" href="javascript:;" data-fancybox="" data-src="#dialog-content">
                <picture>
                    <source media="(max-width: 1023px)" srcset="<?=$sdk->replaceUrl($post->acf->afiche)?>">
                    <img src="<?=$sdk->replaceUrl($post->acf->imagen_pelicula)?>" alt="<?=$post->title->rendered?>" id="logo">
                </picture>
                <?php if($post->acf->logo_de_la_pelicula){ ?>
                    <img loading="lazy" class="lazyload movieLogo" src="https://picsum.photos/20/20"
                        data-src="<?=$sdk->replaceUrl($post->acf->logo_de_la_pelicula)?>" alt="Logo Pelicula">
                <?php }else{ ?>
                    <span class="title-movie"><?=$post->title->rendered?></span>
                <?php } ?>
            </a>
        </li>
        <?php }
        }
        ?>
    </ul>
</main>
<?php include 'includes/footer.php'; ?>