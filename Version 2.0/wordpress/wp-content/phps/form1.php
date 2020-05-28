<?php
	$servername="elcris.ddns.net";
	$user="proyectos";
	$password="estosecambiadespues";
	$dbname="proyectos";

	$conn = new mysqli($servername, $user, $password, $dbname);

		$expediente = $_POST['q3_2Expediente3'];
		$evidencia = $_POST['q4_typeA'];
		$grado = $_POST['q7_3Grado'];
		$nombre = $_POST['q8_4Primer'];
		$nombre2 = $_POST['q9_5Segundo'];
		$paterno = $_POST['q10_6Apellido'];
		$materno = $_POST['q11_7Apellido'];
		$genero = $_POST['q12_6Genero'];

		$cookie_name = "expediente";
		$cookie_value = $expediente;
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");



		$sql = "INSERT INTO dip_proyecto (expediente, evidencia, grado, nombre, nombre2,
			paterno, materno, genero) VALUES ('$expediente', '$evidencia', '$grado',
				'$nombre', '$nombre2', '$paterno', '$materno', '$genero')";

		mysqli_query($conn,$sql);

		header("Location: http://elcris.ddns.net/registro-de-proyecto-2/");
?>