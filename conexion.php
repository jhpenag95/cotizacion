<?php
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'facturacion';

    $conexion = mysqli_connect($host, $user, $password, $db);

    if (!$conexion) {
        echo "error en la conexion";
    }else{
        echo "conexión exitosa";
    }

?>