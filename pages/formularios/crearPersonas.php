<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
    
    
    
    
    
    
    <table cellspacing="10">
    <h4>Persona</h4>
        <tr>
            <td><label>Documento</label></td>
            <td><input type="text" name="documento" required></td>
        </tr>
        <tr>
            <td><label>tipo_doc</label></td>
            <td><select name="tipo_doc">
                <option value="1">CC</option>
                <option value="2">TI</option>
                </select></td>
        </tr>
        <tr>
            <td><label>Nombre</label></td>
            <td><input type="text" name="nombre" required></td>
        </tr>
        <tr>
            <td><label>Apellido</label></td>
            <td><input type="text" name="apellido" required></td>
        </tr>
        <tr>
            <td><label>cargo</label></td>
            <td>
                <select name="cargo">
                    <?php getCargo();?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label>Sede <p style="color:red;"> CAMBIAR.... </p></label></td>
            <td><select name="sede">
                <option value="1">Rionegro</option>
                <option value="2">Apartado</option>
                </select></td>
        </tr>
        <tr>
            <td><label>Cargo Jefe</label></td>
            <td><select name="cargoJefe">
            <?php getCargo();?>
                </select></td>
        </tr>
        <tr>
            <td><label>Es Diretivo?</label></td>
            <td><input type="checkbox" name="isDirectivo"></td>
        </tr>
        <tr>
            <td><label>Perfil<p style="color:red;"> CAMBIAR.... </p></label></td>
            <td><select name="perfil">
                <option value="1">Admin</option>
                <option selected value="2">Jefe</option>
                <option  value="3">Usuario</option>
                </select></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="guardar" name="formulario"></td>
            
        </tr>

        <br>
        
    </table>
    </form>
</body>
</html>

<?php

   

    function getCargo(){
        include("../conexion/mysql.php");
        $consulta="select * from tbl_cargo ORDER BY descripcion ASC";
        $resultado=mysqli_query($link,$consulta);

        while($registro=mysqli_fetch_array($resultado)){
            echo    '<option value="'. $registro['id'].'">'.$registro["descripcion"]
                    .'</option>';
        }
    }

    if(isset($_POST["formulario"])){
        include("../conexion/mysql.php");

            $documento=$_POST["documento"];
            $tipo_doc=$_POST["tipo_doc"];
            $nombre=mb_strtoupper($_POST["nombre"]);
            $apellido=mb_strtoupper($_POST["apellido"]);
            $cargo=$_POST["cargo"];
            $sede=$_POST["sede"];
            $cargo_jefe=$_POST["cargoJefe"];
            $es_directivo=false;
            if(isset($_POST["isDirectivo"])){
                $es_directivo=$_POST["isDirectivo"];
            }
            $perfil=$_POST["perfil"];
            /*echo $documento."<br>";
            echo $tipo_doc."<br>";
            echo $nombre."<br>";
            echo $apellido."<br>";
            echo $cargo."<br>";
            echo $sede."<br>";
            echo $cargo_jefe."<br>";
            echo $es_directivo."<br>";
            echo $perfil."<br>";*/

            $s = str_replace('.', '', $documento);

                if($es_directivo==true){
                    $directivo=1;
                }else{
                    $directivo=0;
                }


        $consulta1="insert into tbl_persona values ('$s','$tipo_doc','$nombre','$apellido','$cargo','$sede',null,'$cargo_jefe','$directivo')";
        $resultado1=mysqli_query($link,$consulta1) or die ("<p style='color:red;'>no se puede insertar persona</p>");

        $consulta2="insert into tbl_usuario(usuario,clave,perfil) values ('$s',123,'$perfil')";
        $resultado2=mysqli_query($link,$consulta2) or die ("<p style='color:red;'>no se puede insertar usuario</p>");

        echo "datos insertados para la persona ".$nombre." ".$apellido;
    }


    

?>