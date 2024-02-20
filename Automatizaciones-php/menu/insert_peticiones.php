<?php
include("../connection/connection.php");
$con = connection();

$descripcion = $_POST['Descripcion'];
$cedulaCliente = $_POST['CedulaCliente'];

if (empty($descripcion) || empty($cedulaCliente)) {
    echo "Error: Todos los campos deben ser completados.";
    exit();
}

// Verificar si el cliente existe en la tabla de usuarios y tiene el rol "Cliente"
$sql_verify = "SELECT Cedula FROM tblusuarios WHERE Cedula = '$cedulaCliente' AND Rol = 'Cliente'";
$result_verify = mysqli_query($con, $sql_verify);

if (mysqli_num_rows($result_verify) == 0) {
    echo '<script>alert("El usuario no está registrado o no tiene permiso para realizar una petición."); window.location.href = "registro.php";</script>';
    exit();
}

// Si el usuario existe y tiene el rol "Cliente", insertar la petición
$sql = "INSERT INTO tblPeticiones (Descripcion, CedulaCliente) VALUES ('$descripcion', '$cedulaCliente')";
$query = mysqli_query($con, $sql);

if ($query) {
    echo '<script>alert("Petición registrada con éxito. Haz clic en aceptar para ir al menú."); window.location.href = "menu.html";</script>';
} else {
    echo "Error al insertar la petición.";
}
?>

