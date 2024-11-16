
<aside class="w-64 bg-primary p-6 border-r border-accent">
    <div class="text-2xl font-bold mb-8">BetApp Admin</div>
    <nav>
        <a href="?page=dashboard" class="block py-2 px-4 rounded hover:bg-secondary mb-2 <?php echo ($currentPage == 'dashboard') ? 'bg-secondary' : ''; ?>">Dashboard</a>
        <a href="?page=matches" class="block py-2 px-4 rounded hover:bg-secondary mb-2 <?php echo ($currentPage == 'matches') ? 'bg-secondary' : ''; ?>">Matches</a>
        <a href="?page=teams" class="block py-2 px-4 rounded hover:bg-secondary mb-2 <?php echo ($currentPage == 'teams') ? 'bg-secondary' : ''; ?>">Teams</a>
        <a href="?page=users" class="block py-2 px-4 rounded hover:bg-secondary mb-2 <?php echo ($currentPage == 'users') ? 'bg-secondary' : ''; ?>">Users</a>
        <a href="?page=bets" class="block py-2 px-4 rounded hover:bg-secondary mb-2 <?php echo ($currentPage == 'bets') ? 'bg-secondary' : ''; ?>">Bets</a>
        <a href="?page=settings" class="block py-2 px-4 rounded hover:bg-secondary mb-2 <?php echo ($currentPage == 'settings') ? 'bg-secondary' : ''; ?>">Settings</a>
    </nav>
</aside>
