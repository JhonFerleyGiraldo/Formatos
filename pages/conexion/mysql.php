<?php	
	$link = mysqli_connect('localhost', 'root', '')
		or die('No se pudo conectar: ' . mysqli_error());
	mysqli_select_db($link,'bd_evaluaciondesempeno') or die('No se pudo seleccionar la base de datos');
?>