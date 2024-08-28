<?php 
    $bodyClass = "obtener";
    include 'includes/head.php';
    include 'includes/header.php';
    $obten = $sdk->query("pages/23295");
    $obten = $obten['response'];
?>
<main>
    <div class="banner" style="background-image:url(images/bannerobtener.jpg);">
        <div class="text">
            <h1><?=$obten->acf->titulo_banner?></h1>
            <a href="#content" class="btn btn-primary">Saber más</a>
        </div>
    </div>

    <section class="intro">
    <?=$obten->content->rendered?>
    </section>
    <section class="zigzag container" id="content">
    <?php
        $secciones = [
            'seccion_1' => 'fade-right',
            'seccion_2' => 'fade-left',
            'seccion_3' => 'fade-right',
            'seccion_4' => 'fade-left'
        ];

        foreach ($secciones as $seccion => $animacion) {
            $titulo = $obten->acf->$seccion->titulo;
            $imagen = $obten->acf->$seccion->imagen;
            $desc = $obten->acf->$seccion->desc;
            echo "<article data-aos=\"$animacion\">
                    <img src=\"$imagen\" alt=\"$titulo\">
                    <div class=\"txt\">
                        <h2>$titulo</h2>
                        $desc
                    </div>
                </article>";
        }
    ?>

    </section>
    <section class="banner_bottom container">
        <ul>
            <li><strong><?=$sdk->generalInfo->acf->numero_peliculas?></strong><?=$sdk->generalInfo->acf->palabra_1_banner?>
            </li>
            <li><strong><?=$sdk->generalInfo->acf->numero_recursos_pedagogicos?></strong><?=$sdk->generalInfo->acf->palabra_2_banner?>
            </li>
        </ul>
    </section>
    <section class="planes container">
        <div class="info">
            <h3><?= $obten->acf->titulo_planes?></h3>
            <?= $obten->acf->descripcion_planes?>
        </div>
        <ul>
            <?php 
                $planes = $sdk->query("cinescuela-plan");
                $planes = $planes['response'];
            for ($i=0; $i < count($planes); $i++) { 
                $plan = $planes[$i];
            ?>
            <li>
                <h4><?=$plan->title->rendered?></h4>
                <?=$plan->content->rendered?>
                <!-- <div class="price">
                    <small>Desde</small>
                    <strong>
                        <pre>$</pre>1M
                    </strong>
                    <small>año*</small>
                </div> -->
                <a href="<?=$lang?>/contacto" class="btn btn-primary">Contacta con Ventas</a>
                <small><?=$plan->acf->condiciones?></small>
            </li>
            <?php }?>
        </ul>
    </section>
</main>
<?php include 'includes/footer.php'; ?>