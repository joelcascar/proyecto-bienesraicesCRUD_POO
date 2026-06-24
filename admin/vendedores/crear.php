<?php

require '../../includes/app.php';

use App\Vendedor;

estaAutenticado();

$vendedor = new Vendedor;

$errores = Vendedor::getErrores();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Creamos una nueva instancia
    $vendedor = new Vendedor($_POST['vendedor']);
    // validamos el vendedor
    $errores = $vendedor->validar();

    if (empty($errores)) {
        $vendedor->guardar();
    }
}

incluirTemplate('header');

?>

<main class="contenedor seccion">
    <h1>Registrar Vendedor(a)</h1>


    <a href="/admin" class="boton-verde">Volver</a> <!-- html siempre buscara el archivo index, por eso no necesitamos definir el nombre del archivo (/admin/index.php) -->

    <?php
    // Imprimir los errores en la página
    foreach ($errores as $error) {
    ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <!-- Para enviar archivos a traves del formulario utilizamos el atributo enctype="multipart/form-data -->
    <form method="post" action="/admin/vendedores/crear.php" class="formulario">

        <?php
        include "../../includes/templates/formulario_vendedores.php"
        ?>
        <input type="submit" value="Registrar Vendedor" class="boton-verde">
    </form>
</main>


<?php incluirTemplate('footer'); ?>