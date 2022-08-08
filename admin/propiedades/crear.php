<?php
require '../../includes/app.php';

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

estaAutenticado();
includeTemplate('header');

$propiedad = new Propiedad();

// Consulta para obtener todos los vendedores
$vendedores=Vendedor::all();


//ARREGLO CON MENSAJES DE ERRORES
$errores = Propiedad::getErrores();

//ejecutar ell codigo despues de enviar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $propiedad = new Propiedad($_POST['propiedad']);
    /*  SUBIDA DE ARCHIVOS*/
    // generar nombre aleatorio y añadir la extension
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    // SETEAR IMAGEN
    //realiza un resize a la imagen con intervention
    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        $imagen = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
        $propiedad->setImagen($nombreImagen);
    }
    $errores = $propiedad->validar();
    if (empty($errores)) {
        // crear carpeta para subir imagenes
        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }

        // Guarda la imagen en el servidor
        $imagen->save(CARPETA_IMAGENES . $nombreImagen);


        // guards en la db
        $resultado = $propiedad->guardar();

    
    }
}

?>
<main class="contenedor seccion">
    <h1>CREAR</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php
    foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error;  ?>
        </div>
    <?php endforeach  ?>

    <form action="/admin/propiedades/crear.php" method="POST" class="formulario" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>

</main>

<?php
includeTemplate('footer');
?>