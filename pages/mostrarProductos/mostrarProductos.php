<?php
// ?Verificamos que la sesion este iniciada en casdo contrario redireccionamos al index
session_start();
if(!isset($_SESSION['empleado_id'])){
  session_destroy();
  header('location: ./../../index.php ');
  die();
}else{
  require './../../dist/php/functions/conexion.php';
  $empleado_id= $_SESSION['empleado_id'];
  $usuario_id= $_SESSION['usuario_id'];
  $username= $_SESSION['username'];
  $rol= $_SESSION['rol'];
  // ? Se obtiene el nombre del empleado actual
  $obtener_nombre=mysqli_query($conexion,"SELECT nombre FROM empleados WHERE empleado_id = $empleado_id") or die("Error en la consulta ".mysqli_error($conexion));
  $nombre = mysqli_fetch_array($obtener_nombre);
  mysqli_close($conexion);
  $nombre_empleado=$nombre['nombre'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
  <link rel="stylesheet" href="./../../css/styles.css" />
  <title>Caja Taqueria Mario's</title>
</head>

<body>
  <div class="contenedor">
    <header class="d-flex justify-content-between  header mb-5">
      <div >
        <h4 class="align-self-center header__titulo">Taqueria Mario's</h4>
        <h5>Le atiende <strong><?php echo $nombre_empleado ?></strong></h5>
        <input type="hidden" name="empleadoId" id="empleadoId" value="<?php echo $empleado_id?>">
      </div>
      <div class="d-flex flex-wrap gap-2  header__productoBotones">
        <input type="search" name="busquedaProductos" id="busquedaProductos" class="header__productoBotonesSearch" placeholder="Buscar productos">
        <button type="submit" class="btn btn-primary header__productoBotonesCarrito" id="btnCarrito">
          Carrito
        </button>
        <div class="btn-group" role="group">
          <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Opciones
          </button>
          <ul class="dropdown-menu">
            <?php if($rol==2){?>
            <li><a class="dropdown-item" href="./../../index_dashboard.php">Dashboard</a></li>
            <?php } ?>
            <li><a class="dropdown-item" href="./../../dist/php/functions/logout.php">Cerrar sesion</a></li>
          </ul>
        </div>

      </div>
    </header>

    <main class="catalogo" id="mostrarProductos">
    </main>

  </div>
              
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="./../../dist/js/pages/mostrarProductos/mostrarProductos.js"></script>
</body>

</html>