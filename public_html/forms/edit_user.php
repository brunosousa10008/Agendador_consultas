<?php
require_once __DIR__ . '/../../app/class/Usuario.php';

if (!isset($_SESSION['autenticacao']) || empty($_SESSION['autenticacao'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$usuario = new Usuario();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int) $_POST['id'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $dtNascimento = $_POST['dtnascimento'] ?? '';
    $perfil_id = (int) $_POST['perfil'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $login = $_POST['login'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmacao_senha = $_POST['confirmacao_senha'] ?? '';
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $atualizado_por = $_SESSION['autenticacao'];

    if($id == 1 && $perfil_id !== 1){
        echo json_encode(["error" => "Você não pode alterar o perfil do administrador"]);
        exit;
        
    }

    // Não pode desabilitar o administrador
    if ($id == 1 && $ativo == 0) {
        echo json_encode(["error" => "Você não pode desabilitar o usuário administrador!"]);
        exit;
    } 

    // Não pode a si mesmo
    if ($id == $_SESSION['autenticacao'] && $ativo == 0) {
        echo json_encode(["error" => "Você não pode se desabilitar!"]);
        exit;
    }

    if(isset($senha) && !empty($senha) || isset($confirmacao_senha) && !empty($confirmacao_senha) && $origin_authentication != "ldap" ){
        if($senha === $confirmacao_senha){
            if($usuario->atualizarUsuarioComsenha($id, $nome, $email, $cpf, $dtNascimento, $perfil_id, $telefone,  $login, $senha, $ativo, $atualizado_por)){
                echo json_encode(["success" => "Usuário editado com sucesso!"]);
                exit;
                
            } else{
                echo json_encode(["error" => "Erro ao atualizar usuário, login ou cpf existente!"]);
                exit;
            }

        } else {
            echo json_encode(["error" => "As senhas não correspondem. Tente novamente."]);
            exit;
        }

    } else {
        if($usuario->atualizarUsuarioSemSenha($id, $nome, $email, $cpf, $dtNascimento, $perfil_id, $telefone,  $login, $ativo, $atualizado_por)){
            echo json_encode(["success" => "Usuário editado com sucesso!"]);
            exit;
        } else{
            echo json_encode(["error" => "Erro ao atualizar usuário, login ou cpf existente!"]);
            exit;
        }
    }

}