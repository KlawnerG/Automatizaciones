<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    include("../connection/connection.php");
    $con = connection();

    
    $IdControl = mysqli_real_escape_string($con, $_POST['IdControl']);
    $CedulaEmpleado = mysqli_real_escape_string($con, $_POST['CedulaEmpleado']);
    $Fecha = mysqli_real_escape_string($con, $_POST['Fecha']);
    $CedulaCliente = mysqli_real_escape_string($con, $_POST ['CedulaCliente']);
    $IdPeticion = mysqli_real_escape_string($con, $_POST['IdPeticion']);
    $IdBot = mysqli_real_escape_string($con, $_POST['IdBot']);
    $EstadoPedido =mysqli_real_escape_string ($con , $_POST['EstadoPedido']);
    $PrecioBot = mysqli_real_escape_string($con, $_POST['PrecioBot']);

   
    $sql = "UPDATE tblcontrol SET IdControl='$IdControl', CedulaEmpleado='$CedulaEmpleado', Fecha='$Fecha', CedulaCliente='$CedulaCliente', IdPeticion='$IdPeticion', IdBot='$IdBot' , EstadoPedido='$EstadoPedido', PrecioBot = '$PrecioBot' WHERE IdControl='$IdControl'";

    
    $query = mysqli_query($con, $sql);

   
    if ($query) {
        header("Location: control.php"); 
        exit();
    } else {
        echo "Error al actualizar el usuario: " . mysqli_error($con);
    }

} else {
    echo "Acceso no autorizado.";
}
?>
