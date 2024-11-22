<?php

require_once 'apiService.php'; // Servicio base que maneja las solicitudes

class AuthService extends ApiService {
    /**
     * Realiza el login mediante el endpoint `/login`
     *
     * @param array $credentials Contiene el email y password
     * @return array Respuesta de la API
     * @throws Exception Si hay un error en la autenticación
     */
    public function login(array $credentials) {
        // Validar que las credenciales contengan email y password
        if (empty($credentials['email']) || empty($credentials['password'])) {
            throw new Exception("Error: Email y contraseña son requeridos.");
        }

        // Sanitizar el email
        $email = filter_var($credentials['email'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Error: Email inválido.");
        }

        // Preparar las credenciales para el POST
        $payload = [
            'email' => $email,
            'password' => $credentials['password'], // Asegúrate de que la contraseña no se exponga innecesariamente
        ];

        // Realizar la solicitud POST al endpoint de login
        try {
            $response = $this->post('/login', $payload);
        } catch (Exception $e) {
            throw new Exception("Error al realizar la solicitud de login: " . $e->getMessage());
        }

        // Verificar la respuesta de la API
        if (isset($response['error']) && $response['error']) {
            throw new Exception("Error de autenticación: " . ($response['message'] ?? 'Error desconocido'));
        }

        return $response;
    }

    /**
     * Verifica la validez de un token mediante el endpoint `/verify-token`
     *
     * @param array $data Contiene el token a verificar
     * @return array Respuesta de la API
     * @throws Exception Si hay un error en la verificación del token
     */
    public function verifyToken(array $data) {
        // Validar que el token esté presente
        if (empty($data['token'])) {
            throw new Exception("Error: Token es requerido.");
        }

        // Preparar el payload para el GET
        $payload = [
            'token' => $data['token'],
        ];

        // Realizar la solicitud GET para verificar el token
        try {
            $response = $this->get('/auth/verify', $payload);
        } catch (Exception $e) {
            throw new Exception("Error al verificar el token: " . $e->getMessage());
        }

        // Verificar la respuesta de la API
        if (isset($response['error']) && $response['error']) {
            throw new Exception("Error al verificar el token: " . ($response['message'] ?? 'Error desconocido'));
        }

        return $response;
    }
}