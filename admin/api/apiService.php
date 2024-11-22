<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Carga Dotenv
use Dotenv\Dotenv;

class ApiService {
    private $baseUrl;

    public function __construct() {
        // Intentar cargar el archivo .env
        try {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
            $dotenv->load();
        } catch (Exception $e) {
            throw new Exception("Error al cargar Dotenv: " . $e->getMessage());
        }

        // Obtener la URL base de la API desde las variables de entorno
        $this->baseUrl = trim(getenv('API_BASE_URL') ?: ($_ENV['API_BASE_URL'] ?? null));

        // Validar que sea una URL válida
        if (!$this->baseUrl || !filter_var($this->baseUrl, FILTER_VALIDATE_URL)) {
            throw new Exception("La URL base de la API no es válida: " . htmlspecialchars($this->baseUrl));
        }
    }

    /**
     * Realiza una solicitud POST a la API
     *
     * @param string $endpoint Ruta relativa al endpoint
     * @param array $data Datos que se enviarán en el cuerpo de la solicitud
     * @return array Respuesta de la API
     */
    public function post($endpoint, $data) {
        $url = $this->baseUrl . $endpoint;

        // Validar que la URL del endpoint sea válida
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception("El endpoint proporcionado no es válido: " . htmlspecialchars($url));
        }

        // Inicializar cURL
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Manejar errores de cURL
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);

            return [
                'error' => true,
                'message' => "Error cURL: $error",
            ];
        }

        curl_close($ch);

        // Decodificar la respuesta JSON
        $decodedResponse = json_decode($response, true);

        // Validar que la respuesta sea un JSON válido
        if ($decodedResponse === null && json_last_error() !== JSON_ERROR_NONE) {
            return [
                'error' => true,
                'status' => $httpCode,
                'message' => 'La respuesta no es un JSON válido.',
            ];
        }

        // Manejar errores HTTP
        if ($httpCode >= 400) {
            return [
                'error' => true,
                'status' => $httpCode,
                'message' => $decodedResponse['message'] ?? 'Error desconocido',
            ];
        }

        return $decodedResponse;
    }

    /**
     * Realiza una solicitud GET a la API
     *
     * @param string $endpoint Ruta relativa al endpoint
     * @return array Respuesta de la API
     */
    protected function get($endpoint, $data = []) {
    $url = $this->baseUrl . $endpoint;

    // Validar que la URL sea válida
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        throw new Exception("El endpoint proporcionado no es válido: " . htmlspecialchars($url));
    }

    // Preparar los headers
    $headers = [
        'Content-Type: application/json',
    ];

    if (isset($data['token'])) {
        $headers[] = 'Authorization: Bearer ' . $data['token']; // Bearer token
        unset($data['token']); // Eliminar el token del cuerpo
    }

    // Inicializar cURL
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPGET => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_CUSTOMREQUEST => 'GET', // Forzar el método GET
        CURLOPT_POSTFIELDS => json_encode($data), // Incluir el cuerpo en JSON
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_SSL_VERIFYPEER => true,
    ]);

    // Ejecutar la solicitud
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Manejar errores de cURL
    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);

        return [
            'error' => true,
            'message' => "Error cURL: $error",
        ];
    }

    curl_close($ch);

    // Decodificar la respuesta JSON
    $decodedResponse = json_decode($response, true);

    if ($decodedResponse === null && json_last_error() !== JSON_ERROR_NONE) {
        return [
            'error' => true,
            'status' => $httpCode,
            'message' => 'La respuesta no es un JSON válido.',
        ];
    }

    // Manejar errores HTTP
    if ($httpCode >= 400) {
        return [
            'error' => true,
            'status' => $httpCode,
            'message' => $decodedResponse['message'] ?? 'Error desconocido',
        ];
    }

    return $decodedResponse;
}

}
