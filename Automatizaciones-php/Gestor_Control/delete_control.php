<?php
include("../connection/connection.php");
$con = connection();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['IdControl'])) {
    // Get the ID of the record to be deleted
    $idControl = mysqli_real_escape_string($con, $_GET['IdControl']);

    // Delete data from tblControl
    $sqlDelete = "DELETE FROM tblControl WHERE IdControl='$idControl'";

    if (mysqli_query($con, $sqlDelete)) {
        header("Location: control.php");
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>
