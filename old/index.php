<?php
	if(!isset($_GET['lang'])){
		header('Location: /es ', true, 301);
		die();
	}
?>
<?php include 'includes/head.php'; ?>
<!--Contenedor principal-->
<div id="main_container" class="home">

	<!--Encabezado-->
	<?php include 'includes/header.php'; ?><!--Fin Encabezado-->
	<!--Frases cinescuela-->
	<section class="phrases_cinescuela">		
		<!--Slider frases-->
		<div class="content_slider">
			<ul class="slider_cinescuela">
            <? $destacados = $cinescuela->getSliderPrincipales(); ?>
			<?php for($i=0;$i<count($destacados);$i++){ $post = $destacados[$i]; ?>
				<li>
					<figure style="background-image:url(<?=replaceUrl($post->acf->imagen_slide)?>);"></figure>
					<div>
						<img src="<?=$post->acf->icono_slide?>" alt="icono">
						<p><?=$post->title->rendered?></p>
					</div>
					<span class="overlay"></span>
				</li>
			<?php } ?>
			</ul>
		</div><!--Slider frases-->
		
		<!--Boton Conoce más-->
		<div class="learn_more">
			<?=find_array($json,33, $lang_ct)?><a href="#anchor_more">more</a>
		</div><!--Fin Boton Conoce más-->
	</section><!--Fin Frases cinescuela-->
	
	<!--Peliculas del mes-->
	<? 
	$mes = $cinescuela->getPeliculas($gnrl->filmonth_gnrl); 
	if(count($mes)>0){ ?>
	<section class="movies_month" id="anchor_more">
		<div class="title">
			<h2><?=find_array($json,34, $lang_ct)?></h2>
		</div>
		<!--Slider peliculas-->
		<div class="content_slider">
			<div class="slider_movies">
				<?php 
			for($j=0;$j<count($mes);$j++){ $post = $mes[$j]["response"];?>
				<article>
					<figure class="main_img" style="background-image: url(<?=replaceUrl($post->acf->imagen_pelicula)?>);"></figure>
					<div>
						<h2><?=$post->title->rendered?></h2><hr>
						<a href="<?=$_GET['lang']?>/pelicula/<?=get_alias($post->title->rendered)?>-<?=$post->id?>" class="btn_more" onClick="ga('send', 'event', 'Películas', 'click', 'botón mas - <?=$post->title->rendered?>')"><?=find_array($json,35, $lang_ct)?></a>
						<div><?=$post->content->rendered?></div>
						<!--<img src="images/site/rank_4.png" alt="calificacion" class="ranking">-->
					</div>
					<span class="overlay"></span>
				</article>
			<?php } ?>
			</div>
		</div><!--Fin Slider peliculas-->
		<!--Carrusel peliculas-->
		<div class="content_carousel">
			<ul id="carousel_movies">
			<?php for($j=0;$j<count($mes);$j++){ $post = $mes[$j]["response"];?>
				<li><a data-slide-index="<?php echo $j; ?>" href="" onClick="ga('send', 'event', 'Películas', 'click','slide peliculas - <?=$post->title->rendered?>')"><img src="<?=replaceUrl($post->acf->afiche)?>" alt="<?=$post->title->rendered?>"></a></li>
			<?php } ?>
			</ul>
		</div><!--Fin Carrusel peliculas-->
	</section>
<? }?>
	<!--Fin Peliculas del mes-->
	
	<!--Ciclo del mes-->
	<?php 
		$post = $cinescuela->getCiclos($gnrl->cyclemonth_gnrl);
		$post = $post[0]["response"];
		if(isset($post->title->rendered)){ 
	?>
	<div class="month_cycle">
		<article>
             
			<figure><img src="<?=replaceUrl($post->acf->imagen_principal_el_ciclo)?>" alt="<?=$post->title->rendered?>"></figure>
			<div>
             
				<span><?=find_array($json,36, $lang_ct)?></span>
				<h2><?=$post->title->rendered?></h2>
				<time datetime="<?=$post->creation_date?>"><?=$post->acf->mes_del_ciclo?> <?=$post->acf->ano_del_ciclo?></time><hr>
				<div>
					<?=$post->acf->descripcion_corta_del_ciclo?>
				</div>
				<a href="<?=$_GET['lang']?>/ciclo/<?=get_alias($post->title->rendered)?>-<?=$post->id?>" class="btn" onClick="ga('send', 'event', 'Ciclos', 'click','Ir al ciclo - <?=$post->title->rendered?>')"><?=find_array($json,37, $lang_ct)?></a>
				<a href="<?=$_GET['lang']?>/ciclos" class="btn" onClick="ga('send', 'event', 'Ciclos', 'click','Ver todos')"><?=find_array($json,38, $lang_ct)?></a>
            </div>

		</article>
	</div><? }?><!--Fin Ciclo del mes-->
	
	<!--Frases educacion-->
	<section class="phrases_education">
		<ul id="slider_phr_edu">
         <? $destacados = $cinescuela->getSliderSecundarios(); ?>
		<?php for($i=0;$i<count($destacados);$i++){ $post = $destacados[$i]; ?>
			<li>
				<figure style="background-image:url(<?=replaceUrl($post->acf->imagen_slide)?>);"></figure>
				<div><?=$post->title->rendered?></div>
				<span class="overlay"></span>
			</li>
		<?php } ?>
		</ul>
	</section><!--Fin Frases educacion-->
	
	<!--Noticias recientes-->
	<section class="latest_news">
		<h2><?=find_array($json,6, $lang_ct)?></h2>
         <? $destacadosNews=$cinescuela->query('posts','','GET',1,4,['field'=>'destacado', 'value'=> 1, 'categories'=> 9,'order'=> 'asc']);?>
        <?php if(is_array($destacadosNews['response'])){ for($i=0;$i<count($destacadosNews['response']);$i++){ $post = $destacadosNews['response'][$i]; ?>
		<article>
			<figure><a href="<?=$_GET['lang']?>/informacion/16/<?=get_alias($post->title->rendered)?>-<?=$post->id?>" onClick="ga('send', 'event', 'Actualidad', 'click','<?=$post->title->rendered?>')"><img src="<?=replaceUrl($post->acf->imagen)?>" alt="<?=$post->title->rendered?>"></a></figure>
			<div>
				<?
					$date = DateTime::createFromFormat('d/m/Y', $post->acf->fecha_de_publicacion);
					if ($date !== false) {
					$newD = $date->format('Y-m-d');
					} else {
					echo "";
					}
				?>
				<time datetime="<?=$post->acf->fecha_de_publicacion?>"><?=$newD?></time>
				<h2><a href="<?=$_GET['lang']?>/informacion/16/<?=get_alias($post->title->rendered)?>-<?=$post->id?>" onClick="ga('send', 'event', 'Actualidad', 'click','<?=$post->title->rendered?>')"><?=$post->title->rendered ?></a></h2>
				<p><?=$post->acf->descripcion_corta?></p>
			</div>
		</article>
		<?php } } ?>
		<a href="<?=$_GET['lang']?>/actualidad" class="btn_more" onClick="ga('send', 'event', 'Actualidad', 'click','Ver todas las noticias')"><?=find_array($json,39, $lang_ct)?></a>
	</section><!--Fin noticias recientes-->
<?php
	/*  DIV en caso de token-- $user and $token  */
	$token = filter_input(INPUT_GET, 'token');
	$user  = filter_input(INPUT_GET, 'user');
	?>
	<script>console.log(<?=$token?>);console.log(<?=$user?>);</script>
	<?
	if (!empty($token) && !empty($user)) {
		$source = 'mail';
?>
	<div><a href="login.php?user=<?=$user?>&token=<?=$token?>&source=<?=$source?>" class="open_renew"></a></div>
	<script>
	function openColorboxSession(){

		$('.open_renew').colorbox({
			maxWidth:'480px',
			width:'95%'
		});
		$(".open_renew")[0].click();
	}
	</script>
<?php }?>

<?php include 'includes/footer.php'; ?>