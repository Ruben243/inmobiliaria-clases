<?php

namespace App;

class Propiedad extends ActiveRecord {
    protected static $tabla = 'propiedades';
    protected static $columnasDB = [
        'id', 'titulo', 'imagen', 'precio', 'descripcion', 'habitaciones', 'wc', 'estacionamiento',
        'vendedorId'
    ];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;


    public function __construct($args = []) {

        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }
    public function validar() {

        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }
        if (!$this->precio) {
            self::$errores[] = "El precio es obligatorio";
        }
        if (!$this->imagen) {
            self::$errores[] = "La imagen es Obligatoria";
        }

        if (strlen($this->descripcion) < 50 && !$this->descripcion) {
            self::$errores[] = "La descripcion es obligatoria y tiene que tener mas de 50 caracteres";
        }
        if (!$this->habitaciones) {
            self::$errores[] = "Indica el numero de habitaciones";
        }
        if (!$this->wc) {
            self::$errores[] = "Indica el numero de servicios";
        }
        if (!$this->estacionamiento) {
            self::$errores[] = "Indica el numero de estacionamientos";
        }
        if (!$this->vendedorId) {
            self::$errores[] = "Elije un vendedor";
        }
        return self::$errores;
    }
}
