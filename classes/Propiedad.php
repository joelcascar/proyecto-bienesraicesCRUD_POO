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
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = $args['creado'] ?? date('Y-m-d');
        $this->vendedores_id = $args['vendedores_id'] ?? 1;
    }

    public static function establecerDB($db)
    {
        // self hace referencia al atributo estático
        self::$db = $db;
    }

    // método para saber si se va a crear o actualizar una propiedad
    public function guardar()
    {
        if (!is_null($this->id)) {
            // actualizamos una propiedad  
            $this->actualizar();
        } else {
            // creamos una propiedad
            $this->crear();
        }
    }

    // método para crear una propiedad
    public function crear()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarDatos();

        // Insertamos los valores en la base de datos, realizamos una consulta a la base de datos.
        $consulta = "INSERT INTO propiedades (";
        $consulta .= join(", ", array_keys($atributos)) . ") VALUES('";
        $consulta .= join("', '", array_values($atributos)) . "');";

        // Realizamos la consulta
        $query = self::$db->query($consulta);

        // redireccionamos al usuario
        if ($query) {
            // Redireccionar al usuario una vez ingresados los datos.
            // Se debe de utilizar poco. 
            header('location: /admin?resultado=1'); // ?resultado=1 vamos a poderlo manejar con $_GET
        }
    }

    // método para actualizar una propiedad
    public function actualizar()
    {
        // sanitizamos los atributos
        $atributos = $this->sanitizarDatos();

        $valores = [];
        foreach ($atributos as $p => $v) {
            $valores[] = "$p = '$v'";
        }

        // formulaamos la consulta
        $consulta = "UPDATE propiedades SET ";
        $consulta .= join(", ", $valores);
        $consulta .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $consulta .= "LIMIT 1;";

        // Ejecutamos la consulta
        $query = self::$db->query($consulta);

        if ($query) {
            // Redireccionar al usuario una vez ingresados los datos.
            // Se debe de utilizar poco. 
            header('location: /admin?resultado=2'); // ?resultado=1 vamos a poderlo manejar con $_GET
        }
    }

    // método para eliminar un registro
    public function eliminar()
    {
        // definimos la consulta
        $consulta = "DELETE FROM propiedades WHERE id = " . self::$db->escape_string($this->id)  .  " LIMIT 1;";
        // realizamos la consulta
        $query = self::$db->query($consulta);
        // Redireccionamos si la realización de la consulta fue exitosa
        if ($query) {
            $this->eliminarImagen();
            header("location: /admin?resultado=3");
        }
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
        if ($this->precio > 100000000) {
            self::$errores[] = "ERROR: El precio supera el limite permitido";
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
        // Eliminamos la imagen anterior 
        if (!is_null($this->id)) {
            $this->eliminarImagen();
        }
        // Asignamos el nombre de la imagen al atributo de la instancia
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    // Elimina el archivo (imagen)
    public function eliminarImagen()
    {
        // Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    // método para listar todos los registros
    public static function all()
    {
        $consulta = "SELECT * FROM propiedades";
        $query = self::consultarSQL($consulta);
        return $query;
    }

    // método para buscar un registro
    public static function find($id)
    {

        $consulta = "SELECT * FROM propiedades WHERE id = $id;";
        $query = self::consultarSQL($consulta);
        return array_shift($query);
    }

    // método estático para realizar la consulta
    public static function consultarSQL($query)
    {
        // Primero realizamos la consulta sql
        $query = self::$db->query($query);
        // Segundo iteramos sobre los resultados
        // array me va a devolver un arreglo de objetos
        $array = [];
        while ($registro = $query->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }
        // tercero liberamos la memoria (opcional)
        $query->free();
        // cuarto retornar los resultados
        return $array;
    }
    // este método estático me va a devolver un objeto de cada registro.
    protected static function crearObjeto($registro)
    {
        // Creamos una instancia de esta clase (Propiedad).
        $objeto = new self;
        // iteramos el arreglo asociativo para convertirlo en objeto
        foreach ($registro as $p => $v) {
            if (property_exists($objeto, $p)) {
                $objeto->$p = $v;
            }
        }
        // Devolvemos el objeto creado
        return $objeto;
    }

    // método sincronizar para poner los nuevos cambios en el objeto actual.
    public function sincronizar($arr = []): void
    {
        foreach ($arr as $p => $v) {
            if (property_exists($this, $p) && !is_null($v)) {
                $this->$p = $v;
            }
        }
    }
}
