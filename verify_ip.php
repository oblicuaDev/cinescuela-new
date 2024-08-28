<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token,Access-Control-Allow-Origin');
extract($_GET);
include 'includes/sdk.php';
$cinescuela =new Cinescuela();
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$user = $cinescuela->verifyIp($_GET['ip']);

	if ($user === false && $user == NULL) {
		echo '{"message":0, "ip":"'.$cinescuela->getRealIP().'","url":"'.$actual_link.'"}';
	}else{
		session_start();
		$_SESSION['logged']['cod_us'] = $user->id;
		$_SESSION['logged']['usu_us'] = $user->acf->primer_nombre;
		$_SESSION['logged']['pro_us'] = $user->acf->perfil_de_usuario;
		$_SESSION['logged']['region_us'] = $user->acf->region;
		$_SESSION['logged']['mail_us'] = $user->acf->correo_electronico;
		$_SESSION['loggedByIp'] = 1;
		
		echo '{"message":1, "ID":"'.$user->id.'","name":"'.$user->acf->primer_nombre.'", "ip":"'.$cinescuela->getRealIP().'","url":"'.$actual_link.'", "time":"'.time().'"}';
	}