<?php
	$servername="elcris.ddns.net";
	$user="proyectos";
	$password="estosecambiadespues";
	$dbname="proyectos";

	$conn = new mysqli($servername, $user, $password, $dbname);

		$expediente = $_COOKIE['expediente'];
		$evidencia = $_POST['q4_typeA'];
		$grado = $_POST['q7_3Grado'];
		$nombre = $_POST['q8_4Primer'];
		$nombre2 = $_POST['q9_5Segundo'];
		$paterno = $_POST['q10_6Apellido'];
		$materno = $_POST['q11_7Apellido'];
		$genero = $_POST['q12_6Genero'];

		$sql = " UPDATE dip_proyecto SET evidencia = '$evidencia',
    grado = '$grado', nombre = '$nombre', nombre2 = '$nombre2', paterno = '$paterno',
    materno = '$materno', genero = '$genero' WHERE expediente = '$expediente'";

		mysqli_query($conn,$sql);

		header("Location: http://elcris.ddns.net/editar-2/");
?>