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
        <h1 class="text-2xl font-bold">User Management</h1>
        <button id="addUserBtn" class="px-4 py-2 bg-success text-white rounded-md font-medium">Add New User</button>
    </header>

    <!-- Users Table -->
    <div class="bg-primary rounded-lg overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-secondary">
                    <th class="text-left p-4 font-medium text-gray-400">Name</th>
                    <th class="text-left p-4 font-medium text-gray-400">Email</th>
                    <th class="text-left p-4 font-medium text-gray-400">Role</th>
                    <th class="text-left p-4 font-medium text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody id="usersTableBody">
                <!-- Rows generated dynamically -->
            </tbody>
        </table>
    </div>
</main>

<!-- Add User Modal -->
<div id="addUserModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-primary p-8 rounded-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4">Add New User</h2>
        <form id="addUserForm">
            <div class="mb-4">
                <label for="userName" class="block text-sm font-medium text-gray-400 mb-2">Name</label>
                <input type="text" id="userName" name="userName" required maxlength="100"
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
            </div>
            <div class="mb-4">
                <label for="userEmail" class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                <input type="email" id="userEmail" name="userEmail" required maxlength="100"
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
            </div>
            <div class="mb-4">
                <label for="userRole" class="block text-sm font-medium text-gray-400 mb-2">Role</label>
                <select id="userRole" name="userRole" required
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
                    <option value="Administrator">Administrator</option>
                    <option value="User">User</option>
                </select>
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="px-4 py-2 bg-accent text-white rounded-md cancel-add-btn">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-success text-white rounded-md">Add User</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-primary p-8 rounded-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4">Edit User</h2>
        <form id="editUserForm">
            <input type="hidden" id="editUserId" name="userId">
            <div class="mb-4">
                <label for="editUserName" class="block text-sm font-medium text-gray-400 mb-2">Name</label>
                <input type="text" id="editUserName" name="userName" required
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
            </div>
            <div class="mb-4">
                <label for="editUserEmail" class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                <input type="email" id="editUserEmail" name="userEmail" required
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
            </div>
            <div class="mb-4">
                <label for="editUserRole" class="block text-sm font-medium text-gray-400 mb-2">Role</label>
                <select id="editUserRole" name="userRole" required
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
                    <option value="Administrator">Administrator</option>
                    <option value="User">User</option>
                </select>
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="px-4 py-2 bg-accent text-white rounded-md cancel-edit-btn">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-success text-white rounded-md">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-primary p-8 rounded-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4">Confirm Deletion</h2>
        <p class="mb-6">Are you sure you want to delete this user? This action cannot be undone.</p>
        <div class="flex justify-end space-x-4">
            <button type="button" class="px-4 py-2 bg-accent text-white rounded-md cancel-delete-btn">Cancel</button>
            <button id="confirmDeleteBtn" class="px-4 py-2 bg-danger text-white rounded-md">Delete</button>
        </div>
    </div>
</div>

<script src="/public/js/renderuser.js"></script>