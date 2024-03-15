<?php
include("../connection/connection.php");
$con = connection();

$IdCalificacion = isset($_GET['IdCalificacion']) ? $_GET['IdCalificacion'] : '';

if (!empty($IdCalificacion)) {
    $sql = "SELECT * FROM tblCalificacionBot WHERE IdCalificacion='$IdCalificacion'";
    $query = mysqli_query($con, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
    } else {
        echo "No se encontraron datos para IdCalificacion proporcionada.";
        exit();
    }
} else {
    echo "IdCalificacion no proporcionada o es inválida.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar usuarios</title>
    <link rel="stylesheet" href="../Gestor_Peticiones/estilopeticiones.css">

</head>

<body>
    <div class="users-form">
        <form action="edit_calificacion.php" method="POST">
            <input type="hidden" name="IdCalificacion" value="<?= isset($row['IdCalificacion']) ? $row['IdCalificacion'] : '' ?>">

            <label for="CedulaCliente">CedulaCliente:</label>
            <input type="text" name="CedulaCliente" placeholder="CedulaCliente" value="<?= isset($row['CedulaCliente']) ? $row['CedulaCliente'] : '' ?>"><br>

            <label for="idBot">idBot:</label>
            <input type="text" name="idBot" placeholder="idBot" value="<?= isset($row['idBot']) ? $row['idBot'] : '' ?>"><br>

            <label for="fecha">fecha:</label>
            <input type="text" name="fecha" placeholder="fecha" value="<?= isset($row['fecha']) ? $row['fecha'] : '' ?>"><br>


            <label for="Calificacion">Calificacion:</label>
            <input type="text" name="Calificacion" placeholder="Calificacion" value="<?= isset($row['Calificacion']) ? $row['Calificacion'] : '' ?>"><br>

            <label for="Comentarios">Comentarios:</label>
            <input type="text" name="Comentarios" placeholder="Comentarios" value="<?= isset($row['Comentarios']) ? $row['Comentarios'] : '' ?>"><br>

            <input type="submit" value="Actualizar">
            <button type="reset" value="cancelar" onclick='redireccion()'>Eliminar</button> 

            <script> function redireccion() {
                window.location.href = "Calificacion.php";
            }
            </script>
        </form>
    </div>
</body>

</html>
