<main class="flex-1 p-0">
    <header class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold">Bet Management</h1>
        <button id="addBetBtn" class="px-4 py-2 bg-success text-white rounded-md font-medium">Add New Bet</button>
    </header>

    <!-- Bets Table -->
    <div class="bg-primary rounded-lg overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-secondary">
                    <th class="text-left p-4 font-medium text-gray-400">User</th>
                    <th class="text-left p-4 font-medium text-gray-400">Match</th>
                    <th class="text-left p-4 font-medium text-gray-400">Amount</th>
                    <th class="text-left p-4 font-medium text-gray-400">State</th>
                </tr>
            </thead>
            <tbody id="betsTableBody">
                <!-- Rows generated dynamically -->
            </tbody>
        </table>
    </div>
</main>

<!-- Add/Edit Bet Modal -->
<div id="addEditBetModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-primary p-8 rounded-lg w-full max-w-md">
        <h2 id="betModalTitle" class="text-2xl font-bold mb-4">Add/Edit Bet</h2>
        <form id="addEditBetForm">
            <input type="hidden" id="editBetId">
            <div class="mb-4">
                <label for="betUser" class="block text-sm font-medium text-gray-400 mb-2">User</label>
                <select id="betUser" name="betUser" required
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
                    <!-- Options dynamically loaded -->
                </select>
            </div>
            <div class="mb-4">
                <label for="betMatch" class="block text-sm font-medium text-gray-400 mb-2">Match</label>
                <select id="betMatch" name="betMatch" required
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
                    <!-- Options dynamically loaded -->
                </select>
            </div>
            <div class="mb-4">
                <label for="betAmount" class="block text-sm font-medium text-gray-400 mb-2">Amount</label>
                <input type="number" id="betAmount" name="betAmount" required min="1"
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
            </div>
            <div class="mb-4">
                <label for="betState" class="block text-sm font-medium text-gray-400 mb-2">State</label>
                <select id="betState" name="betState" required
                    class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground">
                    <option value="pendiente">Pending</option>
                    <option value="ganada">Won</option>
                    <option value="perdida">Lost</option>
                </select>
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="px-4 py-2 bg-accent text-white rounded-md cancel-bet-btn">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-success text-white rounded-md">Save</button>
            </div>
        </form>
    </div>
</div>

<script src="/public/js/renderbet.js"></script>