<?php
    require_once( __DIR__ . '/../includes/database.php');
    require_once( __DIR__ . '/../models/Actividades.php');

    session_start();
    $alertas = [];
    require_once( __DIR__ . '/../templates/autorizado.php');



    if ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        $actividad = Actividades::where("id", $_GET['id']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $encontrado = new Actividades($_POST);
        
        if( !isset($_POST['id']) ){
            $encontrado->guardar();
            Actividades::setAlerta('exito','Actividad creada de manera exitosa');
        }
        else{
            if( $encontrado ){
                $encontrado->guardar();
                $actividad = Actividades::where("id", $_POST['id']);
                Actividades::setAlerta('exito','Actividad modificada de manera exitosa');
            }
            else{
                Actividades::setAlerta('error','Ha ocurrido un error');
            }
        }
    }

    $alertas = Actividades::getAlertas();
?>
</html>
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
            <a class="boton" href="actividades.php">Todas las actividades</a>
            <a class="boton" href="../index.php">Inicio</a> 
        </div>
    </nav>

     <div class="contenedor-app">

            <div class="imagen"></div>

            <div class="app">
                <?php
                    include_once __DIR__ . "/../templates/alertas.php";

                    if( is_null($actividad->id)):
                ?>  
                    <h2>Crear una nueva actividad</h2>
                <?php   
                    else:
                ?>
                    <h2>Estamos modificando la pista id= <?php echo $actividad->id ?></h2>
                <?php   
                    endif;
                ?>

                <form class="formulario" method="POST" action="modificar.php">

                    <?php
                        if( $actividad->id):
                    ?>
                        <input type="hidden" name="id" value="<?php echo $actividad->id ?>">
                    <?php
                        endif;
                    ?>
                    <div class="campo">
                        <label for="tipo">Tipo</label>
                        <input type="text"
                        id="tipo"
                        placeholder="Tipo..."
                        name="tipo"
                        value="<?php echo $actividad->tipo ?>"
                        />
                    </div>
                    <p id="alerta_tipo"></p>

                    <div class="campo">
                        <label for="modalidad">Modalidad</label>
                        <input type="text"
                        id="modalidad"
                        placeholder="Modalidad..."
                        name="modalidad"
                        value="<?php echo $actividad->modalidad ?>"
                        />
                    </div>
                    <p id="alerta_modalidad"></p>
                    
                    <div class="campo">
                        <label for="pistas">Pistas</label>
                        <input type="text"
                        id="pistas"
                        placeholder="Pistas..."
                        name="pistas"
                        value="<?php echo $actividad->pistas ?>"
                        />
                    </div>
                    <p id="alerta_pista"></p>

                    <?php
                        if( $actividad->id):
                    ?>
                        <input type="submit" class="boton submit" value="Modificar">
                    <?php
                        else:
                    ?>
                        <input type="submit" class="boton submit" value="Crear">
                    <?php
                        endif;
                    ?>

                
                </form>
            </div>
        </div>


    <footer class="toolbar">
        <div class="referencias">
            <a class="boton" href="../html/contacto.html"> Contactanos </a>
            <a class="boton" href="../como_se_hizo.pdf">¿Cómo se hizo?</a>
        </div>
    </footer>

            
</body>

<script src="../javascript/actividades.js"></script>


</html>

