
<?php


if (isset($_GET["IdBot"]) && !empty($_GET["IdBot"])) {

    
    include("../connection/connection.php");
    $con = connection();

   
    $IdBot = mysqli_real_escape_string($con, $_GET["IdBot"]);

    
    $sql = "DELETE FROM tblautomatizaciones WHERE IdBot='$IdBot'";

    
    $query = mysqli_query($con, $sql);

    
        if ($query) {
            header("Location: bots.php"); 
            exit();
        } else {
            echo "Error al eliminar el bot: " . mysqli_error($con);
        }
    } else {
            echo "ID no proporcionada o es inválida.";
    }
?>