<?php
    require_once( __DIR__ . '/includes/database.php');
    require_once( __DIR__ . '/models/Usuario.php');
    require_once( __DIR__ . '/models/Actividades.php');

    session_start();
    $alertas = [];
    $registro = 0;

    // Muestra de mensaje correcto cuando se registra un usuario

    if ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        if( isset($_GET['login']) && $_GET['login'] === 'exito'){
            Usuario::setAlerta('exito', 'El usuario ha sido registrado de manera correcta');
            $alertas = Usuario::getAlertas();
        }

        if( isset($_GET['logout']) && $_GET['logout'] === 'exito'){
            Usuario::setAlerta('exito', 'Se ha cerrado la sesión');
            $alertas = Usuario::getAlertas();
        }

        if( isset($_GET['logout']) && $_GET['logout'] === 'error'){
            Usuario::setAlerta('error', 'Se ha accedido a un lugar sin autorización');
            $alertas = Usuario::getAlertas();
        }
    }

    // Gestión del inicio de sesión 

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $encontrado = Usuario::where("email", $_POST['email']);
    
        $contraseña_correcta = $encontrado->ComprobacionContraseña($_POST['contraseña']);

        // Si ambas comprobaciones son correctas el inicio de sesión se hace de manera correcta
        if( $encontrado && $contraseña_correcta ){
            $_SESSION['id'] = $encontrado->id;
            $_SESSION['nombre'] = $encontrado->nombre;
            $_SESSION['email'] = $encontrado->email;
            $_SESSION['admin'] = $encontrado->admin;

            Usuario::setAlerta('exito', 'Inicio de sesión realizado con exito');
            $alertas = Usuario::getAlertas();
        }
        else{
            Usuario::setAlerta('error', 'El usuario no existe , o la contraseña es incorrecta');
            $alertas = Usuario::getAlertas();
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 2</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>

    <header class="toolbar">
        <div class="referencias">
            <a class="boton" href="index.php">Inicio</a>
            <a class="boton" href="actividades/actividades.php"> Actividades </a> 
            <a class="boton" href="conocee_club.html"> Conoce nuestro club </a>  
            <a class="boton" href="evento.html"> Eventos Deportivos </a>  
            <a class="boton" href="informacion.html"> Información general </a>  
            <a class="boton" href="sugerencias.html"> Sugerencias </a>  
            <?php
                if( isset($_SESSION['admin']) && $_SESSION['admin'] == 1 ):
            ?>
                <a class="boton" href="/admin/actividades.php"> Admin </a> 
            <?php endif; ?>
            
        </div>
    </header>

    <main>

        <div class="contenedor-index">
            <img class="logo" src="imagen/Logo.png" alt="Logo">
            <h1 class="titulo"> Bienvenido a mi club <strong>Pablito's CLUB</strong></h1>

            <?php
                if( isset($_SESSION['nombre']) && isset($_SESSION['admin'])):
            ?>

                <p class="">Nombre: <?php echo $_SESSION['nombre'] ?></p>
                <p>Tipo: <?php 
                    if( $_SESSION['admin'] == 0)
                        echo 'Usuario';
                    else
                        echo 'Admin';
                ?></p>

                <form action="logout.php" method="POST">
                    <input type="hidden" name="logout" id="logout" >
                    <button class="boton" type="submit">Cerrar sesión</button>
                </form>
            <?php
                endif;
            ?>
        </div>

        
        <div class="contenedor-app">

            <div class="imagen"></div>

            <div class="app">
                <?php
                    include_once __DIR__ . "/templates/alertas.php";
                ?>

                <form class="formulario" method="POST" action="index.php">
                    <div class="campo">
                        <label for="email">Email</label>
                        <input type="email"
                        id="email"
                        placeholder="Email..."
                        name="email"
                        required
                        />
                    </div>

                    <div class="campo">
                        <label for="contraseña">Contraseña</label>
                        <input type="password"
                        id="contraseña"
                        placeholder="Contraseña..."
                        name="contraseña"
                        required
                        />
                    </div>
                    
                    <input type="submit" class="boton submit" value="Iniciar sesión">
                
                </form>

                <div class="acciones">
                    <a href="altausuarios.php">¿Aún no tienes una cuenta? Crea una</a>
                </div>
            </div>


        </div>
    </main>




    <footer class="toolbar">
        <div class="referencias">
            <a class="boton" href="contacto.html"> Contactanos </a>
            <a class="boton" href="como_se_hizo.pdf">¿Como se hizo?</a>
        </div>
    </footer>

            
</body>
</html>



