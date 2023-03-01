<?php
	session_start();

	if ($_SESSION['rol'] != 1) {
		header(("location: ./"));
	}

include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<?php include "include/script.php" ?>
	<title>Lista usuario</title>
</head>

<body>
	<?php include "include/header.php" ?>
	<section id="container">
		<div class="container">
			<h1>Lista de Usuarios</h1>
			<a href="registro_usuario.php" class="btn btn-success">Crear usuario</a>
			<div class="container mt-4">
				<table class="table responsive">
					<thead class="text-center">
						<tr>
							<th scope="col">id</th>
							<th scope="col">Nombre</th>
							<th scope="col">Correo</th>
							<th scope="col">Usuario</th>
							<th scope="col">Rol</th>
							<th scope="col">Acciones</th>
						</tr>
					</thead>
					<tbody class="text-center">
						<?php

						//Paginador	
						$sql_register = mysqli_query($conexion, "SELECT COUNT(*) as total_registros FROM usuario WHERE estatus = 1");
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
						$query = mysqli_query($conexion, "SELECT u.idusuario, u.nombre, u.correo, u.usuario, r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.estatus = 1  ORDER BY u.idusuario ASC LIMIT $desde,$por_pagina");
						mysqli_close($conexion);

						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_array($query)) {
						?>
								<tr>
									<th><?php echo $data['idusuario'] ?></th>
									<td><?php echo $data['nombre'] ?></td>
									<td><?php echo $data['correo'] ?></td>
									<td><?php echo $data['usuario'] ?></td>
									<td><?php echo $data['rol'] ?></td>
									<td>
										<a href="editar_usuario.php?id=<?php echo $data['idusuario'] ?>" class="btn btn-success mx-2">Editar</a>
										<?php
										if ($data['idusuario'] != 1) {

										?>
											<a href="eliminar_confirmar_usuario.php?id=<?php echo $data['idusuario'] ?>" class="btn btn-danger">Borrar</a>

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