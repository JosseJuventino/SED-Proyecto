<?php
require __DIR__ . '/vendor/autoload.php';

// Configuración de sesión (debe ir antes de session_start())
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Cambiar a 1 solo si estás usando HTTPS
ini_set('session.use_strict_mode', 1);

// Iniciar la sesión
session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Generar token CSRF si no existe
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Sanitizar URL de la API
$apiBaseUrl = filter_var($_ENV['API_BASE_URL'], FILTER_SANITIZE_URL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BetApp Admin Login</title>
    <link rel="stylesheet" href="./public/css/tailwind.css">
</head>
<body class="bg-background text-foreground flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md">
        <div class="bg-primary rounded-lg shadow-lg p-8">
            <div class="text-3xl font-bold text-center mb-6">BetApp Admin</div>
            <form action="./api/login.php" method="POST">
                <!-- CSRF token -->
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                    <input type="email" id="email" name="email" required
                           class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground focus:outline-none focus:ring-2 focus:ring-success">
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-400 mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground focus:outline-none focus:ring-2 focus:ring-success">
                </div>

                <!-- Submit button -->
                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-success hover:bg-success-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-success-500">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
