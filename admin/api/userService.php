<?php
require_once 'apiService.php';

class UserService extends ApiService {
    /**
     * Obtiene los detalles del usuario por su ID
     *
     * @param int $userId El ID del usuario
     * @return array Respuesta de la API
     */
    public function getUserById($userId) {
    $authToken = $_SESSION['auth_token'] ?? null;

    if (!$authToken) {
        throw new Exception("Error: No se encontró el token de autenticación en la sesión.");
    }

    $url = "/usuarios/{$userId}";
    $body = [
        'token' => $authToken,
        'superadminId' => $userId,
    ];


    $response = $this->get($url, $body);


    if (isset($response['error']) && $response['error']) {
        throw new Exception("Error de la API al obtener el usuario: " . ($response['message'] ?? 'Error desconocido'));
    }

    return $response;
}


}
