<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    $errors = [];   // Array para almacenar los errores
    $username = htmlspecialchars(trim($_POST['username'] ?? ''), ENT_QUOTES, 'UTF-8');
    $password = trim($_POST['password'] ?? '');



    if (empty($username) || empty($password)) {
        $errors[] = "El nombre de usuario y la contraseña son obligatorios.";
    }

    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El correo electrónico no es válido.";
    }


    if (strlen($password) < 7) {
        $errors[] = "La contraseña debe tener al menos 8 caracteres.";
    }


    // Si hay errores, los guardamos en la sesión y redirigimos de vuelta al formulario
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['username'] = $username;  // Mantener el valor del nombre de usuario
        header('Location: ../index.php');  // Redirigir de nuevo al formulario
        exit;
    }



    $postData = [
        'email' => $username,
        'password' => $password,
    ];

    $apiUrl = 'https://proyecto-sed.ironcity.cloud/login'; // Cambiar por la URL de la API
    
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
        header('Location: ./dashboard/page.php');
        exit;
    }
    
    // Procesar la respuesta de la API
    $responseData = json_decode($response, true);

    if ($httpCode === 200 && isset($responseData['token'])) {
        session_start();
        $_SESSION['token'] = $responseData['token'];
        error_log('token: ' . $responseData['token'] . ' - ' . $_COOKIE['token']);
        $_SESSION['user_id'] = $responseData['user']['id'];
        header('Location: ./dashboard/page.php');
        exit;
    } else {
        error_log(print_r($responseData, true));
        $errors[] = "Error al iniciar sesión: " . ($responseData['error'] ?? 'Error desconocido');
        $_SESSION['errors'] = $errors;
        header('Location: ../index.php');
        exit;
    }


} else {
    $_SESSION['error_message'] = "Error al iniciar sesión: " . ($responseData['message'] ?? 'Error desconocido');
    header('Location: ../index.php');
    exit;
}
?>

