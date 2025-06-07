<?php
    require_once( __DIR__ . '/../includes/database.php');
    require_once( __DIR__ . '/../models/Actividades.php');

    session_start();
    $alertas = [];
    $pag = 1;
    $extra = '';
    $actividades = Actividades::all();

    if ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        if( isset($_GET['pagina'])){
            $pag = $_GET['pagina'];
        }

        if( isset($_GET['categoria'])){
            $categoria = $_GET['categoria'];
            $actividades = Actividades::encontrarCategoria($categoria);
            $extra .= '&categoria=' . urlencode($_GET['categoria']);
        }   

        if( isset($_GET['deporte'])){
            $deporte = $_GET['deporte'];
            $actividades = Actividades::encontrarDeporte($deporte);
            $extra .= '&deporte=' . urlencode($_GET['deporte']);
        }
    }



    $numero_actividades = count($actividades);
    $num_pag = ceil($numero_actividades/9);
    $inicio = ($pag - 1) * 9;
    $fin = min($inicio + 9, $numero_actividades); // No pasarse del total

    if( $pag > $num_pag)
         header("Location: /actividades/actividades.php?pagina=1");

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
            <a class="boton" href="../html/actividades.php"> Actividades </a> 
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

    <aside class="menu-lateral">
        <p>Categorías</p>
        <ul>
            <p class="categoria">Principal:</p class="categoria">
            <li><a href="actividades.php">Todo</a></li>
            <p class="categoria">Por deporte:</p class="categoria">
                <li><a href="actividades.php?deporte=Futbol">Fútbol</a></li>
                <li><a href="actividades.php?deporte=Tenis">Tenis</a></li>
                <li><a href="actividades.php?deporte=Natacion">Natación</a></li>

            <p class="categoria">Por modalidad:</p class="categoria">
                <li><a href="actividades.php?categoria=Individual">Individual</a></li>
                <li><a href="actividades.php?categoria=En Equipo">Equipo</a></li>
        </ul>
    </aside>

    <main class="contenido">
        <h2>Actividades</h2>
        <h3> Pagina: <?php echo $pag ?></h3>
        <div class="grid-actividades">
            <?php
                for ($i = $inicio; $i < $fin; $i++):
                    $actividad = $actividades[$i];
            ?>
                <a href="actividad.php?id=<?php echo $actividad->id ?>">
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

                    </div>
                </a>
            <?php
                endfor;
            ?>
        </div>

        <div class="referencias">
        <?php if ($pag > 1): ?>  
            <a class="boton" href="?pagina=<?php echo $pag - 1 . $extra ?>">⬅ Anterior</a>
        <?php endif; ?>

        <?php if ($pag < $num_pag): ?>  
            <a class="boton" href="?pagina=<?php echo $pag + 1 . $extra ?>">Siguiente ➡</a>
        <?php endif; ?>
    
        </div>
    </main>
    
    <footer class="toolbar">
        <div class="referencias">
            <a class="boton" href="../html/contacto.html"> Contactanos </a>
            <a class="boton" href="../como_se_hizo.pdf">¿Cómo se hizo?</a>
        </div>
    </footer>

            
</body>
</html>



