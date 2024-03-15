<?php

if (isset($_GET["IdCalificacion"]) && !empty($_GET["IdCalificacion"])) {

    include("../connection/connection.php");
    $con = connection();

    $IdCalificacion = mysqli_real_escape_string($con, $_GET["IdCalificacion"]);

    $sql = "DELETE FROM tblCalificacionBot WHERE IdCalificacion='$IdCalificacion'";

    $query = mysqli_query($con, $sql);

    if ($query) {
        header("Location: Calificacion.php"); 
        exit();
    } else {
        echo "Error al eliminar el control: " . mysqli_error($con);
    }

} else {
    echo "ID de control no proporcionado o es inválido.";
}
?>
