document.addEventListener("DOMContentLoaded", () => {
    const matchesTableBody = document.getElementById('matchesTableBody');
    const finalizeMatchModal = document.getElementById('finalizeMatchModal');
    const finalizeMatchForm = document.getElementById('finalizeMatchForm');
    const cancelFinalizeBtn = document.querySelector('.cancel-finalize-btn');

    const matches = [
        {
            id: 1,
            fechaPartido: "2024-11-14T06:00:00.000Z",
            marcadorLocal: null,
            marcadorVisitante: null,
            equipoLocal: "Equipo Águilas",
            equipoVisitante: "Equipo B",
            finalizado: false
        }
    ];

    function renderMatches() {
        matchesTableBody.innerHTML = '';
        matches.forEach(match => {
            const marcador = match.marcadorLocal === null || match.marcadorVisitante === null
                ? '- . -'
                : `${match.marcadorLocal} - ${match.marcadorVisitante}`;
            const row = `
                <tr class="border-b border-accent ${match.finalizado ? 'bg-gray-200' : ''}">
                    <td class="p-4">${new Date(match.fechaPartido).toLocaleString()}</td>
                    <td class="p-4">${match.equipoLocal}</td>
                    <td class="p-4">${match.equipoVisitante}</td>
                    <td class="p-4">${marcador}</td>
                    <td class="p-4">${match.finalizado ? 'Finalizado' : 'Pendiente'}</td>
                    <td class="p-4">
                        <button class="px-3 py-1 bg-accent text-white rounded-md text-sm mr-2 open-edit-btn" data-match-id="${match.id}">Edit</button>
                        <button class="px-3 py-1 bg-success text-white rounded-md text-sm mr-2 finalize-btn" data-match-id="${match.id}">${match.finalizado ? 'Reopen' : 'Finalize'}</button>
                        <button class="px-3 py-1 bg-danger text-white rounded-md text-sm delete-btn" data-match-id="${match.id}">Delete</button>
                    </td>
                </tr>
            `;
            matchesTableBody.insertAdjacentHTML('beforeend', row);
        });

        document.querySelectorAll('.finalize-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const matchId = e.target.getAttribute('data-match-id');
                openFinalizeModal(matchId);
            });
        });
    }

    function openFinalizeModal(matchId) {
        document.getElementById('finalizeMatchId').value = matchId;
        finalizeMatchModal.classList.remove('hidden');
    }

    function finalizeMatch(matchId, homeScore, awayScore) {
        const match = matches.find(m => m.id == matchId);
        if (match) {
            match.marcadorLocal = homeScore;
            match.marcadorVisitante = awayScore;
            match.finalizado = true;
        }
        renderMatches();
    }

    finalizeMatchForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const matchId = document.getElementById('finalizeMatchId').value;
        const homeScore = parseInt(document.getElementById('finalHomeScore').value, 10);
        const awayScore = parseInt(document.getElementById('finalAwayScore').value, 10);

        if (isNaN(homeScore) || isNaN(awayScore)) {
            alert('Please enter valid scores.');
            return;
        }

        finalizeMatch(matchId, homeScore, awayScore);
        finalizeMatchModal.classList.add('hidden');
    });

    cancelFinalizeBtn.addEventListener('click', () => {
        finalizeMatchModal.classList.add('hidden');
    });

    renderMatches();
});
