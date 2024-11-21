<?php
// Datos de ejemplo para equipos
$teams = [
    [
        "name" => "Paris Saint-Germain",
        "founded" => 1970,
        "captain" => "Marquinhos",
        "stadium" => "Parc des Princes",
        "league" => "Ligue 1",
        "logo" => "https://via.placeholder.com/100",
    ],
    [
        "name" => "Real Madrid",
        "founded" => 1902,
        "captain" => "Nacho",
        "stadium" => "Santiago Bernabéu",
        "league" => "La Liga",
        "logo" => "https://via.placeholder.com/100",
    ],
    [
        "name" => "Manchester City",
        "founded" => 1880,
        "captain" => "Kyle Walker",
        "stadium" => "Etihad Stadium",
        "league" => "Premier League",
        "logo" => "https://via.placeholder.com/100",
    ],
];

// Sanitización de datos
$teams = array_map(function ($team) {
    return [
        "name" => htmlspecialchars($team["name"], ENT_QUOTES, "UTF-8"),
        "founded" => (int)$team["founded"],
        "captain" => htmlspecialchars($team["captain"], ENT_QUOTES, "UTF-8"),
        "stadium" => htmlspecialchars($team["stadium"], ENT_QUOTES, "UTF-8"),
        "league" => htmlspecialchars($team["league"], ENT_QUOTES, "UTF-8"),
        "logo" => filter_var($team["logo"], FILTER_VALIDATE_URL) ? $team["logo"] : "https://via.placeholder.com/100",
    ];
}, $teams);

?>

<div class="max-w-6xl mx-auto space-y-8">
    <!-- Search Section -->
    <div class="flex gap-4 items-center">
    <form action="searchTeams.php" method="POST" class="flex gap-4 w-full">
        <input 
            type="text" 
            name="searchTerm" 
            placeholder="Search teams..." 
            class="flex-1 bg-[#1E293B] border-[#1E293B] text-white placeholder-[#94A3B8] p-3 rounded" 
            required
        >
        <button 
            type="submit" 
            class="bg-[#1E40AF] hover:bg-[#1E40AF]/90 text-white px-4 py-2 rounded flex items-center"
        >
            Search
        </button>
    </form>
</div>


    <!-- Teams Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="teamsGrid">
        <?php foreach ($teams as $team): ?>
            <div class="bg-[#1E293B] border-[#1E293B] text-white rounded-lg overflow-hidden">
                <div class="flex items-center justify-center p-6">
                    <img src="<?= $team['logo'] ?>" alt="<?= $team['name'] ?> Logo" class="rounded-full">
                </div>
                <div class="p-6 space-y-4">
                    <div class="text-center">
                        <h3 class="text-xl font-bold"><?= $team['name'] ?></h3>
                        <p class="text-[#94A3B8]">Founded: <?= $team['founded'] ?></p>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-[#94A3B8]">Captain:</span>
                            <span><?= $team['captain'] ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[#94A3B8]">Stadium:</span>
                            <span><?= $team['stadium'] ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[#94A3B8]">League:</span>
                            <span><?= $team['league'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

