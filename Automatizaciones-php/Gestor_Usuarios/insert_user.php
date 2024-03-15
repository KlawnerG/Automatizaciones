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

    // Verificar si el cliente existe en la tabla de usuarios y tiene el rol "Cliente"
// Verificar si la cédula ya está registrada
$sql_verify_cedula = "SELECT Cedula FROM tblusuarios WHERE Cedula = ?";
$stmt_verify_cedula = mysqli_prepare($con, $sql_verify_cedula);
mysqli_stmt_bind_param($stmt_verify_cedula, 's', $cedula);
mysqli_stmt_execute($stmt_verify_cedula);
mysqli_stmt_store_result($stmt_verify_cedula);

if (mysqli_stmt_num_rows($stmt_verify_cedula) > 0) {
    echo '<script>alert("La cédula ya está registrada."); window.location.href = "usuario.php";</script>';
    exit();
}
    
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
