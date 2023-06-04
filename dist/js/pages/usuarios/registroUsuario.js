$(function(){
    $('#formularioUsuarios').on('submit',function(){
        let datosFormulario={
            username:$('#username').val(),
            empleado_id:$('#empleado_id').val(),
            password:$('#password').val(),
            rpassword:$('#rpassword').val()
        }
        $.ajax({
            type: "POST",
            url: "./../../dist/php/pages/usuarios/registroUsuarios.php",
            data: datosFormulario,
            dataType: "HTML",
            success: function (response) {
                window.location="./usuarios.php";
            },
            error:function(){
                console.log('errorResponse');
            }
        });
        return false;
    });
})