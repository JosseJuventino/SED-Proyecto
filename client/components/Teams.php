<?php
// Incluir dependencias necesarias
require_once __DIR__ . './../app/dashboard/teams/searchTeams.php';
// Instanciar el servicio de equipos
$apiUrl = getenv('API_BASE_URL') ?: ($_ENV['API_BASE_URL'] ?? null);
$userId = $_SESSION['user_id'];
$equipoService = new EquipoService($apiUrl, $userId);

// Archivo de log para depuración
$logFile = __DIR__ . '/../../error.log';
$equipos = [];
if(isset($_SESSION['searchTerm'])) {
    try {
        $equipos = $equipoService->getEquipoById();
        file_put_contents($logFile, "Respuesta de getAllEquipos:\n" . print_r($equipos, true), FILE_APPEND);
    
        if (!is_array($equipos)) {
            throw new Exception("La API devolvió una respuesta no válida.");
        }
    } catch (Exception $e) {
        $equipos = [];
        $error = $e->getMessage();
        file_put_contents($logFile, "Error al obtener equipos: $error\n", FILE_APPEND);
    }
} else {
    $equipos = $equipoService->getAllEquipos();
}
?>

<div class="max-w-6xl mx-auto space-y-8">
    <!-- Search Section -->
    <?php
    // Verificar si hay errores en la sesión
    if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error:</strong>
            <ul class="mt-2 ml-4 list-disc">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
            <button class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-700 focus:outline-none"
                onclick="this.parentElement.style.display='none';">
                ✖
            </button>
        </div>
        <?php
        // Limpiar los errores después de mostrarlos
        unset($_SESSION['errors']);
        ?>
    <?php endif; ?>
    <div class="flex gap-4 items-center">
        <form action="searchTeams.php" method="POST" class="flex gap-4 w-full">
            <input
                type="text"
                name="searchTerm"
                placeholder="Search teams..."
                class="flex-1 bg-[#1E293B] border-[#1E293B] text-white placeholder-[#94A3B8] p-3 rounded"
                required>
            <button
                type="submit"
                class="bg-[#1E40AF] hover:bg-[#1E40AF]/90 text-white px-4 py-2 rounded flex items-center">
                Search
            </button>
        </form>
    </div>


    <!-- Teams Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="teamsGrid">
        <?php foreach ($equipos as $team): echo $team;?>
            
            <div class="bg-[#1E293B] border-[#1E293B] text-white rounded-lg overflow-hidden">
                <div class="flex items-center justify-center p-6">
                    <img src="<?= $team['logo'] ?>" alt="<?= $team['nombreequipo'] ?> Logo" class="rounded-full">
                </div>
                <div class="p-6 space-y-4">
                    <div class="text-center">
                        <h3 class="text-xl font-bold"><?= $team['nombreequipo'] ?></h3>
                        <p class="text-[#94A3B8]">Founded: <?= $team['fechafundacion'] ?></p>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-[#94A3B8]">Captain:</span>
                            <span><?= $team['representanteequipo'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>