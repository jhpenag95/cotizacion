//Función para buscar en la tabla
$(document).ready(function () {
  $("#buscar").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#tabla_productos tbody tr").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });
});
