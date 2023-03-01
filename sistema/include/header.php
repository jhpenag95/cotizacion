<?php
if (empty($_SESSION['active'])) {
	header('location: ../');
}
?>

<header>
	<div class="header p-4 d-flex justify-content-around">

		<h1>Sistema Cotización</h1>
		<div class="optionsBar">
			<p>Colombia, <?php echo fechaC()?></p>
			<span>|</span>
			<span class="user"><?php echo $_SESSION['user'].' -'.$_SESSION['rol'];?></span>
			<img class="photouser" src="img/user.png" alt="Usuario">
			<a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
		</div>
	</div>
	<?php include "nav.php" ?>
</header>