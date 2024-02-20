<?php
include("../connection/connection.php");
$con = connection();

$idPeticion = isset($_GET['IdPeticion']) ? $_GET['IdPeticion'] : '';
$cedulaCliente = isset($_GET['CedulaCliente']) ? $_GET['CedulaCliente'] : '';

if (!empty($idPeticion) || !empty($cedulaCliente)) {
    // Utilizando sentencias preparadas para prevenir inyección SQL
    $sql = "SELECT * FROM tblpeticiones WHERE IdPeticion=? OR CedulaCliente=?";
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $idPeticion, $cedulaCliente);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
        } else {
            echo "No se encontraron datos para la petición o la cédula proporcionada.";
            exit();
        }
    } else {
        echo "Error en la preparación de la consulta.";
        exit();
    }
    mysqli_stmt_close($stmt);
} else {
    echo "ID de la petición o cédula del cliente no proporcionada o es inválida.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Peticiones</title>
    <link rel="stylesheet" href="estilopeticiones.css">
</head>

<body>
    <div class="peticiones-form">
        <form action="edit_peticion.php" method="POST">
            <input type="hidden" name="IdPeticion" value="<?= isset($row['IdPeticion']) ? $row['IdPeticion'] : '' ?>">

            <label for="Descripcion">Descripción:</label>
            <input type="text" name="Descripcion" placeholder="Descripción" value="<?= isset($row['Descripcion']) ? htmlspecialchars($row['Descripcion']) : '' ?>"><br>

            <label for="CedulaCliente">Cédula del Cliente:</label>
            <input type="text" name="CedulaCliente" placeholder="Cédula del Cliente" value="<?= isset($row['CedulaCliente']) ? htmlspecialchars($row['CedulaCliente']) : '' ?>"><br>

            <input type="submit" value="Actualizar">
            <input type="reset" value="Cancelar">
        </form>
    </div>
</body>

</html>
