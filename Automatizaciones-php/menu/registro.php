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
background-image: url('http://getwallpapers.com/wallpaper/full/a/5/d/544750.jpg');
background-size: cover;
background-repeat: no-repeat;
font-family: 'Numans', sans-serif;
margin: 0;
}

.container {
    display: flex;
    justify-content: space-around;
}

.users-form, .users-table {
    background-color: rgba(0, 0, 0, 0.5);
    padding: 20px;
    margin: 20px;
    border-radius: 10px;
    color: white;
    width: 45%; /* Adjust the width as needed */
}

.users-form {
    height: 100vh;
}

.users-form h2,
.users-table h2 {
    text-align: center;
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

input,
select {
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


.users-table table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.users-table th,
.users-table td {
    border: 1px solid white;
    padding: 10px;
    text-align: center;
}

.users-table th {
    background-color: #ffd34f;
    color: black;
}

.users-table a {
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.users-table--edit {
    background-color: #3498db;
    color: white;
}

.users-table--edit:hover {
    background-color: #2980b9;
}

.users-table--delete {
    background-color: #e74c3c;
    color: white;
}

.users-table--delete:hover {
    background-color: #c0392b;
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