<?php
session_start();

include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <?php include "include/script.php" ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="ruta/a/jquery.min.js"></script>

    <title>Lista de productos</title>
</head>

<body>
    <?php include "include/header.php" ?>
    <section id="container">
        <div class="container">
            <h1>Lista de productos</h1>
            <a href="registro_producto.php" class="btn btn-success">Crear producto</a>
            <div class="container mt-4">
                <table class="table responsive">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Existencias</th>
                            <th scope="col">Proveedor</th>
                            <th scope="col">Foto</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php

                        //Paginador	
                        $sql_register = mysqli_query($conexion, "SELECT COUNT(*) as total_registros FROM producto WHERE estatus = 1");
                        $result_register = mysqli_fetch_array($sql_register);
                        $total_registro = $result_register['total_registros'];

                        $por_pagina = 5;

                        if (empty($_GET['pagina'])) {
                            $pagina = 1;
                        } else {
                            $pagina = $_GET['pagina'];
                        }

                        $desde = ($pagina - 1) * $por_pagina;
                        $total_paginas = ceil($total_registro / $por_pagina);

                        //consultar usuario
                        $query = mysqli_query($conexion, "SELECT p.codproducto, p.descripcion, p.precio, p.existencia, pr.proveedor, p.foto 
                                                                FROM producto p 
                                                                INNER JOIN proveedor pr
                                                                ON p.proveedor = pr.codproveedor
                                                                WHERE p.estatus = 1  ORDER BY codproducto  ASC LIMIT $desde,$por_pagina");
                        mysqli_close($conexion);

                        $result = mysqli_num_rows($query);
                        if ($result > 0) {
                            while ($data = mysqli_fetch_array($query)) {
                                if ($data['foto'] != 'img_producto.png') {
                                    $foto = 'img/uploads/' . $data['foto'];
                                } else {
                                    $foto = 'img/' . $data['foto'];
                                }
                        ?>
                                <tr>
                                    <th class="text-center align-middle"><?php echo $data['codproducto'] ?></th>
                                    <th class="text-center align-middle"><?php echo $data['descripcion'] ?></th>
                                    <td class="text-center align-middle"><?php echo $data['precio'] ?></td>
                                    <td class="text-center align-middle"><?php echo $data['existencia'] ?></td>
                                    <td class="text-center align-middle"><?php echo $data['proveedor'] ?></td>
                                    <td class="text-center align-middle"><img src="<?php echo $foto ?>" alt="<?php echo $data['descripcion'] ?>" class="img-producto p-4"></td>
                                    <?php
                                    if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) { ?>
                                        <td class="text-center align-middle">
                                            <a class="btn btn-info mx-2 add_product" product="<?php echo $data['codproducto']; ?>" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Agregar</a>
                                            <a href="editar_producto.php?id=<?php echo $data['codproducto'] ?>" class="btn btn-success mx-2">Editar</a>


                                            <a href="eliminar_confirmar_producto.php?id=<?php echo $data['codproducto'] ?>" class="btn btn-danger">Eliminar</a>
                                        </td>
                                    <?php  } ?>
                                </tr>
                        <?php
                            }
                        }
                        ?>

                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                    <ul class="pagination d-flex justify-content-end">
                        <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
                        <?php

                        for ($i = 1; $i <= $total_paginas; $i++) {
                            if ($i == $pagina) {
                                echo '<li class="page-item"><a class="page-link">' . $i . '</a></li>';
                            } else {

                                echo '<li class="page-item"><a class="page-link" href="?pagina=' . $i . '">' . $i . '</a></li>';
                            }
                        }
                        ?>
                        <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>

    <?php include "include/footer.php" ?>
    <script>
        $(document).ready(function() {
            //--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
            $("#foto").on("change", function() {
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
                        $(".preview").append("<img id='img' src=" + objeto_url + ">");
                        $("./upimg label").remove();
                    }
                } else {
                    alert("No selecciono foto");
                    $("#img").remove();
                }
            });

            $(".delPhoto").click(function() {
                $("#foto").val("");
                $(".delPhoto").addClass("notBlock");
                $("#img").remove();
            });

            //Modal from Add product//

            $(".add_product").click(function(e) {
                e.preventDefault();
                var producto = $(this).attr("product");
                var action = "infoProducto";

                $.ajax({
                    url: "ajax.php",
                    type: "POST",
                    async: true,
                    data: {
                        action: action,
                        producto: producto
                    },

                    success: function(response) {
                        console.log(response);
                    },

                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
</body>

</html>