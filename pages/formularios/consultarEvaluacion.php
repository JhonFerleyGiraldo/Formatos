<?php
 include '../conexion/mysql.php';
 
	//Datos del empleado
	$numeroDocumento = $_POST['numeroDocumento'];
	$nombreCompleto = $_POST['nombreCompleto'];
	$nombreJefe = $_POST['nombreJefe'];
	//$fechaEvaluacion = $_POST['fechaEvaluacion'];
	$periodoEvaluado = $_POST['periodoEvaluado'];
	$tipoFormulario = $_POST['tipoFormulario'];
	$evaluador = $_POST['evaluador'];
	
	//Captura de las valores de la encuesta
	$descriptores = array($_POST['d2'], $_POST['d3'], $_POST['d4'], $_POST['d5'], $_POST['d6'], $_POST['d7'], $_POST['d8'], $_POST['d9'], $_POST['d10'], 
		$_POST['d11'], $_POST['d12'], $_POST['d13'], $_POST['d14'], $_POST['d15'], $_POST['d16'], $_POST['d17'], $_POST['d18'], $_POST['d19'], $_POST['d20'],
		$_POST['d21'], $_POST['d22'], $_POST['d23'], $_POST['d24'], $_POST['d25'], $_POST['d26'], $_POST['d27'], $_POST['d28'], $_POST['d29'], $_POST['d30'],
		$_POST['d31'], $_POST['d32'], $_POST['d33'], $_POST['d34'], $_POST['d35'], $_POST['d36'], $_POST['d37'], $_POST['d38'], $_POST['d39'], $_POST['d40'],
		$_POST['d41'], $_POST['d42'], $_POST['d43'], $_POST['d44'], $_POST['d45'], $_POST['d46']);
	
	//Inserta los datos generales del formulario
	$consulta = "INSERT INTO TB_DETALLES (NUM_IDEmpleado, NVA_NombreEmpleado, NVA_NombreJefe, VAR_PeriodoEva, CAR_TipoFormulario)
				 VALUES ('$numeroDocumento', '$nombreCompleto', '$nombreJefe', '$periodoEvaluado', '$tipoFormulario')";			 
	
	mysqli_query($consulta)or die('A error occured: Insertando en la tabla detalles');
	
	//Se selecciona el codigo de identificación del formulario anterior en la tabla tb_detalles
	$consulta = "SELECT NUM_ID FROM TB_DETALLES WHERE NUM_IDEmpleado = '$numeroDocumento' AND VAR_PeriodoEva = '$periodoEvaluado' AND CAR_TipoFormulario = '$tipoFormulario'";
	
	$resultado = mysqli_query($consulta) or die('A error occured: Consultando ID de formulario en la tabla Detalles');
		while ($registro = mysqli_fetch_array($resultado)){
			$idDetalle = $registro[0];
		}	
	
	//Se registran los valores de la encuesta en la tabla tb_encuestas
	$descriptor = 2;
	foreach ($descriptores as $registro) {
		
		$valor = $registro;		
		
		$consulta = "INSERT INTO TB_EVALUACIONES (NUM_ID_DETALLE, NUM_ID_DESCRIPTOR, CAR_EVALUADOR, NVA_VALOR)
				 VALUES ('$idDetalle', '$descriptor', '$evaluador', '$valor')";
				 
		mysqli_query($consulta)or die('A error occured: Insertando respuesta en la tabla TB_EVALUACIONES');
				 
		//echo "$contador. - $registro.<br />\n";
		$descriptor = $descriptor + 1;
	}

								
?>