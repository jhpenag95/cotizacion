<?php

session_start();

if ($_SESSION['rol'] != 1) {
    header(("location: ./"));
}

include "../conexion.php";
if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['rol'])) {
        $alert = '<p class="msg_error alertas-p"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill mx-2" viewBox="0 0 16 16">
		<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
	  </svg>Todos los campos son obligatorio</p>';
    } else {
        $idusuario = $_POST['idUsuario'];
        $nombre = $_POST['nombre'];
        $email = $_POST['correo'];
        $user = $_POST['usuario'];
        $clave = md5($_POST['clave']);
        $rol = $_POST['rol'];


        $query = mysqli_query($conexion, "SELECT * FROM usuario WHERE (usuario = '$user' AND idusuario != $idusuario)  OR (correo = '$email' AND idusuario != $idusuario)");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<p class="msg_error alertas-p"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill mx-2" viewBox="0 0 16 16">
			<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
		  </svg>El correo o el usuario ya existe</p>';
        } else {
            if (empty($_POST['clave'])) {

                $sql_update = mysqli_query($conexion, "UPDATE usuario SET nombre = '$nombre', correo = '$email', usuario = '$user', rol = '$rol' WHERE idusuario = $idusuario");
            } else {

                $sql_update = mysqli_query($conexion, "UPDATE usuario SET nombre = '$nombre', corre = '$email', usuario = '$user', clave = '$clave', rol = '$rol' WHERE idusuario = $idusuario");
            }

            if ($sql_update) {

                $alert = '<p class="msg_save alertas-p"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill mx-2" viewBox="0 0 16 16">
				<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
			  </svg>Usuario actualizado correctamente</p>';
            } else {
                $alert = '<p class="msg_error alertas-p"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill mx-2" viewBox="0 0 16 16">
				<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
			  </svg>Error al actualizar usuario</p>';
            }
        }
    }
    mysqli_close($conexion);
}

//Mostrar datos

if (empty($_GET['id'])) {
    header('location: lista_usuarios.php');
    mysqli_close($conexion);
}

include "../conexion.php";
$iduser = $_GET['id'];

$sql = mysqli_query($conexion, "SELECT u.idusuario, u.nombre, u.correo, u.usuario, (u.rol) as idrol, (r.rol) as rol 
                                FROM usuario u 
                                INNER JOIN rol r 
                                on u.rol = r.idrol 
                                WHERE idusuario = $iduser");
mysqli_close($conexion);
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
    header('location: lista_usuarios.php');
} else {

    $option = '';

    while ($data = mysqli_fetch_array($sql)) {
        $iduser = $data['idusuario'];
        $nombre = $data['nombre'];
        $correo = $data['correo'];
        $usuario = $data['usuario'];
        $idrol = $data['idrol'];
        $rol = $data['rol'];

        if ($idrol == 1) {
            $option = '<option value="' . $idrol . '" select>' . $rol . '</option>';
        } elseif ($idrol == 2) {
            $option = '<option value="' . $idrol . '" select>' . $rol . '</option>';
        } elseif ($idrol == 3) {
            $option = '<option value="' . $idrol . '" select>' . $rol . '</option>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <?php include "include/script.php" ?>
    <title>Actualizar Usuario</title>
</head>

<body>
    <?php include "include/header.php" ?>
    <section id="container">
        <div class="form_register container w-50">
            <h1>Actualizar Usuario</h1>
            <hr>
            <div class="alerta">
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="container">
                <form class="row g-3 needs-validation" action="" method="post" novalidate>
                    <input type="hidden" name="idUsuario" value="<?php echo $iduser ?>">
                    <div class="col-md-4 position-relative">
                        <label for="validationTooltip01" class="form-label">Nombres</label>
                        <input type="text" class="form-control" name="nombre" id="validationTooltip01" placeholder="Nombre Completo" value="<?php echo $nombre ?>">
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="validationTooltip02" class="form-label">Correo</label>
                        <input type="text" class="form-control" name="correo" id="validationTooltip02" placeholder="Correo Eléctronico" value="<?php echo $correo ?>">
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="validationTooltipUsername" class="form-label">Usuario</label>
                        <div class="input-group has-validation">
                            <input type="text" class="form-control" name="usuario" id="validationTooltipUsername" aria-describedby="validationTooltipUsernamePrepend" placeholder="usuario" value="<?php echo $user ?>">
                        </div>
                    </div>
                    <div class="col-md-6 position-relative">
                        <label for="validationTooltip03" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="clave" id="validationTooltip03" placeholder="Contraseña" required>
                    </div>

                    <?php

                    include "../conexion.php";
                    $query_rol = mysqli_query($conexion, "SELECT * FROM rol");
                    mysqli_close($conexion);
                    $resul_rol = mysqli_num_rows($query_rol);
                    ?>


                    <div class="col-md-3 position-relative">
                        <label for="validationTooltip04" class="form-label">Rol</label>
                        <select class="form-select notitemOne" name="rol" id="validationTooltip04" required>
                            <?php
                            echo $option;

                            if ($resul_rol > 0) {
                                while ($rol = mysqli_fetch_array($query_rol)) {
                            ?>
                                    <option value="<?php echo $rol['idrol'] ?>"><?php echo $rol["rol"] ?></option>

                            <?php
                                }
                            }

                            ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <button id="mi-boton" class="btn btn-success" type="submit">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <?php include "include/footer.php" ?>
    <!-- <script src="js/btnAlertaCrearUsuario.js"></script> -->
</body>

</html>