<?php
require '../includes/app.php';
estaAutenticado();

// importar la conexion
$db = conectarDB();


// impplementar metodo para obtener todas las propiedades 
use App\Propiedad;
use App\Vendedor;

$propiedades = Propiedad::all();
$vendedores = Vendedor::all();


//muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {

        $tipo = $_POST['tipo'];

        if (validarTipo($tipo)) {
            // validar lo que vamos a eliminar
            if ($tipo == "vendedor") {
                $vendedor = Vendedor::findId($id);
                $vendedor->delete();
            } else if ($tipo == "propiedad") {
                $propiedad = Propiedad::findId($id);
                $propiedad->delete();
            }
        }
    }
}
includeTemplate('header');
?>
<main class="contenedor seccion">
    <h1>ADMINISTRADOR DE BIENES RAICES</h1>
    <?php
    $mensaje = mostrarNotificaciones(intval($resultado));
    if ($mensaje) : ?>
        <p class="alerta exito"><?php echo s($mensaje); ?> </p>

    <?php endif; ?>

    <a href="propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
    <a href="vendedores/crear.php" class="boton boton-amarillo">Nuevo Vendedor</a>
    <h2>Propiedades</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <!--Mostrar resultados-->
            <?php foreach ($propiedades as $propiedad) : ?>
                <tr>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td><img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla"></td>
                    <td><?php echo $propiedad->precio; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" value="Eliminar" class="boton-rojo-block">

                        </form>
                        <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id;  ?>" class="boton-verde-block">Actualizar</a>
                    </td>
                </tr>

            <?php endforeach ?>
        </tbody>
    </table>
    <h2>Vendedores</h2>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Acciones</th>

            </tr>
        </thead>

        <tbody>
            <!--Mostrar resultados-->
            <?php foreach ($vendedores as $vendedor) : ?>
                <tr>
                    <td><?php echo $vendedor->id; ?></td>
                    <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
                    <td><?php echo $vendedor->telefono; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" value="Eliminar" class="boton-rojo-block">
                        </form>
                        <a href="/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id;  ?>" class="boton-verde-block">Actualizar</a>
                    </td>
                </tr>

            <?php endforeach ?>
        </tbody>
    </table>
</main>
<?php
// cerrar la conxion
mysqli_close($db);

includeTemplate('footer');
?>