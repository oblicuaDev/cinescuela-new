
<?php 
    $bodyClass = "novedadesPage";
    include 'includes/head.php';
    include 'includes/header.php';
    $novedades= $sdk->getAllNovedades();
    $novedadesList= $novedades['response'];
?>
<script>
    const totalPages = <?= $novedades['total_pages'] ?>; 
</script>
<main>
    <div class="novedades-list container">
        <?php for ($i=0; $i < count($novedadesList); $i++) { $noticia =  $novedadesList[$i]; ?>
            <a href="es/informacion/<?=$sdk->get_alias($noticia->title->rendered)?>-<?=$noticia->id?>">
            <div class="image">
            <img data-src="<?=$noticia->acf->imagen?>" loading="lazy" class="lazyload" src="<?=$noticia->acf->imagen?>">
            <div class="badge"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 3.125C6.20304 3.125 3.125 6.20304 3.125 10C3.125 13.797 6.20304 16.875 10 16.875C13.797 16.875 16.875 13.797 16.875 10C16.875 6.20304 13.797 3.125 10 3.125ZM1.875 10C1.875 5.51269 5.51269 1.875 10 1.875C14.4873 1.875 18.125 5.51269 18.125 10C18.125 14.4873 14.4873 18.125 10 18.125C5.51269 18.125 1.875 14.4873 1.875 10Z" fill="white"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M2.30469 7.5C2.30469 7.15482 2.58451 6.875 2.92969 6.875H17.0703C17.4155 6.875 17.6953 7.15482 17.6953 7.5C17.6953 7.84518 17.4155 8.125 17.0703 8.125H2.92969C2.58451 8.125 2.30469 7.84518 2.30469 7.5Z" fill="white"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M2.30469 12.5C2.30469 12.1548 2.58451 11.875 2.92969 11.875H17.0703C17.4155 11.875 17.6953 12.1548 17.6953 12.5C17.6953 12.8452 17.4155 13.125 17.0703 13.125H2.92969C2.58451 13.125 2.30469 12.8452 2.30469 12.5Z" fill="white"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M8.36482 5.08638C7.83991 6.31204 7.5 8.04884 7.5 10C7.5 11.9512 7.83991 13.688 8.36482 14.9136C8.62775 15.5276 8.92479 15.9845 9.22279 16.2788C9.51811 16.5704 9.78004 16.6719 10 16.6719C10.22 16.6719 10.4819 16.5704 10.7772 16.2788C11.0752 15.9845 11.3722 15.5276 11.6352 14.9136C12.1601 13.688 12.5 11.9512 12.5 10C12.5 8.04884 12.1601 6.31204 11.6352 5.08638C11.3722 4.47243 11.0752 4.01555 10.7772 3.72123C10.4819 3.42957 10.22 3.32812 10 3.32812C9.78004 3.32812 9.51811 3.42957 9.22279 3.72123C8.92479 4.01555 8.62775 4.47243 8.36482 5.08638ZM8.34443 2.83186C8.79684 2.38505 9.35702 2.07812 10 2.07812C10.643 2.07812 11.2032 2.38505 11.6556 2.83186C12.1053 3.27604 12.4817 3.88775 12.7842 4.59428C13.3904 6.00957 13.75 7.92121 13.75 10C13.75 12.0788 13.3904 13.9904 12.7842 15.4057C12.4817 16.1122 12.1053 16.724 11.6556 17.1681C11.2032 17.615 10.643 17.9219 10 17.9219C9.35702 17.9219 8.79684 17.615 8.34443 17.1681C7.89469 16.724 7.51834 16.1122 7.21576 15.4057C6.60964 13.9904 6.25 12.0788 6.25 10C6.25 7.92121 6.60964 6.00957 7.21576 4.59428C7.51834 3.88775 7.89469 3.27604 8.34443 2.83186Z" fill="white"></path></svg>
            <span>Actualidad</span>
            <span><?=$noticia->acf->fecha_de_publicacion?></span>
        </div>
            </div>
           <?=$noticia->title->rendered?>
            </a>
        <?php }?>
    </div>
    <div id="sentinel"></div>
</main>
<?php include 'includes/footer.php'; ?>