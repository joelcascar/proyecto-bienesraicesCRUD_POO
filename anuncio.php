<?php
// Importamos la clase
use App\Propiedad;
// obtenemos el id

$id = $_GET['id'];
// validamos el id
$id = filter_var($id, FILTER_VALIDATE_INT);
if (!$id) {
    header('location: /');
}

require 'includes/app.php';

$propiedad = Propiedad::find($id);

incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $propiedad->titulo; ?></h1>

    <img loading="lazy" src="imagenesDB/<?php echo $propiedad->imagen; ?>" alt="">

    <div class="resumen-propiedad">
        <p class="precio">$ <?php echo $propiedad->precio; ?></p>
        <ul class="iconos-caracteristicas">
            <li>
                <img class="icono tamaño-iconos" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                <p><?php echo $propiedad->wc; ?></p>
            </li>
            <li>
                <img class="icono tamaño-iconos" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                <p><?php echo $propiedad->estacionamiento; ?></p>
            </li>
            <li>
                <img class="icono tamaño-iconos" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono dormitorio">
                <p><?php echo $propiedad->habitaciones; ?></p>
            </li>
        </ul>

        <p><?php echo $propiedad->descripcion; ?></p>
    </div>
</main>

<?php incluirTemplate('footer'); ?>