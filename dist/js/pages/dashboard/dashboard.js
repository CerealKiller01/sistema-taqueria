$(function() {
    const ctx = document.getElementById('myChart');
    let graf = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [],
          datasets: [{
            label: 'Total de venta ',
            data: [],
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });


    // ?Funcion para visualizar graficas
    function mostrarGraficas(){

    }

    // ? Se invoca al metodo datepicker
    $(".selectorFecha").datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
    });

    // ? Consulta para visualizar los datos en la grafica
    $('#ventaGrafica').on('submit',function(){
        let datosBusqueda={
            fechaGraficaI: $('#fechaGraficaI').val(),
            fechaGraficaF: $('#fechaGraficaF').val()
        }
        $.ajax({
            type: "GET",
            url: "./dist/php/pages/dashboard/dashboard.php?accion=grafica",
            data:datosBusqueda,
            dataType: "JSON",
            success: function (response) {
                graf.data.datasets[0].data.splice(0,graf.data.datasets[0].data.length);
                graf.data.labels.splice(0,graf.data.labels.length);
                for (const iterator of response) {
                graf.data.labels.push(iterator.mes);
                graf.data.datasets[0].data.push(iterator.monto);
                }
              graf.update();

            },
            error:function(){
              Swal.fire({
                icon: 'error',
                title: '¡Error Fatal!',
                text: 'Un error inesperado ocurrio en el servidor.'
              })
            }
        });
        return false;
    });

    // ? Consultar los articulos mas vendidos y ordenarlos de mayor a menos y viceversa
    $('#articulosMasVendidos').on('submit',function(){
        let datosBusqueda={
            fechaInicio:$('#fechaInicio').val(),
            fechaFin:$('#fechaFin').val(),
            orden:$("input[name=orden]:checked").val()
        }
        $.ajax({
            type: "GET",
            url: "./dist/php/pages/dashboard/dashboard.php?accion=busqueda",
            data: datosBusqueda,
            dataType: "JSON",
            success: function (response) {
                let productosMasVendidos="";
                for (const iterator of response) {
                    productosMasVendidos+=`
                    <tr>
                    <td>
                      <img src="./dist/img/productos/${iterator.imagen}" alt="Product 1" class="img-circle img-size-32 mr-2">
                      ${iterator.nombre}
                    </td>
                    <td>$${iterator.precio}</td>
                    <td>
                      ${iterator.total}
                    </td>
                  </tr>
                    `
                }
                $('#productosMasVendidos').html(productosMasVendidos);
                
            },
            error:function(){
              Swal.fire({
                icon: 'error',
                title: '¡Error Fatal!',
                text: 'Un error inesperado ocurrio en el servidor.'
              })
            }
        });
        return false;
    });
    // ? Se obtiene la venta de tacos y tortas en un determinado rango de fechas
    $('#ventaAlimentos').on('submit',function(){
        let datosBusqueda={
            fechaInicioDos:$('#fechaInicioDos').val(),
            fechaFinDos:$('#fechaFinDos').val()
        }
        $.ajax({
            type: "GET",
            url: "./dist/php/pages/dashboard/dashboard.php?accion=tacostortas",
            data: datosBusqueda,
            dataType: "JSON",
            success: function (response) {
                let alimentoMasVendido = "";
                for (const iterator of response) {
                    alimentoMasVendido+=`
                    <tr>
                    <td>
                      <img src="./dist/img/productos/${iterator.imagen}" alt="Product 1" class="img-circle img-size-32 mr-2">
                      ${iterator.nombre}
                    </td>
                    <td>$${iterator.precio}</td>
                    <td>
                      ${iterator.total}
                    </td>
                  </tr>
                    `;
                }
                $('#mostrarAlimentos').html(alimentoMasVendido);
            },
            error:function(){
              Swal.fire({
                icon: 'error',
                title: '¡Error Fatal!',
                text: 'Un error inesperado ocurrio en el servidor.'
              })
            }
        });
        return false;
    });

    // ?Venta total dentro de un rango de fechas
    $('#ventaTotal').on('submit',function(){
        let datosBusqueda={
            fechaInicioTres:$('#fechaInicioTres').val(),
            fechaFinTres:$('#fechaFinTres').val()
        }
        $.ajax({
            type: "GET",
            url: "./dist/php/pages/dashboard/dashboard.php?accion=ventatotal",
            data: datosBusqueda,
            dataType: "JSON",
            success: function (response) {
                let ventaTotal = `
                <tr>
                    <td>$${response[0].total_venta}</td>
                </tr>
                `;
                $('#datosVentaTotal').html(ventaTotal);
            },
            error:function(){
              Swal.fire({
                icon: 'error',
                title: '¡Error Fatal!',
                text: 'Un error inesperado ocurrio en el servidor.'
              })
            }
        });
        return false;
    });
    // ? Refrescos vendidos en un rango de fechas
    $('#refrescosVendidos').on('submit',function(){
        let datosBusqueda={
            fechaInicioCuatro:$('#fechaInicioCuatro').val(),
            fechaFinCuatro:$('#fechaFinCuatro').val(),
            ordenRefresco:$("input[name=ordenDos]:checked").val()
        }
        $.ajax({
            type: "GET",
            url: "./dist/php/pages/dashboard/dashboard.php?accion=refrescos",
            data: datosBusqueda,
            dataType: "JSON",
            success: function (response) {
                let refrescos = "";
                let totalVentaRefrescos=0;
                for (const iterator of response) {
                    totalVentaRefrescos+=parseFloat(iterator.subtotal)
                    refrescos+=`
                    <tr>
                    <td>
                      <img src="./dist/img/productos/${iterator.imagen}" alt="Product 1" class="img-circle img-size-32 mr-2">
                      ${iterator.nombre}
                    </td>
                    <td>$${iterator.precio}</td>
                    <td>
                      ${iterator.total}
                    </td>
                    <td>
                        $${iterator.subtotal}
                    </td>
                  </tr>
                    `;
                }
                $('#mostrarRefrescos').html(refrescos);
                $('#totalRefrescos').text(`Total: $${totalVentaRefrescos}`);
            },
            error:function(){
              Swal.fire({
                icon: 'error',
                title: '¡Error Fatal!',
                text: 'Un error inesperado ocurrio en el servidor.'
              })
            }
        });
        return false;
    });

  });