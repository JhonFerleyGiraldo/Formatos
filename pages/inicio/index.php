<?php

    session_start();

    if(!isset($_SESSION["usuario"])){
        header("location:../login/index.php");
    }

    require_once("../conexion/mysql.php");

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
        echo $_SESSION["perfil"];
        //Validamos si el usuario es 3 ya que no califica a nadie
        if($_SESSION["perfil"]==3){
            header("location:../formularios/evaluacionNoDirectivos.php");
        }

    }    


?>