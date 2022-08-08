<?php

require '../../includes/app.php';

use App\Vendedor;

estaAutenticado();

$vendedor = new Vendedor();
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location:/admin');
}

// obtener el array del vendedor
$vendedor = Vendedor::findId($id);

//ARREGLO CON MENSAJES DE ERRORES
$errores = Vendedor::getErrores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $args = $_POST['vendedor'];
   
    $vendedor->sincronizar($args);

    $errores = $vendedor->validarVendedor();
    if (empty($errores)) {
        $vendedor->choose();
    }
}

includeTemplate('header');


?>
<main class="contenedor seccion">
    <h1>ACTUALIZAR VENDEDOR/A</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php
    foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error;  ?>
        </div>
    <?php endforeach  ?>

    <form method="POST" class="formulario" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <input type="submit" value="Guardar Cambios" class="boton boton-verde">
    </form>

</main>

<?php
includeTemplate('footer');
?>