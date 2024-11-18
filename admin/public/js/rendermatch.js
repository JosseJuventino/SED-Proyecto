document.addEventListener("DOMContentLoaded", () => {
    const matchesTableBody = document.getElementById('matchesTableBody');
    const addEditMatchModal = document.getElementById('addEditMatchModal');
    const addEditMatchForm = document.getElementById('addEditMatchForm');
    const finalizeMatchModal = document.getElementById('finalizeMatchModal');
    const finalizeMatchForm = document.getElementById('finalizeMatchForm');
    const cancelModalBtn = document.querySelector('.cancel-modal-btn');
    const cancelFinalizeBtn = document.querySelector('.cancel-finalize-btn');
    const modalTitle = document.getElementById('modalTitle');
    const addMatchBtn = document.getElementById('addMatchBtn');

    const teams = [
        { id: 1, name: "Equipo Águilas" },
        { id: 2, name: "Equipo B" },
        { id: 3, name: "Equipo C" },
        { id: 4, name: "Equipo D" }
    ];

    const matches = [
        {
            id: 1,
            fechaPartido: "2024-11-14T06:00:00.000Z",
            marcadorLocal: 2,
            marcadorVisitante: 1,
            equipoLocal: "Equipo Águilas",
            equipoVisitante: "Equipo B",
        }
    ];

    function renderMatches() {
        matchesTableBody.innerHTML = '';
        matches.forEach(match => {
            const score = match.marcadorLocal === null || match.marcadorVisitante === null
                ? '-.-'
                : `${match.marcadorLocal} - ${match.marcadorVisitante}`;
            const row = `
                <tr class="border-b border-accent">
                    <td class="p-4">${new Date(match.fechaPartido).toLocaleString()}</td>
                    <td class="p-4">${match.equipoLocal}</td>
                    <td class="p-4">${match.equipoVisitante}</td>
                    <td class="p-4">${score}</td>
                    <td class="p-4">
                        <button class="px-3 py-1 bg-accent text-white rounded-md text-sm open-edit-btn" data-match-id="${match.id}">Edit</button>
                        <button class="px-3 py-1 bg-success text-white rounded-md text-sm finalize-btn" data-match-id="${match.id}">Finalize</button>
                        <button class="px-3 py-1 bg-danger text-white rounded-md text-sm delete-btn" data-match-id="${match.id}">Delete</button>
                    </td>
                </tr>
            `;
            matchesTableBody.insertAdjacentHTML('beforeend', row);
        });
    
        document.querySelectorAll('.open-edit-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const matchId = e.target.getAttribute('data-match-id');
                openEditModal(matchId);
            });
        });
    
        document.querySelectorAll('.finalize-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const matchId = e.target.getAttribute('data-match-id');
                openFinalizeModal(matchId);
            });
        });
    
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const matchId = e.target.getAttribute('data-match-id');
                deleteMatch(matchId);
            });
        });
    }

    function deleteMatch(matchId) {
        const matchIndex = matches.findIndex(match => match.id === parseInt(matchId));
        if (matchIndex !== -1) {
            matches.splice(matchIndex, 1);
            renderMatches();
        }
    }
    
    

    function populateDropdowns(selectedHome = '', selectedAway = '') {
        const homeTeamDropdown = document.getElementById('homeTeam');
        const awayTeamDropdown = document.getElementById('awayTeam');
        homeTeamDropdown.innerHTML = '<option value="">Select Home Team</option>';
        awayTeamDropdown.innerHTML = '<option value="">Select Away Team</option>';
        teams.forEach(team => {
            homeTeamDropdown.insertAdjacentHTML(
                'beforeend',
                `<option value="${team.id}" ${team.id === selectedHome ? 'selected' : ''}>${team.name}</option>`
            );
            awayTeamDropdown.insertAdjacentHTML(
                'beforeend',
                `<option value="${team.id}" ${team.id === selectedAway ? 'selected' : ''}>${team.name}</option>`
            );
        });
    }

    function openEditModal(matchId) {
        const match = matches.find(m => m.id === parseInt(matchId));
        if (match) {
            modalTitle.textContent = 'Edit Match';
            document.getElementById('editMatchId').value = match.id;
            document.getElementById('matchDate').value = new Date(match.fechaPartido).toISOString().slice(0, 16);
            populateDropdowns(
                teams.find(t => t.name === match.equipoLocal)?.id,
                teams.find(t => t.name === match.equipoVisitante)?.id
            );
        }
        addEditMatchModal.classList.remove('hidden');
    }

    function openFinalizeModal(matchId) {
        document.getElementById('finalizeMatchId').value = matchId;
        finalizeMatchModal.classList.remove('hidden');
    }

    finalizeMatchForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const matchId = document.getElementById('finalizeMatchId').value;
        const homeScore = document.getElementById('finalHomeScore').value;
        const awayScore = document.getElementById('finalAwayScore').value;

        const match = matches.find(m => m.id === parseInt(matchId));
        if (match) {
            match.marcadorLocal = parseInt(homeScore);
            match.marcadorVisitante = parseInt(awayScore);
            renderMatches();
            finalizeMatchModal.classList.add('hidden');
        }
    });
    addEditMatchForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const matchId = document.getElementById('editMatchId').value;
        const matchDate = document.getElementById('matchDate').value;
        const homeTeamId = document.getElementById('homeTeam').value;
        const awayTeamId = document.getElementById('awayTeam').value;
    
        if (!homeTeamId || !awayTeamId || homeTeamId === awayTeamId) {
            alert('Please select valid teams.');
            return;
        }
    
        const homeTeam = teams.find(t => t.id === parseInt(homeTeamId)).name;
        const awayTeam = teams.find(t => t.id === parseInt(awayTeamId)).name;
    
        if (matchId) {
            const match = matches.find(m => m.id === parseInt(matchId));
            match.fechaPartido = matchDate;
            match.equipoLocal = homeTeam;
            match.equipoVisitante = awayTeam;
        } else {
            matches.push({
                id: matches.length + 1,
                fechaPartido: matchDate,
                marcadorLocal: null, // Cambiar a null para que se renderice como `-.-`
                marcadorVisitante: null, // Cambiar a null para que se renderice como `-.-`
                equipoLocal: homeTeam,
                equipoVisitante: awayTeam,
            });
        }
    
        renderMatches();
        addEditMatchModal.classList.add('hidden');
    });
    
    cancelModalBtn.addEventListener('click', () => addEditMatchModal.classList.add('hidden'));
    cancelFinalizeBtn.addEventListener('click', () => finalizeMatchModal.classList.add('hidden'));
    addMatchBtn.addEventListener('click', () => {
        modalTitle.textContent = 'Add New Match';
        document.getElementById('editMatchId').value = '';
        document.getElementById('matchDate').value = '';
        populateDropdowns();
        addEditMatchModal.classList.remove('hidden');
    });

    renderMatches();
});
