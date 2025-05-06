const submitLoginForm = document.getElementById('submitLoginForm');
const loginForm = document.getElementById('loginForm');

if(loginForm) {
    submitLoginForm.addEventListener('click', (event) => {
        if (loginForm.checkValidity()) {
            event.preventDefault();
            const formData = new FormData(loginForm);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './forms/validacaoDeLogin.php', true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        showMessage("messageError", response.error);
                    } else {
                        showMessage("messageSuccess", response.success);
                        setTimeout(() => {
                            window.location.href = "/index.php";
                        }, 700);
                    }
                } else {
                    showMessage("messageError", "There was an error submitting the form. Please contact the administrator.")
                }
            };

            xhr.send(formData);
        }
    });
}

const submitLoginFormAdmin = document.getElementById('submitLoginFormAdmin');
const loginFormAdmin = document.getElementById('loginFormAdmin');

if(loginFormAdmin){
    submitLoginFormAdmin.addEventListener('click', (event) => {
        if (loginFormAdmin.checkValidity()) {
            event.preventDefault();
            const formData = new FormData(loginFormAdmin);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../forms/validacaoDeLogin.php', true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        showMessage("messageError", response.error);
                    } else {
                        showMessage("messageSuccess", response.success);
                        setTimeout(() => {
                            window.location.href = "gerenciamento.php";
                        }, 700);
                    }
                } else {
                    showMessage("messageError", "There was an error submitting the form. Please contact the administrator.")
                }
            };

            xhr.send(formData);
        }
    });
}