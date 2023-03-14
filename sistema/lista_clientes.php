<?php
session_start();

include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <?php include "include/script.php" ?>
    <title>Lista de clientes</title>
</head>

<body>
    <?php include "include/header.php" ?>
    <section id="container">
        <div class="container">
            <h1>Lista de clientes</h1>
            <a href="registro_cliente.php" class="btn btn-success">Crear cliente</a>
            <div class="container mt-4">
                <table class="table responsive">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nit</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php

                        //Paginador	
                        $sql_register = mysqli_query($conexion, "SELECT COUNT(*) as total_registros FROM cliente WHERE estatus = 1");
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
                        $query = mysqli_query($conexion, "SELECT * FROM cliente  WHERE estatus = 1  ORDER BY idcliente ASC LIMIT $desde,$por_pagina");
                        mysqli_close($conexion);

                        $result = mysqli_num_rows($query);
                        if ($result > 0) {
                            while ($data = mysqli_fetch_array($query)) {

                                if ($data["nit"] == 0) {
                                    $nit = 'C/F';
                                } else {
                                    $nit = $data["nit"];
                                }
                        ?>
                                <tr>
                                    <th><?php echo $data['idcliente'] ?></th>
                                    <th><?php echo $nit; ?></th>
                                    <td><?php echo $data['nombre'] ?></td>
                                    <td><?php echo $data['telefono'] ?></td>
                                    <td><?php echo $data['direccion'] ?></td>
                                    <td><?php echo $data['correo'] ?></td>
                                    <td>
                                        <a href="editar_Clientes.php?id=<?php echo $data['idcliente'] ?>" class="btn btn-success mx-2">Editar</a>
                                        
                                        <?php
                                        if ($_SESSION['rol']== 1 || $_SESSION['rol']== 2) { ?>
                                            <a href="eliminar_confirmar_cliente.php?id=<?php echo $data['idcliente'] ?>" class="btn btn-danger">Borrar</a>
                                        <?php  } ?>
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