<?php 
    $bodyClass = "acomp";
    include 'includes/head.php';
    $movie = $sdk->getPeliculas($_GET['id']);
    $acomp = $movie->related_cinescuela_ap;
    $culturaSociedad = $sdk->getCS($acomp->id);
    $acomp = $acomp->acf_fields;
    $moviesIDs = array_map('strval', $_SESSION['logged']['perfil_de_usuario'][0]->peliculas_del_ciclo);
?>
<header class="acomp_header">
    <div class="container">
        <img src="<?=$movie->acf->logo_de_la_pelicula?>" alt="Logo Pelicula">
        <div class="actions">
            <?php if(!isset($_SESSION['logged'])){ ?>
                <a href="<?=$lang?>/pelicula/<?=$sdk->get_alias($movie->title->rendered)?>-<?=$movie->id?>"
                    class="btn btn-primary"><svg width="50" height="50" viewBox="0 0 50 50" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M6.25 21.875C6.25 21.0121 6.94956 20.3125 7.8125 20.3125H42.1875C43.0504 20.3125 43.75 21.0121 43.75 21.875V39.0625C43.75 39.8913 43.4208 40.6862 42.8347 41.2722C42.2487 41.8583 41.4538 42.1875 40.625 42.1875H9.375C8.5462 42.1875 7.75134 41.8583 7.16529 41.2722C6.57924 40.6862 6.25 39.8913 6.25 39.0625V21.875ZM9.375 23.4375V39.0625H40.625V23.4375H9.375Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M37.0668 4.33312C37.4604 4.22325 37.8719 4.19211 38.2776 4.24156C38.6877 4.29155 39.0838 4.4229 39.4426 4.62792C39.8014 4.83293 40.1156 5.10749 40.3669 5.43549C40.617 5.76191 40.7998 6.13473 40.9047 6.53231C40.9052 6.53425 40.9057 6.53619 40.9062 6.53813L42.5247 12.5635C42.6322 12.9638 42.5763 13.3904 42.3692 13.7495C42.1621 14.1085 41.8208 14.3706 41.4205 14.478L8.21736 23.3842C7.38408 23.6077 6.52734 23.1136 6.30354 22.2804L4.68174 16.2426C4.57569 15.845 4.54921 15.4304 4.6038 15.0226C4.65839 14.6148 4.79299 14.2217 4.99987 13.866C5.20674 13.5104 5.48182 13.199 5.80932 12.9499C6.13556 12.7018 6.50741 12.5203 6.90368 12.4157C6.90522 12.4153 6.90676 12.4149 6.9083 12.4145L37.0668 4.33312ZM37.8881 7.34828L37.8849 7.34915L7.70916 15.4351L7.70117 15.4372L8.91637 19.9612L39.1012 11.8646L37.8881 7.34828Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M24.0569 8.28106C24.4885 7.5338 25.4441 7.27788 26.1914 7.70947L35.7617 13.2368C36.509 13.6684 36.7649 14.624 36.3333 15.3713C35.9017 16.1186 34.9461 16.3745 34.1988 15.9429L24.6285 10.4156C23.8812 9.98398 23.6253 9.02833 24.0569 8.28106Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M10.4834 11.9322C10.9156 11.1853 11.8715 10.9303 12.6184 11.3625L22.1691 16.8898C22.916 17.3221 23.1711 18.278 22.7388 19.0249C22.3066 19.7717 21.3507 20.0268 20.6038 19.5946L11.0531 14.0672C10.3062 13.635 10.0511 12.6791 10.4834 11.9322Z"
                            fill="currentColor" />
                    </svg>Volver al Catálogo web</a>
            <?php }else{ ?>
                <a href="<?=$lang?>/pelicula/<?=$sdk->get_alias($movie->title->rendered)?>-<?=$movie->id?>"
                    class="btn btn-primary"><svg width="50" height="50" viewBox="0 0 50 50" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M6.25 21.875C6.25 21.0121 6.94956 20.3125 7.8125 20.3125H42.1875C43.0504 20.3125 43.75 21.0121 43.75 21.875V39.0625C43.75 39.8913 43.4208 40.6862 42.8347 41.2722C42.2487 41.8583 41.4538 42.1875 40.625 42.1875H9.375C8.5462 42.1875 7.75134 41.8583 7.16529 41.2722C6.57924 40.6862 6.25 39.8913 6.25 39.0625V21.875ZM9.375 23.4375V39.0625H40.625V23.4375H9.375Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M37.0668 4.33312C37.4604 4.22325 37.8719 4.19211 38.2776 4.24156C38.6877 4.29155 39.0838 4.4229 39.4426 4.62792C39.8014 4.83293 40.1156 5.10749 40.3669 5.43549C40.617 5.76191 40.7998 6.13473 40.9047 6.53231C40.9052 6.53425 40.9057 6.53619 40.9062 6.53813L42.5247 12.5635C42.6322 12.9638 42.5763 13.3904 42.3692 13.7495C42.1621 14.1085 41.8208 14.3706 41.4205 14.478L8.21736 23.3842C7.38408 23.6077 6.52734 23.1136 6.30354 22.2804L4.68174 16.2426C4.57569 15.845 4.54921 15.4304 4.6038 15.0226C4.65839 14.6148 4.79299 14.2217 4.99987 13.866C5.20674 13.5104 5.48182 13.199 5.80932 12.9499C6.13556 12.7018 6.50741 12.5203 6.90368 12.4157C6.90522 12.4153 6.90676 12.4149 6.9083 12.4145L37.0668 4.33312ZM37.8881 7.34828L37.8849 7.34915L7.70916 15.4351L7.70117 15.4372L8.91637 19.9612L39.1012 11.8646L37.8881 7.34828Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M24.0569 8.28106C24.4885 7.5338 25.4441 7.27788 26.1914 7.70947L35.7617 13.2368C36.509 13.6684 36.7649 14.624 36.3333 15.3713C35.9017 16.1186 34.9461 16.3745 34.1988 15.9429L24.6285 10.4156C23.8812 9.98398 23.6253 9.02833 24.0569 8.28106Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M10.4834 11.9322C10.9156 11.1853 11.8715 10.9303 12.6184 11.3625L22.1691 16.8898C22.916 17.3221 23.1711 18.278 22.7388 19.0249C22.3066 19.7717 21.3507 20.0268 20.6038 19.5946L11.0531 14.0672C10.3062 13.635 10.0511 12.6791 10.4834 11.9322Z"
                            fill="currentColor" />
                    </svg>Volver a la Pelicula</a>
            <?php } ?>
            <a href="javascript:;" id="ruta_pedagogica" class="btn btn-secondary"><svg width="50" height="50" viewBox="0 0 50 50" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M24.2647 4.87132C24.7243 4.62623 25.2757 4.62623 25.7353 4.87132L49.1728 17.3713C49.682 17.6429 50 18.173 50 18.75C50 19.3271 49.682 19.8571 49.1728 20.1287L25.7353 32.6287C25.2757 32.8738 24.7243 32.8738 24.2647 32.6287L0.827206 20.1287C0.318044 19.8571 0 19.3271 0 18.75C0 18.173 0.318044 17.6429 0.827206 17.3713L24.2647 4.87132ZM4.88281 18.75L25 29.4792L45.1172 18.75L25 8.02083L4.88281 18.75Z"
                        fill="currentColor" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M23.6211 18.0146C24.0272 17.2532 24.9737 16.9652 25.7351 17.3713L37.4539 23.6213C37.963 23.8928 38.2811 24.4229 38.2811 24.9999V46.8749C38.2811 47.7379 37.5815 48.4374 36.7186 48.4374C35.8556 48.4374 35.1561 47.7379 35.1561 46.8749V25.9374L24.2645 20.1286C23.5031 19.7225 23.2151 18.7761 23.6211 18.0146Z"
                        fill="currentColor" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.03126 20.0977C7.89421 20.0977 8.59376 20.7972 8.59376 21.6602V32.3046L8.59719 32.3091L8.5971 32.3091C9.75586 33.8657 14.8937 39.8438 25 39.8438C35.1063 39.8438 40.2442 33.8657 41.4029 32.3091L41.4063 32.3047V21.6602C41.4063 20.7972 42.1058 20.0977 42.9688 20.0977C43.8317 20.0977 44.5313 20.7972 44.5313 21.6602V32.3242L44.5312 32.3308C44.5284 32.9995 44.3085 33.649 43.9047 34.1818C42.4379 36.1495 36.4825 42.9688 25 42.9688C13.5175 42.9688 7.56205 36.1494 6.09529 34.1817C5.69153 33.649 5.4716 32.9995 5.46878 32.3308L5.46875 32.3242H5.46876V21.6602C5.46876 20.7972 6.16832 20.0977 7.03126 20.0977Z"
                        fill="currentColor" />
                </svg>Ruta Pedagógica	<div id="lista_ruta">
						<ul>
                        <? 
						$RutaRelacionada = $acomp->rutas_pedagogicas;
						?>
						<?php 
						for($j=1;$j<7;$j++){ 
							?>
                        <? 
							$paso ="paso_$j";
						if($RutaRelacionada->{$paso}->titulo!=""){ 
							?>
							<li>
								<span class="ico_num"><?php echo $j; ?></span><span class="vertical_line"></span>
								<div>
									<strong><?=$RutaRelacionada->{$paso}->titulo?></strong>
									<?=$RutaRelacionada->{$paso}->descripcion?>
								</div><hr>
							</li>
                            <? 
						} 
						?>
						<?php 
					} 
					?>
						</ul>
					</div></a>
        </div>
    </div>
    <div class="bottom-line">
        <div class="container">
            <small>Acompañamiento Pedagógico</small>
            <nav>
                <button <?= !isset($_GET['tabactive']) ? 'class="active"' : '' ?> <?=isset($_GET['tabactive']) && $_GET['tabactive'] == $sdk->get_alias('Presentación') ? 'class="active"' : ''?> type="button" onclick="changeTab('<?=$sdk->get_alias('Presentación')?>', event)">Presentación</button>
                <button <?=isset($_GET['tabactive']) && $_GET['tabactive'] == $sdk->get_alias('Lenguaje') ? 'class="active"' : ''?> type="button" onclick="changeTab('<?=$sdk->get_alias('Lenguaje')?>', event)">Lenguaje</button>
                <button <?=isset($_GET['tabactive']) && $_GET['tabactive'] == $sdk->get_alias('Contexto') ? 'class="active"' : ''?> type="button" onclick="changeTab('<?=$sdk->get_alias('Contexto')?>', event)">Contexto</button>
                <button <?=isset($_GET['tabactive']) && $_GET['tabactive'] == $sdk->get_alias('Cultura y sociedad') ? 'class="active"' : ''?> type="button" onclick="changeTab('<?=$sdk->get_alias('Cultura y sociedad')?>', event)">Cultura y
                    sociedad</button>
            </nav>
        </div>
    </div>
