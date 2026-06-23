<?php
require '../../includes/app.php';

use App\Propiedad;
// Importamos el driver del manager de imagenes.
use Intervention\Image\Drivers\Gd\Driver;
// Importamos el manejador de imagenes y el alias se va a llamr image
use Intervention\Image\ImageManager as Image;

// Verificamos si la sesión esta abierta
estaAutenticado();

// Creamos una instancia de propiedad sin inicializar los atributos
$propiedad = new Propiedad;

// base de datos
$db = conectarDB();

// Consulta para obtener vendedores de la base de datos.
$sql = "SELECT * FROM vendedores;";
$query = mysqli_query($db, $sql);

// Arreglo de errores.
$errores = Propiedad::getErrores();

// Manejamos los datos que llegan del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Instanciamos la clase propiedad y le añadimos los datos del formulario.
    $propiedad = new Propiedad($_POST['propiedad']);

    // 1 Generar nombre único a la imagen.
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg"; // Este nombre lo pasamos a la consulta SQL.

    // 2 Leemos la imagen
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

    // Validamos si hay errores cunado se mando el formulario.
    $errores = $propiedad->validar();
    // Si el arreglo $errores esta vacio guarda los datos.
    if (empty($errores)) {
        // Subir archivos al servidor
        if (!is_dir(CARPETA_IMAGENES)) { // is_dir(ruta); me devuelve true si la carpeta existe y false si la carpeta no existe.
            mkdir(CARPETA_IMAGENES); // Crea la carpeta en la ubicación establecida.
        }
        // 3 Guardamos la imagen en el servidor
        $imagen->save(CARPETA_IMAGENES . $nombreImagen);
        // Insertamos los datos en la base de datos.
        $propiedad->guardar();
    }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>


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
    <form method="post" action="/admin/propiedades/crear.php" class="formulario" enctype="multipart/form-data">

        <?php
        include "../../includes/templates/formulario_propiedades.php"
        ?>
        <input type="submit" value="Crear Propiedad" class="boton-verde">
    </form>
</main>

<?php incluirTemplate('footer'); ?>