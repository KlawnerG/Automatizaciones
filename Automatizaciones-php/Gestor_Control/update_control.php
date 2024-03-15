<?php
include("../connection/connection.php");
$con = connection();

$IdControl = isset($_GET['IdControl']) ? $_GET['IdControl'] : '';

if (empty($IdControl)) {
    echo "ID de control no proporcionado o es inválido.";
    exit();
}


$sqlEmpleados = "SELECT DISTINCT Cedula, Nombre FROM tblusuarios";
$queryEmpleados = mysqli_query($con, $sqlEmpleados);
$empleados = mysqli_fetch_all($queryEmpleados, MYSQLI_ASSOC);

$sqlClientes = "SELECT DISTINCT Cedula, Nombre FROM tblusuarios";
$queryClientes = mysqli_query($con, $sqlClientes);
$clientes = mysqli_fetch_all($queryClientes, MYSQLI_ASSOC);

$sqlPeticiones = "SELECT DISTINCT IdPeticion, EstadoPedido FROM tblpeticiones";
$queryPeticiones = mysqli_query($con, $sqlPeticiones);
$peticiones = mysqli_fetch_all($queryPeticiones, MYSQLI_ASSOC);

$sqlBots = "SELECT DISTINCT IdBot FROM tblautomatizaciones";
$queryBots = mysqli_query($con, $sqlBots);
$bots = mysqli_fetch_all($queryBots, MYSQLI_ASSOC);

$sqlcontrol_Idbot = "SELECT DISTINCT IdBot FROM tblcontrol";
$queryIdbots = mysqli_query($con, $sqlcontrol_Idbot);
$Idbot = mysqli_fetch_all($queryIdbots, MYSQLI_ASSOC);


$sql = "SELECT * FROM tblcontrol WHERE IdControl='$IdControl'";
$query = mysqli_query($con, $sql);

if (!$query || mysqli_num_rows($query) === 0) {
    echo "No se encontraron datos para el ID de control proporcionado.";
    exit();
}

$row = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar control</title>
    <link rel="stylesheet" href="../Gestor_bots/estilobots.css">
</head>

<body>
    <div class="control-form">
        <form action="edit_control.php" method="POST">
            <input type="hidden" name="IdControl" value="<?= $row['IdControl'] ?? '' ?>">

            <label for="CedulaEmpleado">Cédula del Empleado:</label>
            <input type="text" name="CedulaEmpleado" placeholder="Cédula del Empleado"
                value="<?= $row['CedulaEmpleado'] ?? '' ?>"><br>

            <label for="Fecha">Fecha:</label>
            <input type="date" name="Fecha" placeholder="Fecha" value="<?= $row['Fecha'] ?? '' ?>"><br>

            <label for="CedulaCliente">Cédula del Cliente:</label>
            <input type="text" name="CedulaCliente" placeholder="Cédula del Cliente"
                value="<?= $row['CedulaCliente'] ?? '' ?>"><br>

            <label for="EstadoPeticion">Estado de Peticion</label>
            <select name="EstadoPedido" id="EstadoPedido">
                <option value="Completado">Completado</option>
                <option value="Cancelado">Cancelado</option>
                <option value="En proceso">En proceso</option>
            </select>

            <label for="IdPeticion">ID de la Petición:</label>
            <select name="IdPeticion" placeholder="ID de la Petición">
                <?php
                foreach ($peticiones as $peticionOption) {
                    $selected = ($peticionOption['IdPeticion'] == $row['IdPeticion']) ? 'selected' : '';
                    echo "<option value='" . $peticionOption['IdPeticion'] . "' $selected>" . $peticionOption['IdPeticion'] . "</option>";
                }
                ?>
            </select><br>

            <label for="IdBot">ID del Bot:</label>
            <select name="IdBot" placeholder="ID del Bot">
                <?php
                foreach ($bots as $botOption) {
                    $selected = ($botOption['IdBot'] == $row['IdBot']) ? 'selected' : '';
                    echo "<option value='" . $botOption['IdBot'] . "' $selected>" . $botOption['IdBot'] . "</option>";
                }
                ?>
            </select><br>

            <label for="precioBot">Precio del Bot:</label>
            <input type="text" name="PrecioBot" placeholder="Precio del Bot" value="<?= $row['PrecioBot'] ?? '' ?>"><br>
            <center>
                <input type="submit" value="Actualizar">
                <button type="reset" value="cancelar" onclick='redireccion()'>Eliminar</button>

                <script>
                function redireccion() {
                    window.location.href = "Control.php";
                }
                </script>
            </center>
        </form>
    </div>
</body>

</html>