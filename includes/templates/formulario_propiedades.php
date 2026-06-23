<fieldset>
    <legend>Información General</legend>

    <div>
        <label for="titulo">Titulo</label>
        <input type="text" placeholder="Titulo Propiedad" id="titulo" name="propiedad[titulo]" value="<?php echo s($propiedad->titulo); ?>">
    </div>

    <div>
        <label for="precio">Precio</label>
        <input type="number" placeholder="Precio Propiedad" id="precio" name="propiedad[precio]" value="<?php echo s($propiedad->precio); ?>">
    </div>

    <div>
        <label for="imagen">Imagen</label>
        <input type="file" id="imagen" accept="image/jpeg, image/png" name="propiedad[imagen]">
    </div>

    <?php if ($propiedad->imagen) { ?>
        <img src="/imagenesDB/<?php echo $propiedad->imagen; ?>" alt="" class="imagen-small">
    <?php } ?>

    <div>
        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="propiedad[descripcion]"><?php echo s($propiedad->descripcion); ?></textarea>
    </div>
</fieldset>

<fieldset>
    <legend>Información Propiedad</legend>

    <div>
        <label for="habitaciones">Habitaciones</label>
        <input type="number" name="propiedad[habitaciones]" id="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->habitaciones); ?>">
    </div>

    <div>
        <label for="wc">Baños</label>
        <input type="number" name="propiedad[wc]" id="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->wc); ?>">
    </div>

    <div>
        <label for="estacionamiento">Estacionamiento</label>
        <input type="number" name="propiedad[estacionamiento]" id="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->estacionamiento); ?>">
    </div>
</fieldset>

<fieldset>
    <legend>Vendedor</legend>
</fieldset>