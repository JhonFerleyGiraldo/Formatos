<?php	
	$link = mysql_connect('localhost:3307', 'root', '1234')
		or die('No se pudo conectar: ' . mysql_error());
	mysql_select_db('db_evaluacion') or die('No se pudo seleccionar la base de datos');
?>