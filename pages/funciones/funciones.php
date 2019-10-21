<?php
    function TraerJefes($cargoUsuario,$documentoUsuario){
        include("../conexion/mysql.php");
        
        $codigoCargoJefe=null;

        $consulta="SELECT jefeInmediato FROM tbl_persona WHERE cargo='$cargoUsuario' AND documento='$documentoUsuario'";
        $resultado=mysqli_query($link,$consulta);

        while($valores=mysqli_fetch_array($resultado)){
            $codigoCargoJefe=$valores["jefeInmediato"];
        }
        //echo "<script>alert('$codigoCargoJefe')</script>"; 
        
        try{
            $consulta="SELECT * FROM tbl_persona WHERE cargo='$codigoCargoJefe'";
            
            $resultado= mysqli_query($link ,$consulta);
                    
            while ($valores = mysqli_fetch_array($resultado)) {
                                    
            echo '<option value="'.$valores['documento'].'">'.$valores['nombres']. ' ' . $valores["apellidos"] . '</option>';
            }            

        }catch(Exception $e){
            echo "Error " . $e->getMessage();
        }
    }


    function ListaPeriodos(){

        try{

            include("../conexion/mysql.php");

            $consulta="SELECT * FROM tbl_periodo";
            
            $resultado= mysqli_query($link ,$consulta);
            
            $anioActual=date('Y');
            

            $select="";

            while ($valores = mysqli_fetch_array($resultado)) {
                if($valores["descripcion"]==$anioActual){
                    $select="selected";
                }else{
                    $select="disabled";
                }    
                
            echo '<option  ' . $select . ' value="'.$valores['id'].'">'.$valores['descripcion'] . '</option>';
            } 
        }catch(Exception $e){
            echo "Error " . $e->getMessage();
        }

    }

    function getIdDetalleEvaluacion($usuario,$periodo){
        try{
            
            include("../conexion/mysql.php");

            $consulta="SELECT id FROM tbl_detalle WHERE empleado='$usuario' AND periodo='$periodo'";
            
            $resultado= mysqli_query($link ,$consulta);
                   
            while ($valores = mysqli_fetch_array($resultado)) {
                return $valores["id"];
            }            

        }catch(Exception $e){
            echo "Error " . $e->getMessage();
        }
    }

    /*Funcion que trae el codigo del periodo */
    function getCodigoPeriodo($periodo){
        try{

            include("../conexion/mysql.php");

            $consulta="SELECT id FROM tbl_periodo WHERE descripcion='$periodo'";
            
            $resultado= mysqli_query($link ,$consulta);
                   
            while ($valores = mysqli_fetch_array($resultado)) {
       
                return $valores["id"];

            }            

        }catch(Exception $e){
            echo "Error " . $e->getMessage();
        } 
    }


    /*Trae los datyos del dormulario */
    function tipoFormulario($tipo){
        try{
            include("../conexion/mysql.php");

            $consulta="SELECT * FROM tbl_formulariotipocargo WHERE id='$tipo'";
            
            $resultado= mysqli_query($link ,$consulta);
                    
            while ($valores = mysqli_fetch_array($resultado)) {
                                    
            echo $valores["descripcion"];
            }            

        }catch(Exception $e){
            echo "Error " . $e->getMessage();
        }
    }

    /*Funcion que trae el codigo del usuario */
    function obtenerCodigoUsuario($documento){
        try{
            include("../conexion/mysql.php");

            $consulta="SELECT * FROM tbl_usuario WHERE usuario='$documento'";
            
            $resultado= mysqli_query($link ,$consulta);

            $codUsuario=null;
                    
            while ($valores = mysqli_fetch_array($resultado)) {
                                    
            $codUsuario= $valores["id"];

            }        
            
            return $codUsuario;

        }catch(Exception $e){
            echo "Error " . $e->getMessage();
        }
    }

    /*Funcion encargada de traer la cantidad de descriptores */
    function getCantidadDescriptores(){
        try{
            include("../conexion/mysql.php");

            $consulta="SELECT * FROM tbl_descriptor";
            
            $resultado= mysqli_query($link ,$consulta);

            $cont=0;
                    
            while ($valores = mysqli_fetch_array($resultado)) {
                                    
            $cont++;

            }        
            
            return $cont;

        }catch(Exception $e){
            echo "Error " . $e->getMessage();
        }
    }

    /*Funcion encargada de calidar si la persina ya realizo la evaluacion este periodo */
    function ValidarEvaluacionPorPeriodo($usuario,$periodoActual){
        try{
            include("../conexion/mysql.php");

            $consulta="SELECT * FROM tbl_detalle WHERE empleado='$usuario' AND YEAR(fechaEva)='$periodoActual'";
            
            $resultado= mysqli_query($link ,$consulta);

            $bandera=false;
                    
            while ($valores = mysqli_fetch_array($resultado)) {
                                    
            $bandera=true;

            }        
            
            return $bandera;

        }catch(Exception $e){
            echo "Error " . $e->getMessage();
            return false;
        }
    }

    /*Funcion encargada de traer el nombre del cargo */
    function getNombreCargo($codigoCargo){
        try{
            include("../conexion/mysql.php");

            $consulta="SELECT descripcion FROM tbl_cargo WHERE id='$codigoCargo'";
            
            $resultado= mysqli_query($link ,$consulta);

            $nombre="";
                    
            while ($valores = mysqli_fetch_array($resultado)) {
                                    
            $nombre=$valores["descripcion"];

            }        
            
            return $nombre;

        }catch(Exception $e){
            echo "Error " . $e->getMessage();
            return false;
        }
    }

    /*Funcion encargada de traer las evaluaciones
    que debe revisar el jefe a cargo */
    function getListadoEvaluacionesxJefe($jefe){
        try{
            include("../conexion/mysql.php");

            $consulta=" SELECT 	
                            D.id as 'id',
                            P.documento as 'documento',
                            concat(P.nombres,' ',P.apellidos) as 'persona',
                            C.descripcion as 'cargo',
                            PE.id as 'codPeriodo',
                            PE.descripcion as 'periodo',
                            D.fechaEva as 'fecha',
                            D.fechaUltima  as 'fechaU',
                            D.estado as 'estado',
                            D.resultado as 'resultado'
                        FROM 	tbl_detalle as D inner join tbl_evaluacion as E
                                ON E.detalle=D.id
                                inner join tbl_usuario as U on D.empleado=U.id
                                inner join tbl_persona as P on U.usuario=P.documento
                                inner join tbl_cargo as C on C.id=P.cargo
                                inner join tbl_periodo as PE on D.periodo=PE.id
                        WHERE 	D.jefe=$jefe
                            /*AND   D.fechaUltima IS NULL*/      
                        GROUP BY D.id
                        ORDER BY D.fechaEva desc";
            
            $resultado= mysqli_query($link ,$consulta);

            return $resultado;
                    

        }catch(Exception $e){
            echo "Error " . $e->getMessage();
            return false;
        }

    }


    /*
        Funcion encargada de validar si la persona es directiva o no
    */
    function GetIsDirectivo($documento){
        try{
            include("../conexion/mysql.php");

            $consulta=" SELECT 	
                            isDirectivo           
                        FROM 	tbl_persona
                        WHERE 
                            documento='$documento'
                            ";
            
            $resultado= mysqli_query($link ,$consulta);
            
            $bandera="";
                    
            while ($valores = mysqli_fetch_array($resultado)) {
                                    
            $bandera=$valores["isDirectivo"];

            }

            return $bandera;
                    

        }catch(Exception $e){
            echo "Error " . $e->getMessage();
            return false;
        }
    }

    /*Funcion encargada de mostrar el porcentaje del descriptor */
    function GetPorcentajeDescriptor($descriptor){

        try{
            include("../conexion/mysql.php");

            $consulta=" SELECT COM.id,COM.porcentaje
                        FROM tbl_descriptor AS DP INNER JOIN tbl_competencia AS COM ON DP.competencia=COM.id
                        WHERE DP.id='$descriptor'
                        GROUP BY COM.id,COM.porcentaje
                            ";
            
            $resultado= mysqli_query($link ,$consulta);
           
            
            $competencia=0;
            $porcentajeCompetencia=0;
                    
            while ($valores = mysqli_fetch_array($resultado)) {
                                    
                $competencia=$valores["id"];
                $porcentajeCompetencia=$valores["porcentaje"];
                

            }


            $consulta=" SELECT COUNT(DP.id) AS 'cantidadDescriptores'
                        FROM tbl_descriptor AS DP INNER JOIN tbl_competencia AS COM ON DP.competencia=COM.id
                        WHERE COM.id='$competencia'

                            ";
            
            $resultado= mysqli_query($link ,$consulta);


            $cantidadDescriptores=0;
                    
            while ($valores = mysqli_fetch_array($resultado)) {
                                    
                $cantidadDescriptores=$valores["cantidadDescriptores"];
                

            }

           

            return ($porcentajeCompetencia/$cantidadDescriptores);
                    

        }catch(Exception $e){
            echo "Error " . $e->getMessage();
            return false;
        }

    }

    /*Funcion encargada de traer el valor calificado
    para cada descriptor */
    function GetValorCalificadoDescriptor($detalle,$descriptor,$evaluador){
        try{

            include("../conexion/mysql.php");

            $consulta="CALL SP_consultarResultadoEvaluacionXdescriptor('$detalle','$descriptor','$evaluador')";

            $resultado= mysqli_query($link ,$consulta);

            $valor=0;

            while ($valores = mysqli_fetch_array($resultado)) {

                $valor=$valores["valor"];
                

            }

            return $valor;

        }catch(Exception $e){
            echo "Error " . $e->getMessage();
            return false;
        }
    }

    /*Funcion usada para traer el porcentaje de calificacion por
    cada competencia */
    function GetPorcentajeCalificadoPorCompetencia($detalle,$competencia){
        try{

            include("../conexion/mysql.php");

            $consulta="CALL SP_PorcentajeCalificadoPorCompetencia('$detalle','$competencia')";

            $resultado= mysqli_query($link ,$consulta);

            $valor=0;

            while ($valores = mysqli_fetch_array($resultado)) {

                $valor=$valores["porcentajeEvaluado"];
                

            }

            return $valor;

        }catch(Exception $e){
            echo "Error " . $e->getMessage();
            return false;
        }
    }

    /*Funcion encargada de traer el encabezado de la tabla para comprobante
    de la evaluacion
     */
    function GetEncabezadoEvaluacion($detalle){
        try{

            include("../conexion/mysql.php");

            $consulta="CALL SP_consultarDatosEncabezadoEvaluacion('$detalle')";

            $resultado= mysqli_query($link ,$consulta);

            return $resultado;

        }catch(Exception $e){
            echo "Error " . $e->getMessage();
            return false;
        }
    }

    /*Funcion enfargada de traer la ultima fecha en la que la persona realizo la evaluacion*/
    function GetFechaUltimaEvaluacion($detalle){
        try{

            include("../conexion/mysql.php");

            $consulta=" SELECT		DE.fechaEva AS 'fecha'
                        FROM		tbl_detalle AS DE
                        WHERE DE.id<>'$detalle'
                        ORDER BY 	DE.fechaUltima desc
                        LIMIT 1";

            $resultado= mysqli_query($link ,$consulta);
        

            $valor=0;

            while ($valores = mysqli_fetch_array($resultado)) {

                $valor=$valores["fecha"];
                

            }

            return $valor;


        }catch(Exception $e){
            echo "Error " . $e->getMessage();
            return false;
        }
    }


?>