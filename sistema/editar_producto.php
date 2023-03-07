<?php
session_start();

if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2) {
    header("location: ./");
}

include "../conexion.php";
if (!empty($_POST)) {

    $alert = '';
    if (empty(($_POST['proveedor'])) || empty(($_POST['producto'])) || empty(($_POST['precio'])) || empty($_POST['id']) || empty($_POST['foto_actual']) || empty($_POST['foto_remove'])) {
        $alert = '<p class="msg_error alertas-p"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill mx-2" viewBox="0 0 16 16">
		<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
	  </svg>Todos los campos son obligatorio</p>';
    } else {
        $codproducto = $_POST['id'];
        $proveedor = $_POST['proveedor'];
        $producto = $_POST['producto'];
        $precio = $_POST['precio'];
        $imgProducto = $_POST['foto_actual'];
        $imgRemove = $_POST['foto_remove'];

        $foto = $_FILES['foto'];
        $nombre_foto = $foto['name'];
        $type = $foto['type'];
        $url_temp = $foto['tmp_name'];

        $upd = '';

        if ($nombre_foto != '') {
            $destino = 'img/uploads/';
            $img_nombre = 'img_' . md5(date('d-m-Y H:m:s'));
            $imgProducto = $img_nombre . '.jpg';
            $rsc = $destino . $imgProducto;
        } else {
            if ($_POST['foto_actual'] != $_POST['foto_remove']) {
                $imgProducto = 'img_producto.png';
            }
        }




        $query_update = mysqli_query($conexion, "UPDATE producto SET descripcion = '$producto', 
                                                                        proveedor = $proveedor,
                                                                        precio = $precio,
                                                                        foto = '$imgProducto' 
                                                                 WHERE codproducto = $codproducto");
        if ($query_update) {
            if ($nombre_foto != '' && ($_POST['foto_actual'] != 'img_producto.png' || $_POST['foto_actual'] != $_POST['foto_remove'])) {
                unlink('img/uploads/' . $_POST['foto_actual']);
            }

            if ($nombre_foto != '') {
                move_uploaded_file($url_temp, $rsc);
            }

            $alert = '<p class="msg_save alertas-p"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill mx-2" viewBox="0 0 16 16">
				<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
			  </svg>Producto actualizado correctamente</p>';
        } else {
            $alert = '<p class="msg_error alertas-p"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill mx-2" viewBox="0 0 16 16">
				<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
			  </svg>Error al actualizar producto </p>';
        }
    }
}

//Validar Producto

if (empty($_REQUEST['id'])) {
    header("location: lista_producto.php");
} else {
    $id_producto = $_REQUEST['id'];

    if (!is_numeric($id_producto)) {
        header("location: lista_producto.php");
    }

    $query_producto = mysqli_query($conexion, "SELECT p.codproducto, p.descripcion, p.precio, p.foto, pr.codproveedor, pr.proveedor
                                                         FROM producto p 
                                                         INNER JOIN proveedor pr
                                                         ON p.proveedor = pr.codproveedor
                                                         WHERE p.codproducto = $id_producto AND p.estatus = 1");
    $result_producto = mysqli_num_rows($query_producto);

    $foto = '';
    $classRemove = 'notBlock';

    if ($result_producto > 0) {
        $data_producto = mysqli_fetch_assoc($query_producto);

        if ($data_producto['foto'] != 'img_producto.png') {
            $classRemove = '';
            $foto = '<img id="img" src="img/uploads/' . $data_producto['foto'] . '" alt="Producto">';
        }
    } else {
        header("location: lista_producto.php");
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <?php include "include/script.php" ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/functions.js"></script>

    <title>Actualizar Productos</title>



</head>

<body>
    <?php include "include/header.php" ?>
    <section id="container">
        <div class="form_register container w-50">
            <h1>Actualizar Productos</h1>
            <hr>
            <div class="alerta">
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="container">
                <form class="row g-3 needs-validation" action="" method="post" enctype="multipart/form-data" novalidate> <!--multipart/form-data - indica que se pueden adjuntar archivo-->
                    <input type="hidden" name="id" value="<?php echo $data_producto['codproducto']; ?>">
                    <input type="hidden" id="foto_actual" name="foto_actual" value="<?php echo $data_producto['foto']; ?>">
                    <input type="hidden" id="foto_remove" name="foto_remove" value="<?php echo $data_producto['foto']; ?>">

                    <label for="validationTooltip01" class="form-label">Proveedor:</label>

                    <?php
                    $query_proveedor = mysqli_query($conexion, "SELECT codproveedor, proveedor FROM proveedor WHERE estatus = 1 ORDER BY proveedor ASC");
                    $result_proveedor = mysqli_num_rows($query_proveedor);
                    mysqli_close($conexion);

                    ?>
                    <select class="form-select notitemOne" aria-label="Default select example w-25" name="proveedor">
                        <option value="<?php echo $data_producto['codproveedor']; ?>" selected><?php echo $data_producto['proveedor']; ?></option>
                        <?php
                        if ($result_proveedor > 0) {
                            while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                                # code...


                        ?>
                                <option value="<?php echo $proveedor['codproveedor'] ?>"><?php echo $proveedor['proveedor'] ?></option>

                        <?php

                            }
                        }
                        ?>
                    </select>

                    <div class="col-md-4 position-relative">
                        <label for="validationTooltip01" class="form-label">Producto</label>
                        <input type="text" class="form-control" name="producto" id="validationTooltip01" placeholder="Nombre del Producto" value="<?php echo $data_producto['descripcion'] ?>">
                    </div>
                    <div class="col-md-6 position-relative">
                        <label for="validationTooltip01" class="form-label">Precio</label>
                        <input type="number" class="form-control" name="precio" id="validationTooltip01" placeholder="Precio del producto" value="<?php echo $data_producto['precio'] ?>">
                    </div>
                    <div class="photo">
                        <label for="foto">Foto</label>
                        <div class="prevPhoto">
                            <span class="delPhoto <?php echo $classRemove; ?>">X</span>
                            <label for="foto"></label>
                            <?php echo $foto; ?>
                        </div>
                        <div class="upimg">
                            <input type="file" name="foto" id="foto">
                        </div>
                        <div id="form_alert"></div>
                    </div>


                    <div class="col-12">
                        <button id="mi-boton" class="btn btn-success" type="submit">Actualizar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <?php include "include/footer.php" ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/functions.js"></script>


</body>

</html>