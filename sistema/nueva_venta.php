<?php

session_start();
include "../conexion.php";


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php include "include/script.php"; ?>

    <title>Nueva Cotización</title>
</head>

<body>
    <?php include "include/header.php"; ?>
    <section id="container d-flex justify-content-center">
        <div class="container">
            <div class="title_page">
                <h1 class="mb-5">Nueva Cotización</h1>
            </div>
            <div class="datos_cliente">
                <div class="action_cliente">
                    <h4>Datos de cliente</h4>
                    <button class="btn_new_cliente btn_new btn btn-primary" id="btn_new_cliente">Nuevo cliente</button>
                </div>
            </div>
        </div>
        <div class="container d-flex justify-content-center mb-4">
            <div class="row col-6">
                <form id="form_new_cliente_venta">
                    <input type="hidden" name="action" value="addCliente">
                    <input type="hidden" name="idcliente" id="idcliente" value="" required>
                    <div class="row mb-3">
                        <label for="nit_cliente" class="col-sm-2 col-form-label">Nit</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nit_cliente" name="nit_cliente" placeholder="Ingrese Nit">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputNombre" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputNombre" name="nom_cliente" placeholder="Ingrese su nombre completo" disabled required>
                        </div>
                    </div>
                    <!-- <div class="row mb-3">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Correo electrónico</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" placeholder="Ingrese su correo electrónico">
                    </div>
                </div> -->
                    <div class="row mb-3">
                        <label for="inputTelefono" class="col-sm-2 col-form-label">Teléfono</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="inputTelefono" name="tel_cliente" placeholder="Ingrese su número de teléfono" disabled required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputDireccion" class="col-sm-2 col-form-label">Dirección</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputDireccion" name="dir_cliente" placeholder="Ingrese su dirección" disabled required>
                        </div>
                    </div>
                    <!-- <div class="row mb-3">
                    <label for="inputCiudad" class="col-sm-2 col-form-label">Ciudad</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputCiudad" placeholder="Ingrese su ciudad">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPais" class="col-sm-2 col-form-label">País</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputPais" placeholder="Ingrese su país">
                    </div>
                </div> -->
                    <div id="div_registro_cliente">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>

        </div>
        <div class="container">
            <div class="datos_venta">
                <h4>Datos de venta</h4>
            </div>
            <div class="row col-6 mb-5">
                <div class="container">
                    <div class="row mb-3">
                        <label for="inputTelefono" class="col-sm-2 col-form-label">Vendedor</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" value="<?php echo $_SESSION['nombre']; ?>" aria-label="Disabled input example" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputTelefono" class="col-sm-2 col-form-label">Acciones</label>
                        <div class="col-sm-10">
                            <a href="#" type="button" class="btn btn-warning">Anular</a>
                            <a href="#" type="button" class="btn btn-primary">Procesar</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container ">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="table-primary">
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Existencia</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Precio Total</th>
                                <th>Acción</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="txt_cod_producto" id="txt_cod_producto"></td>
                                <td id="text_descripcion">Producto</td>
                                <td id="text_existencia">10</td>
                                <td><input type="text" name="text_cant_producto" min="1" value="2"></td>
                                <td id="text_precio" class="text-right">$20</td>
                                <td id="text_precio_total" class="text-right">$40</td>
                                <td class="d-flex justify-content-center"><a href="#" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                        </svg></a></td>
                            </tr>
                            <tr class="table-primary">
                                <th>Codigo</th>
                                <th colspan="2">Producto</th>
                                <th>Cantidad</th>
                                <th id="text_precio">Precio</th>
                                <th id="text_precio_total">Precio Total</th>
                                <th>Acción</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td colspan="2">Mause USB</td>
                                <td>1</td>
                                <td class="right-align">100.00</td>
                                <td class="right-align">100.00</td>
                                <td class="d-flex justify-content-center"><a class="link_delete btn btn-danger" href="#" onclick="event.preventDefault(); del_product_detalle(1);"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                        </svg></a></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td colspan="2">teclado USB</td>
                                <td>1</td>
                                <td class="right-align">100.00</td>
                                <td class="right-align">100.00</td>
                                <td class="d-flex justify-content-center"><a class="link_delete btn btn-danger" href="#" onclick="event.preventDefault(); del_product_detalle(1);"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                        </svg></a></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="right-align bold-text">SUBTOTAL</td>
                                <td class="text-right">8.000</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="right-align bold-text">IVA 19%</td>
                                <td class="text-right">2000</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="right-align bold-text">TOTAL</td>
                                <td class="text-right">10.000</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>

    </section>
    <?php include "include/footer.php"; ?>
    <script src="js/nuevaVenta.js"></script>
</body>

</html>