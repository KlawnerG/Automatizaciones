<?php


// confirmar sesion

session_start();

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
    background-color: rgb(90, 89, 89);
    margin: 0;
    font-family: 'Arial', sans-serif; /* Change the font family as needed */
}

.users-form {
    background-color: rgba(0, 0, 0, 0.8);
    padding: 20px;
    margin: 20px auto;
    border-radius: 10px;
    color: white;
    width: 50%; /* Adjust the width as needed */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: Add a subtle box shadow */
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

label {
    display: block;
    margin-bottom: 5px;
    color: white;
}

input {
    margin-bottom: 15px;
    padding: 10px;
    border: none;
    border-radius: 5px;
    width: 100%;
    box-sizing: border-box;
}

input[type="submit"],
input[type="reset"] {
    background-color: #ffd34f;
    color: black;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover,
input[type="reset"]:hover {
    background-color: white;
}

    </style>
</head>
<body>
    <div class="users-form">
        <h2>Registrar Peticiones</h2>
        <form action="insert_peticiones.php" method="POST">
            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion" name="Descripcion" placeholder="Escribe una breve descripción" required>

            <label for="cedulaCliente">Cedula del Cliente:</label>
            <input type="text" id="cedulaCliente" name="CedulaCliente" placeholder="Ingresa la cédula del cliente" required>

            <input type="submit" value="Agregar Peticion">
            <input type="reset" value="Limpiar">
        </form>
    </div>
    
  <script> 
  function Validar(){
    const cedula = document.querySelector('input[name="cedulaCliente"]:checked').value;
    alert(`numero de cedula es ${cedula}.`);
  }

  </script>
</body>
</html>