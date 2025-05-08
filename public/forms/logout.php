<?php
require_once __DIR__ . '/../../app/class/Usuario.php';

if (isset($_SESSION['autenticacao']) && !empty($_SESSION['autenticacao'])):
    session_destroy();
    header('Location: ../login.php');
?>
<?php
else:
    header('Location: ../login.php');
endif;
?>