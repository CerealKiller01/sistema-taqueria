<?php
require './../../functions/conexion.php';
switch($_GET['accion']){
    // ?Listar productos
    case 'listar':
        $listar_productos = mysqli_query($conexion,"SELECT  productos_id,nombre,nombre_categoria, C.categoria_producto_id AS 'c_categoria_producto_id',precio,cantidad,imagen,fecha_registro_producto,hora_registro_producto FROM productos P LEFT JOIN categoria_productos C on P.categoria_producto_id = C.categoria_producto_id") or die("Error en la consulta ".mysqli_error($conexion));
        $r_listar_productos=mysqli_fetch_all($listar_productos,MYSQLI_ASSOC);
        echo json_encode($r_listar_productos);
        break;
    // ?Elimiar producto
    case 'eliminar':
        $productos_id= mysqli_real_escape_string($conexion,$_GET['productos_id']);
        $obtener_imagen=mysqli_query($conexion,"SELECT imagen FROM productos WHERE productos_id = $productos_id") or die("Error en la consulta ".mysqli_error($conexion));
        $nombre_imagen=mysqli_fetch_array($obtener_imagen);
        $eliminar_imagen="./../../../img/productos/".$nombre_imagen['imagen'];
        if(unlink($eliminar_imagen)){
            $eliminar_producto=mysqli_query($conexion,"DELETE FROM productos WHERE productos_id = $productos_id  ") or die("Error en la consulta ".mysqli_error($conexion));
            echo json_encode($eliminar_producto);
        }else{
            echo '{"error":"No al eliminar la imagen"}';
        }

        break;
    // ?Consultar producto
    case 'consultar':
        $productos_id= mysqli_real_escape_string($conexion,$_GET['productos_id']);
        $consultar_producto=mysqli_query($conexion,"SELECT * FROM productos WHERE productos_id =$productos_id") or die("Error en la consulta ".mysqli_error($conexion));
        $r_consultar_producto=mysqli_fetch_all($consultar_producto,MYSQLI_ASSOC);
        echo json_encode($r_consultar_producto);
        break; 
    // ?Actualizar producto
    case 'actualizar':
            $productos_id =mysqli_real_escape_string($conexion,$_POST['input_producto_id']);
            $nombre=mysqli_real_escape_string($conexion,$_POST['nombre']);
            $precio=mysqli_real_escape_string($conexion,$_POST['precio']);
            $categoria_producto_id=mysqli_real_escape_string($conexion,$_POST['categoria']);
            $cantidad=mysqli_real_escape_string($conexion,$_POST['cantidad']);
            if(empty($_FILES["file"]["type"])){
                // ? Se actulizan todos los datos a excepcion de la imagen, debido a que la imagen no necesite ser actualizada
                $actulizar_sin_imagen=mysqli_query($conexion,"UPDATE productos SET nombre ='$nombre',precio=$precio,categoria_producto_id=$categoria_producto_id, cantidad=$cantidad WHERE productos_id = $productos_id") or die("Error en la consulta ".mysqli_error($conexion));
                echo json_encode($actulizar_sin_imagen);
            }else{
                // ?Se obtiene el nombre de la imagen para despues ser eliminada
                $obtener_imagen=mysqli_query($conexion,"SELECT imagen FROM productos WHERE productos_id = $productos_id") or die("Error en la consulta ".mysqli_error($conexion));
                $nombre_imagen=mysqli_fetch_array($obtener_imagen);
                $eliminar_imagen="./../../../img/productos/".$nombre_imagen['imagen'];
                if(unlink($eliminar_imagen)){
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
                    // ? Se realiza la consulta a la base de datos para actualizar el producto
                    $actulizar_con_imagen=mysqli_query($conexion,"UPDATE productos SET nombre ='$nombre',precio=$precio,categoria_producto_id=$categoria_producto_id, cantidad=$cantidad,imagen='$imagenSubida' WHERE productos_id = $productos_id") or die("Error en la consulta ".mysqli_error($conexion));
                    echo json_encode($actulizar_con_imagen);
                }
            }


        break;
    }


?>