<?php


if (isset($_GET["Nombre"]) && !empty($_GET["Nombre"])) {


    include("../connection/connection.php");
    $con = connection();


    $nombre = mysqli_real_escape_string($con, $_GET["Nombre"]);
    $descripcion = mysqli_real_escape_string($con, $_GET["Descripcion"]);

    
    $sql = "DELETE FROM tblroles WHERE nombre='$nombre'";
    $query = mysqli_query($con, $sql);

    
    if ($query) {
        header("Location: roles.php"); 
        exit();
    } else {
        echo "Error al eliminar el Rol: " . mysqli_error($con);
    }

} else {
    echo "Rol no proporcionada o es inválida.";
}
?>