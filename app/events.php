<?php 
    $bodyClass = "events";
    include 'includes/head.php';
    include 'includes/header.php';
    $event = $sdk->query('cinescuela-events', $_GET['id']);
    $event = $event['response'];
?>
<main>
</main>
<?php include 'includes/footer.php'; ?>