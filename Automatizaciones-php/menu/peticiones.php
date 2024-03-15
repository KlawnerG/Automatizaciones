<?php




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilopeticiones.css">
    <title>Peticiones Crud</title>
    <style>
    body {
  font-family: 'Poppins', sans-serif;
  margin: 0;
  padding: 0;
  background-image: url('https://i.pinimg.com/originals/55/01/60/5501609ee45d514d1f2c4a63502045e2.gif');
  color: black;
}

.logo img {
  position: absolute;
  max-width: 60px;
  top: 10px;
 
}


/* Encabezado */
header {
  background-color: #1a1a1a;
  padding: 1px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

header h1 {
  font-size: 24px;
  margin: 10px;
}

header nav ul {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  position: relative;
  right: 20px;
}

header nav ul li {
  margin-left: 20px;
}

header nav ul li a {
  color: #ffffff;
  text-decoration: none;
  transition: color 0.3s ease;
}

header nav ul li a:hover {
    color: #064f17;
  }

    /* Estilos del formulario de registro */
    .users-form {
        background-color: rgba(255, 255, 255, 0.8);
        /* Color de fondo modificado */
        padding: 20px;
        margin: 90px auto;
        width: 80%;
        max-width: 600px;
        border-radius: 10px;
    }

    .users-form h2 {
        text-align: center;
        font-size: 30px;
        margin-bottom: 20px;
    }

    .users-form input[type="text"],
    .users-form input[type="date"] {
        width: 95%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 20px;
    }

    .users-form input[type="submit"],
    .users-form input[type="reset"],
    .users-form button[type="reset"] {
        background-color: #000000;
        /* Color de fondo modificado */
        color: aqua;
        cursor: pointer;
        font-weight: bold;
        width: 40%;
        padding: 15px;
        border-radius: 20px;
        margin-right: 25px;
        margin-left: 25px;
    }

    .users-form input[type="submit"]:hover,
    .users-form input[type="reset"]:hover,
    .users-form button[type="reset"]:hover {
        background-color: white;
        color: #9bbedd;
        /* Color del texto modificado */
    }

    /* Estilos de la tabla de calificaciones */
    .users-table {
        background-color: rgba(255, 255, 255, 0.8);
        /* Color de fondo modificado */
        padding: 20px;
        margin: 50px auto;
        width: 80%;
        border-radius: 10px;
        justify-content: center;
    }

    .users-table h2 {
        text-align: center;
        font-size: 30px;
        margin-bottom: 30px;
        justify-content: center;
    }

    .users-table table {
        width: 100%;
        border-collapse: collapse;
        justify-content: center;
        justify-content: center;
    }

    .users-table table th,
    .users-table table td {
        padding: 10px;
        border-bottom: 1px solid #ccc;
        justify-content: center;
    }

    .users-table table th {
        background-color: #000000;
        /* Color de fondo modificado */
        color: white;
        font-weight: bold;
        text-align: left;
    }

    .users-table--edit,
    .users-table--delete {
        display: inline-block;
        padding: 5px 10px;
        background-color: aqua;
        color: black;
        /* Color del texto modificado */
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .users-table--edit:hover,
    .users-table--delete:hover {
        background-color: #7da6c2;
        /* Color de fondo modificado */
        color: white;
        /* Color del texto modificado */
    }


    /* Estilos del formulario de peticiones */
    .peticiones-form {
        background-color: #b7bec4;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin: 250px auto;
        width: 80%;
        max-width: 600px;
        border-radius: 10px;
    }

    .peticiones-form label {
        color: rgb(0, 0, 0);
        display: block;
        margin-bottom: 5px;
    }

    .peticiones-form input[type="text"],
    .peticiones-form input[Type='date'] {
        width: 90%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .peticiones-form input[type="submit"],
    .peticiones-form input[type="reset"],
    .peticiones-form button[type="reset"] {
        background-color: black;
        color: aqua;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }

    .peticiones-form input[type="submit"]:hover,
    .peticiones-form input[type="reset"]:hover {
        background-color: white;
        color: aqua;
    }

   

    </style>

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

    <div class="users-form">

        <h2>Registrar Peticiones</h2>
        <form action="insert_peticiones.php" method="POST">
            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion" name="Descripcion" placeholder="Escribe una breve descripción" required>

            <label for="cedulaCliente">Cedula del Cliente:</label>
            <input type="text" id="cedulaCliente" name="CedulaCliente" placeholder="Ingresa la cédula del cliente"
                required>

            <input type="submit" value="Agregar Peticion">
            <input type="reset" value="Limpiar">
        </form>
    </div>

    <script>
    function Validar() {
        const cedula = document.querySelector('input[name="cedulaCliente"]:checked').value;
        alert(`numero de cedula es ${cedula}.`);
    }
    </script>
</body>

</html>