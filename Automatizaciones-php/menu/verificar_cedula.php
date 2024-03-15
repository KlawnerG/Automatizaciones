<?php
include("../connection/connection.php");
$con = connection();

if (isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];

    // Consultar si el usuario existe en la base de datos
    $sql = "SELECT * FROM tblUsuarios WHERE Cedula = '$cedula'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        // El usuario existe, redirigir a donde va el botón
        $descripcion = "Quiero personalizar el bot";
        $sql = "INSERT INTO tblPeticiones (Descripcion, CedulaCliente, FechaPedido) VALUES ('$descripcion', '$cedula', NOW())";

        if ($con->query($sql) === TRUE) {
            echo "registrado";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    } else {
        echo "no_registrado";
    }
}

$con->close();
?>