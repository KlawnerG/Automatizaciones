<?php
include("../connection/connection.php");
$con = connection();

$cedulaEmpleado = ($_POST['cedulaEmpleado']);
$cedulaCliente = ($_POST['cedulaCliente']);
$idPeticion = ($_POST['idPeticion']);
$precioBot = ($_POST['precioBot']);
$idBot = ($_POST['IdBot']);

// Verificar si el cliente existe en la tabla de usuarios y tiene el rol "Cliente"
$sql_verifys = "SELECT Cedula FROM tblusuarios WHERE Cedula = '$cedulaCliente' AND Rol = 'Cliente'";
$result_verifys = mysqli_query($con, $sql_verifys);
$sql_verify = "SELECT Cedula FROM tblusuarios WHERE Cedula = '$cedulaEmpleado' AND Rol != 'Cliente'";
$result_verify = mysqli_query($con, $sql_verify);

if (mysqli_num_rows($result_verify) == 0) {
    echo '<script>alert("Empleado no valido, verifica los datos."); window.location.href = "control.php";</script>';
    exit();
}

if (mysqli_num_rows($result_verifys) == 0) {
    echo '<script>alert("El usuario no existe, verifica los datos."); window.location.href = "control.php";</script>';
    exit();
}


if (empty($cedulaEmpleado) || empty($cedulaCliente) || empty($idPeticion) || empty($precioBot) || empty($idBot)) {
    echo "Error: All fields must be filled.";
    exit();

}

$sql = "INSERT INTO tblcontrol (cedulaEmpleado, fecha, cedulaCliente, idPeticion, precioBot, IdBot) VALUES ('$cedulaEmpleado',  NOW() , '$cedulaCliente','$idPeticion', '$precioBot', '$idBot')";

$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: ../gestor_control/control.php");
} else {
    echo "Error al insertar control: " . mysqli_error($con);
}

?>
