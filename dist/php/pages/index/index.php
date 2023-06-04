<?php
require "./../../functions/conexion.php";
$username = mysqli_real_escape_string($conexion,$_POST['username']);
$password = mysqli_real_escape_string($conexion,$_POST['password']);
$passwordmd5=md5($password);
$verificar_datos=mysqli_query($conexion,"SELECT U.empleado_id AS 'empleado_id',usuario_id, username,rol FROM usuarios U INNER JOIN empleados E ON U.empleado_id = E.empleado_id WHERE username='$username' AND password='$passwordmd5'") or die("Error en la consulta ".mysqli_error($conexion));
if(mysqli_num_rows($verificar_datos)==1){
    $r_verificar_datos=mysqli_fetch_array($verificar_datos);
    session_start();
    $_SESSION['empleado_id']=$r_verificar_datos['empleado_id'];
    $_SESSION['usuario_id']=$r_verificar_datos['usuario_id'];
    $_SESSION['username']=$r_verificar_datos['username'];
    $_SESSION['rol']=$r_verificar_datos['rol'];
    echo '{"estado":"true"}';
}else{
    echo '{"estado":"false"}';
}
mysqli_close($conexion);
?>