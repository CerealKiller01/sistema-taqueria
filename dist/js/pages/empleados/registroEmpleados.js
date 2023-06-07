$(function(){


  $('#registroEmpleados').on('submit',function(){
    let datosFormulario={
        nombre: $('#nombre').val(),
        apellidoPaterno: $('#apellidoPaterno').val(),
        apellidoMaterno: $('#apellidoMaterno').val(),
        telefono: $('#telefono').val(),
        email: $('#email').val(),
        rol: $('#rol').val()
    }
    $.ajax({
        type: "POST",
        url: "./../../dist/php/pages/empleados/registroEmpleado.php",
        data: datosFormulario,
        dataType: "JSON",
        success: function (response) {
            window.location="./empleados.php";
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