<?php
include("connectionbot.php");
$conn = connectionbot();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['productos']) && isset($_POST['cantidades']) && isset($_POST['Numeromesa'])) {
        $productos = $_POST['productos'];
        $cantidades = $_POST['cantidades'];
        $numMesa = $_POST['Numeromesa'];
        $comentarios = isset($_POST['Comentarios']) ? $_POST['Comentarios'] : '';
        $fecha = $_POST['FechaPedido'];

        $total = 0;
        $detalles = array();

        foreach ($productos as $idMenu) {
            if (isset($cantidades[$idMenu]) && $cantidades[$idMenu] > 0) {
                $sqlProducto = "SELECT NombreProducto, Precio FROM tblmenu WHERE IdMenu = ?";
                $stmtProducto = $conn->prepare($sqlProducto);
                $stmtProducto->bind_param("i", $idMenu);
                $stmtProducto->execute();
                $resultProducto = $stmtProducto->get_result();

                if ($resultProducto->num_rows > 0) {
                    $row = $resultProducto->fetch_assoc();
                    $nombreProducto = $row['NombreProducto'];
                    $precio = $row['Precio'];
                    $cantidad = $cantidades[$idMenu];
                    $subtotal = $precio * $cantidad;
                    $total += $subtotal;

                    $detalles[] = array(
                        'NombreProducto' => $nombreProducto,
                        'Precio' => $precio,
                        'Cantidad' => $cantidad,
                        'Subtotal' => $subtotal
                    );
                }
            }
        }

        if ($total > 0) {
            $sqlInsertPedido = "INSERT INTO tblPedidos (NumeroMesa, IdMenu, Comentarios, Cantidad, Total, FechaPedido) VALUES (?, ?, ?, ?, ?, ?)";
            $stmtPedido = $conn->prepare($sqlInsertPedido);

            foreach ($detalles as $detalle) {
                $stmtPedido->bind_param("iisids", $numMesa, $detalle['IdMenu'], $comentarios, $detalle['Cantidad'], $detalle['Subtotal'], $fecha);
                $stmtPedido->execute();
                $numeroPedido = $conn->insert_id;

                $sqlInsertFactura = "INSERT INTO tblFactura (NumeroPedido, IdMenu, Cantidad, Subtotal) VALUES (?, ?, ?, ?)";
                $stmtFactura = $conn->prepare($sqlInsertFactura);
                $stmtFactura->bind_param("iiid", $numeroPedido, $detalle['IdMenu'], $detalle['Cantidad'], $detalle['Subtotal']);
                $stmtFactura->execute();
            }

            echo "Pedido realizado correctamente.";
        } else {
            echo "No se ha seleccionado ningún producto.";
        }
    } else {
        echo "Faltan datos para procesar el pedido.";
    }
}

$conn->close();
?>