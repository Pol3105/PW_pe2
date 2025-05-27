<?php
    require_once( __DIR__ . '/../includes/database.php');
    require_once( __DIR__ . '/../models/Usuario.php');

    session_start();

    require_once( __DIR__ . '/../templates/autorizado.php');

    echo "HOLA";