<?php
include_once __DIR__ . '/../../app/class/Usuario.php';
if (isset($_SESSION['autenticacao']) && !empty($_SESSION['autenticacao'])):
?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Administração de Usuários - Sistema Médico</title>
        <link rel="stylesheet" href="../assets/css/gerenciamento.css">
    </head>
    <body>
        <h1>Administração de Usuários</h1>
        <div class="cricao-usuario-div">
            <button>Criar Usuário</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Função</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Maria Oliveira</td>
                    <td>maria@clinicamed.com</td>
                    <td>Administradora</td>
                    <td>Ativo</td>
                    <td>
                        <button class="btn edit">Editar</button>
                        <button class="btn info">Informação</button>
                        <button class="btn delete">Deletar</button>
                    </td>
                </tr>
                <tr>
                    <td>João Silva</td>
                    <td>joao@clinicamed.com</td>
                    <td>Médico</td>
                    <td>Inativo</td>
                    <td>
                        <button class="btn edit">Editar</button>
                        <button class="btn info">Informação</button>
                        <button class="btn delete">Deletar</button>
                    </td>
                </tr>
                <!-- Adicione mais usuários aqui -->
            </tbody>
        </table>
    </body>
    </html>
<?php
else :
    header('Location: ./login.php');
endif;
?>