</header>
<main>
    <div class="container">
        <section class="tab <?= !isset($_GET['tabactive']) ? 'tab-active' : '' ?><?=isset($_GET['tabactive']) && $_GET['tabactive'] == $sdk->get_alias('Presentación') ? 'tab-active' : ''?>" id="<?=$sdk->get_alias("Presentación")?>">
            <article>
                <h2><svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M17.5 3.75C18.1904 3.75 18.75 4.30964 18.75 5V17.5L21.75 15.25C22.1944 14.9167 22.8056 14.9167 23.25 15.25L26.25 17.5V5C26.25 4.30964 26.8096 3.75 27.5 3.75C28.1904 3.75 28.75 4.30964 28.75 5V20C28.75 20.4735 28.4825 20.9063 28.059 21.118C27.6355 21.3298 27.1288 21.2841 26.75 21L22.5 17.8125L18.25 21C17.8712 21.2841 17.3645 21.3298 16.941 21.118C16.5175 20.9063 16.25 20.4735 16.25 20V5C16.25 4.30964 16.8096 3.75 17.5 3.75Z"
                            fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M11.2525 3.75H32.5C33.1904 3.75 33.75 4.30964 33.75 5V30C33.75 30.6904 33.1904 31.25 32.5 31.25H11.25L11.2448 31.25C10.9168 31.2486 10.5918 31.3122 10.2885 31.4371C9.98516 31.562 9.70959 31.7457 9.47766 31.9776C9.24572 32.2096 9.06201 32.4851 8.93712 32.7884C8.81518 33.0846 8.75168 33.4015 8.75003 33.7216V33.75C8.75003 34.4393 8.19198 34.9986 7.50265 35C6.81332 35.0014 6.25293 34.4446 6.25004 33.7552C6.24999 33.7422 6.24999 33.7292 6.25003 33.7162V8.75244M8.75003 29.4132C8.93864 29.3048 9.13455 29.2086 9.3366 29.1254C9.94416 28.8752 10.5952 28.7476 11.2522 28.75C11.2532 28.75 11.2543 28.75 11.2553 28.75L11.25 30V28.75H11.2522H31.25V30H32.5V28.75H31.25V6.25H32.5V5H31.25V6.25H11.2448C10.9168 6.24862 10.5918 6.3122 10.2885 6.43709C9.98516 6.56198 9.70959 6.74569 9.47766 6.97762C9.24572 7.20956 9.06201 7.48513 8.93712 7.78843C8.81224 8.09173 8.74865 8.41676 8.75002 8.74476L8.75004 8.75L8.75003 29.4132Z"
                            fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M7.5 32.5C8.19036 32.5 8.75 33.0596 8.75 33.75H30C30.6904 33.75 31.25 34.3096 31.25 35C31.25 35.6904 30.6904 36.25 30 36.25H7.5C6.80964 36.25 6.25 35.6904 6.25 35V33.75C6.25 33.0596 6.80964 32.5 7.5 32.5Z"
                            fill="white" />
                    </svg>Notas para el profesor</h2>
                <div class="content">
                    <?=$acomp->notas_para_el_profesor?>
                </div>
            </article>
            <article>
                <details open>
                    <summary>
                        <h2>Sinópsis  <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.29289 11.2929C5.68342 10.9024 6.31658 10.9024 6.70711 11.2929L16 20.5858L25.2929 11.2929C25.6834 10.9024 26.3166 10.9024 26.7071 11.2929C27.0976 11.6834 27.0976 12.3166 26.7071 12.7071L16.7071 22.7071C16.3166 23.0976 15.6834 23.0976 15.2929 22.7071L5.29289 12.7071C4.90237 12.3166 4.90237 11.6834 5.29289 11.2929Z"
                                    fill="white" />
                            </svg></h2>
                    </summary>
                    <div class="content">
                        <?=$acomp->presentaciones->sinopsis?>
                    </div>
                </details>
                <details>
                    <summary>
                        <h2>Ficha Técnica <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.29289 11.2929C5.68342 10.9024 6.31658 10.9024 6.70711 11.2929L16 20.5858L25.2929 11.2929C25.6834 10.9024 26.3166 10.9024 26.7071 11.2929C27.0976 11.6834 27.0976 12.3166 26.7071 12.7071L16.7071 22.7071C16.3166 23.0976 15.6834 23.0976 15.2929 22.7071L5.29289 12.7071C4.90237 12.3166 4.90237 11.6834 5.29289 11.2929Z"
                                    fill="white" />
                            </svg></h2>
                    </summary>
                    <div class="content">
                        <?=$acomp->presentaciones->ficha_tecnica?>
                    </div>
                </details>
                <details>
                    <summary>
                        <h2>Reconocimientos <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.29289 11.2929C5.68342 10.9024 6.31658 10.9024 6.70711 11.2929L16 20.5858L25.2929 11.2929C25.6834 10.9024 26.3166 10.9024 26.7071 11.2929C27.0976 11.6834 27.0976 12.3166 26.7071 12.7071L16.7071 22.7071C16.3166 23.0976 15.6834 23.0976 15.2929 22.7071L5.29289 12.7071C4.90237 12.3166 4.90237 11.6834 5.29289 11.2929Z"
                                    fill="white" />
                            </svg></h2>
                    </summary>
                    <div class="content">
                        <?=$acomp->presentaciones->reconocimientos?>
                    </div>
                </details>
            </article>
            <section>

                <ul class="tags">
                    <?php 
                    $tags = explode(',', $movie->acf->palabras_clave_de_esta_publicacion);
                    for ($i=0; $i < count($tags); $i++) { 
                        echo "<li>$tags[$i]</li>";
                    }
                    ?>
                </ul>
                <button type="button" onclick="openModalSugerencia('Keyword')" class="btn btn-primary sugerencia">Crear sugerencia</button>
            </section>
        </section>
        <section class="tab <?=isset($_GET['tabactive']) && $_GET['tabactive'] == $sdk->get_alias('Lenguaje') ? 'tab-active' : ''?>" id="<?=$sdk->get_alias("Lenguaje")?>">
            <div class="TabsMainSection">
                <div class="TabsMainRow">
                    <div class="TabsMainColLeft">
                        <div class="TabList">
                            <ul>
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    $actividad = $acomp->seccion_pelicula->{"actividad_$i"}; 
                                    if($actividad->titulo != ""){
                                ?>
                                <li data-name="Tab<?=$i?>"><button class="medium"><?=$actividad->titulo?> </button></li>
                                <?php }} ?>
                            </ul>
                        </div>
                    </div>
                    <div class="TabsMainColRight">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            $actividad = $acomp->seccion_pelicula->{"actividad_$i"}; 
                            if($actividad->titulo != ""){
                        ?>
                        <div class="Tab<?=$i?> TabContent">
                            <article>
                                <div class="content">
                                    <?=$actividad->descripcion?>
                                </div>
                            </article>
                            <article>
                                <img src="<?=$actividad->imagen?>" alt="<?=$actividad->titulo?>">
                                <div class="content">
                                    <?=$actividad->descripcion_imagen_o_video?>
                                </div>
                            </article>
                            <?php if(count($actividad->actividades_complementarias) > 0 && $actividad->actividades_complementarias != ""){ ?>
                                <article class="full actividadescomp">
                                    <h2><svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M16.25 35C16.25 34.3096 16.8096 33.75 17.5 33.75H22.5C23.1904 33.75 23.75 34.3096 23.75 35C23.75 35.6904 23.1904 36.25 22.5 36.25H17.5C16.8096 36.25 16.25 35.6904 16.25 35Z"
                                                fill="white" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M18.4291 2.12462C18.8712 1.76 19.4265 1.56042 19.9999 1.56042C20.5753 1.56042 21.1325 1.76139 21.5753 2.12844C23.1274 3.39244 26.4874 6.52604 28.3463 11.3578C30.2321 16.2597 30.5195 22.7787 26.088 30.6153C25.8662 31.0075 25.4505 31.25 24.9999 31.25H14.9999C14.5532 31.25 14.1404 31.0116 13.9172 30.6247C9.39505 22.7863 9.67197 16.2577 11.5789 11.3482C13.4559 6.51554 16.8584 3.38269 18.4291 2.12462ZM19.9999 4.06957L19.9995 4.06985C18.5976 5.19138 15.5639 7.99339 13.9093 12.2534C12.3285 16.3232 11.9543 21.8493 15.7311 28.75H24.2614C27.9583 21.8519 27.5794 16.3271 26.013 12.2555C24.3769 8.00285 21.391 5.20304 19.9999 4.06957Z"
                                                fill="white" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M12.3483 16.4468C12.8782 16.8894 12.9491 17.6776 12.5065 18.2075L7.61056 24.0702C7.61086 24.0716 7.61116 24.0729 7.61145 24.0742L9.53246 32.7735L14.2194 29.0239C14.7584 28.5927 15.5451 28.6801 15.9763 29.2192C16.4076 29.7582 16.3202 30.5449 15.7811 30.9761L11.0936 34.7261C10.7623 34.9908 10.3686 35.1673 9.95057 35.2383C9.53252 35.3092 9.10331 35.2726 8.7033 35.132C8.30329 34.9913 7.94562 34.7513 7.66392 34.4344C7.38222 34.1174 7.18576 33.7341 7.09301 33.3203L7.09214 33.3164L5.17349 24.6279C5.08344 24.2562 5.08212 23.8683 5.16978 23.4958C5.25834 23.1194 5.43518 22.7695 5.68564 22.475L10.5877 16.605C11.0302 16.0752 11.8185 16.0043 12.3483 16.4468Z"
                                                fill="white" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M27.5592 16.321C28.0895 15.879 28.8777 15.9507 29.3197 16.4811L34.3151 22.4756C34.5653 22.77 34.742 23.1197 34.8305 23.4958C34.9182 23.8683 34.9168 24.2562 34.8268 24.6279L32.9081 33.3164L32.9073 33.3203C32.8145 33.7341 32.6181 34.1174 32.3364 34.4344C32.0547 34.7513 31.697 34.9913 31.297 35.132C30.897 35.2726 30.4678 35.3092 30.0497 35.2383C29.6317 35.1673 29.2385 34.9913 28.9073 34.7266L24.2192 30.9761C23.6801 30.5449 23.5927 29.7582 24.024 29.2192C24.4552 28.6801 25.2418 28.5927 25.7809 29.0239L30.4678 32.7735L32.3888 24.0742C32.3891 24.0729 32.3894 24.0716 32.3897 24.0702L27.3991 18.0815C26.9572 17.5512 27.0288 16.763 27.5592 16.321Z"
                                                fill="white" />
                                            <path
                                                d="M20 16.875C21.0355 16.875 21.875 16.0355 21.875 15C21.875 13.9645 21.0355 13.125 20 13.125C18.9645 13.125 18.125 13.9645 18.125 15C18.125 16.0355 18.9645 16.875 20 16.875Z"
                                                fill="white" />
                                        </svg>Actividades Complementarias  <button type="button" onclick="openModalSugerencia('Actividad complementaria')" class="btn btn-primary sugerencia">Crear sugerencia</button></h2>
                                        
                                   
                                    <div class="content">
                                        <!-- Slider main container -->
                                        <div class="swiper swiper-actividades_complementarias">
                                        <!-- Additional required wrapper -->
                                        <div class="swiper-wrapper">
                                            <!-- Slides -->
                                            <?php
                                                for ($j=0; $j < count($actividad->actividades_complementarias); $j++) { 
                                                    $actividad_complementaria = $actividad->actividades_complementarias[$j];
                                            ?>
                                            <div class="swiper-slide"><p><?=$actividad_complementaria->post_title?></p></div>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        <!-- If we need navigation buttons -->
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div>
                                        </div>
                                    </div>
                                    
                                </article>
                            <?php } ?>
                        </div>
                        <?php }} ?>
                    </div>
                </div>
            </div>
           
        </section>
        <section class="tab <?=isset($_GET['tabactive']) && $_GET['tabactive'] == $sdk->get_alias('Contexto') ? 'tab-active' : ''?> " id="<?=$sdk->get_alias("Contexto")?>">
            <div class="TabsMainSection">
                <div class="TabsMainRow">
                    <div class="TabsMainColLeft">
                        <div class="TabList">
                            <ul>
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    $actividad = $acomp->contexto->{"actividad_$i"}; 
                                    if($actividad->titulo != ""){
                                ?>
                                <li data-name="Tab<?=$i?>"><button class="medium"><?=$actividad->titulo?> </button></li>
                                <?php }} ?>
                            </ul>
                        </div>
                    </div>
                    <div class="TabsMainColRight">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            $actividad = $acomp->contexto->{"actividad_$i"}; 
                            if($actividad->titulo != ""){
                        ?>
                        <div class="Tab<?=$i?> TabContent">
                            <article>
                                <div class="content">
                                    <?=$actividad->descripcion?>
                                </div>
                            </article>
                            <article>
                                <img src="<?=$actividad->imagen?>" alt="<?=$actividad->titulo?>">
                                <div class="content">
                                    <?=$actividad->descripcion_imagen_o_video?>
                                </div>
                            </article>
                            <article class="full actividadescomp">
                                <h2><svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M16.25 35C16.25 34.3096 16.8096 33.75 17.5 33.75H22.5C23.1904 33.75 23.75 34.3096 23.75 35C23.75 35.6904 23.1904 36.25 22.5 36.25H17.5C16.8096 36.25 16.25 35.6904 16.25 35Z"
                                            fill="white" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M18.4291 2.12462C18.8712 1.76 19.4265 1.56042 19.9999 1.56042C20.5753 1.56042 21.1325 1.76139 21.5753 2.12844C23.1274 3.39244 26.4874 6.52604 28.3463 11.3578C30.2321 16.2597 30.5195 22.7787 26.088 30.6153C25.8662 31.0075 25.4505 31.25 24.9999 31.25H14.9999C14.5532 31.25 14.1404 31.0116 13.9172 30.6247C9.39505 22.7863 9.67197 16.2577 11.5789 11.3482C13.4559 6.51554 16.8584 3.38269 18.4291 2.12462ZM19.9999 4.06957L19.9995 4.06985C18.5976 5.19138 15.5639 7.99339 13.9093 12.2534C12.3285 16.3232 11.9543 21.8493 15.7311 28.75H24.2614C27.9583 21.8519 27.5794 16.3271 26.013 12.2555C24.3769 8.00285 21.391 5.20304 19.9999 4.06957Z"
                                            fill="white" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M12.3483 16.4468C12.8782 16.8894 12.9491 17.6776 12.5065 18.2075L7.61056 24.0702C7.61086 24.0716 7.61116 24.0729 7.61145 24.0742L9.53246 32.7735L14.2194 29.0239C14.7584 28.5927 15.5451 28.6801 15.9763 29.2192C16.4076 29.7582 16.3202 30.5449 15.7811 30.9761L11.0936 34.7261C10.7623 34.9908 10.3686 35.1673 9.95057 35.2383C9.53252 35.3092 9.10331 35.2726 8.7033 35.132C8.30329 34.9913 7.94562 34.7513 7.66392 34.4344C7.38222 34.1174 7.18576 33.7341 7.09301 33.3203L7.09214 33.3164L5.17349 24.6279C5.08344 24.2562 5.08212 23.8683 5.16978 23.4958C5.25834 23.1194 5.43518 22.7695 5.68564 22.475L10.5877 16.605C11.0302 16.0752 11.8185 16.0043 12.3483 16.4468Z"
                                            fill="white" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M27.5592 16.321C28.0895 15.879 28.8777 15.9507 29.3197 16.4811L34.3151 22.4756C34.5653 22.77 34.742 23.1197 34.8305 23.4958C34.9182 23.8683 34.9168 24.2562 34.8268 24.6279L32.9081 33.3164L32.9073 33.3203C32.8145 33.7341 32.6181 34.1174 32.3364 34.4344C32.0547 34.7513 31.697 34.9913 31.297 35.132C30.897 35.2726 30.4678 35.3092 30.0497 35.2383C29.6317 35.1673 29.2385 34.9913 28.9073 34.7266L24.2192 30.9761C23.6801 30.5449 23.5927 29.7582 24.024 29.2192C24.4552 28.6801 25.2418 28.5927 25.7809 29.0239L30.4678 32.7735L32.3888 24.0742C32.3891 24.0729 32.3894 24.0716 32.3897 24.0702L27.3991 18.0815C26.9572 17.5512 27.0288 16.763 27.5592 16.321Z"
                                            fill="white" />
                                        <path
                                            d="M20 16.875C21.0355 16.875 21.875 16.0355 21.875 15C21.875 13.9645 21.0355 13.125 20 13.125C18.9645 13.125 18.125 13.9645 18.125 15C18.125 16.0355 18.9645 16.875 20 16.875Z"
                                            fill="white" />
                                    </svg>Actividades Complementarias   <button type="button" onclick="openModalSugerencia('Actividad complementaria')" class="btn btn-primary sugerencia">Crear sugerencia</button></h2>
                               
                                <div class="content">
                                      <!-- Slider main container -->
                                      <div class="swiper swiper-actividades_complementarias">
                                    <!-- Additional required wrapper -->
                                    <div class="swiper-wrapper">
                                        <!-- Slides -->
                                        <?php
                                            for ($j=0; $j < count($actividad->actividades_complementarias); $j++) { 
                                                $actividad_complementaria = $actividad->actividades_complementarias[$j];
                                        ?>
                                        <div class="swiper-slide"><p><?=$actividad_complementaria->post_title?></p></div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <!-- If we need navigation buttons -->
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <?php }} ?>
                    </div>
                </div>
            </div>
          
        </section>
        <section class="tab <?=isset($_GET['tabactive']) && $_GET['tabactive'] == $sdk->get_alias('Cultura y sociedad') ? 'tab-active' : ''?>" id="<?=$sdk->get_alias("Cultura y sociedad")?>">
        <?php
            function getAndShowTool($tool) {
                // HTML de la herramienta según el tipo de herramienta
                $toolItemHtml = "";
                $toolHtml = "";
                if ($tool->tipo_de_herramienta) {
                    switch ($tool->tipo_de_herramienta) {
                        case "17":
                            $toolHtml = '<a href="'.$tool->enlace.'" target="_BLANK" class="t_video" title="Video">Video</a>';
                            break;
                        case "18":
                            $toolHtml = '<a href="'.$tool->enlace.'" target="_BLANK" class="t_imagen" title="Fotografía">Imagen</a>';
                            break;
                        case "19":
                            $toolHtml = '<a href="'.$tool->enlace.'" target="_BLANK" class="t_cartilla" title="Cartilla">Cartilla</a>';
                            break;
                        case "110":
                            $toolHtml = '<a href="'.$tool->enlace.'" target="_BLANK" class="t_multi" title="Multimedia">Multimedia</a>';
                            break;
                        case "111":
                            $toolHtml = '<a href="'.$tool->enlace.'" target="_BLANK" class="t_audio" title="Audio">Audio</a>';
                            break;
                        case "21400":
                            $toolHtml = '<a href="'.$tool->enlace.'" target="_BLANK" class="t_estadistica" title="Infografía">Infografía</a>';
                            break;
                    }
                    // Generar el HTML completo de la herramienta
                    $toolItemHtml = '<li>' . $toolHtml . '</li>';
                }
                return $toolItemHtml; // Devolver el HTML en lugar de hacer echo
            }

            // Asegúrate de inicializar la variable $containerList
            $containerList = '';

            foreach ($culturaSociedad as $cs) {
                // Verifica que las propiedades existan antes de usarlas
                $backgroundImg = !empty($cs->acf->backgroundimgcs) ? $cs->acf->backgroundimgcs : "https://files.cinescuela.org/2024/03/cultura-sociedad-temporal.jpg";
                $figureHtml = '<img loading="lazy" class="lazyload" src="https://placehold.co/230x297/037A19/FFFFFF" data-src="' . $backgroundImg . '" alt="' . htmlspecialchars($cs->title->rendered) . '" />';

                $containerList .= '<li>';
                $containerList .= '<span class="i_list">' . htmlspecialchars($cs->title->rendered) . '</span>' . $figureHtml;

                // Solo añadir el <ul> si hay elementos en related_tools
                if (!empty($cs->related_tools) && is_array($cs->related_tools)) {
                    $containerList .= "<ul class='tipo'>";
                    foreach ($cs->related_tools as $tool) {
                        // Asegúrate de que la función getAndShowTool() existe
                        if (function_exists('getAndShowTool')) {
                            $containerList .= getAndShowTool($tool); // Concatenar el resultado de la función
                        }
                    }
                    $containerList .= "</ul>";
                }

                $containerList .= '</li>';
            }

            echo '<ul class="cards">' . $containerList . '</ul>';
            ?>
   <button type="button" onclick="openModalSugerencia('Recurso de cultura y sociedad')" class="btn btn-primary sugerencia">Crear sugerencia</button>
        </section>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
