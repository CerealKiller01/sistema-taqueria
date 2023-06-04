<?php
require './../../functions/conexion.php';
$nombre_categoria=mysqli_real_escape_string($conexion,$_POST['nombre_categoria']);
$registro_categoria=mysqli_query($conexion,"INSERT INTO categoria_productos (nombre_categoria) VALUES ('$nombre_categoria') ") or die("Error en la consulta ".mysqli_error($conexion));
echo json_encode($registro_categoria);
?>