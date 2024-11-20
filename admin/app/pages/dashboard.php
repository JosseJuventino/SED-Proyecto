
<div>
    <main class="flex-1 p-0">
        <!-- Header -->
        <header class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <div class="flex items-center gap-4">
                <div class="bg-primary px-4 py-2 rounded">Balance: $10,450</div>
                <div>Admin</div>
            </div>
        </header>

        <!-- Dashboard Summary -->
        <section id="dashboard" class="mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-primary rounded-lg p-6">
                    <h3 class="text-sm text-gray-400 mb-2">Total Users</h3>
                    <div class="text-3xl font-bold">15,234</div>
                </div>
                <div class="bg-primary rounded-lg p-6">
                    <h3 class="text-sm text-gray-400 mb-2">Active Bets</h3>
                    <div class="text-3xl font-bold">1,876</div>
                </div>
                <div class="bg-primary rounded-lg p-6">
                    <h3 class="text-sm text-gray-400 mb-2">Total Matches</h3>
                    <div class="text-3xl font-bold">342</div>
                </div>
                <div class="bg-primary rounded-lg p-6">
                    <h3 class="text-sm text-gray-400 mb-2">Revenue (30 days)</h3>
                    <div class="text-3xl font-bold">$89,450</div>
                </div>
            </div>

            <div class="bg-primary rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4">Recent Activity</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-accent">
                        <div>New user registered</div>
                        <div class="text-sm text-gray-400">2 minutes ago</div>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-accent">
                        <div>Match PSG vs Real Madrid updated</div>
                        <div class="text-sm text-gray-400">15 minutes ago</div>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-accent">
                        <div>Large bet placed on Manchester City vs Barcelona</div>
                        <div class="text-sm text-gray-400">1 hour ago</div>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <div>New match added: Bayern Munich vs Inter Milan</div>
                        <div class="text-sm text-gray-400">2 hours ago</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Match Management -->
        <section id="matches" class="mb-12">
            
            <div class="bg-primary rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="bg-secondary">
                            <th class="text-left p-4 font-medium text-gray-400">Match ID</th>
                            <th class="text-left p-4 font-medium text-gray-400">Teams</th>
                            <th class="text-left p-4 font-medium text-gray-400">Date</th>
                            <th class="text-left p-4 font-medium text-gray-400">Status</th>
                            <th class="text-left p-4 font-medium text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-accent">
                            <td class="p-4">#1234</td>
                            <td class="p-4">PSG vs Real Madrid</td>
                            <td class="p-4">20/11/2024</td>
                            <td class="p-4"><span class="px-2 py-1 bg-success text-white rounded-full text-xs">Active</span></td>
                            <td class="p-4"><button class="px-3 py-1 bg-accent text-white rounded-md text-sm">Edit</button></td>
                        </tr>
                        <tr class="border-b border-accent">
                            <td class="p-4">#1235</td>
                            <td class="p-4">Manchester City vs Barcelona</td>
                            <td class="p-4">22/11/2024</td>
                            <td class="p-4"><span class="px-2 py-1 bg-yellow-500 text-white rounded-full text-xs">Pending</span></td>
                            <td class="p-4"><button class="px-3 py-1 bg-accent text-white rounded-md text-sm">Edit</button></td>
                        </tr>
                        <tr>
                            <td class="p-4">#1236</td>
                            <td class="p-4">Bayern Munich vs Inter Milan</td>
                            <td class="p-4">23/11/2024</td>
                            <td class="p-4"><span class="px-2 py-1 bg-yellow-500 text-white rounded-full text-xs">Pending</span></td>
                            <td class="p-4"><button class="px-3 py-1 bg-accent text-white rounded-md text-sm">Edit</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>