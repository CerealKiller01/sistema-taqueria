$(function(){
    // *Formatos permitidos
    const formato={
        jpg:"image/jpeg",
        png:"image/png"
    }
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
    // * Registrar producto
    $('#registroProducto').on('submit',function(){
        $.ajax({
            type: "POST",
            url: "./../../dist/php/pages/productos/registroProducto.php",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            dataType: "JSON",
            success: function (response) {
                window.location="./productos.php"
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