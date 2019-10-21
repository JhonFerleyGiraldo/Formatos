<?php
session_start();
 include '../conexion/mysql.php';
 include '../funciones/sourceVisualizar.php';
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

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      
      <div class="navbar-menu-wrapper d-flex align-items-center"> 
	
		<h2>EVALUACIÓN DEL DESEMPEÑO CARGOS NO DIRECTIVOS</h2>       

      </div>
	  
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
    
      <!-- partial -->
      <div class="main-panel col-lg-12">
	
		<!-- CABECERA AUTOEVALUACION -->
        <div class="content-wrapper">
          <div class="row">    
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h3 class="">Evaluador o Jefe Inmediato</h3>
				  <br>
				  <p class="col-md-12" style="text-align: justify;">
                      Estimado evaluador, esta evaluación nos permitirá establecer el nivel de desempeño en las labores asignadas del trabajador 
					  y si es pertinente establecer un plan de mejora con él.  Por esto, es importante que efectúe una valoración 
					  honesta de cada uno de los ítem señalados utilizando el criterio: NUNCA, CASI NUNCA, ALGUNAS VECES, CASI SIEMPRE o SIEMPRE. 
					  Por favor seleccione la casilla que corresponde en cada item, de acuerdo a lo que usted considera que aplica para cada aspecto.
                  </p>
				  <br>               
                    <div class="row">
					  <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Número de Documento:</label>
                          <div class="col-sm-5">
                            <input type="text" class="form-control" readonly name="numeroDocumento" value="<?php echo getDocumentoUsuario($datosBasicos[0]);  ?>"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Nombre completo del trabajador:</label>
                          <div class="col-sm-5">
                            <input type="text" class="form-control" readonly name="nombreCompleto" value="<?php echo getNombreUsuario(getDocumentoUsuario($datosBasicos[0])); ?>"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Nombre completo del evaluador y/o jefe inmediato:</label>
                          <div class="col-sm-5">
                            <input type="text" class="form-control" readonly name="nombreJefe" value="<?php echo  getNombreUsuario(getDocumentoUsuario($datosBasicos[1]));  ?>"/>
                          </div>
                        </div>
                      </div>
					  <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Fecha de evaluación</label>
                          <div class="col-sm-8">
                            <input class="form-control" name="fechaEvaluacion" readonly value="<?php echo $datosBasicos[3]; ?>"/>
                          </div>
                        </div>
                      </div>
					  <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Periodo evaluado:</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" readonly name="periodoEvaluado" value="<?php echo getPeriodo($datosBasicos[2]); ?>"/>
							<input type="hidden" class="form-control" name="tipoFormulario" value="N"/>
							<input type="hidden" class="form-control" name="evaluador" value="2"/>
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
		
		
		<?php
			construirFormulario($datosBasicos[6]);
		?>

<?php if($_SESSION["perfil"]==1 || $_SESSION["perfil"]==2): ?>
    <div>	
			<a href="../formularios/inicioJefe.php"><button type="submit" class="btn btn-inverse-success btn-rounded btn-fw" style="position: relative; left: 50%;">Cerrar consulta
				<i class="mdi mdi-check"></i>
			</button></a>
		</div>
    <?php else: ?>

    <div>	
			<a href="../login/index.php"><button type="submit" class="btn btn-inverse-success btn-rounded btn-fw" style="position: relative; left: 50%;">Cerrar consulta
				<i class="mdi mdi-check"></i>
			</button></a>
		</div>

    <?php endif;?>

					

        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2019
              <a href="http://www.serviucis.com/" target="_blank">Serviucis S.A.S</a>. All rights reserved.  &nbsp;&nbsp;&nbsp; Desarrollado por el área de sistemas.</span>
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