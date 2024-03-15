<?php
function connectionbot(){
    $host = "localhost";
    $user = "root";
    $pass = "";
    $bd = "ChatbotRestaurante";


    $connect = mysqli_connect($host, $user, $pass, $bd);


    if (!$connect) {
        die("Error de conexión: " . mysqli_connect_error());
    }


    mysqli_select_db($connect, $bd);


    return $connect;
}


?>
