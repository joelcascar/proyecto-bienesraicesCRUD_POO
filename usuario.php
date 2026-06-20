<?php

require 'includes/app.php';
// importar la conexion

$db = conectarDB();

// Crear un email y password

$email = "correo@correo.com";
$password = "12345";
// Hasheamos la contraseña
$password = password_hash($password, PASSWORD_DEFAULT);

// Query para crear el usuario.
$consulta = "INSERT INTO usuarios (email, password) VALUES ('$email', '$password');";

// Agregarlo a la base de datos.
$query = mysqli_query($db, $consulta);
