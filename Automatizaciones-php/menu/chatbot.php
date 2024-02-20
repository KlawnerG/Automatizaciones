<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ordena en Nuestra Comida Rápida</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #chat-container {
            max-width: 500px;
            width: 100%;
            margin: 20px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        #user-input {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        #user-message {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        #send-button {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        #send-button:hover {
            background-color: #45a049;
        }

        p {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            background-color: #f0f0f0;
        }

        .user-message {
            background-color: #e6f7ff;
        }

        .bot-message {
            background-color: #fff5e6;
        }

        #order-summary {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            background-color: #4caf50;
            color: #fff;
            display: none;
        }

        #order-confirmation {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            background-color: #2196f3;
            color: #fff;
            display: none;
        }

        /* Nuevos estilos para el chat history */
        #chat-history {
            margin-top: 20px;
            max-height: 150px;
            overflow-y: scroll;
        }
    </style>
</head>
<body>
    <div id="chat-container">
        <h1 id="welcome-message">Ordena en Nuestra Comida Rápida</h1>
        <!-- Agregamos un historial de chat -->
        <div id="chat-history"></div>
        <div id="user-input">
            <input type="text" id="user-message" placeholder="Tu mensaje...">
            <button id="send-button" onclick="sendMessage()">Enviar</button>
        </div>
        <div id="order-summary"></div>
        <div id="order-confirmation"></div>
    </div>

    <script>
        var orderSummary = [];
        var customMenu = {};
        var welcomeMessage = 'Ordena en Nuestra Comida Rápida';
        var businessName = 'Comida Rápida Express';
        var finalMessage = '¡Gracias por ordenar en Comida Rápida Express! Esperamos verte de nuevo pronto.';

        function sendMessage() {
            var userMessage = document.getElementById('user-message').value;
            appendMessage('Cliente: ' + userMessage, 'user-message');

            setTimeout(function() {
                var botResponse = simulateBotResponse(userMessage);
                appendMessage('Chatbot: ' + botResponse, 'bot-message');
                updateOrderSummary(botResponse);
            }, 500);
        }

        function appendMessage(message, messageType) {
            // Añadimos el mensaje al historial de chat
            var chatHistory = document.getElementById('chat-history');
            var messageElement = document.createElement('p');
            messageElement.textContent = message;
            messageElement.classList.add(messageType);
            chatHistory.appendChild(messageElement);

            // También lo mostramos en el chat principal
            var chatContainer = document.getElementById('chat-container');
            chatContainer.appendChild(messageElement);

            document.getElementById('user-message').value = '';
        }

        function simulateBotResponse(userMessage) {
            var lowerCaseUserMessage = userMessage.toLowerCase();

            if (lowerCaseUserMessage.includes('mensaje de bienvenida')) {
                var nuevoMensaje = prompt("Ingrese el nuevo mensaje de bienvenida:");
                if (nuevoMensaje) {
                    welcomeMessage = nuevoMensaje;
                    document.getElementById('welcome-message').textContent = welcomeMessage;
                    return `El mensaje de bienvenida ha sido actualizado a: ${nuevoMensaje}`;
                } else {
                    return 'El mensaje de bienvenida no fue cambiado.';
                }
            }

            if (lowerCaseUserMessage.includes('nombre del negocio')) {
                var nuevoNombre = prompt("Ingrese el nuevo nombre del negocio:");
                if (nuevoNombre) {
                    businessName = nuevoNombre;
                    document.getElementById('welcome-message').textContent = businessName;
                    return `El nombre del negocio ha sido actualizado a: ${nuevoNombre}`;
                } else {
                    return 'El nombre del negocio no fue cambiado.';
                }
            }

            if (lowerCaseUserMessage.includes('ver menú')) {
                return showMenu();
            }

            if (lowerCaseUserMessage.includes('mensaje final')) {
                var nuevoMensajeFinal = prompt("Ingrese el nuevo mensaje final:");
                if (nuevoMensajeFinal) {
                    finalMessage = nuevoMensajeFinal;
                    return `El mensaje final ha sido actualizado a: ${nuevoMensajeFinal}`;
                } else {
                    return 'El mensaje final no fue cambiado.';
                }
            }

            if (lowerCaseUserMessage.includes('total')) {
                return showOrderSummary();
            }

            // Agregar lógica para seleccionar un platillo
            if (lowerCaseUserMessage.includes('seleccionar')) {
                var platilloSeleccionado = lowerCaseUserMessage.split(' ')[1];
                if (customMenu[platilloSeleccionado]) {
                    orderSummary.push({
                        platillo: platilloSeleccionado,
                        precio: customMenu[platilloSeleccionado]
                    });
                    return `Has seleccionado ${platilloSeleccionado}. ¿Quieres agregar algo más a tu pedido?`;
                } else {
                    return 'Lo siento, no reconocí ese platillo. ¿Puedes seleccionar uno de los disponibles?';
                }
            }

            // Resto de la lógica de respuesta del bot, como antes...
        }

        function updateOrderSummary(response) {
            // Lógica para actualizar el resumen del pedido, como antes...
        }

        function showMenu() {
            var menuMessage = `Aquí está nuestro menú:\n`;
            for (var platillo in customMenu) {
                menuMessage += `- ${platillo} - $${customMenu[platillo].toFixed(2)}\n`;
            }
            return menuMessage + '\nEscribe "Seleccionar [Platillo]" para agregarlo a tu pedido.';
        }

        function personalizarChatbot() {
            orderSummary = []; // Restablecer el resumen del pedido al personalizar
            customMenu = {}; // Restablecer los platillos personalizados

            welcomeMessage = prompt("Ingrese el nuevo mensaje de bienvenida:");
            document.getElementById('welcome-message').textContent = welcomeMessage;

            businessName = prompt("Ingrese el nuevo nombre del negocio:");
            document.getElementById('welcome-message').textContent = businessName;

            finalMessage = prompt("Ingrese el mensaje final personalizado:");

            while (true) {
                var platillo = prompt("Ingrese un platillo (o escriba 'fin' para terminar):");
                if (platillo.toLowerCase() === 'fin') {
                    break;
                }

                var precio = parseFloat(prompt(`Ingrese el precio para ${platillo}:`));
                if (!isNaN(precio)) {
                    customMenu[platillo] = precio;
                } else {
                    alert("Por favor, ingrese un precio válido.");
                }
            }

            // Mostrar los platillos personalizados en el chat
            appendMessage('Chatbot: Estos son los platillos personalizados disponibles:', 'bot-message');
            for (var platillo in customMenu) {
                appendMessage(`Chatbot: ${platillo} - $${customMenu[platillo].toFixed(2)}`, 'bot-message');
            }
        }

        function finalizarPedido() {
            // Mostrar mensaje final personalizado y resumen del pedido
            appendMessage(`Chatbot: ${finalMessage}`, 'bot-message');
            showOrderSummary();
            generarConfirmacionPedido();
        }

        function showOrderSummary() {
            // Lógica para mostrar el resumen del pedido, como antes...
            var orderSummaryContainer = document.getElementById('order-summary');
            orderSummaryContainer.innerHTML = `<p>Tu orden:</p>`;
            for (var i = 0; i < orderSummary.length; i++) {
                orderSummaryContainer.innerHTML += `<p>${orderSummary[i].platillo} - $${orderSummary[i].precio.toFixed(2)}</p>`;
            }

            if (orderSummary.length > 0) {
                var totalPrecio = orderSummary.reduce((total, item) => total + item.precio, 0);
                orderSummaryContainer.innerHTML += `<p>Total a pagar: $${totalPrecio.toFixed(2)}</p>`;
            }

            orderSummaryContainer.style.display = 'block';
        }

        function generarConfirmacionPedido() {
            var orderConfirmationContainer = document.getElementById('order-confirmation');
            orderConfirmationContainer.innerHTML = `<p>Confirmación del Pedido:</p>`;
            
            for (var i = 0; i < orderSummary.length; i++) {
                orderConfirmationContainer.innerHTML += `<p>${orderSummary[i].platillo} - $${orderSummary[i].precio.toFixed(2)}</p>`;
            }

            if (orderSummary.length > 0) {
                var totalPrecio = orderSummary.reduce((total, item) => total + item.precio, 0);
                orderConfirmationContainer.innerHTML += `<p>Total a pagar: $${totalPrecio.toFixed(2)}</p>`;
            }

            orderConfirmationContainer.style.display = 'block';
        }
    </script>

    <button onclick="personalizarChatbot()">Personalizar Chatbot</button>
    <button onclick="finalizarPedido()">Finalizar Pedido</button>
</body>
</html>
