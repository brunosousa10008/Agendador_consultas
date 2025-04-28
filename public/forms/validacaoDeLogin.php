<?php
require_once __DIR__ . '/../../app/class/Usuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $usuario = new Usuario();

    $nome = $_POST['user'];
    $senha = $_POST['pass'];

    if ($usuario->loginUsuario($nome, $senha)) {
        echo json_encode(["success" => "Login efetuado com sucesso!"]);
        echo $_SESSION['autenticacao'];
    
    } else {
        echo json_encode(["error" => "Login inválido!"]);

    }
}