<?php
require '../../includes/app.php';

use App\Propiedad;
// Importamos el driver del manager de imagenes.
use Intervention\Image\Drivers\Gd\Driver;
// Importamos el manejador de imagenes y el alias se va a llamr image
use Intervention\Image\ImageManager as Image;

// Verificamos si la sesión esta abierta
estaAutenticado();


// base de datos
$db = conectarDB();

// Consulta para obtener vendedores de la base de datos.
$sql = "SELECT * FROM vendedores;";
$query = mysqli_query($db, $sql);

// Me imprime el arreglo asociativo de la consulta de la base de datos.

// echo "<pre>";
// var_dump(mysqli_fetch_all($query));
// echo "<pre>";

// variables donde almacenaremos los datos
$titulo = "";
$precio = "";
$descripcion = "";
$habitaciones = "";
$wc = "";
$estacionamiento = "";
$vendedores_id = "";
$imagen = '';


// Arreglo de errores.
$errores = Propiedad::getErrores();

// Manejamos los datos que llegan del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Instanciamos la clase propiedad y le añadimos los datos del formulario.
    $propiedad = new Propiedad($_POST);

    // 1 Generar nombre único a la imagen.
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg"; // Este nombre lo pasamos a la consulta SQL.

    // 2 Leemos la imagen
    if ($_FILES['imagen']['tmp_name']) {
        // Configuramos el manager de imagenes con el drive por defecto.
        $manager = Image::usingDriver(Driver::class); // el Driver::class me asignara el driver por defecto.
        // Leemos la imagen
        $imagen = $manager->decode($_FILES['imagen']['tmp_name']);
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
        $resultado = $propiedad->guardar();

        if ($resultado) {
            // Redireccionar al usuario una vez ingresados los datos.
            // Se debe de utilizar poco. 
            header('location: /admin?resultado=1'); // ?resultado=1 vamos a poderlo manejar con $_GET
        }
    }


    // Asignar $_FILES a una veriable
    $imagen = $_FILES['imagen'];
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
        <fieldset>
            <legend>Información General</legend>

            <div>
                <label for="titulo">Titulo</label>
                <input type="text" placeholder="Titulo Propiedad" id="titulo" name="titulo" value="<?php echo $titulo; ?>">
            </div>

            <div>
                <label for="precio">Precio</label>
                <input type="number" placeholder="Precio Propiedad" id="precio" name="precio" value="<?php echo $precio; ?>">
            </div>

            <div>
                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
            </div>

            <div>
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
            </div>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>

            <div>
                <label for="habitaciones">Habitaciones</label>
                <input type="number" name="habitaciones" id="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">
            </div>

            <div>
                <label for="wc">Baños</label>
                <input type="number" name="wc" id="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">
            </div>

            <div>
                <label for="estacionamiento">Estacionamiento</label>
                <input type="number" name="estacionamiento" id="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento; ?>">
            </div>
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>
            <!-- Select utilizando unicamente HTML -->
            <!--
            <select name="vendedores_id">
                <option selected value="">-- seleccione --</option>
                <option value="1">Joel</option>
                <option value="2">Sarai</option>
            </select>
             -->

            <!-- Select con datos consultados de la base de datos -->
            <select name="vendedores_id">
                <option selected value="">-- seleccione --</option>
                <?php while ($row = mysqli_fetch_assoc($query)) { ?>
                    <option <?php echo $vendedores_id === $row['id'] ? 'selected' : ''; ?> value="<?php echo $row['id']; ?>"><?php echo $row['nombre'] . " " . $row['apellido']; ?></option>
                <?php } ?>
            </select>
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton-verde">
    </form>




</main>

<?php incluirTemplate('footer') ?>