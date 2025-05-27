# PW_pe2
Practica a realizar para PW , en tercero de carrera segundo cuatri.


Pasos que he realizado para hacer la Practica de manera correcta:

1.- Primeramente he puesto el css , y las imagenes que había utilizado en la practica anterior , tras esto he pasado el index y lo he transformado en .php y he creado la tabla de usuarios que va a ser :

    CREATE TABLE usuario (
        id INT PRIMARY KEY AUTO_INCREMENT,
        nombre VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        contraseña VARCHAR(60),
        admin TINYINT(1) DEFAULT 0,
        UNIQUE(email)
        );

    Tras saber la estructura de mi tabla usuario , creo una clase usuario con sus mismos atributus y con un constructor que parta de una array para así poder inicializar un objeto usuario directamente de un POST por ejemplo.

    Es una estructura básica pero que nos sirve para esta práctica. Una vez ya tengo la tabla realizo la conexion con la base de datos, incluyo una carpeta includes/ con un archivo database.php , donde voy a tener la conexión con la base de datos y varias funciones que me van a ayudar para debuguear el código cuando sea necesario.

    Una vez ya he realizado y comprobado que la conexión me funciona voy a hacer algunos reajustes en altausurio , cambiandolo a .php y gestionando el resgistro de los usuarios, no voy a hacer todavía lo de javaScript , eso lo dejo para más tarde.

    Una vez me doy cuenta que funciona la línea:

        usuario = new usuario($_POST);

    Ya solo queda hacer las comprobaciones pertinentes , pero como esas se hacen con java ya solo quedaría hashear la contraseña y introducir el nuevo usuario en la base de datos. Para hacer el hashing de la contraseña he hecho una función de la clase usuario que cambia la contraseña actual del objeto usuario por una hasheada, una vex hasheada podemos introducir nuestro nuevo usuario en la base de datos.

    Para la gestión de errores voy a crear un array $alertas = [] , el cuál se mostrará si en algún momento hay alguna alerta que decirle al usuario para ello voy a realizar:

    He creado un file en /templates/alertas.php para que en caso de haber errores se gestione de esa forma. Y lo he añadido en altausuario en un lugar donde quiero que se muestre el error en caso de haberlo , esto es solo para gestionar errores al insertar en la base de datos.

    Ahora compruebo que se haga el insert de manera correcta y tras esto paso al index.php para hacer y gestionar el login del usuario en la pagina web.

    Tenia un error de ActiveRecord ya que tengo que asociarle la base de datos una vez ya he solucionado este problema se inserta de manera correcta por lo que paso con el index.php.

    Me he dado cuenta de que no tenía hecho la comprobación de si el usuario existe por lo que he tenido que volver a hacerlo depués de esto he realizado, que si se registra de manera correcta paso con un metodo get sencillo que lo he resgitrado bien al index y lo muestro por pantalla.

            if( $resultado ){
                hheader('Location: /index.php?login=exito');
            }

    Asi redirecciono al login y lo gestino asi para mostrar la alerta:

        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            if( isset($_GET['login']) && $_GET['login'] === 'exito'){
            Usuario::setAlerta('exito', 'El usuario ha sido registrado de manera correcta');
                $alertas = Usuario::getAlertas();
            }
        }

    Ahora en el indix cunado devuelvo un método POST lo que voy ahacer es comprobar que tanto el email como la contraseña son correctos , para ellos encuentro el suuario según el email en la base de datos y comrpuebo que la contraseña pasada por el método POST es igual a la que tengo en la base de datos , como he hasheado la contraseña necesito utilizar una función del estilo:

        // Verificaciones con la contraseña
        public function ComprobacionContraseña($valor) {
            return password_verify($valor, $this->contraseña);
        }

    Una vez ya lo he comprobado muestro el nombre y el tipo en la parte superior derecha de la página, para ello primero inicio sesión una vez se han realizado las comprobaciones de la forma:

        // Si ambas comprobaciones son correctas el inicio de sesión se hace de manera correcta
        if( $encontrado && $contraseña_correcta ){
            session_start();
            $_SESSION['id'] = $encontrado->id;
            $_SESSION['nombre'] = $encontrado->nombre;
            $_SESSION['email'] = $encontrado->email;
            $_SESSION['admin'] = $encontrado->admin;

            if( $encontrado->admin == 1 ){
                header('Location : /');
            }
        }

    Todavía no sé si necesitaré mas información en el session por ahora se queda así y como todavía no he realizado la página donde se crearán las actividades dejo la redirección cuando es admin así para luego cambiarla en el futuro.

    Ahora necesito mostrar la información por pantalla para lo que vooy a utilizar este código:

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
        <?php
            endif;
        ?>

    Ahora tengo que gestionar las alertas si el correo no está registrado o la contraseña del usuario introducida es incorrecta.Para ello incluyo esto en el código y como el template ya está no hay que modificar como se muestra:

        else{
            Usuario::setAlerta('error', 'El usuario no existe , o la contraseña es incorrecta');
            $alertas = Usuario::getAlertas();
        }

    Se me había olvidado introducir el botón de logout, pero se añade al lado de el tipo de usuario y el nombre , ahora voy realizar el logout.php que basicamente va a gestionar destruir la sesión y volver a redirigir al index pero ahora con un mensaje de que se ha finalizado la sesión de manera correcta, para ello en el logout.php introduzco el siguientte código:

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout']))
        {
            $_SESSION = [];
            header('Location: /index.php?logout=exito');
        }
        else{
            header('Location: /index.php?logout=error');
        }

    Basicamentte elimino toda la infformación que tenía del usuario resgitrado y lo redirijo , también tengo en cuenta que no se pueda acceder si no es con el método post , para ello he hecho esto en el botón de cerrar sesión:

        <form action="logout.php" method="POST">
            <input type="hidden" name="logout" id="logout" >
            <button class="boton" type="submit">Cerrar sesión</button>
        </form>

    He añadido algo de seguridad añadiendo una variable en el POST aunque nose si es estrictamente necesario.

    Me he dado cuenta que mejor paso a través de un form al logout para que simplemente poniendo la ruta en el navegador no se pueda desloguear de la cuenta , y también he añadido unua alerta de exito cuando el usuario se inicia de manera correcta en la página y una de error cuando intentas acceder con la ruta de esta forma:

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
    
    Una vez ya controlo todo para el registro , el inicio de sesión y el logout , voy a pasar a empezar a gestionar un administrador que voy a tener que introducir en la base de datos inicialmente con un insert y poniendo que el boolean de admin sea uno para ello hago este insert en el sql:
        INSERT INTO usuario ( nombre, email, edad, contraseña, admin )
            VALUES (' Pablo', 'pablorejoncamacho@gmail.com', '18', '$2y$10$vn94UFSQSdYGSCGmcvFUFuy8HAe0CL2rjT97RcjE94rW/oD/ycJYu', '1 ');

    Ahora voy a empezar viendo a donde redirijo el admin cuando se inicia sesión, al parecer se queda también en el index.php así que no hace falta que haga ninguna redirección extra. Ahora voy a hacer una carpeta admin/ en la cuál estará todo lo que el admin puede realizar y que un usuario no admin no va a poder entrar.

    Una vez he creado admin/actividades.php ( lugar donde el admin creará y modificará y eliminará las actividades de la base de datos) voy a hacer un botón de redireccióon desde el index que solo podrá ver si eres admin:

        <?php
            if( isset($_SESSION['admin']) && $_SESSION['admin'] == 1 ):
        ?>
            <a class="boton" href="/admin/actividades.php"> Admin </a> 
        <?php endif; ?>

    Antes de nada voy a gestionar que los usuarios no puedan entrar en dicho archivo, para esto he creado un template que va a gestionar esta acción para así tener más limpio el código dicho template es /template/autorizado.php y en el :

        <?php
            if( !isset($_SESSION['admin']) || $_SESSION['admin'] == 0 ){
                header('Location: /index.php?logout=error');
            }
        ?>

    Basicamente comprueba que si no existe la variable o es un 0 nos redirije al inicio y te da el warning de que no tienes autorización para acceder a esta ubiccación.

    Ahora voy a gestionar como voy a ver todas las actividades y luego gestionaré como crearlas y modificarlas. Para ver todas las actividades añado en /admin/actividades.php la siguiente información:

        