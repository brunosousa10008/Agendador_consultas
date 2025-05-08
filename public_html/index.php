<?php
    include_once __DIR__ . '/../app/class/Usuario.php';
    
    if(isset($_SESSION['autenticacao']) && !empty($_SESSION['autenticacao'])):
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedPrime - Home</title>
    <link rel="stylesheet" href="../assets/css/index.css">
</head>
<body>
    <h1>Login Efetudo com sucesso</h1>
    <p>Pagina em desenvolvimento</p>
    <button onclick="logout()">Logout</button>
    <script>
        function logout() {
            window.location.href = "./forms/logout.php"; // ou "logout.html"
        }
    </script>
</body>
</html>
<?php
else : 
    header('Location: ./login.php');  
endif;
?>