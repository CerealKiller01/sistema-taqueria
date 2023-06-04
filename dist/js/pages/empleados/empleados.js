$(function(){
    var table = $('#example').DataTable();

    /* Redireccionar a registroEmpleados.php  */
    $('#btnRegistroEmpleados').on('click',function(){
        window.location='./registroEmpleados.php';
    });
});