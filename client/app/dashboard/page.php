<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../public/css/tailwind.css">
</head>
<body class="bg-black text-white mx-10 my-5">
     <?php include '../../components/header.php'; ?>

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
                "imagen" => "https://upload.wikimedia.org/wikipedia/en/thumb/a/a7/Paris_Saint-Germain_F.C..svg/1200px-Paris_Saint-Germain_F.C..svg.png"
            ],
            "equipoVisitante" => [
                "nombre" => "Equipo Visitante",
                "representante" => "Representante Visitante",
                "fechaFundacion" => "2005",
                "imagen" => "https://upload.wikimedia.org/wikipedia/en/thumb/5/56/Real_Madrid_CF.svg/1200px-Real_Madrid_CF.svg.png"
            ]
        ];
    ?>

            <?php
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

    <main class="flex flex-col lg:flex-row items-start my-5 gap-10">
        <div class="w-full">
            <h2 class="text-xl font-bold text-white">Partido actual</h2>

            <div class="mt-5">
                <div class="relative w-full h-full bg-cover bg-center rounded-xl shadow-lg" style="background-image: url('https://e00-elmundo.uecdn.es/assets/multimedia/imagenes/2021/06/24/16245558914634.jpg')">
                    <div class="absolute inset-0 bg-gray-900 bg-opacity-80 rounded-xl"></div>
                    <div class="relative z-10 flex flex-col justify-between h-full p-5 text-white">
                        <div class="flex flex-row justify-between items-center">
                            <!-- Equipo Local -->
                            <div class="flex flex-col text-center items-center justify-center">
                                <img class="h-16 w-16 object-contain" src="<?= $partido['equipoLocal']['imagen'] ?>" alt="Equipo Local">
                                <p class="text-sm font-bold"><?= $partido['equipoLocal']['nombre'] ?></p>
                            </div>

                            <p class="font-bold text-xl">VS</p>

                            <!-- Equipo Visitante -->
                            <div class="flex flex-col text-center items-center justify-center">
                                <img class="h-16 w-16 object-contain" src="<?= $partido['equipoVisitante']['imagen'] ?>" alt="Equipo Visitante">
                                <p class="text-sm font-bold"><?= $partido['equipoVisitante']['nombre'] ?></p>
                            </div>
                        </div>

                        <!-- Detalles del partido -->
                        <div class="mt-5 text-center">
                            <p class="flex flex-row items-center justify-center gap-2 text-lg">
                                📅 <?= date("d/m/Y", strtotime($partido['fechaPartido'])) ?>
                            </p>
                            <h2 class="text-3xl font-bold mt-2">
                                <?= $partido['equipoLocal']['nombre'] ?> vs <?= $partido['equipoVisitante']['nombre'] ?>
                            </h2>
                            <p class="mt-2 text-lg">Place a bet on this match today, get instant cashback and participate in various raffles.</p>
                        </div>

                        <!-- Botón para apostar -->
                        <div class="w-full mt-5 flex justify-center">
                            <button id="openPopup" class="w-full max-w-xs bg-gray-800 hover:bg-gray-700 transition-all duration-500 py-3 rounded-xl text-lg font-semibold">
                                Apostar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="text-xl font-bold text-white mt-10">Partidos próximos</h2>
            <div class="mt-5">
                <?php foreach ($proximosPartidos as $partido): ?>
                        <?php include '../../components/MatchCard.php'; ?>
                <?php endforeach; ?>
            </div>

        </div>
    </main>

    <!-- Overlay and Pop-Up -->
    <div id="overlay" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 hidden"></div>
    <div id="popup" class="fixed top-1/2 z-20 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-gray-800 p-8 rounded-xl hidden shadow-lg">
        <button id="closePopup" class="absolute top-2 right-2 text-white">✖</button>
        <p class="text-center text-lg">Predice el resultado del partido</p>
        <div class="flex flex-row justify-around items-center mt-5">
            <!-- Equipo Local -->
            <div class="flex flex-col justify-center items-center">
                <img class="w-14 h-22 object-fill" src="<?= $partido['equipoLocal']['imagen']; ?>" alt="Local">
                <p class="font-bold"><?= $partido['equipoLocal']['nombre']; ?></p>
                <div class="bg-slate-700 mt-5 h-14 w-14 border-4 rounded-xl border-slate-500 flex items-center justify-center">
                    <input type="number" id="predictionLocal" value="0" class="text-center font-bold text-[25px] bg-transparent text-white w-full h-full outline-none appearance-none">
                </div>
            </div>

            <h2 class="font-bold">VS</h2>

            <!-- Equipo Visitante -->
            <div class="flex flex-col justify-center items-center">
                <img class="w-14 h-14 object-cover" src="<?= $partido['equipoVisitante']['imagen']; ?>" alt="Visitante">
                <p class="font-bold"><?= $partido['equipoVisitante']['nombre']; ?></p>
                <div class="bg-slate-700 mt-5 h-14 w-14 border-4 rounded-xl border-slate-500 flex items-center justify-center">
                    <input type="number" id="predictionVisitante" value="0" class="text-center font-bold text-[25px] bg-transparent text-white w-full h-full outline-none appearance-none">
                </div>
            </div>
        </div>
        <div class="flex flex-col items-start gap-1 mx-5 mt-5">
            <h2 class="font-bold">Cantidad a apostar:</h2>
            <div class="bg-slate-700 border-4 rounded-xl border-slate-500 flex items-center justify-center">
                <input id="betQuantity" type="number" class="px-4 font-bold text-[25px] bg-transparent text-white w-full h-full outline-none appearance-none" placeholder="0">
            </div>
        </div>
        <div class="flex flex-row w-full mt-5">
            <button id="placeBet" class="bg-slate-700 w-full py-3 hover:bg-slate-600 transition-colors duration-200 rounded-xl">Apostar</button>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const overlay = document.getElementById('overlay');
            const popup = document.getElementById('popup');
            const openPopup = document.getElementById('openPopup');
            const closePopup = document.getElementById('closePopup');

            openPopup.addEventListener('click', () => {
                overlay.classList.remove('hidden');
                popup.classList.remove('hidden');
            });

            closePopup.addEventListener('click', () => {
                overlay.classList.add('hidden');
                popup.classList.add('hidden');
            });
        });
    </script>
</body>
</html>
