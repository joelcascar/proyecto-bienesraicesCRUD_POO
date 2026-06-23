<?php

require '../includes/app.php';
// Verificamos si la sesión esta abierta
estaAutenticado();

use App\Propiedad;

// método estático all() para obtener todas las propiedades de la base de datos
$query = Propiedad::all();

$resultado = $_GET["resultado"] ?? NULL; // obtenemos lo que nos manda cuando realizamos la inserción.


// Código para eliminar una propiedad
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {

        // 1 obtenemos el objeto de propiedad
        $propiedad = Propiedad::find($id);

        // 2 Eliminamos la propiedad con el método eliminar()
        $propiedad->eliminar();
    }
}


incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>
    <?php if (intval($resultado) === 1) { ?>
        <p class="alerta exito">Propiedad creada correctamente</p>
    <?php }
    if (intval($resultado) === 2) { ?>
        <p class="alerta exito">Propiedad actualizada correctamente</p>
    <?php } ?>
    <?php if (intval($resultado) === 3) { ?>
        <p class="alerta exito">Propiedad eliminada correctamente</p>
    <?php } ?>

    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($query as $propiedad) { ?>
                <tr>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td> <img src="/imagenesDB/<?php echo $propiedad->imagen; ?>" alt="" class="imagen_tabla"></td>
                    <td>$ <?php echo $propiedad->precio; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</main>

<?php incluirTemplate('footer') ?>