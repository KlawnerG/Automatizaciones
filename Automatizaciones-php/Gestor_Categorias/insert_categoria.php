<?php
include("../connection/connection.php");
$con = connection();

$descripcion = $_POST['descripcion'];
$nombre = $_POST['nombre'];

if (empty($descripcion) || empty($nombre)) {
    echo "Error: Todos los campos deben ser completados.";
    exit();
}

$sql = "INSERT INTO tblcategorias (Descripcion, Nombre) VALUES ('$descripcion', '$nombre')";

$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: Categoria.php");
    echo "Peticion insertada correctamente.";
} else {
    echo "Error al insertar peticion: " . mysqli_error($con);
}
?>
