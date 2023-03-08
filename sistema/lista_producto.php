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
                                <tr class="row<?php echo $data['codproducto'] ?>">
                                    <th class="text-center align-middle"><?php echo $data['codproducto'] ?></th>
                                    <th class="text-center align-middle"><?php echo $data['descripcion'] ?></th>
                                    <td class="text-center align-middle celPrecio"><?php echo $data['precio'] ?></td>
                                    <td class="text-center align-middle celExistencia"><?php echo $data['existencia'] ?></td>
                                    <td class="text-center align-middle"><?php echo $data['proveedor'] ?></td>
                                    <td class="text-center align-middle"><img src="<?php echo $foto ?>" alt="<?php echo $data['descripcion'] ?>" class="img-producto p-4"></td>
                                    <?php
                                    if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) { ?>
                                        <td class="text-center align-middle">
                                            <a class="btn btn-info mx-2 add_product" data-product="<?php echo $data['codproducto']; ?>" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                                </svg></a>
                                            <a href="editar_producto.php?id=<?php echo $data['codproducto'] ?>" class="btn btn-success mx-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                </svg></a>


                                            <a class="btn btn-danger del_product" data-product="<?php echo $data['codproducto']; ?>" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                </svg></a>
                                        </td>
                                    <?php  } ?>
                                </tr>
                        <?php
                            }
                        }
                        ?>

                    </tbody>
                </table>
                <nav class="position-relative z-n1" aria-label="Page navigation example">
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
    <script src="js/functions.js"></script>
    <script src="js/buscadorProductos.js"></script>
</body>

</html>