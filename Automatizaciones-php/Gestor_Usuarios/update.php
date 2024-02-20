<?php
include("../connection/connection.php");
$con = connection();

$cedula = isset($_GET['cedula']) ? $_GET['cedula'] : '';


$sqlRoles = "SELECT DISTINCT Nombre FROM tblroles"; 
$queryRoles = mysqli_query($con, $sqlRoles);
$roles = mysqli_fetch_all($queryRoles, MYSQLI_ASSOC);

if (!empty($cedula)) {
    $sql = "SELECT * FROM tblusuarios WHERE cedula='$cedula'";
    $query = mysqli_query($con, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
    } else {
        echo "No se encontraron datos para la cédula proporcionada.";
        exit();
    }
} else {
    echo "Cédula no proporcionada o es inválida.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar usuarios</title>
    <link rel="stylesheet" href="estilousuarios.css">
    

</head>

<body>
    <div class="users-form">
        <form action="edit_user.php" method="POST">
            <input type="hidden" name="cedula" value="<?= isset($row['Cedula']) ? $row['Cedula'] : '' ?>">

            <label for="correo">Correo:</label>
            <input type="text" name="correo" placeholder="correo" value="<?= isset($row['Correo']) ? $row['Correo'] : '' ?>"><br>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" placeholder="nombre" value="<?= isset($row['Nombre']) ? $row['Nombre'] : '' ?>"><br>

            <label for="Password">Password:</label>
            <input type="text" name="Password" placeholder="Password" value="<?= isset($row['Password']) ? $row['Password'] : '' ?>"><br>

            <label for="rol">Rol:</label>
            <select name="rol" placeholder="rol">
                <?php
                foreach ($roles as $rolOption) {
                    $selected = ($rolOption['Nombre'] == $row['Rol']) ? 'selected' : '';
                    echo "<option value='" . $rolOption['Nombre'] . "' $selected>" . $rolOption['Nombre'] . "</option>";
                }
                ?>
            </select><br>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" placeholder="telefono" value="<?= isset($row['Telefono']) ? $row['Telefono'] : '' ?>"><br>

            <input type="submit" value="Actualizar">
            <input type="reset" value="Cancelar">
        </form>
    </div>
</body>

</html>
