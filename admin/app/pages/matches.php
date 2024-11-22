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

<main class="flex-1 p-0">
    <header class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold">Match Management</h1>
        <button id="addMatchBtn" class="px-4 py-2 bg-success text-white rounded-md font-medium">Add New Match</button>
    </header>

    <!-- Matches Table -->
    <div class="bg-primary rounded-lg overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-secondary">
                    <th class="text-left p-4 font-medium text-gray-400">Date</th>
                    <th class="text-left p-4 font-medium text-gray-400">Home Team</th>
                    <th class="text-left p-4 font-medium text-gray-400">Away Team</th>
                    <th class="text-left p-4 font-medium text-gray-400">Score</th>
                    <th class="text-left p-4 font-medium text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody id="matchesTableBody">
                <!-- Rows generated dynamically -->
            </tbody>
        </table>
    </div>
</main>

<!-- Add/Edit Match Modal -->
<div id="addEditMatchModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-primary p-8 rounded-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4" id="modalTitle">Add Match</h2>
        <form id="addEditMatchForm">
            <input type="hidden" id="editMatchId">
            <div class="mb-4">
                <label for="matchDate" class="block text-sm font-medium text-gray-400 mb-2">Match Date</label>
                <input type="datetime-local" id="matchDate" name="matchDate" required
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
            </div>
            <div class="mb-4">
                <label for="homeTeam" class="block text-sm font-medium text-gray-400 mb-2">Home Team</label>
                <select id="homeTeam" name="homeTeam" required
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
                </select>
            </div>
            <div class="mb-4">
                <label for="awayTeam" class="block text-sm font-medium text-gray-400 mb-2">Away Team</label>
                <select id="awayTeam" name="awayTeam" required
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
                </select>
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="px-4 py-2 bg-accent text-white rounded-md cancel-modal-btn">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-success text-white rounded-md">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Finalize Match Modal -->
<div id="finalizeMatchModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-primary p-8 rounded-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4">Finalize Match</h2>
        <form id="finalizeMatchForm">
            <input type="hidden" id="finalizeMatchId">
            <div class="mb-4">
                <label for="finalHomeScore" class="block text-sm font-medium text-gray-400 mb-2">Home Team Score</label>
                <input type="number" id="finalHomeScore" name="finalHomeScore" required min="0"
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
            </div>
            <div class="mb-4">
                <label for="finalAwayScore" class="block text-sm font-medium text-gray-400 mb-2">Away Team Score</label>
                <input type="number" id="finalAwayScore" name="finalAwayScore" required min="0"
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="px-4 py-2 bg-accent text-white rounded-md cancel-finalize-btn">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-success text-white rounded-md">Finalize</button>
            </div>
        </form>
    </div>
</div>

<script src="/public/js/rendermatch.js"></script>