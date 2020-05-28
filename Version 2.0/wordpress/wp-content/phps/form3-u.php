<?php
	$servername="elcris.ddns.net";
	$user="proyectos";
	$password="estosecambiadespues";
	$dbname="proyectos";

	$conn = new mysqli($servername, $user, $password, $dbname);

		$expediente = $_COOKIE["expediente"];
		$articulos = $_POST['22_ARTICULOS'];
		$libros = $_POST['23_LIBROS'];
		$capslib = $_POST['24_CAPITULO_DE_LIBROS'];
		$ponencia = $_POST['25_PONENCIAS'];
		$patente = $_POST['26_PATENTE_S'];
		$tesis = $_POST['27_TESIS'];
		$metodologia = $_POST['28_TIPO_DE_METODOLOGA'];
		$financiamiento = $_POST['29_TIPO_DE_FINANCIAMIENTO'];

		$sql = "UPDATE dip_proyecto        
        SET
        expediente='$expediente', 
        articulos='$articulos',
        libros='$libros',
				capslib='$capslib',
        ponencia='$ponencia',
        patente='$patente',
        tesis='$tesis',
        metodologia='$metodologia',
				financiamiento='$financiamiento'
        WHERE expediente='$expediente'
			";

		mysqli_query($conn,$sql);

		header("Location: http://elcris.ddns.net/editar-4/");
?>