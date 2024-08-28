<?php 
include '../includes/config.php';
extract($_POST);
$emailSended = $sdk->campaignMonitorEmail("cinescuela@mediodecontencion.com","", "deb12964-dd15-4a39-aedc-285bf0b54229","{\"mail\":\"$mail\",\"content\":\"$content\"}");
echo json_encode($emailSended);
