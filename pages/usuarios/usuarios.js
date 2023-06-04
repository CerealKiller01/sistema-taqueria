$(function () {
  let Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
  });

  // * Listar datos de la tabla usuarios con Datatables
  let tablaUsuarios = $("#tablaUsuarios").DataTable({
    ajax: {
      url: "./../../dist/php/pages/usuarios/usuarios.php?accion=listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "usuario_id",
      },
      {
        data: "username",
      },
      {
        data: "empleado_id",
      },
      {
        data: null,
        orderable: false,
      },
    ],
    columnDefs: [
      {
        targets: 3,
        defaultContent:
          "<button class='btn btn-sm btn-primary' id='botonEditar' data-toggle='modal' data-target='#modal-editar'>Editar</button>  <button class='btn btn-sm btn-success ' id='botonVisualizar' data-toggle='modal' data-target='#modal-visualizar'>Visualizar</button>",
        data: null,
      },
    ],
  });

  // *Visualizar informacion del usuario
  $("#tablaUsuarios").on("click", "#botonVisualizar", function () {
    let empleadoId = tablaUsuarios
      .row($(this).parents("tr"))
      .data().empleado_id;
    $.ajax({
      type: "GET",
      url:
        "./../../dist/php/pages/usuarios/usuarios.php?accion=visualizar&empleadoId=" +
        empleadoId,
      dataType: "JSON",
      success: function (response) {
        for (const iterator of response) {
          $("#empleadoId").html(
            `<strong>Empleado #${iterator.empleado_id}</strong>`
          );
          $("#nombreCompleto").html(
            `<strong>Nombre completo: </strong> ${
              iterator.nombre +
              " " +
              iterator.apellido_paterno +
              " " +
              iterator.apellido_materno
            }`
          );
          $("#telefono").html(
            `<strong>Telefono: </strong> ${iterator.telefono}`
          );
          $("#rol").html(
            `<strong>Rol: </strong>${
              iterator.rol == 0
                ? "Mesero"
                : iterator.rol == 1
                ? "Cajero"
                : "Administrador"
            }`
          );
          $("#fechaRegistro").html(
            `<strong>Fecha de registro: </strong>${
              iterator.fecha_registro_empleado +
              " " +
              iterator.hora_registro_empleado
            }`
          );
        }
      },
      error: function () {
        console.log("Error en el servidor");
      },
    });
  });
  // *Editar nombre de usuario
  $("#tablaUsuarios").on("click", "#botonEditar", function () {
    let usuario_id = tablaUsuarios.row($(this).parents("tr")).data().usuario_id;
    $.ajax({
      type: "GET",
      url:
        "./../../dist/php/pages/usuarios/usuarios.php?accion=verificar&usuario_id=" +
        usuario_id,
      dataType: "JSON",
      success: function (response) {
        $("#usuarioId").html(
          `<strong>Usuario # ${response[0].usuario_id}</strong>`
        );
        $("#input_usuario_id").val(response[0].usuario_id);
        $("#username").val(response[0].username);
      },
      error: function () {
        console.log("Error en el servidor");
      },
    });
  });
  //*Actualizar nombre de usuario
  $("#actualizarUsuario").on("click", function () {
    let datosActualizar = {
      input_usuario_id: $("#input_usuario_id").val(),
      username: $("#username").val(),
    };
    $.ajax({
      type: "GET",
      url: "./../../dist/php/pages/usuarios/usuarios.php?accion=actualizar",
      data: datosActualizar,
      dataType: "JSON",
      success: function (response) {
        Toast.fire({
          icon: "success",
          title: "Usuario actualizado con exito",
        });
        console.log(response);
        tablaUsuarios.ajax.reload();
      },
      error: function () {
        console.log("Error en el servidor");
      },
    });
  });

  // * Redireccionar a registroUsuario.php
  $("#btnRegistroUsuario").on("click", function () {
    window.location = "./registroUsuario.php";
  });
});
