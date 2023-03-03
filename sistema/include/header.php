<?php
if (empty($_SESSION['active'])) {
	header('location: ../');
}
?>

<header>
	<div class="header p-4 d-flex justify-content-around">

		<h1>Sistema Cotización</h1>
		<div class="optionsBar">
			<p>Colombia, <?php echo fechaC() ?></p>
			<span>|</span>
			<span class="user"><?php echo $_SESSION['user'] . ' -' . $_SESSION['rol'] . ' -' . $_SESSION['email']; ?></span>
			<img class="photouser" src="img/user.png" alt="Usuario">
			<a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
		</div>
	</div>
	<?php include "nav.php" ?>
	
</header>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="" method="post" name="form_add_product" onsubmit="event.preventDefault(); sendDataProduct();">
					<div class="mb-3">
						<h1>Agregar producto</h1>
						<h2>Alexa</h2>
						<label for="exampleFormControlInput1" class="form-label">Cantidad</label>
						<input type="number" name="cantidad" class="form-control" id="exampleFormControlInput1" placeholder="Cantidad de producto">
						<label for="exampleFormControlInput1" class="form-label">Precio</label>
						<input type="number" name="precio" class="form-control" id="exampleFormControlInput1" placeholder="precio del producto">
						<input type="hidden" name="producto_id" class="form-control" id="exampleFormControlInput1" required>
						<input type="hidden" name="action" value="addProduct" class="form-control" id="exampleFormControlInput1" required>
						<div class="alerta alertAddProduct"></div>
						<button type="submit" class="btn btn-success">Agregar</button>
						<a href="#" class="btn btn-danger" onclick="closeModal();">Cerrar</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>