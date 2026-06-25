<?php

use App\Propiedad;

// Condición para definir numero de propiedades mostradas
if ($_SERVER['SCRIPT_NAME'] === "/anuncios.php") {
    $propiedades = Propiedad::all();
} else {
    $propiedades = Propiedad::get(3);
}
?>

<div class="contenedor-anuncios">
    <?php foreach ($propiedades as $propiedad) { ?>
        <div class="anuncio">
            <img class="imagen_principal" loading="lazy" src="imagenesDB/<?php echo $propiedad->imagen; ?>" alt="Imagen Propiedad">

            <div class="contenido-anuncio">
                <h3 class="tamaño-titulo"><?php echo $propiedad->titulo; ?></h3>
                <p class="tamaño_descripcion"><?php echo $propiedad->descripcion; ?></p>
                <p class="precio">$ <?php echo $propiedad->precio; ?></p>
                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                        <p><?php echo $propiedad->wc; ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                        <p><?php echo $propiedad->estacionamiento; ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono dormitorio">
                        <p><?php echo $propiedad->habitaciones; ?></p>
                    </li>
                </ul>
                <a href="anuncio.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">
                    Ver propiedad
                </a>
            </div> <!-- contenido anundio -->
        </div> <!-- anuncio -->
    <?php } ?>
</div> <!-- Contenedor de anuncios -->