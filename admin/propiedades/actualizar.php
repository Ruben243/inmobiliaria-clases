<?php

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;


require '../../includes/app.php';

estaAutenticado();
$db = conectarDB();

// Validar que sea un id valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: /admin');
}
// buscar regstro por id
$propiedad = Propiedad::findId($id);
// vendedor consulta-El nombre debe coincidir con el for each de formulario
$vendedores = Vendedor::all();


//ARREGLO CON MENSAJES DE ERRORES
$errores = Propiedad::getErrores();
// asignar valores a variables
$titulo = $propiedad->titulo;
$precio = $propiedad->precio;
$descripcion = $propiedad->descripcion;
$habitaciones = $propiedad->habitaciones;
$wc = $propiedad->wc;
$estacionamiento = $propiedad->estacionamiento;
$vendedorId = $propiedad->vendedorId;
$creado = $propiedad->creado;
$imagen = $propiedad->imagen;

//ejecutar ell codiigo despues de enviar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // asignar los atributos
    $args = [];

    $args = $_POST['propiedad'];

    $propiedad->sincronizar($args);

    $errores = $propiedad->validar();

    /*  SUBIDA DE ARCHIVOS*/
    // generar nombre aleatorio y añadir la extension
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    // SETEAR IMAGEN
    //realiza un resize a la imagen con intervention
    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        $imagen = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
        $propiedad->setImagen($nombreImagen);
    }
    if (empty($errores)) {
        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            $imagen->save(CARPETA_IMAGENES . $nombreImagen);
        }
        $propiedad->choose();
    }
}


includeTemplate('header');

?>

<main class="contenedor seccion">
    <h1>ACTUALIZAR PROPIEDAD</h1>
    <?php
    foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error;  ?>
        </div>
    <?php endforeach  ?>

    <form method="POST" class="formulario" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>
</main>

<?php
includeTemplate('footer');
?>