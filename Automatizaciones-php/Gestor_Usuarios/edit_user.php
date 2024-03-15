<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    include("../connection/connection.php");
    $con = connection();

    
    $cedula = mysqli_real_escape_string($con, $_POST['cedula']);
    $correo = mysqli_real_escape_string($con, $_POST['correo']);
    $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
    $Password = mysqli_real_escape_string($con, $_POST['Password']);
    $rol = mysqli_real_escape_string($con, $_POST['rol']);
    $telefono = mysqli_real_escape_string($con, $_POST['telefono']);

   
    $sql = "UPDATE tblusuarios SET correo='$correo', nombre='$nombre', Password='$Password', rol='$rol', telefono='$telefono' WHERE cedula='$cedula'";

    
    $query = mysqli_query($con, $sql);

   
    if ($query) {
        header("Location: usuario.php"); 
        exit();
    } else {
        echo "Error al actualizar el usuario: " . mysqli_error($con);
    }

} else {
    echo "Acceso no autorizado.";
}
?>