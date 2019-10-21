<?php
 session_start();
 include '../conexion/mysql.php';
 include('../funciones/funciones.php');
 if(!isset($_SESSION["usuario"])){
	header("location:../login/index.php");
}
	
	$numeroDocumento = $_POST['numeroDocumento'];//documento del empleado
	if(isset($_POST['documentoJefe'])){
		$documentoJefe = $_POST['documentoJefe'];
		$jefe=obtenerCodigoUsuario($documentoJefe);//obtenemos el codigo del usuario de el jefe
	}//documento del jefe
	$periodoEvaluado = $_POST['periodoEvaluado'];//periodo evaluado
	$tipoFormulario = $_POST["tipoFormulario"];//tipo de formulario
	$evaluador = $_POST['evaluador'];//evaluador
	$fechaEvalua=$_POST['fechaEvaluacion'];//fecha eveluacion

	 $usuario=obtenerCodigoUsuario($numeroDocumento);//obtenemos el codigo del usuario de el empleado

	
		
		
		//es porque esta guardando respuesta de un formulario directivo, asi que las posiciones cambian
		if(isset($_GET["guardar"])){

			if($_GET["guardar"]=="directivo"){
				$descriptores = array($_POST['d47'], $_POST['d48'], $_POST['d49'], $_POST['d50'], $_POST['d51'], $_POST['d52'], $_POST['d53'], $_POST['d54'], $_POST['d55'], 
				$_POST['d56'], $_POST['d57'], $_POST['d58'], $_POST['d59'], $_POST['d60'], $_POST['d61'], $_POST['d62'], $_POST['d63'], $_POST['d64'], $_POST['d65'],
				$_POST['d66'], $_POST['d67'], $_POST['d68'], $_POST['d69'], $_POST['d70'], $_POST['d71'], $_POST['d72'], $_POST['d73'], $_POST['d74'], $_POST['d75'],
				$_POST['d76'], $_POST['d77'], $_POST['d78'], $_POST['d79'], $_POST['d80'], $_POST['d81'], $_POST['d82'], $_POST['d83'], $_POST['d84'], $_POST['d85'],
				$_POST['d86'], $_POST['d87'], $_POST['d88'], $_POST['d89'], $_POST['d90'], $_POST['d91'],$_POST['d92'], $_POST['d93'], $_POST['d94'], $_POST['d95'], 
				$_POST['d96'], $_POST['d97'],$_POST['d98'], $_POST['d99'], $_POST['d100'], $_POST['d101'],$_POST['d102'], $_POST['d103'], $_POST['d104'],$_POST['d105'],
				$_POST['d106']);
			}

		}else{
			//se valida si el formylario es para administrativo=1 o no administrativo=2
			if($tipoFormulario==1){
				$descriptores = array($_POST['d2'], $_POST['d3'], $_POST['d4'], $_POST['d5'], $_POST['d6'], $_POST['d7'], $_POST['d8'], $_POST['d9'], $_POST['d10'], 
				$_POST['d11'], $_POST['d12'], $_POST['d13'], $_POST['d14'], $_POST['d15'], $_POST['d16'], $_POST['d17'], $_POST['d18'], $_POST['d19'], $_POST['d20'],
				$_POST['d21'], $_POST['d22'], $_POST['d23'], $_POST['d24'], $_POST['d25'], $_POST['d26'], $_POST['d27'], $_POST['d28'], $_POST['d29'], $_POST['d30'],
				$_POST['d31'], $_POST['d32'], $_POST['d33'], $_POST['d34'], $_POST['d35'], $_POST['d36'], $_POST['d37'], $_POST['d38'], $_POST['d39'], $_POST['d40'],
				$_POST['d41'], $_POST['d42'], $_POST['d43'], $_POST['d44'], $_POST['d45'], $_POST['d46'],$_POST['d47'], $_POST['d48'], $_POST['d49'], $_POST['d50'], 
				$_POST['d51'], $_POST['d52'],$_POST['d53'], $_POST['d54'], $_POST['d55'], $_POST['d56'],$_POST['d57'], $_POST['d58'], $_POST['d59'],$_POST['d60'],
				$_POST['d61']);
			
			}else{
				//Captura de las valores de la encuesta
				$descriptores = array($_POST['d2'], $_POST['d3'], $_POST['d4'], $_POST['d5'], $_POST['d6'], $_POST['d7'], $_POST['d8'], $_POST['d9'], $_POST['d10'], 
				$_POST['d11'], $_POST['d12'], $_POST['d13'], $_POST['d14'], $_POST['d15'], $_POST['d16'], $_POST['d17'], $_POST['d18'], $_POST['d19'], $_POST['d20'],
				$_POST['d21'], $_POST['d22'], $_POST['d23'], $_POST['d24'], $_POST['d25'], $_POST['d26'], $_POST['d27'], $_POST['d28'], $_POST['d29'], $_POST['d30'],
				$_POST['d31'], $_POST['d32'], $_POST['d33'], $_POST['d34'], $_POST['d35'], $_POST['d36'], $_POST['d37'], $_POST['d38'], $_POST['d39'], $_POST['d40'],
				$_POST['d41'], $_POST['d42'], $_POST['d43'], $_POST['d44'], $_POST['d45'], $_POST['d46']);
			
			
			}
		}


		//Se valida si se trata de autoevaluacion=1 o calificacion jefe=2
	if($evaluador==2){
	
		
		if(!isset($_GET["detalle"])){
			die('No se encontro el consecutivo de detalle.'); 
		}
		
		$detalleId=$_GET["detalle"];

			$codigoJefe=obtenerCodigoUsuario($_SESSION["usuario"]);

			



			//Se registran los valores de la encuesta en la tabla tbl_evaluacion
			if(isset($_GET["guardar"])){

				//Se valida si la calificacion se esta realizando a un formulario directivo
				if($_GET["guardar"]=="directivo"){
					$descriptor = 46;//se inicia en 46 ya que es un directivo
				}

			}else{
				$descriptor = 1;//se inicia en 1 ya que es el primer registro en la tabla descriptores
			}
			
			$sumaResultado=0;

			foreach ($descriptores as $registro) {

				$porcentajeDescriptor=0;

				$valor = $registro;		

				$porcentajeDescriptor=GetPorcentajeDescriptor($descriptor);
				
				$sumaResultado=$sumaResultado+$valor*($porcentajeDescriptor/100);

				$porcentajeEvaluado=$valor*($porcentajeDescriptor/100);

				$consulta = "INSERT INTO tbl_evaluacion (detalle, descriptor, evaluador, valor,porcenEvaluado)
					VALUES ('$detalleId', '$descriptor', '$evaluador', '$valor','$porcentajeEvaluado')";
			
				mysqli_query($link,$consulta);// or die('A error occured: Insertando evaluacion');
				//echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";

				//echo "$contador. - $registro.<br />\n";
				$descriptor = $descriptor + 1;
			}

			$estado=0;
			if($sumaResultado>=3){
				$estado=3;
			}else{
				$estado=2;
			}


			$fechaUltima=GetFechaUltimaEvaluacion($detalleId);

				
			if($fechaUltima==0){
				//Actualiza el detalle de la evaluacion
				$consulta="UPDATE tbl_detalle set fechaUltima=NULL,estado='$estado',resultado='$sumaResultado'
				WHERE id='$detalleId' AND jefe='$codigoJefe'";
			}else{
				//Actualiza el detalle de la evaluacion
				$consulta="UPDATE tbl_detalle set fechaUltima='$fechaUltima',estado='$estado',resultado='$sumaResultado'
				WHERE id='$detalleId' AND jefe='$codigoJefe'";
			}

			

			mysqli_query($link, $consulta);//or die('A error occured: insertando en la tabla Detalles');
			echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";

			echo "Resultado:: " . $sumaResultado;

			
		//si no es porque es una autoevaluacion
	}else{

			//Inserta los datos generales del formulario
			$consulta = "INSERT INTO tbl_detalle ( empleado, jefe, periodo, fechaEva, formularioTipoCargo,estado)
			VALUES ('$usuario', '$jefe', '$periodoEvaluado',NOW(), '$tipoFormulario',1)";			 

			mysqli_query($link, $consulta)or die('A error occured: insertando en la tabla Detalles');
			//echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";


			//Se selecciona el codigo de identificación del formulario anterior en la tabla tb_detalles
			$consulta = "SELECT id FROM tbl_detalle WHERE empleado = '$usuario' AND periodo = '$periodoEvaluado' AND formularioTipoCargo = '$tipoFormulario'";



			$resultado = mysqli_query($link,$consulta) or die('A error occured: Consultando ID de formulario en la tabla Detalles');
			while ($registro = mysqli_fetch_array($resultado)){
			$idDetalle = $registro[0];
			}	


			//se valida si el formylario es para administrativo=1 o no administrativo=2
			if($tipoFormulario==1){
				//Se registran los valores de la encuesta en la tabla tbl_evaluacion
				$descriptor = 46;//se inicia en 46 ya que es el primer descriptor de administrativos
				$var1=0;
				foreach ($descriptores as $registro) {
				$var1++;
				$valor = $registro;	
			

				$consulta = "INSERT INTO tbl_evaluacion (detalle, descriptor, evaluador, valor)
					VALUES ('$idDetalle', '$descriptor', '$evaluador', '$valor')";

				mysqli_query($link,$consulta);// or die('A error occured: Insertando evaluacion');
				echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";

				//echo "$contador. - $registro.<br />\n";
				$descriptor = $descriptor + 1;
				}
				echo "Este es el valor : " . $var1;
			}else{
				//Se registran los valores de la encuesta en la tabla tbl_evaluacion
				$descriptor = 1;//se inicia en 2 ya que es el primer registro en la tabla descriptores
				foreach ($descriptores as $registro) {

				$valor = $registro;	

				$consulta = "INSERT INTO tbl_evaluacion (detalle, descriptor, evaluador, valor)
					VALUES ('$idDetalle', '$descriptor', '$evaluador', '$valor')";

				mysqli_query($link,$consulta) or die('A error occured: Insertando evaluacion');
				//echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";

				//echo "$contador. - $registro.<br />\n";
				$descriptor = $descriptor + 1;
				}
			}

			

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
	<link rel="icon" type="image/x-icon" href="../../images/iconos/IconPage.ico">
    
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
          <h4 class="modal-title">Validaci&oacute;n</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          Registro guardado satisfactoriamente.
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" id="cerrarModal" class="btn btn-success" data-dismiss="modal">Continuar</button>
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

	<?php
		$cargo=$_SESSION["cargo"];
		$bandera;
		//si los cargos no son jefes se enviaran al login
		if($cargo==11 || $cargo==33 || $cargo==2){
			$bandera="true";
		}else{
			$bandera="false";
			
		}
	?>
	var bandera= <?php echo $bandera; ?>;
	if(bandera){

		
		window.location.href="../login/index.php";
	}else{
	
		window.location.href="../formularios/inicioJefe.php";
	}

});

</script>
</html>