<?php 
    $bodyClass = "intern";
    include 'includes/head.php';
    include 'includes/header.php';
    $movie = $sdk->getPeliculas($_GET['id']);

?>

    <div class="videos">
        <div class="overlayMovie">
            <?php if($movie->acf->logo_de_la_pelicula && $movie->acf->logo_de_la_pelicula != ""){ ?>
                <img src="<?=$movie->acf->logo_de_la_pelicula?>" alt="Logo Pelicula">
            <?php }else{ ?>
                <span class="title-movie"><?=$movie->title->rendered?></span>
            <?php } ?>
            <div class="sinopsis">
                <h2>Sinópsis</h2>
                <?=$movie->content->rendered?>
            </div>
        </div>
        <a href="<?=$lang?>/inicio" class="backArrow"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve"><path fill="#FFFFFF" d="M31.678,18.698h-19.94l5.103-6.059c0.533-0.634,0.452-1.58-0.182-2.114 c-0.633-0.533-1.579-0.451-2.113,0.181l-7.213,8.565c-0.48,0.57-0.469,1.407,0.028,1.964l7.213,8.09 c0.296,0.333,0.707,0.502,1.12,0.502c0.354,0,0.711-0.125,0.997-0.381c0.618-0.551,0.673-1.499,0.121-2.117l-5.021-5.632h19.887 c0.828,0,1.5-0.672,1.5-1.5S32.506,18.698,31.678,18.698z"/></svg></a>
        <div class="userName"><?=$_SESSION['logged']['usu_us']?></div>
        <div class="video-container">
            <video id="videoEl"
                src="<?=$movie->acf->link_pelicula?>"
                class="video" onclick="togglePlay();" onloadedmetadata="updateTimeElapsed()"
                onloadeddata="initializeVideo(); updateTimeElapsed()" onmouseenter="showControls()" onmouseleave="hideControls()"
                onpause="updatePlayButton()" onplay="updatePlayButton()"
                ontimeupdate="updateProgress(); set_time(); updateTimeElapsed()" onvolumechange="updateVolumeIcon()"
                onseeked="set_time()" onplaying="playingVideo()" onwaiting="waitingVideo()">
                <source
                    src="<?=$movie->acf->link_pelicula?>"
                    type="video/mp4">
            </video>
        </div>
        <div class="video-controls" id="video-controls" onmouseenter="showControls()" onmouseleave="hideControls()">
            <div class="mode">
                <div class="toggle-switch">
                    <input type="checkbox" class="theme-checkbox" onchange="toggleMode()">
                    <p>Modo pedagógico</p>
                </div>
            </div>
            <div class="top-controls">
                <div class="video-progress">
                    <div class="colorBuffer"></div>
                    <progress id="progress-bar" value="0" min="0"></progress>
                    <input class="seek" id="seek" value="0" min="0" type="range" step=".5"
                        onmousemove="updateSeekTooltip(event)" oninput="skipAhead(event)" />
                    <div class="seek-tooltip" id="seek-tooltip">00:00</div>
                </div>
                <div class="time">
                    <time id="time-elapsed">00:00</time>
                    <span> / </span>
                    <time id="duration">00:00</time>
                </div>
            </div>
            <div class="bottom-controls">
                <div class="left-controls">
                    <button data-title="Play (k)" id="playButton" onclick="togglePlay()">
                        <svg class="playback-icons">
                            <use href="#play-icon" ></use>
                            <use href="#pause" class="hidden"></use>
                        </svg>
                    </button>

                    <div class="volume-controls">
                        <button data-title="Mute (m)" class="volume-button" id="volumeButton" onclick="toggleMute()">
                            <svg>
                                <use class="hidden" id="volumemute" href="#volume-mute"></use>
                                <use class="hidden" id="volumelow" href="#volume-low"></use>
                                <use id="volumehigh" href="#volume-high"></use>
                            </svg>
                        </button>

                        <input class="volume" id="volume" #volume value="1" data-mute="0.5" type="range" max="1" min="0"
                            step="0.01" oninput="updateVolume()" />
                    </div>
                </div>

                <div class="right-controls">
                    <!-- <button data-title="Activar Totems" onclick="activeTotems()" id="active-totems">
                    <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
  <g clip-path="url(#clip0_26_8)">
    <path d="M17.23 34.33C16.66 34.33 16.12 34 15.87 33.46C14.96 31.5 13.7 29.17 13.08 28.41H1.5C0.67 28.41 0 27.74 0 26.91V1.5C0 0.67 0.67 0 1.5 0H32.93C33.76 0 34.43 0.67 34.43 1.5V26.5C34.43 27.33 33.76 28 32.93 28H21.7C20.34 30.06 18.94 32.36 18.72 33C18.65 33.63 18.18 34.15 17.55 34.29C17.44 34.31 17.33 34.33 17.23 34.33ZM3 25.41H13.54C14.18 25.41 15.08 25.41 17.23 29.44C17.8 28.49 18.58 27.26 19.65 25.66C19.93 25.25 20.39 25 20.89 25H31.43V3H3V25.41Z" fill="currentColor"/>
    <path d="M8.63999 16.22C9.93233 16.22 10.98 15.1723 10.98 13.88C10.98 12.5877 9.93233 11.54 8.63999 11.54C7.34764 11.54 6.29999 12.5877 6.29999 13.88C6.29999 15.1723 7.34764 16.22 8.63999 16.22Z" fill="currentColor"/>
    <path d="M17.31 16.22C18.6023 16.22 19.65 15.1723 19.65 13.88C19.65 12.5877 18.6023 11.54 17.31 11.54C16.0176 11.54 14.97 12.5877 14.97 13.88C14.97 15.1723 16.0176 16.22 17.31 16.22Z" fill="currentColor"/>
    <path d="M25.79 16.22C27.0824 16.22 28.13 15.1723 28.13 13.88C28.13 12.5877 27.0824 11.54 25.79 11.54C24.4977 11.54 23.45 12.5877 23.45 13.88C23.45 15.1723 24.4977 16.22 25.79 16.22Z" fill="currentColor"/>
  </g>
  <defs>
    <clipPath id="clip0_26_8">
      <rect width="34.43" height="34.33" fill="currentColor"/>
    </clipPath>
  </defs>
