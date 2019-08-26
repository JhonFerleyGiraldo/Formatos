<?php
    function TraerJefes($cargoUsuario){
        include("../conexion/mysql.php");
        
        $codigoCargoJefe=null;

        switch($cargoUsuario){

            case 1:
                $codigoCargoJefe=2;
            break;
            case 2:
                $codigoCargoJefe=3;
            break;
        }
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
                    $select="";
                }    
                
            echo '<option  ' . $select . ' value="'.$valores['id'].'">'.$valores['descripcion'] . '</option>';
            } 
        }catch(Exception $e){
            echo "Error " . $e->getMessage();
        }

    }


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
                            D.fechaUltima  as 'estado'           
                        FROM 	tbl_detalle as D inner join tbl_evaluacion as E
                                ON E.detalle=D.id
                                inner join tbl_usuario as U on D.empleado=U.id
                                inner join tbl_persona as P on U.usuario=P.documento
                                inner join tbl_cargo as C on C.id=P.cargo
                                inner join tbl_periodo as PE on D.periodo=PE.id
                        WHERE 	D.jefe=$jefe        
                        GROUP BY D.id
                        ORDER BY D.fechaEva desc";
            
            $resultado= mysqli_query($link ,$consulta);

            return $resultado;
                    

        }catch(Exception $e){
            echo "Error " . $e->getMessage();
            return false;
        }

    }


?>