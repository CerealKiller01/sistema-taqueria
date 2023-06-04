$(function(){
    let minDate, maxDate;
    // Custom filtering function which will search data in column four between two values
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            let min = minDate.val();
            let max = maxDate.val();
            let date = new Date(data[5]);

            if (
                (min === null && max === null) ||
                (min === null && date <= max) ||
                (min <= date && max === null) ||
                (min <= date && date <= max)
            ) {
                return true;
            }
            return false;
        }
    );
    
            // Create date inputs
            minDate = new DateTime($('#min'), {
                format: 'MMMM Do YYYY'
            });
            maxDate = new DateTime($('#max'), {
                format: 'MMMM Do YYYY'
            });

            // DataTables initialisation
            let tablaVentas = $('#tablaVentas').DataTable({
                ajax:{
                    url:"./../../dist/php/pages/ventas/ventas.php?accion=listar",
                    dataSrc:""
                },
                columns:[
                    {
                        data:"venta_id",
                    },
                    {
                        data:"nombre",
                    },
                    {
                        data:"monto"
                    },
                    {
                        data:"dinero_cliente"
                    },
                    {
                        data:"cambio"
                    },
                    {
                        data:"fecha_venta"
                    },
                    {
                        data:"hora_venta"
                    },
                    {
                        data:null,
                        orderable:false
                    }
                ],
                columnDefs:[
                    {
                        targets:7,
                        defaultContent:"<button class='btn btn-success' id='btnVer'  data-toggle='modal' data-target='#modal-editar'>Ver</button>",
                        data:null
                    }
                ]
            });

            // Refilter the table
            $('#min, #max').on('change', function() {
                tablaVentas.draw();

            });

            // ?VISUALIZAR VENTA
            $('#tablaVentas').on('click','#btnVer',function(){
                let venta_id = tablaVentas.row($(this).parents('tr')).data().venta_id;
                $.ajax({
                    type: "GET",
                    url: "./../../dist/php/pages/ventas/ventas.php?accion=producto&venta_id="+venta_id,
                    dataType: "JSON",
                    success: function (response) {
                        let datosProductos = '';
                        $('#fechaVenta').text(`Fecha: ${response[0].fecha_venta}`);
                        $('#ventaId').text(`#${response[0].venta_id}`);
                        $('#nombreEmpleado').text(response[0].nombre_empleado);
                        $('#empleadoId').text(`# ${response[0].empleado_id}`);
                        for (const iterator of response) {
                            datosProductos+= `
                            <tr>
                                <td>${iterator.productos_id}</td>
                                <td>${iterator.nombre_producto}</td>
                                <td>${iterator.precio_producto}</td>
                                <td>${iterator.cantidad}</td>
                                <td>$${iterator.total_x_producto}</td>
                            </tr>
                            `
                        }
                        $('#datosProductos').html(datosProductos);
                        $('#dineroCliente').text(`$${response[0].dinero_cliente}`);
                        $('#total').text(`$${response[0].monto}`);
                        $('#cambio').text(`$${response[0].cambio}`);
                        
                        

                    },
                    error:function(){
                        console.log('Error en el servidor');
                    }
                });
            });
})