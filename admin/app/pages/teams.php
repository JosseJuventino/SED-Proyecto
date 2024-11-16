

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
                    <tbody>
                        <tr class="border-b border-accent">
                            <td class="p-4">Real Madrid</td>
                            <td class="p-4">Florentino Pérez</td>
                            <td class="p-4">March 6, 1902</td>
                            <td class="p-4">
                                <button class="px-3 py-1 bg-accent text-white rounded-md text-sm mr-2 edit-btn" data-team-id="1">Edit</button>
                                <button class="px-3 py-1 bg-danger text-white rounded-md text-sm delete-btn" data-team-id="1">Delete</button>
                            </td>
                        </tr>
                        <tr class="border-b border-accent">
                            <td class="p-4">Barcelona</td>
                            <td class="p-4">Joan Laporta</td>
                            <td class="p-4">November 29, 1899</td>
                            <td class="p-4">
                                <button class="px-3 py-1 bg-accent text-white rounded-md text-sm mr-2 edit-btn" data-team-id="2">Edit</button>
                                <button class="px-3 py-1 bg-danger text-white rounded-md text-sm delete-btn" data-team-id="2">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-4">Manchester United</td>
                            <td class="p-4">Richard Arnold</td>
                            <td class="p-4">1878</td>
                            <td class="p-4">
                                <button class="px-3 py-1 bg-accent text-white rounded-md text-sm mr-2 edit-btn" data-team-id="3">Edit</button>
                                <button class="px-3 py-1 bg-danger text-white rounded-md text-sm delete-btn" data-team-id="3">Delete</button>
                            </td>
                        </tr>
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
                    <input type="text" id="teamName" name="teamName" required
                           class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
                </div>
                <div class="mb-4">
                    <label for="representative" class="block text-sm font-medium text-gray-400 mb-2">Representative</label>
                    <input type="text" id="representative" name="representative" required
                           class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
                </div>
                <div class="mb-4">
                    <label for="foundationDate" class="block text-sm font-medium text-gray-400 mb-2">Date of Foundation</label>
                    <input type="date" id="foundationDate" name="foundationDate" required
                           class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
                </div>
                <div class="mb-6">
                    <label for="teamImage" class="block text-sm font-medium text-gray-400 mb-2">Team Image</label>
                    <input type="file" id="teamImage" name="teamImage" accept="image/*"
                           class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" class="px-4 py-2 bg-accent text-white rounded-md cancel-btn">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-success text-white rounded-md">Add Team</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Team Modal -->
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
                    <label for="editRepresentative" class="block text-sm font-medium text-gray-400 mb-2">Representative</label>
                    <input type="text" id="editRepresentative" name="representative" required
                           class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
                </div>
                <div class="mb-4">
                    <label for="editFoundationDate" class="block text-sm font-medium text-gray-400 mb-2">Date of Foundation</label>
                    <input type="date" id="editFoundationDate" name="foundationDate" required
                           class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
                </div>
                <div class="mb-6">
                    <label for="editTeamImage" class="block text-sm font-medium text-gray-400 mb-2">Team Image</label>
                    <input type="file" id="editTeamImage" name="teamImage" accept="image/*"
                           class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" class="px-4 py-2 bg-accent text-white rounded-md cancel-btn">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-success text-white rounded-md">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-primary p-8 rounded-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-4">Confirm Deletion</h2>
            <p class="mb-6">Are you sure you want to delete this team? This action cannot be undone.</p>
            <div class="flex justify-end space-x-4">
                <button id="cancelDeleteBtn" class="px-4 py-2 bg-accent text-white rounded-md">Cancel</button>
                <button id="confirmDeleteBtn" class="px-4 py-2 bg-danger text-white rounded-md">Delete</button>
            </div>
        </div>
    </div>

    <script>
        const addTeamBtn = document.getElementById('addTeamBtn');
        const addTeamModal = document.getElementById('addTeamModal');
        const editTeamModal = document.getElementById('editTeamModal');
        const deleteConfirmModal = document.getElementById('deleteConfirmModal');
        const addTeamForm = document.getElementById('addTeamForm');
        const editTeamForm = document.getElementById('editTeamForm');
        const cancelBtns = document.querySelectorAll('.cancel-btn');
        const editBtns = document.querySelectorAll('.edit-btn');
        const deleteBtns = document.querySelectorAll('.delete-btn');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        let currentTeamId = null;

        // Add Team
        addTeamBtn.addEventListener('click', () => {
            addTeamModal.classList.remove('hidden');
        });

        addTeamForm.addEventListener('submit', (e) => {
            e.preventDefault();
            console.log('Add team form submitted');
            addTeamModal.classList.add('hidden');
        });

        // Edit Team
        editBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const teamId = e.target.getAttribute('data-team-id');
                currentTeamId = teamId;
                // In a real application, you would fetch the team data here
                document.getElementById('editTeamId').value = teamId;
                document.getElementById('editTeamName').value = 'Team ' + teamId;
                document.getElementById('editRepresentative').value = 'Representative ' + teamId;
                document.getElementById('editFoundationDate').value = '2023-01-01'; // Example date
                editTeamModal.classList.remove('hidden');
            });
        });

        editTeamForm.addEventListener('submit', (e) => {
            e.preventDefault();
            console.log('Edit team form submitted for team ID:', currentTeamId);
            editTeamModal.classList.add('hidden');
        });

        // Delete Team
        deleteBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                currentTeamId = e.target.getAttribute('data-team-id');
                deleteConfirmModal.classList.remove('hidden');
            });
        });

        confirmDeleteBtn.addEventListener('click', () => {
            console.log('Deleting team with ID:', currentTeamId);
            deleteConfirmModal.classList.add('hidden');
            // Here you would typically send a request to your backend to delete the team
        });

        // Cancel buttons
        cancelBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                addTeamModal.classList.add('hidden');
                editTeamModal.classList.add('hidden');
            });
        });

        cancelDeleteBtn.addEventListener('click', () => {
            deleteConfirmModal.classList.add('hidden');
        });

        // Close modals if clicking outside
        [addTeamModal, editTeamModal, deleteConfirmModal].forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
