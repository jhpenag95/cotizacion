<?php

session_start();

if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2) {
    header(("location: ./"));
}

include "../conexion.php";

if (!empty($_POST)) {

    if (empty($_POST['idcliente'])) {
        header('location: lista_clientes.php');
        mysqli_close($conexion);
    }

    $idcliente = $_POST['idcliente'];

    //$query_delete = mysqli_query($conexion, "DELETE  FROM usuario WHERE idusuario = $idusuario");
    $query_delete = mysqli_query($conexion, "UPDATE cliente SET estatus = 0 WHERE idcliente = $idcliente");
    mysqli_close($conexion);

    if ($query_delete) {
        header('location: lista_clientes.php');
    } else {
        echo "Error al elimiar";
    }
}


if (empty($_REQUEST['id'])) {
    header('location: lista_clientes.php');
    include "../conexion.php";
} else {


    $idcliente = $_REQUEST['id'];

    $query = mysqli_query($conexion, "SELECT * FROM cliente WHERE idcliente = $idcliente");
    mysqli_close($conexion);
    $result = mysqli_num_rows($query);


    if ($result > 0) {
        while ($data = mysqli_fetch_array($query)) {
            $nit = $data['nit'];
            $nombre = $data['nombre'];
        }
    } else {
        header('location: lista_clientes.php');
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <?php include "include/script.php" ?>
    <title>Eliminar cliente</title>
</head>

<body>
    <?php include "include/header.php" ?>
    <section id="container">
        <div class="container d-flex justify-content-center">
            <div class="container d-flex justify-content-center flex-column">
                <h2 class="text-center">¿Está seguro de eliminar el siguiente registro?</h2>
                <div class="row d-flex justify-content-center align-items-center flex-column">
                    <label for="exampleInputEmail1" class="form-label mt-4 w-50 fs-5">Nit:</label>
                    <input class="form-control w-50 text-info fw-bold" type="text" value="<?php echo $nit ?>" aria-label="Disabled input example" disabled>
                    <label for="exampleInputEmail1" class="form-label mt-4 w-50 fs-5">Nombre:</label>
                    <input class="form-control w-50 text-info fw-bold" type="text" value="<?php echo $nombre ?>" aria-label="Disabled input example" disabled>
                    <form action="" method="post">
                        <div class="container d-flex justify-content-center align-items-center mt-5">
                            <input type="hidden" name="idcliente" value="<?php echo $idcliente?>">
                            <a href="lista_usuarios.php" type="button" class="btn btn-warning">cancelar</a>
                            <input href="#" type="submit" class="btn btn-danger mx-2" value="Eliminar"></input>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include "include/footer.php" ?>
</body>

</html>