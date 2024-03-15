<?php
include("../connection/connection.php");
$con = connection();

$sqlRoles = "SELECT DISTINCT Nombre FROM tblroles";
$queryRoles = mysqli_query($con, $sqlRoles);
$roles = mysqli_fetch_all($queryRoles, MYSQLI_ASSOC);

$searchCedula = isset($_GET['searchCedula']) ? $_GET['searchCedula'] : '';

$sqlUsuarios = "SELECT * FROM tblusuarios";

if (!empty($searchCedula)) {
    $sqlUsuarios .= " WHERE Cedula LIKE '%$searchCedula%'";
}
$queryUsuarios = mysqli_query($con, $sqlUsuarios);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Crud</title>
<style>
body {
    background-image: url('https://i.pinimg.com/originals/55/01/60/5501609ee45d514d1f2c4a63502045e2.gif');
background-size: cover;
background-repeat: no-repeat;
font-family: 'Numans', sans-serif;
margin: 0;
}

body {
        font-family: 'Poppins', sans-serif;
        background-image: url('https://i.pinimg.com/originals/55/01/60/5501609ee45d514d1f2c4a63502045e2.gif');
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    input[type="submit"]
     {
        width: 100%;
        background-color: #000000;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        margin:5px;
    }
    input[type="submit"]:hover {
        background-color: #727272;
    }
    input[type="reset"] {
        width: 100%;
        background-color: #000000;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        margin:5px;
    }
    input[type="reset"]:hover {
        background-color: #727272;
    }

    </style>
</head>
<body>
    <center>
<div class="users-form">
    <h2>Registrate</h2>
    <form action="insert_user.php" method="POST">
        <input type="text" name="cedula" placeholder="Cedula">
        <input type="text" name="correo" placeholder="Correo electronico">
        <input type="text" name="Nombre" placeholder="Nombre y Apellidos">     
        <input type="text" name="Password" placeholder="Password">
        <input type="text" name="telefono" placeholder="Telefono">
        <input type="submit" value="Crear Usuario" >  
        <input type="reset" value="Eliminar">
    </form>
</div>
</center>
    
</body>
</html>