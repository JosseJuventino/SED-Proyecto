const users = [
    { id: 6, username: "clopez_updated" },
    { id: 7, username: "jdoe" }
];

const matches = [
    {
        id: 2,
        fechaPartido: "2024-11-14T06:00:00.000Z",
        equipoLocal: "Equipo Águilas updated de nuevo",
        equipoVisitante: "Equipo A"
    },
    {
        id: 3,
        fechaPartido: "2024-11-20T06:00:00.000Z",
        equipoLocal: "Equipo B",
        equipoVisitante: "Equipo C"
    }
];

const bets = [
    {
        id: 5,
        idUsuario: 6,
        idPartido: 2,
        cantidadApostada: "500.000",
        fechaApuesta: "2024-11-14T06:00:00.000Z",
        idEstadoApuesta: 1,
        estadoApuesta: "ganada"
    }
];


document.addEventListener("DOMContentLoaded", () => {
    const betsTableBody = document.getElementById('betsTableBody');
    const addEditBetModal = document.getElementById('addEditBetModal');
    const addEditBetForm = document.getElementById('addEditBetForm');
    const cancelBetBtn = document.querySelector('.cancel-bet-btn');
    const betModalTitle = document.getElementById('betModalTitle');

    function renderBets() {
        betsTableBody.innerHTML = '';
        bets.forEach(bet => {
            const user = users.find(u => u.id === bet.idUsuario);
            const match = matches.find(m => m.id === bet.idPartido);
            const matchInfo = `${match.equipoLocal} vs ${match.equipoVisitante} (${new Date(match.fechaPartido).toLocaleString()})`;

            const row = `
                <tr class="border-b border-accent">
                    <td class="p-4">${user.username}</td>
                    <td class="p-4">${matchInfo}</td>
                    <td class="p-4">${bet.cantidadApostada}</td>
                    <td class="p-4">${bet.estadoApuesta}</td>
                </tr>
            `;
            betsTableBody.insertAdjacentHTML('beforeend', row);
        });

        document.querySelectorAll('.edit-bet-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const betId = e.target.getAttribute('data-bet-id');
                openEditBetModal(betId);
            });
        });

        document.querySelectorAll('.delete-bet-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const betId = e.target.getAttribute('data-bet-id');
                deleteBet(betId);
            });
        });
    }

    function populateDropdowns(selectedUserId = '', selectedMatchId = '') {
        const betUserDropdown = document.getElementById('betUser');
        const betMatchDropdown = document.getElementById('betMatch');

        betUserDropdown.innerHTML = '<option value="">Select User</option>';
        betMatchDropdown.innerHTML = '<option value="">Select Match</option>';

        users.forEach(user => {
            const selected = user.id == selectedUserId ? 'selected' : '';
            betUserDropdown.insertAdjacentHTML('beforeend', `<option value="${user.id}" ${selected}>${user.username}</option>`);
        });

        matches.forEach(match => {
            const matchInfo = `${match.equipoLocal} vs ${match.equipoVisitante} (${new Date(match.fechaPartido).toLocaleString()})`;
            const selected = match.id == selectedMatchId ? 'selected' : '';
            betMatchDropdown.insertAdjacentHTML('beforeend', `<option value="${match.id}" ${selected}>${matchInfo}</option>`);
        });
    }

    function openEditBetModal(betId) {
        const bet = bets.find(b => b.id == betId);
        if (bet) {
            document.getElementById('editBetId').value = bet.id;
            document.getElementById('betAmount').value = bet.cantidadApostada;
            document.getElementById('betState').value = bet.estadoApuesta;
            populateDropdowns(bet.idUsuario, bet.idPartido);
            betModalTitle.textContent = 'Edit Bet';
        } else {
            document.getElementById('editBetId').value = '';
            document.getElementById('betAmount').value = '';
            document.getElementById('betState').value = 'pendiente';
            populateDropdowns();
            betModalTitle.textContent = 'Add Bet';
        }
        addEditBetModal.classList.remove('hidden');
    }

    function deleteBet(betId) {
        const betIndex = bets.findIndex(b => b.id == betId);
        if (betIndex !== -1) {
            bets.splice(betIndex, 1);
        }
        renderBets();
    }

    addEditBetForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const betId = document.getElementById('editBetId').value;
        const betUserId = document.getElementById('betUser').value;
        const betMatchId = document.getElementById('betMatch').value;
        const betAmount = document.getElementById('betAmount').value;
        const betState = document.getElementById('betState').value;

        if (!betUserId || !betMatchId || !betAmount) {
            alert('Please fill in all fields.');
            return;
        }

        if (betId) {
            const bet = bets.find(b => b.id == betId);
            if (bet) {
                bet.idUsuario = parseInt(betUserId);
                bet.idPartido = parseInt(betMatchId);
                bet.cantidadApostada = betAmount;
                bet.estadoApuesta = betState;
            }
        } else {
            bets.push({
                id: bets.length + 1,
                idUsuario: parseInt(betUserId),
                idPartido: parseInt(betMatchId),
                cantidadApostada: betAmount,
                fechaApuesta: new Date().toISOString(),
                idEstadoApuesta: 1,
                estadoApuesta: betState
            });
        }

        renderBets();
        addEditBetModal.classList.add('hidden');
    });

    document.getElementById('addBetBtn').addEventListener('click', () => {
        openEditBetModal(null);
    });

    cancelBetBtn.addEventListener('click', () => {
        addEditBetModal.classList.add('hidden');
    });

    renderBets();
});
