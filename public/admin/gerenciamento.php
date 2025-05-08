<?php
include_once __DIR__ . '/../../app/class/Usuario.php';
if (isset($_SESSION['autenticacao']) && !empty($_SESSION['autenticacao'])):
    $usuario = new Usuario();
    $usuario->lerUsuario($_SESSION['autenticacao']);
   
    if($usuario->getPerfilId() === 1):
  
?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Administração de Usuários - Sistema Médico</title>
        <link rel="stylesheet" href="../assets/css/gerenciamento.css">
        <script src="../assets/js/gerenciamento.js" defer></script>
    </head>
    <body>
        <!-- Start message -->
        <?php include __DIR__ . '../../includes/message.php'; ?>
        <!-- End message -->
        <h1>Administração de Usuários</h1>
        <div class="cricao-usuario-div">
            <button onclick="logout()">Logout</button>
            <button onclick="openPopupCreateUser()">Criar Usuário</button>
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
                <?php
                    foreach ($usuario->lerUsuarios() as $row) {
                        $ativo = ($row['ativo'] == 1) ? "ativo" : "Desativado";
                        echo "<tr>".
                            "<td>".$row['nome']."</td>".
                            "<td>".$row['email']."</td>".
                            "<td>".$row['perfil']."</td>".
                            "<td>".$ativo."</td>".

                            "<td>".
                                "<button onclick=\"openPopupEditUser('" . $row['usuario_id'] . "')\" class='btn edit'>Editar</button>" .
                                "<button onclick=\"openPopupInfoUser('" . $row['usuario_id'] . "')\" class='btn info'>Informação</button>";
                                if ($row['usuario_id'] !== 1) {
                                    echo "<button onclick=\"openPopupDeleteUser(" . $row['usuario_id'] . ", '" . addslashes($row['nome']) . "')\" class='btn delete'>Deletar</button>";

                                }
                            echo "</td>".
                       "</tr>";
                    }

                ?>
            </tbody>
        </table>

        <!-- Pop-up create user -->
        <div class="popup-create-user" id="popupCreateUser">
            <div class="popup-content-create-user" id="popupContentCreateUser">
                <div class="title">
                    <div class="close-popup">
                        <svg onclick="closePopupCreateUser(event)" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0,0,256,256">
                            <g fill="#0000006e" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M4.99023,3.99023c-0.40692,0.00011 -0.77321,0.24676 -0.92633,0.62377c-0.15312,0.37701 -0.06255,0.80921 0.22907,1.09303l6.29297,6.29297l-6.29297,6.29297c-0.26124,0.25082 -0.36647,0.62327 -0.27511,0.97371c0.09136,0.35044 0.36503,0.62411 0.71547,0.71547c0.35044,0.09136 0.72289,-0.01388 0.97371,-0.27511l6.29297,-6.29297l6.29297,6.29297c0.25082,0.26124 0.62327,0.36648 0.97371,0.27512c0.35044,-0.09136 0.62411,-0.36503 0.71547,-0.71547c0.09136,-0.35044 -0.01388,-0.72289 -0.27512,-0.97371l-6.29297,-6.29297l6.29297,-6.29297c0.29576,-0.28749 0.38469,-0.72707 0.22393,-1.10691c-0.16075,-0.37985 -0.53821,-0.62204 -0.9505,-0.60988c-0.2598,0.00774 -0.50638,0.11632 -0.6875,0.30273l-6.29297,6.29297l-6.29297,-6.29297c-0.18827,-0.19353 -0.4468,-0.30272 -0.7168,-0.30273z"></path></g></g>
                        </svg>
                    </div>
                    <h1>Criação de Usuário</h1>
                </div>
                <div class="creation-form">
                    <form action="../forms/create_user.php" id="userCreationForm" method="post">
                        <div class="fields">
                            <div class="division-1">
                                <div class="user-name">
                                    <label for="nome">Nome <span>&ast;</span></label>
                                    <input type="text" name="nome" required>
                                </div>
                                <div class="user-email">
                                    <label for="email">Email</label>
                                    <input type="text" name="email">
                                </div>
                                <div class="user-cpf">
                                    <label for="cpf">CPF <span>&ast;</span></label>
                                    <input 
                                        type="text" 
                                        name="cpf" 
                                        maxlength="14" 
                                        required 
                                        pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" 
                                        title="Digite um CPF válido (ex: 123.456.789-09)"
                                        oninput="mascararCPF(this)">
                                </div>
                                <div class="user-data-nascimento">
                                    <label for="dtnascimento">Data de Nascimento <span>&ast;</span></label>
                                    <input type="date" name="dtnascimento" required>
                                </div>
                                <div class="user-profile">
                                    <label for="perfilId">Perfil <span>&ast;</span></label>
                                    <select name="perfilId" required>
                                        <option value="1">Admin</option>
                                        <option value="2">Médico</option>
                                        <option value="3">Paciente</option>
                                    </select>
                                </div>
                            </div>
                            <div class="division-2">
                                <div class="user-phone">
                                    <label for="telefone">Telefone <span>&ast;</span></label>
                                    <input
                                        type="text"
                                        name="telefone"
                                        required
                                        maxlength="15"
                                        pattern="\(\d{2}\)\s\d{4,5}-\d{4}"
                                        title="Digite um telefone válido (ex: (11) 91234-5678)"
                                        oninput="mascararTelefone(this)">
                                </div>
                                <div class="user-login">
                                    <label for="login">Login <span>&ast;</span></label>
                                    <input type="text" name="login" required>
                                </div>
                                <div class="user-password divPassword">
                                    <label for="senha" >Senha <span>&ast;</span></label>
                                    <input type="password" id="inputCreatePassword" name="senha" required>
                                </div>
                                <div class="user-confirm-password divPassword">
                                    <label for="confirmacao_senha" id="inputConfirmPassword">Confirmação de senha <span>&ast;</span></label>
                                    <input type="password" id="inputCreateConfirmPassword" name="confirmacao_senha" required>
                                </div>
                                <div>
                                    <label for="ativo">Active</label>
                                    <input type="checkbox" name="ativo" checked>
                                </div>
                            </div>
                        </div>

                        <div class="user-buttons">
                            <button class="close" onclick="closePopupCreateUser(event)">Close</button>
                            <button class="create" id="submitFormCreateUser">Create</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>

        <!-- Pop-up edit user --> 
        <div class="popup-edit-user" id="popupEditUser">
            <div class="popup-content-edit-user" id="popupContentEditUser">
                <div class="title">
                    <div class="close-popup">
                        <svg onclick="closePopupEditUser(event)" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0,0,256,256">
                            <g fill="#0000006e" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M4.99023,3.99023c-0.40692,0.00011 -0.77321,0.24676 -0.92633,0.62377c-0.15312,0.37701 -0.06255,0.80921 0.22907,1.09303l6.29297,6.29297l-6.29297,6.29297c-0.26124,0.25082 -0.36647,0.62327 -0.27511,0.97371c0.09136,0.35044 0.36503,0.62411 0.71547,0.71547c0.35044,0.09136 0.72289,-0.01388 0.97371,-0.27511l6.29297,-6.29297l6.29297,6.29297c0.25082,0.26124 0.62327,0.36648 0.97371,0.27512c0.35044,-0.09136 0.62411,-0.36503 0.71547,-0.71547c0.09136,-0.35044 -0.01388,-0.72289 -0.27512,-0.97371l-6.29297,-6.29297l6.29297,-6.29297c0.29576,-0.28749 0.38469,-0.72707 0.22393,-1.10691c-0.16075,-0.37985 -0.53821,-0.62204 -0.9505,-0.60988c-0.2598,0.00774 -0.50638,0.11632 -0.6875,0.30273l-6.29297,6.29297l-6.29297,-6.29297c-0.18827,-0.19353 -0.4468,-0.30272 -0.7168,-0.30273z"></path></g></g>
                        </svg>
                    </div>
                    <h1>Edição de Usuario</h1>
                </div>
                <div class="edit-form">
                    <form action="../forms/edit_user.php" id="userEditForm" method="post">
                        <input type="hidden" name="id" id="edicaoId">
                        <div class="fields">
                            <div class="division-1">
                                <div class="user-name">
                                    <label for="nome">Nome <span>&ast;</span></label>
                                    <input type="text" name="nome" id="edicaoNome" required>
                                </div>
                                <div class="user-email">
                                    <label for="email">Email</label>
                                    <input type="text" id="edicaoEmail" name="email">
                                </div>
                                <div class="user-cpf">
                                    <label for="cpf">CPF <span>&ast;</span></label>
                                    <input 
                                        type="text" 
                                        id="edicaoCpf" 
                                        name="cpf" 
                                        maxlength="14" 
                                        required 
                                        pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" 
                                        title="Digite um CPF válido (ex: 123.456.789-09)"
                                        oninput="mascararCPF(this)">
                                </div>
                                <div class="user-data-nascimento">
                                    <label for="dtnascimento">Data de Nascimento <span>&ast;</span></label>
                                    <input type="date" id="edicaoDtNascimento" name="dtnascimento" required>
                                </div>
                                <div class="user-profile">
                                    <label for="perfil">Profile <span>&ast;</span></label>
                                    <select name="perfil" id="edicaoPerfil" required>
                                        <option value="1">Admin</option>
                                        <option value="2">Médico</option>
                                        <option value="3">Paciente</option>
                                    </select>
                                </div>
                            </div>
                            <div class="division-2">
                                <div class="user-phone">
                                    <label for="telefone">Telefone <span>&ast;</span></label>
                                    <input
                                        type="text"
                                        id="edicaoTelefone"
                                        name="telefone"
                                        required
                                        maxlength="15"
                                        pattern="\(\d{2}\)\s\d{4,5}-\d{4}"
                                        title="Digite um telefone válido (ex: (11) 91234-5678)"
                                        oninput="mascararTelefone(this)">
                                </div>
                                <div class="user-login">
                                    <label for="login">Login <span>&ast;</span></label>
                                    <input type="text" id="edicaoLogin" name="login" required>
                                </div>
                                <div class="user-password divPassword">
                                    <label for="senha">Senha</label>
                                    <input type="password" id="inputEditPassword" name="senha">
                                </div>
                                <div class="user-confirm-password divPassword">
                                    <label for="confirmacao_senha">Confirmação de senha</label>
                                    <input type="password" id="inputEditConfirmPassword" name="confirmacao_senha">
                                </div>
                                <div>
                                    <label for="ativo">Active</label>
                                    <input type="checkbox" id="edicaoAtivo" name="ativo" checked>
                                </div>
                            </div>
                        </div>

                        <div class="user-buttons">
                            <div>
                                <button class="close" onclick="closePopupEditUser(event)">Close</button>
                                <button class="create" id="submitFormEditUser">Edit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Pop-up edit user --> 
        <div class="popup-info-user" id="popupInfoUser">
            <div class="popup-content-info-user" id="popupContentInfoUser">
                <div class="title">
                    <div class="close-popup">
                        <svg onclick="closePopupInfoUser(event)" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0,0,256,256">
                            <g fill="#0000006e" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M4.99023,3.99023c-0.40692,0.00011 -0.77321,0.24676 -0.92633,0.62377c-0.15312,0.37701 -0.06255,0.80921 0.22907,1.09303l6.29297,6.29297l-6.29297,6.29297c-0.26124,0.25082 -0.36647,0.62327 -0.27511,0.97371c0.09136,0.35044 0.36503,0.62411 0.71547,0.71547c0.35044,0.09136 0.72289,-0.01388 0.97371,-0.27511l6.29297,-6.29297l6.29297,6.29297c0.25082,0.26124 0.62327,0.36648 0.97371,0.27512c0.35044,-0.09136 0.62411,-0.36503 0.71547,-0.71547c0.09136,-0.35044 -0.01388,-0.72289 -0.27512,-0.97371l-6.29297,-6.29297l6.29297,-6.29297c0.29576,-0.28749 0.38469,-0.72707 0.22393,-1.10691c-0.16075,-0.37985 -0.53821,-0.62204 -0.9505,-0.60988c-0.2598,0.00774 -0.50638,0.11632 -0.6875,0.30273l-6.29297,6.29297l-6.29297,-6.29297c-0.18827,-0.19353 -0.4468,-0.30272 -0.7168,-0.30273z"></path></g></g>
                        </svg>
                    </div>
                    <h1>Informações do usuario</h1>
                </div>
                <div class="content">
                    <ul>
                        <li>Nome: <span id="infoNome"></span></li>
                        <li>Perfil: <span id="infoPerfil"></span></li>
                        <li>CPF: <span id="infoCpf"></span></li>
                        <li>Data de Nascimento: <span id="infoDtNascimento"></span></li>
                        <li>Login: <span id="infoLogin"></span></li>
                        <li>Ativo: <span id="infoAtivo"></span></li>
                        <li>Email: <span id="infoEmail"></span></li>
                        <li>Telefone: <span id="infoTelefone"></span></li>
                        <li>Atualizado em: <span id="infoAtualizadoEm"></span></li>
                        <li>Atualizado por: <span id="infoAtualizadoPor"></span></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Pop-up delete user --> 
        <div class="popup-delete-user" id="popupDeleteUser">
            <div class="popup-content-delete-user" id="popupContentDeleteUser">
                <div class="title">
                    <div class="close-popup">
                        <svg onclick="closePopupDeleteUser(event)" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0,0,256,256">
                            <g fill="#0000006e" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M4.99023,3.99023c-0.40692,0.00011 -0.77321,0.24676 -0.92633,0.62377c-0.15312,0.37701 -0.06255,0.80921 0.22907,1.09303l6.29297,6.29297l-6.29297,6.29297c-0.26124,0.25082 -0.36647,0.62327 -0.27511,0.97371c0.09136,0.35044 0.36503,0.62411 0.71547,0.71547c0.35044,0.09136 0.72289,-0.01388 0.97371,-0.27511l6.29297,-6.29297l6.29297,6.29297c0.25082,0.26124 0.62327,0.36648 0.97371,0.27512c0.35044,-0.09136 0.62411,-0.36503 0.71547,-0.71547c0.09136,-0.35044 -0.01388,-0.72289 -0.27512,-0.97371l-6.29297,-6.29297l6.29297,-6.29297c0.29576,-0.28749 0.38469,-0.72707 0.22393,-1.10691c-0.16075,-0.37985 -0.53821,-0.62204 -0.9505,-0.60988c-0.2598,0.00774 -0.50638,0.11632 -0.6875,0.30273l-6.29297,6.29297l-6.29297,-6.29297c-0.18827,-0.19353 -0.4468,-0.30272 -0.7168,-0.30273z"></path></g></g>
                        </svg>
                    </div>
                    <h1>Deletar Usuario</h1>
                </div>
                <div class="delete-form">
                    <form action="../forms/delete_user.php" id="userDeleteForm" method="post">
                        <p id="textDeleteUser"></p>
                        <input type="hidden" id="deletarUsuario" name="id">
                        <div class="customer-buttons">
                            <button class="close" onclick="closePopupDeleteUser(event)">Close</button>
                            <button class="delete" id="submitFormDeleteUser">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    </html>
<?php
    else :
        header('Location: ./login.php');
    endif;
else: 
     header('Location: ./login.php');
endif;
?>