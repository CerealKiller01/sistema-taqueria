<?php 
  require './../../dist/php/functions/active_link.php';
  $obtener_nombre = mysqli_query($conexion,"SELECT CONCAT(nombre,' ',apellido_paterno,' ',apellido_materno) AS 'nombre_empleado' FROM empleados WHERE empleado_id = $_SESSION[empleado_id]") or die('Error en la consulta '.mysqli_error($conexion));
  $r_obtener_nombre = mysqli_fetch_array($obtener_nombre);
?>

<a href="./../../index_dashboard.php" class="brand-link">
  <img src="./../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
  <span class="brand-text font-weight-light">Taqueria Mario's</span>
</a>
<div class="sidebar">

  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="./../../dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
      <a href="#" class="d-block"><?php echo $r_obtener_nombre['nombre_empleado']?></a>
    </div>
  </div>

  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="./../../index_dashboard.php" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="./../empleados/empleados.php" class="nav-link <?php echo active_link('empleados') ?>">
          <i class="nav-icon far fa-user"></i>
          <p>
            Empleados
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="./../usuarios/usuarios.php" class="nav-link <?php echo active_link('usuarios') ?>">
          <i class="nav-icon far fa-user"></i>
          <p>
            Usuarios
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="./../productos/productos.php" class="nav-link <?php echo active_link('productos') ?>">
          <i class="nav-icon far fa-image"></i>
          <p>
            Productos
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="./../ventas/ventas.php" class="nav-link <?php echo active_link('ventas') ?>">
          <i class="nav-icon fas fa-book"></i>
          <p>
            Ventas
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="./../mostrarProductos/mostrarProductos.php" class="nav-link">
          <i class="nav-icon fas fa-backward"></i>
          <p>
            Regresar a caja
          </p>
        </a>
      </li>
    </ul>
  </nav>

</div>