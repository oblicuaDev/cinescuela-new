<?php 
    $bodyClass = "terminos";
    include 'includes/head.php';
    include 'includes/header.php';
    $politics = $sdk->query('pages/10188');
    $politics = $politics['response'];
?>
<main>
    <h1><?=$politics->title->rendered?></h1>
    <?=$politics->content->rendered?>

</main>
<?php include 'includes/footer.php'; ?>