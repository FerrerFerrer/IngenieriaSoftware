<?php
	$servername="elcris.ddns.net";
	$user="proyectos";
	$password="estosecambiadespues";
	$dbname="proyectos";

	$conn = new mysqli($servername, $user, $password, $dbname);

		$expedienteorig = $_COOKIE['expediente'];
		$expediente = $_POST['31_EXPEDIENTE'];
		$evidencia = $_POST['30_TIENES_EVIDENCIA_DE_PRODUCCIN_CIENTFICA'];
		$nombrecomp = $_POST['32_NOMBRE_COMPLETO'];
		$nomdeproy = $_POST['33_NOMBRE_DEL_PROYECTO_REGISTRADO'];
		$nomart = $_POST['34_NOMBRE_DEL_ARTCULO'];
		$ligaart = $_POST['35_LIGA_DEL_ARTCULO'];
		$comentarioart = $_POST['36_COMENTARIO_DEL_ARTCULO'];

		$nomlib = $_POST['37_NOMBRE_DEL_LIBRO'];
		$ligalib = $_POST['38_LIGA_AL_LIBRO'];
		$comentariolib = $_POST['39_COMENTARIO_SOBRE_EL_LIBRO'];

		$nomcap = $_POST['40_NOMBRE_DEL_CAPTULO_DEL_LIBRO'];
		$ligacap = $_POST['41_LIGA_DEL_CAPTULO_DEL_LIBRO'];
		$comentariocap = $_POST['42_COMENTARIO_SOBRE_EL_CAPTULO_DEL_LIBRO'];

		$nomtesis = $_POST['43NOMBRE_DE_LA_TESIS'];
		$ligatesis = $_POST['44_LIGA_DE_LA_TESIS'];
		$comentariotesis = $_POST['45_COMENTARIO_DE_LA_TESIS'];

		$nomponencia = $_POST['46_NOMBRE_DE_LA_PONENCIA'];
		$ligaponencia = $_POST['47_LIGA_A_LA_PONENCIA'];
		$comentarioponencia = $_POST['48_COMENTARIO_SOBRE_LA_PONENCIA'];

		$nompat = $_POST['49NOMBRE_DE_LA_PATENTE'];
		$ligapat = $_POST['50LIGA_A_LA_PATENTE'];
		$comentariopat = $_POST['51COMENTARIO_SOBRE_LA_PATENTE'];

		$sql = "INSERT INTO dip_evidencia
		(expediente, expedienteorig, evidencia, nombrecomp, nomdeproy, nomart,
		ligaart, comentarioart, nomlib, ligalib, comentariolib,  nomcap,
		ligacap, comentariocap, nomtesis, ligatesis, comentariotesis, nomponencia,
	  ligaponencia, comentarioponencia, nompat, ligapat, comentariopat)
        VALUES
				('$expediente', '$expedienteorig', '$evidencia', '$nombrecomp', '$nomdeproy',
					'$nomart', '$ligaart', '$comentarioart', '$nomlib', '$ligalib', '$comentariolib',
					'$nomcap', '$ligacap', '$comentariocap', '$nomtesis', '$ligatesis',
					'$comentariotesis', '$nomponencia', '$ligaponencia','$comentarioponencia',
					'$nompat', '$ligapat','$comentariopat'
				)
			";

		mysqli_query($conn,$sql);

		header("Location: http://elcris.ddns.net/registro-de-proyecto-subir/");
?>