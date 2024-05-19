<?php 
    $bodyClass = "novedades";
    include 'includes/head.php';
    include 'includes/header.php';
    $novedades=$sdk->query('posts/'.$_GET['id']);
    $novedades = $novedades['response'];
?>
<main>
    <div class="container">
        <h1><?=$novedades->title->rendered?></h1>
        <h2><?=$novedades->acf->fecha_de_publicacion?></h2>
    <img src="<?=$sdk->replaceUrl($novedades->acf->imagen)?>" alt="<?=$novedades->title->rendered?>">
        <?=$novedades->content->rendered?>
    </div>
</main>
<div class="more-news container">
    <h3>Otras publicaciones</h3>
    <div class="novedades-list">

    </div>
</div>
<?php include 'includes/footer.php'; ?>