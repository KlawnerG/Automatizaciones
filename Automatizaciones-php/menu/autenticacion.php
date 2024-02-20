<?php
try {
    $base = new PDO("mysql:host=localhost;dbname=automatizaciones", "root", "");
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM tblusuarios WHERE Cedula = :login AND PASSWORD = :password";
    $resultado = $base->prepare($sql);

    $login = htmlentities(addslashes($_POST["login"]));
    $password = htmlentities(addslashes($_POST["password"]));
    $resultado->bindValue(":login", $login);
    $resultado->bindValue(":password", $password);
    $resultado->execute();
    $usuario = $resultado->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Recupera el rol del usuario
        $rol = $usuario['Rol'];

        if ($rol == "Cliente") {
            header("location: menu.html");
            exit();
        } else {
            session_start();
            $_SESSION["usuario"] = $_POST["login"];
            header("location: menuadmin.php");
            exit();
        }
    } else {
        header("Location: login.html");
        exit();
    }
} catch (\Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
