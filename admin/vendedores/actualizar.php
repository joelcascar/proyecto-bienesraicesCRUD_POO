<?php

require '../../includes/app.php';

use App\Vendedor;

estaAutenticado();

$id = $_GET['id'] ?? null;
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('location: /admin');
}

$vendedor = Vendedor::find($id);

$errores = Vendedor::getErrores();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // sincronizamos los datos con la instrancia actual
    $vendedor->sincronizar($_POST['vendedor']);
    // validamos los datos actualizados
    $errores = $vendedor->validar();

    if (empty($errores)) {
        $vendedor->guardar();
    }
}

incluirTemplate('header');

?>

<main class="contenedor seccion">
    <h1>Actualizar Vendedor(a)</h1>


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
    <form method="POST" class="formulario">

        <?php
        include "../../includes/templates/formulario_vendedores.php"
        ?>
        <input type="submit" value="Actualizar Vendedor" class="boton-verde">
    </form>
</main>


<?php incluirTemplate('footer'); ?>