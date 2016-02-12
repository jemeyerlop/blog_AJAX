<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" novalidate">
    <fieldset>
        <label for="reg-nombre">Nombre</label>
        <input type="text" name="reg-nombre" placeholder="Indícanos tu nombre">
    </fieldset>
    
    <fieldset>
        <label for="reg-apellido">Apellido</label>
        <input type="text" name="reg-apellido" placeholder="Indícanos tu apellido">
    </fieldset>
    
    <fieldset>
        <label for="reg-correo">Correo</label>
        <input type="email" name="reg-correo" placeholder="Indícanos tu correo electrónico">
    </fieldset>
    
    <fieldset>
        <label for="reg-contra">Contraseña</label>
        <input type="password" name="reg-contra">
    </fieldset>
    
    <fieldset>
        <input type="submit" name="reg-submit" value="Regístrate">
		<input type="reset" id="reset" value="Limpiar campos" />
    </fieldset> 
</form>