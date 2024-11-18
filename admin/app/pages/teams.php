<!-- Main Content -->
<main class="flex-1 p-0">
    <header class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold">Teams Management</h1>
        <button id="addTeamBtn" class="px-4 py-2 bg-success text-white rounded-md font-medium">Add New Team</button>
    </header>

    <!-- Teams Table -->
    <div class="bg-primary rounded-lg overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-secondary">
                    <th class="text-left p-4 font-medium text-gray-400">Team Name</th>
                    <th class="text-left p-4 font-medium text-gray-400">Representative</th>
                    <th class="text-left p-4 font-medium text-gray-400">Founded</th>
                    <th class="text-left p-4 font-medium text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody id="teamsTableBody">
                <!-- Rows generated dynamically with safe data escaping -->
            </tbody>
        </table>
    </div>
</main>

<!-- Add Team Modal -->
<div id="addTeamModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-primary p-8 rounded-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4">Add New Team</h2>
        <form id="addTeamForm">
            <div class="mb-4">
                <label for="teamName" class="block text-sm font-medium text-gray-400 mb-2">Team Name</label>
                <input type="text" id="teamName" name="teamName" required maxlength="100"
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
            </div>
            <div class="mb-4">
                <label for="representative" class="block text-sm font-medium text-gray-400 mb-2">Representative</label>
                <input type="text" id="representative" name="representative" required maxlength="100"
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
            </div>
            <div class="mb-4">
                <label for="foundationDate" class="block text-sm font-medium text-gray-400 mb-2">Date of
                    Foundation</label>
                <input type="date" id="foundationDate" name="foundationDate" required min="1800-01-01" max="2100-12-31"
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
            </div>
            <div class="mb-6">
                <label for="teamImage" class="block text-sm font-medium text-gray-400 mb-2">Team Image</label>
                <input type="file" id="teamImage" name="teamImage" accept="image/*"
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="px-4 py-2 bg-accent text-white rounded-md cancel-add-btn">Cancel</button>

                <button type="submit" class="px-4 py-2 bg-success text-white rounded-md">Add Team</button>
            </div>
        </form>
    </div>
</div>

<div id="editTeamModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-primary p-8 rounded-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4">Edit Team</h2>
        <form id="editTeamForm">
            <input type="hidden" id="editTeamId" name="teamId">
            <div class="mb-4">
                <label for="editTeamName" class="block text-sm font-medium text-gray-400 mb-2">Team Name</label>
                <input type="text" id="editTeamName" name="teamName" required
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
            </div>
            <div class="mb-4">
                <label for="editRepresentative"
                    class="block text-sm font-medium text-gray-400 mb-2">Representative</label>
                <input type="text" id="editRepresentative" name="representative" required
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
            </div>
            <div class="mb-4">
                <label for="editFoundationDate" class="block text-sm font-medium text-gray-400 mb-2">Date of
                    Foundation</label>
                <input type="date" id="editFoundationDate" name="foundationDate" required
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
            </div>
            <div class="mb-6">
                <label for="editTeamImage" class="block text-sm font-medium text-gray-400 mb-2">Team Image</label>
                <input type="file" id="editTeamImage" name="teamImage" accept="image/*"
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="px-4 py-2 bg-accent text-white rounded-md cancel-edit-btn">Cancel</button>

                <button type="submit" class="px-4 py-2 bg-success text-white rounded-md">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<div id="deleteConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-primary p-8 rounded-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4">Confirm Deletion</h2>
        <p class="mb-6">Are you sure you want to delete this team? This action cannot be undone.</p>
        <div class="flex justify-end space-x-4">
            <button type="button" class="px-4 py-2 bg-accent text-white rounded-md cancel-delete-btn">Cancel</button>

            <button id="confirmDeleteBtn" class="px-4 py-2 bg-danger text-white rounded-md">Delete</button>
        </div>
    </div>
</div>

<script src="/public/js/renderteam.js"></script>