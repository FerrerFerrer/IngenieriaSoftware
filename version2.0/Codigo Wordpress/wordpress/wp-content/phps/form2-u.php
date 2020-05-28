<?php
	$servername="elcris.ddns.net";
	$user="proyectos";
	$password="estosecambiadespues";
	$dbname="proyectos";

	$conn = new mysqli($servername, $user, $password, $dbname);

		$expediente = $_COOKIE["expediente"];
		$unidad = $_POST['9_UNIDAD'];
		$dependencia = $_POST['10_DEPENDENCIA'];
		$conocimiento = $_POST['11_REA_DE_CONOCIMIENTO'];
		$cuerpoac = $_POST['12_CUERPO_ACADMICO'];
		$nivelcuerpoac = $_POST['13_NIVEL_DEL_CUERPO_ACADMICO'];
		$lineadegen = $_POST['14_LINEA_DE_GENERACIN_APLICACIN_DEL_CONOCIMIENTO'];
		$tipodeproy = $_POST['15EL_PROYECTO_ES'];
		$nomdeproy = $_POST['16_NOMBRE_DEL_PROYECTO'];
		$etapa = $_POST['17_ETAPA_DEL_PROYECTO'];
		$fecini = $_POST['18_FECHA_DE_INICIO'];
		$fecfin = $_POST['19_FECHA_DE_TRMINO'];
		$objgral = $_POST['20_OBJETIVO_GENERAL'];
		$objesp = $_POST['21_OBJETIVO_ESPECIFICO'];
        
        if($unidad == 'Externo'){
        $dependencia = $_POST['10_DEPENDENCIA_T'];
        }

		$sql = "UPDATE dip_proyecto 
        SET 
        unidad='$unidad', 
        dependencia='$dependencia', 
        conocimiento='$conocimiento',
		cuerpoac='$cuerpoac', 
        nivelcuerpoac='$nivelcuerpoac', 
        lineadegen='$lineadegen', 
        tipodeproy='$tipodeproy', 
        nomdeproy='$nomdeproy',
		etapa='$etapa', 
        fecini='$fecini', 
        fecfin='$fecfin', 
        objgral='$objgral', 
        objesp='$objesp'
        WHERE expediente='$expediente'
			";

		mysqli_query($conn,$sql);

		header("Location: http://elcris.ddns.net/editar-3/");
?>