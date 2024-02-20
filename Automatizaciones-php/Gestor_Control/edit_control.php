<?php
include("../connection/connection.php");
$con = connection();

// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanitizar los datos del formulario
    $cedulaEmpleado = mysqli_real_escape_string($con, $_POST['cedulaEmpleado']);
    $fecha = mysqli_real_escape_string($con, $_POST['fecha']);
    $cedulaCliente = mysqli_real_escape_string($con, $_POST['cedulaCliente']);
    $idPeticion = mysqli_real_escape_string($con, $_POST['idPeticion']);
    $precioBot = mysqli_real_escape_string($con, $_POST['precioBot']);
    $idBot = mysqli_real_escape_string($con, $_POST['IdBot']);

    // Construir la consulta SQL
    $sql = "UPDATE tblcontrol SET cedulaEmpleado='$cedulaEmpleado', fecha='$fecha', cedulaCliente='$cedulaCliente', idPeticion='$idPeticion', precioBot='$precioBot' WHERE IdBot='$idBot'";


    // Ejecutar la consulta
    $query = mysqli_query($con, $sql);

    // Verificar si la consulta se ejecutó correctamente
    if ($query) {
        header("Location: control.php");
        exit();
    } else {
        echo "Error al actualizar la información: " . mysqli_error($con);
    }

} else {
    echo "Acceso no autorizado.";
}
?>
