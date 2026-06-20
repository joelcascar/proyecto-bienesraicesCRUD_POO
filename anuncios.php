<?php
require 'includes/app.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h2>Casas y Depas en Venta</h2>

    <?php
    incluirTemplate("anuncios", false, 10); ?>

</main>

<?php incluirTemplate('footer'); ?>