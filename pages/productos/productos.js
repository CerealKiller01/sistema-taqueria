$(function(){
    let Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
      });
        // *Formatos permitidos
        const formato={
            jpg:"image/jpeg",
            png:"image/png"
        }
    // ? Listar datos en la tabla productos
    let tablaProductos = $('#tablaProductos').DataTable({
        
        ajax:{
            url:"./../../dist/php/pages/productos/productos.php?accion=listar",
            dataSrc:""
        },

        columns:[
            {
                data:"productos_id",
            },
            {
                data:"nombre",
            },
            {
                data:"nombre_categoria",
            },
            {
                data:"precio",
            },
            {
                data:"cantidad",

            },
            {
                data:"imagen",
            },
            {
                data:"fecha_registro_producto",
            },
            {
                data:"hora_registro_producto",
            },
            {
                data:null,
                orderable:false,
            }
        ],


        columnDefs:[
            {
                targets:5,
                data:"imagen",
                render:function(data, type, row, meta){
                    return '<img src="./../../dist/img/productos/' + data + '" alt="' + data + '" class="rounded-circle avatar" width="80px" height="53px"/>';
                }
            },
            {
                targets:8,
                defaultContent:
                "<button class='btn btn-sm btn-primary' id='botonEditar' data-toggle='modal' data-target='#modal-editar'>Editar</button> <button class='btn btn-sm btn-danger' id='botonBorrar'>Borrar</button>",
                data:null
            }
        ],

    });


    // ?Elimar producto
    $('#tablaProductos').on('click','#botonBorrar',function(){
        let productos_id = tablaProductos.row($(this).parents("tr")).data().productos_id;

        Swal.fire({
            title: "¿Estas seguro?",
            text: "¡Este cambio no se puede revertir!.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Continuar",
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "./../../dist/php/pages/productos/productos.php?accion=eliminar&productos_id="+productos_id,
                    dataType: "JSON",
                    success: function (response) {
                        tablaProductos.ajax.reload();
                        console.log(response);
                    },
                    error:function(){
                        console.log("Error en el servidor");
                    }
                });
              Swal.fire("!Eliminado!", "Registro eliminado con exito", "success");
            }
          });
        

    });
    // ?Consultar productos
    $('#tablaProductos').on('click','#botonEditar',function(){
        $('#file').val('');
        let productos_id = tablaProductos.row($(this).parents("tr")).data().productos_id;
        let nombre_categoria = tablaProductos.row($(this).parents("tr")).data().nombre_categoria;
        $.ajax({
            type: "GET",
            url: "./../../dist/php/pages/productos/productos.php?accion=consultar&productos_id="+productos_id,
            dataType: "JSON",
            success: function (response) {
                $('#productoId').html(`<strong>Producto #${response[0].productos_id}</strong>`);
                $('#input_producto_id').val(response[0].productos_id);
                $('#nombre').val(response[0].nombre);
                $('#previsualizarImagen').attr("src","./../../dist/img/productos/"+response[0].imagen);
                $('#precio').val(response[0].precio);
                $('#cantidad').val(response[0].cantidad);
                $(`#categoria option:contains(${nombre_categoria})`).prop("selected",true);
            },
            error:function(){
                console.log("Error en el servidor");
            }
        });
    });
    // * Previsualizar imagen y verificar su formato
    $('#file').on('change',function(){
        let archivo = this.files[0];
        let rutaArchivo= URL.createObjectURL(archivo);
        if(archivo.type == formato.jpg){
            $('#previsualizarImagen').attr('src',rutaArchivo);
        }else if(archivo.type == formato.png){
            $('#previsualizarImagen').attr('src',rutaArchivo);
        }else{
            $('#file').val('')
            $('#previsualizarImagen').attr('src','./../../dist/img/noimage.jpg');
        }
    });
    // ?Actualizar producto
    $('#actualizarProducto').on('submit',function(){
        $.ajax({
            type: "POST",
            url: "./../../dist/php/pages/productos/productos.php?accion=actualizar",
            data: new FormData(this),
            contentType:false,
            cache:false,
            processData:false,
            dataType: "JSON",
            success: function (response) {
                Toast.fire({
                    icon: "success",
                    title: "Categoria actualizada con exito.",
                  });
                $('#modal-editar').modal('hide');
                tablaProductos.ajax.reload();
            },
            error:function(){
                console.log("Error en el servidor");
            }
        });
        return false;
    });
    // ?Redireccionar a registro de productos
    $('#btnRegistroProducto').on('click',function(){
        window.location="./registroProductos.php";
    });

});