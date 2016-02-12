<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" novalidate">
    <fieldset>
        <label for="li-correo">Correo</label>
        <input type="email" name="li-correo" placeholder="Indícanos tu correo electrónico">
    </fieldset>

    <fieldset>
        <label for="li-contra">Contraseña</label>
        <input type="password" name="li-contra">
    </fieldset>

    <fieldset>
        <input type="submit" name="li-submit" value="Ingresar">
        <input type="reset" value="Limpiar campos">
    </fieldset>
</form>