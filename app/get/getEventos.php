<?php
    include '../includes/config.php';
	$events = $sdk->query("cinescuela-events");
	echo json_encode($events);