<?php
include("../connection/connection.php");
$con = connection();

// Inicializar $searchCedula y $searchIdPeticion
$searchCedula = isset($_GET['searchCedula']) ? $_GET['searchCedula'] : '';
$searchIdPeticion = isset($_GET['searchIdPeticion']) ? $_GET['searchIdPeticion'] : '';

$sqlPeticiones = "SELECT * FROM tblpeticiones";

if (!empty($searchCedula)) {
    $searchCedula = mysqli_real_escape_string($con, $searchCedula);
    $sqlPeticiones .= " WHERE CedulaCliente LIKE '%$searchCedula%'";
} elseif (!empty($searchIdPeticion)) {
    $searchIdPeticion = mysqli_real_escape_string($con, $searchIdPeticion);
    $sqlPeticiones .= " WHERE IdPeticion LIKE '%$searchIdPeticion%'";
}

$queryPeticiones = mysqli_query($con, $sqlPeticiones);
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
    <link rel="stylesheet" href="estilopeticiones.css">
    <link rel="stylesheet" href="../Gestor_Usuarios/estilomenu.css">
    <title>Peticiones Crud</title>
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
<body>
<div class="users-form">
    <h2>Registrar Peticiones</h2>
    <form action="insert_peticion.php" method="POST">
        <input type="text" name="Descripcion" placeholder="Descripción">
        <input type="text" name="CedulaCliente" placeholder="Cedula del Cliente">
        <input type="date" name="FechaPedido" placeholder="Fecha">
        <input type="text" name="EstadoPedido" placeholder="Estado Pedido">
        <input type="submit" value="Agregar Peticion">
        <input type="reset" value="Limpiar">
    </form>
</div>
<div class="users-table">
    <h2>Peticiones Registradas</h2>
    <center>
    <form action="" method="GET">
        <label for="searchCedula">Buscar por Cedula del Cliente:</label>
        <input type="text" name="searchCedula" id="searchCedula" value="<?= $searchCedula ?>">
        <input type="submit" value="Buscar">
    </form>
        <br>
    <form action="" method="GET">
        <label for="searchIdPeticion">Buscar por ID Peticion:</label>
        <input type="text" name="searchIdPeticion" id="searchIdPeticion" value="<?= $searchIdPeticion ?>">
        <input type="submit" value="Buscar">
    </form>
    <br>  
    </center>
    <table>
        <thead>
        <tr>
            <th>ID Peticion</th>
            <th>Descripción</th>
            <th>Cedula del Cliente</th>
            <th>Fecha</th>
            <th>EstadoPedido</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
    <?php
    while ($row = mysqli_fetch_array($queryPeticiones)) :
        ?>
        <tr>
            <th><?= isset($row['IdPeticion']) ? $row['IdPeticion'] : 'N/A'; ?></th>
            <th><?= isset($row['Descripcion']) ? $row['Descripcion'] : 'N/A'; ?></th>
            <th><?= isset($row['CedulaCliente']) ? $row['CedulaCliente'] : 'N/A'; ?></th>
            <th><?= isset($row['FechaPedido']) ? $row['FechaPedido'] : 'N/A'; ?></th>
            <th><?= isset($row['EstadoPedido']) ? $row['EstadoPedido'] : 'N/A'; ?></th>
            <th><a href="update_peticion.php?IdPeticion=<?= isset($row['IdPeticion']) ? $row['IdPeticion'] : ''; ?>" class="users-table--edit">Editar</a></th>
            <th><a href="delete_peticion.php?IdPeticion=<?= isset($row['IdPeticion']) ? $row['IdPeticion'] : ''; ?>" class="users-table--delete"><img src="../img/trash.png" alt=""></a></th>
        </tr>
    <?php
    endwhile;
    ?>
</tbody>
    </table>
    
</div>
</body>
</html>
