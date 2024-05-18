<?php 
 
    function pager($currentPage,$totalPages){
        $cadena = '<ul>';
        if($currentPage>1){ 
            $cadena .='<li><a href="'.currentURL().'/pagina-'.($currentPage-1).'" class="prev">prev</a></li>';
        } 
        for($i=1;$i<=$totalPages;$i++){ 
            $cadena .='<li><a href="'.currentURL().'/pagina-'.$i.'"'; 
            if($currentPage==$i){ $cadena .='class="active"'; }
            $cadena .='>'.$i.'</a></li>';
        } 
        if($currentPage<$totalPages){ 
            $cadena .='<li><a href="'.currentURL().'/pagina-'.($currentPage+1).'" class="next">next</a></li>';
        } 
        $cadena .='</ul>';
        if(isset($_GET['page'])){
            $cadena=str_replace('/pagina-'.$_GET['page'].'/', '/', $cadena);
        }
        echo $cadena;
    }
    $bodyClass = "movies";
    include 'includes/head.php';
    include 'includes/header.php';
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    // Obtener películas para la página actual
    $postsParams = ['field' => 'pelicula_destacada,pelicula_frances', 'value' => '0,' . ($lang == 'es' ? 0 : 1),'order'=>'asc'];
    $posts = $sdk->getPeliculas("", $currentPage, 30, $postsParams);
    $totalPages = $posts['total_pages'];
    $posts = $posts['response'];
?>
<main>
    <section class="container">
    <ul class="grid-elements">
            <?php
            for ($i=0; $i < count($posts); $i++) { 
                $post = $posts[$i];
            // Supongamos que $post contiene los datos que deseas pasar a getInfoMovie()
            // Convertimos $post a JSON de forma segura
            $post_json = json_encode($post);

            // Escapamos las comillas para evitar problemas con el HTML
            $post_json_escaped = htmlspecialchars($post_json, ENT_QUOTES, 'UTF-8');
            ?>
                <li onclick="getInfoMovie(<?= $post_json_escaped ?>)"><a href="javascript:;" data-fancybox="" data-src="#dialog-content" data-temalight="false"><img loading="lazy" class="lazyload" src="<?=$post->acf->imagen_pelicula?>" data-src="<?=$post->acf->imagen_pelicula?>" alt="Logo Pelicula"><img loading="lazy" class="lazyload movieLogo" src="<?=$post->acf->logo_de_la_pelicula?>" data-src="<?=$post->acf->logo_de_la_pelicula?>" alt="Logo Pelicula"></a></li>
            <?php
            }
            ?>
        </ul>
        <div class="pager">
			<? pager($currentPage, $totalPages); ?>
		</div>
    </section>
</main>
<?php include 'includes/footer.php'; ?>