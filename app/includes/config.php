<?php
	session_start();
	include "../../includes/sdk.php";
	$sdk = new Cinescuela(isset($lang) ? $lang : "es"); 
?>