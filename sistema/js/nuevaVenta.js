//activar canpos para registrar cliente

$(document).ready(function () {
  // Manejar el clic en el botón
  $(".btn_new_cliente").click(function (e) {
    e.preventDefault();
    $("#inputNombre").removeAttr("disabled");
    $("#inputTelefono").removeAttr("disabled");
    $("#inputDireccion").removeAttr("disabled");
    $("#div_registro_cliente").slideDown();
  });
});

//Buscar Cliente

$("#nit_cliente").keyup(function (e) {
  e.preventDefault();

  var cl = $(this).val();
  var action = "searchCliente";

  $.ajax({
    url: "ajax.php",
    type: "POST",
    async: true,
    data: { action: action, cliente: cl },

    success: function (response) {
      if (response == 0) {
        $("#idcliente").val("");
        $("#inputNombre").val("");
        $("#inputTelefono").val("");
        $("#inputDireccion").val("");

        //mostrar boton agregar
        $("#btn_new_cliente").slideDown();
      } else {
        var data = $.parseJSON(response);
        $("#idcliente").val(data.idcliente);
        $("#inputNombre").val(data.nombre);
        $("#inputTelefono").val(data.telefono);
        $("#inputDireccion").val(data.direccion);

        //oculta boton agregar
        $("#btn_new_cliente").slideUp();

        //Bloquee campos
        $("#inputNombre").attr("disabled", "disabled");
        $("#inputTelefono").attr("disabled", "disabled");
        $("#inputDireccion").attr("disabled", "disabled");

        //oculta boton guardar
        $("#div_registro_cliente").slideUp();
      }
    },

    error: function (error) {
      console(error);
    },
  });
});

// Crear cliente - ventas

$("#form_new_cliente_venta").submit(function (e) {
  e.preventDefault();
  $.ajax({
    url: "ajax.php",
    type: "POST",
    async: true,
    data: $("#form_new_cliente_venta").serialize(),

    success: function (response) {
      if (response != "error") {
        //Agrega id a input hidden
        $("#idcliente").val(response);
        //Bloquean campos
        $("#inputNombre").attr("disabled", "disabled");
        $("#inputTelefono").attr("disabled", "disabled");
        $("#inputDireccion").attr("disabled", "disabled");

        //Ocultar boton agregar
        $("#btn_new_cliente").slideUp();

        //oculta boton guardar
        $("#div_registro_cliente").slideUp();
      }
    },

    error: function (error) {
      console(error);
    },
  });
});


// Buscar Producto - Ventas
$("#txt_cod_producto").keyup(function (e) {
  e.preventDefault();

  // Obtener el valor actual del campo de texto
  var producto = $(this).val();
  
  // Comprobar si el valor es una cadena no vacía
  if (producto !== "") {
    var action = "infoProducto";

    $.ajax({
      url: "ajax.php",
      type: "POST",
      async: true,
      data: { action: action, producto: producto },

      success: function (response) {
        console.log(response);
      },

      error: function (error) {
        console.error(error);
      },
    });
  }
});
