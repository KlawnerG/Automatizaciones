<?php
include("../connection/connection.php");
$con = connection();

$sqlCedulas = "SELECT DISTINCT Cedula FROM tblusuarios WHERE Rol IN ('Administrador', 'Tester', 'Secretaria', 'Soporte')";
$queryCedulas = mysqli_query($con, $sqlCedulas);

$sqlCedula_cliente = "SELECT Cedula FROM tblusuarios WHERE Rol = 'Cliente'";
$queryCedula_cliente = mysqli_query($con, $sqlCedula_cliente);

$sqlEmpleados = "SELECT DISTINCT Cedula, Nombre FROM tblusuarios";
$queryEmpleados = mysqli_query($con, $sqlEmpleados);
$empleados = mysqli_fetch_all($queryEmpleados, MYSQLI_ASSOC);

$sqlPeticiones = "SELECT DISTINCT IdPeticion, Descripcion FROM tblpeticiones";
$queryPeticiones = mysqli_query($con, $sqlPeticiones);
$peticiones = mysqli_fetch_all($queryPeticiones, MYSQLI_ASSOC);

// Crear un array asociativo para mapear los IDs de petición a sus descripciones
$peticiones_map = array();
foreach ($peticiones as $peticion) {
    $peticiones_map[$peticion['IdPeticion']] = $peticion['Descripcion'];
}

$sqlBots = "SELECT DISTINCT IdBot, Nombre FROM tblautomatizaciones";
$queryBots = mysqli_query($con, $sqlBots);
$bots = mysqli_fetch_all($queryBots, MYSQLI_ASSOC);

$bots_map = array();
foreach ($bots as $automatizacion) {
    $bots_map[$automatizacion['IdBot']] = $automatizacion['Nombre'];
}



$sqlcontrol_Idbot = "SELECT DISTINCT Idbot FROM tblcontrol";
$queryIdbots = mysqli_query($con, $sqlcontrol_Idbot);
$Idbot = mysqli_fetch_all($queryIdbots, MYSQLI_ASSOC);

$searchCedulaEmpleado = isset($_GET['searchCedulaEmpleado']) ? $_GET['searchCedulaEmpleado'] : '';
$searchFecha = isset($_GET['searchFecha']) ? $_GET['searchFecha'] : '';
$searchCedulaCliente = isset($_GET['searchCedulaCliente']) ? $_GET['searchCedulaCliente'] : '';
$searchEstadoPedido = isset($_GET['searchEstadoPedido']) ? $_GET['searchEstadoPedido'] : '';


$sqlControles = "SELECT IdBot, IdControl, CedulaEmpleado, Fecha, CedulaCliente, IdPeticion, EstadoPedido, PrecioBot FROM tblcontrol";

if (!empty($searchCedulaEmpleado)) {
    $sqlControles .= " WHERE CedulaEmpleado LIKE '%$searchCedulaEmpleado%'";
}

if (!empty($searchFecha)) {
    $sqlControles .= (strpos($sqlControles, 'WHERE') !== false) ? " AND Fecha LIKE '%$searchFecha%'" : " WHERE Fecha LIKE '%$searchFecha%'";
}

if (!empty($searchCedulaCliente)) {
    $sqlControles .= (strpos($sqlControles, 'WHERE') !== false) ? " AND CedulaCliente LIKE '%$searchCedulaCliente%'" : " WHERE CedulaCliente LIKE '%$searchCedulaCliente%'";
}

if (!empty($searchEstadoPedido)) {
    $sqlControles .= (strpos($sqlControles, 'WHERE') !== false) ? " AND EstadoPedido = '$searchEstadoPedido'" : " WHERE EstadoPedido = '$searchEstadoPedido'";
}

