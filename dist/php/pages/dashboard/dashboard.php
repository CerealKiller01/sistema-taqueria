<?php
require './../../functions/conexion.php';
switch($_GET['accion']){
    case 'busqueda':
        $fechaInicio = mysqli_real_escape_string($conexion,$_GET['fechaInicio']);
        $fechaFin = mysqli_real_escape_string($conexion,$_GET['fechaFin']);
        $orden = mysqli_real_escape_string($conexion,$_GET['orden']);
        $busqueda=mysqli_query($conexion,"SELECT P.nombre, SUM(AV.cantidad) AS 'total', P.imagen,P.precio FROM articulos_x_venta AV INNER JOIN productos P ON AV.producto_id = P.productos_id  INNER JOIN ventas V ON AV.venta_id = V.venta_id WHERE V.fecha_venta BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY P.nombre ORDER BY `total` $orden ") or die('Error en la consulta '.mysqli_error($conexion));
        $r_busqueda = mysqli_fetch_all($busqueda,MYSQLI_ASSOC);
        echo json_encode($r_busqueda);
        break;
    case 'tacostortas':
        $fechaInicioDos = mysqli_real_escape_string($conexion,$_GET['fechaInicioDos']);
        $fechaFinDos = mysqli_real_escape_string($conexion,$_GET['fechaFinDos']);
        $producto_mas_vendido = mysqli_query($conexion,"SELECT P.imagen,P.nombre,P.precio, SUM(AV.cantidad) AS 'total' FROM articulos_x_venta AV INNER JOIN productos P ON AV.producto_id = P.productos_id INNER JOIN ventas V ON AV.venta_id = V.venta_id WHERE P.categoria_producto_id BETWEEN 14 AND 15 AND V.fecha_venta BETWEEN '$fechaInicioDos' AND '$fechaFinDos' GROUP BY nombre ") or die('Error en la consulta '.mysqli_error($conexion));
        $r_producto_mas_vendido = mysqli_fetch_all($producto_mas_vendido,MYSQLI_ASSOC);
        echo json_encode($r_producto_mas_vendido);
        break;
    case 'ventatotal':
        $fechaInicioTres = mysqli_real_escape_string($conexion,$_GET['fechaInicioTres']);
        $fechaFinTres = mysqli_real_escape_string($conexion,$_GET['fechaFinTres']);
        $venta = mysqli_query($conexion,"SELECT SUM(monto) AS 'total_venta' FROM ventas WHERE fecha_venta BETWEEN '$fechaInicioTres' AND '$fechaFinTres'") or die('Error en la consulta '.mysqli_error($conexion));
        $r_venta=mysqli_fetch_all($venta,MYSQLI_ASSOC);
        echo json_encode($r_venta);
        break;
    case 'refrescos':
        $fechaInicioCuatro = mysqli_real_escape_string($conexion,$_GET['fechaInicioCuatro']);
        $fechaFinCuatro = mysqli_real_escape_string($conexion,$_GET['fechaFinCuatro']);
        $orden_refrescos = mysqli_real_escape_string($conexion,$_GET['ordenRefresco']);
        $refrescos_vendidos = mysqli_query($conexion,"SELECT P.imagen,P.nombre,P.precio, SUM(AV.cantidad) AS 'total',(P.precio * SUM(AV.cantidad)) AS 'subtotal' FROM articulos_x_venta AV INNER JOIN ventas V ON AV.venta_id = V.venta_id INNER JOIN productos P ON AV.producto_id = P.productos_id WHERE P.categoria_producto_id = 17 AND fecha_venta BETWEEN '$fechaInicioCuatro' AND '$fechaFinCuatro' GROUP BY nombre ORDER BY `total` $orden_refrescos") or die('Error en la consulta '.mysqli_error($conexion));
        $r_refrescos_vendidos = mysqli_fetch_all($refrescos_vendidos,MYSQLI_ASSOC);
        echo json_encode($r_refrescos_vendidos);
        break;
    case 'grafica':
        $fechaGraficaI = mysqli_real_escape_string($conexion,$_GET['fechaGraficaI']);
        $fechaGraficaF = mysqli_real_escape_string($conexion,$_GET['fechaGraficaF']);
        $grafica = mysqli_query($conexion,"SELECT MONTHNAME(fecha_venta) AS 'mes', SUM(monto) AS 'monto' FROM ventas WHERE fecha_venta BETWEEN '$fechaGraficaI' AND '$fechaGraficaF' GROUP BY MONTH(fecha_venta)") or die('Error en la consulta '.mysqli_error($conexion));
        $r_grafica=mysqli_fetch_all($grafica,MYSQLI_ASSOC);
        echo json_encode($r_grafica);
        break;
}
