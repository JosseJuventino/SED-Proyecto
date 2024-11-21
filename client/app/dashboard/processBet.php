<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    // Capturar y validar datos
    $errors = [];
    $predictionLocal = filter_input(INPUT_POST, 'predictionLocal', FILTER_VALIDATE_INT);
    $predictionVisitante = filter_input(INPUT_POST, 'predictionVisitante', FILTER_VALIDATE_INT);
    $betQuantity = filter_input(INPUT_POST, 'betQuantity', FILTER_VALIDATE_INT);

    // Verificar que todos los campos estén presentes y sean válidos
    error_log("predictionLocal: $predictionLocal, predictionVisitante: $predictionVisitante, betQuantity: $betQuantity", 0);
    if ($predictionLocal === false || $predictionVisitante === false || $betQuantity === false) {
        $errors[] = "Todos los campos son obligatorios.";
    }

    // Validar que los valores sean positivos
    if ($predictionLocal < 0 || $predictionVisitante < 0 || $betQuantity < 0) {
        $errors[] = "Los valores deben ser positivos.";
    }
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        // Mostrar el log de los errores
        foreach ($errors as $error) {
            //Quiero ver en los logs
            error_log($error, 0);
        }
        header('Location: page.php');
        exit;
    }
    // Sanitizar contra XSS (aunque los datos ya están limpios al llegar aquí)
    $predictionLocal = htmlspecialchars($predictionLocal, ENT_QUOTES, 'UTF-8');
    $predictionVisitante = htmlspecialchars($predictionVisitante, ENT_QUOTES, 'UTF-8');
    $betQuantity = htmlspecialchars($betQuantity, ENT_QUOTES, 'UTF-8');

    $postData = [
        'predictionLocal' => $predictionLocal,
        'predictionVisitante' => $predictionVisitante,
        'betQuantity' => $betQuantity,
    ];

    $apiUrl = 'https://url-de-la-api/api/login'; // Cambiar por la URL de la API

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
        session_start();
        header('Location: page.php');
        exit;
    } else {
        $errors[] = "Error al iniciar sesión: " . ($responseData['message'] ?? 'Error desconocido');
        $_SESSION['errors'] = $errors;
        header('Location: page.php');
        exit;
    }
} else {
    // Si el archivo se accede directamente sin enviar datos
    header('Location: /'); // Redirigir al inicio u otra página
    exit;
}
