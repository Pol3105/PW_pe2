<?php
    require_once( __DIR__ . '/includes/database.php');
    require_once( __DIR__ . '/models/Usuario.php');

    $alertas = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $usuario = new Usuario($_POST);
        $encontrado = Usuario::where("email", $_POST['email']);
    
        if( !$encontrado ){
            $usuario->HasheoContraseña();
        
            $resultado = $usuario->guardar();

            if( $resultado ){
                header('Location: /index.php?login=exito');
            }
            else{
                Usuario::setAlerta('error','Ha ocurrido un error');
            }
        }
        else{
            Usuario::setAlerta('error','El correo ya esta usado');
        }
    }

    $alertas = usuario::getAlertas();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 1</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>

    <nav class="toolbar">
        <div class="referencias">
            <a class="boton" href="index.php">Inicio</a>
            <a class="boton" href="actividades/actividades.html"> Actividades </a> 
            <a class="boton" href="conocee_club.html"> Conoce nuestro club </a>  
            <a class="boton" href="evento.html"> Eventos Deportivos </a>  
            <a class="boton" href="informacion.html"> Información general </a>  
            <a class="boton" href="sugerencias.html"> Sugerencias </a>  

        </div>
    </nav>

    <main>

        <h1 class="titulo"> Bienvenido a mi club <strong>Pablito's CLUB</strong></h1>

        <div class="contenedor-app">

            <div class="imagen"></div>

            <div class="app">

                <?php
                    include_once __DIR__ . "/templates/alertas.php";
                ?>

                <form class="formulario" method="POST" action="altausuarios.php">
                    <div class="campo">
                        <label for="email">Email</label>
                        <input type="email"
                        id="email"
                        placeholder="Email..."
                        name="email"
                        />
                    </div>

                    <div class="campo">
                        <label for="nombre">Nombre</label>
                        <input type="text"
                        id="nombre"
                        placeholder="Nombre..."
                        name="nombre"
                        />
                    </div>

                    <div class="campo">
                        <label for="edad">Edad</label>
                        <input type="number"
                        id="edad"
                        placeholder="Edad..."
                        name="edad"
                        />
                    </div>

                    <div class="campo">
                        <label for="contraseña">Contraseña</label>
                        <input type="password"
                        id="contraseña"
                        placeholder="Contraseña..."
                        name="contraseña"
                        />
                    </div>
                    
                    <input type="submit" class="boton submit" value="Crear cuenta">
                
                </form>

                <div class="acciones">
                    <a href="index.php">¿Ya tienes una cuenta?</a>
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



