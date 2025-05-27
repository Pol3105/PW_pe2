
<?php

require_once('ActiveRecord.php');

class Usuario extends ActiveRecord{
    // Base de datos
    protected static $tabla = 'usuario';
    protected static $columnasBD = ['id','nombre','email','edad','contraseña','admin'];

    public $id;
    public $nombre;
    public $email;
    public $edad;
    public $contraseña;
    public $admin;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? null;
        $this->edad = $args['edad'] ?? '';
        $this->contraseña = $args['contraseña'] ?? '';
        $this->admin = $args['admin'] ?? '0';
    }


    // Verificaciones con la contraseña
    public function ComprobacionContraseña($valor) {
        return password_verify($valor, $this->contraseña);
    }
    
    // Hasheo de la contraseña
    public function HasheoContraseña() {
        if (!empty($this->contraseña)) {
            $this->contraseña = password_hash($this->contraseña, PASSWORD_DEFAULT);
        }
    }
    
}