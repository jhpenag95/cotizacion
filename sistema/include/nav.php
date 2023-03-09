<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary fs-4 position-relative mb-4">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="contimg">
            <!-- <img src="#" alt="" width="200" height="auto"> -->
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto ">
                <li class="nav-item"><a class="nav-link" href="../index.php">Inicio</a></li>
                <?php
                if ($_SESSION['rol'] == 1) {
                ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Usuarios
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="registro_usuario.php">Nuevo Usuario</a></li>
                            <li><a class="dropdown-item" href="lista_usuarios.php">Lista de Usuarios</a></li>
                        </ul>
                    </li>
                <?php } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Clientes
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="registro_cliente.php">Nuevo Cliente</a></li>
                        <li><a class="dropdown-item" href="lista_clientes.php">Lista de Clientes</a></li>
                    </ul>
                </li>

                <?php
                if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
                ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Proveedores
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="registro_proveedor.php">Nuevo Proveedor</a></li>
                            <li><a class="dropdown-item" href="lista_proveedor.php">Lista de Proveedores</a></li>
                        </ul>
                    </li>
                <?php } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Productos
                    </a>
                    <ul class="dropdown-menu">
                        <?php
                        if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
                        ?>
                            <li><a class="dropdown-item" href="registro_producto.php">Nuevo Producto</a></li>
                        <?php } ?>
                        <li><a class="dropdown-item" href="lista_producto.php">Lista de Productos</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Cotización
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="nueva_venta.php">Nuevo Cotización</a></li>
                        <li><a class="dropdown-item" href="#">Cotizaciones</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Navbar -->