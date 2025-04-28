<?php
include_once __DIR__ . '/../../app/class/Usuario.php';

if(isset($_SESSION['autenticacao']) && !empty($_SESSION['autenticacao'])): header('Location: ./gerenciamento'); 

else : header('Location: ./login.php');  endif;