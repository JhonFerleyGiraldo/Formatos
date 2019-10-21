
<?php

include("../conexion/mysql.php");
include("../funciones/funciones.php");

 $numeroDocumento = $_GET["usuario"];
 $codigoUsuario=obtenerCodigoUsuario($numeroDocumento);
 $periodoEvaluado =date('Y');


 $tipoFormulario;
 //Validamos si es directivo, para saber que formulario es
 if(GetIsDirectivo($numeroDocumento)){
    $tipoFormulario = 1;
  }else{
    $tipoFormulario = 2;
  }
 

    $codigoPeriodo=getCodigoPeriodo($periodoEvaluado);
    $idDetalle=getIdDetalleEvaluacion($codigoUsuario,$codigoPeriodo);
  
    echo "Docume " . $numeroDocumento;
    echo " cod usu " . $codigoUsuario;
    echo "Per " . $periodoEvaluado;
    echo " tipo " . $tipoFormulario;
    echo "detalle " .$idDetalle;

 
 //Consultar datos básicos del formulario 
 $consulta = "	SELECT empleado, jefe, periodo, fechaEva, fechaUltima, formularioTipoCargo,id
                 FROM tbl_detalle
                 WHERE id='$idDetalle' AND empleado = '$codigoUsuario' AND periodo = '$codigoPeriodo' AND formularioTipoCargo = '$tipoFormulario'";			 

$resultado = mysqli_query($link,$consulta) or die('A error occured: Consultando datos básicos de formulario en la tabla Detalles');

while ($registro = mysqli_fetch_array($resultado)){
    $datosBasicos = $registro;
    
}




function encabezadosRespuestas()
{
  
  $contador = 1;
  while ($contador <= 2) {
	  
		?>
		  <div class="col-4 row">		
			<?php if($contador==1){ ?>
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
			<?php } ?>
		  </div>
		<?php
	  
    $contador = $contador + 1;
  }	
        
}

function descripcion($descripcion)
{
    ?>
        <br><br><br><br>
        <div class="col-4 row">
            <p class="card-description col-md-12" style="text-align: justify; font-weight: 1;">
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
                        <div class="form-radio form-radio-flat">
                          <label class="form-check-label">
							<?php if($contadorPpal == 1) { ?>
                            <input  type="radio" class="form-check-input" style="border-color:#000000;" 	
                                                                            name="<?php if($contadorPpal == 1){echo "r$bIdDescriptor";}else{echo "d$bIdDescriptor";}?>"
                                                                            value="<?php if($contadorPpal == 2){echo $contador;}?>" 
                                                                            
                                                                            <?php
                                                                                //se deshabilita las respuestas de el empleado
                                                                                if($contadorPpal==1){
                                                                                    echo "disabled";
                                                                                    }
                                                                            ?>

                                                                            <?php
                                                                            
                                                                                if($contadorPpal == 1){
                                                                                    if($bValor == $contador){
                                                                                        echo 'checked';
                                                                                        
                                                                                    } 
                                                                                }else{
                                                                                    if ($contador == 1){ 
                                                                                        echo 'checked';
                                                                                    }
                                                                                } 
                                                                                
                                                                            ?>
                                                                            
                            >
							<?php } ?>
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



    include("../conexion/mysql.php");

    $idFormulario;
 //Validamos si es directivo, para saber que formulario es
 if(!GetIsDirectivo($_GET["usuario"])){
    $idFormulario = 1;
  }else{
    $idFormulario = 2;
  }
 
    
    //Consultar Grupos del Formulario 
    $consulta = "SELECT * FROM tbl_grupo
                 WHERE formulario = '$idFormulario'";			 
    
    $resultadoGrup = mysqli_query($link,$consulta) or die('A error occured: Consultando  ID de formulario en la tabla TB_GRUPOS');
    
    while ($registroGrup = mysqli_fetch_array($resultadoGrup)){
        
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
                            $consulta = "SELECT * FROM tbl_competencia
                                         WHERE grupo = '$idGrupo'";			 
                            
                            $resultadoComp = mysqli_query($link,$consulta) or die('A error occured: Consultando  ID de grupo en la tabla TB_COMPETENCIAS');
                            
                            while ($registroComp = mysqli_fetch_array($resultadoComp)){
                                
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
                                                $consulta = "SELECT * FROM tbl_descriptor
                                                             WHERE competencia = '$idCompetencia'";			 
                                                
                                                $resultadoDesc = mysqli_query($link,$consulta) or die('A error occured: Consultando  ID de competencia en la tabla TB_DESCRIPTORES');
                                                
                                                while ($registroDesc = mysqli_fetch_array($resultadoDesc)){
                                                    $descriptoresCompetencia = $registroDesc;
                                                    
                                                    descripcion($descriptoresCompetencia[2]);
                                                    
                                                    $idDescriptor = $descriptoresCompetencia[0];
													
                                                    //Consultar respuesta 
                                                    $consulta = "SELECT * FROM tbl_evaluacion
                                                                 WHERE detalle = '$idDatosBasicos' AND descriptor = '$idDescriptor' AND evaluador = 1";			 
            
                                                    $resultadoEva = mysqli_query($link,$consulta) or die('A error occured: Consultando  ID de descriptor en la tabla TB_EVALUACIONES');
                                                    
                                                    while ($registroEva = mysqli_fetch_array($resultadoEva)){
														
                                                        $evaluacionDescriptor = $registroEva;
                                                        //Parámetros idDetalle, idDescriptor, Evaluador, Valor
                                                        botonRadio($idDatosBasicos, $idDescriptor+1, 'A',  $evaluacionDescriptor[4]);
														
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



function getDocumentoUsuario($codigoUsuario){
    include("../conexion/mysql.php");
    $consulta = "	SELECT usuario
                 FROM tbl_usuario
                 WHERE id = '$codigoUsuario' ";			 

    $resultado = mysqli_query($link,$consulta) or die('A error occured: Consultando cedula usuario');
    
    while ($registro = mysqli_fetch_array($resultado)){
        $cedula = $registro;		
    }
    

    return $cedula[0];
}

function getNombreUsuario($cedula){
    include("../conexion/mysql.php");
    $consulta = "	SELECT nombres,apellidos
                 FROM tbl_persona
                 WHERE documento = '$cedula' ";			 

    $resultado = mysqli_query($link,$consulta) or die('A error occured: Consultando cedula usuario');
        
    while ($registro = mysqli_fetch_array($resultado)){
        $nombre = $registro[0];		
        $apellido = $registro[1];
    }
    

    return $nombre . ' ' . $apellido;
}



function getPeriodo($codigoPeriodo){
    include("../conexion/mysql.php");
    $consulta = "	SELECT descripcion
                 FROM tbl_periodo
                 WHERE id = '$codigoPeriodo' ";			 

    $resultado = mysqli_query($link,$consulta) or die('A error occured: Consultando cedula usuario');
        
    while ($registro = mysqli_fetch_array($resultado)){
        $periodo = $registro[0];		
        
    }
    

    return $periodo;
}
?>