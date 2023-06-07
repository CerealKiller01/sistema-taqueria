<?php
require './../../dist/php/functions/conexion.php';
// ?Verificamos que la sesion este iniciada en casdo contrario redireccionamos al index
session_start();
if (!isset($_SESSION['empleado_id'])) {
    session_destroy();
    header('location: ./../../index.php ');
    die();
} else {
    $empleado_id = $_SESSION['empleado_id'];
    if ($_SESSION['rol'] != 2) {
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
    <title>Ventas Taqueria Mario's</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.4.1/css/dataTables.dateTime.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
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
                            <h1>Ventas</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./../../index_dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Ventas</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <section class="content">
                <div class="container-fluid">
                    <table cellspacing="5" cellpadding="5" border="0">
                        <tbody>
                            <tr>
                                <td>Minimum date:</td>
                                <td><input type="text" id="min" name="min"></td>
                            </tr>
                            <tr>
                                <td>Maximum date:</td>
                                <td><input type="text" id="max" name="max"></td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Responsive Hover Table</h3>


                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table id="tablaVentas" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Id venta</th>
                                                <th>Cobrada por</th>
                                                <th>Total $</th>
                                                <th>Dinero del cliente $</th>
                                                <th>Cambio $</th>
                                                <th>Fecha</th>
                                                <th>Hora</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Id venta</th>
                                                <th>Cobrada por</th>
                                                <th>Total $</th>
                                                <th>Dinero del cliente $</th>
                                                <th>Cambio $</th>
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
                                    <h4 class="modal-title" id="productoId">Comprobante de venta</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" enctype="multipart/form-data" id="actualizarProducto">

                                    <div class="modal-body">
                                        <!-- Main content -->
                                        <div class="invoice p-3 mb-3">
                                            <!-- title row -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <h4>
                                                        <i class="fas fa-globe"></i> Taqueria Marios.
                                                        <small class="float-right" id="fechaVenta"></small>
                                                    </h4>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- info row -->
                                            <div class="row invoice-info">
                                                <div class="col-sm-6 invoice-col">
                                                    <!-- De -->
                                                    <address>
                                                        <strong>Taqueria Marios.</strong><br>
                                                        Guadalupe victoria 3 B<br>
                                                        Contla, Tlaxcala 90670<br>
                                                        Telefono: 246-208-7180<br>
                                                        Email: duk123xk@gmail.com
                                                    </address>
                                                </div>
                                                <div class="col-sm-6 invoice-col">
                                                    <p>Venta: <strong id="ventaId"></strong> </p>
                                                    <p>Realizada por: <strong id="nombreEmpleado"></strong> </p>
                                                    <p>Id del empleado: <strong id="empleadoId"></strong></p>
                                                </div>


                                            </div>
                                            <!-- /.row -->

                                            <!-- Table row -->
                                            <div class="row">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Id del producto</th>
                                                                <th>Nombre</th>
                                                                <th>Precio</th>
                                                                <th>Cantidad</th>
                                                                <th>Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="datosProductos">
                                                            <!-- <tr>
                                                                <td>1</td>
                                                                <td>Tacos al pastor</td>
                                                                <td>7</td>
                                                                <td>5</td>
                                                                <td>$35</td>
                                                            </tr> -->


                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->

                                            <div class="row justify-content-end">
                                                <!-- accepted payments column -->

                                                <!-- /.col -->
                                                <div class="col-6">

                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tr>
                                                                <th>Dinero cliente:</th>
                                                                <td id="dineroCliente"></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Total:</th>
                                                                <td id="total"></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Cambio:</th>
                                                                <td id="cambio"></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->

                                            <!-- this row will not appear when printing -->
                                            <div class="row no-print">
                                                <div class="col-12">
                                                    <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

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
    <script src="./ventas.js"></script>

</body>

</html>