</svg>


                    </button> -->
                    <button data-title="Full screen (f)" class="fullscreen-button" id="fullscreenButton"
                        onclick="toggleFullScreen()">
                        <svg>
                            <use href="#fullscreen" class="hidden"></use>
                            <use href="#fullscreen-exit" ></use>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <main data-movieid="<?=$_GET['id']?>">
        <section class="movie-grid">
            <?php if($movie->acf->logo_de_la_pelicula && $movie->acf->logo_de_la_pelicula != ""){ ?>
                <img src="<?=$movie->acf->logo_de_la_pelicula?>" alt="Logo Pelicula">
            <?php } ?>
            <div class="col movie">
                <div class="toggle-switch">
                    <input type="checkbox" class="theme-checkbox" onchange="toggleMode()">
                    <p>Modo pedagógico</p>
                </div>
                <!-- <span class="age">13+</span> -->
                <a href="<?=$lang?>/acompanamiento-pedagogico/<?=$sdk->get_alias($movie->title->rendered)?>-<?=$movie->id?>" class="btn btn-primary" onClick="ga('send', 'event', 'Acompañamiento pedagógico', 'click','Película - <?=$movie->title->rendered?>')">Ver acompañamiento pedagógico completo</a>
            </div>
            <div class="col">
                <div class="sinopsis">
                    <h2>Sinópsis</h2>
                    <?=$movie->content->rendered?>
                </div>
                <?=$movie->acf->ficha_tecnica?>
                <ul class="tags">
                    <?php 
                    $tags = explode(',', $movie->acf->palabras_clave_de_esta_publicacion);
                    for ($i=0; $i < count($tags); $i++) { 
                        echo "<li>$tags[$i]</li>";
                    }
                    ?>
                </ul>
                <!-- <button type="button" onclick="openModalSugerencia('Keyword')" class="btn btn-primary sugerencia">Crear sugerencia</button> -->
                <div class="reconocimientos">
                    <h2>Reconocimientos</h2>
                    <ul>
                    </ul>
                </div>
            </div>
            <div class="col opinion">
                <h2>Nuestra opinión</h2>
                <?=$movie->acf->opinion?>
                <div class="notes"></div>
            </div>
            <div class="col sectionpedago"></div>
            <div class="col cultura">
                <h2>Cultura y Sociedad</h2>
                <ul class="cards">
                    <li class="skeleton"><img loading="lazy" class="lazyload" src="https://picsum.photos/20/20"
                            data-src="https://placehold.co/230x297" alt="Logo Pelicula"></li>
                    <li class="skeleton"><img loading="lazy" class="lazyload" src="https://picsum.photos/20/20"
                            data-src="https://placehold.co/230x297" alt="Logo Pelicula"></li>
                    <li class="skeleton"><img loading="lazy" class="lazyload" src="https://picsum.photos/20/20"
                            data-src="https://placehold.co/230x297" alt="Logo Pelicula"></li>
                </ul>
                <div class="actions">
                    <a href="<?=$lang?>/acompanamiento-pedagogico/<?=$sdk->get_alias($movie->title->rendered)?>-<?=$movie->id?>?tabactive=cultura-y-sociedad" class="btn btn-primary" onClick="ga('send', 'event', 'Acompañamiento pedagógico', 'click','Película - <?=$movie->title->rendered?>')">Ver sección completa</a>
                    <button type="button" onclick="openModalSugerencia('Recurso de cultura y sociedad')" class="btn btn-primary sugerencia">Crear sugerencia</button>
                </div>
            </div>
        </section>
    </main>
    <svg style="display: none">
        <defs>
            <symbol id="pause" viewBox="0 0 24 24">
                <path d="M14.016 5.016h3.984v13.969h-3.984v-13.969zM6 18.984v-13.969h3.984v13.969h-3.984z"></path>
            </symbol>

            <symbol id="play-icon" viewBox="0 0 24 24">
                <path d="M8.016 5.016l10.969 6.984-10.969 6.984v-13.969z"></path>
            </symbol>

            <symbol id="volume-high" viewBox="0 0 24 24">
                <path class="st0" d="M13.3,0.1C13,0,12.7,0,12.4,0.1L4.9,5c-0.8,0-2.6,0-3.8,1.1C0.4,6.8,0,7.7,0,8.8V11c0,0.3,0,1.6,1,2.7
            c0.8,0.8,1.9,1.2,3.4,1.2c0.1,0,0.3,0,0.4,0l7.5,5.6c0.2,0.1,0.3,0.2,0.5,0.2c0.1,0,0.3,0,0.4-0.1c0.3-0.2,0.5-0.5,0.5-0.8V0.9
            C13.8,0.6,13.6,0.3,13.3,0.1z M1.8,11.1C1.8,11.1,1.8,11.1,1.8,11.1l0-2.3c0-0.6,0.2-1,0.5-1.3c0.5-0.4,1.3-0.6,1.9-0.6V13
            c-0.8,0-1.5-0.2-1.9-0.6C1.8,11.9,1.8,11.1,1.8,11.1z M12,18l-5.9-4.4c0,0-0.1-0.1-0.1-0.1V6.5l6-3.9V18z" />
                <path class="st0" d="M18.6,4.9c-0.5,0-0.9,0.4-0.9,0.9s0.4,0.9,0.9,0.9c2,0,3.6,1.6,3.6,3.6s-1.6,3.6-3.6,3.6
            c-0.5,0-0.9,0.4-0.9,0.9c0,0.5,0.4,0.9,0.9,0.9c3,0,5.4-2.4,5.4-5.4S21.6,4.9,18.6,4.9z" />
                <path class="st0" d="M19.6,10.3c0-1.7-1.4-3.1-3.1-3.1c-0.5,0-0.9,0.4-0.9,0.9S16,9,16.5,9c0.7,0,1.3,0.6,1.3,1.3s-0.6,1.3-1.3,1.3
            c-0.5,0-0.9,0.4-0.9,0.9s0.4,0.9,0.9,0.9C18.2,13.4,19.6,12,19.6,10.3z" />
            </symbol>

            <symbol id="volume-low" viewBox="0 0 24 24">
                <path class="st0" d="M13.3,0.1C13,0,12.7,0,12.4,0.1L4.9,5c-0.8,0-2.6,0-3.8,1.1C0.4,6.8,0,7.7,0,8.8V11c0,0.3,0,1.6,1,2.7
            c0.8,0.8,1.9,1.2,3.4,1.2c0.1,0,0.3,0,0.4,0l7.5,5.6c0.2,0.1,0.3,0.2,0.5,0.2c0.1,0,0.3,0,0.4-0.1c0.3-0.2,0.5-0.5,0.5-0.8V0.9
            C13.8,0.6,13.6,0.3,13.3,0.1z M1.8,11.1C1.8,11.1,1.8,11.1,1.8,11.1l0-2.3c0-0.6,0.2-1,0.5-1.3c0.5-0.4,1.3-0.6,1.9-0.6V13
            c-0.8,0-1.5-0.2-1.9-0.6C1.8,11.9,1.8,11.1,1.8,11.1z M12,18l-5.9-4.4c0,0-0.1-0.1-0.1-0.1V6.5l6-3.9V18z" />
                <path class="st0" d="M16.5,7.2c-0.5,0-0.9,0.4-0.9,0.9S16,9,16.5,9c0.7,0,1.3,0.6,1.3,1.3s-0.6,1.3-1.3,1.3c-0.5,0-0.9,0.4-0.9,0.9
            s0.4,0.9,0.9,0.9c1.7,0,3.1-1.4,3.1-3.1S18.2,7.2,16.5,7.2z" />
            </symbol>

            <symbol id="volume-mute" viewBox="0 0 24 24">
                <path class="st0" d="M13.8,0.9c0-0.3-0.2-0.6-0.5-0.8C13,0,12.7,0,12.4,0.1l-6,3.9L2.7,0.3L1.1,1.8L4.3,5c-0.9,0-2.2,0.2-3.2,1.1
            C0.4,6.8,0,7.7,0,8.8V11c0,0.3,0,1.6,1,2.7c0.8,0.8,1.9,1.2,3.4,1.2c0.1,0,0.3,0,0.4,0l7.5,5.6c0.2,0.1,0.3,0.2,0.5,0.2
            c0.1,0,0.3,0,0.4-0.1c0.3-0.2,0.5-0.5,0.5-0.8v-5.2l6,6l1.6-1.6l-7.6-7.6V0.9z M12,2.6v7L7.7,5.3L12,2.6z M1.8,11.1
            C1.8,11.1,1.8,11.1,1.8,11.1l0-2.3c0-0.6,0.2-1,0.5-1.3c0.5-0.4,1.3-0.6,1.9-0.6V13c-0.8,0-1.5-0.2-1.9-0.6
            C1.8,11.9,1.8,11.1,1.8,11.1z M12,18l-5.9-4.4c0,0-0.1-0.1-0.1-0.1V6.7l6,6V18z" />
                <path class="st0" d="M18.6,4.9c-0.5,0-0.9,0.4-0.9,0.9s0.4,0.9,0.9,0.9c2,0,3.6,1.6,3.6,3.6s-1.6,3.6-3.6,3.6
            c-0.5,0-0.9,0.4-0.9,0.9c0,0.5,0.4,0.9,0.9,0.9c3,0,5.4-2.4,5.4-5.4S21.6,4.9,18.6,4.9z" />
                <path class="st0" d="M16.5,11.7c-0.5,0-0.9,0.4-0.9,0.9s0.4,0.9,0.9,0.9c1.7,0,3.1-1.4,3.1-3.1s-1.4-3.1-3.1-3.1
            c-0.5,0-0.9,0.4-0.9,0.9S16,9,16.5,9c0.7,0,1.3,0.6,1.3,1.3S17.2,11.7,16.5,11.7z" />
            </symbol>

            <symbol id="fullscreen-exit" viewBox="0 0 24 24">
                <path class="st0" d="M4.6,0H0.8C0.3,0,0,0.3,0,0.8v3.8C0,5,0.3,5.4,0.8,5.4S1.5,5,1.5,4.6V1.5h3.1c0.4,0,0.8-0.3,0.8-0.8
            C5.4,0.3,5,0,4.6,0z" />
                <path class="st0" d="M23.2,0h-4.3c-0.4,0-0.8,0.3-0.8,0.8c0,0.4,0.3,0.8,0.8,0.8h3.6v3.1c0,0.4,0.3,0.8,0.8,0.8S24,5,24,4.6V0.8
            C24,0.3,23.7,0,23.2,0z" />
                <path class="st0" d="M23.2,11c-0.4,0-0.8,0.3-0.8,0.8v2.6h-3.6c-0.4,0-0.8,0.3-0.8,0.8c0,0.4,0.3,0.8,0.8,0.8h4.3
            c0.4,0,0.8-0.3,0.8-0.8v-3.3C24,11.3,23.7,11,23.2,11z" />
                <path class="st0" d="M4.6,14.3H1.5v-2.6c0-0.4-0.3-0.8-0.8-0.8S0,11.3,0,11.7v3.3c0,0.4,0.3,0.8,0.8,0.8h3.8c0.4,0,0.8-0.3,0.8-0.8
            C5.4,14.6,5,14.3,4.6,14.3z" />
            </symbol>

            <symbol id="fullscreen" viewBox="0 0 24 24">
                <path class="st0" d="M4.6,0C4.2,0,3.8,0.3,3.8,0.8v3.1H0.8C0.3,3.8,0,4.2,0,4.6C0,5,0.3,5.4,0.8,5.4h3.8C5,5.4,5.4,5,5.4,4.6V0.8
            C5.4,0.3,5,0,4.6,0z" />
                <path class="st0" d="M18.9,5.4h4.3C23.7,5.4,24,5,24,4.6c0-0.4-0.3-0.8-0.8-0.8h-3.6V0.8c0-0.4-0.3-0.8-0.8-0.8s-0.8,0.3-0.8,0.8
            v3.8C18.1,5,18.5,5.4,18.9,5.4z" />
                <path class="st0" d="M23.2,11h-4.3c-0.4,0-0.8,0.3-0.8,0.8v3.3c0,0.4,0.3,0.8,0.8,0.8s0.8-0.3,0.8-0.8v-2.6h3.6
            c0.4,0,0.8-0.3,0.8-0.8C24,11.3,23.7,11,23.2,11z" />
                <path class="st0" d="M4.6,11H0.8C0.3,11,0,11.3,0,11.7c0,0.4,0.3,0.8,0.8,0.8h3.1v2.6c0,0.4,0.3,0.8,0.8,0.8s0.8-0.3,0.8-0.8v-3.3
            C5.4,11.3,5,11,4.6,11z" />
            </symbol>
        </defs>
    </svg>
<?php include 'includes/footer.php'; ?>