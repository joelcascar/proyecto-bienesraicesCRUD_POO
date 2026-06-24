<fieldset>
    <legend>Información General</legend>

    <div>
        <label for="nombre">Nombre</label>
        <input type="text" placeholder="Nombre del vendedor(a)" id="nombre" name="vendedor[nombre]" value="<?php echo s($vendedor->nombre); ?>">
    </div>
    <div>
        <label for="apellido">Apellido</label>
        <input type="text" placeholder="Apellido del vendedor(a)" id="apellido" name="vendedor[apellido]" value="<?php echo s($vendedor->apellido); ?>">
    </div>
</fieldset>

<fieldset>
    <legend>Información Extra</legend>
    <div>
        <label for="telefono">Teléfono</label>
        <input type="tel" placeholder="Teléfono del vendedor(a)" id="telefono" name="vendedor[telefono]" value="<?php echo s($vendedor->telefono); ?>">
    </div>
</fieldset>