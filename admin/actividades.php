<?php
    require_once( __DIR__ . '/../includes/database.php');
    require_once( __DIR__ . '/../models/Actividades.php');

    session_start();
    $alertas = [];
    $pag = 1;

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

        if( isset($_GET['pagina'])){
            $pag = $_GET['pagina'];
        }
    }
    $actividades = Actividades::all();

    $numero_actividades = count($actividades);
    $num_pag = ceil($numero_actividades/9);
    $inicio = ($pag - 1) * 9;
    $fin = min($inicio + 9, $numero_actividades); // No pasarse del total

    if( $pag > $num_pag)
         header("Location: /admin/actividades.php?pagina=1");

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
        <h3> Pagina: <?php echo $pag ?></h3>
        <div class="grid-actividades">
            <?php
                for ($i = $inicio; $i < $fin; $i++):
                    $actividad = $actividades[$i];
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
                        if( $actividad->tipo == "Tenis"):
                    ?>
                        <img src="../imagen/tenis/tenis1.webp" alt="Fútbol">
                    <?php
                        endif;
                    ?>

                    <h3><?php echo $actividad->tipo ?></h3>
                    <p><strong>Modalidad:</strong> <?php echo $actividad->modalidad ?></p>
                    <p>Pistas: <?php echo $actividad->pistas ?></p>


                    <a class="boton_admin" href="modificar.php?id=<?php echo $actividad->id; ?>">Modificar</a>
                    <a class="boton_admin" href="eliminar.php?id=<?php echo $actividad->id; ?>&pagina=<?php echo $pag; ?>">Eliminar</a>

                </div>
                
            <?php
                endfor;
            ?>
        </div>

        <div class="referencias">
        <?php
            if ($pag > 1):
        ?>  
            <a class="boton" href="?pagina=<?php echo $pag-1 ?>">⬅ Anterior</a>
        <?php
            endif;
        ?>
        <?php
            if ($pag < $num_pag):
        ?>  
            <a class="boton" href="?pagina=<?php echo $pag + 1; ?>">Siguiente ➡</a>
        <?php
            endif;
        ?>
        </div>
        <div class="referencias">
            <a class="boton" href="modificar.php">Crear nueva actividad</a>
        </div>
    </main>
    
    <footer class="toolbar">
        <div class="referencias">
            <a class="boton" href="../contacto.html"> Contactanos </a>
            <a class="boton" href="../como_se_hizo.pdf">¿Cómo se hizo?</a>
        </div>
    </footer>

            
</body>
</html>



