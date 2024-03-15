<?php
include("../connection/connection.php");
$con = connection();

// Verifica si se recibieron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos del formulario
    $calificacion = $_POST["calificacion"];
    $comentarios = $_POST["comentarios"];
    $cedulaCliente = $_POST["cedulaCliente"];
    $idBot = $_POST["idBot"];

    // Verificar si el cliente existe en la tabla de usuarios y tiene el rol "Cliente"
    $sql_verifys = "SELECT Cedula FROM tblusuarios WHERE Cedula = '$cedulaCliente' AND Rol = 'Cliente'";
    $result_verifys = mysqli_query($con, $sql_verifys);
    $sql_verify = "SELECT Cedula FROM tblusuarios WHERE Cedula = '$cedulaEmpleado' AND Rol != 'Cliente'";
    $result_verify = mysqli_query($con, $sql_verify);



    if (mysqli_num_rows($result_verifys) == 0) {
        echo '<script>alert("El Cliente no existe en la base de datos, verifica los datos."); window.location.href = "Calificacion.php";</script>';
        exit();
    }

    // Inserta los datos en la base de datos
    $sql = "INSERT INTO tblCalificacionBot (CedulaCliente, idBot, fecha, Calificacion, Comentarios) VALUES ('$cedulaCliente', '$idBot', NOW(), '$calificacion', '$comentarios')";

    // Verificar si el cliente existe en la tabla de usuarios
    $sql_verify = "SELECT Cedula FROM tblusuarios WHERE Cedula = '$cedulaCliente'";
    $result_verify = mysqli_query($con, $sql_verify);

    if (mysqli_num_rows($result_verify) == 0) {       
        echo '<script>
        if (confirm("La cédula ingresada no coincide con ningún registro. ¿Deseas corregirla o registrarte como nuevo usuario?")) {
            window.location.href = "calificacion.php";
        } else {
            // Si el usuario cancela, puedes realizar alguna otra acción o no hacer nada
            window.location.href = "registro.php";
        }
        </script>';


        exit();
    }
    $sql_verify = "SELECT idBot FROM tblautomatizaciones WHERE idBot = '$idBot'";
    $result_verify = mysqli_query($con, $sql_verify);

    if (mysqli_num_rows($result_verify) == 0) {
        echo '<script>alert("El bot no está registrado. Por favor verifique si Id.");</script>';
        exit();
    }


    if ($con->query($sql) === TRUE) {
        // Muestra la alerta y redirecciona a menu.html
        echo '<script>alert("Calificación registrada con éxito dale aceptar para ir al menu"); window.location.href = "index.html";</script>';
    } else {
        echo "Error al enviar la calificación: " . $con->error;
        
    }

    

    // Cierra la conexión
    $con->close();
}
?>