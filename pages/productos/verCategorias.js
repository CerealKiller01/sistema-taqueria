$(function(){
    let Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
      });
    // * Listar categorias
   let tablaCategorias= $('#tablaCategorias').DataTable({
    ajax:{
        url:"./../../dist/php/pages/productos/verCategoria.php?accion=listar",
        dataSrc:"",
    },
    columns:[
        {
            data:"categoria_producto_id",
        },
        {
            data:"nombre_categoria",
        },
        {
            data:null,
            orderable:false
        },
    ],
    columnDefs:[
        {
            targets:2,
            // defaultContent:
            // "<button class='btn btn-sm btn-primary' id='botonEditar' data-toggle='modal' data-target='#modal-editar'>Editar</button> <button class='btn btn-sm btn-danger' id='botonBorrar'>Borrar</button>",
            defaultContent:
            "<button class='btn btn-sm btn-primary' id='botonEditar' data-toggle='modal' data-target='#modal-editar'>Editar</button>",
            data: null,
        }
    ]
   });

    //* Borrar categoria
   $('#tablaCategorias').on('click','#botonBorrar',function(){
    let categoria_producto_id = tablaCategorias.row($(this).parents("tr")).data().categoria_producto_id;
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
                url:"./../../dist/php/pages/productos/verCategoria.php?accion=borrar&categoria_producto_id="+categoria_producto_id,
                dataType: "JSON",
                success: function (response) {
                    tablaCategorias.ajax.reload();
                },
                error:function(){
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error Fatal!',
                        text: 'Un error inesperado ocurrio en el servidor.'
                      })
                }
            });
          Swal.fire("!Eliminado!", "Registro eliminado con exito", "success");
        }
      });

   });

   //* Cargar datos de categoria

   $('#tablaCategorias').on('click','#botonEditar',function(){
    let categoria_producto_id = tablaCategorias.row($(this).parents("tr")).data().categoria_producto_id;
    $.ajax({
        type: "GET",
        url:"./../../dist/php/pages/productos/verCategoria.php?accion=cargar&categoria_producto_id="+categoria_producto_id,
        dataType: "JSON",
        success: function (response) {
            $('#categoriaId').html(`<strong>Categoria: #${response[0].categoria_producto_id}</strong>`);
            $('#input_categoria_id').val(response[0].categoria_producto_id);
            $('#nombreCategoria').val(response[0].nombre_categoria);
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

    //* Actualizar categoria
    $('#actualizarCategoria').on('click',function(){
        let datos={
            input_categoria_id:$('#input_categoria_id').val(),
            nombreCategoria:$('#nombreCategoria').val()
        }
        $.ajax({
            type: "GET",
            url: "./../../dist/php/pages/productos/verCategoria.php?accion=actualizar",
            data: datos,
            dataType: "JSON",
            success: function (response) {
                tablaCategorias.ajax.reload();
                Toast.fire({
                    icon: "success",
                    title: "Categoria actualizada con exito.",
                  });
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
});