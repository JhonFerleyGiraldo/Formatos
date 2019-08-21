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
    }



$("#cerrarModal").click(function(){
	window.location.href="../login/index.php";
});

</script>
</html>

<?php

    session_start();

    if(!isset($_SESSION["usuario"])){
        header("location:../login/index.php");
    }

    require_once("../conexion/mysql.php");
    require_once("../funciones/funciones.php");

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
            /*if(ValidarEvaluacionPorPeriodo(obtenerCodigoUsuario($usuario),date('Y'))){
                echo "  <script>
                            
                            abrirModal();
                        </script>";
            }else{*/
                header("location:../formularios/evaluacionNoDirectivos.php");
            //}
            //si el perfil es 2 es porque es un jefe
        }else if($_SESSION["perfil"]==2){
          header("location:../formularios/inicioJefe.php");
        }

    }    


?>



