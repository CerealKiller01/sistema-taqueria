<?php
require './../../dist/php/functions/conexion.php';
// ?Verificamos que la sesion este iniciada en casdo contrario redireccionamos al index
session_start();
if(!isset($_SESSION['empleado_id'])){
  session_destroy();
  header('location: ./../../index.php ');
  die();
}else{
  $empleado_id = $_SESSION['empleado_id'];
  if($_SESSION['rol']!=2){
    session_destroy();
    header('location: ./../../index.php ');
    die();
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Productos Taqueria Mario's</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.4.1/css/dataTables.dateTime.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="./../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

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
                <!-- Navbar Search -->

                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">



            <!-- Sidebar Menu -->
            <?php include './../sidebar/sidebar.php'; ?>
            <!-- /.sidebar-menu -->

        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Productos</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./../../index_dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Productos</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <section class="content">
                <div class="container-fluid">
                <button class="btn btn-primary mb-3" id="btnRegistroProducto">Registrar producto</button>

                <div class="margin">
                  <div class="btn-group mb-3">
                    <button type="button" class="btn btn-primary">Categorias</button>
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <!-- <a class="dropdown-item" href="./registroCategoria.php">Registrar Categoria</a> -->
                      <a class="dropdown-item" href="./verCategorias.php">Ver categorias</a>
                    </div>
                  </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Responsive Hover Table</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table id="tablaProductos" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Categoria</th>
                                                <th>Precio $</th>
                                                <th>Cantidad</th>
                                                <th>Imagen</th>
                                                <th>Fecha</th>
                                                <th>Hora</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>

                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Categoria</th>
                                                <th>Precio $</th>
                                                <th>Cantidad</th>
                                                <th>Imagen</th>
                                                <th>Fecha</th>
                                                <th>Hora</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.row -->
      <!-- modal-editar -->
      <div class="modal fade" id="modal-editar">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="productoId"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" enctype="multipart/form-data" id="actualizarProducto">

            <div class="modal-body">
                <input type="hidden" name="input_producto_id" id="input_producto_id">
                <div class="w-50">
                  <label for="nombre" class="form-label">Nombre del producto</label>
                  <input type="text" name="nombre" id="nombre" class="form-control">
                  <label for="file">Selecciona una imagen</label>
                  <input type="file" class="form-control" name="file" id="file" alt="img"  >
                  <img src="./../../dist/img/noimage.jpg" class="mt-2" alt="" srcset="" id="previsualizarImagen" width="250px" height="250px">
                  <label for="precio" class="form-label">Precio</label>
                  <input type="text" name="precio" id="precio" class="form-control">
                  <div class="mt-3">
                    <select class="form-select" name="categoria" id="categoria">
                      <option disabled>Selecciona una categoria</option>
                      <?php
                        $consultar_categorias = mysqli_query($conexion,"SELECT * FROM categoria_productos") or die("Error en la consulta ".mysqli_error($conexion));
                        while($r_consultar_categorias=mysqli_fetch_array($consultar_categorias)){
                      ?>
                        <option value="<?php echo $r_consultar_categorias['categoria_producto_id']?>"><?php echo $r_consultar_categorias['nombre_categoria']?></option>
                      <?php } ?>

                    </select>
                  </div>
                  <label for="cantidad" class="form-label">Cantidad</label>
                  <input type="text" name="cantidad" id="cantidad" class="form-control">

                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" >Actualizar cambios</button>

            </div>
            </form>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal-editar -->
                </div><!-- /.container-fluid -->
            </section>
        </div>
        <!-- /.content-wrapper -->

        <!-- footer -->
        <?php include './../footer/footer.php'; ?>
        <!-- /.footer -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <!-- <script src="../../plugins/jquery/jquery.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- SweetAlert2 -->
        <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.4.1/js/dataTables.dateTime.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.13.4/api/sum().js"></script>
    <!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./productos.js"></script>
</body>

</html>