<!-- Elemento oculto para precargar las imágenes -->
<div class="image-preloader">
    <img loading="lazy" class="lazyload" src="images/lines/line1.webp" alt="">
    <img loading="lazy" class="lazyload" src="images/lines/line2.webp" alt="">
    <img loading="lazy" class="lazyload" src="images/lines/line3.webp" alt="">
    <img loading="lazy" class="lazyload" src="images/lines/line4.webp" alt="">
    <img loading="lazy" class="lazyload" src="images/lines/line5.webp" alt="">
    <img loading="lazy" class="lazyload" src="images/lines/line6.webp" alt="">
</div>
<div class="preloader">
    <div class="center">
        <img src="images/logo.png" alt="logo">
        <h2>Sácale el jugo al cine</h2>
    </div>
    <div class="line1 line" style="background-image: url(images/lines/line1.webp);background-repeat: repeat-x;">
    </div>
    <div class="line2 line" style="background-image: url(images/lines/line2.webp);background-repeat: repeat-x;">
    </div>
    <div class="line3 line" style="background-image: url(images/lines/line3.webp);background-repeat: repeat-x;">
    </div>
    <div class="line4 line" style="background-image: url(images/lines/line4.webp);background-repeat: repeat-x;">
    </div>
    <div class="line5 line" style="background-image: url(images/lines/line5.webp);background-repeat: repeat-x;">
    </div>
    <div class="line6 line" style="background-image: url(images/lines/line6.webp);background-repeat: repeat-x;">
    </div>
</div>

<footer>
    <div class="container">
        <div class="logos">
            <a href="" class="logo">
                <img src="images/logo.png" alt="logo">
            </a>
            <img src="images/logos.png" alt="logos">
        </div>
        <div class="links">
            <a href="<?=$lang?>/peliculas">Nuestro catálogo</a>
            <a href="<?=$lang?>/ciclos">Ciclos</a>
            <a href="<?=$lang?>/acompanamientos-pedagogicos">Acompañamientos pedagógicos</a>
            <a href="<?=$lang?>/actualidad-educacion">Actualidad y Educación</a>
            <a href="<?=$lang?>/obtener-cinescuela">Obtén Cinescuela</a>
        </div>
        <div class="links">
            <a href="<?=$lang?>/obtener-cinescuela">Obtén Cinescuela</a>
            <a href="<?=$lang?>/terminos-condiciones">Términos y condiciones</a>
            <a href="app/">Iniciar Sesión</a>
            <a href="<?=$lang?>/contacto">Contacto</a>
        </div>
    </div>
    <div class="copy"><?=$sdk->generalInfo->acf->copyright?></div>
</footer>
<div id="dialog-content" style="max-width:1345px;display: none;">
    <div class="content">
        <div class="content-header">
            <div class="image">
                <img loading="lazy" class="lazyload" src="https://picsum.photos/20/20"
                    data-src="https://placehold.co/1345x545" alt="Logo Pelicula">
            </div>
            <img id="logoPeli" loading="lazy" class="lazyload" src="https://picsum.photos/20/20"
                data-src="https://placehold.co/430x145" alt="Logo Pelicula">
        </div>
        <div class="content-body">
            <div class="left">
                <div class="actions"></div>
                <p>En una región húmeda y calurosa de Colombia, transcurren los días de Emilio, un joven de 16 años,
                    que ante la desazón y falta de oportunidades no tiene más opción que entrar en el grupo
                    paramilitar de la zona. Una clase de autómatas, que sin ningún atisbo de sentimientos controlan
                    el entorno en el que ningún joven nacido en territorios en disputa pareciera poder escapar.</p>
                <div class="moreinfo">
                    <p class="director">Dirigido por Andres Jimenez Quintero</p>
                    <p class="country__date">Colombia 2021</p>
                    <p class="time">Duracion: 90min</p>
                </div>
                <ul class="tags">
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="js/utils.js"></script>
<script src="js/videoCustom.js"></script>
<script src="js/swipers.js"></script>
<script src="js/notifications.js"></script>
<script src="js/dropdowns.js"></script>
<script src="js/validator.js"></script>
<script src="js/main.js"></script>

</body>

</html>