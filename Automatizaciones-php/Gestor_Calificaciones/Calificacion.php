<?php
include("../connection/connection.php");
$con = connection();

$sqlCalificaciones = "SELECT * FROM tblCalificacionBot";



$searchCedula = isset($_GET['searchCedula']) ? $_GET['searchCedula'] : '';

if (!empty($searchCedula)) {
    $sqlCalificaciones .= " WHERE CedulaCliente IN (SELECT Cedula FROM tblUsuarios WHERE Cedula LIKE '%$searchCedula%')";
}

$queryCalificaciones = mysqli_query($con, $sqlCalificaciones);
?>
<?php

session_start();

if (!isset($_SESSION["usuario"])) {
    # code...
    header("location: ../menu/login.html ");
}
?>

<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="calificaciones.css">
<head>

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
<div class="calificaciones-form">
    <h2>Registrar calificaciones</h2>
    <form action="insert_calificacion.php" method="POST">
        <input type="text" name="cedulaCliente" placeholder="Cedula del Cliente">
        <input type="text" name="idBot" placeholder="ID del Bot">
        <input type="date" name="fecha" placeholder="Fecha">
        <input type="text" name="calificacion" placeholder="Calificacion">
        <input type="text" name="comentarios" placeholder="Comentarios">

        <input type="submit" value="Agregar calificación">
        <input type="reset" value="Eliminar">
    </form>
</div>
<div class="calificaciones-table">
    <br>
    <center>
    <h2>Calificaciones Registradas</h2>
    

    <form action="" method="GET">
        <label for="searchCedula">Buscar por Cedula del Cliente:</label>
        <input type="text" name="searchCedula" id="searchCedula" value="<?= $searchCedula ?>">
        <input type="submit" value="Buscar">
    </form>
    </center>
    <br>
    <table>
        <thead>
        <tr>
            <th>ID Calificacion</th>
            <th>Cedula Cliente</th>
            <th>ID Bot</th>
            <th>Fecha</th>
            <th>Calificacion</th>
            <th>Comentarios</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_array($queryCalificaciones)) :
            ?>
            <tr>
                <th><?= isset($row['IdCalificacion']) ? $row['IdCalificacion'] : 'N/A'; ?></th>
                <th><?= isset($row['CedulaCliente']) ? $row['CedulaCliente'] : 'N/A'; ?></th>
                <th><?= isset($row['idBot']) ? $row['idBot'] : 'N/A'; ?></th>
                <th><?= isset($row['fecha']) ? $row['fecha'] : 'N/A'; ?></th>
                <th><?= isset($row['Calificacion']) ? $row['Calificacion'] : 'N/A'; ?></th>
                <th><?= isset($row['Comentarios']) ? $row['Comentarios'] : 'N/A'; ?></th>
                <th><a href="update_calificacion.php?IdCalificacion=<?= isset($row['IdCalificacion']) ? $row['IdCalificacion'] : ''; ?>" class="users-table--edit">Editar</a></th>
                <th><a href="delete_calificacion.php?IdCalificacion=<?= isset($row['IdCalificacion']) ? $row['IdCalificacion'] : ''; ?>" class="users-table--delete">Eliminar</a></th>
            </tr>
        <?php
        endwhile;
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
