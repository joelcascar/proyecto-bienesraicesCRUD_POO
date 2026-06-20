<?php
require 'includes/app.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Conoce Sobre Nosotros</h1>
    <div class="nosotros">
        <div class="imagen">
            <picture>
                <source srcset="build/img/nosotros.webp" type="image/webp">
                <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                <img loading="lazy" src="build/img/nosotros.jpg" alt="Sobre Nosotros">
            </picture>

        </div>

        <div class="texto-nosotros">
            <blockquote>25 años de experiencia</blockquote>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Pariatur asperiores id, vero reiciendis sit eaque distinctio magni cum suscipit qui eius corporis molestias similique nisi illo iste, neque, inventore alias. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum quasi ex asperiores tenetur earum molestias amet corporis fugit doloribus libero!</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur sunt repudiandae saepe doloremque veniam nostrum itaque natus modi tempore dolorum veritatis aut inventore, similique, officiis aspernatur, perspiciatis asperiores magni eveniet molestias? Labore sunt in assumenda esse unde harum ea voluptatibus?</p>
        </div>
    </div>
</main>

<section class="contenedor seccion">
    <h1>Más sobre nosotros</h1>

    <div class="iconos-nosotros">
        <div class="icono">
            <img src="build/img/icono1.svg" alt="Icono seguridad" loading="lazy">
            <h3>Seguridad</h3>
            <p>Aliquam voluptates doloremque fuga sequi quam sed architecto reprehenderit in! Fuga illum molestias delectus nobis nemo, deleniti expedita laboriosam doloribus id labore.</p>
        </div>
        <div class="icono">
            <img src="build/img/icono2.svg" alt="Icono precio" loading="lazy">
            <h3>Precio</h3>
            <p>Aliquam voluptates doloremque fuga sequi quam sed architecto reprehenderit in! Fuga illum molestias delectus nobis nemo, deleniti expedita laboriosam doloribus id labore.</p>
        </div>
        <div class="icono">
            <img src="build/img/icono3.svg" alt="Icono tiempo" loading="lazy">
            <h3>A Tiempo</h3>
            <p>Aliquam voluptates doloremque fuga sequi quam sed architecto reprehenderit in! Fuga illum molestias delectus nobis nemo, deleniti expedita laboriosam doloribus id labore.</p>
        </div>
    </div>
</section>

<?php incluirTemplate('footer') ?>