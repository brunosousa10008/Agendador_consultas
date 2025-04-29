<?php
    include_once __DIR__ . '/../../app/class/Usuario.php';
    if(isset($_SESSION['autenticacao']) && !empty($_SESSION['autenticacao'])):
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager</title>
</head>
<body>
    
</body>
</html>
<?php
else : 
    header('Location: ./login.php');  
endif;
?>