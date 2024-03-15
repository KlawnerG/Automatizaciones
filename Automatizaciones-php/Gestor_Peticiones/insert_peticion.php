<?php
include("../connection/connection.php");
$con = connection();

$descripcion = $_POST['Descripcion'];
$cedulaCliente = $_POST['CedulaCliente'];
$Fecha = $_POST["FechaPedido"];
$EstadoPedido = $_POST["EstadoPedido"];

if (empty($descripcion) || empty($cedulaCliente)) {
    echo "Error: Todos los campos deben ser completados.";
    exit();
}

$sql = "INSERT INTO tblPeticiones (Descripcion, CedulaCliente, FechaPedido, EstadoPedido) VALUES ('$descripcion', '$cedulaCliente','$Fecha', '$EstadoPedido')";

$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: peticiones.php");
    echo "Peticion insertada correctamente.";
} else {
    echo "Error al insertar peticion: " . mysqli_error($con);
}
?>
