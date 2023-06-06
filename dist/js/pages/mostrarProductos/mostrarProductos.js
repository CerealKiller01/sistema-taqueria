$(function () {
  let Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 1400,
  });
  // ? Inicializar productos
  mostrarProductos();
  // ?Funcion para mostrar solo productos
  function productos(response) {
    let productos = "";
    for (const iterator of response) {
      productos += `
            <div class="carta ${(iterator.categoria_producto_id == 17 && iterator.cantidad == 0)?'border border-danger':''}">
            <img src="./../../dist/img/productos/${
              iterator.imagen
            }" alt="" class="carta__img" height="220px">
            <div class="carta__contenedor">
              <input type="hidden" name="producto_id" id="producto_id" value="${
                iterator.productos_id
              }">
              <input type="hidden" name="cantidad" id="cantidad" value="${
                iterator.cantidad
              }">
              <input type="hidden" name="categoria_producto_id" id="categoria_producto_id" value="${
                iterator.categoria_producto_id
              }">
              <h3 class="carta__nombre">${iterator.nombre}</h3>
              <h5 class="carta__precio">$${iterator.precio}</h5>
              <h5 class="carta__cantidad">${
                iterator.categoria_producto_id == 17
                  ? `Cantidad: ${iterator.cantidad}`
                  : ""
              }</h5>
              <input type="text" name="cantidadComida" id="cantidadComida" class="form-control carta__input" placeholder="Ingresa una cantidad">
              <button class="btn btn-primary carta__btn " id="btnAgregar">Agregar</button>
            </div>
          </div>
            `;
    }
    $("#mostrarProductos").html(productos);
  }
  // ? Funcion mostrar productos
  function mostrarProductos() {
    $.ajax({
      type: "GET",
      url: "./../../dist/php/pages/mostrarProductos/mostrarProductos.php?accion=mostrar",
      dataType: "JSON",
      success: function (response) {
        productos(response);
      },
      error: function () {
        console.log("Error en el servidor");
      },
    });
  }

  // ? Funcion busqueda de productos
  function busquedaProductos(texto) {
    $.ajax({
      type: "GET",
      url:
        "./../../dist/php/pages/mostrarProductos/mostrarProductos.php?accion=buscar&texto=" +
        texto,
      dataType: "JSON",
      success: function (response) {
        if(response.length == 0){
          $('#mostrarProductos').html('<div class="carta"><strong>Sin resultados :(</strong></div>')
        }else{
        productos(response);
        }
      },
      error: function () {
        console.log("Error en el servidor al buscar");
      },
    });
  }

  //? Busqueda de productos
  $("#busquedaProductos").on("keyup", function () {
    if ($(this).val().length === 0) {
      busquedaProductos(($(this).value = " "));
    } else {
      busquedaProductos($(this).val());
    }
  });
  // ?FUNCION PARA LLENAR DATOS DEL PRODUCTO A AGREGAR
  function llenarDatos(producto_id, empleado_id, cantidad) {
    let datosProducto = {
      producto_id: producto_id,
      empleado_id: empleado_id,
      cantidad: cantidad,
    };
    return datosProducto;
  }

  // ?FUNCION PARA AGREGAR DATOS A LA BASE DE DATOS
  function agregarRegistro(datosProducto) {
    $.ajax({
      type: "POST",
      url: "./../../dist/php/pages/mostrarProductos/mostrarProductos.php?accion=agregar",
      data: datosProducto,
      dataType: "JSON",
      success: function (response) {
        Toast.fire({
          icon: "success",
          title: "Producto agregado!",
        });
        console.log(response);
      },
      error: function () {
        console.log("Error en el servidor");
      },
    });
  }

  // ? Validacion para que solo se acepten numeros
  $('#mostrarProductos').on('input','#cantidadComida',function(){
    $(this).val($(this).val().replace(/[^0-9]/g,''));
  });

  // ?Agregar productos al carrito
  $("#mostrarProductos").on("click", "#btnAgregar", function () {
    if ($(this).parent()[0].children[2].value == 17) {
      if(parseInt($(this).parent()[0].children[6].value) > 0){

   
      let cantidadBebida = $(this).parent()[0].children[6].value;
      let bebidaId =  $(this).parent()[0].children[0].value;
      let datos = llenarDatos(
        $(this).parent()[0].children[0].value,
        $("#empleadoId").val(),
        $(this).parent()[0].children[6].value
      );
      $.ajax({
        type: "GET",
        url: "./../../dist/php/pages/mostrarProductos/mostrarProductos.php?accion=verificar&producto_id="+$(this).parent()[0].children[0].value,
        dataType: "JSON",
        success: function (response) {
          if(response.length == 0){
            $.ajax({
              type: "GET",
              url: "./../../dist/php/pages/mostrarProductos/mostrarProductos.php?accion=verificarcantidad&producto_id="+bebidaId,
              dataType: "JSON",
              success: function (response) {
                if(parseInt(cantidadBebida)<=parseInt(response[0].cantidad)){
                 agregarRegistro(datos);

                }else{
                  Toast.fire({
                    icon: "error",
                    title: "¡Se ha excedido la cantidad!",
                  });
                }
              },
              error:function(){
                console.log("Error en el servidor");
              }
            });
            console.log("ARRAY VACIO");

          }else{
            if(parseInt(cantidadBebida) <= parseInt(response[0].cantidad_disponible) ){
            agregarRegistro(datos);
            console.log(response[0].cantidad_disponible);

            }else{
              Toast.fire({
                icon: "error",
                title: "¡Se ha alcanzado el limite maximo en stock!",
              });
            }

            // console.log("EL ARRAY NO ESTA VACIO");
          }
        },
        error:function(){
          console.log("Error en el servidor");
        }
      });
    }else{
      Toast.fire({
        icon: "error",
        title: "Error en la cantidad!",
      });
    }

      
    } else {
      if (parseInt($(this).parent()[0].children[6].value) > 0) {
        let datos = llenarDatos(
          $(this).parent()[0].children[0].value,
          $("#empleadoId").val(),
          $(this).parent()[0].children[6].value
        );
        agregarRegistro(datos);
      } else {
        Toast.fire({
          icon: "error",
          title: "Error en la cantidad!",
        });
      }
    }
  });


  // ? Redireccionar a carrito
  $("#btnCarrito").on("click", function () {
    window.location = "./../carrito/carrito.php";
  });
});
