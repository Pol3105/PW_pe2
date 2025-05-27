<?php
    require_once( __DIR__ . '/includes/database.php');
    require_once( __DIR__ . '/models/Usuario.php');
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout']))
    {
        $_SESSION = [];
        header('Location: /index.php?logout=exito');
    }
    else{
        header('Location: /index.php?logout=error');
    }
   