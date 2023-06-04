<?php
require './../../functions/conexion.php';
switch($_GET['accion']){
    // *Listar empleados en Datatable
    case 'listar':
        $listar_empleados = mysqli_query($conexion, "SELECT E.empleado_id,nombre,apellido_paterno,apellido_materno,telefono,rol,fecha_registro_empleado,hora_registro_empleado, usuario_id FROM empleados E LEFT JOIN usuarios U ON E.empleado_id = U.empleado_id") or die("Error en la consulta ".mysqli_error($conexion));
        $r_listar_empleados=mysqli_fetch_all($listar_empleados,MYSQLI_ASSOC);
        echo json_encode($r_listar_empleados);
        break;
    // *Borrar un empleado en especifico
    case 'borrar':
        $empleado_id=mysqli_real_escape_string($conexion,$_GET['empleado_id']);
        $borrar_empleado=mysqli_query($conexion,"DELETE FROM empleados WHERE empleado_id = $empleado_id") or die("Error en la consulta ".mysqli_error($conexion));
        echo json_encode($borrar_empleado);
        break;   
    // *Visualizar datos para despues actualizarlos
    case 'visualizar':
        $empleado_id=mysqli_real_escape_string($conexion,$_GET['empleado_id']);
        $visualizar_empleado=mysqli_query($conexion,"SELECT * FROM empleados WHERE empleado_id = $empleado_id") or die("Error en la consulta ".mysqli_error($conexion));
        $r_visualizar_empleado=mysqli_fetch_all($visualizar_empleado,MYSQLI_ASSOC);
        echo json_encode($r_visualizar_empleado);
        break;
    // *Actualizar datos
    case 'actualizar':
        $empleado_id=mysqli_real_escape_string($conexion,$_GET['input_empleado_id']);
        $nombre=mysqli_real_escape_string($conexion,$_GET['nombre']);
        $apellido_paterno=mysqli_real_escape_string($conexion,$_GET['apellido_paterno']);
        $apellido_materno=mysqli_real_escape_string($conexion,$_GET['apellido_materno']);
        $telefono=mysqli_real_escape_string($conexion,$_GET['telefono']);
        $rol=mysqli_real_escape_string($conexion,$_GET['rol']);
        $actualizar_empleado=mysqli_query($conexion,"UPDATE empleados SET nombre='$nombre',apellido_paterno='$apellido_paterno',apellido_materno='$apellido_materno',telefono='$telefono',rol=$rol WHERE empleado_id=$empleado_id ") or die("Error en la consulta ".mysqli_error($conexion));
        echo json_encode($actualizar_empleado);
        break;
}
