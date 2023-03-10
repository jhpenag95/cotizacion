$(document).ready(function () {
  //--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
  $("#foto").on("change", function () {
    var uploadFoto = document.getElementById("foto").value;
    var foto = document.getElementById("foto").files;
    var nav = window.URL || window.webkitURL;
    var contactAlert = document.getElementById("form_alert");

    if (uploadFoto != "") {
      var type = foto[0].type;
      var name = foto[0].name;
      if (type != "image/jpeg" && type != "image/jpg" && type != "image/png") {
        contactAlert.innerHTML =
          '<p class="errorArchivo">El archivo no es válido.</p>';
        $("#img").remove();
        $(".delPhoto").addClass("notBlock");
        $("#foto").val("");
        return false;
      } else {
        contactAlert.innerHTML = "";
        $("#img").remove();
        $(".delPhoto").removeClass("notBlock");
        var objeto_url = nav.createObjectURL(this.files[0]);
        $(".prevPhoto").append("<img id='img' src=" + objeto_url + ">");
        $(".upimg label").remove();
      }
    } else {
      alert("No selecciono foto");
      $("#img").remove();
    }
  });

  $(".delPhoto").click(function () {
    $("#foto").val("");
    $(".delPhoto").addClass("notBlock");
    $("#img").remove();

    if ($("#foto_actual") && $("#foto_remove")) {
      $("#foto_remove").val("img_producto.png");
    }
  });

  //****************modal*******************//

  $(document).ready(function () {
    $(".add_product").click(function (e) {
      e.preventDefault();
      var producto = $(this).data("product");
      var action = "infoProducto";

      $.ajax({
        url: "ajax.php",
        type: "POST",
        async: true,
        data: { action: action, producto: producto },

        success: function (response) {
          if (response != "error") {
            var info = JSON.parse(response);

            //$("#producto_id").val(info.codproducto);
            //$(".nameProducto").html(info.descripcion);

            $(".bodyModal").html(
              '<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); sentDataProduct();">' +
                '<h1><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16"><path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.                              044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5                               1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.                             045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5                             0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z" /></svg><br>Agregar Producto</h1>' +
                '<h2 class="nameProducto">' +
                info.descripcion +
                "</h2><br>" +
                '<input class="form-control" type="number" name="cantidad" id="txtCantidad" placeholder="Cantidad del producto" required><br>' +
                '<input class="form-control" type="text" name="precio" id="txtPrecio" placeholder="Precio del producto" required>' +
                '<input type="hidden" name="producto_id" id="producto_id" value="' +
                info.codproducto +
                '" required>' +
                '<input type="hidden" name="action" value="addProduct" required>' +
                '<div class="alert alertAddProduct"></div>' +
                '<button type="submit" class="btn btn-success btn btn_new mx-2">Agregar</button>' +
                '<a href="#" class="btn btn-danger btn_ok closeModal" onclick="closeModal();">Cerrar</a>' +
                "</form>"
            );
          }
        },

        error: function (error) {
          console(error);
        },
      });

      $(".mymodal").fadeIn();
    });
  });

  /**============Modal elimiar producto=================== */
  $(document).ready(function () {
    $(".del_product").click(function (e) {
      e.preventDefault();
      var producto = $(this).data("product");
      var action = "infoProducto";

      $.ajax({
        url: "ajax.php",
        type: "POST",
        async: true,
        data: { action: action, producto: producto },

        success: function (response) {
          if (response != "error") {
            var info = JSON.parse(response);

            //$("#producto_id").val(info.codproducto);
            //$(".nameProducto").html(info.descripcion);

            $(".bodyModal").html(
              '<form action="" method="post" name="form_del_product" id="form_del_product" onsubmit="event.preventDefault(); delProduct();">' +
                '<h1><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16"><path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.                              044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5                               1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.                             045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5                             0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z" /></svg><br>Elimiar Producto</h1>' +
                '<div class="container d-flex justify-content-center flex-column">' +
                '<p class="text-center">¿Está seguro de eliminar el siguiente producto?</p>' +
                "</div>" +
                '<h2 class="nameProducto" style="color: red;">' +
                info.descripcion +
                "</h2><br>" +
                '<input type="hidden" name="producto_id" id="producto_id" value="' +
                info.codproducto +
                '" required>' +
                '<input type="hidden" name="action" value="delProduct" required>' +
                '<div class="alerta alertAddProduct"></div>' +
                '<a href="#" type="button" class="btn btn-warning" onclick="closeModal();">cerrar</a>' +
                '<input href="#" type="submit" class="btn btn-danger mx-2" value="Eliminar"></input>' +
                "</form>"
            );
          }
        },

        error: function (error) {
          console(error);
        },
      });

      $(".mymodal").fadeIn();
    });
  });
});

/*****************Eliminar datos desde el formulario modal almacenar**************** */
function delProduct() {
  var pr = $("producto_id").val();

  $(".alertAddProduct").html("");

  $.ajax({
    url: "ajax.php",
    type: "POST",
    async: true,
    data: $("#form_del_product").serialize(),

    success: function (response) {
      console.log(response);
      if (response == "error") {
        $(".alertAddProduct").html(
          '<p style="color: red;">Error al elimiar Producto</p>'
        );
      } else {
        $(".row" + pr).remove();
        $("#form_del_product .btn_ok").remove();
        $(".alertAddProduct").html("<p>Producto eliminado correctamente</p>");
      }
    },

    error: function (error) {
      console.error(error);
    },
  });
}
/*****************Enviar datos desde el formulario modal almacenar**************** */
function sentDataProduct() {
  $(".alertAddProduct").html("");

  $.ajax({
    url: "ajax.php",
    type: "POST",
    async: true,
    data: $("#form_add_product").serialize(),

    success: function (response) {
      if (response == "error") {
        $(".alertAddProduct").html(
          '<p style="color: red;">Error al agregar Producto</p>'
        );
      } else {
        var info = JSON.parse(response);
        $(".row" + info.producto_id + ".celPrecio").html(info.nuevo_precio);
        $(".row" + info.producto_id + ".celExistencia").html(
          info.nueva_existencia
        );
        $("#txtCantidad").val("");
        $("#txtPrecio").val("");
        $(".alertAddProduct").html("<p>Producto guardado correctamente</p>");
      }
    },

    error: function (error) {
      console.error(error);
    },
  });
}

/**btn Cerrar modal */
function closeModal() {
  $(".alertAddProduct").html("");
  $("#txtCantidad").val("");
  $("#txtPrecio").val("");
  $(".mymodal").fadeOut();
  location.reload();
}
