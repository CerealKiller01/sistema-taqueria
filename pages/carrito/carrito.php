<?php
// ?Verificamos que la sesion este iniciada en casdo contrario redireccionamos al index
session_start();
if(!isset($_SESSION['empleado_id'])){
  session_destroy();
  header('location: ./../../index.php ');
  die();
}else{
  $empleado_id= $_SESSION['empleado_id'];
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="./../../css/styles.css" />
    <title>Document</title>
  </head>
  <body>
    <div class="contenedorCarrito">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Id producto #</th>
              <th>Nombre</th>
              <th>Imagen</th>
              <th>Precio</th>
              <th>Cantidad</th>
              <th>Subtotal</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="datosProductos">
          </tbody>
          <tfoot id="tfoot">
            <tr>
              <th>Id producto #</th>
              <th>Nombre</th>
              <th>Imagen</th>
              <th>Precio</th>
              <th>Cantidad</th>
              <th>Subtotal</th>
              <th>Acciones</th>
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="d-flex flex-column gap-3 w-50 contenedorPago" >
        <h3 class="contenedorPago__total" id="totalPagar"></h3>
        <div class="form-floating">
          <input type="text" class="form-control w-75" id="cantidadDinero" placeholder="$100">
          <label for="cantidadDinero">Ingresa dinero:</label>
        </div>

        <input type="hidden" name="empleado_id" id="empleado_id" value="<?php echo $empleado_id?>">
        <button class="btn btn-success contenedorPago__btn" id="btnCobrar">Cobrar</button>
        <button class="btn btn-danger contenedorPago__btn" id="btnRegresar">Regresar</button>
        
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./../../dist/js/pages/carrito/carrito.js"></script>

  </body>
</html>
