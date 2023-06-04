<?php
require './../../functions/conexion.php';
switch($_GET['accion']){
    // *Listar datos de la tabla categoria_productos
    case 'listar':
        $listar_categorias=mysqli_query($conexion,"SELECT * FROM categoria_productos") or die("Error en la consulta ".mysqli_error($conexion));
        $r_listar_categorias=mysqli_fetch_all($listar_categorias,MYSQLI_ASSOC);
        echo json_encode($r_listar_categorias);
        break;
    // *Borrar un registro  de categoria_productos
    case 'borrar':
        $categoria_producto_id=mysqli_real_escape_string($conexion,$_GET['categoria_producto_id']);
        $borrar_categoria=mysqli_query($conexion,"DELETE FROM categoria_productos WHERE categoria_producto_id = $categoria_producto_id") or die("Error en la consulta ".mysqli_error($conexion));
        echo json_encode($borrar_categoria);
        break;
    // *Cargar datos de categoria
    case 'cargar':
        $categoria_producto_id=mysqli_real_escape_string($conexion,$_GET['categoria_producto_id']);
        $cargar_categoria=mysqli_query($conexion,"SELECT * FROM  categoria_productos WHERE categoria_producto_id = $categoria_producto_id") or die("Error en la consulta ".mysqli_error($conexion));
        $r_cargar_categoria=mysqli_fetch_all($cargar_categoria,MYSQLI_ASSOC);
        echo json_encode($r_cargar_categoria);
        break;
    // *Actualizar datos de categoria
    case 'actualizar':
        $categoria_producto_id = mysqli_real_escape_string($conexion,$_GET['input_categoria_id']);
        $nombre_categoria = mysqli_real_escape_string($conexion,$_GET['nombreCategoria']);
        $actualizar_categoria=mysqli_query($conexion,"UPDATE categoria_productos SET  nombre_categoria = '$nombre_categoria' WHERE categoria_producto_id = $categoria_producto_id ") or die("Error en la consulta ".mysqli_error($conexion));
        echo json_encode($actualizar_categoria);
        break;

}
?>