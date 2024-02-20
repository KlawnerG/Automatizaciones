<?php

if (isset($_GET["cedula"]) && !empty($_GET["cedula"])) {

    include("../connection/connection.php");
    $con = connection();

    $Cedula = mysqli_real_escape_string($con, $_GET["cedula"]);

    $sql = "DELETE FROM tblusuarios WHERE cedula='$Cedula'";

    $query = mysqli_query($con, $sql);

    if ($query) {
        header("Location: usuario.php"); 
        exit();
    } else {
        echo "Error al eliminar el Usuario: " . mysqli_error($con);
    }

} else {
    echo "Cedula del usuario no encontrada.";
}
?>
