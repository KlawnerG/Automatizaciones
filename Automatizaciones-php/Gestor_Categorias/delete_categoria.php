<?php


if (isset($_GET["Nombre"]) && !empty($_GET["Nombre"])) {

    
    include("../connection/connection.php");
    $con = connection();

   
    $nombre = mysqli_real_escape_string($con, $_GET["Nombre"]);

    
    $sql = "DELETE FROM tblcategorias WHERE Nombre='$nombre'";

    
    $query = mysqli_query($con, $sql);

    
    if ($query) {
        header("Location: Categoria.php"); 
        exit();
    } else {
        echo "Error al eliminar La Categoria: " . mysqli_error($con);
    }

} else { 
}
?>