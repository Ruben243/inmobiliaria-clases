<?php

namespace App;

class ActiveRecord {
    // base de datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';
    // Validacion
    protected static $errores = [];

    // definir la conexion a la base de datos
    public static function setDB($database) {
        self::$db = $database;
    }

    // validacion
    public static function getErrores() {
        return self::$errores;
    }

    // subida de archivos
    public function setImagen($imagen) {
        // elimina la imagen previa
        if (!is_null($this->id)) {
            $this->borrarImagen();
        }
        // asignar nombre imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }


    // eliminar archivo
    public function borrarImagen() {
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    public function atributos() {
        $atributos = [];
        foreach (static::$columnasDB as  $columna) {
            if ($columna === 'id') {
                continue;
            }
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }


    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    public static function consultarSQL($query) {
        // consultar base de datos
        $resultado = self::$db->query($query);
        // iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
        // liberar memoria
        $resultado->free();

        // retornar resultados
        return $array;
    }


    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }


    public function validar() {
        static::$errores = [];
        return self::$errores;
    }

    // Sincroniza e objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = []) {
        foreach ($args as $key => $value) :
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        endforeach;
    }


    /**....................METODOS DEL CRUD...................... */

    // lista toda las propiedades
    public static function all() {
        $query = "select * from " . static::$tabla . "";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca una registro por su id
    public static function findId($id) {
        $query = "select * from " . static::$tabla . " where id=${id}";
        $resultado = self::consultarSQL(($query));

        return array_shift($resultado);
    }

    public function delete() {
        $query = "delete from " . static::$tabla . " where id=" . self::$db->escape_string($this->id) . " limit 1";
        $resultado = self::$db->query($query);
        if ($resultado) {
            $this->borrarImagen();
            header('Location:/admin?resultado=3');
        }
    }

    // ELIGE ENTRE UNA FUNCION U OTRA
    public function choose() {
        !is_null($this->id) ?  $this->update() : $this->guardar();
    }


    // ACTUALIZA UN REGISTRO
    public function update() {
        $atributos = $this->sanitizarAtributos();
        $valores = [];
        foreach ($atributos as $key => $value) :
            $valores[] = "{$key}='{$value}'";

        endforeach;
        $insert = join(',', $valores);
        $query = "Update " . static::$tabla . " set " . $insert . " where id='" . self::$db->escape_string($this->id) . "' limit 1";
        $resultado = self::$db->query($query);
        if ($resultado) {
            //Redireccion al usuario
            header('Location:/admin?resultado=2');
        }
    }

    // CREA UN NUEVO REGISTRO
    public function guardar() {
        $atributos = $this->sanitizarAtributos();
        //insertar base de datos
        $query = "insert into " . static::$tabla . "(";
        $query .= join(',', array_keys($atributos)); //join crea un nuevo string con las llaves del array,toma dos parametros el separador y el array que vas aplanar
        $query .= " ) values('";
        $query .= join("','", array_values($atributos)); //join crea un nuevo string con las valores  del array,toma dos parametros el separador y el array que vas aplanar
        $query .= "')";
        $resultado =  self::$db->query($query);
        //Redireccion al usuario
        if ($resultado) {
            header('Location:/admin?resultado=1');
        }
    }
}
