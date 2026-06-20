

<?php

define("TEMPLATES_URL", __DIR__ . "/templates");
define("FUNCIONES_URL", __DIR__ . "funciones.php");

function incluirTemplate(string $nombre, bool $inicio = false, int $limite = 1)
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

function debuguear($variable)
{
    echo "<pre>";
    var_dump($variable);
    echo "<pre>";
    exit;
}
