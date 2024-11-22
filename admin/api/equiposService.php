<?php

require_once 'ApiService.php';

class EquipoService extends ApiService {
    
    private $userId;

    public function __construct($apiUrl, $userId) {
        parent::__construct($apiUrl); // Llamar al constructor de ApiService
        $this->userId = $userId;
    }

    // Crear un nuevo equipo
    public function createEquipo($nombreEquipo, $representanteEquipo) {
        $data = [
            'userId' => $this->userId,
            'nombreEquipo' => $nombreEquipo,
            'representanteEquipo' => $representanteEquipo
        ];

        return $this->sendRequest('/equipo', 'POST', $data);
    }

    // Actualizar los detalles de un equipo
    public function updateEquipo($idEquipo, $nombreEquipo, $representanteEquipo) {
        $data = [
            'userId' => $this->userId,
            'nombreEquipo' => $nombreEquipo,
            'representanteEquipo' => $representanteEquipo
        ];

        return $this->sendRequest("/equipo/{$idEquipo}", 'PUT', $data);
    }

    // Obtener un equipo por su ID
    public function getEquipoById($idEquipo) {
        return $this->sendRequest("/equipo/{$idEquipo}", 'GET');
    }

    // Obtener todos los equipos
    public function getAllEquipos() {
        return $this->sendRequest('/equipo', 'GET');
    }

    // Eliminar un equipo
    public function deleteEquipo($idEquipo) {
        return $this->sendRequest("/equipo/{$idEquipo}", 'DELETE');
    }
}
?>
