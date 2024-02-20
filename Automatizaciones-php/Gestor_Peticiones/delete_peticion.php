<?php


if (isset($_GET["IdPeticion"]) && !empty($_GET["IdPeticion"])) {

    
    include("../connection/connection.php");
    $con = connection();

   
    $IdPeticion = mysqli_real_escape_string($con, $_GET["IdPeticion"]);

    
    $sql = "DELETE FROM tblpeticiones WHERE IdPeticion='$IdPeticion'";

    
    $query = mysqli_query($con, $sql);

    
    if ($query) {
        header("Location: peticiones.php"); 
        exit();
    } else {
        echo "Error al eliminar el usuario: " . mysqli_error($con);
    }

} else {
    echo "IdPeticion no proporcionada o es inválida.";
}
?>