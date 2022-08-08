<fieldset>
    <legend>
        Informacion General
    </legend>
    <label for="titulo">Titulo</label>
    <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Titulo Propiedad" value="<?php echo s($propiedad->titulo); ?>">

    <label for="precio">Precio</label>
    <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio Propiedad" value="<?php echo  $propiedad->precio; ?>">

    <label for="imagen">imagen</label>
    <input type="file" id="imagen" name="propiedad[imagen]" accept="image/jpeg,image/png" name="imagen">

    <?php if ($propiedad->imagen) { ?>
        <img src="/imagenes/<?php echo $propiedad->imagen ?>" class="imagen-small">
    <?php } ?>

    <label for="descripcion">Descripcion:</label>
    <textarea name="propiedad[descripcion]" id="descripcion" cols="30" rows="10"><?php echo $propiedad->descripcion; ?></textarea>

</fieldset>

<fieldset>
    <legend>Informacion de la propiedad</legend>

    <label for="habitaciones">Habitaciones</label>
    <input type="number" id="habitaciones" name="propiedad[habitaciones]" placeholder="Ej:3" min="1" max="9" value="<?php echo  $propiedad->habitaciones; ?>">

    <label for="wc">Baños</label>
    <input type="number" id="wc" name="propiedad[wc]" placeholder="Ej:3" min="1" max="9" value="<?php echo  $propiedad->wc; ?>">

    <label for="estacionamientos">Estacionamientos</label>
    <input type="number" id="estacionamientos" name="propiedad[estacionamiento]" placeholder="Ej:3" min="1" max="9" value="<?php echo  $propiedad->estacionamiento; ?>">

</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    <label for="vendedor">Vendedor</label>
    <select name="propiedad[vendedorId]" id="vendedor">
        <option value="">--Seleccione un vendedor--</option>
        <?php foreach ($vendedores as $vendedor) : ?>
            <option <?php echo $propiedad->vendedorId === $vendedor->id ? 'selected' : '' ?> value="<?php echo ($vendedor->id); ?>"><?php echo ($vendedor->nombre) . " " . ($vendedor->apellido); ?></option>
        <?php endforeach ?>
    </select>
</fieldset>