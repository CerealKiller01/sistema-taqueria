<?php
require './../../functions/conexion.php';
$nombre=mysqli_real_escape_string($conexion,$_POST['nombre']);
$apellidoPaterno=mysqli_real_escape_string($conexion,$_POST['apellidoPaterno']);
$apellidoMaterno=mysqli_real_escape_string($conexion,$_POST['apellidoMaterno']);
$telefono=mysqli_real_escape_string($conexion,$_POST['telefono']);
$rol=mysqli_real_escape_string($conexion,$_POST['rol']);

$registro_empleado = mysqli_query($conexion, "INSERT INTO empleados(nombre,apellido_paterno,apellido_materno,telefono,rol) values ('$nombre','$apellidoPaterno','$apellidoMaterno','$telefono',$rol)");
echo json_encode($registro_empleado);



?>