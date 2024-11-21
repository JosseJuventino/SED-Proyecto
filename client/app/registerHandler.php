<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Aquí van las validaciones
    $errors = [];
    $errorspasswords = [];

    $nombreUsuario = htmlspecialchars(trim($_POST['nombreUsuario'] ?? ''), ENT_QUOTES, 'UTF-8');
    $apellidoUsuario = htmlspecialchars(trim($_POST['apellidoUsuario'] ?? ''), ENT_QUOTES, 'UTF-8');
    $userName = htmlspecialchars(trim($_POST['userName'] ?? ''), ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars(trim($_POST['email'] ?? ''), ENT_QUOTES, 'UTF-8');
    $password = $_POST['clave'] ?? '';

    if (empty($nombreUsuario) || empty($apellidoUsuario) || empty($userName) || empty($email) || empty($password)) {
        $errors[] = "Todos los campos son obligatorios.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El correo electrónico no es válido.";
    }

    if (!preg_match('/^[a-zA-Z0-9_\-]{3,50}$/', $userName)) {
        $errors[] = "El nombre de usuario solo puede contener letras, números, guiones y guiones bajos.";
    }

    if (strlen($password) < 8) {
        $errorspasswords[] = "La contraseña debe tener al menos 8 caracteres.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errorspasswords[] = "La contraseña debe tener al menos una mayúscula.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errorspasswords[] = "La contraseña debe tener al menos una minúscula.";
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errorspasswords[] = "La contraseña debe tener al menos un número.";
    }
    if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
        $errorspasswords[] = "La contraseña debe tener al menos un caracter especial.";
    }



    // Si hay errores, guardamos los errores y los valores en la sesión y redirigimos
    if (!empty($errors) || !empty($errorspasswords)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['password_errors'] = $errorspasswords;

        $_SESSION['nombreUsuario'] = $_POST['nombreUsuario'];
        $_SESSION['apellidoUsuario'] = $_POST['apellidoUsuario'];
        $_SESSION['userName'] = $_POST['userName'];
        $_SESSION['email'] = $_POST['email'];

        header('Location: register.php');
        exit;
    }
    $postData = [
        'nombreUsuario' => $nombreUsuario,
        'apellidoUsuario' => $apellidoUsuario,
        'userName' => $userName,
        'email' => $email,
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
        $errors[] = "Error en la solicitud.";
        header('Location: register.php');
        exit;
    }

    // Procesar la respuesta de la API
    $responseData = json_decode($response, true);

    if ($httpCode === 200 && isset($responseData['success']) && $responseData['success'] === true) {
        session_start();
        $_SESSION['token'] = $responseData['data']['token'];
        header('Location: ../index.php');
        exit;
    } else {
        $errors[] = "Error al iniciar sesión: " . ($responseData['message'] ?? 'Error desconocido');
        $_SESSION['errors'] = $errors;
        header('Location: register.php');
        exit;
    }
} else {
    header('Location: register.php');
    exit;
}
