<?php
		$expediente = $_GET['id'];

		$cookie_name = "expediente";
		$cookie_value = $expediente;
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

		header("Location: http://elcris.ddns.net/editar/");
?>
