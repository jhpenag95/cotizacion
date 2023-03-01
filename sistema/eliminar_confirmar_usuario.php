<?php

session_start();

if ($_SESSION['rol'] != 1) {
	header(("location: ./"));
}

include "../conexion.php";

if (!empty($_POST)) {

    if ($_POST['idusuario'] == 1) {
        header('location: lista_usuarios.php');
        include "../conexion.php";
        exit;
    }

    $idusuario = $_POST['idusuario'];

    //$query_delete = mysqli_query($conexion, "DELETE  FROM usuario WHERE idusuario = $idusuario");
    $query_delete = mysqli_query($conexion, "UPDATE usuario SET estatus = 0 WHERE idusuario = $idusuario");
    include "../conexion.php";

    if ($query_delete) {
        header('location: lista_usuarios.php');
    } else {
        echo "Error al elimiar";
    }
}


if (empty($_REQUEST['id']) || $_REQUEST['id'] == 1) {
    header('location: lista_usuarios.php');
    include "../conexion.php";
} else {


    $idusuario = $_REQUEST['id'];

    $query = mysqli_query($conexion, "SELECT u.nombre, u.usuario, r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.idusuario = $idusuario");
    include "../conexion.php";
    $result = mysqli_num_rows($query);

    
    if ($result > 0) {
        while ($data = mysqli_fetch_array($query)) {
            $nombre = $data['nombre'];
            $usuario = $data['usuario'];
            $rol = $data['rol'];
        }
    } else {
        header('location: lista_usuarios.php');
    }
}



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <?php include "include/script.php" ?>
    <title>Eliminar usuario</title>
</head>

<body>
    <?php include "include/header.php" ?>
    <section id="container">
        <div class="container d-flex justify-content-center">
            <div class="container d-flex justify-content-center flex-column">
                <h2 class="text-center">¿Está seguro de eliminar el siguiente registro?</h2>
                <div class="row d-flex justify-content-center align-items-center flex-column">
                    <label for="exampleInputEmail1" class="form-label mt-4 w-50 fs-5">Nombre:</label>
                    <input class="form-control w-50 text-info fw-bold" type="text" value="<?php echo $nombre ?>" aria-label="Disabled input example" disabled>
                    <label for="exampleInputEmail1" class="form-label mt-4 w-50 fs-5">Usuario:</label>
                    <input class="form-control w-50 text-info fw-bold" type="text" value="<?php echo $usuario ?>" aria-label="Disabled input example" disabled>
                    <label for="exampleInputEmail1" class="form-label mt-4 w-50 fs-5">Rol:</label>
                    <input class="form-control w-50 text-info fw-bold" type="text" value="<?php echo $rol ?>" aria-label="Disabled input example" disabled>
                    <form action="" method="post">
                        <div class="container d-flex justify-content-center align-items-center mt-5">
                            <input type="hidden" name="idusuario" value="<?php echo $idusuario ?>">
                            <a href="lista_usuarios.php" type="button" class="btn btn-warning">cancelar</a>
                            <input href="#" type="submit" class="btn btn-danger mx-2" value="Aceptar"></input>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include "include/footer.php" ?>
</body>

</html>