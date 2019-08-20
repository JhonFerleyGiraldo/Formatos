<?php
 include '../conexion/mysql.php';
 include '../funciones/source.php';
 include('../funciones/funciones.php');
 session_start();
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
  <link rel="shortcut icon" href="../../images/favicon.png" />
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
		   
		<h2>Evaluación del desempeño cargos no directivos</h2>  
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
                           
							<select class="form-control inputs" name="documentoJefe">
							<?php
								TraerJefes($_SESSION["cargo"]);
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
							<input type="hidden" class="form-control" name="tipoFormulario" value="<?php echo tipoFormulario(2); ?>"/>
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
				<h3 class="">Organizacionales 15%</h3>	
				  <br> 
					<div class="row">						
					  <h4 class="">Trabajo en equipo 5%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								 encabezadosRespuestas();							
								 descripcion('Coopera en distintas situaciones y comparte información. Aporta sugerencias, ideas y opiniones.');
							     botonRadio('d2');
								 
								 descripcion('Planifica las propias acciones teniendo en cuenta la repercusión de las mismas para la consecución de los objetivos grupales.');
							     botonRadio('d3');
								 
								 descripcion('Establece diálogo directo con los miembros del equipo, lo que permite compartir información e ideas en condiciones de respeto y cordialidad.');
							     botonRadio('d4');
						
								 descripcion('Respeta  criterios dispares y distintas opiniones del equipo.');
							     botonRadio('d5');
								 
								 descripcion('Reconoce la interdependencia entre su trabajo y el de otros.');
							     botonRadio('d6');
							?>
						</div>
                    </div>                     
					<br>                 
                    <div class="row">						
					  <h4 >Orientación al usuario 10%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								 encabezadosRespuestas();							
								 descripcion('Atiende y valora las necesidades y peticiones de los usuarios internos y externos.');
							     botonRadio('d7');
							
								 descripcion('Considera las necesidades de los usuarios al diseñar sus servicios.');
							     botonRadio('d8');
							
								 descripcion('Da respuesta oportuna a las necesidades de los usuarios de acuerdo al servicio que presta.');
							     botonRadio('d9');
							
								 descripcion('Establece diferentes canales de comunicación con el usuario para conocer sus necesidades y propuestas y responde a las mismas.');
							     botonRadio('d10');
								 
								 descripcion('Conoce los deberes y derechos de los usuarios.');
							     botonRadio('d11');
							?>
						</div>
                    </div> 					
                </div>
              </div>
            </div>
          </div>
        </div>
		<!-- FIN DE GRUPO ORGANIZACIONALES -->
		<!-- GRUPO TÉCNICAS O PROFESIONALES -->
		<div class="content-wrapper">
          <div class="row">			
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">   
				<h3 class="">Técnicas o profesionales 45%</h3>	
				  <br> 
					<div class="row">						
					  <h4 class="">Orientación a los resultados 10%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								encabezadosRespuestas();
								descripcion('Cumple las funciones que le han sido asignadas con oportunidad, en función de estándares, objetivos y metas 
								  establecidas por la Institución.');
							     botonRadio('d12');
								 
								 descripcion('Asume la responsabilidad por sus resultados.');
							     botonRadio('d13');
								 
								descripcion('Actúa con diligencia y sentido de urgencia ante decisiones importantes, necesarias para la organización.');
							     botonRadio('d14');
								 
								descripcion('Administra los procesos establecidos para que no interfieran con la consecución de los resultados esperados.');
							     botonRadio('d15');
								 
								descripcion('Realiza todas las acciones necesarias para alcanzar los objetivos propuestos, enfrentando los obstáculos que se presenten.');
							     botonRadio('d16');
							?>
							<br><br>							
						</div>
                    </div>                     
					<br>                 
                    <div class="row">						
					  <h4 >Dominio profesional o técnico 20%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								encabezadosRespuestas();
								descripcion('Asesora en su campo de conocimiento, emitiendo conceptos, juicios o propuestas ajustados a lineamientos teóricos y técnicos.');
								botonRadio('d17');
								
								descripcion('Se comunica de manera clara, efectiva, lógica y segura.');
								botonRadio('d18');
								
								descripcion('Analiza de un modo sistemático y racional los aspectos de trabajo, basándose en la información relevante.');
							     botonRadio('d19');
								 
								descripcion('Aplica reglas básicas y conceptos aprendidos.');
							     botonRadio('d20');
								 
								descripcion('Identifica y reconoce con facilidad las causas de los problemas y sus posibles soluciones.');
							     botonRadio('d21');
							?>
							
						</div>
                    </div>
					<br> 
					<div class="row">						
					  <h4 >Trabajo seguro 15%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								encabezadosRespuestas();
								descripcion('Establece prioridades, optimiza los recursos disponibles y administra adecuadamente la información.');
							     botonRadio('d22');
								 
								descripcion('Ejecuta las actividades en orden lógico para asegurar el logro de los resultados en un tiempo determinado.');
							     botonRadio('d23');
								 
								descripcion('Realiza los procedimientos de acuerdo con lo establecido y atendiendo las normas de seguridad.');
							     botonRadio('d24');
								 
								descripcion('Cumple con las normas de higiene y seguridad industrial, bioseguridad, seguridad y salud en el trabajo, manejo de residuos hospitalarios y seguridad del paciente.');
							     botonRadio('d25');
								 
								descripcion('Identifica situaciones de riesgo potencial y sugiere acciones de prevención y mejoramiento.');
							     botonRadio('d26');
								 
								descripcion('Realiza seguimiento a la información, detecta datos erróneos o ausentes y busca la información  que le permita mantener métodos de trabajo seguros y efectivos.');
							     botonRadio('d27');
							?>
						</div>
                    </div> 
                </div>
              </div>
            </div>
          </div>
        </div>
		<!-- FIN DE GRUPO TÉCNICAS O PROFESIONALES -->
		<!-- GRUPO PERSONALES -->
		<div class="content-wrapper">
          <div class="row">			
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">   
				<h3 class="">PERSONALES 40%</h3>	
				  <br> 
					<div class="row">						
					  <h4 class="">Asertividad 15%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								encabezadosRespuestas();
								descripcion('Motiva en forma positiva y constructiva, resalta lo potenciable y anima a las demás personas a lograr sus metas.');
							     botonRadio('d28');
								 
								descripcion('Pensamiento orientado hacia el autorespeto para influir positivamente en los demás.');
							     botonRadio('d29');
								 
								descripcion('Expresa lo que quiere y necesita decir,  en el momento, lugar, forma y persona adecuada, con el propósito de que se entienda que está sucediendo, su impacto y consecuencias.');
							     botonRadio('d30');
								 
								descripcion('Es capaz de decir no sin ser agresivo ni asumir posiciones pasivas.');
							     botonRadio('d31');
								 
								descripcion('Conoce sus derechos y reconoce el hecho que llegan hasta donde empiezan los derechos de los demás.');
							     botonRadio('d32');
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
							     botonRadio('d33');
								 
								descripcion('Tiene un impacto positivo en los usuarios.');
							     botonRadio('d34');
								 
								descripcion('Establece relaciones satisfactorias con los clientes internos y externos.');
							     botonRadio('d35');
								 
								descripcion('Es cordial en el trato, educado y abierto a escuchar a otros.');
							     botonRadio('d36');
								 
								descripcion('Es puntual a la hora de ingreso a la institución.');
							     botonRadio('d37');
							?>
						</div>
                    </div> 	
					<br>                 
                    <div class="row">						
					  <h4>Confidencialidad 10%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								encabezadosRespuestas();
								descripcion('Evita que personas no autorizadas puedan acceder a la información que está  bajo su responsabilidad , y utiliza técnicas de control de acceso a la información.');
							     botonRadio('d38');
								 
								descripcion('Asegura la protección de la información, con base en disposiciones legales o criterios estratégicos, 
								  de información privada, tal como datos de la nómina de los empleados, documentos internos sobre estrategias, 
								  situaciones inusuales en el estado de salud de los usuarios, guías y protocolos  que son requeridos en la toma 
								  de decisiones. ');
							     botonRadio('d39');
								 
								descripcion('Es capaz de diferenciar o identificar que hace público y que no.');
							     botonRadio('d40');
							?>							
						</div>
                    </div> 
					<br>                 
                    <div class="row">						
					  <h4>Racionalidad en el uso de los recursos 10%</h4 >	
						<div class="row">
							<div class="col-6 row">								
							</div>
							<?php
								encabezadosRespuestas();
								descripcion('Utiliza en forma óptima los recursos humanos, físicos, tecnológicos y financieros.');
							     botonRadio('d41');
								 
								descripcion('Utiliza racionalmente los servicios públicos en la institución.');
							     botonRadio('d42');
								 
								descripcion('Recicla los insumos y demás elementos, de acuerdo a las políticas institucionales.');
							     botonRadio('d43');
								 
								descripcion('Realiza las cosas bien desde el principio, evitando reprocesos y costos de no calidad.');
							     botonRadio('d44');
								 
								descripcion('Solicita los insumos realmente necesarios para cumplir con sus tareas.');
							     botonRadio('d45');
								 
								descripcion('Cumple con sus compromisos en el tiempo señalado.');
							     botonRadio('d46');
							?>
						</div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
		<!-- FIN DE GRUPO PERSONALES -->

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