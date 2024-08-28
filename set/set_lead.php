<?php 
include '../includes/config.php';
extract($_POST);
$data = '{
    "title": "'.$name.'",
    "status": "publish",
    "fields": {
        "nombre_institucion": "'.$institucion.'",
        "correo_electronico": "'.$email.'",
        "ciudad": "'.$city.'"
    }
}';
$emailSended = $sdk->campaignMonitorEmail("dreinovcorp@gmail.com","", "29b9175b-b8c9-4f62-9d58-d541304c615e", "{\"name\":\"$name\",\"institucion\":\"$institucion\",\"email\":\"$email\",\"city\":\"$city\"}");
$emailSended2 = $sdk->campaignMonitorEmail($email,"", "3c93f9af-6b5e-4f99-bc06-e8e29b523275", "{}");
$price = $sdk->setLead($data);
echo json_encode($price);
