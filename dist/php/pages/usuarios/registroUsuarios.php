<?php
require './../../functions/conexion.php';
$username = mysqli_real_escape_string($conexion,$_POST['username']);
$empleado_id = mysqli_real_escape_string($conexion,$_POST['empleado_id']);
$password = mysqli_real_escape_string($conexion,$_POST['password']);
$rpassword = mysqli_real_escape_string($conexion,$_POST['rpassword']);

$verificar_username= mysqli_query($conexion,"SELECT username FROM usuarios WHERE username ='$username'") or die("Error en la conexion ".mysqli_error($conexion));
if(mysqli_num_rows($verificar_username) == 1){
    echo '{"error":"este username ya esta en uso"}';
}else{
    if($password == $rpassword){
        $md5password = md5($password);
        $insertar_usuario = mysqli_query($conexion,"INSERT INTO usuarios(empleado_id,username,password)  VALUES($empleado_id,'$username','$md5password')") or die("Error en la consulta ".mysqli_error($conexion));
        echo json_encode($insertar_usuario);
    }else{
        echo '{"error":"las contrasñas son distintas"}';
    }
}


?>
