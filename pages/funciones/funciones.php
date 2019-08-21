<?php

    

    //funciones php

    function TraerJefes($cargoUsuario){
        include("../conexion/mysql.php");
        
        $codigoCargoJefe=null;

        switch($cargoUsuario){

            case 1:
                $codigoCargoJefe=1;
            break;
            default:
                echo "ERROR EN LA SELECCION DE CARGO";
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

?>