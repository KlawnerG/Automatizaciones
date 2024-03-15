<?php
include("../connection/connection.php");
$con = connection();

$nombre = $_POST['Nombre'];
$descripcion = $_POST['Descripcion'];

if (empty($nombre) || empty($descripcion)) {
    echo "Error: Todos los campos deben ser completados.";
    exit();
}

$sql = "INSERT INTO tblRoles (Nombre, Descripcion) VALUES ('$nombre', '$descripcion')";

$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: roles.php");
    echo "Rol insertado correctamente.";
} else {
    echo "Error al insertar rol: " . mysqli_error($con);
}
?>
