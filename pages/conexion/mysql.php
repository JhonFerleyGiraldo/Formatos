<?php	
	$link = mysqli_connect('localhost', 'root', '')
		or die('No se pudo conectar: ' . mysqli_error());
	mysqli_select_db($link,'bd_evaluaciondesempeno') or die('No se pudo seleccionar la base de datos');

	if (!$link->set_charset("utf8")) {// Condicional para asignar utf-8
		die("Error mostrando el conjunto de caracteres utf8");
 	}

?>