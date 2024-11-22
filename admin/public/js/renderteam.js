document.addEventListener("DOMContentLoaded", () => {
    const addTeamModal = document.getElementById('addTeamModal');
    const editTeamModal = document.getElementById('editTeamModal');
    const deleteConfirmModal = document.getElementById('deleteConfirmModal');
    const cancelAddBtn = document.querySelector('.cancel-add-btn');
    const cancelEditBtn = document.querySelector('.cancel-edit-btn');
    const cancelDeleteBtn = document.querySelector('.cancel-delete-btn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn'); // Correctamente definido

    // Función para abrir el modal de agregar
    function openAddModal() {
        addTeamModal.classList.remove('hidden'); // Mostrar el modal
    }

    // Función para abrir el modal de editar
    function openEditModal(teamId, teamName, representative) {
        document.getElementById('editTeamId').value = teamId;
        document.getElementById('editTeamName').value = teamName;
        document.getElementById('editRepresentative').value = representative;

        editTeamModal.classList.remove('hidden'); // Mostrar el modal
    }

    // Función para abrir el modal de eliminación
    function openDeleteModal(teamId) {
        document.getElementById('deleteTeamId').value = teamId; // Asignar el ID al input oculto
        confirmDeleteBtn.setAttribute('data-team-id', teamId); // Vincular el ID al botón de confirmación
        deleteConfirmModal.classList.remove('hidden'); // Mostrar el modal
    }

    // Eventos para abrir los modales
    document.getElementById('addTeamBtn').addEventListener('click', openAddModal);

    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
            const teamId = button.getAttribute('data-id');
            const teamName = button.getAttribute('data-name');
            const representative = button.getAttribute('data-representative');
            openEditModal(teamId, teamName, representative);
        });
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', () => {
            const teamId = button.getAttribute('data-id');
            openDeleteModal(teamId);
        });
    });

    // Eventos para cerrar los modales
    cancelAddBtn.addEventListener('click', () => {
        addTeamModal.classList.add('hidden');
    });

    cancelEditBtn.addEventListener('click', () => {
        editTeamModal.classList.add('hidden');
    });

    cancelDeleteBtn.addEventListener('click', () => {
        deleteConfirmModal.classList.add('hidden');
    });

    // Confirmar la eliminación
    confirmDeleteBtn.addEventListener('click', () => {
        const teamId = confirmDeleteBtn.getAttribute('data-team-id');
        console.log(`Deleting team with ID: ${teamId}`);

        // Opcional: Aquí puedes enviar una solicitud POST para eliminar el equipo
        const deleteForm = document.getElementById('deleteTeamForm');
        deleteForm.submit(); // Enviar el formulario si es necesario

        deleteConfirmModal.classList.add('hidden'); // Ocultar el modal
    });
});
