<?php 
    $bodyClass = "movies-favorites";
    include 'includes/head.php';
    include 'includes/header.php';
?>
<main>
    <div class="container">
        <h2>Mi lista de favoritos</h2>
        <p class="emptyList">Tu lista de favoritos está vacía. ¡Empieza a explorar contenido y agrega tus títulos preferidos!</p>
    </div>
    <ul class="movies-list movies-list-favorites container " id="movie-container-favorites"></ul>
</main>
<?php include 'includes/footer.php'; ?>