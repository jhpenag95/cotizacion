<?php
session_start();

include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <?php include "include/script.php" ?>
    <title>Lista de proveedores</title>
</head>

<body>
    <?php include "include/header.php" ?>
    <section id="container">
        <div class="container">
            <h1>Lista de proveedores</h1>
            <a href="registro_proveedor.php" class="btn btn-success">Crear proveedor</a>
            <div class="container mt-4">
                <table class="table responsive">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nit proveedor</th>
                            <th scope="col">Nombre proveedor</th>
                            <th scope="col">Contacto</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php

                        //Paginador	
                        $sql_register = mysqli_query($conexion, "SELECT COUNT(*) as total_registros FROM proveedor WHERE estatus = 1");
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
                        $query = mysqli_query($conexion, "SELECT * FROM proveedor  WHERE estatus = 1  ORDER BY codproveedor ASC LIMIT $desde,$por_pagina");
                        mysqli_close($conexion);

                        $result = mysqli_num_rows($query);
                        if ($result > 0) {
                            while ($data = mysqli_fetch_array($query)) {

                                $formato = 'Y-m-d H:i:s';
                                $fecha = DateTime::createFromFormat($formato, $data['date_add']);

                        ?>
                                <tr>
                                    <th><?php echo $data['codproveedor'] ?></th>
                                    <th><?php echo $data['nit_proveedor'] ?></th>
                                    <td><?php echo $data['proveedor'] ?></td>
                                    <td><?php echo $data['contacto'] ?></td>
                                    <td><?php echo $data['telefono'] ?></td>
                                    <td><?php echo $data['direccion'] ?></td>
                                    <td><?php echo $fecha->format('d-m-Y') ?></td>
                                    <td>
                                        <a href="editar_proveedor.php?id=<?php echo $data['codproveedor'] ?>" class="btn btn-success mx-2">Editar</a>

                                        <a href="eliminar_confirmar_proveedor.php?id=<?php echo $data['codproveedor'] ?>" class="btn btn-danger">Borrar</a>

                                    </td>
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
</body>

</html>