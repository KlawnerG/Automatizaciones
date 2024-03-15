<?php
include("../connection/connection.php");
$con = connection();

// Aumentar el tamaño máximo permitido para los datos enviados
ini_set('post_max_size', '16M');
ini_set('upload_max_filesize', '16M');

$nombre = mysqli_real_escape_string($con, $_POST['Nombre']);
$tipo = mysqli_real_escape_string($con, $_POST['Tipo']);
$categoria = mysqli_real_escape_string($con, $_POST['Categoria']);
$subcategoria = mysqli_real_escape_string($con, $_POST['Subcategoria']);
$codigofuente = mysqli_real_escape_string($con, $_POST['CodigoFuente']);
$contenido = mysqli_real_escape_string($con, $_POST['Contenido']);

$sql = "INSERT INTO tblautomatizaciones (Nombre, Tipo, Categoria, Subcategoria, CodigoFuente, Contenido) VALUES ('$nombre', '$tipo', '$categoria', '$subcategoria', '$codigofuente', '$contenido')";
$query = mysqli_query($con, $sql) or die("Error: " . mysqli_error($con));

if ($query) {
    header("Location: ../Gestor_bots/bots.php");
} else {
    echo "Error al insertar bot: " . mysqli_error($con);
}
if (empty($nombre) || empty($tipo) || empty($categoria) || empty($subcategoria) || empty($codigofuente) || empty($contenido)) {
    echo "Error: All fields must be filled.";
    exit();
}
$sql = "INSERT INTO tblautomatizaciones (Nombre, Tipo, Categoria, Subcategoria, CodigoFuente, Contenido) VALUES ('$nombre', '$tipo', '$categoria','$subcategoria', '$codigofuente', '$contenido')";
$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: ../Gestor_bots/bots.php");
} else {
    echo "Error al insertar bot: " . mysqli_error($con);
}

$con->close();
?>