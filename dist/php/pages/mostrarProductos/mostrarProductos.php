<?php
    require "./../../functions/conexion.php";
    switch($_GET['accion']){
        case 'mostrar':
            $mostrar_productos = mysqli_query($conexion,"SELECT * FROM productos") or die("Error en la consulta ".mysqli_error($conexion));
            $r_mostrar_productos = mysqli_fetch_all($mostrar_productos,MYSQLI_ASSOC);
            echo json_encode($r_mostrar_productos);
            mysqli_close($conexion);
            break;
        case 'buscar':
            $texto = mysqli_real_escape_string($conexion,$_GET['texto']);
            $buscar_productos = mysqli_query($conexion,"SELECT * FROM productos WHERE nombre REGEXP '^$texto' ") or die("Error en la consulta ".mysqli_error($conexion));
            $r_buscar_productos = mysqli_fetch_all($buscar_productos,MYSQLI_ASSOC);
            echo json_encode($r_buscar_productos);
            mysqli_close($conexion);
            break;
        case 'agregar':
            $producto_id=mysqli_real_escape_string($conexion,$_POST['producto_id']);
            $empleado_id=mysqli_real_escape_string($conexion,$_POST['empleado_id']);
            $cantidad=mysqli_real_escape_string($conexion,$_POST['cantidad']);
            $verificar_producto = mysqli_query($conexion,"SELECT * FROM carrito WHERE producto_id = $producto_id") or die('Error en la consulta '.mysqli_error($conexion));
            if(mysqli_num_rows($verificar_producto) == 1){
                $actualizar_producto = mysqli_query($conexion,"UPDATE carrito SET cantidad = (cantidad+$cantidad) WHERE producto_id = $producto_id") or die('Error en la consulta '.mysqli_error($conexion));
                echo json_encode($actualizar_producto);
            }else{
            $agregar_producto=mysqli_query($conexion,"INSERT carrito (producto_id,empleado_id,cantidad) VALUES ($producto_id,$empleado_id,$cantidad) ") or die("Error en la consulta ".mysqli_error($conexion));
            echo json_encode($agregar_producto);
            }
            break;
        case 'calcular':
            $cantidad = mysqli_real_escape_string($conexion,$_GET['cantidad']);
            $calcular_bebidas = mysqli_query($conexion,"SELECT (P.cantidad - 2)  AS 'total_disponible' FROM carrito C INNER JOIN productos P ON C.producto_id = P.productos_id ") or die('Error en la consulta '.mysqli_error($conexion));
            $r_calcular_bebidas = mysqli_fetch_all($calcular_bebidas,MYSQLI_ASSOC);
            echo json_encode($r_calcular_bebidas);
            break;
        case 'verificar':
            $producto_id = mysqli_real_escape_string($conexion,$_GET['producto_id']);
            $verificar = mysqli_query($conexion,"SELECT C.producto_id,P.nombre,C.cantidad AS 'cantidad_x_vender',(P.cantidad - C.cantidad) AS 'cantidad_disponible' FROM carrito C INNER JOIN productos P ON C.producto_id = P.productos_id WHERE P.categoria_producto_id = 17 AND P.productos_id = $producto_id") or die('Error en la consulta '.mysqli_error($conexion));
            $r_verificar=mysqli_fetch_all($verificar,MYSQLI_ASSOC);
            echo json_encode($r_verificar);
            break;
        case 'verificarcantidad':
            $producto_id = mysqli_real_escape_string($conexion,$_GET['producto_id']);
            $verificar_cantidad = mysqli_query($conexion,"SELECT cantidad FROM productos WHERE productos_id = $producto_id") or die('Error en la consulta '.mysqli_error($conexion));
            $r_verificar_cantidad = mysqli_fetch_all($verificar_cantidad,MYSQLI_ASSOC);
            echo json_encode($r_verificar_cantidad);
            break;
    }

?>