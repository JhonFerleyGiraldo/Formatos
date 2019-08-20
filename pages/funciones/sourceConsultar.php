
<?php


	 $numeroDocumento = '12345';
	 $periodoEvaluado = '2019';
	 $tipoFormulario = 'N';
	 
	 //Consultar datos básicos del formulario 
	 $consulta = "SELECT NUM_IDEmpleado, NVA_NombreEmpleado, NVA_NombreJefe, VAR_PeriodoEva, FEC_FechaEva, CAR_TipoFormulario, NUM_ID
				 FROM TB_DETALLES
				 WHERE NUM_IDEmpleado = '$numeroDocumento' AND VAR_PeriodoEva = '$periodoEvaluado' AND CAR_TipoFormulario = '$tipoFormulario'";			 
	
	$resultado = mysql_query($consulta) or die('A error occured: Consultando datos básicos de formulario en la tabla Detalles');
	
	while ($registro = mysql_fetch_array($resultado)){
		$datosBasicos = $registro;
	}


	function encabezadosRespuestas()
	{
		$contador = 1;
		while ($contador <= 2) {
			?>
				<div class="col-4 row">															  
				  <div class="col-2">			
					 <h6>Nunca</h6>
				  </div>
				  <div class="col-2">			
					 <h6>Casi nunca</h6>
				  </div>
				  <div class="col-2">			
					 <h6>Algunas veces</h6>
				  </div>
				  <div class="col-2">			
					 <h6>Casi siempre</h6>
				  </div>
				  <div class="col-2">			
					 <h6>Siempre</h6>
				  </div>
				</div>
			<?php
			$contador = $contador + 1;
		}	
	}
	
	function descripcion($descripcion)
	{
		?>
			<br><br>
			<div class="col-4 row">
				<p class="card-description col-md-12" style="text-align: justify;">
				  <b><?php echo $descripcion; ?></b>
				</p>
			</div>
		<?php
	}
	
	//Parámetros idDetalle, idDescriptor, Evaluador, Valor
	
	function botonRadio($bIdDetalle, $bIdDescriptor, $bEvaluador, $bValor)
	{
		$contadorPpal = 1;
		while ($contadorPpal <= 2) {
			$contador = 1;
			?>
				
				<div class="col-4  row">
				  <?php
					while ($contador <= 5 ){					
						?>
						  <div class="col-2">
							<div class="form-radio">
							  <label class="form-check-label">
								<input type="radio" class="form-check-input" name="<?php if($contadorPpal == 1){echo "r$bIdDescriptor";}else{echo "d$bIdDescriptor";}?>" value="<?php if($contadorPpal == 2){echo $contador;}?>" <?php if($contadorPpal == 1){ if($bValor == $contador){echo 'checked';} }else{if ($contador == 1) { echo 'checked';}} ?> >
							  </label>
							</div>
						  </div>						
						<?php
						$contador = $contador + 1;
					}
					$contadorPpal = $contadorPpal + 1;
				  ?>
				</div>
				
			<?php
		}	
	}
	
	function construirFormulario($idDatosBasicos)
	{
		$idFormulario = 1;
		
		//Consultar Grupos del Formulario 
		$consulta = "SELECT * FROM TB_GRUPOS
					 WHERE NUM_IDFormulario = '$idFormulario'";			 
		
		$resultadoGrup = mysql_query($consulta) or die('A error occured: Consultando  ID de formulario en la tabla TB_GRUPOS');
		
		while ($registroGrup = mysql_fetch_array($resultadoGrup)){
			$gruposFormulario = $registroGrup;
			?>
				<div class="content-wrapper">
				  <div class="row">			
					<div class="col-12 grid-margin">
					  <div class="card">
						<div class="card-body">   
						<h3 class=""><?php echo "$gruposFormulario[2] $gruposFormulario[3]%"; ?></h3>							   							
							<?php 
								$idGrupo = $gruposFormulario[0];
								//Consultar Competencias del Grupo 
								$consulta = "SELECT * FROM TB_COMPETENCIAS
											 WHERE NUM_ID_Grupo = '$idGrupo'";			 
								
								$resultadoComp = mysql_query($consulta) or die('A error occured: Consultando  ID de grupo en la tabla TB_COMPETENCIAS');
								
								while ($registroComp = mysql_fetch_array($resultadoComp)){
									$competenciasGrupo = $registroComp;
									?>
										<br>
										<div class="row">
										  <h4 class=""><?php echo "$competenciasGrupo[2] $competenciasGrupo[3]%"; ?></h4 >	
											<div class="row">
												<div class="col-4 row">								
												</div>
												<?php
													encabezadosRespuestas();

													$idCompetencia = $competenciasGrupo[0];
													//Consultar descriptores de la competencia 
													$consulta = "SELECT * FROM TB_DESCRIPTORES
																 WHERE NUM_ID_Competencia = '$idCompetencia'";			 
													
													$resultadoDesc = mysql_query($consulta) or die('A error occured: Consultando  ID de competencia en la tabla TB_DESCRIPTORES');
													
													while ($registroDesc = mysql_fetch_array($resultadoDesc)){
														$descriptoresCompetencia = $registroDesc;
														
														descripcion($descriptoresCompetencia[2]);
														
														$idDescriptor = $descriptoresCompetencia[0];
														//Consultar respuesta 
														$consulta = "SELECT * FROM TB_EVALUACIONES
																	 WHERE NUM_ID_DETALLE = '$idDatosBasicos' AND NUM_ID_Descriptor = '$idDescriptor' AND CAR_Evaluador = 'A'";			 
				
														$resultadoEva = mysql_query($consulta) or die('A error occured: Consultando  ID de descriptor en la tabla TB_EVALUACIONES');
														
														while ($registroEva = mysql_fetch_array($resultadoEva)){
															$evaluacionDescriptor = $registroEva;
															//Parámetros idDetalle, idDescriptor, Evaluador, Valor
															botonRadio($datosBasicos[0], $idDescriptor, 'A',  $evaluacionDescriptor[4]);
														}															
													}	
												?>
											</div>
										</div> 
									<?php
								}
								
							?>		
						</div>
					  </div>
					</div>
				  </div>
				</div>
			<?php
		}
	}
?>