<?php
// Descargar el código del chatbot personalizado

session_start();
$customChatbotData = isset($_SESSION['custom_chatbot_data']) ? $_SESSION['custom_chatbot_data'] : null;

if ($customChatbotData) {
    // Construir el código del chatbot personalizado
    $code = '<!DOCTYPE html>' . "\n";
    $code .= '<html lang="es">' . "\n";
    $code .= '<head>' . "\n";
    $code .= '    <meta charset="UTF-8">' . "\n";
    $code .= '    <title>Chatbot Personalizado</title>' . "\n";
    $code .= '</head>' . "\n";
    $code .= '<body>' . "\n";
    $code .= '    <h1>Chatbot Personalizado</h1>' . "\n";
    $code .= '    <p>' . $customChatbotData['welcome_message'] . '</p>' . "\n";
    $code .= '    <ul>' . "\n";
    foreach ($customChatbotData['menu_items'] as $menuItem) {
        $code .= '        <li>' . $menuItem['name'] . ' - $' . $menuItem['price'] . '</li>' . "\n";
    }
    $code .= '    </ul>' . "\n";
    $code .= '</body>' . "\n";
    $code .= '</html>';

    // Descargar el código como un archivo HTML
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=chatbot_personalizado.html');
    echo $code;
    exit;
} else {
    // Si no hay datos personalizados, redirigir a personalizar.php
    header('Location: personalizar.php');
    exit;
}
?>
