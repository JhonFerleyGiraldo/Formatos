<?php
session_start();

  if(!isset($_SESSION["usuario"])){
    header("location:../login/index.php");
  }
 include('../conexion/mysql.php');
 include('../funciones/source.php');
 include('../funciones/funciones.php');  
date_default_timezone_set('America/Bogota');

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Inicio</title>
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
          <h4 class="modal-title">Validación</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          Usted ya registro su evaluación para este periodo, favor validar.
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

  });

    function abrirModal(){
        $('#abrirModal').click();
	
		setTimeout('CerrarAutomaticamente()', 2500);

    }
	function CerrarAutomaticamente(){
		$("#cerrarModal").click();
	}


$("#cerrarModal").click(function(){
	<?php
		$cargo=$_SESSION["cargo"];
		$bandera;
		if($cargo==1){
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

<?php
if(ValidarEvaluacionPorPeriodo(obtenerCodigoUsuario($_SESSION["usuario"]),date('Y'))){
	echo "  <script>
				//Abrir modal es usado para cerrarle la aplicacion al usuario
				//se comenta ya que lo que se va a realizar es mostrarle al usuario la encuesta realizada pero bloqueada
				//abrirModal();

				//Redireccionamos al formulario para ver la evaluacion realizada en el periodo
				window.location.href='visualizarEvaluacionDirectivos.php?usuario=" . $_SESSION['usuario'] . "';

			</script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Evaluación de Desempeño</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../vendors/icheck/skins/all.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="icon" type="image/x-icon" href="../../images/iconos/IconPage.ico">
</head>
<style>
.inputs{
	border-color:#000000;
}

</style>
<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      
      <div class="navbar-menu-wrapper d-flex align-items-center"> 
		   
		<h2>Evaluación del desempeño cargos directivos</h2>  
      </div>
	  
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
    
      <!-- partial -->
      <div class="main-panel col-lg-12">
	  <form class="form-sample" action="guardarEvaluacion.php" method="post">   
		<!-- CABECERA AUTOEVALUACION -->
        <div class="content-wrapper">
          <div class="row">    
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h3 class="">Autoevaluación</h3>
				  <br>
				  <p class="col-md-12" style="text-align: justify;">
                      Estimado trabajador, esta evaluación nos permitirá establecer el nivel de desempeño en sus labores asignadas 
					  y si es pertinente establecer un plan de mejora con usted.  Por esto, es importante que efectúe una valoración 
					  honesta de cada uno de los ítem señalados utilizando el criterio: NUNCA, CASI NUNCA, ALGUNAS VECES, CASI SIEMPRE o SIEMPRE. 
					  Por favor seleccione la casilla que corresponde en cada item, de acuerdo a lo que usted considera que aplica para cada aspecto.
                  </p>
				  <br>               
                    <div class="row">
					  <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Número de Documento:</label>
                          <div class="col-sm-5">
                            <input type="text" class="form-control inputs" value="<?php echo $_SESSION['usuario'];?>" readonly="readonly" placeholder="Ingrese documento" name="numeroDocumento"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Nombre completo del trabajador:</label>
                          <div class="col-sm-5">
                            <input type="text" class="form-control inputs" value="<?php echo $_SESSION['nombreUsuario']; ?>" readonly="readonly" placeholder="Ingrese su nombre" name="nombreCompleto"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Nombre completo del evaluador y/o jefe inmediato:</label>
                          <div class="col-sm-5">
                           
							<select class="form-control inputs" required name="documentoJefe">
							<?php
								TraerJefes($_SESSION["cargo"],$_SESSION['usuario']);
							?>
							</select>
						  </div>

                        </div>
                      </div>
					  <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Fecha de evaluación</label>
                          <div class="col-sm-8">
                            <input value="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="dd/mm/yyyy" readonly="readonly" name="fechaEvaluacion"/>
                          </div>
                        </div>
                      </div>
					  <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Periodo evaluado:</label>
                          <div class="col-sm-9">
							<select class="form-control inputs" name="periodoEvaluado" >
							<?php
								ListaPeriodos();
							?>
							</select>
							<input type="hidden" class="form-control" name="tipoFormulario" value="1"/>
							<input type="hidden" class="form-control" name="evaluador" value="1"/>
                          </div>
                        </div>
                      </div>
                    </div>                    
                </div>
              </div>
            </div>
          </div>
        </div>
		<!-- FIN DE CABECERA AUTOEVALUACION -->
		<!-- GRUPO ORGANIZACIONALES -->
		<div class="content-wrapper">
          <div class="row">			
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">   
				<h3 class="">Directivas 30%</h3>	
				  <br> 
					<div class="row">						
					  <h4 class="">Liderazgo y empoderamiento 18%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								 encabezadosRespuestas();							
								 descripcion('Motiva permanentemente a sus colaboradores. Emprende acciones para mejorar el talento y las capacidades de su equipo de trabajo.');
							     botonRadio('d2');
								 
								 descripcion('Mantiene los grupos de trabajo con un desarrollo conforme a los estandares establecidos y comparte las consecuencias y resultados con todos los involucrados.');
							     botonRadio('d3');
								 
								 descripcion('Promueve la eficacia del equipo. Fija claramente objetivos de desempeño y responsabilidades, proporcionando dirección y capacitación.');
							     botonRadio('d4');
						
								 descripcion('Aprovecha la diversidad (heterogeneidad) del equipo para lograr un valor agregado a la Institución. Combina adecuadamente situación-persona y tiempo.');
							     botonRadio('d5');
								 
							?>
						</div>
                    </div>                     
					<br>                 
                    <div class="row">						
					  <h4 >Poder de negociación 4%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								 encabezadosRespuestas();							
								 descripcion('Se pone en el lugar del otro y anticipa sus necesidades e intereses ante una negociación.');
							     botonRadio('d6');
							
								 descripcion('Logra convencer a la contra parte y vende sus ideas en beneficio de los interereses de la organización.');
							     botonRadio('d7');
							
								 descripcion('Logra acuerdos satisfactorios para ambas partes, basándose en criterios objetivos.');
							     botonRadio('d8');
							
								 descripcion('Dirige y controla una discusión utilizando técnicas ganar-ganar, planifica opciones para negociar los mejores acuerdos.');
							     botonRadio('d9');
								 
							?>
						</div>
                    </div> 
					<br>
					<div class="row">						
					  <h4 >Planeación y control 4%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								 encabezadosRespuestas();							
								 descripcion('Anticipa situaciones y escenarios futuros con acierto, establece objetivos  claros y  concisos, estructurados y coherentes  con  las  metas organizacionales.');
							     botonRadio('d10');
							
								 descripcion('Busca solución a los problemas, distribuye el tiempo con eficiencia, establece planes alternativos de acción y se centra en el problema y no en la persona.');
							     botonRadio('d11');
							
								 descripcion('Conoce y maneja la ejecución de los procesos y sus resultados.');
							     botonRadio('d12');
							
								 descripcion('Define Indicadores Que le permiten realizar seguimiento a la gestion y a los palnes de accion establecidos.');
							     botonRadio('d13');
								 
								 descripcion('Establece medidas correctivas y de mejora a los procesos con desviaciones.');
							     botonRadio('d14');
							?>
						</div>
                    </div> 
					<br>
					<div class="row">						
					  <h4 >Juicio analitico 4%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								 encabezadosRespuestas();							
								 descripcion('Analiza las partes de un problema o situacion paso a paso, interpretando las situaciones , hechos o datos.');
							     botonRadio('d15');
							
								 descripcion('Realiza comparaciones continuamente, saca concluiones y actua conforme a lo aprendido.');
							     botonRadio('d16');
							
							?>
						</div>
                    </div> 
                </div>
              </div>
            </div>
          </div>
        </div>
		
		<div class="content-wrapper">
          <div class="row">			
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">   
				<h3 class="">ORGANIZACIONALES 25%</h3>	
				  <br> 
					<div class="row">						
					  <h4 class="">Trabajo en equipo 10%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								encabezadosRespuestas();
								descripcion('Reconoce e identifica las habilidades y fortalezas de los miembros del equipo, optimizando resultados y logrando un rendimiento excepcional con compromiso y confianza mutua.');
							     botonRadio('d17');
								 
								 descripcion('Valora y promueve el trabajo en equipo,  aprovecha  ventajas y beneficios del mismo para la consecución de objetivos Organizacionales,  prioriza las tareas que afectan el trabajo de otros.');
							     botonRadio('d18');
								 
								descripcion('Lidera y participa en las reuniones establecidas por la Organización.');
							     botonRadio('d19');
								 
								descripcion('Reconoce la interdependencia entre su trabajo y el de otros.');
							     botonRadio('d20');
								 
								descripcion('Respeta  criterios dispares y distintas opiniones.');
							    botonRadio('d21');
								
								descripcion('Establece dialogo directo con los miembros del equipo, comparte conocimientos, información, recursos y medios de trabajo.');
							     botonRadio('d22');
							?>
							<br><br>							
						</div>
                    </div>                     
					<br>                 
                    <div class="row">						
					  <h4 >Orientación al usuario 15%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								encabezadosRespuestas();
								descripcion('Atiende y valora las necesidades y peticiones de los usuarios internos y externos.');
								botonRadio('d23');
								
								descripcion('Considera las necesidades de los usuarios al diseñar sus servicios.');
								botonRadio('d24');
								
								descripcion('Establece diferentes canales de comunicación con el usuario para conocer sus necesidades y propuestas y responde a las mismas.');
							     botonRadio('d25');
								 
								descripcion('Brinda respuesta oportuna a las necesidades de los usuarios deacuerdo al servicio que presta');
							     botonRadio('d26');
								 
								descripcion('Conoce los deberes y derechos de los usuarios.');
							     botonRadio('d27');
							?>
							
						</div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
		<div class="content-wrapper">
          <div class="row">			
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">   
				<h3 class="">Técnicas o profesionales 20%</h3>	
				  <br> 
					<div class="row">						
					  <h4 class="">Orientación a los resultados 5%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								encabezadosRespuestas();
								descripcion('Se preocupa por enriquecer su trabajo, es objetivo y atinado en la autoevaluación de su trabajo.');
							     botonRadio('d28');
								 
								descripcion('Asume la responsabilidad de sus resultados.');
							     botonRadio('d29');
								 
								descripcion('Asume las tareas con exigencia y rigurosidad, logrando estándares de calidad superiores a los establecidos.');
							     botonRadio('d30');
								 
								descripcion('Administra los procesos establecidos para que no inter- fiera con la consecución de los resultados esperados.');
							     botonRadio('d31');
								 
								descripcion('Actua con diligencia y sentido de urgencia ante desciones importantes necesarias para la organización.');
							     botonRadio('d32');
							?>
						</div>
                    </div>                     
					<br>                 
                    <div class="row">						
					  <h4>Dominio profesional o técnico 10%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								encabezadosRespuestas();								
								descripcion('Demuestra conocimiento amplio y suficiente respecto a su especialidad  y lo aplica efectivamente en el desempeño de su trabajo');
							     botonRadio('d33');
								 
								descripcion('Se actualiza permanentemente y aporta valor a la Organización.');
							     botonRadio('d34');
								 
								descripcion('Se comunica de manera clara, efectiva, lógica y segura.');
							     botonRadio('d35');
								 
								descripcion('Aplica reglas básicas y conceptos aprendidos.');
							     botonRadio('d36');
								 
								descripcion('Asesora en su campo de conocimiento, emitiendo conceptos, juicios o propuestas ajustadas a lineamientos teóricos y técnicos.');
							     botonRadio('d37');
								 
								 descripcion('Identifica y reconoce con facilidad las causas de los problemas y sus posibes soluciones.');
							     botonRadio('d38');
							?>
						</div>
                    </div> 	
					<br>                 
                    <div class="row">						
					  <h4>Trabajo seguro 5%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								encabezadosRespuestas();
								descripcion('Ejecuta las actividades en orden lógico para asegurar el logro de los resultados en un tiempo determinado.');
							     botonRadio('d39');
								 
								descripcion('Realiza los procedimientos de acuerdo con lo establecido y atendiendo las normas de seguridad.');
							     botonRadio('d40');
								 
								descripcion('Cumple con las normas de higiene y seguridad industrial, bioseguridad, seguridad y salud en el trabajo, manejo de residuos hospitalarios y seguridad del paciente.');
							     botonRadio('d41');
								 
								 descripcion('Identifica situaciones de riesgo potencial y sugiere acciones de prevención y mejoramiento.');
							     botonRadio('d42');
								 
								descripcion('Realiza seguimiento a la información, detecta datos erróneos o ausentes y busca la información  que le permita mantener métodos de trabajo seguros y efectivos.');
							     botonRadio('d43');
								 
							?>						
							
						</div>
                    </div> 
					
                </div>
              </div>
            </div>
          </div>
        </div>
		<div class="content-wrapper">
          <div class="row">			
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">   
				<h3 class="">Personales 25%</h3>	
				  <br> 
					<div class="row">						
					  <h4 class="">Asertividad 10%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								encabezadosRespuestas();
								descripcion('Motiva en forma positiva y constructiva, resalta lo potenciable y anima a las demás personas a lograr sus metas.');
							     botonRadio('d44');
								 
								descripcion('Expresa lo que quiere y necesita decir,  en el momento, lugar, forma y persona adecuada, con el propósito de que se entienda que está sucediendo, su impacto y consecuencias.');
							     botonRadio('d45');
								 
								descripcion('Es capaz de decir no sin ser agresivo ni asumir posiciones pasivas.');
							     botonRadio('d46');
								 
								descripcion('Conoce sus derechos y reconoce el hecho que llegan hasta donde empiezan los derechos de los demás.');
							     botonRadio('d47'); 
								
							?>
						</div>
                    </div>                     
					<br>                 
                    <div class="row">						
					  <h4>Proyección institucional 5%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								encabezadosRespuestas();								
								descripcion('Fortalece la imagen institucional a través de su presentación personal.');
							     botonRadio('d48');
								 
								descripcion('Tiene un impacto positivo en los usuarios.');
							     botonRadio('d49');
								 
								descripcion('Establece relaciones satisfactorias con los clientes internos y externos.');
							     botonRadio('d50');
								 
								descripcion('Es cordial en el trato, educado y abierto a escuchar a otros.');
							     botonRadio('d51');
								 
								descripcion('Es puntual a la hora de ingreso a la institución.');
							     botonRadio('d52');
							?>
						</div>
                    </div> 	
					<br>                 
                    <div class="row">						
					  <h4>Confidencialidad 5%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								encabezadosRespuestas();
								descripcion('Evita que personas no autorizadas puedan acceder a la información que está  bajo su responsabilidad , y utiliza técnicas de control de acceso a la información.');
							     botonRadio('d53');
								 
								descripcion('Asegura la protección de la información, con base en disposiciones legales o criterios estratégicos, de información privada, tal como datos de la nómina de los empleados, documentos internos sobre estrategias, situaciones inusuales en el estado de salud de los usuarios, guías y protocolos  que son requeridos en la toma de decisiones.');
							     botonRadio('d54');
								 
								descripcion('Es capaz de diferenciar o identificar que hace público y que no.');
							     botonRadio('d55');
							?>							
						</div>
                    </div>
					<br>                 
                    <div class="row">						
					  <h4>Racionalidad en el uso de los recursos 5%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								encabezadosRespuestas();
								descripcion('Utiliza en forma óptima los recursos humanos, físicos, tecnológicos y financieros.');
							     botonRadio('d56');
								 
								descripcion('Utiliza racionalmente los servicios públicos en la institución.');
							     botonRadio('d57');
								 
								descripcion('Recicla los insumos y demás elementos, de acuerdo a las políticas institucionales.');
							     botonRadio('d58');
								 
								 descripcion('Realiza las cosas bien desde el principio, evitando reprocesos y costos de no calidad.');
							     botonRadio('d59');
								 
								descripcion('Solicita los insumos realmente necesarios para cumplir con sus tareas.');
							     botonRadio('d60');
								 
								descripcion('Cumple con sus compromisos en el tiempo señalado.');
							     botonRadio('d61');
							?>							
						</div>
                    </div>
					
                </div>
              </div>
            </div>
          </div>
        </div>

			<div>	
				<button type="submit" class="btn btn-inverse-success btn-rounded btn-fw" style="position: relative; left: 50%;">Guardar
					<i class="mdi mdi-check"></i>
				</button>
			</div>

					
		</form>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2019
              <a href="http://www.serviucis.com/" target="_blank">Serviucis S.A.S</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Recursos Humanos
            </span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <script src="../../vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>

</html>