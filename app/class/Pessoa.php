<?php
require_once __DIR__ . "/../database/Pdo.php";

class Pessoa{
    private $pdo;

    public function __construct(){
        $db = new Pdo();
        $this->pdo = $db->getPDO();
    }

    function criarPessoa($nome, $cpf, $nascimento, $telefone, $pessoa_tipo_id, $atualizado_por) {
        $sql = "INSERT INTO tbPessoas (nome, cpf, nascimento, telefone, pessoa_tipo_id, atualizado_por, atualizado_em) VALUES (:nome, :cpf, :nascimento, :telefone, :pessoa_tipo_id, :atualizado_por, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":nome", $nome, PDO::PARAM_STR);
        $stmt->bindValue(":cpf", $cpf, PDO::PARAM_STR);
        $stmt->bindValue(":nascimento", $nascimento, PDO::PARAM_STR);
        $stmt->bindValue(":telefone", $telefone, PDO::PARAM_STR);
        $stmt->bindValue(":pessoa_tipo_id", $pessoa_tipo_id, PDO::PARAM_INT);
        $stmt->bindValue(":atualizado_por", $atualizado_por, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    function lerPessoas() {
        $sql = "SELECT * FROM tbPessoas";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function atualizarPessoa($id, $nome, $telefone, $atualizado_por) {
        $sql = "UPDATE tbPessoas SET nome = :nome, telefone = :telefone, atualizado_em = NOW(), atualizado_por = :atualizado_por WHERE pessoa_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":nome", $nome, PDO::PARAM_STR);
        $stmt->bindValue(":telefone", $telefone, PDO::PARAM_STR);
        $stmt->bindValue(":atualizado_por", $atualizado_por, PDO::PARAM_INT);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    function deletarPessoa($id) {
        $sql = "DELETE FROM tbPessoas WHERE pessoa_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}