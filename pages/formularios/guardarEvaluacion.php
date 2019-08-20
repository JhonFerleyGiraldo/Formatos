<?php
 include '../conexion/mysql.php';
 include('../funciones/funciones.php');
 

	
	$numeroDocumento = $_POST['numeroDocumento'];//documento del empleado
	$documentoJefe = $_POST['documentoJefe'];//documento del jefe
	$periodoEvaluado = $_POST['periodoEvaluado'];//periodo evaluado
	$tipoFormulario = 2;//tipo de formulario
	$evaluador = $_POST['evaluador'];//evaluador
	$fechaEvalua=$_POST['fechaEvaluacion'];//fecha eveluacion

	 $usuario=obtenerCodigoUsuario($numeroDocumento);//obtenemos el codigo del usuario de el empleado
	 $jefe=obtenerCodigoUsuario($documentoJefe);//obtenemos el codigo del usuario de el jefe
	
	//Captura de las valores de la encuesta
	$descriptores = array($_POST['d2'], $_POST['d3'], $_POST['d4'], $_POST['d5'], $_POST['d6'], $_POST['d7'], $_POST['d8'], $_POST['d9'], $_POST['d10'], 
		$_POST['d11'], $_POST['d12'], $_POST['d13'], $_POST['d14'], $_POST['d15'], $_POST['d16'], $_POST['d17'], $_POST['d18'], $_POST['d19'], $_POST['d20'],
		$_POST['d21'], $_POST['d22'], $_POST['d23'], $_POST['d24'], $_POST['d25'], $_POST['d26'], $_POST['d27'], $_POST['d28'], $_POST['d29'], $_POST['d30'],
		$_POST['d31'], $_POST['d32'], $_POST['d33'], $_POST['d34'], $_POST['d35'], $_POST['d36'], $_POST['d37'], $_POST['d38'], $_POST['d39'], $_POST['d40'],
		$_POST['d41'], $_POST['d42'], $_POST['d43'], $_POST['d44'], $_POST['d45'], $_POST['d46']);
	
	//Inserta los datos generales del formulario
	$consulta = "INSERT INTO tbl_detalle ( empleador, jefe, periodo, fechaEva, fechaUltima, formularioTipoCargo)
				 VALUES ('$usuario', '$jefe', '$periodoEvaluado','$fechaEvalua' ,'$fechaEvalua' , '$tipoFormulario')";			 

	mysqli_query($link, $consulta);
	

	//Se selecciona el codigo de identificación del formulario anterior en la tabla tb_detalles
	$consulta = "SELECT id FROM tbl_detalle WHERE empleador = '$usuario' AND periodo = '$periodoEvaluado' AND formularioTipoCargo = '$tipoFormulario'";
	

	
	$resultado = mysqli_query($link,$consulta) or die('A error occured: Consultando ID de formulario en la tabla Detalles');
		while ($registro = mysqli_fetch_array($resultado)){
			$idDetalle = $registro[0];
		}	
	
		
	
		

//Se registran los valores de la encuesta en la tabla tb_encuestas
$descriptor = 2;
foreach ($descriptores as $registro) {
	
	$valor = $registro;		
	
	$consulta = "INSERT INTO tbl_evaluacion (detalle, descriptor, evaluador, valor)
				 VALUES ('$idDetalle', '$descriptor', '$evaluador', '$valor')";
			 
	mysqli_query($link,$consulta);
	echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
			 
	//echo "$contador. - $registro.<br />\n";
	$descriptor = $descriptor + 1;
}

	

								
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Guardar-evaluación</title>
	<link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
</head>
<body>
	 <!-- Button to Open the Modal -->
	 <button type="button" id="abrirModal" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    Open modal
  </button>

  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Validación</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          Su encuesta fue registrada satisfactoriamente.
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" id="cerrarModal" class="btn btn-success" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  
</div>   
</body>
<script>

//esperamos la carga del documento
$(document).ready(function() {
    
    $("#abrirModal").hide();

	$("#abrirModal").click();

  });

$("#cerrarModal").click(function(){
	window.location.href="../login/index.php";
});

</script>
</html>