<?php
include("../connection/connection.php");
$con = connection();

$cedulaCliente = $_POST['cedulaCliente'];
$idBot = $_POST['idBot'];
$calificacion = $_POST['calificacion'];
$comentarios = $_POST['comentarios'];

// Verificar si el cliente existe en la tabla de usuarios y tiene el rol "Cliente"
$sql_verifys = "SELECT Cedula FROM tblusuarios WHERE Cedula = '$cedulaCliente' AND Rol = 'Cliente'";
$result_verifys = mysqli_query($con, $sql_verifys);
$sql_verify = "SELECT Cedula FROM tblusuarios WHERE Cedula = '$cedulaEmpleado' AND Rol != 'Cliente'";
$result_verify = mysqli_query($con, $sql_verify);



if (mysqli_num_rows($result_verifys) == 0) {
    echo '<script>alert("El Cliente no existe en la base de datos, verifica los datos."); window.location.href = "Calificacion.php";</script>';
    exit();
}


$sql = "INSERT INTO tblCalificacionBot (CedulaCliente, idBot, fecha, Calificacion, Comentarios) 
        VALUES ('$cedulaCliente', '$idBot', NOW(), '$calificacion', '$comentarios')";

$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: calificacion.php");
} else {
    echo "Error al insertar calificación: " . mysqli_error($con);
}
?>
