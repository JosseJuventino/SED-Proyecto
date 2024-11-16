<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = htmlspecialchars(trim($_POST['username'] ?? ''), ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars(trim($_POST['password'] ?? ''), ENT_QUOTES, 'UTF-8');



    if (empty($username) || empty($password)) {
        die("Por favor, completa todos los campos.");
    }

    if (!preg_match('/^[a-zA-Z0-9_\-]{3,50}$/', $username)) {
        die("El nombre de usuario debe contener solo letras, números, guiones y tener entre 3 y 50 caracteres.");
    }

    if (strlen($password) < 8) {
        die("La contraseña debe tener al menos 8 caracteres.");
    }


    $postData = [
        'username' => $username,
        'password' => $password,
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
        header('Location: ../index.php');
        exit;
    }
    
    // Procesar la respuesta de la API
    $responseData = json_decode($response, true);

    if ($httpCode === 200 && isset($responseData['success']) && $responseData['success'] === true) {
        session_start();
        $_SESSION['token'] = $responseData['data']['token'];
        header('Location: ./dashboard/page.php');
        exit;
    } else {
        echo "Error al iniciar sesión: " . ($responseData['message'] ?? 'Error desconocido');
    }


} else {
    header('Location: ../index.php');
    exit;
}
?>

