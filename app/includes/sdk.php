<?php 
class Cinescuela {
    public $domain = "https://webadmin.cinescuela.org/wp-json/wp/v2/";
    public $domainCustom = "https://webadmin.cinescuela.org/wp-json/custom/v1/";
    public $generalInfo = array();
    public $language = "es";
    public $production = true;

    function __construct($language = "es", $development = false){
        if ($development) {
            $this->production = false;
        }
        $this->language = $language;
        $this->generalInfo = $this->gHomeInfo();
    }
    public function customQuery($endpoint, $body = "", $method = "GET", $page = 1, $per_page = 50, $extra = [], $cache = true){
        // Ruta donde se va a guardar todos los archivos de CACHE
        $cacheAbsoluteRoute = "/home/customer/www/cinescuela.org/public_html/cache";
        $url = "{$this->domainCustom}{$endpoint}";
        $url = urldecode($url);
         // Realizar la solicitud HEAD para obtener solo los encabezados de respuesta
         $response_headers = get_headers($url, 1);
         // Verificar si la solicitud fue exitosa
         if ($response_headers !== false) {
             // Obtener el encabezado 'x-wp-total'
             $numPosts = $response_headers['x-wp-total'];
             $totalPages = $response_headers['x-wp-totalpages'];
         } else {
             // Manejar la situación en caso de error
             echo "Error al obtener los encabezados de respuesta.";
         }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        if ($cache) {
            $filetitle = $this->get_alias($url) . ".json";
            if (!file_exists($cacheAbsoluteRoute)) {
                mkdir($cacheAbsoluteRoute, 0777, true);
            }
            $path = $cacheAbsoluteRoute . "/" . $filetitle;

            if (file_exists($path)) {
                $data = file_get_contents($path);
                $ok = json_decode($data);
                return $ok;
            } else {
                $output = curl_exec($ch);
                $request = json_decode($output);
                $finalstructure = '{"endpoint":"' . $endpoint . '","lastUpdate":"' . date("Y-m-d") . '","response":' . json_encode($request) . '}';
                $bwriting = file_put_contents($path, $finalstructure);
                curl_close($ch);
                return $request;
            }
        } else {
            $output = curl_exec($ch);
            $request = json_decode($output);
            curl_close($ch);
            return $request;
        }
    }
    public function query($endpoint, $body = "", $method = "GET", $page = 1, $per_page = 50, $extra = [], $cache = true){
        // Initialize the query array
        $query = ['langcode' => $this->language];
        // Add 'order' if provided and not empty
        if (!empty($extra['order'])) {
            $query['order'] = $extra['order'];
        }
        // Add 'page' if provided and not empty
        if ($page !== "") {
            $query['page'] = $page;
        }
        // Add 'per_page' if provided and not empty
        if ($per_page !== "") {
            $query['per_page'] = $per_page;
        }
        // Ruta donde se va a guardar todos los archivos de CACHE
        $cacheAbsoluteRoute = "/home/customer/www/cinescuela.org/public_html/cache";
        // Validación de la variable $extra para colocar queryParams en el ENDPOINT
        if ($extra) {
            $query = array_merge($query, $extra);
        }
        $query_string = http_build_query($query);
        $url = "{$this->domain}{$endpoint}?{$query_string}";
        $url = urldecode($url);
        var_dump($url);
         // Realizar la solicitud HEAD para obtener solo los encabezados de respuesta
         $response_headers = get_headers($url, 1);
         // Verificar si la solicitud fue exitosa
         if ($response_headers !== false) {
             // Obtener el encabezado 'x-wp-total'
             $numPosts = $response_headers['x-wp-total'];
             $totalPages = $response_headers['x-wp-totalpages'];
         } else {
             // Manejar la situación en caso de error
             echo "Error al obtener los encabezados de respuesta.";
         }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        // Set request body for POST and PUT methods
        if ($method === "POST" || $method === "PUT") {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        if ($cache) {
            $filetitle = $this->get_alias($url) . ".json";
            if (!file_exists($cacheAbsoluteRoute)) {
                mkdir($cacheAbsoluteRoute, 0777, true);
            }
            $path = $cacheAbsoluteRoute . "/" . $filetitle;

            if (file_exists($path)) {
                $data = file_get_contents($path);
                $ok = json_decode($data);
                return ['response' => $ok->response->response, 'total_pages' => $ok->response->total_pages, 'total_posts' => $ok->response->total_posts];
            } else {
                $output = curl_exec($ch);
                $request = json_decode($output);
                $info = ['response' => $request, 'total_pages' => $totalPages, 'total_posts' => $numPosts];
                $finalstructure = '{"endpoint":"' . $endpoint . '","lastUpdate":"' . date("Y-m-d") . '","response":' . json_encode($info) . '}';
                $bwriting = file_put_contents($path, $finalstructure);
                curl_close($ch);
                return ['response' => $request, 'total_pages' => $totalPages, 'total_posts' => $numPosts];
            }
        } else {
            $output = curl_exec($ch);
            $request = json_decode($output);
            curl_close($ch);
            return ['response' => $request, 'total_pages' => $totalPages, 'total_posts' => $numPosts];
        }
    }
    function consultarRecursos($recurso, $ids = "", $body = "", $method = "GET", $page = 1, $per_page = 50, $extra = [], $cache = true) {
        
        // Variable para almacenar los resultados de la consulta
        $resultados = [];
        // Verificar si se proporcionaron IDs
        if ($ids !== "") {
            // Verificar si $ids es una cadena (un solo ID) o un arreglo (múltiples IDs)
            if (is_string($ids) || is_numeric($ids)) {
                // Si es una cadena (un solo ID), hacer la consulta para ese ID y almacenar el resultado
                $resultados =  $this->query($recurso."/".$ids, $body, $method, $page, $per_page, $extra, $cache);
                return $resultados["response"];
               
            } else {
                // Si es un arreglo (múltiples IDs), hacer una consulta por cada uno
                foreach ($ids as $id) {
                    // Perform your query
                    $resultados = $this->query($recurso."/".strval($id), $body, $method, $page, $per_page, $extra, $cache);
                    // Add the result to the array
                    $results[] = $resultados;
                }
                return $results;
            }
        } else {
            // Si no se proporcionan IDs, hacer una consulta general sin IDs y almacenar el resultado
            $resultados = $this->query($recurso, $body, $method, $page, $per_page, $extra, $cache);
            // Retornar los resultados de la consulta
            return $resultados;
        }
    }
    function gHomeInfo() {
        $gnrl = array();
        if (isset($_SESSION[$this->language]['gHomeInfo'])) {
            $gnrl[$this->language] = $_SESSION[$this->language]['gHomeInfo'];
        } else {
            $resultES = $this->query("pages/8695");
            $resultFR = $this->query("pages/8769");
            $gnrl = array();
            $modifiedDataES = $resultES["response"];
            $modifiedDataFR = $resultFR["response"];
            $gnrl["es"] = $modifiedDataES;
            $gnrl["fr"] = $modifiedDataFR;
            $_SESSION['es']['gHomeInfo'] = $modifiedDataES;
            $_SESSION['fr']['gHomeInfo'] = $modifiedDataFR;
        }
        return $gnrl[$this->language] ;
    }
    function getTheme($id){
        $response = $this->customQuery("cinescuela-ap/$id");
        return $response;
    }
    function getPages($ids = "", $page = 1, $per_page = 50, $extra = []) {
        $info = $this->consultarRecursos("pages", $ids, "", "GET", $page, $per_page,  $extra, true);
        return $info;
    }
    function getPeliculas($ids = "", $page = 1, $per_page = 50, $extra = []) {
        if($ids != ""){
            $peliculas = $this->consultarRecursos("cinescuela-movies", $ids, "", "GET", $page, $per_page,  $extra, false);
        }else{
            $peliculas = $this->consultarRecursos("cinescuela-movies", $ids, "", "GET", $page, $per_page,  $extra, true);
        }
        return $peliculas;
    }
    function getCiclos($ids = "", $page = 1, $per_page = 100, $extra = []) {
        if($ids != ""){
            $ciclos = $this->consultarRecursos("cinescuela-ciclo", $ids,  "", "GET", $page, $per_page, $extra, false);
        }else{
            $ciclos = $this->consultarRecursos("cinescuela-ciclo", $ids,  "", "GET", $page, $per_page, $extra, true);
        }
        return $ciclos;
    }
    function getSliderPrincipales($ids = "") {
        if (isset($_SESSION['getSliderPrincipales'])) {
            $slprin = $_SESSION['getSliderPrincipales'];
        } else {
            $slprin = $this->consultarRecursos("cinescuela-slprin");
            $_SESSION['getSliderPrincipales'] = $slprin;
        }
        return $slprin["response"];
    }
    function getSliderSecundarios($ids = "") {
        if (isset($_SESSION['getSliderSecundarios'])) {
            $slsec = $_SESSION['getSliderSecundarios'];
        } else {
            $slsec = $this->consultarRecursos("cinescuela-slsec");
            $_SESSION['getSliderSecundarios'] = $slsec;
        }
        return $slsec["response"];
    }
    function getAsignaturas($ids = "") {
        if (isset($_SESSION['getAsignaturas'])) {
            $slsec = $_SESSION['getAsignaturas'];
        } else {
            $slsec = $this->consultarRecursos("cinescuela-subjects");
            $_SESSION['getAsignaturas'] = $slsec;
        }
        return $slsec["response"];
    }
    function getTematicas($ids = "") {
        if (isset($_SESSION['getTematicas'])) {
            $slsec = $_SESSION['getTematicas'];
        } else {
            $slsec = $this->consultarRecursos("cinescuela-tematicas");
            $_SESSION['getTematicas'] = $slsec;
        }
        return $slsec["response"];
    }
    function loginCinescuelaUser($username){
        $user = $this->consultarRecursos("cinescuela-users", "", "","GET", 99, 99,['slug'=>$username], false);
        return $user['response'];
    }
    function getInfoUser($id){
        $user = $this->consultarRecursos("cinescuela-users", $id, "","GET", 1, 1,[], false);
        return $user;
    }
    function getProfileUsers($id){
        $profile = $this->consultarRecursos("cinescuela-perfiles", $id);
        return $profile;
    }
    function getAP($rowID){
        $ap = $this->consultarRecursos("cinescuela-ap", "", "","GET", 1, 1,['field'=>'pelicula_relacionada','value'=>$rowID]);
        return $ap['response'][0];
    }
    function getCS($rowID){
        $ap = $this->consultarRecursos("cinescuela-cys", "", "","GET", "", "",['field'=>'acoid','value'=>$rowID]);
        return $ap['response'];
    }
    function getTools($idTools){
        $tools = $this->consultarRecursos("cinescuela-tools", $idTools);
        return $tools;
    }
    function getEdades($idEdad){
        $tools = $this->consultarRecursos("cinescuela-ge", $idEdad);
        return $tools;
    }
    function getTotems($idMovie){
        $totems = $this->consultarRecursos("cinescuela-totem", "", "","GET", 1, 99,['field'=>'pelicula','value'=>$idMovie]);
        return $totems;
    }
    function read_json($array){
		$str = file_get_contents('data_static.json');
		$array = json_decode($str, true);
		return $array;
	}
	function find_array($array, $row, $lang){
		echo $array[$row][$lang];
	}
    function get_alias($String){
        $String = html_entity_decode($String); // Traduce codificación

        $String = str_replace("%2c", "_", $String); //Signo de exclamación abierta.&iexcl;
        $String = str_replace("¡", "", $String); //Signo de exclamación abierta.&iexcl;
        $String = str_replace("'", "", $String); //Signo de exclamación abierta.&iexcl;
        $String = str_replace("!", "", $String); //Signo de exclamación cerrada.&iexcl;
        $String = str_replace("¢", "-", $String); //Signo de centavo.&cent;
        $String = str_replace("£", "-", $String); //Signo de libra esterlina.&pound;
        $String = str_replace("¤", "-", $String); //Signo monetario.&curren;
        $String = str_replace("¥", "-", $String); //Signo del yen.&yen;
        $String = str_replace("¦", "-", $String); //Barra vertical partida.&brvbar;
        $String = str_replace("§", "-", $String); //Signo de sección.&sect;
        $String = str_replace("¨", "-", $String); //Diéresis.&uml;
        $String = str_replace("©", "-", $String); //Signo de derecho de copia.&copy;
        $String = str_replace("ª", "-", $String); //Indicador ordinal femenino.&ordf;
        $String = str_replace("«", "-", $String); //Signo de comillas francesas de apertura.&laquo;
        $String = str_replace("¬", "-", $String); //Signo de negación.&not;
        $String = str_replace("", "-", $String); //Guión separador de sílabas.&shy;
        $String = str_replace("®", "-", $String); //Signo de marca registrada.&reg;
        $String = str_replace("¯", "&-", $String); //Macrón.&macr;
        $String = str_replace("°", "-", $String); //Signo de grado.&deg;
        $String = str_replace("±", "-", $String); //Signo de más-menos.&plusmn;
        $String = str_replace("²", "-", $String); //Superíndice dos.&sup2;
        $String = str_replace("³", "-", $String); //Superíndice tres.&sup3;
        $String = str_replace("´", "-", $String); //Acento agudo.&acute;
        $String = str_replace("µ", "-", $String); //Signo de micro.&micro;
        $String = str_replace("¶", "-", $String); //Signo de calderón.&para;
        $String = str_replace("·", "-", $String); //Punto centrado.&middot;
        $String = str_replace("¸", "_", $String); //Cedilla.&cedil;
        $String = str_replace("¹", "-", $String); //Superíndice 1.&sup1;
        $String = str_replace("º", "-", $String); //Indicador ordinal masculino.&ordm;
        $String = str_replace("»", "-", $String); //Signo de comillas francesas de cierre.&raquo;
        $String = str_replace("¼", "-", $String); //Fracción vulgar de un cuarto.&frac14;
        $String = str_replace("½", "-", $String); //Fracción vulgar de un medio.&frac12;
        $String = str_replace("¾", "-", $String); //Fracción vulgar de tres cuartos.&frac34;
        $String = str_replace("¿", "-", $String); //Signo de interrogación abierta.&iquest;
        $String = str_replace("×", "-", $String); //Signo de multiplicación.&times;
        $String = str_replace("÷", "-", $String); //Signo de división.&divide;
        $String = str_replace("À", "a", $String); //A mayúscula con acento grave.&Agrave;
        $String = str_replace("Á", "a", $String); //A mayúscula con acento agudo.&Aacute;
        $String = str_replace("Â", "a", $String); //A mayúscula con circunflejo.&Acirc;
        $String = str_replace("Ã", "a", $String); //A mayúscula con tilde.&Atilde;
        $String = str_replace("Ä", "a", $String); //A mayúscula con diéresis.&Auml;
        $String = str_replace("Å", "a", $String); //A mayúscula con círculo encima.&Aring;
        $String = str_replace("Æ", "a", $String); //AE mayúscula.&AElig;
        $String = str_replace("Ç", "c", $String); //C mayúscula con cedilla.&Ccedil;
        $String = str_replace("È", "e", $String); //E mayúscula con acento grave.&Egrave;
        $String = str_replace("É", "e", $String); //E mayúscula con acento agudo.&Eacute;
        $String = str_replace("Ê", "e", $String); //E mayúscula con circunflejo.&Ecirc;
        $String = str_replace("Ë", "e", $String); //E mayúscula con diéresis.&Euml;
        $String = str_replace("Ì", "i", $String); //I mayúscula con acento grave.&Igrave;
        $String = str_replace("Í", "i", $String); //I mayúscula con acento agudo.&Iacute;
        $String = str_replace("Î", "i", $String); //I mayúscula con circunflejo.&Icirc;
        $String = str_replace("Ï", "i", $String); //I mayúscula con diéresis.&Iuml;
        $String = str_replace("Ð", "d", $String); //ETH mayúscula.&ETH;
        $String = str_replace("Ñ", "n", $String); //N mayúscula con tilde.&Ntilde;
        $String = str_replace("Ò", "o", $String); //O mayúscula con acento grave.&Ograve;
        $String = str_replace("Ó", "o", $String); //O mayúscula con acento agudo.&Oacute;
        $String = str_replace("Ô", "o", $String); //O mayúscula con circunflejo.&Ocirc;
        $String = str_replace("Õ", "o", $String); //O mayúscula con tilde.&Otilde;
        $String = str_replace("Ö", "o", $String); //O mayúscula con diéresis.&Ouml;
        $String = str_replace("Ø", "o", $String); //O mayúscula con barra inclinada.&Oslash;
        $String = str_replace("Ù", "u", $String); //U mayúscula con acento grave.&Ugrave;
        $String = str_replace("Ú", "u", $String); //U mayúscula con acento agudo.&Uacute;
        $String = str_replace("Û", "u", $String); //U mayúscula con circunflejo.&Ucirc;
        $String = str_replace("Ü", "u", $String); //U mayúscula con diéresis.&Uuml;
        $String = str_replace("Ý", "y", $String); //Y mayúscula con acento agudo.&Yacute;
        $String = str_replace("Þ", "b", $String); //Thorn mayúscula.&THORN;
        $String = str_replace("ß", "b", $String); //S aguda alemana.&szlig;
        $String = str_replace("à", "a", $String); //a minúscula con acento grave.&agrave;
        $String = str_replace("á", "a", $String); //a minúscula con acento agudo.&aacute;
        $String = str_replace("â", "a", $String); //a minúscula con circunflejo.&acirc;
        $String = str_replace("ã", "a", $String); //a minúscula con tilde.&atilde;
        $String = str_replace("ä", "a", $String); //a minúscula con diéresis.&auml;
        $String = str_replace("å", "a", $String); //a minúscula con círculo encima.&aring;
        $String = str_replace("æ", "a", $String); //ae minúscula.&aelig;
        $String = str_replace("ç", "a", $String); //c minúscula con cedilla.&ccedil;
        $String = str_replace("è", "e", $String); //e minúscula con acento grave.&egrave;
        $String = str_replace("é", "e", $String); //e minúscula con acento agudo.&eacute;
        $String = str_replace("ê", "e", $String); //e minúscula con circunflejo.&ecirc;
        $String = str_replace("ë", "e", $String); //e minúscula con diéresis.&euml;
        $String = str_replace("ì", "i", $String); //i minúscula con acento grave.&igrave;
        $String = str_replace("í", "i", $String); //i minúscula con acento agudo.&iacute;
        $String = str_replace("î", "i", $String); //i minúscula con circunflejo.&icirc;
        $String = str_replace("ï", "i", $String); //i minúscula con diéresis.&iuml;
        $String = str_replace("ð", "i", $String); //eth minúscula.&eth;
        $String = str_replace("ñ", "n", $String); //n minúscula con tilde.&ntilde;
        $String = str_replace("ò", "o", $String); //o minúscula con acento grave.&ograve;
        $String = str_replace("ó", "o", $String); //o minúscula con acento agudo.&oacute;
        $String = str_replace("ô", "o", $String); //o minúscula con circunflejo.&ocirc;
        $String = str_replace("õ", "o", $String); //o minúscula con tilde.&otilde;
        $String = str_replace("ö", "o", $String); //o minúscula con diéresis.&ouml;
        $String = str_replace("ø", "o", $String); //o minúscula con barra inclinada.&oslash;
        $String = str_replace("ù", "o", $String); //u minúscula con acento grave.&ugrave;
        $String = str_replace("ú", "u", $String); //u minúscula con acento agudo.&uacute;
        $String = str_replace("û", "u", $String); //u minúscula con circunflejo.&ucirc;
        $String = str_replace("ü", "u", $String); //u minúscula con diéresis.&uuml;
        $String = str_replace("ý", "y", $String); //y minúscula con acento agudo.&yacute;
        $String = str_replace("þ", "b", $String); //thorn minúscula.&thorn;
        $String = str_replace("ÿ", "y", $String); //y minúscula con diéresis.&yuml;
        $String = str_replace("Œ", "d", $String); //OE Mayúscula.&OElig;
        $String = str_replace("œ", "-", $String); //oe minúscula.&oelig;
        $String = str_replace("Ÿ", "-", $String); //Y mayúscula con diéresis.&Yuml;
        $String = str_replace("ˆ", "", $String); //Acento circunflejo.&circ;
        $String = str_replace("˜", "", $String); //Tilde.&tilde;
        $String = str_replace("–", "", $String); //Guiún corto.&ndash;
        $String = str_replace("—", "", $String); //Guiún largo.&mdash;
        $String = str_replace("'", "", $String); //Comilla simple izquierda.&lsquo;
        $String = str_replace("'", "", $String); //Comilla simple derecha.&rsquo;
        $String = str_replace("‚", "", $String); //Comilla simple inferior.&sbquo;
        $String = str_replace("\"", "", $String); //Comillas doble derecha.&rdquo;
        $String = str_replace("\"", "", $String); //Comillas doble inferior.&bdquo;
        $String = str_replace("†", "-", $String); //Daga.&dagger;
        $String = str_replace("‡", "-", $String); //Daga doble.&Dagger;
        $String = str_replace("…", "-", $String); //Elipsis horizontal.&hellip;
        $String = str_replace("‰", "-", $String); //Signo de por mil.&permil;
        $String = str_replace("‹", "-", $String); //Signo izquierdo de una cita.&lsaquo;
        $String = str_replace("›", "-", $String); //Signo derecho de una cita.&rsaquo;
        $String = str_replace("€", "-", $String); //Euro.&euro;
        $String = str_replace("™", "-", $String); //Marca registrada.&trade;
        $String = str_replace(":", "-", $String); //Marca registrada.&trade;
        $String = str_replace(" & ", "-", $String); //Marca registrada.&trade;
        $String = str_replace("(", "-", $String);
        $String = str_replace(")", "-", $String);
        $String = str_replace("?", "-", $String);
        $String = str_replace("¿", "-", $String);
        $String = str_replace(",", "-", $String);
        $String = str_replace(";", "-", $String);
        $String = str_replace("�", "-", $String);
        $String = str_replace("/", "-", $String);
        $String = str_replace(" ", "-", $String); //Espacios
        $String = str_replace(".", "", $String); //Punto
        $String = str_replace("&", "-", $String);
        $String = str_replace("“", "", $String);
        $String = str_replace("”", "", $String);
        $String = str_replace("+", "", $String);
        $String = str_replace("–", "", $String);
        $String = str_replace("—", "", $String);
        $String = str_replace("-", "", $String);

        //Mayusculas
        $String = strtolower($String);

        return ($String);
    }
    function replaceUrl($url) {
		// Obtenemos la parte de la URL después del dominio
		$path = parse_url($url, PHP_URL_PATH);
		// Quitamos '/wp-content/uploads/' del path
		$path = preg_replace('/\/wp-content\/uploads\//', '/', $path);
		// Reemplazamos la parte de la URL con 'files.cinescuela.org'
		$newUrl = 'https://files.cinescuela.org' . $path;
		return $newUrl;
	}
    function getRealIP() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		//whether ip is from proxy
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		//whether ip is from remote address
		else{
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
		return $ip_address;
	}
	function verifyIp($theip){
		global $cinescuela;
		$ip = getRealIP(); // Obtener la IP real del usuario
		$users = $cinescuela->query("cinescuela-users", "", "GET", 1, 100, ['field' => 'ips', 'value' => $ip], false);
		if (is_array($users) && count($users) > 0) {
			return $users['response'][0]; // Se encontró al menos un usuario con la IP dada
		} else {
			return false; // No se encontraron usuarios con la IP dada
		}
	}
	function setIp($userRowID){
		$ip = getRealIP();
		$ch = curl_init('http://orekacloud.com/p/custom_functions/217/set_ip.php');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		curl_setopt($ch, CURLOPT_POSTFIELDS, '{"user":'.$userRowID.',"ip":"'.$ip.'"}');
		$ch_response = curl_exec($ch);
		curl_close($ch);
		return $ch_response;
	}
}
?>