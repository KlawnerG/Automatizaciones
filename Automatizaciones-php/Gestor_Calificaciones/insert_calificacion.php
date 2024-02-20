<?php
include("../connection/connection.php");
$con = connection();

$cedulaCliente = $_POST['cedulaCliente'];
$idBot = $_POST['idBot'];
$fecha = $_POST['fecha'];
$calificacion = $_POST['calificacion'];
$comentarios = $_POST['comentarios'];

$sql = "INSERT INTO tblCalificacionBot (CedulaCliente, idBot, fecha, Calificacion, Comentarios) 
        VALUES ('$cedulaCliente', '$idBot', '$fecha', '$calificacion', '$comentarios')";

$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: calificacion.php");
} else {
    echo "Error al insertar calificación: " . mysqli_error($con);
}
?>
