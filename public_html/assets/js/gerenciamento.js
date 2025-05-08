
// POP-UP Criar Usuário
const popupCreateUser = document.getElementById('popupCreateUser');
const popupContentCreateUser = document.getElementById('popupContentCreateUser');

function openPopupCreateUser() {
    popupCreateUser.style.display = "flex";
    setTimeout(() => {
        popupContentCreateUser.style.marginTop = "2rem";
    }, 300);
    
}

function closePopupCreateUser(e) {
    e.preventDefault();
    popupContentCreateUser.style.marginTop = "-80rem";
    setTimeout(() => {
        popupCreateUser.style.display = "none";
    }, 500);

}

    // Verificar se a criação de usuário é com ldap
const selectOriginAuth = document.getElementById('selectOriginAuth');
const inputPassword = document.getElementById('inputCreatePassword');
const inputConfirmPassword = document.getElementById('inputCreateConfirmPassword');
const divPassword = document.querySelectorAll('.divPassword');

    // Envio de formulário criação de usuário
const submitFormCreateUser = document.getElementById('submitFormCreateUser');
const userCreationForm = document.getElementById('userCreationForm');

submitFormCreateUser.addEventListener('click', (event) => {
    if (userCreationForm.checkValidity()) {
        event.preventDefault();
        const formData = new FormData(userCreationForm);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../forms/create_user.php', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.error) {
                    showMessage("messageError", response.error);
                } else {
                    showMessage("messageSuccess", response.success);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            } else {
                showMessage("messageError", "There was an error submitting the form. Please contact the administrator.")
            }
        };

        xhr.send(formData);
    }
});


// POP-UP Editar Usuário
    //Função para buscar o id do usuário
function getUserById(id) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", `../forms/get_user.php?id=${id}`, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                var data = JSON.parse(xhr.responseText);
                if (data) {
                    document.getElementById("edicaoId").value = data.usuario_id;
                    document.getElementById("edicaoNome").value = data.nome;
                    document.getElementById("edicaoEmail").value = data.email;
                    document.getElementById("edicaoCpf").value = data.cpf;
                    document.getElementById("edicaoDtNascimento").value = data.nascimento;
                    document.getElementById("edicaoLogin").value = data.login;
                    document.getElementById("edicaoTelefone").value = data.telefone;
                    if (data.ativo == 1) {
                        document.getElementById("edicaoAtivo").checked = true;
                        
                    }
          
                    switch (data.perfil_id) {
                        case 1:
                        case 2:
                        case 3:
                            document.getElementById("edicaoPerfil").value = data.perfil_id;
                            break;
                        default:
                            break;
                    }  
                }
                
            } catch (error) {
                console.error("Erro ao processar JSON:", error);
            }
        }
    };

    xhr.onerror = function () {
        console.error("Erro na requisição AJAX");
    };

    xhr.send();
}

const popupEditUser = document.getElementById('popupEditUser');
const popupContentEditUser = document.getElementById('popupContentEditUser');
function openPopupEditUser(userId) {
    getUserById(userId);
    popupEditUser.style.display = "flex";
    setTimeout(() => {
        popupContentEditUser.style.marginTop = "2rem";
    }, 300);
    
}

function closePopupEditUser(e) {
    e.preventDefault();
    popupContentEditUser.style.marginTop = "-80rem";
    setTimeout(() => {
        popupEditUser.style.display = "none";
    }, 500);

}

    // Envio de formulário edição de usuário
const submitFormEditUser = document.getElementById('submitFormEditUser');
const userEditForm = document.getElementById('userEditForm');

