<?php

require '../../includes/app.php';

use App\Vendedor;

estaAutenticado();

$vendedor = new Vendedor();

//ARREGLO CON MENSAJES DE ERRORES
$errores = Vendedor::getErrores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // crear nueva instancia
    $vendedor = new Vendedor($_POST['vendedor']);

    // validar no campos vacios
    $errores = $vendedor->validarVendedor();
    if (empty($errores)) {
        $vendedor->choose();
    }
}

includeTemplate('header');


?>
<main class="contenedor seccion">
    <h1>REGISTRAR VENDEDOR/A</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php
    foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error;  ?>
        </div>
    <?php endforeach  ?>

    <form action="/admin/vendedores/crear.php" method="POST" class="formulario" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <input type="submit" value="Registrar Vendedor/a" class="boton boton-verde">
    </form>

</main>

<?php
includeTemplate('footer');
?>