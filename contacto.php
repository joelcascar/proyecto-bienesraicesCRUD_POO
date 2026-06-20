<?php
require 'includes/app.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Contacto</h1>
    <picture>
        <source srcset="build/img/destacada3.webp" type="image/webp">
        <source srcset="build/img/destacada3.jpg" type="image/jpeg">
        <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen Contacto">
    </picture>

    <h2>Llene el formulariop de contacto</h2>

    <form class="formulario">
        <fieldset>
            <legend>Información Personal</legend>

            <div class="campo">
                <label for="nombre">nombre</label>
                <input type="text" placeholder="Tu Nombre" id="nombre">
            </div>
            <div class="campo">
                <label for="email">e-mail</label>
                <input type="email" placeholder="Tu correo electrónico" id="email">
            </div>
            <div class="campo">
                <label for="telefono">teléfono</label>
                <input type="tel" placeholder="Tu Teléfono" id="telefono">
            </div>

            <div class="campo">
                <label for="mensaje">mensaje</label>
                <textarea id="mensaje"></textarea>
            </div>
        </fieldset>

        <fieldset>
            <legend>Información sobre la Propiedad</legend>
            <div class="campo">
                <label for="opciones">Vende o compra</label>
                <select id="opciones">
                    <option disabled selected>-- Seleccione --</option>
                    <option value="compra">Compra</option>
                    <option value="vende">Vende</option>
                </select>
            </div>
            <div class="campo">
                <label for="presupuesto">Precio o Presupuesto</label>
                <input type="number" placeholder="Tu Precio o Presupuesto" id="presupuesto">
            </div>
        </fieldset>

        <fieldset>
            <legend>COntacto</legend>

            <p>Como desea ser contactado</p>

            <div class="forma-contacto">
                <label for="contactar-telefono">Teléfono</label>
                <input type="radio" id="contactar-telefono" value="Teléfono" name="contacto">
                <label for="contactar-email">E-mail</label>
                <input type="radio" id="contactar-email" value="email" name="contacto">
            </div>

            <div>
                <p>Si eligió teléfono, elija la fecha y la hora</p>
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha">
                <label for="hora">Hora</label>
                <input type="time" id="hora" min="08:00" max="18:00">
            </div>
        </fieldset>
        <input type="submit" value="enviar" class="boton-verde">
    </form>
</main>

<?php incluirTemplate('footer'); ?>