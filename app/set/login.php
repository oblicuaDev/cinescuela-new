<?php
    @session_start();
    include ("../includes/config.php");
	$passuser = md5(filter_input(INPUT_POST, 'password'));	
	$nameuser = filter_input(INPUT_POST, 'username');
	$user = $sdk->loginCinescuelaUser($nameuser);
	foreach ($user as $single_user) {
        if (isset($single_user->title->rendered) && $single_user->title->rendered === $nameuser) {
			$user = $single_user;
            break;
        }
    }
    if(empty($user)){
        echo json_encode('0');
    }else{
        if($user->acf->usuario_activo == '1'){
            $userInfo = $sdk->getInfoUser($user->id);
            $userInfo = $userInfo->related_cinescuela_profiles;
            $ipVerified = true;
            
            if (isset($user->acf->ips) && $user->acf->ips !== '') {
                $ips = explode(',', $user->acf->ips);
                $theIp = '-'.getRealIP().'-';
                $ipVerified = in_array($theIp, $ips);
            }
            if($user->acf->contrasena_antigua == "" && isset($user->acf->contrasena) || $user->acf->contrasena_antigua != "" && isset($user->acf->contrasena) ){
                // URL de la API REST en tu sitio de WordPress
                $request_url = 'https://webadmin.cinescuela.org/wp-json/cinescuela/v1/validate-password/';

                // Datos para enviar en la solicitud POST
                $post_data = array(
                    'user_id' => $user->id,
                    'password' => filter_input(INPUT_POST, 'password'),
                );


                // Inicializar cURL
                $ch = curl_init($request_url);

                // Configurar la solicitud POST
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                // Ejecutar la solicitud
                $response = curl_exec($ch);

                // Verificar si hubo errores
                if ($response === false) {
                    echo "Error en la solicitud: " . curl_error($ch);
                } else {
                    // Decodificar la respuesta JSON
                    $data = json_decode($response);
                    // Verificar el resultado de la validación
                    if ($data->success) {
                        if($ipVerified){
                            $_SESSION['logged']['cod_us'] = $user->id;
                          
                            $_SESSION['logged']['usu_us'] = $user->acf->primer_nombre;
                            $_SESSION['logged']['pro_us'] = $user->acf->perfil_de_usuario;
                            $_SESSION['logged']['perfil_de_usuario'] = $userInfo;
                            $_SESSION['logged']['region_us'] = $user->acf->region;
                            $_SESSION['logged']['mail_us'] = $user->acf->correo_electronico;
                            echo json_encode($user->acf->primer_nombre);
                        }else{
                            echo json_encode('0');
                        }
                    } else {
                        echo json_encode('0');
                    }
                }
                // Cerrar la sesión cURL
                curl_close($ch);

            }else{
                if($user->acf->contrasena_antigua == $passuser && $ipVerified){
                    $_SESSION['logged']['cod_us'] = $user->id;
                    $_SESSION['logged']['usu_us'] = $user->acf->primer_nombre;
                    $_SESSION['logged']['pro_us'] = $user->acf->perfil_de_usuario;
                    $_SESSION['logged']['region_us'] = $user->acf->region;
                    $_SESSION['logged']['perfil_de_usuario'] = $user->related_cinescuela_profiles;
                    $_SESSION['logged']['mail_us'] = $user->acf->correo_electronico;
                    echo json_encode($user->acf->primer_nombre);
                }else{
                    echo json_encode('0');
                }
            }
        }else{
            if($user->acf->contrasena_antigua == $passuser){
                echo json_encode('2');
            }else{
                echo json_encode('0');
            }
        }
    }
?>