$(function () {
  let Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
  });
  // * Redireccionar a registroEmpleados.php
  $("#btnRegistroEmpleados").on("click", function () {
    window.location = "./registroEmpleados.php";
  });
  // * Listar datos de la tabla empleados con DataTable
  let tablaEmpleados = $("#tablaEmpleados").DataTable({
    ajax: {
      url: "./../../dist/php/pages/empleados/empleados.php?accion=listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "empleado_id",
      },
      {
        data: "nombre",
      },
      {
        data: "apellido_paterno",
      },
      {
        data: "apellido_materno",
      },
      {
        data: "telefono",
      },
      {
        data: "rol",
      },
      {
        data: "fecha_registro_empleado",
      },
      {
        data: "hora_registro_empleado",
      },
      {
        data: "usuario_id",
      },
      {
        data: null,
        orderable: false,
      },
    ],
    columnDefs: [
      {
        targets: 5,
        data: "rol",
        render: function (data) {
          if (data == 0) {
            return "Mesero";
          } else if (data == 1) {
            return "Cajero";
          } else {
            return "Administrador";
          }
        },
      },
      {
        targets: 9,
        defaultContent:
          "<button class='btn btn-sm btn-primary' id='botonEditar' data-toggle='modal' data-target='#modal-editar'>Editar</button> <button class='btn btn-sm btn-danger' id='botonBorrar'>Borrar</button>",
        data: null,
      },
    ],
  });

  // * Eliminar empleado al presionar el boton de borrar
  $("#tablaEmpleados").on("click", "#botonBorrar", function () {
    let empleado_id = tablaEmpleados
      .row($(this).parents("tr"))
      .data().empleado_id;
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
          url:
            "./../../dist/php/pages/empleados/empleados.php?accion=borrar&empleado_id=" +
            empleado_id,
          dataType: "JSON",
          success: function (response) {
            tablaEmpleados.ajax.reload();
          },
          error: function () {
            console.log("Error en el servidor");
          },
        });
        Swal.fire("!Eliminado!", "Registro eliminado con exito", "success");
      }
    });
  });

  // * Cargar datos para editar
  $("#tablaEmpleados").on("click", "#botonEditar", function () {
    let empleado_id = tablaEmpleados
      .row($(this).parents("tr"))
      .data().empleado_id;
    $.ajax({
      type: "GET",
      url:
        "./../../dist/php/pages/empleados/empleados.php?accion=visualizar&empleado_id=" +
        empleado_id,
      dataType: "JSON",
      success: function (response) {
        $("#input_empleado_id").val(response[0].empleado_id);
        $("#empleadoId").html(
          `<strong>Empleado #${response[0].empleado_id}</strong>`
        );
        $("#nombre").val(response[0].nombre);
        $("#apellido_paterno").val(response[0].apellido_paterno);
        $("#apellido_materno").val(response[0].apellido_materno);
        $("#telefono").val(response[0].telefono);
        $(`#rol option:eq(${parseInt(response[0].rol) + 1})`).prop(
          "selected",
          true
        );
      },
      error: function () {
        console.log("Error en el servidor");
      },
    });
  });
  //*Actualizar datos
  $("#actualizarEmpleado").on("click", function () {
    let datosEmpleado = {
      input_empleado_id: $("#input_empleado_id").val(),
      nombre: $("#nombre").val(),
      apellido_paterno: $("#apellido_paterno").val(),
      apellido_materno: $("#apellido_materno").val(),
      telefono: $("#telefono").val(),
      rol: $("#rol").val(),
    };
    $.ajax({
      type: "GET",
      url: "./../../dist/php/pages/empleados/empleados.php?accion=actualizar",
      data: datosEmpleado,
      dataType: "JSON",
      success: function (response) {
        Toast.fire({
          icon: "success",
          title: "Empleado actualizado con exito.",
        });
        tablaEmpleados.ajax.reload();
      },
      error: function () {
        console.log("Error en el servidor");
      },
    });
  });
});
