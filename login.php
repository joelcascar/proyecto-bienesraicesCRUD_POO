<?php
require 'includes/app.php';
// Importar la base de datos
$db = conectarDB();

$email = '';

// Errores
$errores = [];

// Autenticar el usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Definimos las variables
    $email = $_POST['email'];
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // validamos el email
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $email = mysqli_real_escape_string($db, $email);

    if (!$email) {
        $errores[] = "ERROR: El email es obligatorio o no es valido.";
    }

    if (!$password) {
        $errores[] = "ERROR: La contraseña es obligatoria.";
    }

    if (empty($errores)) {
        // Verificamos si el usuario existe.
        $sql = "SELECT * FROM usuarios WHERE email = '$email';";
        $query = mysqli_query($db, $sql);
        if (!$query->num_rows) {
            $errores[] = "ERROR: El usario no existe";
        } else {
            // Revisamos si el password es correcto
            $usuario = mysqli_fetch_assoc($query);
            $passwordHash = $usuario['password'];
            $auth = password_verify($password, $passwordHash);
            if ($auth) {
                // El usuario esta autenticado
                // iniciar la sesión
                session_start();
                // llenar el arreglo de sesion
                $_SESSION['usuario'] = $email;
                $_SESSION['login'] = true;

                header("location: /admin");
            } else {
                $errores[] = "ERROR: La contraseña no es correcta";
            }
        }
    }
}


incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar sesión</h1>

    <?php foreach ($errores as $error) { ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <form method="POST" class="formulario">
        <fieldset>
            <legend>Email y Password</legend>

            <div>
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Tu email" name="email" value="<?php echo $email; ?>">
            </div>
            <div>
                <label for="password">Contraseñá</label>
                <input type="password" id="password" placeholder="Tu password" name="password">
            </div>
        </fieldset>
        <input type="submit" class="b boton-verde" value="Iniciar Sesión">
    </form>
</main>

<?php incluirTemplate('footer') ?>