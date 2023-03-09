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
    <?php include "include/script.php"; ?>
    <title>Nueva Cotización</title>
</head>

<body>
    <?php include "include/header.php"; ?>
    <section id="container">
        <div class="title_page">
            <h1>Nueva Cotización</h1>
        </div>
        <div class="datos_cliente">
            <div class="action_cliente">
                <h4>Datos de cliente</h4>
                <a href="" class="btn_new btn_new_cliente">Nuevo cliente</a>
            </div>
        </div>
        <div class="container d-flex justify-content-center">
            <div class="row col-6">
                <form>
                    <input type="hidden" name="action" value="addCliente">
                    <input type="hidden" name="idcliente" id="idcliente" value="" required>
                    <div class="row mb-3">
                        <label for="inputNombre" class="col-sm-2 col-form-label">Nit</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputNombre" name="nit_cliente" placeholder="Ingrese Nit">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputNombre" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputNombre" name="nom_cliente" placeholder="Ingrese su nombre completo" required>
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
                            <input type="number" class="form-control" id="inputTelefono" name="tel_cliente" placeholder="Ingrese su número de teléfono" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputDireccion" class="col-sm-2 col-form-label">Dirección</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputDireccion" name="dir_cliente" placeholder="Ingrese su dirección" required>
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
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>
            </div>

        </div>
        <div class="datos_venta">
            <h4>Datos de venta</h4>
        </div>
    </section>
    <h1>Cotización</h1>
    <?php include "include/footer.php"; ?>
</body>

</html>