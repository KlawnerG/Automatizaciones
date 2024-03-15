<?php
include("../connection/connection.php");
$con = connection();

$nombre = isset($_GET['Nombre']) ? $_GET['Nombre'] : '';
$descripcion = isset($_GET['Descripcion']) ? $_GET['Descripcion'] : '';

if (!empty($nombre) || !empty($descripcion)) {
    // Utilizando sentencias preparadas para prevenir inyección SQL
    $sql = "SELECT * FROM tbltipos WHERE Nombre=? OR Descripcion=?";
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $nombre, $descripcion);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
        } else {
            echo "No se encontraron datos de la Sub categoria.";
            exit();
        }
    } else {
        echo "Error en la preparación de la consulta.";
        exit();
    }
    mysqli_stmt_close($stmt);
} else {
    echo "El Nombre de la Sub categoria seleccionada no existe.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Categorias</title>
    <link rel="stylesheet" href="../Gestor_Peticiones/estilopeticiones.css">

</head>

<body>
    <div class="peticiones-form">
        <form action="edit_tipos.php" method="POST">

            <label for="Nombre">Nombre:</label>
            <input type="text" name="Nombre" placeholder="nombre" value="<?= isset($row['Nombre']) ? htmlspecialchars($row['Nombre']) : '' ?>"><br>

            <label for="Descripcion">Descripción:</label>
            <input type="text" name="Descripcion" placeholder="Descripción" value="<?= isset($row['Descripcion']) ? htmlspecialchars($row['Descripcion']) : '' ?>"><br>

            <input type="submit" value="Actualizar">
            <button type="reset" value="cancelar" onclick='redireccion()'>Eliminar</button> 

            <script> function redireccion() {
                window.location.href = "Tipos.php";
            }
            </script>
        </form>
    </div>
</body>

</html>