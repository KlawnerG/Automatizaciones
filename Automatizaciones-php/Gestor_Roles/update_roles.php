<?php
include("../connection/connection.php");
$con = connection();

$Nombre = isset($_GET['Nombre']) ? $_GET['Nombre'] : '';



if (!empty($Nombre)) {
    $sql = "SELECT * FROM tblroles WHERE Nombre='$Nombre'";
    $query = mysqli_query($con, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
    } else {
        echo "No se encontraron datos para Nombre proporcionada.";
        exit();
    }
} else {
    echo "Nombre no proporcionada o es inválida.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Roles</title>
    <link rel="stylesheet" href="estiloroles.css">

</head>

<body>
    <div class="Roles-form">
        <form action="edit.php" method="POST">
            <input type="hidden" name="Nombre" value="<?= isset($row['Nombre']) ? $row['Nombre'] : '' ?>">
            <label for="Descripcion">Teléfono:</label>
            <input type="text" name="Descripcion" placeholder="Descripcion" value="<?= isset($row['Descripcion']) ? $row['Descripcion'] : '' ?>"><br>
            <center>
            <input type="submit" value="Actualizar">
            <input type="reset" value="Cancelar">
            </center>
        </form>
    </div>
</body>

</html>