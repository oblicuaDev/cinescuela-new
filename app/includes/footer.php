    <div class="thanks">
    <button type="button" onclick="fadeOut(document.querySelector('.thanks'))">&times;</button>
        <h2>¡Gracias por tus comentarios!</h2>
        <!-- <p>_________________________________</p> -->
        <button type="button" class="btn btn-primary" onclick="fadeOut(document.querySelector('.thanks'))">Continuar</button>
    </div>
   <!-- Modal del Tour -->
   <div id="buzonModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <div id="buzonModalContent">
            <h2>Buzón de sugerencias</h2>
            <form action="<?=$_GET['lang']?>/s/set_buzon/" id="buzon" method="POST">
                <span>
                    <label for="">Mensaje</label>
                    <textarea name="content" id="content"></textarea>
                    <span class="error-message"></span>
                </span>
                <input type="hidden" name="mail" id="mail" value="<?= $_SESSION['logged']['mail_us'] ?>">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
      </div>
    </div>
   <!-- Modal del Tour -->
   <!-- Modal del Tour -->
   <div id="wordsModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <div id="wordsModalContent">
            <h2>Sugerir contenido</h2>
            <form action="<?=$_GET['lang']?>/s/set_sugerencia/" id="sugerencia" method="POST">
                <span>
                    <label for="type">Tipo de sugerencia</label>
                    <select name="type" id="type">
                        <option value="Keyword">Keyword</option>
                        <option value="Actividad complementaria">Actividad complementaria</option>
                        <option value="Recurso de cultura y sociedad">Recurso de cultura y sociedad</option>
                    </select>
                    <span class="error-message"></span>
                </span>
                <span>
                    <label for="contentSug">Mensaje</label>
                    <textarea name="contentSug" id="contentSug"></textarea>
                    <span class="error-message"></span>
                </span>
                <input type="hidden" name="movie" id="movie" value="<?= $movie->title->rendered ?>">
                <input type="hidden" name="user" id="user" value="<?= $_SESSION['logged']['mail_us'] ?>">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
      </div>
    </div>
   <!-- Modal del Tour -->
   <div id="tourModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div id="tourContent">
          <!-- El contenido del tour se generará dinámicamente aquí -->
        </div>
      </div>
    </div>
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

    <footer></footer>
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
<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 1000;font-size: 18px;"></div>
<div class="bhrcredits" style="text-align:right; background:#393939; padding:10px 0; width:100%;grid-column: 1 / -1;"><div style="max-width: 1200px;margin: 0 auto;color: #FFF;font-size: 12px;display: flex;align-items: center;padding: 2px 20px;justify-content: flex-end;">Creado junto a <a href="https://www.web.oblicua.co/?ref=Cinescuela" style="color:#428bca;" target="_blank"><img src="https://oblicua.co/lab/credits/logo.svg" width="60" style="margin-left:10px;" alt="Sitio diseñado por Oblicua"></a></div></div>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../js/utils.js?v=<?=time()?>"></script>
    <script src="../js/videoCustom.js?v=<?=time()?>"></script>
    <script src="../js/swipers.js?v=<?=time()?>"></script>
    <script src="../js/notifications.js?v=<?=time()?>"></script>
    <script src="../js/dropdowns.js?v=<?=time()?>"></script>
    <script src="../js/validator.js?v=<?=time()?>"></script>
    <script src="js/main.js?v=<?=time()?>"></script>
</body>

</html>