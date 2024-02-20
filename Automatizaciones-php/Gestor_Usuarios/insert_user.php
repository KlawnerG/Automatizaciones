<?php
include("../connection/connection.php");
$con = connection();


$cedula = $_POST['cedula'];
$correo = $_POST['correo'];
$nombre = $_POST['Nombre'];
$Password = $_POST['Password'];
$rol = $_POST['Rol']; 
$telefono = $_POST['telefono'];


$checkRol = mysqli_query($con, "SELECT * FROM tblroles WHERE Nombre = '$rol'");
if (mysqli_num_rows($checkRol) > 0) {
    
    $sql = "INSERT INTO tblusuarios (cedula, correo, nombre, Password, rol, telefono) VALUES ('$cedula', '$correo', '$nombre', '$Password', '$rol', '$telefono')";
    $query = mysqli_query($con, $sql);

    if ($query) {
        header("Location: usuario.php");
    } else {
        
        echo "Error al insertar usuario: " . mysqli_error($con);
    }
} else {
    
    echo "Error: El rol '$rol' no existe en la tabla tblroles.";
}
?>
