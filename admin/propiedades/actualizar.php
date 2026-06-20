<?php
require '../../includes/app.php';
// Verificamos si la sesión esta abierta
estaAutenticado();
// base de datos
$db = conectarDB();
// Validar un ID
// 1 Obtenemos el id de la propiedad
$id = $_GET['id'];
// 2 verificamos si el id recibido sea un numero
$id = filter_var($id, FILTER_VALIDATE_INT);
// 3 En caso de que $id este vacio o no haya redireccionamos.
if (!$id) {
    header("location: /admin");
}
// Consultar la propiedad con el id recibido
$sql = "SELECT * FROM propiedades WHERE id = $id;";
// Ejecutamos la consulta
$query = mysqli_query($db, $sql);
// Almacenamos el arreglo asociativo de la propiedad seleccionada
$datos = mysqli_fetch_assoc($query);


// variables donde almacenaremos los datos
$titulo = $datos['titulo'] ?? NULL;
$precio = $datos['precio'] ?? NULL;
$descripcion = $datos['descripcion'] ?? NULL;
$habitaciones = $datos['habitaciones'] ?? NULL;
$wc = $datos['wc'] ?? NULL;
$estacionamiento = $datos['estacionamiento'] ?? NULL;
$vendedores_id = $datos['vendedores_id'] ?? NULL;
$imagenPropiedad = $datos['imagen'];

// consulta para vendedores
$consulta = "SELECT * FROM vendedores;";
// realizar la consulta
$res = mysqli_query($db, $consulta);


// Arreglo de errores.
$errores = [];

// Manejar los datos a actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // echo '<pre>';
    // var_dump($_POST);
    // echo '<pre>';


    // Almacenamos los valores recibidos desde el formulario.
    $titulo = mysqli_real_escape_string($db, $_POST['titulo']); // Le agregamos la función mysqli_real_scape_string() 
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $creado = date('Y-m-d');
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $vendedores_id = mysqli_real_escape_string($db, $_POST['vendedores_id']);

    // Asignar $_FILES a una veriable
    $imagen = $_FILES['imagen'];

    // validaciones antes de realizar la consulta
    if (!$titulo) {
        $errores[] = "ERROR: El título es obligatorio";
    };
    if (!$precio) {
        $errores[] = "ERROR: El precio es obligatorio";
    };
    if (!$descripcion) {
        $errores[] = "ERROR: La descripción es obligatoria";
    };
    if (strlen($descripcion) < 50) {
        $errores[] = "ERROR: La descripción no cumple con al menos 50 caracteres";
    };
    if (strlen($descripcion) > 250) {
        $errores[] = "ERROR: La descripción excede el limite de 250 carácteres permitidos";
    };
    if (!$habitaciones) {
        $errores[] = "ERROR: El Número de habitaciones es obligatorio";
    };
    if (!$wc) {
        $errores[] = "ERROR: El número de baños es obligatorio";
    };
    if (!$estacionamiento) {
        $errores[] = "ERROR: El número de lugares de estacionamiento es obligatorio";
    };

    if ($vendedores_id == "") {
        $errores[] = "ERROR: El vendedor es obligatorio";
    };

    // Convertir Bytes a KBytes
    $medida = 1000 * 1000;

    if ($imagen['size'] > $medida) {
        $errores[] = "Error: la imagen pesa más de 500 KB";
    }

    // Revisamos si el arreglo de errores esta vacio, si esta vacio realiza la consulta.
    if (empty($errores)) {


        // Subir archivos al servidor
        // 1. creamos la carpeta
        $carpetaImagenes = '../../imagenesDB';

        if (!is_dir($carpetaImagenes)) { // is_dir(ruta); me devuelve true si la carpeta existe y false si la carpeta no existe.
            mkdir($carpetaImagenes); // Crea la carpeta en la ubicación establecida.
        }

        $nombreImagen = '';

        // Eliminar una imagen en caso de haber subido otra
        if ($imagen['name']) {
            // Eliminar la imagen previa
            unlink("$carpetaImagenes/$imagenPropiedad");
            // Generar nombre único.
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg"; // Este nombre lo pasamos a la consulta SQL.
            // Mover la imagen de la carpeta temporal a la carpeta creada con el nombre único
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . "/{$nombreImagen}");
        } else {
            $nombreImagen = $imagenPropiedad;
        }

        // Insertamos los valores en la base de datos, realizamos una consulta a la base de datos.
        $query = "UPDATE propiedades SET titulo = '$titulo', precio = $precio, imagen = '$nombreImagen', descripcion = '$descripcion', habitaciones = $habitaciones, wc = $wc, estacionamiento = $estacionamiento, vendedores_id = $vendedores_id WHERE id = $id;";

        // echo $query;

        // Ejecutar el script en MySQL
        $resultado = mysqli_query($db, $query);
        if ($resultado) {
            // Redireccionar al usuario una vez ingresados los datos.
            // Se debe de utilizar poco. 
            header('location: /admin?resultado=2'); // ?resultado=1 vamos a poderlo manejar con $_GET
        }
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

            <img src="/imagenesDB/<?php echo $imagenPropiedad; ?>" alt="" class="imagen-small">

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
                <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                    <option <?php echo $vendedores_id === $row['id'] ? 'selected' : ''; ?> value="<?php echo $row['id']; ?>"><?php echo $row['nombre'] . " " . $row['apellido']; ?></option>
                <?php } ?>
            </select>
        </fieldset>

        <input type="submit" value="Actualizar Propiedad" class="boton-verde">
    </form>
</main>

<?php incluirTemplate('footer') ?>