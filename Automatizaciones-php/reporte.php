<?php

function generatePdf() {
    include("../connection/connection.php");
    $con = connection();

    $NombreRol = $_POST['NombreRol'];

    $sqlUsuarios = "SELECT * FROM tblusuarios WHERE Rol LIKE '%$NombreRol%'";
    $queryUsuarios = mysqli_query($con, $sqlUsuarios);

    require "fpdf.php";
    

    $pdf = new FPDF("P", "mm", "letter");
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetFont("Arial", "B", 12);
    $pdf->Cell(190, 5, "Reporte de Usuarios", 0, 1, "C");
    $pdf->SetMargins(10,10,10);

    $pdf->SetFont("Arial", "B", 10);
    $pdf->Cell(370,5,"Fecha: ". date("d/m/Y"), 0, 1, "C");


    $pdf->SetFont("Arial", "B", 10);
    $pdf->Ln(2);
    $pdf->Cell(30, 5, "Cedula", 1, 0, "C");
    $pdf->Cell(40, 5, "Correo", 1, 0, "C");
    $pdf->Cell(40, 5, "Nombre", 1, 0, "C");
    $pdf->Cell(30, 5, "Password", 1, 0, "C");
    $pdf->Cell(30, 5, "Rol", 1, 0, "C");
    $pdf->Cell(30, 5, "Telefono", 1, 1, "C");

    $pdf->SetFont("Arial", "", 9);
    while ($fila = $queryUsuarios->fetch_assoc()) {
        $pdf->Cell(30, 5, $fila['Cedula'], 1, 0, "C");
        $pdf->Cell(40, 5, $fila['Correo'], 1, 0, "C");
        $pdf->Cell(40, 5, $fila['Nombre'], 1, 0, "C");
        $pdf->Cell(30, 5, $fila['Password'], 1, 0, "C");
        $pdf->Cell(30, 5, $fila['Rol'], 1, 0, "C");
        $pdf->Cell(30, 5, $fila['Telefono'], 1, 1, "C");
    }

    $pdf->Output();
}

function generarpdfControl() {
    include("../connection/connection.php");
    $con = connection();

    $pedido = $_POST['estado'];

    $sqlControl = "SELECT * FROM tblcontrol WHERE EstadoPedido LIKE '%$pedido%'";
    $queryresult = mysqli_query($con, $sqlControl);

    require "fpdf.php";

    $pdf = new FPDF("P", "mm", "letter");
    $pdf->AddPage();
    $pdf->SetFont("Arial", "B", 12);
    $pdf->Cell(190, 5, "Reporte de Control", 0, 1, "C");
    $pdf->SetMargins(10,10,10);

    $pdf->SetFont("Arial", "B", 10);
    $pdf->Cell(370,5,"Fecha: ". date("d/m/Y"), 0, 1, "C");

    $pdf->SetFont("Arial", "B", 10);
    $pdf->Ln(2);
    $pdf->Cell(30, 5, "IdControl", 1, 0, "C");
    $pdf->Cell(40, 5, "Cedula.E", 1, 0, "C");
    $pdf->Cell(40, 5, "Fecha", 1, 0, "C");
    $pdf->Cell(30, 5, "Cedula.C", 1, 0, "C");
    $pdf->Cell(30, 5, "Estado", 1, 0, "C");
    $pdf->Cell(30, 5, "Precio", 1, 1, "C");

    $pdf->SetFont("Arial", "", 9);
    while ($fila = $queryresult->fetch_assoc()) {
        $pdf->Cell(30, 5, $fila['IdControl'], 1, 0, "C");
        $pdf->Cell(40, 5, $fila['CedulaEmpleado'], 1, 0, "C");
        $pdf->Cell(40, 5, $fila['Fecha'], 1, 0, "C");
        $pdf->Cell(30, 5, $fila['CedulaCliente'], 1, 0, "C");
        $pdf->Cell(30, 5, $fila['EstadoPedido'], 1, 0, "C");
        $pdf->Cell(30, 5, $fila['PrecioBot'], 1, 1, "C");
    }

    $pdf->Output();
}

// Call the function to generate PDF if it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['generatePdfControl'])) {
        generarpdfControl();
    } else {
        generatePdf();
    }
} else {
    // Handle any other request method (optional)
    header("HTTP/1.1 405 Method Not Allowed");
    exit("Method Not Allowed");
}

?>
