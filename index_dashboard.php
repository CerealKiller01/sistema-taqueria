<?php
require './dist/php/functions/conexion.php';
// ?Verificamos que la sesion este iniciada en casdo contrario redireccionamos al index
session_start();
if (!isset($_SESSION['empleado_id'])) {
  session_destroy();
  header('location: ./index.php ');
  die();
} else {
  $empleado_id = $_SESSION['empleado_id'];
  if ($_SESSION['rol'] != 2) {
    session_destroy();
    header('location: ./index.php ');
    die();
  }
  $obtener_nombre = mysqli_query($conexion, "SELECT CONCAT(nombre,' ',apellido_paterno,' ',apellido_materno) AS 'nombre_empleado' FROM empleados WHERE empleado_id = $empleado_id") or die('Error en la consulta ' . mysqli_error($conexion));
  $r_obtener_nombre = mysqli_fetch_array($obtener_nombre);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Taqueria Mario's</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- Jquery UI -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>


      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->
    <!-- Sidebar inicio -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="./index_dashboard.php" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Taqueria Mario's</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="./dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo $r_obtener_nombre['nombre_empleado']; ?></a>
          </div>
        </div>



        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="./index_dashboard.php" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./pages/empleados/empleados.php" class="nav-link">
                <i class="nav-icon far fa-user"></i>
                <p>
                  Empleados
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./pages/usuarios/usuarios.php" class="nav-link">
                <i class="nav-icon far fa-user"></i>
                <p>
                  Usuarios
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./pages/productos/productos.php" class="nav-link">
                <i class="nav-icon far fa-image"></i>
                <p>
                  Productos
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./pages/ventas/ventas.php" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Ventas
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./pages/mostrarProductos/mostrarProductos.php" class="nav-link">
                <i class="nav-icon fas fa-backward"></i>
                <p>
                  Regresar a caja
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Sidebar fin -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="./index_dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <?php
                  $total_ventas = mysqli_query($conexion, "SELECT COUNT(*) AS 'total_ventas' FROM ventas") or die('Error en la consulta ' . mysqli_error($conexion));
                  $r_total_ventas = mysqli_fetch_array($total_ventas);
                  ?>
                  <h3><?php echo $r_total_ventas['total_ventas'] ?></h3>
                  <p>Ventas realizadas</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>

              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <?php
                  $alimento_mas_vendido = mysqli_query($conexion, "SELECT P.nombre, SUM(AV.cantidad) AS 'total' FROM articulos_x_venta AV INNER JOIN productos P ON AV.producto_id = P.productos_id WHERE P.categoria_producto_id BETWEEN 14 AND 15 GROUP BY P.nombre ORDER BY `total` DESC") or die('Error en la consulta ' . mysqli_error($conexion));
                  $r_alimento_mas_vendido = mysqli_fetch_array($alimento_mas_vendido);
                  ?>
                  <h3><?php echo $r_alimento_mas_vendido['total'] ?></h3>
                  <p><?php echo $r_alimento_mas_vendido['nombre'] ?></p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>

              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <?php
                  $bebida_mas_vendida = mysqli_query($conexion, "SELECT P.nombre, SUM(AV.cantidad) AS 'total' FROM articulos_x_venta AV INNER JOIN productos P ON AV.producto_id = P.productos_id WHERE P.categoria_producto_id = 17 GROUP BY P.nombre ORDER BY `total` DESC") or die('Error en la consulta ' . mysqli_error($conexion));
                  $r_bebida_mas_vendida = mysqli_fetch_array($bebida_mas_vendida);
                  ?>
                  <h3><?php echo $r_bebida_mas_vendida['total'] ?></h3>
                  <p><?php echo $r_bebida_mas_vendida['nombre'] ?></p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>

              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <?php
                  $venta_total = mysqli_query($conexion, "SELECT SUM(monto) AS 'venta_total' FROM ventas") or die('Error en la consulta ' . mysqli_error($conexion));
                  $r_venta_total = mysqli_fetch_array($venta_total);
                  ?>
                  <h3>$<?php echo $r_venta_total['venta_total'] ?></h3>
                  <p>Venta total</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>

              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="card">
                <div class="card-header border-0">
                  <h3 class="card-title"><strong>Articulos más vendidos</strong> </h3>
                  <div class="card-tools">
                    <form action="#" id="articulosMasVendidos">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="orden" id="asc" value="ASC">
                        <label class="form-check-label" for="asc">A</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="orden" id="desc" value="DESC">
                        <label class="form-check-label" for="desc">D</label>
                      </div>
                      <input type="text" class="selectorFecha" name="fechaInicio" id="fechaInicio" placeholder="Ingresa una fecha">
                      <input type="text" class="selectorFecha" name="fechaFin" id="fechaFin" placeholder="Ingresa una fecha">
                      <input type="submit" value="Enviar" class="btn btn-primary">
                    </form>
                  </div>
                </div>
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped table-valign-middle">
                    <thead>
                      <tr>
                        <th>Productos</th>
                        <th>Precio</th>
                        <th>Ventas</th>
                      </tr>
                    </thead>
                    <tbody id="productosMasVendidos">

                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card">
                <div class="card-header border-0">
                  <h3 class="card-title"><strong>Venta de tacos y tortas en un rango de fechas</strong> </h3>
                  <div class="card-tools">
                    <form action="#" id="ventaAlimentos">
                      <input type="text" class="selectorFecha" name="fechaInicioDos" id="fechaInicioDos" placeholder="Ingresa una fecha">
                      <input type="text" class="selectorFecha" name="fechaFinDos" id="fechaFinDos" placeholder="Ingresa una fecha">
                      <input type="submit" value="Enviar" class="btn btn-primary">
                    </form>
                  </div>
                </div>
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped table-valign-middle">
                    <thead>
                      <tr>
                        <th>Productos</th>
                        <th>Precio</th>
                        <th>Ventas</th>
                      </tr>
                    </thead>
                    <tbody id="mostrarAlimentos">

                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card">
                <div class="card-header border-0">
                  <h3 class="card-title"><strong>Refrescos vendidos en un rango de fechas</strong> </h3>
                  <div class="card-tools">
                    <form action="#" id="refrescosVendidos">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ordenDos" id="asc2" value="ASC">
                        <label class="form-check-label" for="asc2">A</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ordenDos" id="desc2" value="DESC">
                        <label class="form-check-label" for="desc2">D</label>
                      </div>
                      <input type="text" class="selectorFecha" name="fechaInicioCuatro" id="fechaInicioCuatro" placeholder="Ingresa una fecha">
                      <input type="text" class="selectorFecha" name="fechaFinCuatro" id="fechaFinCuatro" placeholder="Ingresa una fecha">
                      <input type="submit" value="Enviar" class="btn btn-primary">
                    </form>
                  </div>
                </div>
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped table-valign-middle">
                    <thead>
                      <tr>
                        <th>Productos</th>
                        <th>Precio</th>
                        <th>Ventas</th>
                        <th>Subtotal</th>
                      </tr>
                    </thead>
                    <tbody id="mostrarRefrescos">
                    </tbody>
                  </table>

                </div>
                <h5 class="ml-3" id="totalRefrescos"></h5>

              </div>


              <!-- /.card -->

              <!-- DIRECT CHAT -->
              <!--/.direct-chat -->

              <!-- TO DO List -->
              <!-- /.card -->
            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">
              <div class="card">
                <div class="card-header border-0">
                  <h3 class="card-title"><strong>Venta total en un rango de fechas</strong> </h3>
                  <div class="card-tools">
                    <form action="#" id="ventaTotal">
                      <input type="text" class="selectorFecha" name="fechaInicioTres" id="fechaInicioTres" placeholder="Ingresa una fecha">
                      <input type="text" class="selectorFecha" name="fechaFinTres" id="fechaFinTres" placeholder="Ingresa una fecha">
                      <input type="submit" value="Enviar" class="btn btn-primary">
                    </form>
                  </div>
                </div>
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped table-valign-middle">
                    <thead>
                      <tr>
                        <th>Total venta</th>
                      </tr>
                    </thead>
                    <tbody id="datosVentaTotal">

                    </tbody>
                  </table>
                </div>
              </div>
              <!-- Map card -->

              <!-- /.card -->

              <!-- solid sales graph -->
              <div class="card ">
                <div class="card-header border-0">
                  <h3 class="card-title"><strong>Venta total en un rango de fechas</strong> </h3>
                  <div class="card-tools">
                    <form action="#" id="ventaGrafica">
                      <input type="text" class="selectorFecha" name="fechaGraficaI" id="fechaGraficaI" placeholder="Ingresa una fecha">
                      <input type="text" class="selectorFecha" name="fechaGraficaF" id="fechaGraficaF" placeholder="Ingresa una fecha">
                      <input type="submit" value="Enviar" class="btn btn-primary">
                    </form>
                  </div>
                </div>
                <canvas id="myChart"></canvas>
              </div>
              <!-- /.card -->

              <!-- Calendar -->
              <!-- /.card -->
            </section>
            <!-- right col -->
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <strong>Copyright &copy; 1990-2023 Taqueria Marios.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0
      </div>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <!-- <script src="plugins/chart.js/Chart.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>
  <script src="./dist/js/pages/dashboard/dashboard.js"></script>
</body>

</html>