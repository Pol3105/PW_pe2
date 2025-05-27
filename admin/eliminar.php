<?php
    require_once( __DIR__ . '/../includes/database.php');
    require_once( __DIR__ . '/../models/Actividades.php');

    session_start();

    require_once( __DIR__ . '/../templates/autorizado.php');

    if ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        $actividad = Actividades::where("id", $_GET['id']);

        $resultado = $actividad->eliminar();

        if( $resultado ){
            header('Location: /admin/actividades.php?eliminar=exito');
        }
        else{
            header('Location: /admin/actividades.php?eliminar=error');
        }
    }
    else{
        header('Location: /admin/actividades.php?eliminar=error');
    }
?>