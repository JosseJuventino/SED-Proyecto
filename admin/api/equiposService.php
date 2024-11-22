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

    // Crear un nuevo equipo
    public function createEquipo($nombreEquipo, $representanteEquipo) {
        $data = [
            'userId' => $this->userId,
            'nombreEquipo' => $nombreEquipo,
            'representanteEquipo' => $representanteEquipo,
            'token' => $this->authToken // Incluir el token aquí
        ];

        return $this->post('/equipo', $data);
    }

    // Actualizar los detalles de un equipo
    public function updateEquipo($idEquipo, $nombreEquipo, $representanteEquipo) {
        $data = [
            'userId' => $this->userId,
            'nombreEquipo' => $nombreEquipo,
            'representanteEquipo' => $representanteEquipo,
            'token' => $this->authToken // Incluir el token aquí
        ];

        return $this->post("/equipo/{$idEquipo}", $data); // Simular PUT con POST
    }

    // Obtener un equipo por su ID
    public function getEquipoById($idEquipo) {
        $data = [
            'token' => $this->authToken // Incluir el token aquí
        ];

        return $this->get("/equipo/{$idEquipo}", $data);
    }

    // Obtener todos los equipos
    public function getAllEquipos() {
        $data = [
            'token' => $this->authToken // Incluir el token aquí
        ];

        return $this->get('/equipo', $data);
    }

    // Eliminar un equipo
    public function deleteEquipo($idEquipo) {
        $data = [
            'token' => $this->authToken, // Incluir el token aquí
            '_method' => 'DELETE' // Simular DELETE con POST si la API lo permite
        ];

        return $this->post("/equipo/{$idEquipo}", $data);
    }
}
