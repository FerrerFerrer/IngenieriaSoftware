<?php
  require_once('/wp-config.php');
  global $wpdb;

    $table='wp_proyectos';

    $data=array(
      'expediente' => $_POST['q3_2Expediente3'],
      'evidencia' => $_POST['q4_typeA'],
      'grado' => $_POST['q7_3Grado'],
      'nombre' => $_POST['q8_4Primer'],
      'nombre2' => $_POST['q9_5Segundo']
      'paterno' => $_POST['q10_6Apellido'],
      'materno' => $_POST['q11_7Apellido'],
      'genero' => $_POST['q12_6Genero'];
      );

      $wpdb->insert($table,$data);
 ?>