submitFormEditUser.addEventListener('click', (event) => {
    if (userEditForm.checkValidity()) {
        event.preventDefault();
        const formData = new FormData(userEditForm);
        const xhr = new XMLHttpRequest();

        xhr.open('POST', '../forms/edit_user.php', true);

        xhr.onload = function () {
            if (xhr.status === 200) {           
                const response = JSON.parse(xhr.responseText);
                if (response.error) {
                    showMessage("messageError", response.error);
                } else {
                    showMessage("messageSuccess", response.success);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            } else {
                showMessage("messageError", "There was an error submitting the form. Please contact the administrator.")
            }
        };

        xhr.send(formData);
    }
});

// POP-UP Informação Usuário
//Função para buscar o id do usuário
function getInfoUserById(id) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", `../forms/get_user.php?id=${id}`, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                var data = JSON.parse(xhr.responseText);
                if (data) {
                    document.getElementById("infoNome").innerText = data.nome;
                    document.getElementById("infoEmail").innerText = data.email;
                    document.getElementById("infoCpf").innerText = data.cpf;
                    document.getElementById("infoDtNascimento").innerText = data.nascimento;
                    document.getElementById("infoLogin").innerText = data.login;
                    document.getElementById("infoTelefone").innerText = data.telefone;
                    document.getElementById("infoAtualizadoEm").innerText = data.atualizado_em;
                    if (data.ativo == 1) {
                        document.getElementById("infoAtivo").innerText = "Sim";
                        
                    } else {
                        document.getElementById("infoAtivo").innerText = "Não";
                    }

                    switch (data.perfil_id) {
                        case 1:
                            document.getElementById("infoPerfil").innerText = "Admin";
                            break;
                        case 2:
                            document.getElementById("infoPerfil").innerText = "Médico";
                            break;
                        case 3:
                            document.getElementById("infoPerfil").innerText = "Paciente";
                            break;
                        default:
                            break;
                    }  
                    
                }
                
            } catch (error) {
                console.error("Erro ao processar JSON:", error);
            }
        }
    };

    xhr.onerror = function () {
        console.error("Erro na requisição AJAX");
    };

    xhr.send();
}

const popupInfoUser = document.getElementById('popupInfoUser');
const popupContentInfoUser = document.getElementById('popupContentInfoUser');
function openPopupInfoUser(userId) {
    getInfoUserById(userId);
    popupInfoUser.style.display = "flex";
    setTimeout(() => {
        popupContentInfoUser.style.marginTop = "2rem";
    }, 300);
    
}

function closePopupInfoUser(e) {
    e.preventDefault();
    popupContentInfoUser.style.marginTop = "-80rem";
    setTimeout(() => {
        popupInfoUser.style.display = "none";
    }, 500);

}

//  POP-UP deletar usuário
const popupDeleteUser = document.getElementById('popupDeleteUser');
const popupContentDeleteUser = document.getElementById('popupContentDeleteUser');

function openPopupDeleteUser($id, $nome){
    document.getElementById('deletarUsuario').value = $id;
    document.getElementById('textDeleteUser').innerText = `Tem certeza que deseja apagar o usuário ${$nome}`;
    popupDeleteUser.style.display = "flex";
    setTimeout(() => {
        popupContentDeleteUser.style.marginTop = "2rem";
    }, 300);
}

function closePopupDeleteUser(e){
    e.preventDefault();
    popupContentDeleteUser.style.marginTop = "-80rem";
    setTimeout(() => {
        popupDeleteUser.style.display = "none";
    }, 500);
}

    // Envio de formulário exclusão de usuário
const submitFormDeleteUser = document.getElementById('submitFormDeleteUser');
const userDeleteForm = document.getElementById('userDeleteForm');

submitFormDeleteUser.addEventListener('click', (event) => {
    if (userDeleteForm.checkValidity()) {
        event.preventDefault();
        const formData = new FormData(userDeleteForm);
        const xhr = new XMLHttpRequest();

        xhr.open('POST', '../forms/delete_user.php', true);

        xhr.onload = function () {
            if (xhr.status === 200) {           
                const response = JSON.parse(xhr.responseText);
                if (response.error) {
                    showMessage("messageError", response.error);
                } else {
                    showMessage("messageSuccess", response.success);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            } else {
                showMessage("messageError", "There was an error submitting the form. Please contact the administrator.")
            }
        };

        xhr.send(formData);
    }
});


function mascararCPF(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length > 11) value = value.slice(0, 11);
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    input.value = value;
}

function mascararTelefone(input) {
    let value = input.value.replace(/\D/g, '');

    if (value.length > 11) value = value.slice(0, 11);

    if (value.length <= 10) {
        value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
    } else {
        value = value.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
    }

    input.value = value.trim();
}

function logout() {
    window.location.href = "../forms/logout.php";
}