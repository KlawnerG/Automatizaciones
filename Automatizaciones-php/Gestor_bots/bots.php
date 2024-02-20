<?php
include("../connection/connection.php");
$con = connection();

$sqlTipos = "SELECT DISTINCT Nombre FROM tbltipos";
$queryTipos = mysqli_query($con, $sqlTipos);
$Tipos = mysqli_fetch_all($queryTipos, MYSQLI_ASSOC);

$sqlCategorias = "SELECT DISTINCT Nombre FROM tblcategorias";
$queryCategorias = mysqli_query($con, $sqlCategorias);
$Categorias = mysqli_fetch_all($queryCategorias, MYSQLI_ASSOC);

$sqlSubcategorias = "SELECT DISTINCT Nombre FROM tblsubcategorias";
$querySubcategorias = mysqli_query($con, $sqlSubcategorias);
$Subcategorias = mysqli_fetch_all($querySubcategorias, MYSQLI_ASSOC);

$searchIdbot = isset($_GET['searchIdbot']) ? $_GET['searchIdbot'] : '';

$sqlBots = "SELECT * FROM tblautomatizaciones";

if (!empty($searchIdbot)) {
    $sqlBots .= " WHERE IdBot LIKE '%$searchIdbot%'";
}
$queryBots = mysqli_query($con, $sqlBots);
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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilobots.css">
    <title>Bots Crud</title>
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
<div class="users-form">
    <h2>Registrar Bots</h2>
    <form action="insert_bots.php" method="POST">
        <input type="text" name="IdBot" placeholder="id bot">
        <input type="text" name="Nombre" placeholder="Nombre">
        <h3>Tipos de Bot</h3>
        <select name="Tipo" placeholder="Tipo de bot" style="font-family: 'Times New Roman', serif; font-size: 18px;">
            <?php
            foreach ($Tipos as $tipo) {
                echo "<option value='" . $tipo['Nombre'] . "'>" . $tipo['Nombre'] . "</option>";
            }
            ?>
        </select>
        <h3>Categoria</h3>
        <select name="Categoria" placeholder="Categoria" style="font-family: 'Times New Roman', serif; font-size: 18px;">
            <?php
            foreach ($Categorias as $categoria) {
                echo "<option value='" . $categoria['Nombre'] . "'>" . $categoria['Nombre'] . "</option>";
            }
            ?>
        </select>
        <h3>Subcategoria</h3>
        <select name="Subcategoria" placeholder="Subcategoria" style="font-family: 'Times New Roman', serif; font-size: 18px; ">
            <?php
            foreach ($Subcategorias as $subcategoria) {
                echo "<option value='" . $subcategoria['Nombre'] . "'>" . $subcategoria['Nombre'] . "</option>";
            }
            ?>
        </select>
        <br><br>
        <input type="text" name="CodigoFuente" placeholder="Codigo del Bot">
        <input type="text" name="CodigoFuente" placeholder="Plantilla de Codigo">
        <!-- Nuevo campo agregado -->
        <input type="text" name="Contenido" placeholder="Contenido">
        <!-- Fin del nuevo campo -->
        <input type="submit" value="Agregar Bot">
        <input type="reset" value="Cancelar Bot">
    </form>
</div>
<div class="users-table">
    <h2>Bots Registrados</h2>
    <center>
    <form action="" method="GET">
        <label for="searchIdbot">Buscar por ID:</label>
        <input type="text" name="searchIdbot" id="searchIdbot" value="<?= $searchIdbot ?>">
        <input type="submit" value="Buscar">
    </form>
    </center>
    <br><br>
    <table>
        <thead>
        <tr>
            <th>IdBot</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Categoria</th>
            <th>SubCategoria</th>
            <th>codigo Fuente</th>
            <th>Contenido</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
    <?php
    while ($row = mysqli_fetch_array($queryBots)) :
        ?>
        <tr>
            <th><?= isset($row['IdBot']) ? $row['IdBot'] : 'N/A'; ?></th>
            <th><?= isset($row['Nombre']) ? $row['Nombre'] : 'N/A'; ?></th>
            <th><?= isset($row['Tipo']) ? $row['Tipo'] : 'N/A'; ?></th>
            <th><?= isset($row['Categoria']) ? $row['Categoria'] : 'N/A'; ?></th>
            <th><?= isset($row['Subcategoria']) ? $row['Subcategoria'] : 'N/A'; ?></th>
            <th><?= isset($row['CodigoFuente']) ? $row['CodigoFuente'] : 'N/A'; ?></th>
            <th><?= isset($row['Contenido']) ? $row['Contenido'] : 'N/A'; ?></th>
            <th><a href="update_bots.php?IdBot=<?= isset($row['IdBot']) ? $row['IdBot'] : ''; ?>" class="users-table--edit">Editar</a></th>
            <th><a href="delete_bots.php?IdBot=<?= isset($row['IdBot']) ? $row['IdBot'] : ''; ?>" class="users-table--delete">Eliminar</a></th>
        </tr>
    <?php
    endwhile;
    ?>
</tbody>
    </table>
    bots.php
</div>
</body>
</html>
