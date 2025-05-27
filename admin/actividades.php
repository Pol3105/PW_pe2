<?php
    require_once( __DIR__ . '/../includes/database.php');
    require_once( __DIR__ . '/../models/Actividades.php');

    session_start();
    $alertas = [];

    require_once( __DIR__ . '/../templates/autorizado.php');

    if ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        if( isset($_GET['eliminar']) && $_GET['eliminar'] === 'exito'){
            Actividades::setAlerta('exito', 'Se ha eliminado de manera correcta');
            $alertas = Actividades::getAlertas();
        }

        if( isset($_GET['eliminar']) && $_GET['eliminar'] === 'error'){
            Actividades::setAlerta('error', 'No se ha podido eliminar');
            $alertas = Actividades::getAlertas();
        }
    }

    $actividades = Actividades::all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 1</title>
    <link rel="stylesheet" href="../css/app.css">
</head>
<body>

    <nav class="toolbar">

        <div class="referencias">
            <a class="boton" href="../index.php">Volver</a>
    
        </div>
    </nav>
  
    <?php
        include_once __DIR__ . "/../templates/alertas.php";
    ?>    
    <main >
        <h2>Actividades</h2>
        <div class="grid-actividades">

            <?php
                foreach($actividades as $actividad):
            ?>
                <div class="actividad">
                    <?php
                        if( $actividad->tipo == 'Futbol'):
                    ?>
                        <img src="../imagen/futbol/futbol1.webp" alt="Fútbol">
                    <?php
                        endif;
                    ?>

                    <?php
                        if( $actividad->tipo == 'Natacion'):
                    ?>
                        <img src="../imagen/natacion/natacion1.webp" alt="Fútbol">
                    <?php
                        endif;
                    ?>

                    <?php
                        if( $actividad->tipo == 'Tenis'):
                    ?>
                        <img src="../imagen/tenis/tenis1.webp" alt="Fútbol">
                    <?php
                        endif;
                    ?>

                    <h3><?php echo $actividad->tipo ?></h3>
                    <p><strong>Modalidad:</strong> <?php echo $actividad->modalidad ?></p>
                    <p>Pistas: <?php echo $actividad->pistas ?></p>


                    <a class="boton_admin" href="modificar.php?id=<?php echo $actividad->id; ?>">Modificar</a>
                    <a class="boton_admin" href="eliminar.php?id=<?php echo $actividad->id; ?>">Eliminar</a>

                </div>
                
            <?php
                endforeach;
            ?>
        
    </main>
    
    <footer class="toolbar">
        <div class="referencias">
            <a class="boton" href="../contacto.html"> Contactanos </a>
            <a class="boton" href="../como_se_hizo.pdf">¿Cómo se hizo?</a>
        </div>
    </footer>

            
</body>
</html>



