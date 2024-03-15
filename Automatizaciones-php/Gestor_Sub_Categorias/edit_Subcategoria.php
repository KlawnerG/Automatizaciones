<?php
include("../connection/connection.php");
$con = connection();

$nombre = mysqli_real_escape_string($con, $_POST['Nombre']);
$descripcion = mysqli_real_escape_string($con, $_POST['Descripcion']);

$sql = "UPDATE tblsubCategorias SET Descripcion='$descripcion' WHERE Nombre='$nombre'";

$query = mysqli_query($con, $sql);

if ($query) {
    // Verificar si se afectó alguna fila
    if (mysqli_affected_rows($con) > 0) {
        header("Location: Sub_Categoria.php"); 
        exit();
    } else {
        echo "No se encontró el registro con el nombre proporcionado.";
    }
} else {
    echo "Error al actualizar la Sub Categoría: " . mysqli_error($con);
}
?>



