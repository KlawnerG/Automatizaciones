<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="estilocalificacion.css">
    
</head>

<header>
    <h1>ZenithTech</h1>  <nav>
        <ul>
            <li><a href="bot.html">Conoce Nuestros Bots</a></li>
            <li><a href="peticiones.php">Realiza Peticiones</a></li>
            <li><a href="calificacion.php">Haz una Calificación</a></li>
            <li><a href="index.html">Menú</a></li>
        </ul>
    </nav>
</header>


  


<body>
    <form id="form_1" method="post" action="procesar_calificacion.php">
        <label for="cedulaCliente">Cédula del Cliente:</label>
        <input type="text" id="cedulaCliente" name="cedulaCliente" required>

        <label for="idBot">ID del Bot:</label>
        <input type="text" id="idBot" name="idBot" required>

        <p class="clasificacion">
            <input id="radio1" type="radio" name="calificacion" value="5">
            <label for="radio1">★</label>
            <input id="radio2" type="radio" name="calificacion" value="4">
            <label for="radio2">★</label>
            <input id="radio3" type="radio" name="calificacion" value="3">
            <label for="radio3">★</label>
            <input id="radio4" type="radio" name="calificacion" value="2">
            <label for="radio4">★</label>
            <input id="radio5" type="radio" name="calificacion" value="1">
            <label for="radio5">★</label>
        </p>

        <label for="comentarios">Comentarios:</label>
        <textarea id="comentarios" name="comentarios" rows="4" cols="50"></textarea>

        <br>
        <input type="submit" value="Enviar Calificación">
    </form>
</body>

</html>