<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ChatbotRestaurante1";
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre_negocio = $_POST['nombre_negocio'];
$saludo = $_POST['saludo'];
$despedida = $_POST['despedida'];
$contacto = $_POST['contacto'];

// Insertar los datos en la tabla tblRestaurantes
$sql = "INSERT INTO tblRestaurantes (NombreNegocio, Saludo, Despedida, Contacto) VALUES ('$nombre_negocio', '$saludo', '$despedida', '$contacto')";
if ($conn->query($sql) === TRUE) {
    echo "Datos del restaurante insertados correctamente.<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Obtener los datos de los productos
$nombre_producto = $_POST['nombre_producto'];
$descripcion_producto = $_POST['descripcion_producto'];
$precio = $_POST['precio'];

// Insertar los productos en la tabla tblMenu
for ($i = 0; $i < count($nombre_producto); $i++) {
    $sql = "INSERT INTO tblMenu (NombreProducto, DescripcionProducto, Precio) VALUES ('$nombre_producto[$i]', '$descripcion_producto[$i]', '$precio[$i]')";
    if ($conn->query($sql) === TRUE) {
        echo "Producto insertado correctamente.<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function generarScript($nombre_negocio, $saludo, $despedida, $contacto, $nombre_producto, $descripcion_producto, $precio) {
    $script = "// Información del restaurante\n";
    $script .= "const nombreNegocio = '$nombre_negocio';\n";
    $script .= "const saludo = '$saludo';\n";
    $script .= "const despedida = '$despedida';\n";
    $script .= "const contacto = '$contacto';\n\n";
    $script .= "// Menú\n";
    $script .= "const menu = [\n";
    for ($i = 0; $i < count($nombre_producto); $i++) {
        $script .= " {\n";
        $script .= " nombre: '$nombre_producto[$i]',\n";
        $script .= " descripcion: '$descripcion_producto[$i]',\n";
        $script .= " precio: $precio[$i]\n";
        $script .= " },\n";
    }
    $script .= "];\n";
    return $script;
}

// Generar el script
$script = generarScript($nombre_negocio, $saludo, $despedida, $contacto, $nombre_producto, $descripcion_producto, $precio);

// Crear un archivo ZIP que contenga los scripts y la carpeta
$zipFile = 'botrestaurantepersonalizado.zip';
$zip = new ZipArchive();
if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    // Agregar el script al archivo ZIP
    $zip->addFromString('script.js', $script);

    // Agregar la carpeta al archivo ZIP
    $dir = 'botrestaurantepersonalizado';
    if (is_dir($dir)) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
        foreach ($iterator as $file) {
            if (!$file->isDir()) {
                $zipPath = 'botrestaurantepersonalizado/' . $iterator->getSubPathName();
                $zip->addFile(realpath($file), $zipPath);
            }
        }
    }

    $zip->close();

    // Enviar el archivo ZIP al navegador para descargarlo
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $zipFile . '"');
    header('Content-Length: ' . filesize($zipFile));
    readfile($zipFile);
    exit();
} else {
    echo 'Error al crear el archivo ZIP.';
}

$conn->close();
?>