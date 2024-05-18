<?php 
    $bodyClass = "intern";
    include 'includes/head.php';
    include 'includes/header.php';
    $movie = $sdk->getPeliculas($_GET['id']);

?>

    <div class="videos">
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
                    <p>Activar Modo pedagógico</p>
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
                            <use href="#play-icon"></use>
                            <use href="#pause" class="hidden"></use>
                        </svg>
                    </button>

                    <div class="volume-controls">
                        <button data-title="Mute (m)" class="volume-button" id="volume-button" onclick="toggleMute()">
                            <svg>
                                <use class="hidden" href="#volume-mute"></use>
                                <use class="hidden" href="#volume-low"></use>
                                <use href="#volume-high"></use>
                            </svg>
                        </button>

                        <input class="volume" id="volume" #volume value="1" data-mute="0.5" type="range" max="1" min="0"
                            step="0.01" oninput="updateVolume()" />
                    </div>
                </div>

                <div class="right-controls">
                    <button data-title="Full screen (f)" class="fullscreen-button" id="fullscreen-button"
                        onclick="toggleFullScreen()">
                        <svg>
                            <use href="#fullscreen"></use>
                            <use href="#fullscreen-exit" class="hidden"></use>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <main data-movieid="<?=$_GET['id']?>">
        <section class="movie-grid">
            <img src="<?=$movie->acf->logo_de_la_pelicula?>" alt="Logo Pelicula">
            <div class="col movie">
                <div class="toggle-switch">
                    <input type="checkbox" class="theme-checkbox" onchange="toggleMode()">
                    <p>Activar Modo pedagógico</p>
                </div>
                <!-- <span class="age">13+</span> -->
                <a href="<?=$lang?>/acompanamiento-pedagogico/<?=$sdk->get_alias($movie->title->rendered)?>-<?=$movie->id?>" class="btn btn-primary">Ver acompañamiento pedagógico completo</a>
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
                <a href="<?=$lang?>/acompanamiento-pedagogico/<?=$sdk->get_alias($movie->title->rendered)?>-<?=$movie->id?>?tabactive=cultura-y-sociedad" class="btn btn-primary">Ver sección completa</a>
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