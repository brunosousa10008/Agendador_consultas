<?php
require_once __DIR__ . "/../database/Pdo.php";

class Usuario{
    private $pdo;

    public function __construct(){
        $db = new Pdo();
        $this->pdo = $db->getPDO();
    }

    function criarUsuario(string $nome, string $login, string $senha, int $atualizado_por) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO tbUsuarios (nome, login, senha, atualizado_em, atualizado_por) VALUES (:nome, :login, :senha, NOW(), :atualizado_por)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":nome", $nome, PDO::PARAM_STR);
        $stmt->bindValue(":login", $login, PDO::PARAM_STR);
        $stmt->bindValue(":senha", $senha_hash, PDO::PARAM_STR);
        $stmt->bindValue(":atualizado_por", $atualizado_por, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    function lerUsuarios() {
        $sql = "SELECT * FROM tbUsuarios";
        return $this->pdo->query($sql);
    }
    
    function atualizarUsuario($id, $nome, $senha, $atualizado_por) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "UPDATE tbUsuarios SET nome = :nome, senha =:senha, atualizado_em = NOW(), atualizado_por = :atualizado_por WHERE usuario_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->bindValue(":nome", $nome, PDO::PARAM_STR);
        $stmt->bindValue(":senha", $senha_hash, PDO::PARAM_STR);
        $stmt->bindValue(":atualizado_por", $atualizado_por, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    function deletarUsuario($id) {
        $sql = "DELETE FROM tbUsuarios WHERE usuario_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $ $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}