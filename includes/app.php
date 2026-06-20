<!-- Definimos las rutas a los include -->
<?php

require "funciones.php";
require "config/database.php";
require __DIR__ . "/../vendor/autoload.php";

// Importamos las clases con el namespace
use App\Propiedad;

// obteniendo la base de datos
$db = conectarDB();

// establecemos la BD en la clase, por lo que cada instancia va a tener la bd
Propiedad::establecerDB($db);
