<?php
ob_start();
session_start();
require_once __DIR__ . '/../api/authService.php';
require_once __DIR__ . '/../api/userService.php';

// Verificar si el token está presente en la sesión
if (!isset($_SESSION['auth_token'])) {
    error_log("Token no encontrado en sesión. Redirigiendo al login.");
    session_destroy();
    header('Location: ../index.php');
    exit;
}

$userService = new UserService();
$authToken = $_SESSION['auth_token'];

try {
    // Verificar el token con el servicio de autenticación
    $authResponse = (new AuthService())->verifyToken(['token' => $authToken]);
    if (isset($authResponse['error']) && $authResponse['error']) {
        error_log("Token inválido o expirado. Redirigiendo al login.");
        session_destroy();
        header('Location: ../index.php');
        exit;
    }

    // Obtener los datos del usuario a partir de su ID
    $userId = $_SESSION['user_id'];
    $userData = $userService->getUserById($userId);
    $userRole = $userData['rol'] ?? null; // Suponiendo que el rol está en el campo 'rol'

    // Validar el rol
    if ($userRole !== 'admin' && $userRole !== 'superadmin') {
        error_log("Acceso denegado para el usuario con rol: $userRole. Redirigiendo.");
        session_destroy();
        header('Location: ../index.php');
        exit;
    }

} catch (Exception $e) {
    error_log("Error al procesar la autenticación: " . $e->getMessage());
    session_destroy();
    header('Location: ../index.php');
    exit;
}

// Configuración de páginas y rutas
$pages = [
    'dashboard' => 'pages/dashboard.php',
    'matches'   => 'pages/matches.php',
    'users'     => 'pages/users.php',
    'teams'     => 'pages/teams.php',
    'bets'      => 'pages/bets.php',
    '404'       => 'pages/404.php'
];

// Validar la página solicitada
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$currentPage = $page && array_key_exists($page, $pages) ? $page : '404';

$pageToInclude = array_key_exists($currentPage, $pages) && file_exists($pages[$currentPage])
    ? $pages[$currentPage]
    : $pages['404'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $currentPage === '404' ? '404 Not Found' : 'BetApp Admin'; ?></title>
    <link rel="stylesheet" href="../public/css/tailwind.css">
</head>
<body class="bg-background text-foreground">
    <?php if ($currentPage === '404'): ?>
        <?php include './pages/404.php'; ?>
    <?php else: ?>
        <div class="flex min-h-screen">
            <?php include '../components/Sidebar.php'; ?>

            <main class="flex-1 p-8">
                <?php include $pageToInclude; ?>
            </main>
        </div>
    <?php endif; ?>
</body>
</html>
