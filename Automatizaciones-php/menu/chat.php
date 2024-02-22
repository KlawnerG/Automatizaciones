<?php

include("connectionbot.php");
session_start(); // Iniciar sesión 
$conn = connectionbot();
$userMessage = isset($_POST['userMessage']) ? strtolower($_POST['userMessage']) : '';
$response = processUserMessage($userMessage, $conn);
echo $response;
$conn->close();

function processUserMessage($message, $conn) {
    $reply = "Lo siento no te entiendo puedes repetir";
    $saludoCommandKeywords = ['hola', 'buen dia', 'buendia', 'buenos dias', 'buenas noches', 'buenas', 'ola', 'vuenas', 'buena'];
    $saludoCommandRequested = checkKeywords($message, $saludoCommandKeywords);
    $deliveryKeywords = ['a domicilio', 'domicilio'];
    $deliveryRequested = checkKeywords($message, $deliveryKeywords);
    $inRestaurant = isset($_SESSION['inRestaurant']) ? $_SESSION['inRestaurant'] : false;
    $mesa = isset($_SESSION['NumeroMesa']) ? $_SESSION['NumeroMesa'] : null;
    $selectedProducts = isset($_SESSION['selectedProducts']) ? $_SESSION['selectedProducts'] : [];
    $menuItems = getMenuItems($conn);

    if ($saludoCommandRequested) {
        // Si ya está en el restaurante y se estableció el número de mesa, mostrar el menú y opciones
        if ($inRestaurant && $mesa !== null) {
            $reply = "Este es el menú:";
            foreach ($menuItems as $key => $item) {
                $reply .= "\n$key. " . $item['NombreProducto'] . " - $" . $item['Precio'];
            }
            $reply .= "\nPor favor elige los productos ingresando el número correspondiente.";
        } else {
            $reply = "Hola bienvenido a restaurante la parrillada ¿quieres el servicio en el restaurante o a domicilio?";
        }
    } elseif ($deliveryRequested) {
        // Si la entrega a domicilio es solicitada, pedir la información necesaria
        $reply = "Perfecto, necesitamos algunos detalles para la entrega a domicilio.\n";
        $reply .= "Por favor, ingresa tu nombre, teléfono y dirección de entrega, separados por comas.\n";
        $reply .= "Por ejemplo: Juan Perez, 1234567890, Calle 123, Ciudad";
        // Establecer la sesión en modo domicilio
        $_SESSION['inRestaurant'] = false;
    } elseif (strpos($message, 'restaurante') !== false) {
        $inRestaurant = true;
        $_SESSION['inRestaurant'] = true;
        $reply = "Ingresa el número de la mesa en la que te encuentras:";
        // No sobrescribas la respuesta anterior, si deseas mostrar el menú después de ingresar el número de mesa.
    } elseif ($inRestaurant && $mesa === null && is_numeric($message)) {
        // Captura el número de mesa y muestra el menú
        $_SESSION['NumeroMesa'] = $message;
        $mesa = $message;
        $reply = "¡Gracias! Ahora estás en la mesa número $mesa. Este es el menú:";
        foreach ($menuItems as $key => $item) {
            $reply .= "\n$key. " . $item['NombreProducto'] . " - $" . $item['Precio'];
        }
        $reply .= "\nPor favor, elige los productos ingresando el número correspondiente.";
    } elseif ($inRestaurant && is_numeric($message) && isset($menuItems[$message])) {
        $selectedProducts[] = $menuItems[$message];
        $_SESSION['selectedProducts'] = $selectedProducts;
        $reply = "Agregaste " . $menuItems[$message]['NombreProducto'] . " a tu orden.";

        // Guardar el número de mesa en la tabla de pedidos y detalle de pedidos
        guardarNumeroMesa($conn);
    } elseif (!$inRestaurant && strpos($message, ',') !== false) {
        // Si estamos en modo domicilio y el mensaje contiene comas, procesar la información
        $deliveryInfo = explode(',', $message);
        if (count($deliveryInfo) == 3) {
            $nombre = trim($deliveryInfo[0]);
            $telefono = trim($deliveryInfo[1]);
            $direccion = trim($deliveryInfo[2]);
            
            // Insertar la información de entrega a domicilio en la base de datos
            $orderId = confirmarDomicilio($conn, $nombre, $telefono, $direccion);
            
            if (is_numeric($orderId)) {
                $reply = "Perfecto, tu pedido a domicilio fue confirmado con el ID: " . $orderId . ", y llegará en aproximadamente 30 minutos.";
            } else {
                $reply = $orderId; // Manejar el mensaje de error
            }
            // Reiniciar la sesión después de confirmar la orden
            session_unset();
            session_destroy();
        } else {
            $reply = "Por favor, ingresa la información correctamente (nombre, teléfono, dirección).";
        }
    } elseif (strtolower($message) == 'confirmar orden') {
        $total = calcularTotal($selectedProducts);
        $orderId = confirmarOrden($conn, $selectedProducts, $total);
        if (is_numeric($orderId)) {
            $reply = "Perfecto, tu orden fue confirmada con el ID: " . $orderId . ", y tiene un tiempo de 15 minutos aproximadamente.";
        } else {
            $reply = $orderId; // Manejar el mensaje de error
        }
        // Reiniciar la sesión después de confirmar la orden
        session_unset();
        session_destroy();
    } elseif (strtolower($message) == 'ver total') {
        // Mostrar el total y la lista de productos seleccionados
        $total = calcularTotal($selectedProducts);
        $reply = "Tu orden actual es la siguiente:\n";
        foreach ($selectedProducts as $product) {
            $reply .= $product['NombreProducto'] . " - $" . $product['Precio'] . "\n";
        }
        $reply .= "Total a pagar: $" . $total;
    
    } elseif (strtolower($message) == 'gracias') {
        $reply = "¡Tu pedido fue confirmado! Por favor, espera.";
        // Reiniciar la sesión después de confirmar la orden
        session_unset();
        session_destroy();
    } elseif (strtolower($message) == 'ya no quiero nada') {
        $reply = "Entonces abrite sapo.";
        // Reiniciar la sesión después de confirmar la orden
        session_unset();
        session_destroy();
    } elseif (strtolower($message) == 'gracias') {
        $reply = "¡Tu pedido fue confirmado! Por favor, espera.";
        // Reiniciar la sesión después de confirmar la orden
        session_unset();
        session_destroy();
    } elseif (strtolower($message) == 'cancelar') {
        $reply = "Entonces abrite sapo.";
        // Reiniciar la sesión después de confirmar la orden
        session_unset();
        session_destroy();
    }

    return $reply;
}

