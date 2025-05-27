
<?php

require_once('ActiveRecord.php');

class Actividades extends ActiveRecord{
    // Base de datos
    protected static $tabla = 'actividades';
    protected static $columnasBD = ['id','tipo','modalidad','pistas'];

    public $id;
    public $tipo;
    public $modalidad;
    public $pistas;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->tipo = $args['tipo'] ?? '';
        $this->modalidad = $args['modalidad'] ?? null;
        $this->pistas = $args['pistas'] ?? '';
    }
}