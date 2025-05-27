<?php

require_once( __DIR__ . '/../models/ActiveRecord.php');

// Conexión a la base de datos    // nombre    // contraseña       // Nombre BD
$db = mysqli_connect('localhost', 'root',      'root',            'pw_pe2'        );

// Gestión de error al conectarse con la base de datos
if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}

ActiveRecord::setDB($db);

// Función para debugear el código
function debuguear($variable) : string 
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string 
{
    $s = htmlspecialchars($html);
    return $s;
}
