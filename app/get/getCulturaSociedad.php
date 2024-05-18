<?php
    include '../includes/config.php';
	$cs = $sdk->getCS($_GET['id']);
	echo json_encode($cs);