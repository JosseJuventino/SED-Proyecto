<?php
// Incluir dependencias necesarias
require_once __DIR__ . '/../../api/equiposService.php';

// Iniciar sesión si aún no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar que el usuario está logueado
if (!isset($_COOKIE['auth_token']) || !isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

// Instanciar el servicio de equipos
$apiUrl = getenv('API_BASE_URL') ?: ($_ENV['API_BASE_URL'] ?? null);
$userId = $_SESSION['user_id'];
$equipoService = new EquipoService($apiUrl, $userId);

// Archivo de log para depuración
$logFile = __DIR__ . '/../../error.log';

// Manejar acciones del formulario (crear, editar o eliminar equipos)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    try {
        if ($action === 'create') {
            $nombreEquipo = filter_input(INPUT_POST, 'teamName', FILTER_SANITIZE_STRING);
            $representanteEquipo = filter_input(INPUT_POST, 'representative', FILTER_SANITIZE_STRING);
            $equipoService->createEquipo($nombreEquipo, $representanteEquipo);
        } elseif ($action === 'edit') {
            $idEquipo = filter_input(INPUT_POST, 'teamId', FILTER_VALIDATE_INT);
            $nombreEquipo = filter_input(INPUT_POST, 'teamName', FILTER_SANITIZE_STRING);
            $representanteEquipo = filter_input(INPUT_POST, 'representative', FILTER_SANITIZE_STRING);
            $equipoService->updateEquipo($idEquipo, $nombreEquipo, $representanteEquipo);
        } elseif ($action === 'delete') {
            $idEquipo = filter_input(INPUT_POST, 'teamId', FILTER_VALIDATE_INT);
            $equipoService->deleteEquipo($idEquipo);
        }

        // Redirigir para evitar reenvíos del formulario
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
        file_put_contents($logFile, "Error en acción POST: $error\n", FILE_APPEND);
    }
}

// Obtener la lista de equipos
$equipos = [];
try {
    $equipos = $equipoService->getAllEquipos();
    file_put_contents($logFile, "Respuesta de getAllEquipos:\n" . print_r($equipos, true), FILE_APPEND);

    if (!is_array($equipos)) {
        throw new Exception("La API devolvió una respuesta no válida.");
    }
} catch (Exception $e) {
    $equipos = [];
    $error = $e->getMessage();
    file_put_contents($logFile, "Error al obtener equipos: $error\n", FILE_APPEND);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/styles.css">
    <title>Teams Management</title>
</head>
<body>
<main class="flex-1 p-0">
    <header class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold">Teams Management</h1>
        <button id="addTeamBtn" class="px-4 py-2 bg-success text-white rounded-md font-medium">Add New Team</button>
    </header>

    <!-- Mensaje de error -->
    <?php if (isset($error)): ?>
        <div class="bg-danger text-white p-4 rounded-md mb-4">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- Teams Table -->
    <div class="bg-primary rounded-lg overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-secondary">
                    <th class="text-left p-4 font-medium text-gray-400">Team Name</th>
                    <th class="text-left p-4 font-medium text-gray-400">Representative</th>
                    <th class="text-left p-4 font-medium text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody id="teamsTableBody">
    <?php if (!empty($equipos)): ?>
        <?php foreach ($equipos as $equipo): ?>
            <tr>
                <td class="p-4"><?= htmlspecialchars($equipo['nombreequipo'] ?? 'N/A') ?></td>
                <td class="p-4"><?= htmlspecialchars($equipo['representanteequipo'] ?? 'N/A') ?></td>
                <td class="p-4">
                    <button class="edit-btn px-3 py-1 bg-accent text-white rounded-md" 
                        data-id="<?= htmlspecialchars($equipo['idequipo'] ?? '') ?>" 
                        data-name="<?= htmlspecialchars($equipo['nombreequipo'] ?? '') ?>" 
                        data-representative="<?= htmlspecialchars($equipo['representanteequipo'] ?? '') ?>">
                        Edit
                    </button>
                    <button class="delete-btn px-3 py-1 bg-danger text-white rounded-md" 
                        data-id="<?= htmlspecialchars($equipo['idequipo'] ?? '') ?>">
                        Delete
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3" class="p-4 text-center text-gray-400">No teams available</td>
        </tr>
    <?php endif; ?>
</tbody>

        </table>
    </div>
</main>

<!-- JavaScript para acciones de los botones -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addTeamBtn = document.getElementById('addTeamBtn');
        const teamsTableBody = document.getElementById('teamsTableBody');

        // Manejar el botón para agregar un equipo
        addTeamBtn.addEventListener('click', () => {
            // Lógica para mostrar el modal de agregar equipo
        });

        // Manejar los botones de editar y eliminar
        teamsTableBody.addEventListener('click', (e) => {
            if (e.target.classList.contains('edit-btn')) {
                const id = e.target.getAttribute('data-id');
                const name = e.target.getAttribute('data-name');
                const representative = e.target.getAttribute('data-representative');
                // Lógica para mostrar el modal de edición con datos cargados
            }

            if (e.target.classList.contains('delete-btn')) {
                const id = e.target.getAttribute('data-id');
                // Confirmar y enviar el formulario de eliminación
            }
        });
    });
</script>
</body>
</html>
