<?php
	session_start();
	include "sdk.php";
	$sdk = new Cinescuela(isset($lang) ? $lang : "es"); 
?>