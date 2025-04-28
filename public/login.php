<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=], initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/login.css">
    <title>MedPrime - Login</title>
</head>
<body>
    <main>
        <div class="login-submit">
            <div class="head">
                <div class="title">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="48px" height="48px" viewBox="0,0,256,256"><defs><linearGradient x1="23.99717" y1="5.99848" x2="23.99788" y2="42.00082" gradientUnits="userSpaceOnUse" id="color-1"><stop offset="0" stop-color="#fa5252"></stop><stop offset="1" stop-color="#fa5252"></stop></linearGradient></defs><g fill="url(#color-1)" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.33333,5.33333)"><path d="M30,29h11c0.55228,0 1,-0.44772 1,-1v-8c0,-0.55228 -0.44772,-1 -1,-1h-11c-0.55228,0 -1,-0.44772 -1,-1v-11c0,-0.55228 -0.44772,-1 -1,-1h-8c-0.55228,0 -1,0.44772 -1,1v11c0,0.55228 -0.44772,1 -1,1h-11c-0.55228,0 -1,0.44772 -1,1v8c0,0.55228 0.44772,1 1,1h11c0.55228,0 1,0.44772 1,1v11c0,0.55228 0.44772,1 1,1h8c0.55228,0 1,-0.44772 1,-1v-11c0,-0.55228 0.44772,-1 1,-1z"></path></g></g></svg>
                    <h1>Clínica <span>Med</span><span>Prime</span></h1>
                </div>
            </div>
            <div class="body">
                <form action="./forms/validacaoDeLogin.php" method="post">
                    <div>
                        <label for="user">Login</label>
                        <input type="text" name="user">
                    </div>
                    <div>
                        <label for="pass">Senha</label>
                        <input type="password" name="pass">
                    </div>
                    <div>
                        <button>Entrar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="login-wallpaper">
        </div>
    </main>
</body>
</html>