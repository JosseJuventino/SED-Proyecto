<div>
    <?php
    $partido = [
        "idPartido" => 1,
        "idEquipoLocal" => 1,
        "idEquipoVisitante" => 2,
        "fechaPartido" => "2024-11-20",
        "equipoLocal" => [
            "nombre" => "Equipo Local",
            "representante" => "Representante Local",
            "fechaFundacion" => "2000",
            "imagen" => "https://upload.wikimedia.org/wikipedia/en/thumb/a/a7/Paris_Saint-Germain_F.C..svg/1200px-Paris_Saint-Germain_F.C..svg.png",
        ],
        "equipoVisitante" => [
            "nombre" => "Equipo Visitante",
            "representante" => "Representante Visitante",
            "fechaFundacion" => "2005",
            "imagen" => "https://upload.wikimedia.org/wikipedia/en/thumb/5/56/Real_Madrid_CF.svg/1200px-Real_Madrid_CF.svg.png",
        ],
    ];

    // Sanitizar datos
    $partido = [
        "idPartido" => (int) $partido["idPartido"],
        "idEquipoLocal" => (int) $partido["idEquipoLocal"],
        "idEquipoVisitante" => (int) $partido["idEquipoVisitante"],
        "fechaPartido" => htmlspecialchars($partido["fechaPartido"], ENT_QUOTES, "UTF-8"),
        "equipoLocal" => [
            "nombre" => htmlspecialchars($partido["equipoLocal"]["nombre"], ENT_QUOTES, "UTF-8"),
            "representante" => htmlspecialchars($partido["equipoLocal"]["representante"], ENT_QUOTES, "UTF-8"),
            "fechaFundacion" => htmlspecialchars($partido["equipoLocal"]["fechaFundacion"], ENT_QUOTES, "UTF-8"),
            "imagen" => filter_var($partido["equipoLocal"]["imagen"], FILTER_SANITIZE_URL),
        ],
        "equipoVisitante" => [
            "nombre" => htmlspecialchars($partido["equipoVisitante"]["nombre"], ENT_QUOTES, "UTF-8"),
            "representante" => htmlspecialchars($partido["equipoVisitante"]["representante"], ENT_QUOTES, "UTF-8"),
            "fechaFundacion" => htmlspecialchars($partido["equipoVisitante"]["fechaFundacion"], ENT_QUOTES, "UTF-8"),
            "imagen" => filter_var($partido["equipoVisitante"]["imagen"], FILTER_SANITIZE_URL),
        ],
    ];

    try {
        $fechaPartido = new DateTime($partido['fechaPartido']);
        $fechaPartidoFormateada = $fechaPartido->format('d/m/Y');
    } catch (Exception $e) {
        $fechaPartidoFormateada = "Fecha no válida";
    }

    $proximosPartidos = [
        [
            "nombreEquipoLocal" => "Equipo A",
            "nombreEquipoVisitante" => "Equipo B",
            "fechaPartido" => "2024-11-22",
        ],
        [
            "nombreEquipoLocal" => "Equipo C",
            "nombreEquipoVisitante" => "Equipo D",
            "fechaPartido" => "2024-11-23",
        ],
    ];
    ?>

    <div class="w-full">
        <h2 class="text-xl font-bold text-white">Partido actual</h2>

        <div class="mt-5">
            <div class="relative w-full h-full bg-cover bg-center rounded-xl shadow-lg"
                style="background-image: url('https://e00-elmundo.uecdn.es/assets/multimedia/imagenes/2021/06/24/16245558914634.jpg')">
                <div class="absolute inset-0 bg-gray-900 bg-opacity-80 rounded-xl"></div>
                <div class="relative z-10 flex flex-col justify-between h-full p-5 text-white">
                    <div class="flex flex-row justify-between items-center">
                        <!-- Equipo Local -->
                        <div class="flex flex-col text-center items-center justify-center">
                            <img class="h-16 w-16 object-contain" src="<?= $partido['equipoLocal']['imagen'] ?>"
                                alt="Equipo Local">
                            <p class="text-sm font-bold"><?= $partido['equipoLocal']['nombre'] ?></p>
                        </div>

                        <p class="font-bold text-xl">VS</p>

                        <!-- Equipo Visitante -->
                        <div class="flex flex-col text-center items-center justify-center">
                            <img class="h-16 w-16 object-contain" src="<?= $partido['equipoVisitante']['imagen'] ?>"
                                alt="Equipo Visitante">
                            <p class="text-sm font-bold"><?= $partido['equipoVisitante']['nombre'] ?></p>
                        </div>
                    </div>

                    <!-- Detalles del partido -->
                    <div class="mt-5 text-center">
                        <p class="flex flex-row items-center justify-center gap-2 text-lg">
                            📅 <?= $fechaPartidoFormateada ?>
                        </p>
                        <h2 class="text-3xl font-bold mt-2">
                            <?= $partido['equipoLocal']['nombre'] ?> vs <?= $partido['equipoVisitante']['nombre'] ?>
                        </h2>
                        <p class="mt-2 text-lg">Place a bet on this match today, get instant cashback and participate in
                            various raffles.</p>
                    </div>

                    <!-- Botón para apostar -->
                    <div class="w-full mt-5 flex justify-center">
                        <button id="openPopup"
                            class="w-full max-w-xs bg-gray-800 hover:bg-gray-700 transition-all duration-500 py-3 rounded-xl text-lg font-semibold">
                            Apostar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="text-xl font-bold text-white mt-10">Partidos próximos</h2>
        <div class="mt-5">
            <?php foreach ($proximosPartidos as $matches): ?>
                <div class="bg-gray-800 p-4 rounded-lg shadow-lg my-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white">
                            <?= htmlspecialchars($matches['nombreEquipoLocal']) ?> vs
                            <?= htmlspecialchars($matches['nombreEquipoVisitante']) ?>
                        </h3>
                        <p class="text-white">
                            <?= date("d/m/Y", strtotime($matches['fechaPartido'])) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Overlay and Pop-Up -->
