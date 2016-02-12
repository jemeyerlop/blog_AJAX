<?php
    //consulta específica del usuario actual
    $bd     = bd_conectar();
    $uid=$_SESSION[usuario_id];
    $query = "SELECT
                usuario_nombre,
                usuario_apellido,
                usuario_correo
             FROM blog_usuarios
             WHERE usuario_id='$uid'";
                
    $result = $bd->query( $query );
    $fila = $result->fetch_assoc();

    $usuario_nombre=$fila[usuario_nombre];
    $usuario_apellido=$fila[usuario_apellido];
    $usuario_correo=$fila[usuario_correo];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" novalidate">
    <fieldset>
        <label for="mod-nombre">Nombre</label>
        <input type="text" name="mod-nombre" placeholder="modifica tu nombre" value="<?php echo $usuario_nombre ?>">
    </fieldset>
    
    <fieldset>
        <label for="mod-apellido">Apellido</label>
        <input type="text" name="mod-apellido" placeholder="modifica tu apellido" value="<?php echo $usuario_apellido ?>">
    </fieldset>
    
    <fieldset>
        <label for="mod-correo">Correo</label>
        <input type="email" name="mod-correo" placeholder="modifica tu correo" value="<?php echo $usuario_correo ?>">
    </fieldset>
    
    <fieldset>
        <label for="mod-contra">Contraseña</label>
        <input type="password" name="mod-contra" placeholder="confirma tu contraseña">
    </fieldset>
    
    <fieldset>
        <input type="submit" name="mod-submit" value="Modificar">
		<input type="reset" id="reset" value="Limpiar campos" />
    </fieldset>
</form>