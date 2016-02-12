<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" novalidate">
    <fieldset>
        <label for="ct-nombre">Nombre</label>
        <input type="text" name="ct-nombre" placeholder="Nombre">
    </fieldset>
    <fieldset>
        <label for="ct-apellido">Apellido</label>
        <input type="text" name="ct-apellido" placeholder="Apellido">
    </fieldset>
    <fieldset>
        <label for="ct-correo">Correo</label>
        <input type="email" name="ct-correo" placeholder="Correo Electrónico">
    </fieldset>
    <fieldset>
        <label for="ct-mensaje">Mensaje</label>
        <textarea name="ct-mensaje" placeholder="Tu mensaje"></textarea>
    </fieldset>
    <fieldset>
        <input type="submit" id="submit" name="submit-correo" value="Enviar">
        <input type="reset" id="reset" value="Limpiar campos">
    </fieldset>
</form>