<div id="overlay" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 hidden"></div>
<div id="popup"
    class="fixed top-1/2 z-20 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-gray-800 p-8 rounded-xl hidden shadow-lg">
    <button id="closePopup" class="absolute top-2 right-2 text-white">✖</button>
    <p class="text-center text-lg">Predice el resultado del partido</p>
    <div class="flex flex-row justify-around items-center mt-5">
        <!-- Equipo Local -->
        <div class="flex flex-col justify-center items-center">
            <img class="w-14 h-14 object-cover" src="<?= $partido['equipoLocal']['imagen']; ?>" alt="Equipo Local">
            <p class="font-bold"><?= $partido['equipoLocal']['nombre']; ?></p>
            <div
                class="bg-slate-700 mt-5 h-14 w-14 border-4 rounded-xl border-slate-500 flex items-center justify-center">
                <input type="number" id="predictionLocal" value="0"
                    class="text-center font-bold text-[25px] bg-transparent text-white w-full h-full outline-none appearance-none">
            </div>
        </div>

        <h2 class="font-bold">VS</h2>

        <!-- Equipo Visitante -->
        <div class="flex flex-col justify-center items-center">
            <img class="w-14 h-14 object-cover" src="<?= $partido['equipoVisitante']['imagen']; ?>"
                alt="Equipo Visitante">
            <p class="font-bold"><?= $partido['equipoVisitante']['nombre']; ?></p>
            <div
                class="bg-slate-700 mt-5 h-14 w-14 border-4 rounded-xl border-slate-500 flex items-center justify-center">
                <input type="number" id="predictionVisitante" value="0"
                    class="text-center font-bold text-[25px] bg-transparent text-white w-full h-full outline-none appearance-none">
            </div>
        </div>
    </div>
    <div class="flex flex-col items-start gap-1 mx-5 mt-5">
        <h2 class="font-bold">Cantidad a apostar:</h2>
        <div class="bg-slate-700 border-4 rounded-xl border-slate-500 flex items-center justify-center">
            <input id="betQuantity" type="number"
                class="px-4 font-bold text-[25px] bg-transparent text-white w-full h-full outline-none appearance-none"
                placeholder="0">
        </div>
    </div>
    <div class="flex flex-row w-full mt-5">
        <button id="placeBet"
            class="bg-slate-700 w-full py-3 hover:bg-slate-600 transition-colors duration-200 rounded-xl">Apostar</button>
    </div>
</div>


<script src="/public/js/openPopupBet.js" defer></script>