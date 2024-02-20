<?php


if (isset($_GET["Nombre"]) && !empty($_GET["Nombre"])) {

    
    include("../connection/connection.php");
    $con = connection();


    $nombre = mysqli_real_escape_string($con, $_GET["Nombre"]);

    
    $sql = "DELETE FROM tblsubcategorias WHERE Nombre='$nombre'";

    
    $query = mysqli_query($con, $sql);

    
    if ($query) {
        header("Location: Sub_Categoria.php"); 
        exit();
    } else {
        echo "Error al eliminar La Sub Categoria: " . mysqli_error($con);
    }

} else { 
}
?>