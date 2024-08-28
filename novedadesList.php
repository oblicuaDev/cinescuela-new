
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
        <?php 
            for ($i=0; $i < count($novedadesList); $i++) { 
                $noticia =  $novedadesList[$i]; 
                $nameCat = array_map(function($category) {
                    return $category->name;
                }, $noticia->categories_full);
                
                $idCat = array_map(function($category) {
                    return $category->id;
                }, $noticia->categories_full);
                
                $icon = '';
                if (!in_array(10, $idCat)) {
                    $icon = '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 3.125C6.20304 3.125 3.125 6.20304 3.125 10C3.125 13.797 6.20304 16.875 10 16.875C13.797 16.875 16.875 13.797 16.875 10C16.875 6.20304 13.797 3.125 10 3.125ZM1.875 10C1.875 5.51269 5.51269 1.875 10 1.875C14.4873 1.875 18.125 5.51269 18.125 10C18.125 14.4873 14.4873 18.125 10 18.125C5.51269 18.125 1.875 14.4873 1.875 10Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M2.30469 7.5C2.30469 7.15482 2.58451 6.875 2.92969 6.875H17.0703C17.4155 6.875 17.6953 7.15482 17.6953 7.5C17.6953 7.84518 17.4155 8.125 17.0703 8.125H2.92969C2.58451 8.125 2.30469 7.84518 2.30469 7.5Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M2.30469 12.5C2.30469 12.1548 2.58451 11.875 2.92969 11.875H17.0703C17.4155 11.875 17.6953 12.1548 17.6953 12.5C17.6953 12.8452 17.4155 13.125 17.0703 13.125H2.92969C2.58451 13.125 2.30469 12.8452 2.30469 12.5Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M8.36482 5.08638C7.83991 6.31204 7.5 8.04884 7.5 10C7.5 11.9512 7.83991 13.688 8.36482 14.9136C8.62775 15.5276 8.92479 15.9845 9.22279 16.2788C9.51811 16.5704 9.78004 16.6719 10 16.6719C10.22 16.6719 10.4819 16.5704 10.7772 16.2788C11.0752 15.9845 11.3722 15.5276 11.6352 14.9136C12.1601 13.688 12.5 11.9512 12.5 10C12.5 8.04884 12.1601 6.31204 11.6352 5.08638C11.3722 4.47243 11.0752 4.01555 10.7772 3.72123C10.4819 3.42957 10.22 3.32812 10 3.32812C9.78004 3.32812 9.51811 3.42957 9.22279 3.72123C8.92479 4.01555 8.62775 4.47243 8.36482 5.08638ZM8.34443 2.83186C8.79684 2.38505 9.35702 2.07812 10 2.07812C10.643 2.07812 11.2032 2.38505 11.6556 2.83186C12.1053 3.27604 12.4817 3.88775 12.7842 4.59428C13.3904 6.00957 13.75 7.92121 13.75 10C13.75 12.0788 13.3904 13.9904 12.7842 15.4057C12.4817 16.1122 12.1053 16.724 11.6556 17.1681C11.2032 17.615 10.643 17.9219 10 17.9219C9.35702 17.9219 8.79684 17.615 8.34443 17.1681C7.89469 16.724 7.51834 16.1122 7.21576 15.4057C6.60964 13.9904 6.25 12.0788 6.25 10C6.25 7.92121 6.60964 6.00957 7.21576 4.59428C7.51834 3.88775 7.89469 3.27604 8.34443 2.83186Z" fill="white"/></svg>';
                } else {
                    $icon = '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M16.25 14.375C16.5952 14.375 16.875 14.0952 16.875 13.75V5C16.875 4.65482 16.5952 4.375 16.25 4.375L3.75 4.375C3.40482 4.375 3.125 4.65482 3.125 5L3.125 13.75C3.125 14.0952 3.40482 14.375 3.75 14.375L16.25 14.375ZM18.125 13.75C18.125 14.7855 17.2855 15.625 16.25 15.625L3.75 15.625C2.71447 15.625 1.875 14.7855 1.875 13.75V5C1.875 3.96447 2.71447 3.125 3.75 3.125L16.25 3.125C17.2855 3.125 18.125 3.96447 18.125 5V13.75Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M6.875 17.5C6.875 17.1548 7.15482 16.875 7.5 16.875H12.5C12.8452 16.875 13.125 17.1548 13.125 17.5C13.125 17.8452 12.8452 18.125 12.5 18.125H7.5C7.15482 18.125 6.875 17.8452 6.875 17.5Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1.875 11.875C1.875 11.5298 2.15482 11.25 2.5 11.25H17.5C17.8452 11.25 18.125 11.5298 18.125 11.875C18.125 12.2202 17.8452 12.5 17.5 12.5H2.5C2.15482 12.5 1.875 12.2202 1.875 11.875Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M10 14.375C10.3452 14.375 10.625 14.6548 10.625 15V17.5C10.625 17.8452 10.3452 18.125 10 18.125C9.65482 18.125 9.375 17.8452 9.375 17.5V15C9.375 14.6548 9.65482 14.375 10 14.375Z" fill="white"/></svg>';
                }
        ?>
            <a href="es/informacion/<?=$sdk->get_alias($noticia->title->rendered)?>-<?=$noticia->id?>">
            <div class="image">
            <img data-src="<?=$noticia->acf->imagen?>" loading="lazy" class="lazyload" src="<?=$noticia->acf->imagen?>">
            <div class="badge">
                <?=$icon?>
            <span><?=$nameCat[0]?></span>
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