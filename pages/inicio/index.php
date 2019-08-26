<?php
session_start();
		include("../conexion/mysql.php");
		include("../funciones/funciones.php"); 
if(!isset($_SESSION["usuario"])){
        header("location:../login/index.php");
    }

	$documento=$_SESSION["usuario"];

    $consulta="SELECT * FROM tbl_persona WHERE documento='$documento'";

    $resultado= mysqli_query($link ,$consulta)or die('Error al consultar usuario');

    $cargo=null;
    $nombreCompleto=null;

    while ($registro = mysqli_fetch_array($resultado)){
        $cargo=$registro["cargo"];
        $nombreCompleto=$registro["nombres"] . " " . $registro["apellidos"];
    }

    $_SESSION["cargo"]=$cargo;
    $_SESSION["nombreUsuario"]=$nombreCompleto;

    enviarInicioApp($documento);
	
    function enviarInicioApp($usuario){
        //Validamos si el usuario es 3 ya que no califica a nadie
        if($_SESSION["perfil"]==3){			
            
				echo "<script type='text/javascript'>location.href='../formularios/evaluacionNoDirectivos.php';</script>";

            
            //si el perfil es 2 es porque es un jefe
        }else if($_SESSION["perfil"]==2){
			//include("../formularios/inicioJefe.php");
			header("location:../formularios/inicioJefe.php");
        }

    }    


?>
