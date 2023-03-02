<?php
session_start();

include "../conexion.php";
if (!empty($_POST)) {
    $alert = '';
    if (empty(($_POST['nit_proveedor']) || empty(($_POST['proveedor'])) || empty(($_POST['contacto'])) || empty(empty($_POST['telefono'])) || empty($_POST['direccion']))) {
        $alert = '<p class="msg_error alertas-p"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill mx-2" viewBox="0 0 16 16">
		<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
	  </svg>Todos los campos son obligatorio</p>';
    } else {
        $nit_proveedor = $_POST['nit_proveedor'];
        $proveedor = $_POST['proveedor'];
        $contacto = $_POST['contacto'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $usuario_id = $_SESSION['idUser'];


        $query_insert = mysqli_query($conexion, "INSERT INTO proveedor (nit_proveedor,proveedor,contacto,telefono,direccion,usuario_id) VALUE ('$nit_proveedor','$proveedor','$contacto','$telefono','$direccion','$usuario_id')");

        if ($query_insert) {

            $alert = '<p class="msg_save alertas-p"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill mx-2" viewBox="0 0 16 16">
				<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
			  </svg>Proveedor creado correctamente</p>';
        } else {
            $alert = '<p class="msg_error alertas-p"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill mx-2" viewBox="0 0 16 16">
				<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
			  </svg>Error al guardar proveedor </p>';
        }
    }
    mysqli_close($conexion);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <?php include "include/script.php" ?>
    <title>Registro Proveedores</title>
</head>

<body>
    <?php include "include/header.php" ?>
    <section id="container">
        <div class="form_register container w-50">
            <h1>Registro de Proveedores</h1>
            <hr>
            <div class="alerta">
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="container">
                <form class="row g-3 needs-validation" action="" method="post" novalidate>
                    <div class="col-md-4 position-relative">
                        <label for="validationTooltip01" class="form-label">Nit proveedor</label>
                        <input type="number" class="form-control" name="nit_proveedor" id="validationTooltip01" placeholder="Nit Proveedor" required>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="validationTooltip01" class="form-label">Proveedor</label>
                        <input type="text" class="form-control" name="proveedor" id="validationTooltip01" placeholder="Nombre Proveedor" required>
                    </div>
                    <div class="col-md-6 position-relative">
                        <label for="validationTooltip01" class="form-label">Contacto</label>
                        <input type="text" class="form-control" name="contacto" id="validationTooltip01" placeholder="Nombre Completo del contacto" required>
                    </div>
                    <div class="col-md-5 position-relative">
                        <label for="validationTooltip02" class="form-label">Teléfono</label>
                        <input type="number" class="form-control" name="telefono" id="validationTooltip02" placeholder="Télefono del proveedor" required>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="validationTooltipUsername" class="form-label">Dirección</label>
                        <div class="input-group has-validation">
                            <input type="text" class="form-control" name="direccion" id="validationTooltipUsername" aria-describedby="validationTooltipUsernamePrepend" placeholder="Dirección proveedor" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <button id="mi-boton" class="btn btn-success" type="submit">Registrar Proveedor</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <?php include "include/footer.php" ?>
    <!-- <script src="js/btnAlertaCrearUsuario.js"></script> -->
</body>

</html>