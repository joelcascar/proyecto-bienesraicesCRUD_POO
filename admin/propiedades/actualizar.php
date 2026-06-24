<?php
require '../../includes/app.php';
// Verificamos si la sesión esta abierta
estaAutenticado();

use App\Propiedad;
use App\Vendedor;

// Importamos el driver del manager de imagenes.
use Intervention\Image\Drivers\Gd\Driver;
// Importamos el manejador de imagenes y el alias se va a llamr image
use Intervention\Image\ImageManager as Image;
// Validar un ID
// 1 Obtenemos el id de la propiedad
$id = $_GET['id'];
// 2 verificamos si el id recibido sea un numero
$id = filter_var($id, FILTER_VALIDATE_INT);
// 3 En caso de que $id este vacio o no haya redireccionamos.
if (!$id) {
    header("location: /admin");
}

// me devolvera un arreglo de un objeto.
$propiedad = Propiedad::find($id);

// traemos todos los vendedores
$vendedores = Vendedor::all();

// Arreglo de errores.
$errores = Propiedad::getErrores();

// Manejar los datos a actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Primera opcion para mandar el arreglo a que se actualice con la instancia actual.

    // $args = [];
    // $args['titulo'] = $_POST['titulo'] ?? null;
    // $args['precio'] = $_POST['precio'] ?? null;

    // Segunda opcion recomendada  
    // 1 actualizamos los name de titulo a propiedad[titulo];
    // 2 asignamos el $_POST en el arreglo
    $args = $_POST['propiedad'];
    // sincronizamos los datos enviados por el formulario con la instancia actual.
    $propiedad->sincronizar($args);
    // Validamos si hay algun error
    $errores = $propiedad->validar();

    // validación subida de imagenes
    // 1 Generar nombre único a la imagen.
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg"; // Este nombre lo pasamos a la consulta SQL.
    // 2 Leemos la imagen

    $imagen = NULL;

    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        // Configuramos el manager de imagenes con el drive por defecto.
        $manager = Image::usingDriver(Driver::class); // el Driver::class me asignara el driver por defecto.
        // Leemos la imagen
        $imagen = $manager->decode($_FILES['propiedad']['tmp_name']['imagen']);
        // Cambiamos el tamaño de la imagen
        $imagen->cover(800, 600); // Primero pone el tamaño de la imgen, despues lo coloca en el centro y corta el exceso.
        // Asignamos el nombre mediante el método setImagen()
        $propiedad->setImagen($nombreImagen); // vamos a agregar el nombre de la imagen a la instancia actual ($propiedad).
    }

    // Revisamos si el arreglo de errores esta vacio, si esta vacio realiza la consulta.
    if (empty($errores)) {
        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            // Guardamos la imagen en la carpeta
            $imagen->save(CARPETA_IMAGENES . $nombreImagen);
        }
        // Actualizamos la propiedad en la base de datos.
        $propiedad->guardar();
    }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>


    <a href="/admin" class="boton boton-verde">Volver</a> <!-- html siempre buscara el archivo index, por eso no necesitamos definir el nombre del archivo (/admin/index.php) -->

    <?php
    // Imprimir los errores en la página
    foreach ($errores as $error) {
    ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <!-- Para enviar archivos a traves del formulario utilizamos el atributo enctype="multipart/form-data -->
    <form method="post" class="formulario" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <input type="submit" value="Actualizar Propiedad" class="boton-verde">
    </form>
</main>

<?php incluirTemplate('footer') ?>