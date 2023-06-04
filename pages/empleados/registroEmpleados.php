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
    <title>Registros empleados Taqueria Mario's</title>


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
                <h3><b>Registro de empleados</b></h3>
            </div>
            <div class="card-body">
                <form action="" method="POST" id="registroEmpleados">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Nombre(s)" name="nombre" id="nombre">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Apellido paterno" name="apellidoPaterno" id="apellidoPaterno">
                        <div class="input-group-append">

                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Apellido materno" name="apellidoMaterno" id="apellidoMaterno">
                        <div class="input-group-append">

                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Numero de telefono" name="telefono" id="telefono">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-control" name="rol" id="rol">
                            <option disabled selected>Selecciona un rol</option>
                            <option value="0">Mesero</option>
                            <option value="1">Cajero</option>
                            <option value="2">Administrador</option>
                        </select>
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
    <!-- <script src="../../plugins/jquery/jquery.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- JS registroEmpleados -->
    <script src="./../../dist/js/pages/empleados/registroEmpleados.js"></script>
</body>

</html>