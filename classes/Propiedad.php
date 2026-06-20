<?php

namespace App;

class Propiedad
{
    // Atributos espejo de la tabla propiedades de la base de datos.
    protected static $db = "";
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
        $this->imagen = $args['imagen'] ?? 'imagen.jpg';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? 0;
        $this->wc = $args['wc'] ?? 0;
        $this->estacionamiento = $args['estacionamiento'] ?? 0;
        $this->creado = $args['creado'] ?? date('Y-m-d');
        $this->vendedores_id = $args['vendedores_id'] ?? 0;
    }

    public function guardar()
    {
        // Insertamos los valores en la base de datos, realizamos una consulta a la base de datos.
        $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, creado, habitaciones, wc, estacionamiento, vendedores_id) VALUES ('$this->titulo', $this->precio, '$this->imagen', '$this->descripcion', '$this->creado', $this->habitaciones, $this->wc, $this->estacionamiento, $this->vendedores_id);";
    }

    public static function establecerDB($db)
    {
        // self hace referencia al atributo estático
        self::$db = $db;
    }
}
