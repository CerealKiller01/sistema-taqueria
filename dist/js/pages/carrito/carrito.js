$(function(){
    // ?Inicializar productos
    mostrarProductos();
    // ?Funcion para mostrar productos
    function mostrarProductos(){
        $.ajax({
            type: "GET",
            url: "./../../dist/php/pages/carrito/carrito.php?accion=mostrar",
            dataType: "JSON",
            success: function (response) {
                if(response.length == 0){
                    $('#datosProductos').html('<h3>Sin productos agregados :(</h3>');
                    $('#tfoot,.form-floating,#btnCobrar,#totalPagar').css('display','none');
                }else{
                    mostrarSoloProductos(response);
                }
            },
            error:function(){
                Swal.fire({
                    icon: 'error',
                    title: '¡Error Fatal!',
                    text: 'Un error inesperado ocurrio en el servidor.'
                  })
            }
        });
    };

    // ? Funcion para mostrar solo una parte de los productos
    function mostrarSoloProductos(response){
        let datos = "";
        let suma = 0;
        for (const iterator of response) {
            iterator.subtotal= iterator.subtotal.replace(/,/g,'');
            suma+=parseFloat(iterator.subtotal);
            datos+=`
            <tr>
            <th>${iterator.producto_id}</th>
            <td>${iterator.nombre}</td>
            <td class="contenedorImagen"><img src="./../../dist/img/productos/${iterator.imagen}" alt="" class="contenedorImagen__img"></td>
            <td>$${iterator.precio}</td>
            <td>${iterator.cantidad}</td>
            <td>$${iterator.subtotal}</td>
            <td><button class="btn btn-danger" id="btnBorrar">Borrar</button></td>
          </tr>
            `;
        }
        $('#datosProductos').html(datos);
        $('#totalPagar').text(`Total a pagar : $${suma}`);
    }

    // ?Borrar articulo
    $('#datosProductos').on('click','#btnBorrar',function(){
        let producto_id = $(this).parent().parent()[0].children[0].textContent;
        $.ajax({
            type: "GET",
            url: "./../../dist/php/pages/carrito/carrito.php?accion=borrar&producto_id="+producto_id,
            dataType: "JSON",
            success: function (response) {
                mostrarProductos();
            },
            error:function(){
                Swal.fire({
                    icon: 'error',
                    title: '¡Error Fatal!',
                    text: 'Un error inesperado ocurrio en el servidor.'
                  })
            }
        });
    });
    // ? Redireccionar a Muestra de productos
    $('#btnRegresar').on('click',function(){
        window.location="./../mostrarProductos/mostrarProductos.php";
    });

    // ?Validar para que solo se permitan numeros al momento de cobrar (input)
    $('#cantidadDinero').on('input',function(){
        $(this).val($(this).val().replace(/[^0-9]/g,''));
    });

    // ? Cobrar cuenta
    $('#btnCobrar').on('click',function(){
        let cantidadDinero = parseInt($('#cantidadDinero').val());
        let textoTotal =$('#totalPagar').text();
        let total = textoTotal.split('$');
        let totalPagar = parseInt(total[1]);
        let cambio = 0;
        if(cantidadDinero>0 && cantidadDinero >= totalPagar){
            cambio = cantidadDinero - totalPagar;
            Swal.fire({
                title: `Cambio : $${cambio}`,
                text: "Confirmar venta",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Continuar'
              }).then((result) => {
                if (result.isConfirmed) {
                  Swal.fire(
                    'Exito!',
                    'Venta realizada.',
                    'success'
                  )
                  let datosVenta ={
                    empleado_id:$('#empleado_id').val(),
                    monto:totalPagar,
                    dinero_cliente:cantidadDinero,
                    cambio:cambio
                  }
                    // ? Se realiza la venta 
                  $.ajax({
                    type: "GET",
                    url: "./../../dist/php/pages/carrito/carrito.php?accion=venta",
                    data: datosVenta,
                    dataType: "JSON",
                    success: function (response) {
                        setTimeout(function(){
                            window.location="./../mostrarProductos/mostrarProductos.php";
                        },1500);
                    },
                    error:function(){
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error Fatal!',
                            text: 'Un error inesperado ocurrio en el servidor.'
                          })
                    }
                  });

                }
              })
        }else{
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error en la cantidad',
                showConfirmButton: false,
                timer: 1500
              })
        }
        
    });
});