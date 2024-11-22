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
<!-- Modal para Agregar Equipo -->
<div id="addTeamModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-black rounded-lg shadow-lg w-full max-w-md p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Add New Team</h2>
        <form id="addTeamForm" method="POST">
            <input type="hidden" name="action" value="create">
            <div class="mb-4">
                <label for="teamName" class="block text-sm font-medium text-gray-700">Team Name</label>
                <input type="text" id="teamName" name="teamName" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="representative" class="block text-sm font-medium text-gray-700">Representative</label>
                <input type="text" id="representative" name="representative" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="cancel-add-btn px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Add Team</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Editar Equipo -->
<div id="editTeamModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-black rounded-lg shadow-lg w-full max-w-md p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Team</h2>
        <form id="editTeamForm" method="POST">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" id="editTeamId" name="teamId">
            <div class="mb-4">
                <label for="editTeamName" class="block text-sm font-medium text-gray-700">Team Name</label>
                <input type="text" c id="editTeamName" name="teamName" required class="mt-1 bg-black block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="editRepresentative" class="block text-sm font-medium text-gray-700">Representative</label>
                <input type="text" id="editRepresentative" name="representative" required class="mt-1 block w-full bg-black rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="cancel-edit-btn px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Confirmar Eliminación -->
<!-- Modal para Confirmar Eliminación -->
<div id="deleteConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-black rounded-lg shadow-lg w-full max-w-md p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Delete Team</h2>
        <p class="text-gray-600 mb-6">Are you sure you want to delete this team? This action cannot be undone.</p>
        <form id="deleteTeamForm" method="POST">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" id="deleteTeamId" name="teamId">
            <div class="flex justify-end space-x-4">
                <button type="button" class="cancel-delete-btn px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancel</button>
                <button type="button" id="confirmDeleteBtn" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
            </div>
        </form>
    </div>
</div>

<script src="/public/js/renderteam.js"></script>

