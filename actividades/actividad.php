<?php
    require_once( __DIR__ . '/../includes/database.php');
    require_once( __DIR__ . '/../models/Actividades.php');

    session_start();


    if ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        if( isset($_GET['id'])){
            $id = $_GET['id'];
        }
    }

    $actividad = Actividades::where('id',$id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 2</title>
    <link rel="stylesheet" href="../css/app.css">
</head>
<body>

    <header class="toolbar">
        <div class="referencias">
            <a class="boton" href="../index.php">Inicio</a>
            <a class="boton" href="actividades.php"> Actividades </a> 
            <a class="boton" href="../html/conocee_club.html"> Conoce nuestro club </a>  
            <a class="boton" href="../html/evento.html"> Eventos Deportivos </a>  
            <a class="boton" href="../html/informacion.html"> Información general </a>  
            <a class="boton" href="../html/sugerencias.html"> Sugerencias </a>  
            <?php
                if( isset($_SESSION['admin']) && $_SESSION['admin'] == 1 ):
            ?>
                <a class="boton" href="../admin/actividades.php"> Admin </a> 
            <?php endif; ?>
            
        </div>
    </header>

    <main class="menu-derecha">
        <div class="actividad-detalle">
            <?php
                if( $actividad->tipo == 'Futbol'):
            ?>
                <img class="banner" src="../imagen/futbol/futbol1.webp" alt="Fútbol">
            <?php
                endif;
            ?>

            <?php
                if( $actividad->tipo == 'Natacion'):
            ?>
                <img class="banner" src="../imagen/natacion/natacion1.webp" alt="Fútbol">
            <?php
                endif;
            ?>

            <?php
                if( $actividad->tipo == "Tenis"):
            ?>
                <img class="banner" src="../imagen/tenis/tenis1.webp" alt="Fútbol">
            <?php
                endif;
            ?>

            <section class="contenido-actividad">
                <div class="info">
                    <h2><?php echo $actividad->tipo ?></h2>
                    <p><strong>Modalidad:</strong> <?php echo $actividad->modalidad ?></p>
                    <p><strong>Pistas:</strong><?php echo $actividad->pistas ?></p>
                </div>

                <aside class="detalles">
                    <h3>Detalles Adicionales</h3>
                    <ul>
                        <li>Duración: 2 horas por partido</li>
                        <li>Material necesario: Balón, petos, calzado adecuado</li>
                        <li>Nivel: Todos los niveles</li>
                    </ul>
                </aside>

            </section>
        </div>

    </main>

    <footer class="toolbar">
        <div class="referencias">
            <a class="boton" href="../../contacto.html"> Contactanos </a>
            <a class="boton" href="../../como_se_hizo.pdf">¿Cómo se hizo?</a>
        </div>
    </footer>

            
</body>
</html>
