    document.addEventListener("DOMContentLoaded", () => {
    const usersTableBody = document.getElementById('usersTableBody');
    const addUserModal = document.getElementById('addUserModal');
    const editUserModal = document.getElementById('editUserModal');
    const deleteConfirmModal = document.getElementById('deleteConfirmModal');
    const addUserForm = document.getElementById('addUserForm');
    const editUserForm = document.getElementById('editUserForm');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const cancelAddBtn = document.querySelector('.cancel-add-btn');
    const cancelEditBtn = document.querySelector('.cancel-edit-btn');
    const cancelDeleteBtn = document.querySelector('.cancel-delete-btn');

    const users = [
        { id: 15, name: "Nuevozz López", email: "nuevozz@example.com", role: "Administrator" }
    ];

    function renderUsers() {
        usersTableBody.innerHTML = '';
        users.forEach(user => {
            const row = `
                <tr class="border-b border-accent">
                    <td class="p-4">${user.name}</td>
                    <td class="p-4">${user.email}</td>
                    <td class="p-4">${user.role}</td>
                    <td class="p-4">
                        <button class="px-3 py-1 bg-accent text-white rounded-md text-sm mr-2 open-edit-btn" data-user-id="${user.id}">Edit</button>
                        <button class="px-3 py-1 bg-danger text-white rounded-md text-sm open-delete-btn" data-user-id="${user.id}">Delete</button>
                    </td>
                </tr>
            `;
            usersTableBody.insertAdjacentHTML('beforeend', row);
        });

        document.querySelectorAll('.open-edit-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const userId = e.target.getAttribute('data-user-id');
                openEditModal(userId);
            });
        });

        document.querySelectorAll('.open-delete-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const userId = e.target.getAttribute('data-user-id');
                openDeleteModal(userId);
            });
        });
    }

    function openAddModal() {
        addUserModal.classList.remove('hidden');
    }

    function openEditModal(userId) {
        const user = users.find(u => u.id == userId);
        if (user) {
            document.getElementById('editUserId').value = user.id;
            document.getElementById('editUserName').value = user.name;
            document.getElementById('editUserEmail').value = user.email;
            document.getElementById('editUserRole').value = user.role;
        }
        editUserModal.classList.remove('hidden');
    }

    function openDeleteModal(userId) {
        confirmDeleteBtn.setAttribute('data-user-id', userId);
        deleteConfirmModal.classList.remove('hidden');
    }

    addUserForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const userName = document.getElementById('userName').value;
        const userEmail = document.getElementById('userEmail').value;
        const userRole = document.getElementById('userRole').value;

        if (userName && userEmail && userRole) {
            users.push({
                id: users.length + 1,
                name: userName,
                email: userEmail,
                role: userRole
            });
            renderUsers();
            addUserModal.classList.add('hidden');
        }
    });

    editUserForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const userId = document.getElementById('editUserId').value;
        const userName = document.getElementById('editUserName').value;
        const userEmail = document.getElementById('editUserEmail').value;
        const userRole = document.getElementById('editUserRole').value;

        const userIndex = users.findIndex(u => u.id == userId);
        if (userIndex !== -1) {
            users[userIndex] = { id: userId, name: userName, email: userEmail, role: userRole };
        }
        renderUsers();
        editUserModal.classList.add('hidden');
    });

    cancelAddBtn.addEventListener('click', () => {
        addUserModal.classList.add('hidden');
    });

    cancelEditBtn.addEventListener('click', () => {
        editUserModal.classList.add('hidden');
    });

    cancelDeleteBtn.addEventListener('click', () => {
        deleteConfirmModal.classList.add('hidden');
    });

    confirmDeleteBtn.addEventListener('click', () => {
        const userId = confirmDeleteBtn.getAttribute('data-user-id');
        const userIndex = users.findIndex(u => u.id == userId);
        if (userIndex !== -1) {
            users.splice(userIndex, 1);
        }
        renderUsers();
        deleteConfirmModal.classList.add('hidden');
    });

    document.getElementById('addUserBtn').addEventListener('click', openAddModal);

    renderUsers();
    });
