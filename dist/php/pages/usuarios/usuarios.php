<?php
require './../../functions/conexion.php';
switch($_GET['accion']){
    case 'listar':
        $listar_usuarios=mysqli_query($conexion,"SELECT usuario_id,empleado_id,username FROM usuarios") or die("Error en la consulta ".mysqli_error($conexion));
        $r_listar_usuarios=mysqli_fetch_all($listar_usuarios,MYSQLI_ASSOC);
        echo json_encode($r_listar_usuarios);
        break;
    case 'visualizar':
        $empleado_id=mysqli_real_escape_string($conexion,$_GET['empleadoId']);
        $visualizar_empleado=mysqli_query($conexion,"SELECT * FROM empleados WHERE empleado_id = $empleado_id ") or die("Error en la consulta ".mysqli_error($conexion));
        $r_visualizar_empleado=mysqli_fetch_all($visualizar_empleado,MYSQLI_ASSOC);
        echo json_encode($r_visualizar_empleado);
        break;
    case 'verificar':
        $usuario_id = mysqli_real_escape_string($conexion,$_GET['usuario_id']);
        $verificar_usuario= mysqli_query($conexion,"SELECT * FROM usuarios WHERE usuario_id = $usuario_id") or die("Error en la consulta ".mysqli_error($conexion));
        $r_verificar_usuario=mysqli_fetch_all($verificar_usuario,MYSQLI_ASSOC);
        echo json_encode($r_verificar_usuario);
        break;
    case 'actualizar':
        $input_usuario_id = mysqli_real_escape_string($conexion,$_GET['input_usuario_id']);
        $username = mysqli_real_escape_string($conexion,$_GET['username']);
        // *Verificar que el username no sea repetido 
        $verificar_username=mysqli_query($conexion,"SELECT username FROM usuarios WHERE username = '$username'") or die("Error en la consulta ".mysqli_error($conexion));
        if(mysqli_num_rows($verificar_username)==1){
            echo '{"error":"Este nombre de usuario ya esta en uso"}';
        }else{
            $editar_usuario = mysqli_query($conexion,"UPDATE usuarios SET username ='$username' WHERE usuario_id = $input_usuario_id") or die("Error en la consulta ".mysqli_error($conexion));
            echo json_encode($editar_usuario);
        }
        break;
}
?>