<?php
include("../connection/connection.php");
$con = connection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = mysqli_real_escape_string($con, $_POST['cedula']);
    $correo = mysqli_real_escape_string($con, $_POST['correo']);
    $nombre = mysqli_real_escape_string($con, $_POST['Nombre']);
    $Password = mysqli_real_escape_string($con, $_POST['Password']);
    $rol = 'Cliente'; // Rol específico para usuarios
    $telefono = isset($_POST['telefono']) ? mysqli_real_escape_string($con, $_POST['telefono']) : '';

    // Verifica si el rol 'Usuario' existe en tblroles
    $checkRolQuery = "SELECT Nombre FROM tblroles WHERE Nombre = '$rol'";
    $checkRolResult = mysqli_query($con, $checkRolQuery);

    if (mysqli_num_rows($checkRolResult) == 0) {
        // El rol 'Usuario' no existe en tblroles, intenta agregarlo
        $insertRolQuery = "INSERT INTO tblroles (Nombre) VALUES ('$rol')";
        $insertRolResult = mysqli_query($con, $insertRolQuery);

        if (!$insertRolResult) {
            // Hubo un error al intentar insertar el rol 'Usuario'
            echo "Error al insertar el rol 'Cliente' en la tabla tblroles: " . mysqli_error($con);
            exit;
        }
    }

    // Ahora, intenta realizar la inserción en tblusuarios
    $sql = "INSERT INTO tblusuarios (cedula, correo, Nombre, Password, Rol, telefono) VALUES ('$cedula', '$correo', '$nombre', '$Password', '$rol', '$telefono')";
    
    // Verifica si la cédula ya existe antes de intentar insertar
    $checkCedulaQuery = "SELECT Cedula FROM tblusuarios WHERE Cedula = '$cedula'";
    $checkCedulaResult = mysqli_query($con, $checkCedulaQuery);

    if (mysqli_num_rows($checkCedulaResult) == 0) {
        // La cédula no existe, procede con la inserción
        $query = mysqli_query($con, $sql);

        if ($query) {
            // Éxito al insertar el usuario
            echo '<script>alert("Ya puedes hacer tus peticiones o calificarnos, Bienvenido"); window.location.href = "menu.html";</script>';
        } else {
            // Hubo un error al intentar insertar el usuario
            echo "Error al insertar el usuario: " . mysqli_error($con);
        }
    } else {
        // La cédula ya existe, muestra un mensaje de error
        echo '<script>alert("El numero de identificacion ya esta registrado en nuestro sistema, te invitamos a que inicies sesion"); window.location.href = "registro.php";</script>';
    }
}
?>
