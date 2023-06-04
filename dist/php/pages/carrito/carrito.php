<?php
require './../../functions/conexion.php';
switch($_GET['accion']){
    case 'mostrar':
        $mostrar_productos= mysqli_query($conexion,"SELECT producto_id,categoria_producto_id,nombre,imagen,precio,C.cantidad,IF(categoria_producto_id = 16,FORMAT((precio*C.cantidad/1000),2),FORMAT((precio*C.cantidad),2)) AS 'subtotal' FROM productos P INNER JOIN carrito C ON C.producto_id = P.productos_id ORDER BY nombre ASC ") or die("Error en la consulta ".mysqli_error($conexion));
        $r_mostrar_productos=mysqli_fetch_all($mostrar_productos,MYSQLI_ASSOC);
        echo json_encode($r_mostrar_productos);
        break;
    case 'borrar':
        $producto_id = mysqli_real_escape_string($conexion,$_GET['producto_id']);
        $borrar_producto = mysqli_query($conexion,"DELETE FROM carrito WHERE producto_id =$producto_id") or die('Error en la consulta '.mysqli_error($conexion));
        echo json_encode($borrar_producto);
        break;
    case 'venta':
        $empleado_id = mysqli_real_escape_string($conexion,$_GET['empleado_id']);
        $monto = mysqli_real_escape_string($conexion,$_GET['monto']);
        $dinero_cliente = mysqli_real_escape_string($conexion,$_GET['dinero_cliente']);
        $cambio = mysqli_real_escape_string($conexion,$_GET['cambio']);
        // ? SE REALIZA EL REGISTRO DE LA VENTA
        $registro_venta = mysqli_query($conexion,"INSERT INTO ventas (empleado_id,monto,dinero_cliente,cambio) VALUES ($empleado_id,$monto,$dinero_cliente,$cambio)") or die('Error en la consulta '.mysqli_error($conexion));
        $ultimo_id = mysqli_insert_id($conexion);
        // ? SE INSERTAN LOS DATOS A LA TABLA DE REGISTRO DE ARTICULOS POR VENTA
        $registro_articulos_x_venta = mysqli_query($conexion,"INSERT INTO articulos_x_venta (venta_id,producto_id,cantidad,precio_producto,total_x_producto ) SELECT V.venta_id, C.producto_id,C.cantidad,P.precio,IF(P.categoria_producto_id = 16,FORMAT((precio*C.cantidad/1000),2),(C.cantidad * P.precio)) AS 'total_x_producto'FROM carrito C INNER JOIN productos P ON C.producto_id = P.productos_id INNER JOIN ventas V ON V.empleado_id = C.empleado_id WHERE V.venta_id = $ultimo_id") or die('Error en la consulta '.mysqli_error($conexion));

        // ? SE REALIZA UN UPDATE PARA ACTUALIZAR LA CANTIDAD DE BEBIDAS EN LA TABLA PRODUCTO, ESTE UPDATE SE ACTIVA SI  SE VENDIERON O NO BEBIDAS
        // ! ****ESTO SE PUEDE MEJORAR PARA QUE SE ACTIVE SOLO CUANDO HAY BEBIDAS DENTRO DE UNA VENTA ***
        $actualizar_cantidad_bebidas = mysqli_query($conexion,"UPDATE productos P INNER JOIN articulos_x_venta AV ON P.productos_id = AV.producto_id SET P.cantidad = (P.cantidad - AV.cantidad) WHERE P.categoria_producto_id = 17 AND AV.venta_id = $ultimo_id") or die('Error en la consulta '.mysqli_error($conexion));
        // ? VACIAR TABLA CARRITO
        $vaciar_carrito = mysqli_query($conexion,"DELETE FROM carrito") or die('Error en la consulta '.mysqli_error($conexion));
        mysqli_close($conexion);
        echo json_encode($vaciar_carrito);
        break;

}
?>