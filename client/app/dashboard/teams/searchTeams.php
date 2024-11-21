<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $errors = [];
    // Capturar el término de búsqueda
    $rawSearchTerm = $_POST['searchTerm'] ?? '';

    // Verificar si está vacío
    if (empty($rawSearchTerm)) {
        $errors[] = "El término de búsqueda no puede estar vacío.";
    }

    // Sanitizar contra XSS
    $sanitizedSearchTerm = filter_var($rawSearchTerm, FILTER_SANITIZE_SPECIAL_CHARS);

    // Validar longitud o formato si aplica
    if (strlen($sanitizedSearchTerm) > 255) {
        $errors[] = "El término de búsqueda no puede tener más de 255 caracteres.";
    }

    // Escapar la salida para prevenir XSS
    error_log(
        "Search term: $sanitizedSearchTerm",
    );

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: page.php');
        exit;
    }

    $postData = [
        'searchTerm' => $sanitizedSearchTerm,
    ];

    $apiUrl = 'https://url-de-la-api/api/buscador'; // Cambiar por la URL de la API

    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n" .
                "Accept: application/json\r\n",
            'content' => json_encode($postData),
            'ignore_errors' => true, // Permite capturar errores HTTP
        ],
    ];

    // Crear un contexto de flujo
    $context = stream_context_create($options);

    // Realizar la solicitud con file_get_contents
    $response = file_get_contents($apiUrl, false, $context);

    // Obtener el código de respuesta HTTP
    $httpCode = null;
    if (isset($http_response_header)) {
        foreach ($http_response_header as $header) {
            if (preg_match('#^HTTP/\d+\.\d+\s+(\d+)#', $header, $matches)) {
                $httpCode = intval($matches[1]);
                break;
            }
        }
    }

    // Verificar si la solicitud fue exitosa
    if ($response === false) {
        echo "Error en la solicitud.";
        header('Location: page.php');
        exit;
    }

    // Procesar la respuesta de la API
    $responseData = json_decode($response, true);

    if ($httpCode === 200 && isset($responseData['success']) && $responseData['success'] === true) {
        header('Location: page.php');
        exit;
    } else {
        $errors[] = "Error al iniciar sesión: " . ($responseData['message'] ?? 'Error desconocido');
        $_SESSION['errors'] = $errors;
        header('Location: page.php');
        exit;
    }
} else {
    // Si no es una solicitud POST, redirigir o mostrar un mensaje de error
    header('HTTP/1.1 405 Method Not Allowed');
    echo "Método no permitido.";
    exit;
}
