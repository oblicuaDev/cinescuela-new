<?php 
    $bodyClass = "ciclo";
    include 'includes/head.php';
    include 'includes/header.php';
    $ciclo = $sdk->getCiclos($_GET['id']);
?>
<main data-movies="<?=json_encode($ciclo->acf->peliculas_del_ciclo)?>" data-cicloid="<?=$_GET['id']?>">
    <section class="container">
        <div class="ciclo-mes">
            <img src="<?=$ciclo->acf->imagen_principal_el_ciclo?>" alt="<?=$ciclo->title->rendered?>">
            <div class="info">
                <h2><?=$ciclo->title->rendered?></h2>
                <small><?=$ciclo->acf->mes_del_ciclo?> <?=$ciclo->acf->ano_del_ciclo?></small>
                <?=$ciclo->acf->descripcion_corta_del_ciclo?>
            </div>
        </div>
    </section>
    <section class="container">
        <h2>Películas de este ciclo</h2>
        <ul class="movies">
        <li class="afiche-movie skeleton"><a href="#"></a></li>
        <li class="afiche-movie skeleton"><a href="#"></a></li>
        <li class="afiche-movie skeleton"><a href="#"></a></li>
        <li class="afiche-movie skeleton"><a href="#"></a></li>
        <li class="afiche-movie skeleton"><a href="#"></a></li>
        </ul>
    </section>
    <section class="container ciclosrel">
        <h2>Otros Ciclos</h2>
        <ul class="ciclos-list">

            <li class="skeleton"><a href=""><div class="image"></div></a></li>
            <li class="skeleton"><a href=""><div class="image"></div></a></li>
            

        </ul>
    </section>
</main>
<?php include 'includes/footer.php'; ?>