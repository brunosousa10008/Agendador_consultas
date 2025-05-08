<?php
require_once __DIR__ . '/../../app/class/Usuario.php';

if (!isset($_SESSION['authentication']) || empty($_SESSION['authentication'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$usuario = new Usuario();

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $id = (int)$_POST['id'] ?? '';

    if ($id == 1) {
        echo json_encode(["error" => "Você não pode excluir o usuário administrador"]);
        exit;
    } 
    
    if ($id == $_SESSION['authentication'] ) {
        echo json_encode(["error" => "Você não pode se auto-excluir"]);
        exit;
    }
    
    if ($usuario->deletarUsuario($id)) {
        echo json_encode(["success" => "Usuário excluído com sucesso!"]);
    } else {
        echo json_encode(["error" => "Erro ao excluir usuário, entre em contato com o administrador!"]);
    }
    exit;
}