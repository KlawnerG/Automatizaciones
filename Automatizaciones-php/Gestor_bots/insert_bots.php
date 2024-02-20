
<?php
include("../connection/connection.php");
$con = connection();

$nombre = $_POST['Nombre'];
$tipo = $_POST['Tipo'];
$categoria = $_POST['Categoria'];
$subcategoria = $_POST['Subcategoria'];
$codigofuente = $_POST['CodigoFuente'];
$contenido = $_POST['Contenido'];


if (empty($nombre) || empty($tipo) || empty($categoria) || empty($subcategoria) || empty($codigofuente) || empty($contenido)) {
    echo "Error: All fields must be filled.";
    exit();
}

$sql = "INSERT INTO tblautomatizaciones (Nombre, Tipo, Categoria, Subcategoria, CodigoFuente, Contenido) VALUES ('$nombre', '$tipo', '$categoria','$subcategoria', '$codigofuente', '$contenido')";

$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: ../Gestor_bots/bots.php");
} else {
    echo "Error al insertar usuario: " . mysqli_error($con);
}

?>
