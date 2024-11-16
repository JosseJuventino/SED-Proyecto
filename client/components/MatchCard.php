 <div class="bg-gray-800 p-4 rounded-lg shadow-lg my-4">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-bold text-white">
            <?= htmlspecialchars($matches['nombreEquipoLocal']) ?> vs <?= htmlspecialchars($matches['nombreEquipoVisitante']) ?>
        </h3>
        <p class="text-white">
            <?= date("d/m/Y", strtotime($matches['fechaPartido'])) ?>
        </p>
    </div>
    <div class="flex justify-between items-center mt-2">
        <p class="text-white">Local: <?= htmlspecialchars($matches['nombreEquipoLocal']) ?></p>
        <p class="text-white">Visitante: <?= htmlspecialchars($matches['nombreEquipoVisitante']) ?></p>
    </div>
</div>
