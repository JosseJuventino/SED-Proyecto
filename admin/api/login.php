<?php
// Iniciar buffer de salida
ob_start();

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/authService.php';

use Dotenv\Dotenv;

// Configuración de sesión (debe ir antes de session_start())
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', false); // Cambiar a true si usas HTTPS
ini_set('session.use_strict_mode', 1);

// Iniciar sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Archivo de depuración
$logFile = 'debug.log';

// Registrar inicio de ejecución en el archivo de depuración
file_put_contents($logFile, "Inicio del login.php\n", FILE_APPEND);

// Verificar método HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    file_put_contents($logFile, "Método no permitido\n", FILE_APPEND);
    http_response_code(405);
    die("Método no permitido.");
}

// Verificar token CSRF
if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    file_put_contents($logFile, "Token CSRF inválido\n", FILE_APPEND);
    http_response_code(403);
    die("Solicitud inválida (CSRF).");
}

// Sanitizar y validar entradas
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW); // Removí htmlspecialchars()

// Verificar que el email y la contraseña sean válidos
if (!$email || !$password) {
    file_put_contents($logFile, "Email o contraseña no válidos\n", FILE_APPEND);
    http_response_code(400);
    die("Por favor, llena todos los campos correctamente.");
}

// Instanciar AuthService
$userService = new AuthService();

// Enviar credenciales al servicio de autenticación
$response = $userService->login([
    'email' => $email,
    'password' => $password,
]);

file_put_contents($logFile, "Respuesta del servicio: " . print_r($response, true), FILE_APPEND);

if (isset($response['error']) && $response['error']) {
    file_put_contents($logFile, "Error de autenticación: " . $response['message'] . "\n", FILE_APPEND);
    http_response_code(401);
    die("Credenciales inválidas: " . htmlspecialchars($response['message']));
}


if (isset($response['token']) && isset($response['user'])) {
    // Guardar token en una cookie
    setcookie('auth_token', $response['token'], [
        'expires' => time() + 3600,
        'path' => '/',
        'secure' => false, 
        'httponly' => true,
        'samesite' => 'Strict',
    ]);

    // Guardar el token y user_id en la sesión
    $_SESSION['auth_token'] = $response['token'];
    $_SESSION['user_id'] = $response['user']['id'];

    // Depuración
    file_put_contents($logFile, "Token guardado en sesión: " . $_SESSION['auth_token'] . "\n", FILE_APPEND);
    file_put_contents($logFile, "ID del usuario guardado en sesión: " . $_SESSION['user_id'] . "\n", FILE_APPEND);

    // Redirigir al dashboard
    file_put_contents($logFile, "Redirigiendo al dashboard\n", FILE_APPEND);
    header('Location: ../app/page.php?page=dashboard');
    exit;
} else {
    file_put_contents($logFile, "Error: Respuesta inesperada de la API, token o usuario no encontrados.\n", FILE_APPEND);
    http_response_code(401);
    die("Error: La respuesta del servidor es inválida o incompleta.");
}



// Error desconocido al procesar la respuesta
file_put_contents($logFile, "Error desconocido al procesar la respuesta del servidor\n", FILE_APPEND);
http_response_code(500);
die("Error al procesar la respuesta del servidor.");
