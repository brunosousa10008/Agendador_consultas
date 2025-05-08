<?php
require_once __DIR__ . "/../database/ConexaoDB.php";
session_start();
class Usuario {
    private $pdo;

    private int $perfilId;

    public function __construct() {
        $db = new ConexaoDB();
        $this->pdo = $db->getPDO();
    }

    public function getPerfilId():int {
        return $this->perfilId;
    }

    function loginUsuario(string $login, $senha){
        try {
            $sql = "SELECT * FROM tbUsuarios
                    WHERE login = :login 
                    AND ativo = 1";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':login' => $login]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($senha, $user['senha'])) {
                $_SESSION['autenticacao'] = $user['usuario_id'];
                return true;

            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erro na conexão ou execução da consulta: " . $e->getMessage());
            return false;

        }
    }

    function criarUsuario(string $nome, int $perfil_id, string $cpf, string $nascimento, string $login, string $telefone, string $senha, int $atualizado_por, bool $ativo) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO tbUsuarios (nome, perfil_id, cpf, nascimento, login, telefone, senha, atualizado_em, atualizado_por, ativo)
                VALUES (:nome, :perfil_id, :cpf, :nascimento, :login, :telefone, :senha, NOW(), :atualizado_por, :ativo)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":nome", $nome, PDO::PARAM_STR);
        $stmt->bindValue(":perfil_id", $perfil_id, PDO::PARAM_INT);
        $stmt->bindValue(":cpf", $cpf, PDO::PARAM_STR);
        $stmt->bindValue(":nascimento", $nascimento, PDO::PARAM_STR); // formato 'YYYY-MM-DD'
        $stmt->bindValue(":login", $login, PDO::PARAM_STR);
        $stmt->bindValue(":telefone", $telefone, PDO::PARAM_STR);
        $stmt->bindValue(":senha", $senha_hash, PDO::PARAM_STR);
        $stmt->bindValue(":atualizado_por", $atualizado_por, PDO::PARAM_INT);
        $stmt->bindValue(":ativo", $ativo, PDO::PARAM_BOOL);
        return $stmt->execute();
    }

    public function validacaoLogin(string $login):bool {
        try {
            $sql = "SELECT COUNT(*) FROM tbUsuarios
                    WHERE login = :login ";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':login' => $login]);
            $count = $stmt->fetchColumn();
    
            if ($count > 0) {
                return true;
            } else {
                return false;
            }
        
    
        } catch (PDOException $e) {
            error_log("Erro na conexão ou execução da consulta: " . $e->getMessage());
            return false;
        }
    }

    public function validacaoCpf(string $cpf):bool {
        try {
            $sql = "SELECT COUNT(*) FROM tbUsuarios
                    WHERE cpf = :cpf ";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':cpf' => $cpf]);
            $count = $stmt->fetchColumn();
    
            if ($count > 0) {
                return true;
            } else {
                return false;
            }
        
    
        } catch (PDOException $e) {
            error_log("Erro na conexão ou execução da consulta: " . $e->getMessage());
            return false;
        }
    }

    public function lerUsuario($id):void {
        $sql = "SELECT * FROM tbUsuarios WHERE usuario_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->perfilId = $user['perfil_id'];

    }

    function lerUsuarioPeloId($id):array {
        $sql = "SELECT *, u2.nome as atualizado_por_name FROM tbUsuarios as u 
        LEFT JOIN tbUsuarios as u2 ON u.atualizado_por = u2.usuario_id 
        WHERE u.usuario_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario ?? "";
    }

    function lerUsuarios():array {
        $sql = "SELECT 
                    *, p.descricao AS perfil 
                FROM 
                    tbUsuarios AS u
                LEFT JOIN 
                    tbPerfil AS p ON u.perfil_id = p.perfil_id;
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    function atualizarUsuarioComSenha($id, $nome, $email, $cpf, $dtNascimento, $perfil_id, $telefone,  $login, $senha, $ativo, $atualizado_por) {
        try {
            // Criptografando a senha
            $hashedPassword = password_hash($senha, PASSWORD_BCRYPT);
    
            // Atualizando o banco de dados
            $sql = "UPDATE tbUsuarios SET nome = :nome, email = :email, cpf = :cpf, nascimento = :dtNascimento, perfil_id = :perfil_id, telefone = :telefone, login = :login, senha = :senha, ativo = :ativo, atualizado_por = :atualizado_por WHERE usuario_id = :id";
            $stmt = $this->pdo->prepare($sql);
    
            // Vinculando os parâmetros
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
            $stmt->bindParam(':dtNascimento', $dtNascimento, PDO::PARAM_STR);
            $stmt->bindParam(':perfil_id', $perfil_id, PDO::PARAM_INT);
            $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
            $stmt->bindParam(':login', $login, PDO::PARAM_STR);
            $stmt->bindParam(':senha', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
            $stmt->bindParam(':atualizado_por', $atualizado_por, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            return $stmt->execute(); 
        } catch (PDOException $e) {
            error_log("Erro ao atualizar usuário: " . $e->getMessage());
            return false; // Retorna false em caso de falha
        }
    }

    function atualizarUsuarioSemSenha($id, $nome, $email, $cpf, $dtNascimento, $perfil_id, $telefone,  $login, $ativo, $atualizado_por) {
        try{  
            // Atualizando o banco de dados
            $sql = "UPDATE tbUsuarios SET nome = :nome, email = :email, cpf = :cpf, nascimento = :dtNascimento, perfil_id = :perfil_id, telefone = :telefone, login = :login, ativo = :ativo, atualizado_por = :atualizado_por WHERE usuario_id = :id";
            $stmt = $this->pdo->prepare($sql);

            // Vinculando os parâmetros
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
            $stmt->bindParam(':dtNascimento', $dtNascimento, PDO::PARAM_STR);
            $stmt->bindParam(':perfil_id', $perfil_id, PDO::PARAM_INT);
            $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
            $stmt->bindParam(':login', $login, PDO::PARAM_STR);
            $stmt->bindParam(':ativo', $ativo, PDO::PARAM_BOOL);
            $stmt->bindParam(':atualizado_por', $atualizado_por, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute(); 
        } catch (PDOException $e) {
            error_log("Erro ao atualizar usuário: " . $e->getMessage());
            return false; // Retorna false em caso de falha
        }
    }

    function deletarUsuario($id) {
        $sql = "DELETE FROM tbUsuarios WHERE usuario_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
