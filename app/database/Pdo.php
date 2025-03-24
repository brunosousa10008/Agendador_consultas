<?php
require_once __DIR__ . "/../database/Pdo.php";

class Pdo{
    private $host;
    private $db;
    private $user;
    private $pass;
    private $pdo;

    // O construtor agora permite a personalização dos parâmetros de conexão
    public function __construct($host = '127.0.0.1', $db = 'medprime', $user = 'root', $pass = 'root') {
        $this->host = $host;
        $this->db = $db;
        $this->user = $user;
        $this->pass = $pass;

        
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->handleError($e);
        }
    }

    // Método para obter a conexão PDO
    public function getPDO() {
        return $this->pdo;
        
    }

    // Método para tratar erros de conexão
    private function handleError(PDOException $e) {
        echo json_encode([
            'message' => 'Database connection error: ' . $e->getMessage(),
            'success' => false
        ]);
        exit;
    }
}