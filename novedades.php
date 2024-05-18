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
    <img src="<?=$sdk->replaceUrl($novedades->acf->imagen)?>" alt="<?=$novedades->title->rendered?>">
        <?=$novedades->content->rendered?>
    </div>
</main>
<?php include 'includes/footer.php'; ?>