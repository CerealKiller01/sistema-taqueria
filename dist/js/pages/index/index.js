$(function(){


    $('#formularioLogin').on('submit',function(){
        $.ajax({
            type: "POST",
            url: "./dist/php/pages/index/index.php",
            data: new FormData(this),
            cache:false,
            contentType:false,
            processData:false,
            dataType: "JSON",
            success: function (response) {
                if(response.estado == "true"){
                    window.location="./pages/mostrarProductos/mostrarProductos.php";
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '¡Usuario o contraseña incorrectos!'
                      })
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
        return false;
    });

});