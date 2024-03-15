
<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    include("../connection/connection.php");
    $con = connection();

    
    $IdBot = mysqli_real_escape_string($con, $_POST['IdBot']);
    $nombre = mysqli_real_escape_string($con, $_POST['Nombre']);
    $tipo = mysqli_real_escape_string($con, $_POST['Tipo']);
    $categoria = mysqli_real_escape_string($con, $_POST['Categoria']);
    $subcategoria = mysqli_real_escape_string($con, $_POST['Subcategoria']);
    $codigfuente = mysqli_real_escape_string($con, $_POST['CodigoFuente']);
    $contenido = mysqli_real_escape_string($con, $_POST['Contenido']);


    $sql = "UPDATE tblautomatizaciones SET IdBot='$IdBot', Nombre='$nombre', Tipo='$tipo', Categoria='$categoria', Subcategoria='$subcategoria' WHERE IdBot='$IdCalificacion'";

    
    $query = mysqli_query($con, $sql);


    if ($query) {
        header("Location: bots.php"); 
        exit();
    } else {
        echo "Error al actualizar: " . mysqli_error($con);
    }

} else {
    echo "Acceso no autorizado.";
}
?>