function calcularTotal($selectedProducts) {
    $total = 0.000; // Inicializar el total como un número decimal
    foreach ($selectedProducts as $product) {
        $total += $product['Precio'];
    }
    return number_format($total, 4); // Formatear el total con 2 decimales
}

function confirmarDomicilio($conn, $nombre, $telefono, $direccion) {
    try {
        $conn->begin_transaction();

        // Insertar los detalles de la entrega a domicilio en la tabla tblDomicilio
        $sqlDomicilio = "INSERT INTO tblDomicilio (Nombre, Telefono, DireccionEntrega) VALUES (?, ?, ?)";
        $stmtDomicilio = $conn->prepare($sqlDomicilio);
        $stmtDomicilio->bind_param("sss", $nombre, $telefono, $direccion);

        if (!$stmtDomicilio->execute()) {
            throw new Exception($stmtDomicilio->error);
        }

        $orderId = $stmtDomicilio->insert_id; // Obtener el ID de la orden generada

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        // Devolver detalles específicos sobre el error
        return "Hubo un error al procesar tu pedido. Detalles del error: " . $e->getMessage();
    }

    return $orderId;
}

function guardarNumeroMesa($conn) {
    try {
        // Verificar si la clave 'lastOrderId' está definida en $_SESSION
        if (!isset($_SESSION['lastOrderId'])) {
            // Si no está definida, mostrar un mensaje de error o manejar de alguna manera adecuada
            return "Error: 'lastOrderId' no está definido en la sesión.";
        }

        // Obtener el ID de la orden generada
        $orderId = $_SESSION['lastOrderId'];

        // Resto del código...
        // ...
    } catch (Exception $e) {
        // Manejar el error adecuadamente (puedes loggearlo, mostrar un mensaje al usuario, etc.)
        return "Hubo un error al guardar el número de mesa. Detalles del error: " . $e->getMessage();
    }
}

function getMenuItems($conn) {
    $menuItems = [];
    $sql = "SELECT NombreProducto, DescripcionProducto, Precio FROM tblMenu";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $menuItems[] = $row;
        }
    }

    return $menuItems;
}

function checkKeywords($message, $keywords) {
    foreach ($keywords as $keyword) {
        if (strpos($message, $keyword) !== false) {
            return true;
        }
    }
    return false;
}


function confirmarOrden($conn, $selectedProducts, $total) {
    try {
        $conn->begin_transaction();

        // Insertar los detalles de la orden en la tabla tblPedidos
        $sqlPedido = "INSERT INTO tblPedidos (Numeromesa, TotalPedido) VALUES (?, ?)";
        $stmtPedido = $conn->prepare($sqlPedido);
        $stmtPedido->bind_param("id", $_SESSION['NumeroMesa'], $total);

        $stmtPedido->execute();

        // Obtener el ID de la orden generada
        $_SESSION['lastOrderId'] = $stmtPedido->insert_id;

        // Utilizar la función para guardar el número de mesa en las tablas correspondientes
        guardarNumeroMesa($conn);

        // Insertar los detalles de los productos en la tabla tblDetallePedido
        $sqlDetalle = "INSERT INTO tblDetallePedido (NumeroPedido, Numeromesa, NombreProducto, Cantidad, Precio) VALUES (?, ?, ?, ?, ?)";
        $stmtDetalle = $conn->prepare($sqlDetalle);

        foreach ($selectedProducts as $product) {
            $nombreProducto = $product['NombreProducto'];
            $cantidad = 1; // Por ejemplo, se asume una cantidad fija de 1 por producto
            $precio = $product['Precio'];

            $stmtDetalle->bind_param("iisid", $_SESSION['lastOrderId'], $_SESSION['NumeroMesa'], $nombreProducto, $cantidad, $precio);
            $stmtDetalle->execute();
        }

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        // Manejar el error adecuadamente (puedes loggearlo, mostrar un mensaje al usuario, etc.)
        return "Hubo un error al procesar tu pedido. Por favor, inténtalo de nuevo. Detalles del error: " . $e->getMessage();
    }

    return $_SESSION['lastOrderId'];
}
?>