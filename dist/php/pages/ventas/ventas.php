<?php
require './../../functions/conexion.php';
switch($_GET['accion']){
    case 'listar':
        $listar_ventas = mysqli_query($conexion,"SELECT venta_id,CONCAT(E.nombre,' ',E.apellido_paterno) AS 'nombre',monto,dinero_cliente,cambio,fecha_venta,hora_venta FROM ventas V LEFT JOIN empleados E ON V.empleado_id = E.empleado_id ORDER BY venta_id DESC") or die('Error en la consulta '.mysqli_error($conexion));
        $r_listar_ventas = mysqli_fetch_all($listar_ventas,MYSQLI_ASSOC);
        echo json_encode($r_listar_ventas);
        break;
    case 'producto':
        $venta_id  = mysqli_real_escape_string($conexion,$_GET['venta_id']);
        $listar_producto = mysqli_query($conexion,"SELECT V.venta_id, CONCAT(V.fecha_venta,' ',V.hora_venta) AS 'fecha_venta', CONCAT(E.nombre,' ',apellido_paterno,' ',apellido_materno) AS 'nombre_empleado', E.empleado_id, P.productos_id,P.nombre AS 'nombre_producto',AV.precio_producto, AV.cantidad, AV.total_x_producto ,monto,dinero_cliente,V.cambio   FROM articulos_x_venta AV INNER JOIN ventas V ON AV.venta_id = V.venta_id LEFT JOIN empleados E ON V.empleado_id=E.empleado_id INNER JOIN productos P ON AV.producto_id = P.productos_id WHERE AV.venta_id = $venta_id") or die('Error en la consulta '.mysqli_error($conexion));
        $r_listar_producto = mysqli_fetch_all($listar_producto,MYSQLI_ASSOC);
        echo json_encode($r_listar_producto);
        break;
}
?>