<?php 
require_once __DIR__ . '/../../app/class/Usuario.php';

if (!isset($_SESSION['autenticacao']) || empty($_SESSION['autenticacao'])) {
    echo json_encode(["error" => "Não autorizado"]);
    exit;
}

$usuario = new Usuario();

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $dtnascimento = $_POST['dtnascimento'] ?? '';
    $perfilId = $_POST['perfilId'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $login = $_POST['login'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmacao_senha = $_POST['confirmacao_senha'] ?? '';
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $atualizadoPor = $_SESSION['autenticacao'];

    if ($usuario->validacaoLogin($login)) {
        echo json_encode(["error" => "Login já existente"]);
        exit;

    } else if ($usuario->validacaoCpf($cpf)) {
        echo json_encode(["error" => "Cpf já existente"]);
        exit;
        
    } else if($senha !== $confirmacao_senha){
        // Enviar mensagem de erro se as senhas não coincidirem
        echo json_encode(["error" => "As senhas não coincidem!"]);
        exit;

    } else if ($usuario->criarUsuario($nome, $perfilId, $cpf, $email, $dtnascimento, $login, $telefone, $senha, $atualizadoPor, $ativo)) {
        echo json_encode(["success" => "Usuário criado com sucesso!"]);
        exit;

    } else {
        echo json_encode(["error" => "Erro na criação do usuário, contate o administrador!"]);
        exit;
    }

}