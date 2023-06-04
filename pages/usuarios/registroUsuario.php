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
  <title>Registro de usuarios Taqueria Mario's</title>

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
        <h3><b>Registro de usuarios</b></h3>
      </div>
      <div class="card-body">

        <form action="" method="POST" id="formularioUsuarios">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username" name="username" id="username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <select class="form-control" name="empleado_id" id="empleado_id">
              <option disabled selected>Selecciona un empleado</option>

              <?php
              //* Se realiza consulta a empleados para obtener ID y NOMBRE
              $consulta_empleados = mysqli_query($conexion, "SELECT E.empleado_id as 'empleado',E.nombre as 'nombre',E.apellido_paterno as 'apellido_paterno',E.apellido_materno as 'apellido_materno', D.empleado_id as 'usuario' FROM empleados E LEFT JOIN usuarios D ON E.empleado_id = D.empleado_id") or die('Error en la consulta ' . mysqli_error($conexion));
              while ($resultado = mysqli_fetch_array($consulta_empleados)) {
                if ($resultado['empleado'] != $resultado['usuario']) {
              ?>
                  <option value="<?php echo $resultado['empleado'] ?>">#<?php echo $resultado['empleado'] ?> <?php echo $resultado['nombre'] . $resultado['apellido_paterno'] . $resultado['apellido_materno'] ?> </option>
              <?php
                }
              }
              ?>
            </select>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" id="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Retype password" name="rpassword" id="rpassword">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
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
  <script src="./../../dist/js/pages/usuarios/registroUsuario.js"></script>
</body>

</html>