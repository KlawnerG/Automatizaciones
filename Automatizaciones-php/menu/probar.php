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
    </style>
</head>
<body>
    <div id="chat-container">
        <h1>Ordena en Nuestra Comida Rápida</h1>
        <div id="user-input">
            <input type="text" id="user-message" placeholder="Tu mensaje...">
            <button id="send-button" onclick="sendMessage()">Enviar</button>
        </div>
        <div id="order-summary"></div>
        <div id="order-confirmation"></div>
    </div>

    <script>
        var orderSummary = [];

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
            var chatContainer = document.getElementById('chat-container');
            var messageElement = document.createElement('p');
            messageElement.textContent = message;
            messageElement.classList.add(messageType);
            chatContainer.appendChild(messageElement);
            document.getElementById('user-message').value = '';
        }

        function simulateBotResponse(userMessage) {
            var lowerCaseUserMessage = userMessage.toLowerCase();

            var menu = {
                "menú 1": {
                    "descripcion": "Hamburguesa, papas fritas y bebida",
                    "precio": 10.99
                },
                "menú 2": {
                    "descripcion": "Hamburguesa vegana, batatas y batido de frutas",
                    "precio": 12.99
                },
                "menú 3": {
                    "descripcion": "Nuggets de pollo, puré de papas y jugo",
                    "precio": 8.99
                }
            };

            switch (lowerCaseUserMessage) {
                case 'hola':
                    return '¡Hola! ¿En qué puedo ayudarte con tu pedido de comida rápida? Aquí hay algunas cosas que puedes hacer:\n- Decir "Ver menú"\n- Decir "Quiero un menú"\n- Especificar un menú, por ejemplo, "Menú 1"';
                case 'ver menú':
                    var menuOptions = Object.keys(menu).join(', ');
                    return `Claro, aquí están nuestros menús disponibles: ${menuOptions}. ¿Cuál prefieres?`;
                case 'quiero un menú':
                    return 'Perfecto, ¿cuál de nuestros menús te gustaría ordenar?';
                case 'menú 1':
                case 'menú 2':
                case 'menú 3':
                    var selectedMenu = menu[lowerCaseUserMessage];
                    return `Excelente elección. ${selectedMenu.descripcion}. El precio es $${selectedMenu.precio}. ¿Te gustaría agregar algo más a tu orden?`;
                case 'no':
                    showOrderSummary();
                    return 'Tu orden ha sido registrada con éxito. ¡Gracias por elegirnos!';
                default:
                    return 'Lo siento, no entendí. ¿Puedes repetir o especificar tu pedido?';
            }
        }

        function updateOrderSummary(response) {
            var match = response.match(/menú \d/i);
            if (match) {
                var menuNumber = match[0].toLowerCase();
                orderSummary.push({
                    menu: menuNumber,
                    descripcion: menu[menuNumber].descripcion,
                    precio: menu[menuNumber].precio
                });
            }
        }

        function showOrderSummary() {
            var orderSummaryContainer = document.getElementById('order-summary');
            var orderConfirmationContainer = document.getElementById('order-confirmation');
            if (orderSummary.length > 0) {
                var totalPrecio = orderSummary.reduce((total, item) => total + item.precio, 0);
                orderSummaryContainer.innerHTML = `<p>Tu orden:</p><ul>${orderSummary.map(item => `<li>${item.menu}: ${item.descripcion} - $${item.precio.toFixed(2)}</li>`).join('')}</ul><p>Total a pagar: $${totalPrecio.toFixed(2)}</p>`;
                orderSummaryContainer.style.display = 'block';

                orderConfirmationContainer.innerHTML = `<p>Tu orden fue registrada correctamente. Aquí está el detalle:</p><ul>${orderSummary.map(item => `<li>${item.menu}: ${item.descripcion} - $${item.precio.toFixed(2)}</li>`).join('')}</ul><p>Total a pagar: $${totalPrecio.toFixed(2)}</p>`;
                orderConfirmationContainer.style.display = 'block';
            }
        }
    </script>
</body>
</html>