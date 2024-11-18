document.addEventListener("DOMContentLoaded", () => {
    const teamsTableBody = document.getElementById('teamsTableBody');
    const addTeamModal = document.getElementById('addTeamModal');
    const editTeamModal = document.getElementById('editTeamModal');
    const deleteConfirmModal = document.getElementById('deleteConfirmModal');
    const addTeamForm = document.getElementById('addTeamForm');
    const editTeamForm = document.getElementById('editTeamForm');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const cancelAddBtn = document.querySelector('.cancel-add-btn');
    const cancelEditBtn = document.querySelector('.cancel-edit-btn');
    const cancelDeleteBtn = document.querySelector('.cancel-delete-btn');

    const teams = [
        { id: 1, name: "Real Madrid", representative: "Florentino Pérez", founded: "1902-03-06" },
        { id: 2, name: "Barcelona", representative: "Joan Laporta", founded: "1899-11-29" },
        { id: 3, name: "Manchester United", representative: "Richard Arnold", founded: "1878-01-01" }
    ];

    function escapeHTML(str) {
        const div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }

    function renderTeams() {
        teamsTableBody.innerHTML = ''; 
        teams.forEach(team => {
            const row = `
                <tr class="border-b border-accent">
                    <td class="p-4">${escapeHTML(team.name)}</td>
                    <td class="p-4">${escapeHTML(team.representative)}</td>
                    <td class="p-4">${escapeHTML(new Date(team.founded).toDateString())}</td>
                    <td class="p-4">
                        <button class="px-3 py-1 bg-accent text-white rounded-md text-sm mr-2 open-edit-btn" data-team-id="${team.id}">Edit</button>
                        <button class="px-3 py-1 bg-danger text-white rounded-md text-sm open-delete-btn" data-team-id="${team.id}">Delete</button>
                    </td>
                </tr>
            `;
            teamsTableBody.insertAdjacentHTML('beforeend', row);
        });

        // Asignar eventos dinámicamente a los botones "Edit"
        document.querySelectorAll('.open-edit-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const teamId = e.target.getAttribute('data-team-id'); // Obtén el ID del equipo
                openEditModal(teamId);
            });
        });

        // Asignar eventos dinámicamente a los botones "Delete"
        document.querySelectorAll('.open-delete-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const teamId = e.target.getAttribute('data-team-id'); // Obtén el ID del equipo
                openDeleteModal(teamId);
            });
        });
    }

    function openAddModal() {
        addTeamModal.classList.remove('hidden'); // Muestra el modal de agregar
    }

    function openEditModal(teamId) {
        const team = teams.find(t => t.id == teamId); // Encuentra el equipo correspondiente
        if (team) {
            // Rellena los campos del formulario de edición con los datos del equipo
            document.getElementById('editTeamId').value = team.id;
            document.getElementById('editTeamName').value = team.name;
            document.getElementById('editRepresentative').value = team.representative;
            document.getElementById('editFoundationDate').value = team.founded;
        }
        editTeamModal.classList.remove('hidden'); // Muestra el modal de edición
    }

    function openDeleteModal(teamId) {
        // Muestra el modal de confirmación de eliminación
        confirmDeleteBtn.setAttribute('data-team-id', teamId); // Asocia el ID al botón "Confirm Delete"
        deleteConfirmModal.classList.remove('hidden');
    }

    // Manejo del formulario de agregar
    addTeamForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const teamName = escapeHTML(document.getElementById('teamName').value);
        const representative = escapeHTML(document.getElementById('representative').value);
        const foundationDate = document.getElementById('foundationDate').value;

        if (teamName && representative && foundationDate) {
            const newTeam = {
                id: teams.length + 1, 
                name: teamName,
                representative: representative,
                founded: foundationDate
            };
            teams.push(newTeam);
            renderTeams(); // Actualiza la tabla
            addTeamModal.classList.add('hidden'); // Oculta el modal de agregar
        }
    });

    // Manejo del formulario de edición
    editTeamForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const teamId = document.getElementById('editTeamId').value;
        const teamName = escapeHTML(document.getElementById('editTeamName').value);
        const representative = escapeHTML(document.getElementById('editRepresentative').value);
        const foundationDate = document.getElementById('editFoundationDate').value;

        const teamIndex = teams.findIndex(t => t.id == teamId);
        if (teamIndex !== -1) {
            teams[teamIndex] = { ...teams[teamIndex], name: teamName, representative, founded: foundationDate };
        }
        renderTeams(); // Actualiza la tabla
        editTeamModal.classList.add('hidden'); // Oculta el modal de edición
    });

    // Manejo del botón "Cancel" para el modal de agregar
    cancelAddBtn.addEventListener('click', () => {
        addTeamModal.classList.add('hidden'); // Oculta el modal de agregar
    });

    // Manejo del botón "Cancel" para el modal de edición
    cancelEditBtn.addEventListener('click', () => {
        editTeamModal.classList.add('hidden'); // Oculta el modal de edición
    });

    // Manejo del botón "Cancel" para el modal de confirmación de eliminación
    cancelDeleteBtn.addEventListener('click', () => {
        deleteConfirmModal.classList.add('hidden'); // Oculta el modal
    });

    // Manejo del botón "Confirm Delete" en el modal de confirmación de eliminación
    confirmDeleteBtn.addEventListener('click', () => {
        const teamId = confirmDeleteBtn.getAttribute('data-team-id'); // Obtén el ID del equipo a eliminar
        const teamIndex = teams.findIndex(t => t.id == teamId);
        if (teamIndex !== -1) {
            teams.splice(teamIndex, 1); // Elimina el equipo del array
        }
        renderTeams(); // Actualiza la tabla
        deleteConfirmModal.classList.add('hidden'); // Oculta el modal
    });

    // Botón para abrir el modal de agregar
    document.getElementById('addTeamBtn').addEventListener('click', openAddModal);

    renderTeams(); // Renderiza la tabla al cargar la página
});
