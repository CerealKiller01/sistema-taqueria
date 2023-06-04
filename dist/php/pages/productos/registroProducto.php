<?php
require './../../functions/conexion.php';
if(!empty($_FILES["file"]["type"])){
    $nombreImagen=time().'_'.$_FILES['file']['name'];
    $validarFormato=array("jpeg","jpg","png");
    $nombreTemporal = explode(".",$_FILES["file"]["name"]);
    $formatoImagen = end($nombreTemporal);
    if((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && in_array($formatoImagen, $validarFormato)){
        $rutaPrincipal = $_FILES["file"]["tmp_name"];
        $rutaObjetivo ="./../../../img/productos/".$nombreImagen;
        if(move_uploaded_file($rutaPrincipal,$rutaObjetivo)){
            $imagenSubida = $nombreImagen;
        }
    }
}
$nombre = mysqli_real_escape_string($conexion,$_POST['nombre']);
$precio = mysqli_real_escape_string($conexion,$_POST['precio']);
$categoria_producto_id = mysqli_real_escape_string($conexion,$_POST['categoria']);
$cantidad = mysqli_real_escape_string($conexion,$_POST['cantidad']);
$registrar_producto=mysqli_query($conexion,"INSERT INTO productos (categoria_producto_id,nombre,imagen,precio,cantidad) VALUES ($categoria_producto_id,'$nombre','$imagenSubida',$precio,$cantidad)") or die("Error en la consulta ".mysqli_error($conexion));
echo json_encode($registrar_producto)
?>