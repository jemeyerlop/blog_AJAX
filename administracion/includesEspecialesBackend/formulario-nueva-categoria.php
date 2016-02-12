<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
	<fieldset>
		<label for="cat-nombre">Nombre</label>
		<input type="text" name="cat-nombre" placeholder="Nombre categoría">
	</fieldset>
	<fieldset>
		<input type="submit" name="cat-submit" value="Crear">
		<input type="reset" id="reset" value="Limpiar campos">
	</fieldset>
</form>