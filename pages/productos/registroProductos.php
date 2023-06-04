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
    <title>Registro de productos Taqueria Mario's</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h3><b>Registro de productos</b></h3>
            </div>
            <div class="card-body">
                <form action="" method="POST" id="registroProducto" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Nombre del producto" name="nombre" id="nombre">
                    </div>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" name="file" id="file" alt="img" required >
                    </div>
                    <div class="input-group mb-3 justify-content-center">
                        <img src="./../../dist/img/noimage.jpg" alt="" srcset="" id="previsualizarImagen" width="250px" height="250px">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" placeholder="Ingrese el precio del producto" name="precio" id="precio">
                    </div>
                    <div class="input-group mb-3">
                        <select class="form-control" name="categoria" id="categoria">
                            <option disabled selected>Selecciona una categoria</option>
                            <?php
                                $listar_categorias = mysqli_query($conexion,"SELECT * FROM categoria_productos") or die("Error en la consulta ".mysqli_error($conexion));
                                while($r_listar_categorias=mysqli_fetch_array($listar_categorias)){
                            ?>
                                <option value="<?php echo $r_listar_categorias['categoria_producto_id']?>"><?php echo $r_listar_categorias['nombre_categoria']?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Ingrese una cantidad" name="cantidad" id="cantidad">
                    </div>
                    <div class="row justify-content-center">
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>



            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- JS registroProductos -->
    <script src="./registroProductos.js"></script>
</body>

</html>