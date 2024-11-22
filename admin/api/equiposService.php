<?php
require_once 'ApiService.php';

class EquipoService extends ApiService {
    private $userId;
    private $authToken;

    public function __construct($apiUrl, $userId) {
        parent::__construct($apiUrl); // Llamar al constructor de ApiService
        $this->userId = $userId;
        $this->authToken = $_SESSION['auth_token'] ?? null;

        if (!$this->authToken) {
            throw new Exception("Error: No se encontró el token de autenticación en la sesión.");
        }
    }

    public function createEquipo($nombreEquipo, $representanteEquipo) {
        $data = [
            'userId' => $this->userId, // ID del usuario logueado
            'nombreEquipo' => $nombreEquipo,
            'representanteEquipo' => $representanteEquipo,
        ];

        // Encabezados con el token
        $headers = [
            "Authorization: Bearer {$this->authToken}", // Token de autenticación
        ];

        // Realizar la solicitud POST
        $response = $this->post('/equipo', $data, $headers);

        // Mostrar la respuesta en consola
        error_log("[CREATE EQUIPO RESPONSE] " . json_encode($response, JSON_PRETTY_PRINT));

        return $response;
    }

    public function updateEquipo($idEquipo, $nombreEquipo, $representanteEquipo) {
        $data = [
            'userId' => $this->userId,
            'nombreEquipo' => $nombreEquipo,
            'representanteEquipo' => $representanteEquipo,
        ];

        // Encabezados con el token
        $headers = [
            "Authorization: Bearer {$this->authToken}", // Token de autenticación
        ];

        $response = $this->post("/equipo/{$idEquipo}", $data, $headers);

        // Mostrar la respuesta en consola
        error_log("[UPDATE EQUIPO RESPONSE] " . json_encode($response, JSON_PRETTY_PRINT));

        return $response;
    }

    public function getAllEquipos() {
        // Encabezados con el token
        $headers = [
            "Authorization: Bearer {$this->authToken}", // Token de autenticación
        ];

        $response = $this->get('/equipo', ['token' => $this->authToken], $headers);

        // Mostrar la respuesta en consola
        error_log("[GET ALL EQUIPOS RESPONSE] " . json_encode($response, JSON_PRETTY_PRINT));

        return $response;
    }

    public function getEquipoById($idEquipo) {
        // Encabezados con el token
        $headers = [
            "Authorization: Bearer {$this->authToken}", // Token de autenticación
        ];

        $response = $this->get("/equipo/{$idEquipo}", ['token' => $this->authToken], $headers);

        // Mostrar la respuesta en consola
        error_log("[GET EQUIPO BY ID RESPONSE] " . json_encode($response, JSON_PRETTY_PRINT));

        return $response;
    }

    public function deleteEquipo($idEquipo) {
        $data = [
            '_method' => 'DELETE', // Simular DELETE con POST
        ];

        // Encabezados con el token
        $headers = [
            "Authorization: Bearer {$this->authToken}", // Token de autenticación
        ];

        $response = $this->post("/equipo/{$idEquipo}", $data, $headers);

        // Mostrar la respuesta en consola
        error_log("[DELETE EQUIPO RESPONSE] " . json_encode($response, JSON_PRETTY_PRINT));

        return $response;
    }
}
