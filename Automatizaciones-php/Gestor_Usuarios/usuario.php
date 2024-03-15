<?php
include("../connection/connection.php");
$con = connection();

$sqlRoles = "SELECT DISTINCT Nombre FROM tblroles";
$queryRoles = mysqli_query($con, $sqlRoles);
$roles = mysqli_fetch_all($queryRoles, MYSQLI_ASSOC);

$searchCedula = isset($_GET['searchCedula']) ? $_GET['searchCedula'] : '';

$sqlUsuarios = "SELECT * FROM tblusuarios";


if (!empty($searchCedula) || !empty($_GET['role'])) {
    $sqlUsuarios .= " WHERE ";
    if (!empty($searchCedula)) {
        $sqlUsuarios .= "Cedula LIKE '%$searchCedula%'";
    }
    if (!empty($searchCedula) && !empty($_GET['role'])) {
        $sqlUsuarios .= " AND ";
    }
    if (!empty($_GET['role'])) {
        $roleFilter = $_GET['role'];
        $sqlUsuarios .= "Rol = '$roleFilter'";
    }
}

$queryUsuarios = mysqli_query($con, $sqlUsuarios);
?>

<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location: ../menu/login.html ");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilousuarios.css">
    <link rel="stylesheet" href="../Gestor_Usuarios/estilomenu.css">
    <title>Usuarios Crud</title>
    <style>
        body {
            background-color: rgb(90, 89, 89);
        }


    </style>
</head>
<body>
<div class="menu">      
<nav>
        <ul>
        <li><a href="../Gestor_usuarios/usuario.php">Gestor de Usuarios</a></li>
    <li><a href="../Gestor_peticiones/peticiones.php">Gestor de Peticiones</a></li>
      <li class="dropdown">
  <a href="#">Automatizaciones</a>
  <ul class="dropdown-menu">
    <li><a href="../Gestor_bots/bots.php">Gestor de Bots</a></li>
    <li><a href="../Gestor_categorias/categoria.php">Categorías</a></li>
    <li><a href="../Gestor_sub_categorias/sub_categoria.php">Subcategorías</a></li>
    <li><a href="../Gestor_tipos/tipos.php">Gestor de Tipos</a></li>
  </ul>
</li>
    <li><a href="../Gestor_calificaciones/calificacion.php">Gestor de Calificaciones</a></li>
    <li><a href="../Gestor_roles/roles.php">Gestor de Roles</a></li>
    <li><a href="../Gestor_control/Control.php">Control</a></li>
    <li><a href="../menu/menuadmin.php">Home</a></li>
  </ul>
        </nav>
    </div>
<div class="users-form">
    <h2>Registrar usuarios</h2>
    <form action="insert_user.php" method="POST">
        <input type="text" name="cedula" placeholder="Cedula">
        <input type="text" name="correo" placeholder="Correo electronico">
        <input type="text" name="Nombre" placeholder="Nombre y Apellidos">
        <input type="text" name="Password" placeholder="Password">
        <select name="Rol" placeholder="Rol">
            <?php
            foreach ($roles as $rol) {
                echo "<option value='" . $rol['Nombre'] . "'>" . $rol['Nombre'] . "</option>";
            }
            ?>
        </select><br><br>
        <input type="int" name="telefono" placeholder="Telefono">
        <input type="submit" value="Agregar usuario">
        <input type="reset" value="Eliminar">
    </form>
</div>
<div class="users-table">
    <h2>Usuarios Registrados</h2>
    <center>
    <form action="usuario.php" method="GET">
        <label for="searchCedula">Buscar por Cedula:</label>
        <input type="text" name="searchCedula" id="searchCedula" value="<?= $searchCedula ?>">
        <label for="role">Filtrar por rol:</label>
        <select name="role" id="role">
            <option value="">Todos los roles</option>
            <?php
            foreach ($roles as $rol) {
                echo "<option value='" . $rol['Nombre'] . "'>" . $rol['Nombre'] . "</option>";
            }
            ?>
        </select>
        <input type="submit" value="Buscar">
    </form>
    </center>
    <br></br>
    
    <table>
        <thead>
        <tr>
            <th>Cedula</th>
            <th>Correo</th>
            <th>Nombre</th>
            <th>Password</th>
            <th>Rol</th>
            <th>Telefono</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_array($queryUsuarios)) :
            ?>
            <tr>
                <th><?= isset($row['Cedula']) ? $row['Cedula'] : 'N/A'; ?></th>
                <th><?= isset($row['Correo']) ? $row['Correo'] : 'N/A'; ?></th>
                <th><?= isset($row['Nombre']) ? $row['Nombre'] : 'N/A'; ?></th>
                <th><?= isset($row['Password']) ? $row['Password'] : 'N/A'; ?></th>
                <th><?= isset($row['Rol']) ? $row['Rol'] : 'N/A'; ?></th>
                <th><?= isset($row['Telefono']) ? $row['Telefono'] : 'N/A'; ?></th>
                <th><a href="update.php?cedula=<?= isset($row['Cedula']) ? $row['Cedula'] : ''; ?>" class="users-table--edit">Editar</a></th>
                <th><a href="delete_user.php?cedula=<?= isset($row['Cedula']) ? $row['Cedula'] : ''; ?>" class="users-table--delete"><img src="../img/trash.png" alt=""></a></th>
            </tr>
        <?php
        endwhile;
        ?>
        </tbody>
        <form id="generatePdfForm" action="../pdf/reporte.php" method="post">
            <label for="Nombrerol">Generar Por Rol: </label>
            <input type="text" name="NombreRol" autocomplete="off" ><br><br>
            <button type="submit" class="generate-pdf-btn">Generar Informe PDF</button>
        </form>

        <br><br>
    </table>
    
</div>
</body>
</html>
