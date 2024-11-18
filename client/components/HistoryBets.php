<?php
// Datos quemados
$apuestaHistoryInfo = [
    [
        "idApuesta" => 1,
        "equipoLocal" => "Equipo A",
        "equipoVisitante" => "Equipo B",
        "CantidadApostada" => 100,
        "prediccionEquipoLocal" => 2,
        "prediccionEquipoVisitante" => 1,
        "marcadorLocalFinal" => null,
        "marcadorVisitanteFinal" => null,
        "fecha" => "2024-11-20",
    ],
    [
        "idApuesta" => 2,
        "equipoLocal" => "Equipo C",
        "equipoVisitante" => "Equipo D",
        "CantidadApostada" => 150,
        "prediccionEquipoLocal" => 1,
        "prediccionEquipoVisitante" => 3,
        "marcadorLocalFinal" => 1,
        "marcadorVisitanteFinal" => 3,
        "fecha" => "2024-11-18",
    ],
];

// Sanitización
$apuestaHistoryInfo = array_map(function ($apuesta) {
    return [
        'idApuesta' => (int) $apuesta['idApuesta'],
        'equipoLocal' => htmlspecialchars($apuesta['equipoLocal'], ENT_QUOTES, 'UTF-8'),
        'equipoVisitante' => htmlspecialchars($apuesta['equipoVisitante'], ENT_QUOTES, 'UTF-8'),
        'CantidadApostada' => (float) $apuesta['CantidadApostada'],
        'prediccionEquipoLocal' => (int) $apuesta['prediccionEquipoLocal'],
        'prediccionEquipoVisitante' => (int) $apuesta['prediccionEquipoVisitante'],
        'marcadorLocalFinal' => isset($apuesta['marcadorLocalFinal']) ? (int) $apuesta['marcadorLocalFinal'] : null,
        'marcadorVisitanteFinal' => isset($apuesta['marcadorVisitanteFinal']) ? (int) $apuesta['marcadorVisitanteFinal'] : null,
        'fecha' => htmlspecialchars($apuesta['fecha'], ENT_QUOTES, 'UTF-8'),
    ];
}, $apuestaHistoryInfo);

// Filtrar apuestas
$activeBets = array_filter($apuestaHistoryInfo, fn($apuesta) => is_null($apuesta['marcadorLocalFinal']));
$historicalBets = array_filter($apuestaHistoryInfo, fn($apuesta) => !is_null($apuesta['marcadorLocalFinal']));
?>

<div class="py-5">
    <h1 class="text-xl font-medium my-4 text-center">Historial de apuestas</h1>
    <div class="space-y-4">

        <!-- Apuestas Activas -->
        <div class="bg-gray-800 rounded-lg">
            <div class="flex justify-between items-center p-3 bg-gray-700 cursor-pointer rounded-lg">
                <h2 class="text-lg font-semibold">Apuestas Activas</h2>
            </div>
            <div class="h-[30vh] overflow-y-scroll custom-scrollbar p-3 bg-gray-800 rounded-b-lg">
                <?php if (!empty($activeBets)): ?>
                    <?php foreach ($activeBets as $apuesta): ?>
                        <div class="flex flex-row justify-between items-center mb-2 rounded-lg">
                            <div class="text-center">
                                <p class="text-white font-bold"><?= htmlspecialchars($apuesta['equipoLocal']) ?></p>
                                <p class="text-sm text-gray-400">Predicción: <?= $apuesta['prediccionEquipoLocal'] ?></p>
                            </div>
                            <p class="font-bold text-xl">VS</p>
                            <div class="text-center">
                                <p class="text-white font-bold"><?= htmlspecialchars($apuesta['equipoVisitante']) ?></p>
                                <p class="text-sm text-gray-400">Predicción: <?= $apuesta['prediccionEquipoVisitante'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">No hay apuestas activas</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Apuestas Pasadas -->
        <div class="bg-gray-800 rounded-lg">
            <div class="flex justify-between items-center p-3 bg-gray-700 cursor-pointer rounded-lg">
                <h2 class="text-lg font-semibold">Apuestas Pasadas</h2>
            </div>
            <div class="h-[30vh] overflow-y-scroll custom-scrollbar bg-gray-800 rounded-b-lg">
                <?php if (!empty($historicalBets)): ?>
                    <?php foreach ($historicalBets as $apuesta): ?>
                        <?php
                        $correctPrediction = $apuesta['prediccionEquipoLocal'] === $apuesta['marcadorLocalFinal'] &&
                            $apuesta['prediccionEquipoVisitante'] === $apuesta['marcadorVisitanteFinal'];
                        $badgeColor = $correctPrediction ? "bg-green-500" : "bg-red-500";
                        $separator = $correctPrediction ? "+" : "-";
                        ?>
                        <div class="flex flex-row justify-between items-center gap-4 p-3">
                            <div class="text-center">
                                <p class="text-white font-bold"><?= htmlspecialchars($apuesta['equipoLocal']) ?></p>
                                <p class="text-sm text-gray-400">Marcador: <?= $apuesta['marcadorLocalFinal'] ?></p>
                            </div>
                            <p class="font-bold text-xl">VS</p>
                            <div class="text-center">
                                <p class="text-white font-bold"><?= htmlspecialchars($apuesta['equipoVisitante']) ?></p>
                                <p class="text-sm text-gray-400">Marcador: <?= $apuesta['marcadorVisitanteFinal'] ?></p>
                            </div>
                            <div class="badge <?= $badgeColor ?> text-white px-3 py-1 rounded-full">
                                <?= $separator . $apuesta['CantidadApostada'] ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">No hay apuestas pasadas</p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
