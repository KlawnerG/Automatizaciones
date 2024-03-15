<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    include("../connection/connection.php");
    $con = connection();

    
    $IdPeticion = mysqli_real_escape_string($con, $_POST['IdPeticion']);
    $descripcion = mysqli_real_escape_string($con, $_POST['Descripcion']);
    $cedula = mysqli_real_escape_string($con, $_POST['CedulaCliente']);
    $fecha = mysqli_real_escape_string ($con, $_POST['FechaPedido']);
    $EstadoPedido = mysqli_real_escape_string ($con, $_POST['EstadoPedido']);

   
    $sql = "UPDATE tblpeticiones SET CedulaCliente='$cedula', Descripcion='$descripcion', FechaPedido='$fecha', EstadoPedido ='$EstadoPedido' WHERE IdPeticion='$IdPeticion'";

    
    $query = mysqli_query($con, $sql);

   
    if ($query) {
        header("Location: peticiones.php"); 
        exit();
    } else {
        echo "Error al actualizar el usuario: " . mysqli_error($con);
    }

} else {
    echo "Acceso no autorizado.";
}
?>