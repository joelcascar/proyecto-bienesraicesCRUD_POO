<?php

namespace App;

class Propiedad
{
    // Atributos espejo de la tabla propiedades de la base de datos.
    protected static $db;
    // Definimos las columnas de la tabla de la base de datos
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];
    // Atributo que contendra los errores de la validación
    protected static $errores = [];
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? 0;
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? 0;
        $this->wc = $args['wc'] ?? 0;
        $this->estacionamiento = $args['estacionamiento'] ?? 0;
        $this->creado = $args['creado'] ?? date('Y-m-d');
        $this->vendedores_id = $args['vendedores_id'] ?? 0;
    }

    public static function establecerDB($db)
    {
        // self hace referencia al atributo estático
        self::$db = $db;
    }

    public function guardar()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarDatos();

        // Insertamos los valores en la base de datos, realizamos una consulta a la base de datos.
        $consulta = "INSERT INTO propiedades (";
        $consulta .= join(", ", array_keys($atributos)) . ") VALUES('";
        $consulta .= join("', '", array_values($atributos)) . "');";

        // Realizamos la consulta
        return self::$db->query($consulta);
    }

    // Esta función sirve para unir los atributos en un arreglo asociativo
    public function atributos()
    {
        $atributos = [];

        foreach (self::$columnasDB as $columna) {
            if ($columna === 'id') continue; // en caso de que $columna sea igual a id se va a pasar a la siguiente interacción.
            $atributos[$columna] = $this->$columna;
        }

        return $atributos;
    }

    // Esta función sirve para sanitizar los atributos 
    public function sanitizarDatos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $p => $v) {
            $sanitizado[$p] = self::$db->escape_string($v);
        }

        return $sanitizado;
    }

    // Método para obtener los errores de la validación.
    public static function getErrores()
    {
        return self::$errores;
    }

    // Método para validar los datos enviados al servidor.
    public function validar()
    {
        // validaciones antes de realizar la consulta
        if (!$this->titulo) {
            self::$errores[] = "ERROR: El título es obligatorio";
        };
        if (!$this->precio) {
            self::$errores[] = "ERROR: El precio es obligatorio";
        };
        if (!$this->descripcion) {
            self::$errores[] = "ERROR: La descripción es obligatoria";
        };
        if (strlen($this->descripcion) < 50) {
            self::$errores[] = "ERROR: La descripción no cumple con al menos 50 caracteres";
        };
        if (strlen($this->descripcion) > 250) {
            self::$errores[] = "ERROR: La descripción excede el limite de 250 carácteres permitidos";
        };
        if (!$this->habitaciones) {
            self::$errores[] = "ERROR: El Número de habitaciones es obligatorio";
        };
        if (!$this->wc) {
            self::$errores[] = "ERROR: El número de baños es obligatorio";
        };
        if (!$this->estacionamiento) {
            self::$errores[] = "ERROR: El número de lugares de estacionamiento es obligatorio";
        };

        if ($this->vendedores_id == "") {
            self::$errores[] = "ERROR: El vendedor es obligatorio";
        };

        // Validación de la imagen

        if (!$this->imagen) {
            self::$errores[] = "Error: la imagen es obligatoria";
        }

        return self::$errores;
    }

    public function setImagen($imagen)
    {
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }
}
