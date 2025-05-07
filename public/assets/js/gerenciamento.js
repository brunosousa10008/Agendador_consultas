
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

selectOriginAuth.addEventListener('change', () => {
    if (selectOriginAuth.value == "ldap") {
        inputPassword.removeAttribute('required');
        inputConfirmPassword.removeAttribute('required');
        inputPassword.value = '';
        inputConfirmPassword.value = '';
        divPassword.forEach(element => {
            element.style.display = "none";

        });
    } else {
        divPassword.forEach(element => {
            element.style.display = "flex";
        });
        inputPassword.setAttribute('required', 'true');
        inputConfirmPassword.setAttribute('required', 'true');
        
    }    



})

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
                    document.getElementById('editId').value = data.id;
                    document.getElementById("editName").value = data.name;
                    document.getElementById("editEmail").value = data.email;
                    document.getElementById("editProfile").value = data.profile_id;
                    document.getElementById("editLoginOrigin").value = data.login_origin;
                    document.getElementById("editLogin").value = data.login;
                    if (data.active == 1) {
                        document.getElementById("editActive").checked = true;
                        
                    }

                    document.getElementById('textDeleteUser').innerText = `Are you sure you want to delete user ${data.name}?`;
                    document.getElementById('deleteUser').value = data.id;
                
                    if(data.login_origin === "ldap"){
                        document.getElementById("inputEditPassword").value = '';
                        document.getElementById("inputEditConfirmPassword").value = '';
                        document.querySelectorAll(".divEditInputPassword").forEach(element => {
                            element.style.display="none";
                        });            
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
    // Se o usuário for administrador ou o id for igual ao id da authentication
    const DeleteUserBtn = document.getElementById('callPopDeleteUser');
    const editActiveDiv = document.getElementById("editActiveDiv");
    const optionLdap = document.getElementById('optionLdap');
    const optionsProfileAnalyst = document.getElementById('optionsProfileAnalyst');

    if(userId === 1) {
        optionLdap.style.display = "none";
        optionsProfileAnalyst.style.display = "none";

    } else {
        optionLdap.style.display = "block";
        optionsProfileAnalyst.style.display = "block";

    }

    if(userId === myID || userId === 1) {
        DeleteUserBtn.style.display = "none";
        editActiveDiv.style.display = "none";

    } else {
        DeleteUserBtn.style.display = "flex";
        editActiveDiv.style.display = "flex";
    }

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
    // Verificar se a edição de usuário é com ldap
const editLoginOrigin = document.getElementById('editLoginOrigin');

editLoginOrigin.addEventListener('change', () => {
    if(editLoginOrigin.value === "ldap"){
        document.getElementById("inputEditPassword").value = '';
        document.getElementById("inputEditConfirmPassword").value = '';
        document.querySelectorAll(".divEditInputPassword").forEach(element => {
            element.style.display="none";
        });            
    } else {
        document.querySelectorAll(".divEditInputPassword").forEach(element => {
            element.style.display="flex";
        }); 
    }
})


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


//  POP-UP deletar usuário
const popupDeleteUser = document.getElementById('popupDeleteUser');
const popupContentDeleteUser = document.getElementById('popupContentDeleteUser');

const callPopDeleteUser = document.getElementById('callPopDeleteUser');

function openPopupDeleteUser(){
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

callPopDeleteUser.addEventListener('click', (e) => {
    e.preventDefault();
    openPopupDeleteUser();

})

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