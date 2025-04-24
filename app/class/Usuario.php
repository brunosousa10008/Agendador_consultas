<?php
require_once __DIR__ . "/../database/Pdo.php";
session_start();
class Usuario {
    private $pdo;

    public function __construct() {
        $db = new Pdo();
        $this->pdo = $db->getPDO();
    }

    function loginUsuario(string $login, $senha ){
        try {
            $sql = "SELECT * FROM users 
                    WHERE login = :login 
                    AND login_origin = 'local'
                    AND active = 1";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':login' => $login]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $ip = $_SERVER['REMOTE_ADDR'] ?? 'IP desconhecido';

            if ($user && password_verify($senha, $user['senha'])) {
                $_SESSION['authentication'] = $user['id'];
                return true;

            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erro na conexão ou execução da consulta: " . $e->getMessage());
            return false;

        }
    }

    function criarUsuario(string $nome, int $perfil_id, string $cpf, string $nascimento, string $login, string $telefone, string $senha, int $atualizado_por) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO tbUsuarios (nome, perfil_id, cpf, nascimento, login, telefone, senha, atualizado_em, atualizado_por)
                VALUES (:nome, :perfil_id, :cpf, :nascimento, :login, :telefone, :senha, NOW(), :atualizado_por)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":nome", $nome, PDO::PARAM_STR);
        $stmt->bindValue(":perfil_id", $perfil_id, PDO::PARAM_INT);
        $stmt->bindValue(":cpf", $cpf, PDO::PARAM_STR);
        $stmt->bindValue(":nascimento", $nascimento, PDO::PARAM_STR); // formato 'YYYY-MM-DD'
        $stmt->bindValue(":login", $login, PDO::PARAM_STR);
        $stmt->bindValue(":telefone", $telefone, PDO::PARAM_STR);
        $stmt->bindValue(":senha", $senha_hash, PDO::PARAM_STR);
        $stmt->bindValue(":atualizado_por", $atualizado_por, PDO::PARAM_INT);
        return $stmt->execute();
    }

    function lerUsuarios() {
        $sql = "SELECT * FROM tbUsuarios";
        return $this->pdo->query($sql);
    }

    function atualizarUsuario($id, $nome, $telefone, $senha, $atualizado_por) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "UPDATE tbUsuarios 
                SET nome = :nome, telefone = :telefone, senha = :senha, atualizado_em = NOW(), atualizado_por = :atualizado_por 
                WHERE usuario_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->bindValue(":nome", $nome, PDO::PARAM_STR);
        $stmt->bindValue(":telefone", $telefone, PDO::PARAM_STR);
        $stmt->bindValue(":senha", $senha_hash, PDO::PARAM_STR);
        $stmt->bindValue(":atualizado_por", $atualizado_por, PDO::PARAM_INT);
        return $stmt->execute();
    }

    function deletarUsuario($id) {
        $sql = "DELETE FROM tbUsuarios WHERE usuario_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