$queryControles = mysqli_query($con, $sqlControles);
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
    <title>Controles Crud</title>
    <link rel="stylesheet" href="control.css">
    <link rel="stylesheet" href="../Gestor_Usuarios/estilomenu.css">
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

    <div class="controles-form">
        <h2>Registrar control</h2>
        <form action="insert_control.php" method="POST">
            <input type="text" name="CedulaEmpleado" placeholder="Cedula del Empleado" required>
            <input type="text" name="CedulaCliente" placeholder="Cedula del Cliente" required>
            <select name="EstadoPedido" id="EstadoPedido" placeholder="Estado de pedido" required>
                <option value="">Todos</option>
                <option value="En proceso">En proceso</option>
                <option value="Completado">Completado</option>
                <option value="Cancelado">Cancelado</option>
            </select>

            <h4>IdPeticion</h4>
            <select name="IdPeticion" placeholder="ID de la Petición" required>
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
            <input type="text" name="PrecioBot" placeholder="Precio del Bot" required>
            <input type="submit" value="Agregar control">
            <input type="reset" value="Eliminar">
        </form>
    </div>

    <div class="controles-table">
        <h2>Controles Registrados</h2>
        <center>
            <form action="" method="GET">
                <label for="searchCedulaEmpleado">Seleccionar Cedula de Empleado:</label>
                <select name="searchCedulaEmpleado" id="searchCedulaEmpleado">
                    <option value="">Seleccionar Cedula</option>
                    <?php
            while ($row = mysqli_fetch_array($queryCedulas)) :
            ?>
                    <option value="<?= isset($row['Cedula']) ? $row['Cedula'] : ''; ?>">
                        <?= isset($row['Cedula']) ? $row['Cedula'] : 'N/A'; ?></option>
                    <?php
            endwhile;
            ?>
                </select><br><br>
                <label for="searchFecha">Buscar por Fecha:</label>
                <input type="date" name="searchFecha" id="searchFecha" value="<?= $searchFecha ?>"><br><br>


                <label for="searchCedulaCliente">Seleccionar Cedula de Cliente:</label>
                <select name="searchCedulaCliente" id="searchCedulaCliente">
                    <option value="">Seleccionar Cedula</option>
                    <?php
            while ($row = mysqli_fetch_array($queryCedula_cliente)) :
            ?>
                    <option value="<?= isset($row['Cedula']) ? $row['Cedula'] : ''; ?>">
                        <?= isset($row['Cedula']) ? $row['Cedula'] : 'N/A'; ?></option>
                    <?php
            endwhile;
            ?>
                </select>
                    
                    
                    <br><br>
                <label for="searchEstadoPedido">Buscar por Estado de Pedido:</label>
                <select name="searchEstadoPedido" id="searchEstadoPedido">
                    <option value="">Todos</option>
                    <option value="En proceso">En proceso</option>
                    <option value="Completado">Completado</option>
                    <option value="Cancelado">Cancelado</option>
                </select><br><br>

                <input type="submit" value="Buscar">
            </form>
        </center>
        <br><br>
        <table>
            <thead>
                <tr>
                    <th>ID de Control</th>
                    <th>Nombre Bot</th>
                    <th>Cedula del Empleado</th>
                    <th>Fecha</th>
                    <th>Cedula del Cliente</th>
                    <th>Peticiónes</th> 
                    <th>Estado de la Petición</th> 
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
                    <th><?= isset($bots_map[$row['IdBot']]) ? $bots_map[$row['IdBot']] : 'N/A'; ?></th>
                    <th><?= isset($row['CedulaEmpleado']) ? $row['CedulaEmpleado'] : 'N/A'; ?></th>
                    <th><?= isset($row['Fecha']) ? $row['Fecha'] : 'N/A'; ?></th>
                    <th><?= isset($row['CedulaCliente']) ? $row['CedulaCliente'] : 'N/A'; ?></th>
                    <th><?= isset($peticiones_map[$row['IdPeticion']]) ? $peticiones_map[$row['IdPeticion']] : 'N/A'; ?></th> 
                    <th><?= isset($row['EstadoPedido']) ? $row['EstadoPedido'] : 'N/A'; ?></th>
                    <th><?= isset($row['PrecioBot']) ? $row['PrecioBot'] : 'N/A'; ?></th>
                    <th><a href="update_control.php?IdControl=<?= isset($row['IdControl']) ? $row['IdControl'] : ''; ?>"
                            class="controles-table--edit">Editar</a></th>
                    <th><a href="delete_control.php?IdControl=<?= isset($row['IdControl']) ? $row['IdControl'] : ''; ?>"
                            class="controles-table--delete"><img src="../img/trash.png" alt=""></a></th>
                </tr>
                <?php
        endwhile;
        ?>
            </tbody>
            <form id="generarpdfControl" action="../pdf/reporte.php" method="post">
                <input type="hidden" name="generatePdfControl" value="1">
                <label for="">Estado Del Pedido: </label>
                <input type="text" name="estado"><br><br>
                <button type="submit" class="generate-pdf-btn">Generar PDF de Control</button>
            </form>
            <br><br>

        </table>
    </div>
</body>

</html>
