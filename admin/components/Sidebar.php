<?php
require_once __DIR__ . '/../api/userService.php'; 

if (isset($_SESSION['auth_token']) && isset($_SESSION['user_id'])) {
    try {
        // Instanciar el servicio de usuario
        $userService = new UserService();

        // Usar el user_id de la sesión para obtener los datos del usuario
        $userData = $userService->getUserById($_SESSION['user_id']); 

        // Asignar el nombre del usuario directamente
        $userName = $userData['nombreusuario'] ?? "Usuario no encontrado"; // Usar operador null-coalescing
        $userRole = $userData['rol'] ?? null; // Asumimos que el rol se guarda en 'rol'

    } catch (Exception $e) {
        $userName = "Error al cargar usuario";
        $userRole = null;
    }
} else {
    $userName = "No autenticado";
    $userRole = null;
}

// Solo mostrar el panel si el usuario es admin o superadmin
if ($userRole !== 'admin' && $userRole !== 'superadmin') {
    header('Location: ../index.php'); // Redirigir a otra página si no tiene acceso
    exit();
}
?>

<aside class="w-64 bg-primary p-6 border-r border-accent">
    <div class="text-2xl font-bold mb-8">BetApp Admin</div>
    <div class="text-lg mb-4">Bienvenido, <?php echo $userName; ?></div>
    <nav>
        <a href="?page=dashboard" class="block py-2 px-4 rounded hover:bg-secondary mb-2 <?php echo ($currentPage == 'dashboard') ? 'bg-secondary' : ''; ?>">Dashboard</a>
        <a href="?page=matches" class="block py-2 px-4 rounded hover:bg-secondary mb-2 <?php echo ($currentPage == 'matches') ? 'bg-secondary' : ''; ?>">Matches</a>
        
        <?php if ($userRole === 'superadmin') : ?>
            <a href="?page=teams" class="block py-2 px-4 rounded hover:bg-secondary mb-2 <?php echo ($currentPage == 'teams') ? 'bg-secondary' : ''; ?>">Teams</a>
            <a href="?page=users" class="block py-2 px-4 rounded hover:bg-secondary mb-2 <?php echo ($currentPage == 'users') ? 'bg-secondary' : ''; ?>">Users</a>
            <a href="?page=bets" class="block py-2 px-4 rounded hover:bg-secondary mb-2 <?php echo ($currentPage == 'bets') ? 'bg-secondary' : ''; ?>">Bets</a>
        <?php endif; ?>
        
        
    </nav>
</aside>