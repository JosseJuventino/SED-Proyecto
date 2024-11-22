<?php
require_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;

try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    echo "Archivo .env cargado correctamente.\n";
} catch (Exception $e) {
    echo "Error al cargar el archivo .env: " . $e->getMessage() . "\n";
}

// Verificar si API_BASE_URL está disponible
echo "API_BASE_URL (getenv): " . getenv('API_BASE_URL') . "\n";
echo "API_BASE_URL (\$_ENV): " . ($_ENV['API_BASE_URL'] ?? 'No disponible') . "\n";
echo "API_BASE_URL (\$_SERVER): " . ($_SERVER['API_BASE_URL'] ?? 'No disponible') . "\n";

// Mostrar todas las variables de entorno cargadas
print_r($_ENV);
