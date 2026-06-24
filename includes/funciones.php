

<?php

define("TEMPLATES_URL", __DIR__ . "/templates");
define("FUNCIONES_URL", __DIR__ . "funciones.php");
define("CARPETA_IMAGENES", __DIR__ . "/../imagenesDB/");

function incluirTemplate(string $nombre, bool $inicio = false, int $limite = 1): void
{
    // primera opcion
    // include TEMPLATES_URL . "/" . $nombre . ".php";

    // segunda opcion
    include TEMPLATES_URL . "/{$nombre}.php";
}


function estaAutenticado(): void
{
    session_start();
    if (!$_SESSION['login']) {
        header('location: /');
    }
}

function debuguear($variable): void
{
    echo "<pre>";
    var_dump($variable);
    echo "<pre>";
    exit;
}

// Función para sanitzar los datos antes de que se almacenen los datos
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

// Validar tipo de contenido
function validarContenido($tipo)
{
    $tipos = ['propiedad', 'vendedor'];

    return in_array($tipo, $tipos);
}
