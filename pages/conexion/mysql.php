<?php	
	$link = mysqli_connect('localhost', 'root', '')
		or die('No se pudo conectar: ' . mysql_error());
	mysqli_select_db($link,'db_evaluacion') or die('No se pudo seleccionar la base de datos');
?>