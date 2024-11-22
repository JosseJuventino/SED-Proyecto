<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $errors = [];
    // Capturar el término de búsqueda
    $rawSearchTerm = $_POST['searchTerm'] ?? '';

    // Verificar si está vacío
    if (empty($rawSearchTerm)) {
        $errors[] = "El término de búsqueda no puede estar vacío.";
    }

    // Sanitizar contra XSS
    $sanitizedSearchTerm = filter_var($rawSearchTerm, FILTER_SANITIZE_SPECIAL_CHARS);

    // Validar longitud o formato si aplica
    if (strlen($sanitizedSearchTerm) > 255) {
        $errors[] = "El término de búsqueda no puede tener más de 255 caracteres.";
    }

    // Escapar la salida para prevenir XSS
    error_log(
        "Search term: $sanitizedSearchTerm",
    );

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: page.php');
        exit;
    }

    $_SESSION['searchTerm'] = $sanitizedSearchTerm;
}


require_once 'apiService.php';

class EquipoService extends ApiService {
    
    private $userId;
    private $authToken;

    public function __construct($apiUrl, $userId) {
        parent::__construct($apiUrl); // Llamar al constructor de ApiService
        $this->userId = $userId;
        $this->authToken = $_SESSION['token'] ?? null;

        if (!$this->authToken) {
            throw new Exception("Error: No se encontró el token de autenticación en la sesión.");
        }
    }

    // Obtener un equipo por su ID
    public function getEquipoById($equipoName) {
        $data = [
            'token' => $this->authToken // Incluir el token aquí
        ];

        return $this->get("/equipo/nombre/{$equipoName}", $data);
    }
    public function getAllEquipos() {
        $data = [
            'token' => $this->authToken // Incluir el token aquí
        ];

        return $this->get('/equipo', $data);
    }
}