<script>
    document.querySelector("body").style.backgroundImage = `url(<?=$acomp->presentaciones->imagen_de_fondo?>)`;
    document.addEventListener('DOMContentLoaded', function () {
        var detailsElements = document.querySelectorAll('details');

        detailsElements.forEach(function (details) {
            details.addEventListener('click', function () {
                // Close other open details
                detailsElements.forEach(function (otherDetails) {
                    if (otherDetails !== details && otherDetails.hasAttribute('open')) {
                        otherDetails.removeAttribute('open');
                    }
                });
            });
        });
    });
    // Check if there are elements with class "TabsMainSection"
    var tabsMainSections = document.querySelectorAll(".TabsMainSection");
    if (tabsMainSections.length > 0) {
        tabsMainSections.forEach(function (tabsMainSection) {
            // Add "current" class to the first li element in each TabsMainSection
            tabsMainSection.querySelector(".TabList li:first-child").classList.add("current");
            // Add "active" class to the first TabContent element in each TabsMainSection
            tabsMainSection.querySelector(".TabContent:first-child").classList.add("active");
            // Add click event listener to all li elements in each TabsMainSection
            tabsMainSection.querySelectorAll(".TabList li").forEach(function (tabListItem) {
                tabListItem.addEventListener("click", function (e) {
                    e.preventDefault();
                    var currLink = this;
                    // Add "current" class to the clicked li element and remove it from its siblings
                    this.classList.add("current");
                    Array.from(this.parentNode.children).forEach(function (sibling) {
                        if (sibling !== currLink) {
                            sibling.classList.remove("current");
                        }
                    });
                    var navi = this.getAttribute("data-name");
                    // Remove "active" class from all TabContent elements in the same TabsMainSection
                    tabsMainSection.querySelectorAll(".TabContent").forEach(function (tabContent) {
                        tabContent.classList.remove("active");
                    });
                    // Add "active" class to the TabContent element with the corresponding data-name attribute
                    tabsMainSection.querySelector("." + navi).classList.add("active");
                });
            });
        });
    }

</script>