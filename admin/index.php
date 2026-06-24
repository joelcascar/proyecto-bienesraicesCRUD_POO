<?php

require '../includes/app.php';
// Verificamos si la sesión esta abierta
estaAutenticado();

// Impoortar las clases
use App\Propiedad;
use App\Vendedor;

// método estático all() para obtener todas las propiedades de la base de datos
$query = Propiedad::all();
$vendedores = Vendedor::all();
// obtenemos lo que nos manda cuando realizamos la consulta.
$resultado = $_GET["resultado"] ?? NULL;


// Código para eliminar una propiedad
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        $tipo = $_POST['tipo'];

        if (validarContenido($tipo)) {
            // Compara lo que vamos a eliminar
            if ($tipo === 'propiedad') {
                // 1 obtenemos el objeto de propiedad
                $propiedad = Propiedad::find($id);
                // 2 Eliminamos la propiedad con el método eliminar()
                $propiedad->eliminar();
            } else if ($tipo === 'vendedor') {
                // obtenemos el objeto de vendedor
                $vendedor = Vendedor::find($id);
                // Eliminamos el objeto de vendedor
                $vendedor->eliminar();
            }
        }
    }
}


incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>
    <!-- Mostrar las notificaciones de creado, actualizado y eliminado -->
    <?php $mensaje = mostrarNotificacion(intval($resultado));
    if ($mensaje) { ?>
        <p class="alerta exito"><?php echo s($mensaje); ?></p>
    <?php } ?>


    <a href="/admin/propiedades/crear.php" class="boton-verde">Nueva Propiedad</a>
    <a href="/admin/vendedores/crear.php" class="boton-amarillo">Nuevo Vendedor</a>

    <h2>Propiedades</h2>

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
                            <!-- Mandamos el id del vendedor -->
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <!-- Mandamos el tipo de id para diferenciarlo -->
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h2>Vendedores</h2>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendedores as $vendedor) { ?>
                <tr>
                    <td><?php echo $vendedor->id; ?></td>
                    <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
                    <td><?php echo $vendedor->telefono; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <!-- Mandamos el id del vendedor -->
                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <!-- Mandamos el tipo de id para diferenciarlo -->
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</main>

<?php incluirTemplate('footer') ?>