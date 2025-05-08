<?php
require_once __DIR__ . '/../../app/class/Usuario.php';

if (!isset($_SESSION['autenticacao']) || empty($_SESSION['autenticacao'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $usuario = new Usuario();
    $id = intval($_GET['id']);

    $userData = $usuario->lerUsuarioPeloId($id);

    // Retorna os dados como JSON
    echo json_encode($userData);

} else {
    echo json_encode(["error" => "ID inválido"]);
}
