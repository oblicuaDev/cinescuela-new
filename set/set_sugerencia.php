<?php 
include '../includes/config.php';
extract($_POST);
$emailSended = $sdk->campaignMonitorEmail("cinescuela@mediodecontencion.com","", "2f74deea-f45c-43f1-bb09-03a05e85e3c3","{
\"user\":\"$user\",
\"type\":\"$type\",
\"content\":\"$content\",
\"movie\":\"$movie\",
}");
echo json_encode($emailSended);
