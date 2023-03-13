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

    if (producto != "") {
      $.ajax({
        url: "ajax.php",
        type: "POST",
        async: true,
        data: { action: action, producto: producto },

        success: function (response) {
          if (response != "error") {
            var info = JSON.parse(response);

            $("#text_descripcion").html(info.descripcion);
            $("#text_existencia").html(info.existencia);
            $("#text_cant_producto").val("1");
            $("#text_precio").html(info.precio);
            $("#text_precio_total").html(info.precio);

            //Activar catidad
            $("#text_cant_producto").removeAttr("disabled");

            //Mostrar boton agregar
            $("#add_product_venta").slideDown();
          } else {
            $("#text_descripcion").html("-");
            $("#text_existencia").html("-");
            $("#text_cant_producto").val("0");
            $("#text_precio").html("0.00");
            $("#text_precio_total").html("0.00");

            //Bloquear catidad
            $("#text_cant_producto").attr("disabled", "disabled");

            //Bloquear boton agregar
            $("#add_product_venta").slideUp();
          }
        },

        error: function (error) {
          console.error(error);
        },
      });
    }
  }
});

//Validar cantidad de producto antes de agregar

$("#text_cant_producto").keyup(function (e) {
  e.preventDefault();

  var precio_total = $(this).val() * $("#text_precio").html();
  var existencia = parseInt($("#text_existencia").html());
  $("#text_precio_total").html(precio_total);

  //Oculta boton agregar si la cantidad es menor a 1

  if ($(this).val() < 1 || isNaN($(this).val()) || $(this).val() > existencia) {
    $("#add_product_venta").slideUp();
  } else {
    $("#add_product_venta").slideDown();
  }
});

//Agregar productos al detalle

$("#add_product_venta").click(function (e) {
  e.preventDefault();

  if ($("#text_cant_producto").val() > 0) {
    var codproducto = $("#txt_cod_producto").val();
    var cantidad = $("#text_cant_producto").val();
    var action = "addProductoDetalle";

    $.ajax({
      url: "ajax.php",
      type: "POST",
      async: true,
      data: { action: action, producto: codproducto, cantidad: cantidad },

      success: function (response) {
        if (response != "error") {
          var info = JSON.parse(response);
          $("#detalle_venta").html(info.detalle);
          $("#detalle_totales").html(info.totales);

          //limpiar campos
          $("#txt_cod_producto").val("");
          $("#text_descripcion").html("-");
          $("#text_existencia").html("-");
          $("#text_cant_producto").val("0");
          $("#text_precio").html("0.00");
          $("#text_precio_total").html("0.00");

          //Bloquear Cantidad
          $("#text_cant_producto").attr("disabled", "disabled");

          //Ocualtar boton agregar
          $("#add_product_venta").slideUp();
        } else {
          console.log("no data");
        }
        viewProcesar();
      },

      error: function (error) {
        console.error(error);
      },
    });
  }
});

//Eliminar el producto de la venta

function del_product_detalle(correlativo) {
  var action = "delProductoDetalle";
  var id_detalle = correlativo;

  $.ajax({
    url: "ajax.php",
    type: "POST",
    async: true,
    data: { action: action, id_detalle: id_detalle },

    success: function (response) {
      if (response != "error") {
        var info = JSON.parse(response);

        $("#detalle_venta").html(info.detalle);
        $("#detalle_totales").html(info.totales);

        //limpiar campos
        $("#txt_cod_producto").val("");
        $("#text_descripcion").html("-");
        $("#text_existencia").html("-");
        $("#text_cant_producto").val("0");
        $("#text_precio").html("0.00");
        $("#text_precio_total").html("0.00");

        //Bloquear Cantidad
        $("#text_cant_producto").attr("disabled", "disabled");

        //Ocualtar boton agregar
        $("#add_product_venta").slideUp();
      } else {
        $("#detalle_venta").html("");
        $("#detalle_totales").html("");
      }
      viewProcesar();
    },

    error: function (error) {
      console.error(error);
    },
  });
}

//Mostar / Ocultar bton Procesar

function viewProcesar() {
  if ($("#detalle_venta tr").length > 0) {
    $("#btn_facturar_venta").show();
  } else {
    $("#btn_facturar_venta").hide();
  }
}

function serchForDetalle(id) {
  var action = "serchForDetalle";
  var user = id;

  $.ajax({
    url: "ajax.php",
    type: "POST",
    async: true,
    data: { action: action, user: user },

    success: function (response) {
      if (response != "error") {
        var info = JSON.parse(response);
        $("#detalle_venta").html(info.detalle);
        $("#detalle_totales").html(info.totales);
      } else {
        console.log("no data");
      }
      viewProcesar();
    },

    error: function (error) {
      console.error(error);
    },
  });
}

//Anular Venta

$("#btn_anular_venta").click(function (e) {
  e.preventDefault();

  var row = $("#detalle_venta tr").length;

  if (row > 0) {
    var action = "anularVenta";

    $.ajax({
      url: "ajax.php",
      type: "POST",
      async: true,
      data: { action: action },

      success: function (response) {

        if (response != 'error') {
          location.reload();
        }
      },

      error: function (error) {
        console.error(error);
      },
    });
  }
});


// facturar venta - Boton procesar
$("#btn_facturar_venta").click(function (e) {
  e.preventDefault();

  var row = $("#detalle_venta tr").length;

  if (row > 0) {
    var action = "procesarVenta";
    var codcliente = $('#idcliente').val();

    $.ajax({
      url: "ajax.php",
      type: "POST",
      async: true,
      data: { action: action, codcliente: codcliente },

      success: function (response) {
        if (response != 'error') {

          var info = JSON.parse(response);
          //console.log(info);

          location.reload();//recarga la pagina

          generarPDF(info.codcliente,info.nofactura);

        }else{
          console.log('no data');
        }
      },

      error: function (error) {
        console.error(error);
      },
    });
  }
});

//Genera PDF venta

function generarPDF(cliente, factura) {
  var ancho = 1000;
  var alto = 800;

  //Calcular posición x,y para centrar ventana 
  var x = parseInt((window.screen.width/2) - (ancho / 2));
  var y = parseInt((window.screen.width/2) - (alto / 2));

  $url = 'factura/generaFactura.php?cl='+cliente+'&f='+factura;
  window.open($url,"cotizacion","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");

}
