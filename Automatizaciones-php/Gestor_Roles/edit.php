<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    include("../connection/connection.php");
    $con = connection();

    
    $Nombre = mysqli_real_escape_string($con, $_POST['Nombre']);
    $Descripcion = mysqli_real_escape_string($con, $_POST['Descripcion']);

    $sql = "UPDATE tblroles SET  Descripcion='$Descripcion' WHERE Nombre='$Nombre'";

    
    $query = mysqli_query($con, $sql);

   
    if ($query) {
        header("Location: roles.php"); 
        exit();
    } else {
        echo "Error al actualizar el usuario: " . mysqli_error($con);
    }

} else {
    echo "Acceso no autorizado.";
}
?>