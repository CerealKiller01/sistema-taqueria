$(function(){
    // *Registrar categoria
    $('#registroCategoria').on('submit',function(){
        $.ajax({
            type: "POST",
            url: "./../../dist/php/pages/empleados/registroCategoria.php",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            dataType: "JSON",
            success: function (response) {
                window.location="./productos.php";
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
})