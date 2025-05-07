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
        <script src="../assets/js/gerenciamento.js" defer></script>
    </head>
    <body>
        <h1>Administração de Usuários</h1>
        <div class="cricao-usuario-div">
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

        <!-- Pop-up create user -->
        <div class="popup-create-user" id="popupCreateUser">
            <div class="popup-content-create-user" id="popupContentCreateUser">
                <div class="title">
                    <div class="close-popup">
                        <svg onclick="closePopupCreateUser(event)" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0,0,256,256">
                            <g fill="#0000006e" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M4.99023,3.99023c-0.40692,0.00011 -0.77321,0.24676 -0.92633,0.62377c-0.15312,0.37701 -0.06255,0.80921 0.22907,1.09303l6.29297,6.29297l-6.29297,6.29297c-0.26124,0.25082 -0.36647,0.62327 -0.27511,0.97371c0.09136,0.35044 0.36503,0.62411 0.71547,0.71547c0.35044,0.09136 0.72289,-0.01388 0.97371,-0.27511l6.29297,-6.29297l6.29297,6.29297c0.25082,0.26124 0.62327,0.36648 0.97371,0.27512c0.35044,-0.09136 0.62411,-0.36503 0.71547,-0.71547c0.09136,-0.35044 -0.01388,-0.72289 -0.27512,-0.97371l-6.29297,-6.29297l6.29297,-6.29297c0.29576,-0.28749 0.38469,-0.72707 0.22393,-1.10691c-0.16075,-0.37985 -0.53821,-0.62204 -0.9505,-0.60988c-0.2598,0.00774 -0.50638,0.11632 -0.6875,0.30273l-6.29297,6.29297l-6.29297,-6.29297c-0.18827,-0.19353 -0.4468,-0.30272 -0.7168,-0.30273z"></path></g></g>
                        </svg>
                    </div>
                    <h1>Create User</h1>
                </div>
                <div class="creation-form">
                    <form action="../forms/create_user.php" id="userCreationForm" method="post">
                        <div class="fields">
                            <div class="division-1">
                                <div class="user-name">
                                    <label for="name">Name <span>&ast;</span></label>
                                    <input type="text" name="name" required>
                                </div>
                                <div class="user-email">
                                    <label for="email">Email</label>
                                    <input type="text" name="email">
                                </div>
                                <div class="user-profile">
                                    <label for="profile">Profile <span>&ast;</span></label>
                                    <select name="profile" required>
                                        <option value="1">Admin</option>
                                        <option value="2">Analyst</option>
                                    </select>
                                </div>
                                <div class="user-origin_authentication">
                                    <label for="origin_authentication">Origin authentication <span>&ast;</span></label>
                                    <select name="origin_authentication" id="selectOriginAuth" required>
                                        <option value="local">local</option>
                                        <option value="ldap">ldap</option>
                                    </select>
                                </div>
                            </div>
                            <div class="division-2">
                                <div class="user-login">
                                    <label for="login">Login <span>&ast;</span></label>
                                    <input type="text" name="login" required>
                                </div>
                                <div class="user-password divPassword">
                                    <label for="password" >Password <span>&ast;</span></label>
                                    <input type="password" id="inputCreatePassword" name="password" required>
                                </div>
                                <div class="user-confirm-password divPassword">
                                    <label for="confirm-password" id="inputConfirmPassword">Confirm Password <span>&ast;</span></label>
                                    <input type="password" id="inputCreateConfirmPassword" name="confirm-password" required>
                                </div>
                                <div>
                                    <label for="active">Active</label>
                                    <input type="checkbox" name="active" checked>
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
                    <h1>Edit User</h1>
                </div>
                <div class="edit-form">
                    <form action="../forms/edit_user.php" id="userEditForm" method="post">
                        <input type="hidden" name="id" id="editId">
                        <div class="fields">
                            <div class="division-1">
                                <div class="user-name">
                                    <label for="name">Name <span>&ast;</span></label>
                                    <input type="text" name="name" id="editName" required>
                                </div>
                                <div class="user-email">
                                    <label for="email">Email</label>
                                    <input type="text" id="editEmail" name="email">
                                </div>
                                <div class="user-profile">
                                    <label for="profile">Profile <span>&ast;</span></label>
                                    <select name="profile" id="editProfile" required>
                                        <option value="1">Admin</option>
                                        <option value="2" id="optionsProfileAnalyst">Analyst</option>
                                    </select>
                                </div>
                                <div class="user-origin_authentication">
                                    <label for="origin_authentication">Origin authentication <span>&ast;</span></label>
                                    <select name="origin_authentication" id="editLoginOrigin" required>
                                        <option value="local">local</option>
                                        <option value="ldap" id="optionLdap">ldap</option>
                                    </select>
                                </div>
                            </div>
                            <div class="division-2">
                                <div class="user-login">
                                    <label for="login">Login <span>&ast;</span></label>
                                    <input type="text" name="login" id="editLogin" required>
                                </div>
                                <div class="user-password divEditInputPassword">
                                    <label for="password" >Password</label>
                                    <input type="password" name="password" id="inputEditPassword">
                                </div>
                                <div class="user-confirm-password divEditInputPassword">
                                    <label for="confirm-password">Confirm Password</label>
                                    <input type="password" name="confirm-password" id="inputEditConfirmPassword">
                                </div>
                                <div id="editActiveDiv">
                                    <label for="active">Active</label>
                                    <input type="checkbox" name="active" id="editActive">
                                </div>
                            </div>
                        </div>

                        <div class="user-buttons">
                            <div>
                                <button class="delete" id="callPopDeleteUser">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px" viewBox="0,0,256,256">
                                        <g fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M10,1.9668c-0.183,0 -0.36553,0.05833 -0.51953,0.17383l-3.8125,2.85938h12l-2.2832,-1.71289c-0.239,-0.179 -0.55303,-0.22128 -0.83203,-0.11328l-1.75,0.67773l-2.2832,-1.71094c-0.154,-0.1155 -0.33653,-0.17383 -0.51953,-0.17383zM4.67773,7c-0.368,0 -0.65152,0.32445 -0.60352,0.68945l1.67578,12.57422c0.133,0.994 0.98042,1.73633 1.98242,1.73633h8.25c1.003,0 1.84942,-0.74233 1.98242,-1.73633l1.67773,-12.57422c0.048,-0.365 -0.23747,-0.68945 -0.60547,-0.68945z"></path></g></g>
                                    </svg>
                                    Delete
                                </button>
                            </div>
                            <div>
                                <button class="close" onclick="closePopupEditUser(event)">Close</button>
                                <button class="create" id="submitFormEditUser">Edit</button>
                            </div>
                        </div>
                    </form>
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
                    <h1>Delete customer</h1>
                </div>
                <div class="delete-form">
                    <form action="../forms/delete_user.php" id="userDeleteForm" method="post">
                        <p id="textDeleteUser"></p>
                        <input type="hidden" id="deleteUser" name="id">
                        <div class="customer-buttons">
                            <button class="close" onclick="closePopupDeleteUser(event)">Close</button>
                            <button class="delete" id="submitFormDeleteUser" >Delete</button>
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
?>