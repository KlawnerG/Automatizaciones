<?php
include("../connection/connection.php");
$con = connection();

$idbot = isset($_GET['IdBot']) ? $_GET['IdBot'] : '';


$sqlTipos = "SELECT DISTINCT Nombre FROM tbltipos";
$queryTipos = mysqli_query($con, $sqlTipos);
$Tipos = mysqli_fetch_all($queryTipos, MYSQLI_ASSOC);

$sqlCategorias = "SELECT DISTINCT Nombre FROM tblcategorias";
$queryCategorias = mysqli_query($con, $sqlCategorias);
$Categorias = mysqli_fetch_all($queryCategorias, MYSQLI_ASSOC);

$sqlSubcategorias = "SELECT DISTINCT Nombre FROM tblsubcategorias";
$querySubcategorias = mysqli_query($con, $sqlSubcategorias);
$Subcategorias = mysqli_fetch_all($querySubcategorias, MYSQLI_ASSOC);

if (!empty($idbot)) {
    $sql = "SELECT * FROM tblautomatizaciones WHERE IdBot='$idbot'";
    $query = mysqli_query($con, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
    } else {
        echo "No se encontraron datos para la ID proporcionado.";
        exit();
    }
} else {
    echo "ID no proporcionado o es inválido.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="estilobots.css">
    <title>Editar usuarios</title>
    

</head>

<body>
    <div class="users-form">
        <form action="edit_bots.php" method="POST">
            <input type="hidden" name="IdBot" value="<?= isset($row['IdBot']) ? $row['IdBot'] : '' ?>">

            <label for="Nombre">Nombre:</label>
            <input type="text" name="nombre" placeholder="nombre" value="<?= isset($row['Nombre']) ? $row['Nombre'] : '' ?>"><br>
            <h4>Tipos</h4>
            <select name="Tipo" placeholder="tipo de bot">
            <?php
            foreach ($Tipos as $tipo) {
                echo "<option value='" . $tipo['Nombre'] . "'>" . $tipo['Nombre'] . "</option>";
            }
            ?>
        </select>
        <h4>categoria</h4>
        <br>
        <select name="Categoria" placeholder="Categoria">
            <?php
            foreach ($Categorias as $categoria) {
                echo "<option value='" . $categoria['Nombre'] . "'>" . $categoria['Nombre'] . "</option>";
            }
            ?>
        </select>
        <h4>subcategoria</h4>
        <br>
        <select name="Subcategoria" placeholder="Subcategoria">
            <?php
            foreach ($Subcategorias as $subcategoria) {
                echo "<option value='" . $subcategoria['Nombre'] . "'>" . $subcategoria['Nombre'] . "</option>";
            }
            ?>
        
        </select><br>

            <label for="CodigoFuente">codigo fuente:</label>
            <input type="text" name="CodigoFuente" placeholder="CodigoFuente" value="<?= isset($row['CodigoFuente']) ? $row['CodigoFuente'] : '' ?>"><br>

            <label for="Contenido">codigo fuente:</label>
            <input type="text" name="Contenido" placeholder="Contenido" value="<?= isset($row['Contenido']) ? $row['Contenido'] : '' ?>"><br>

            <input type="submit" value="Actualizar">
            <button type="reset" value="cancelar" onclick='redireccion()'>Eliminar</button> 

            <script> function redireccion() {
                window.location.href = "bots.php";
            }
            </script>

        </form>
    </div>
</body>

</html>
