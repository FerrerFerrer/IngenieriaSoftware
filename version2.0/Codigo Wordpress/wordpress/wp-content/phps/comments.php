<?php
	$servername="elcris.ddns.net";
	$user="proyectos";
	$password="estosecambiadespues";
	$dbname="proyectos";

	$conn = new mysqli($servername, $user, $password, $dbname);

		$expediente = $_COOKIE["expediente"];
		$comentarios = $_POST['COMENTARIOS_DEL_REGISTRO_PROYECTO_Y_EVIDENCIAS_DE_INVESTIGACIN'];
		$correcto = $_POST['SE_ENTREG_LA_INFORMACIN_DE_FORMA_CORRECTA'];

		$sql = "UPDATE dip_proyecto
        SET
        comentarios='$comentarios',
        correcto='$correcto',
        WHERE expediente='$expediente'
			";

		mysqli_query($conn,$sql);

		header("Location: http://elcris.ddns.net/listo/");
?>