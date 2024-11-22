<?php

require_once 'ApiService.php';

class PartidoService extends ApiService {

    private $authToken;

    /**
     * Constructor de PartidoService
     * @param string $apiUrl URL base de la API
     */
    public function __construct($apiUrl) {
        parent::__construct($apiUrl); // Llamar al constructor de ApiService

        $this->authToken = $_SESSION['auth_token'] ?? null;

        if (!$this->authToken) {
            throw new Exception("Error: No se encontró el token de autenticación en la sesión.");
        }
    }

    /**
     * Obtener todos los partidos
     * @return array Respuesta de la API
     */
    public function getAllPartidos() {
        return $this->getWithAuth('/partido');
    }

    /**
     * Obtener un partido por su ID
     * @param int $idPartido ID del partido
     * @return array Respuesta de la API
     */
    public function getPartidoById($idPartido) {
        return $this->getWithAuth("/partido/{$idPartido}");
    }

    /**
     * Crear un nuevo partido
     * @param int $userId ID del usuario
     * @param string $fechaPartido Fecha del partido (formato YYYY-MM-DD)
     * @param int $idEquipoLocal ID del equipo local
     * @param int $idEquipoVisitante ID del equipo visitante
     * @return array Respuesta de la API
     */
    public function createPartido($userId, $fechaPartido, $idEquipoLocal, $idEquipoVisitante) {
        $data = [
            'userId' => $userId,
            'fechaPartido' => $fechaPartido,
            'idEquipoLocal' => $idEquipoLocal,
            'idEquipoVisitante' => $idEquipoVisitante,
        ];

        return $this->postWithAuth('/partido', $data);
    }

    /**
     * Actualizar un partido existente
     * @param int $idPartido ID del partido
     * @param int $userId ID del usuario
     * @param string $fechaPartido Fecha del partido (formato YYYY-MM-DD)
     * @param int $marcadorLocal Marcador del equipo local
     * @param int $marcadorVisitante Marcador del equipo visitante
     * @param int $idEquipoLocal ID del equipo local
     * @param int $idEquipoVisitante ID del equipo visitante
     * @return array Respuesta de la API
     */
    public function updatePartido($idPartido, $userId, $fechaPartido, $marcadorLocal, $marcadorVisitante, $idEquipoLocal, $idEquipoVisitante) {
        $data = [
            'userId' => $userId,
            'fechaPartido' => $fechaPartido,
            'marcadorLocal' => $marcadorLocal,
            'marcadorVisitante' => $marcadorVisitante,
            'idEquipoLocal' => $idEquipoLocal,
            'idEquipoVisitante' => $idEquipoVisitante,
        ];

        return $this->postWithAuth("/partido/{$idPartido}", $data); // Simular PUT con POST
    }

    /**
     * Eliminar un partido existente
     * @param int $idPartido ID del partido
     * @param int $userId ID del usuario
     * @return array Respuesta de la API
     */
    public function deletePartido($idPartido, $userId) {
        $data = [
            'userId' => $userId
        ];

        return $this->postWithAuth("/partido/{$idPartido}/delete", $data); // Simular DELETE con POST
    }

    /**
     * Método interno para realizar solicitudes GET con autenticación
     * @param string $endpoint Ruta del endpoint
     * @return array Respuesta de la API
     */
    private function getWithAuth($endpoint) {
        $data = ['token' => $this->authToken]; // Incluir el token en los headers
        return $this->get($endpoint, $data);
    }

    /**
     * Método interno para realizar solicitudes POST con autenticación
     * @param string $endpoint Ruta del endpoint
     * @param array $data Datos a enviar en el cuerpo de la solicitud
     * @return array Respuesta de la API
     */
    private function postWithAuth($endpoint, $data = []) {
        $data['token'] = $this->authToken; // Incluir el token de autenticación
        return $this->post($endpoint, $data);
    }
}
