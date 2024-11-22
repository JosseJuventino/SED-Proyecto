class PartidoService {
    constructor(apiUrl, authToken) {
        this.apiUrl = apiUrl;
        this.authToken = authToken;
    }

    async getAllPartidos() {
        const response = await fetch(`${this.apiUrl}/partido`, {
            headers: { Authorization: `Bearer ${this.authToken}` },
        });
        return response.json();
    }

    async getPartidoById(id) {
        const response = await fetch(`${this.apiUrl}/partido/${id}`, {
            headers: { Authorization: `Bearer ${this.authToken}` },
        });
        return response.json();
    }

    async createPartido(data) {
        const response = await fetch(`${this.apiUrl}/partido`, {
            method: 'POST',
            headers: {
                Authorization: `Bearer ${this.authToken}`,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
        return response.json();
    }

    async updatePartido(id, data) {
        const response = await fetch(`${this.apiUrl}/partido/${id}`, {
            method: 'PUT',
            headers: {
                Authorization: `Bearer ${this.authToken}`,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
        return response.json();
    }

    async deletePartido(id, userId) {
        const response = await fetch(`${this.apiUrl}/partido/${id}/delete`, {
            method: 'POST', // Simulación de DELETE
            headers: {
                Authorization: `Bearer ${this.authToken}`,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ userId }),
        });
        return response.json();
    }
}

const partidoService = new PartidoService('https://api.ejemplo.com', 'tu_auth_token');

// DOM Elements
const matchesTableBody = document.getElementById('matchesTableBody');
const addEditMatchModal = document.getElementById('addEditMatchModal');
const finalizeMatchModal = document.getElementById('finalizeMatchModal');
const addEditMatchForm = document.getElementById('addEditMatchForm');
const finalizeMatchForm = document.getElementById('finalizeMatchForm');

// Render Matches
async function renderMatches() {
    const matches = await partidoService.getAllPartidos();
    matchesTableBody.innerHTML = '';

    matches.forEach(match => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="p-4">${match.fechaPartido}</td>
            <td class="p-4">${match.equipoLocal.nombre}</td>
            <td class="p-4">${match.equipoVisitante.nombre}</td>
            <td class="p-4">${match.marcadorLocal || '-'}:${match.marcadorVisitante || '-'}</td>
            <td class="p-4">
                <button class="px-4 py-2 bg-info text-white rounded-md edit-btn" data-id="${match.id}">Edit</button>
                <button class="px-4 py-2 bg-error text-white rounded-md delete-btn" data-id="${match.id}">Delete</button>
            </td>
        `;
        matchesTableBody.appendChild(row);
    });

    addEventListeners();
}

// Add Event Listeners
function addEventListeners() {
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', async (e) => {
            const id = e.target.dataset.id;
            const match = await partidoService.getPartidoById(id);

            document.getElementById('editMatchId').value = id;
            document.getElementById('matchDate').value = match.fechaPartido;
            document.getElementById('homeTeam').value = match.idEquipoLocal;
            document.getElementById('awayTeam').value = match.idEquipoVisitante;

            addEditMatchModal.classList.remove('hidden');
        });
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', async (e) => {
            const id = e.target.dataset.id;
            if (confirm('Are you sure you want to delete this match?')) {
                await partidoService.deletePartido(id, 31); // Replace with actual userId
                renderMatches();
            }
        });
    });
}

// Handle Add/Edit Form Submission
addEditMatchForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const id = document.getElementById('editMatchId').value;
    const data = {
        userId: 27, // Replace with actual userId
        fechaPartido: document.getElementById('matchDate').value,
        idEquipoLocal: document.getElementById('homeTeam').value,
        idEquipoVisitante: document.getElementById('awayTeam').value,
    };

    if (id) {
        await partidoService.updatePartido(id, data);
    } else {
        await partidoService.createPartido(data);
    }

    addEditMatchModal.classList.add('hidden');
    renderMatches();
});

// Handle Finalize Form Submission
finalizeMatchForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const id = document.getElementById('finalizeMatchId').value;
    const data = {
        marcadorLocal: document.getElementById('finalHomeScore').value,
        marcadorVisitante: document.getElementById('finalAwayScore').value,
    };

    await partidoService.updatePartido(id, data);

    finalizeMatchModal.classList.add('hidden');
    renderMatches();
});

// Initialize
renderMatches();

// Event Listeners for Modal Cancel Buttons
document.querySelectorAll('.cancel-modal-btn').forEach(button => {
    button.addEventListener('click', () => {
        addEditMatchModal.classList.add('hidden');
    });
});

document.querySelectorAll('.cancel-finalize-btn').forEach(button => {
    button.addEventListener('click', () => {
        finalizeMatchModal.classList.add('hidden');
    });
});
