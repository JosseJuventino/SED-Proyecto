 <div class="bg-gray-800 p-4 rounded-lg shadow-lg my-4">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-bold text-white">
            <?= htmlspecialchars($partido['nombreEquipoLocal']) ?> vs <?= htmlspecialchars($partido['nombreEquipoVisitante']) ?>
        </h3>
        <p class="text-white">
            <?= date("d/m/Y", strtotime($partido['fechaPartido'])) ?>
        </p>
    </div>
    <div class="flex justify-between items-center mt-2">
        <p class="text-white">Local: <?= htmlspecialchars($partido['nombreEquipoLocal']) ?></p>
        <p class="text-white">Visitante: <?= htmlspecialchars($partido['nombreEquipoVisitante']) ?></p>
    </div>
</div>
