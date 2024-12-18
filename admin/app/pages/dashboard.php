<?php
// Verificar si la sesión ya está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ruta ajustada al archivo userService.php
require_once __DIR__ . '/../../api/userService.php';

// Verificar si el usuario tiene acceso a esta página
$userService = new UserService();

try {
    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
        throw new Exception("Usuario no autenticado");
    }

    $userData = $userService->getUserById($userId);
    $userRole = $userData['rol'] ?? null;

    // Validar que el usuario tenga rol de admin o superadmin
    if ($userRole !== 'admin' && $userRole !== 'superadmin') {
        header('Location: ../index.php');
        exit;
    }
} catch (Exception $e) {
    error_log("Error al validar usuario: " . $e->getMessage());
    header('Location: ../index.php');
    exit;
}
?>

<div>
    <main class="flex-1 p-0">
        <!-- Header -->
        <header class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold">Dashboard</h1>
        </header>

        <!-- Dashboard Summary -->
        <section id="dashboard" class="mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-primary rounded-lg p-6">
                    <h3 class="text-sm text-gray-400 mb-2">Total Users</h3>
                    <div class="text-3xl font-bold">15,234</div>
                </div>
                <div class="bg-primary rounded-lg p-6">
                    <h3 class="text-sm text-gray-400 mb-2">Active Bets</h3>
                    <div class="text-3xl font-bold">1,876</div>
                </div>
                <div class="bg-primary rounded-lg p-6">
                    <h3 class="text-sm text-gray-400 mb-2">Total Matches</h3>
                    <div class="text-3xl font-bold">342</div>
                </div>
                <div class="bg-primary rounded-lg p-6">
                    <h3 class="text-sm text-gray-400 mb-2">Revenue (30 days)</h3>
                    <div class="text-3xl font-bold">$89,450</div>
                </div>
            </div>

        </section>

    </main>
</div>