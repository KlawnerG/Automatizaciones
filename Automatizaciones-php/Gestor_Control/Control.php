<?php
include("../connection/connection.php");
$con = connection();

$sqlEmpleados = "SELECT DISTINCT Cedula, Nombre FROM tblusuarios";
$queryEmpleados = mysqli_query($con, $sqlEmpleados);
$empleados = mysqli_fetch_all($queryEmpleados, MYSQLI_ASSOC);


$sqlPeticiones = "SELECT DISTINCT IdPeticion FROM tblpeticiones";
$queryPeticiones = mysqli_query($con, $sqlPeticiones);
$peticiones = mysqli_fetch_all($queryPeticiones, MYSQLI_ASSOC);

$sqlBots = "SELECT DISTINCT IdBot FROM tblautomatizaciones";
$queryBots = mysqli_query($con, $sqlBots);
$bots = mysqli_fetch_all($queryBots, MYSQLI_ASSOC);

$searchCedulaEmpleado = isset($_GET['searchCedulaEmpleado']) ? $_GET['searchCedulaEmpleado'] : '';
$searchFecha = isset($_GET['searchFecha']) ? $_GET['searchFecha'] : '';
$searchCedulaCliente = isset($_GET['searchCedulaCliente']) ? $_GET['searchCedulaCliente'] : '';

$sqlControles = "SELECT * FROM tblcontrol";


if (!empty($searchCedulaEmpleado)) {
    $sqlControles .= " WHERE CedulaEmpleado LIKE '%$searchCedulaEmpleado%'";
}

if (!empty($searchFecha)) {
    $sqlControles .= (strpos($sqlControles, 'WHERE') !== false) ? " AND Fecha LIKE '%$searchFecha%'" : " WHERE Fecha LIKE '%$searchFecha%'";
}

if (!empty($searchCedulaCliente)) {
    $sqlControles .= (strpos($sqlControles, 'WHERE') !== false) ? " AND CedulaCliente LIKE '%$searchCedulaCliente%'" : " WHERE CedulaCliente LIKE '%$searchCedulaCliente%'";
}

$queryControles = mysqli_query($con, $sqlControles);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilocontroles.css">
    <title>Controles Crud</title>
    <link rel="stylesheet" href="control.css">
    <style>
        body {
            background-color: rgb(90, 89, 89);
        }
    </style>
</head>
<div class="menu">
    <nav>
        <ul>
            <li><a href="../Gestor_usuarios/usuario.php">Gestor de Usuarios</a></li>
            <li><a href="../Gestor_bots/bots.php">Gestor de Bots</a></li>
            <li><a href="../Gestor_peticiones/peticiones.php">Gestor de Peticiones</a></li>
            <li><a href="../Gestor_calificaciones/calificacion.php">Gestor de Calificaciones</a></li>
            <li><a href="../Gestor_roles/roles.php">Gestor de Roles</a></li>
            <li><a href="../Gestor_tipos/tipos.php">Gestor de Tipos</a></li>
            <li><a href="../Gestor_categorias/categoria.php">Gestor de Categorías</a></li>
            <li><a href="../Gestor_sub_categorias/sub_categoria.php">Gestor de Subcategorías</a></li>
            <li><a href="../Gestor_control/Control.php ">Control</a></li>
        </ul>
    </nav>
</div>
<body>
<div class="controles-form">
    <h2>Registrar control</h2>
    <form action="insert_control.php" method="POST">
        <input type="text" name="cedulaEmpleado" placeholder="Cedula del Empleado" required>
        <input type="text" name="cedulaCliente" placeholder="Cedula del Cliente" required>
        <h4>IdPeticion</h4>
        <select name="idPeticion" placeholder="ID de la Petición" required>
            <?php
            foreach ($peticiones as $peticion) {
                echo "<option value='" . $peticion['IdPeticion'] . "'>" . $peticion['IdPeticion'] . "</option>";
            }
            ?>
        </select>
        <h4>idBot</h4>
        <select name="IdBot" placeholder="ID del Bot" required>
            <?php
            foreach ($bots as $bot) {
                echo "<option value='" . $bot['IdBot'] . "'>" . $bot['IdBot'] . "</option>";
            }
            ?>
        </select>
        <input type="text" name="precioBot" placeholder="Precio del Bot" required>
        <input type="submit" value="Agregar control">
        <input type="reset" value="Eliminar">
    </form>
</div>
<div class="controles-table">
    <h2>Controles Registrados</h2>
    
    <form action="" method="GET">
        <label for="searchCedulaEmpleado">Buscar por Cedula del Empleado:</label>
        <input type="text" name="searchCedulaEmpleado" id="searchCedulaEmpleado" value="<?= $searchCedulaEmpleado ?>">
        <label for="searchFecha">Buscar por Fecha:</label>
        <input type="date" name="searchFecha" id="searchFecha" value="<?= $searchFecha ?>">
        <label for="searchCedulaCliente">Buscar por Cedula del Cliente:</label>
        <input type="text" name="searchCedulaCliente" id="searchCedulaCliente" value="<?= $searchCedulaCliente ?>">
        <input type="submit" value="Buscar">
    </form>
            <br><br>
    <table>
        <thead>
        <tr>
            <th>ID de Control</th>
            <th>Cedula del Empleado</th>
            <th>Fecha</th>
            <th>Cedula del Cliente</th>
            <th>ID de la Petición</th>
            <th>ID del Bot</th>
            <th>Precio del Bot</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_array($queryControles)) :
            ?>
            <tr>
                <th><?= isset($row['IdControl']) ? $row['IdControl'] : 'N/A'; ?></th>
                <th><?= isset($row['CedulaEmpleado']) ? $row['CedulaEmpleado'] : 'N/A'; ?></th>
                <th><?= isset($row['Fecha']) ? $row['Fecha'] : 'N/A'; ?></th>
                <th><?= isset($row['CedulaCliente']) ? $row['CedulaCliente'] : 'N/A'; ?></th>
                <th><?= isset($row['IdPeticion']) ? $row['IdPeticion'] : 'N/A'; ?></th>
                <th><?= isset($row['IdBot']) ? $row['IdBot'] : 'N/A'; ?></th>
                <th><?= isset($row['PrecioBot']) ? $row['PrecioBot'] : 'N/A'; ?></th>
                <th><a href="update_control.php?idControl=<?= isset($row['IdControl']) ? $row['IdControl'] : ''; ?>" class="controles-table--edit">Editar</a></th>
                <th><a href="delete_control.php?idControl=<?= isset($row['IdControl']) ? $row['IdControl'] : ''; ?>" class="controles-table--delete">Eliminar</a></th>
            </tr>
            <?php
            endwhile;
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
