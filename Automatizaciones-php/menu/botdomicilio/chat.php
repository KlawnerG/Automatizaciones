<style>
    #factura-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    #detalles-tabla {
        width: 80%; /* Ajusta el ancho según tus preferencias */
        border-collapse: collapse;
        margin: 20px auto; /* Centra la tabla dentro del contenedor */
    }

    #detalles-tabla th, #detalles-tabla td {
        border: 1px solid #ddd;
        padding: 8px;
        
    }

    #detalles-tabla th {
        background-color: #f2f2f2;
        
    }

    #detalles-tabla tr:hover {
        background-color: #f5f5f5;
        
    }

    #detalles-tabla td[colspan="4"] {
        background-color: #f2f2f2;
        
    }

    #detalles-tabla p {
        margin-top: 20px;
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
        $sqlSaludo = "SELECT Saludo FROM tblrestaurantes LIMIT 1";
        $result = $conn->query($sqlSaludo);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $reply = $row['Saludo'];
        } else {
            $reply = "¡Hola! ¿En qué puedo ayudarte?";
        }
    } elseif ($userMessage == 'adios' || $userMessage == 'cancelar' || $userMessage == 'chao' || $userMessage == 'buena tarde' || $userMessage == 'muchas gracias' || $userMessage == 'gracias') {
        $sqlDespedida = "SELECT Despedida FROM tblrestaurantes LIMIT 1";
        $result = $conn->query($sqlDespedida);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $reply = $row['Despedida'];
            session_destroy();
        }
    } elseif ($userMessage == 'si' || $userMessage == 'menu' || $userMessage == 'esta bien' || $userMessage == 'ok' || $userMessage == 's' || $userMessage == 'ssi' || $userMessage == 'ver menu') {
        if ($conn->ping()) {
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

                $reply .= "<form action='chat.php' method='POST'>";
                $reply .= "<h2>Aquí tienes nuestro menú:</h2>";
                $reply .= "<p><h4> → Selecciona el producto que quieras y luego escoje la cantidad</h4>" ;
                $reply .= "<label for='Nombre'>Escribe tu Nombre:</label><br>";
                $reply .= "<input type='text' name='Nombre' id='NombreCliente'><br><br>";
                $reply .= "<label for='Nombre'>Telefono:</label><br>";
                $reply .= "<input type='text' name='Telefono' id='telefono'><br><br>";
                $reply .= "<table border='1'>";
                $reply .= "<tr><th>Menú</th><th>Producto</th><th>Precio</th><th>Cantidad</th></tr>";
                foreach ($menu as $item) {
                    $reply .= "<tr>";
                    $reply .= "<td><input type='checkbox' name='productos[]' value='" . $item['IdMenu'] . "'></td>";
                    $reply .= "<td>" . $item['NombreProducto'] . "</td>";
                    $reply .= "<td>" . formatCurrency($item['Precio']) . "</td>";
                    $reply .= "<td><input type='number' name='cantidades[" . $item['IdMenu'] . "]' value='0' min='0' max='10'></td>";
                    $reply .= "</tr>";
                }
                $reply .= "</table><br>";
                $reply .= "<label for='NumMesa'>Por favor ingresa tu Direccion:</label><br>";
                $reply .= "<input type='text' name='Direccion' value='' min='1' max='20' required><br><br>";
                $reply .= "<label for='Comentarios'>Si tienes algún comentario adicional, escríbelo aquí:</label><br>";
                $reply .= "<input type='text' name='Comentarios' max='100'><br>";
                $reply .= "<input type='hidden' name='FechaPedido' value='" . date('Y-m-d H:i:s') . "'><br>";
                $reply .= "<input type='submit' name='confirmar' value='Confirmar Pedido'>";
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
    if (isset($_POST['productos']) && isset($_POST['cantidades']) && isset($_POST['Direccion'])) {
        $nombre_C = $_POST['Nombre'];
        $telefono = $_POST['Telefono'];
        $productos = $_POST['productos'];
        $cantidades = $_POST['cantidades'];
        $Direccion = $_POST['Direccion'];
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
            $sqlInsertPedido = "INSERT INTO tblPedidos (Direccion, Telefono, NombreCliente, IdMenu, Comentarios, Cantidad, Total, FechaPedido) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtPedido = $conn->prepare($sqlInsertPedido);

            foreach ($detalles as $detalle) {
                $stmtPedido->bind_param("sssiidds", $Direccion, $telefono, $nombre_C, $detalle['IdMenu'], $detalle['Cantidad'], $detalle['Subtotal'], $total, $fecha);
                $stmtPedido->execute();
            }

            $sqlInsertFactura = "INSERT INTO tblFactura (Direccion, Telefono, NombreCliente, IdMenu, Cantidad, Subtotal, Total) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtFactura = $conn->prepare($sqlInsertFactura);

            foreach ($detalles as $detalle) {
                $stmtFactura->bind_param("sssiidd", $Direccion, $telefono, $nombre_C, $detalle['IdMenu'], $detalle['Cantidad'], $detalle['Subtotal'], $total);
                $stmtFactura->execute();
            }
            echo "<div id='factura-container'>";
                

                echo "<table id='detalles-tabla' border='2'>";
                echo "<tr><th colspan='8'>Detalles del pedido:</th></tr>";
                echo "<tr><th colspan='4'>Comentario</th></tr>";
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

                // Agrega las filas para el nombre del cliente, dirección y teléfono
                echo "<tr><td colspan='2'>Nombre del Cliente:</td><td colspan='2'>" . htmlspecialchars($nombre_C) . "</td></tr>";
                echo "<tr><td colspan='2'>Dirección:</td><td colspan='2'>" . htmlspecialchars($Direccion) . "</td></tr>";
                echo "<tr><td colspan='2'>Teléfono:</td><td colspan='2'>" . htmlspecialchars($telefono) . "</td></tr>";
                echo "<tr><td colspan='1'>Total:</td><td colspan='3'>" . formatCurrency($total) . "</td></tr>";
                echo "<tr><td colspan='4'> El tiempo estimado de espera es de 15 minutos.</td></tr>";
                echo "</table>";
            echo "</div>";

            

        } else {
            echo "No se ha seleccionado ningún producto.";
        }
    }
}
?>
