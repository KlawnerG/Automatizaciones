<?php
include("../connection/connection.php");
$con = connection();

$descripcion = $_POST['descripcion'];
$nombre = $_POST['nombre'];

if (empty($descripcion) || empty($nombre)) {
    echo "Error: Todos los campos deben ser completados.";
    exit();
}

$sql = "INSERT INTO tblSubcategorias (Descripcion, Nombre) VALUES ('$descripcion', '$nombre')";

$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: Sub_Categoria.php");
    echo "Sub categoria insertada correctamente.";
} else {
    echo "Error al insertar la Sub categoria: " . mysqli_error($con);
}
?>
