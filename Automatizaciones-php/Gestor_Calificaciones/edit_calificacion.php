<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    include("../connection/connection.php");
    $con = connection();

    
    $IdCalificacion = mysqli_real_escape_string($con, $_POST['IdCalificacion']);
    $CedulaCliente = mysqli_real_escape_string($con, $_POST['CedulaCliente']);
    $idBot = mysqli_real_escape_string($con, $_POST['idBot']);
    $fecha = mysqli_real_escape_string($con, $_POST['fecha']);
    $Calificacion = mysqli_real_escape_string($con, $_POST['Calificacion']);
    $Comentarios = mysqli_real_escape_string($con, $_POST['Comentarios']);


    $sql = "UPDATE tblCalificacionBot SET CedulaCliente='$CedulaCliente', idBot='$idBot', fecha='$fecha', Calificacion='$Calificacion', Comentarios='$Comentarios' WHERE IdCalificacion='$IdCalificacion'";

    
    $query = mysqli_query($con, $sql);


    if ($query) {
        header("Location: Calificacion.php"); 
        exit();
    } else {
        echo "Error al actualizar el usuario: " . mysqli_error($con);
    }

} else {
    echo "Acceso no autorizado.";
}
?>