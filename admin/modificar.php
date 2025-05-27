<?php
    require_once( __DIR__ . '/../includes/database.php');
    require_once( __DIR__ . '/../models/Actividades.php');

    session_start();

    require_once( __DIR__ . '/../templates/autorizado.php');

    if ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        $actividad = Actividades::where("id", $_GET['id']);
    }
?>