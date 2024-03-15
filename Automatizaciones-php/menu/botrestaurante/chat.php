<style>
    .order-details {
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px auto;
    max-width: 600px;
    font-family: 'Roboto', sans-serif;
    color: #2c292a;
}

.order-details h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.8em;
    text-align: center;
    margin-bottom: 20px;
}

.order-details table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.order-details th,
.order-details td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.order-details th {
    background-color: #604c50;
    color: #fff;
}

.order-details tr:last-child td {
    border-bottom: none;
}

.order-details .total-row td {
    font-weight: bold;
}

.order-details p {
    text-align: center;
    margin-bottom: 10px;
}

.order-details button {
    background-color: #604c50;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

.order-details button:hover {
    background-color: #a17c7f;
}

.order-details button a {
    color: #fff;
    text-decoration: none;
}
</style>
<?php
include("connectionbot.php");
session_start();
$conn = connectionbot();

mysqli_set_charset($conn, "utf8");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmar'])) {
    procesarPedido($conn);
} else {
    $userMessage = isset($_POST['Mensaje_usuario']) ? strtolower($_POST['Mensaje_usuario']) : '';
    $response = processUserMessage($userMessage, $conn);
    echo $response;
}

function formatCurrency($amount)
{
    return number_format($amount, 3, ',', '.');
}

function processUserMessage($userMessage, $conn) {
    $reply = "";

    if ($userMessage == 'hola' || $userMessage == 'ola' || $userMessage == 'buenas tardes' || $userMessage == 'buenos dias' || $userMessage == 'buenas noches' || $userMessage == 'hola buenos dias' || $userMessage == 'hola buenas tardes' || $userMessage == 'hola buenas noches' || $userMessage == 'buenas') {
        // Consultar la base de datos para obtener el saludo del restaurante
        $sqlSaludo = "SELECT Saludo FROM tblrestaurantes LIMIT 1";
        $result = $conn->query($sqlSaludo);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $reply = $row['Saludo'];
        } else {
            $reply = "¡Hola! ¿En qué puedo ayudarte?";
        }
    } elseif ($userMessage == 'adios' || $userMessage == 'cancelar' || $userMessage == 'chao' || $userMessage == 'buena tarde' || $userMessage == 'muchas gracias' || $userMessage == 'gracias') {
        // Consultar la base de datos para obtener el mensaje de despedida del restaurante
        $sqlDespedida = "SELECT Despedida FROM tblrestaurantes LIMIT 1";
        $result = $conn->query($sqlDespedida);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $reply = $row['Despedida'];
            session_destroy();
        }
    } elseif ($userMessage == 'si' || $userMessage == 'menu' || $userMessage == 'esta bien' || $userMessage == 'ok' || $userMessage == 's' || $userMessage == 'ssi' || $userMessage == 'ver menu') {
        if ($conn->ping()) {
            // Consultar la base de datos para obtener el menu del restaurante
            $sqlMenu = "SELECT IdMenu, NombreProducto, Precio FROM tblmenu";
            $result = $conn->query($sqlMenu);

            if ($result->num_rows > 0) {
                $menu = array();

                while ($row = $result->fetch_assoc()) {
                    $idMenu = $row['IdMenu'];
                    $nombreProducto = $row['NombreProducto'];
                    $precio = $row['Precio'];

                    $menu[] = array(
                        'IdMenu' => $idMenu,
                        'NombreProducto' => $nombreProducto,
                        'Precio' => $precio,
                    );
                }

                // Respuesta del bot con los datos del menú en una tabla HTML
                $reply .= "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>";
                $reply .= "<h2>Aquí tienes nuestro menú:</h2>";
                $reply .= "<table border='1'>";
                $reply .= "<tr><th></th><th>Producto</th><th>Precio</th><th>Cantidad</th></tr>";
                foreach ($menu as $item) {
                    $reply .= "<tr>";
                    $reply .= "<td><input type='checkbox' name='productos[]' value='" . $item['IdMenu'] . "'></td>";
                    $reply .= "<td>" . $item['NombreProducto'] . "</td>";
                    $reply .= "<td>" . formatCurrency($item['Precio']) . "</td>"; // Formatear el precio aquí
                    $reply .= "<td><input type='number' name='cantidades[" . $item['IdMenu'] . "]' value='0' min='0' max='10'></td>";
                    $reply .= "</tr>";
                }
                $reply .= "</table>";
                $reply .= "<label for='NumMesa'>Por favor ingresa tu número de mesa:</label><br>";
                $reply .= "<input type='number' name='Numeromesa' value='' min='1' max='20' required><br>";
                $reply .= "<label for='Comentarios'>Si tienes algún comentario adicional, escríbelo aquí:</label><br>";
                $reply .= "<input type='text' name='Comentarios' max='100'><br>";
                $reply .= "<input type='hidden' name='FechaPedido' value='" . date('Y-m-d H:i:s') . "'>";
                $reply .= "<center><input type='submit' name='confirmar' value='Confirmar Pedido'></center>";
                $reply .= "</form>";
            } else {
                $reply = 'Lo siento mucho, el menú no está disponible en este momento';
            }
        } else {
            $reply = "Lo siento, hubo un problema con la conexión a la base de datos. Por favor, inténtalo de nuevo más tarde.";
        }
    } else {
        $reply = "Lo siento, no entiendo ese mensaje. ¿Podrías repetirlo de otra manera?";
    }
    return $reply;
}

function procesarPedido($conn) {
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
                        'IdMenu' => $idMenu,
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

                $sqlInsertFactura = "INSERT INTO tblFactura (NumeroMesa, IdMenu, Cantidad, Subtotal, Total) VALUES (?, ?, ?, ?, ?)";
                $stmtFactura = $conn->prepare($sqlInsertFactura);
                $stmtFactura->bind_param("iiids", $numMesa, $detalle['IdMenu'], $detalle['Cantidad'], $detalle['Subtotal'], $detalle['Subtotal']);
                $stmtFactura->execute();
            }

            echo "<div class='order-details'>";
            echo "<h3>Detalles del pedido:</h3>";
            
            echo "<table border='2'>";
            echo "</tr><th colspan='4'>Comentario</th></tr>";
            echo "<tr><td colspan='4'>" . htmlspecialchars($comentarios) . "</td></tr>";
            echo "<tr><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th></tr>";

            foreach ($detalles as $detalle) {
                echo "<tr>";
                echo "<td>" . $detalle['NombreProducto'] . "</td>";
                echo "<td>" . $detalle['Cantidad'] . "</td>";
                echo "<td>" . formatCurrency($detalle['Precio']) . "</td>";
                echo "<td>" . formatCurrency($detalle['Subtotal']) . "</td>"; 
                echo "</tr>";
            }
            echo "<tr><td colspan='2'>Total:</td><td colspan='2'>" . formatCurrency($total) . "</td></tr>";
            echo "</table>";
            echo "<p>El tiempo estimado de espera es de 15 minutos.</p>";

            echo " <button><a href=index.html>Volver al inicio</a></button>";
        } else {
            echo "No se ha seleccionado ningún producto.";
        }
    }
}
echo "</div>";
?>