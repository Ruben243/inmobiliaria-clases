<?php


define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');


function includeTemplate(String $nombre, bool $inicio = false) {
    include TEMPLATES_URL . "/${nombre}.php";
}

function estaAutenticado(): void {
    session_start();
    if (!$_SESSION['login']) {
        header("Location: /");
    }
}
// escapa html
function s($html): string {
    $s = htmlspecialchars($html);
    return $s;
}

function debugear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// validad tipo de contenio
function validarTipo($tipo) {
    $tipos = ['vendedor', 'propiedad'];
    return in_array($tipo, $tipos);
}

// muestra los mensajes
function mostrarNotificaciones($codigo) {
    $mensaje = "";

    switch ($codigo) {
        case 1:
            $mensaje = "Creado Correctamente";
            break;
        case 2:
            $mensaje = "Actualizado Correctamente";
            break;
        case 3:
            $mensaje = "Eliminado Correctamente";
            break;

        default:
            $mensaje=false;
            break;
    }
    return $mensaje;
}
