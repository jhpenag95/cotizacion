<?php
include "../conexion.php";
session_start();
//print_r($_POST); exit;


if (!empty($_POST['action'])) {
    if ($_POST['action'] == 'infoProducto' && !empty($_POST['producto'])) {
      $producto_id = $_POST['producto'];
  
      // Utilizar sentencias preparadas o filtros para evitar ataques de inyección SQL
      $stmt = $conexion->prepare("SELECT codproducto, descripcion, existencia,precio FROM producto WHERE codproducto = ? AND estatus=1");
      $stmt->bind_param("s", $producto_id);
      $stmt->execute();
      $result = $stmt->get_result();
      mysqli_close($conexion);
  
      if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
      }
      echo 'error';
      exit;
    }


    //Agregar productos a entrada

    if ($_POST['action'] == 'addProduct') {
        if (!empty($_POST['cantidad']) || !empty($_POST['precio']) || !empty($_POST['producto_id'])) {
            $cantidad = $_POST['cantidad'];
            $precio = $_POST['precio'];
            $producto_id = $_POST['producto_id'];
            $usuario_id = $_SESSION['idUser'];

            $query_insert = mysqli_query($conexion, "INSERT INTO entradas(codproducto,cantidad,precio,usuario_id) 
                                            VALUES ('$producto_id','$cantidad','$precio','$usuario_id')");


            if ($query_insert) {

                //ejecutar procedimiento almacenado
                $query_upd = mysqli_query($conexion, "CALL actualizar_precio_producto($cantidad,$precio,$producto_id)");
                $result_pro = mysqli_num_rows($query_upd);

                if ($result_pro > 0) {
                    $data = mysqli_fetch_assoc($query_upd);
                    $data['producto_id'] = $producto_id;
                    echo json_encode($data, JSON_UNESCAPED_UNICODE);
                    exit;
                }
            } else {
                echo 'error';
            }
            mysqli_close($conexion);
        } else {
            echo 'error';
        }
        exit;
    }

    // Eliminar Producto

    if ($_POST['action'] == 'delProduct') {

        if (empty($_POST['producto_id']) || !is_numeric($_POST['producto_id'])) {
            echo "Error";
        } else {

            $idproducto = $_POST['producto_id'];
           
            $query_delete = mysqli_query($conexion, "UPDATE producto SET estatus = 0 WHERE codproducto = $idproducto");

            mysqli_close($conexion);

            if ($query_delete) {
                echo 'ok';
            } else {
                echo "Error al elimiar";
            }
        }

        echo 'Error';
        exit;
    }

    //Buscar Cliente - ventas

    if ($_POST['action'] == 'searchCliente') {
        if (!empty ($_POST['cliente'])) {
            $nit =$_POST['cliente'];

            $query =mysqli_query($conexion, "SELECT * FROM cliente WHERE nit LIKE '$nit' AND estatus = 1");

            mysqli_close($conexion);

            $result =mysqli_num_rows($query);

            $data ='';

            if ($result > 0) {
                $data = mysqli_fetch_assoc($query);
            }else{
                $data = 0;
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    //Registrar cliente - ventas
    if ($_POST['action'] == 'addCliente') {

        $nit = $_POST['nit_cliente'];
        $nombre      = $_POST['nom_cliente'];
        $telefono    = $_POST['tel_cliente'];
        $direccion   = $_POST['dir_cliente'];
        $usuario_id  = $_SESSION['idUser'];

        $query_insert = mysqli_query($conexion, "INSERT INTO cliente (nit,nombre,telefono,direccion,usuario_id) VALUE ('$nit','$nombre','$telefono','$direccion','$usuario_id')");
        

        if ($query_insert) {
            $codCliente = mysqli_insert_id($conexion);
            $msg = $codCliente;
        } else {
            $msg = 'error';
        }
        mysqli_close($conexion);

        echo $msg;
        exit;
    }

    //Agregar productos al detalle temporal
    if ($_POST['action'] == 'addProductoDetalle') {
        if (empty($_POST['producto']) || empty($_POST['cantidad'])) {
            echo 'error';
        }else{
            $codproducto = $_POST['producto'];
            $cantidad = $_POST['cantidad'];
            $token = md5($_SESSION['idUser']);

            //extraer IVA
            $query_iva = mysqli_query($conexion, "SELECT iva FROM configuracion");
            $result_iva = mysqli_num_rows($query_iva);

            //Almacena lo que devuelve el procedimiento almacenado
            $query_detalle_temp = mysqli_query($conexion, "CALL add_detalle_temp($codproducto, $cantidad, '$token')");
            $result = mysqli_num_rows($query_detalle_temp);

            $detalleTabla = '';
            $sub_total = 0;
            $iva = 0;
            $total = 0;
            $arrayData = array();

            if ($result > 0) {
                //Validar que exista el IVA
                if ($result_iva > 0) {
                    $inf_iva = mysqli_fetch_assoc($query_iva);
                    $iva = $inf_iva['iva'];
                }

                //para recorrer todos los registros que devuelve el procedimiento almacenado
                while ($data = mysqli_fetch_assoc($query_detalle_temp)) {
                    //se deben calcular datos
                    $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
                    $sub_total = round($sub_total + $precioTotal, 2);
                    $total = round($total + $precioTotal, 2);

                    $detalleTabla .= '
                    <tr>
                        <td>'.$data['codproducto'].'</td>
                        <td colspan="2">'.$data['descripcion'].'</td>
                        <td>'.$data['cantidad'].'</td>
                        <td class="right-align">'.$data['precio_venta'].'0</td>
                        <td class="right-align">'.$precioTotal.'</td>
                        <td class="d-flex justify-content-center"><a class="link_delete btn btn-danger" href="#" onclick="event.preventDefault(); del_product_detalle('.$data['codproducto'].');"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                            </svg></a></td>
                    </tr>';
                }

                //se calculan los totales
                $impuesto = round($sub_total * ($iva / 100), 2);
                $tl_sniva = round($sub_total - $impuesto, 2);
                $total    = round($tl_sniva + $impuesto, 2);

                $detalleTotales = '
                <tr>
                    <td colspan="5" class="right-align bold-text">SUBTOTAL</td>
                    <td class="text-right">'.$tl_sniva.'</td>
                </tr>
                <tr>
                    <td colspan="5" class="right-align bold-text">IVA 19%</td>
                    <td class="text-right">'.$impuesto.'</td>
                </tr>
                <tr>
                    <td colspan="5" class="right-align bold-text">TOTAL</td>
                    <td class="text-right">'.$total.'</td>
                </tr>';

                $arrayData ['detalle'] = $detalleTabla;
                $arrayData ['totales'] = $detalleTotales;

                //Retornamos array
                echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);

            }else{
                echo 'error';
            }
            mysqli_close($conexion);
        }
        exit;
    }

    //Extrae datos del detalle_temp (tabla)
    if ($_POST['action'] == 'serchForDetalle') {
        if (empty($_POST['user'])) {
            echo 'error';
        }else{
            
            $token = md5($_SESSION['idUser']);

            $query = mysqli_query($conexion, "SELECT tmp.correlativo,
                                                     tmp.token_user,
                                                     tmp.cantidad,
                                                     tmp.precio_venta,
                                                     p.codproducto,
                                                     p.descripcion
                                                     FROM detalle_temp tmp
                                                     INNER JOIN producto p
                                                     ON tmp.codproducto = p.codproducto
                                                     WHERE token_user = '$token'");

            $result = mysqli_num_rows($query);

            //extraer IVA
            $query_iva = mysqli_query($conexion, "SELECT iva FROM configuracion");
            $result_iva = mysqli_num_rows($query_iva);


            $detalleTabla = '';
            $sub_total = 0;
            $iva = 0;
            $total = 0;
            $arrayData = array();

            if ($result > 0) {
                //Validar que exista el IVA
                if ($result_iva > 0) {
                    $inf_iva = mysqli_fetch_assoc($query_iva);
                    $iva = $inf_iva['iva'];
                }

                //para recorrer todos los registros que devuelve el procedimiento almacenado
                while ($data = mysqli_fetch_assoc($query)) {
                    //se deben calcular datos
                    $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
                    $sub_total = round($sub_total + $precioTotal, 2);
                    $total = round($total + $precioTotal, 2);

                    $detalleTabla .= '
                    <tr>
                        <td>'.$data['codproducto'].'</td>
                        <td colspan="2">'.$data['descripcion'].'</td>
                        <td>'.$data['cantidad'].'</td>
                        <td class="right-align">'.$data['precio_venta'].'0</td>
                        <td class="right-align">'.$precioTotal.'</td>
                        <td class="d-flex justify-content-center"><a class="link_delete btn btn-danger" href="#" onclick="event.preventDefault(); del_product_detalle('.$data['codproducto'].');"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                            </svg></a></td>
                    </tr>';
                }

                //se calculan los totales
                $impuesto = round($sub_total * ($iva / 100), 2);
                $tl_sniva = round($sub_total - $impuesto, 2);
                $total    = round($tl_sniva + $impuesto, 2);

                $detalleTotales = '
                <tr>
                    <td colspan="5" class="right-align bold-text">SUBTOTAL</td>
                    <td class="text-right">'.$tl_sniva.'</td>
                </tr>
                <tr>
                    <td colspan="5" class="right-align bold-text">IVA 19%</td>
                    <td class="text-right">'.$impuesto.'</td>
                </tr>
                <tr>
                    <td colspan="5" class="right-align bold-text">TOTAL</td>
                    <td class="text-right">'.$total.'</td>
                </tr>';

                $arrayData ['detalle'] = $detalleTabla;
                $arrayData ['totales'] = $detalleTotales;

                //Retornamos array
                echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);

            }else{
                echo 'error';
            }
            mysqli_close($conexion);
        }
        exit;
    }
}
exit;

?>