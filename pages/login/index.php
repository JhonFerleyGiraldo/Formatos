<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Evaluación-Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
    <link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
</head>
<style>
  

</style>
<body>
    <?php
      require_once("../conexion/mysql.php");
    ?>

<!--Ventana modal para error de usuario -->
<div class="container">
  
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
          Usuario o contraseña incorrectos, favor validar.
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  
</div>   




    <!-- NAVIGATION  -->
    <nav class="navbar navbar-expand-lg navbar-expand-sm navbar-expand-auto navbar-dark bg-dark">
      <img class="logo" src="../../images/logoUCI.png" alt="raee">
      <div class="collapse navbar-collapse" >
          <p class="navbar-nav ml-auto  mx-auto" style="color:#FFFFFF;font-size:20px;">EVALUACIÓN DE DESEMPEÑO</p>
      </div>
    </nav>

    <!--Formulario para login -->
    <div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
      <img class="iconoLogin" src="../../images/login/login.png" id="icon" alt="User Icon" />
    </div>

    <!-- Login Form -->
    <form id="FormLogin" method="POST">
      <input required type="text" id="login" class="fadeIn second" name="user" placeholder="login">
      <input required type="password" id="password" class="fadeIn third" name="pass" placeholder="password">
      <input type="submit" class="fadeIn fourth" value="Log In">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <!--<a class="underlineHover" href="#">Forgot Password?</a>-->
    </div>

  </div>
</div>

    <?php

        //Se valida que se ejecute el metodo post
        if(isset($_POST["user"]) && isset($_POST["pass"]))
        {
          //Llamamos la funcion login
          if(login($_POST["user"],$_POST["pass"])){
            header("location:../inicio/index.php");
          }else{
            echo "<script>$('#abrirModal').click();</script>";
          }

        }
        
        //Funcion encargada de validar el login
        function login($user,$pass){
          
          try{
            include("../conexion/mysql.php");

            $consulta="SELECT * FROM tbl_usuario WHERE usuario='$user' AND clave='$pass'";
  
            $resultado= mysqli_query($link ,$consulta)or die('Error al consultar usuario');
            
            $perfil=null;
            $contador=0;
            while ($registro = mysqli_fetch_array($resultado)){
              $perfil=$registro["perfil"];
             $contador++;
            }

            
  
            if($contador){
              session_start();
              $_SESSION["perfil"]=$perfil;
					    $_SESSION["usuario"]=$user;//se almacena la sesion del usuario 
              return true;
            }else{
              return false;
            }
          }catch(Exception $e){
            echo "ERROR" . $e->getMessage();
          }
          
        }

    ?>
     

  </body>
  <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous">
  </script>
  <script>
  
  //Eventos con JS para manejo de la pagina

  

  //esperamos la carga del documento
  $(document).ready(function() {
    
    $("#abrirModal").hide();

  });

  function errorIngreso(){
    /*$("#abrirModal").click(function(){
      alert("sdgs");
    });*/
    alert("dfsd");
  }


  </script>
</html>