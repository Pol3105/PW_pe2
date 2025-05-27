<?php
    require_once( __DIR__ . '/../includes/database.php');
    require_once( __DIR__ . '/../models/Actividades.php');

    session_start();

    require_once( __DIR__ . '/../templates/autorizado.php');

    if ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        $actividad = Actividades::where("id", $_GET['id']);
        $pag = $_GET['pagina'] ?? 1;

        $resultado = $actividad->eliminar();

        if ($resultado) {
            header("Location: /admin/actividades.php?eliminar=exito&pagina=" . $pag);
        } else {
            header("Location: /admin/actividades.php?eliminar=error&pagina=" . $pag);
        }
    } else {
        header("Location: /admin/actividades.php?eliminar=error&pagina=1");
    }
?>