<?php
// Evaluamos si hay datos en la supoer global $_SESSION
if (!isset($_SESSION)) {
    session_start();
}

$auth = $_SESSION['login'] ?? false;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>

<body>
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img src="/build/img/logo.svg" alt="logotipo de bienes raíces">
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="/build/img/dark-mode.svg" alt="imagen dark mode">
                    <nav class="navegacion">
                        <?php if ($auth) { ?>
                            <a href="/admin/index.php">Admin</a>
                        <?php } ?>
                        <a href="/nosotros.php">Nosotros</a>
                        <a href="/anuncios.php">Anuncios</a>
                        <a href="/blog.php">Blog</a>
                        <a href="/contacto.php">Contacto</a>
                        <?php if ($auth) { ?>
                            <a href="/cerrar-sesion.php">Cerrar Sesión</a>
                        <?php } else { ?>
                            <a href="/login.php">Iniciar Sesión</a>
                        <?php } ?>
                    </nav>
                </div>
            </div> <!-- barra -->
            <h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>
        </div>
    </header>