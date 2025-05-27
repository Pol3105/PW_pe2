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

    Para empezar a gestionar las actividades primero voy a hacer la tabla en la base de datos y le voy a añadir varias actividades para así poder ver que funciona , también voy a tener que gestionar como se ven dichas actividades, primero haré lo de sql de la forma:

        CREATE TABLE actividades (
        id INT PRIMARY KEY AUTO_INCREMENT,
        tipo VARCHAR(50) NOT NULL,
        modalidad VARCHAR(50) NOT NULL,
        pistas VARCHAR(60)
        );
        INSERT INTO actividades (tipo, modalidad, pistas) VALUES
        ('Futbol', 'En Equipo', '1'),
        ('Natacion', 'En Equipo', '5'),
        ('Tenis', 'Individual', '3'),
        ('Futbol', 'En Equipo', '12');

    Una vez he hecho esto tengo que crear la clase que voy a utilizar para gestionar las actividades que va a ser /models/Actividades.php , una vez ya hemos hecho esto podemos pasar a como vamos a traernos todas las actividades de la base de datos:

    $actividades = Actividades::all();

    Así tengo todas las actividades de la base de datos en un array que es $actividades una vez tengo esto lo muestro por pantalla al administrador de la forma:

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
                </div>
                
            <?php
                endforeach;
            ?>

    Ahora tengo que añadir los botones en cada una de ellas para poder modificarlas , o eliminarlas:

        <a class="boton_admin" href="modificar.php?id=<?php echo $actividad->id; ?>">Modificar</a>
        <a class="boton_admin" href="eliminar.php?id=<?php echo $actividad->id; ?>">Eliminar</a>

    Como podemos observar he pasado a través del metodo get el id de la actividad, para saber a que actividad nos estamos refiriendo, ahora voy a hacer los archivos php /admin/modificar.php y /admin/eliminar.php, empezamos por el de eliminar que es mas simple:

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

    Aqui gestino que si el id se ha pasado de manera correcta se elimine , y sigo añadiendo el template ay que nos encontramos en la carpeta admin. gestiono las alertas como lo he hecho en el indice , por lo tanto ahora en las actividades.php tengo que gestionarlo asi:

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

    Una vez ya he terminado y gestionado como eliminar las actividades , voy a pasar a como modificarlas, es decir , voy a pasar a hacer el código de admin/modificar.php:

        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $actividad = Actividades::where("id", $_GET['id']);
        }

    Recojo que actividad es la que quiero modificar , y la guardo en un objeto de la clase Actividades, una vez echo esto voy a hacer el formulario para modificar el objeto:

        <input type="text"
            id="tipo"
            placeholder="tipo..."
            name="tipo"
            value="<?php echo $actividad->tipo ?>"
            required
        />

    Es importando añadir el valor value=... , para que el que está modificando vea el valor actual que tiene dicha actividad, una vez ya lo sabe lo que tiene que hacer es borrar introducir un valor nuevo y darle al boton , que va a redireccionar a la misma página , y vamos a gestionarlo ahora con:

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $encontrado = new Actividades($_POST);
            
            if( $encontrado ){
                $encontrado->guardar();
                Actividades::setAlerta('exito','Actividad modificada de manera exitosa');

                $actividad = Actividades::where("id", $_POST['id']);
            }
            else{
                Actividades::setAlerta('error','Ha ocurrido un error');
            }
        }
    
    Aqui gestiono la actividad que ha sido modificada con el POST , tras esto la guardo en la base de datos , ajusto la alerta de que me ha funcionado de manera correcta y por último actualizo $actividad para que en el propio formulario se meustre ya modificada la actividad( es lo que he comentado antes de los value ).

    Una vez ya he terminado de crear el el modificar.php voy a hacer el crear.php , aunque dandome cuenta creo que no es necesario hacer ningún crear, ya que en el modificar.php puedo ajustarlo para que funcione para ambas cosas según le pases por referencia las actividades o no.
    Para hacer todo esto he tenido que  hacer una serie de cambios en el modificar.php para no tener que hacer dos archivoss innecesariamente, ya que el formulario es el mismo. Lo primero que he realizado es cambiar cuando se recibe un método post:

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

    El cambio basicamente es que si no paso una actividad con el método get en el form no mando un id de la forma:

        <?php
            if( $actividad->id):
        ?>
            <input type="hidden" name="id" value="<?php echo $actividad->id ?>">
        <?php
            endif;
        ?>

    En la vista también he cambiado algunas cosas para que se vea que estás modificando o creando según:

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

    Ademas de:

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

    Ya teniendo hecho todo esto , voy a ver como mostrar más de nueve actividades con la paginación. PAra realizar la paginación primero he realizado unos cáculos básicos que son:

        $numero_actividades = count($actividades);
        $num_pag = ceil($numero_actividades/9);
        $inicio = ($pag - 1) * 9;
        $fin = min($inicio + 9, $numero_actividades); // No pasarse del total

    Estos me van a ayudar a saber el rango que tengo que manejar , teniendo en cuenta que $pag inicia su valor en 1.Para hacer la paginación hago que se muestre del array de $actividades que muestra desde $inicio hasta $fin según en que $pag nos encontremos. Para poner que la flechas he utilzado el siguiente código:

        <?php
            if ($pag > 1):
        ?>  
            a class="boton" href="?pagina=<?php echo $pag-1 ?>">⬅ Anterior</a>
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

    Esto muestra que en la primera página no mostramos para dar a anterior, ya que no hay. Y para mostrar si hay más verificamos si la pagina en la que estamos es menor que el numero total de páginas , ya que si es igual nos encontramos en la última página.

    Claro otra cosa es que utilizamos como se puede evr el método get para saber en que página nos encontramos actualmente, por lo que ahora tengo que actualizar el método eliminar , ya que al eliminar te mueve otra vez a la página inicial y no es la idea. Por eso le paso por el método get al eliminar la página en la que nos encontramos:

        <a class="boton_admin" href="eliminar.php?id=<?php echo $actividad->id; ?>&pagina=<?php echo $pag; ?>">Eliminar</a>

    Ahora tenemos que volver a modificar el eliminar de la forma:

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

    Una vez hemos echo esto , cuando elimino una actividad te retorna en la página en la que estabas previamente. Además he añadido una verificación para que si quieres acceder a una página y no existe te devuelva a la primera de todas:

        if( $pag > $num_pag)
            header("Location: /admin/actividades.php?pagina=1");

    Una vez ya he terminado la paginación puedo dar por concluida la parte del administrador ,es decir, la creación, eliminación y modificación de las actividades paso al punto 5, que es el menú de actividades de manera dinámica. Para esto , que es basicamente mostrar las actividades para todos los usuarios creo otra carpeta /actividades con un archivo dentro /actividades/actividades.php , este archivo se va a parecer mucho al que gestiona el administrador ya que es practivamente igual , la única diferencia es que el usuario no puede modificar nada de las actividades.

    Haciendo un copia pega rápido quitando los botones del adminstrador podemos tener ya hecho todo lo que necesitamos , ahora queda hacer el ménu según las categorías. Ahora para gestionar el menú lateral voy a hacer primeramente esto:

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

    Así redirecciono con el get para asi poder luego filtrar segun la modalidad o el tipo. Ahora teniendo esto tengo que ver que hago cuando lo encuentro a través del GET, para ello utilizo:

        if( isset($_GET['categoria'])){
            $categoria = $_GET['categoria'];
            $actividades = Actividades::encontrarCategoria($categoria);
        }   

        if( isset($_GET['deporte'])){
            $deporte = $_GET['deporte'];
            $actividades = Actividades::encontrarDeporte($deporte);
        }
    
    He tenido que crear varias funciones que se traen todas las actividades según el filtro, dichas funciones son:

        public static function encontrarCategoria($categoria){
            $query = "SELECT * FROM " . static::$tabla  ." WHERE modalidad = '{$categoria}'";
            $resultado = self::consultarSQL($query);
            return $resultado;
        }

        public static function encontrarDeporte($deporte){
            $query = "SELECT * FROM " . static::$tabla  ." WHERE tipo = '{$deporte}'";
            $resultado = self::consultarSQL($query);
            return $resultado;
        }

    Una vez ya tengo la forma de que las actividades que se muestran se filtren según el tipo o la modalidad, ahora sigue habiendo un problema y es que en la paginación si antes habia aplicado una categoría se pierde por lo que necesito que esa información se mantenga, para ello cuando sé que lo he recibido en el get hago respectivamente:

        $extra .= '&categoria=' . urlencode($_GET['categoria']);
        $extra .= '&deporte=' . urlencode($_GET['deporte']);

    Cabe añadir que la función urlenconde() es necesario ya que una de las modalidades es "En Equipo" al tener un espacion es necesario hacer esto para que funciones de manera correcta.Con esto ya tengo forma de añadir la categoria o el deporte a la hora de hacer la paginación con la forma:

        <?php if ($pag > 1): ?>  
            <a class="boton" href="?pagina=<?php echo $pag - 1 . $extra ?>">⬅ Anterior</a>
        <?php endif; ?>

        <?php if ($pag < $num_pag): ?>  
            <a class="boton" href="?pagina=<?php echo $pag + 1 . $extra ?>">Siguiente ➡</a>
        <?php endif; ?>

    Así también tengo en cuenta la categoría en la paginación. Ya he terminado la página actividades/actividades.php y ahora voy a hacer el que enseña cada imagen sola individualmente. Para ello he creado el archivo /actividades/actividad.php donde mostraré las imagenes, para hacerlo pasaré por el método get el id de la actividad:

        <a href="actividad.php?id=<?php echo $actividad->id ?>">

    Añadiendo eso en cada actividad ahora tengo que gestionarlo en actividad.php de la forma:

        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            if( isset($_GET['id'])){
                $id = $_GET['id'];
            }
        }

        $actividad = Actividades::where('id',$id);

    Así ya tengo la actividad que quiero tener ahora una vez ya he hecho tengo que ver como lo muestro, y es de la forma:

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
        </section>
        
    Una vez ya tengo como mostrar , ya puedo dar por finalizada toda esta parte, alomejor más tarde añado más información en la base de datos para que aparezco mucho más completo.

    Ahora que ya he hecho esto he terminado con toda la parte de php , el próximo paso será hacer JS , haciendo el carrusel y la corección de todos los formulario.

    Para hacer el formulario empezamos...


    
