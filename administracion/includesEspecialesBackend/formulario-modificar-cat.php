<?php
	//consulta específica de la categoría elegida
	$cid=$_GET[cid];
	$query = "SELECT * FROM blog_categorias
			 WHERE cat_id='$cid'";
				
	$result	= $bd->query( $query );
	$fila = $result->fetch_assoc();

	$cat_nombre=$fila[cat_nombre];
	$cid=$fila[cat_id];

?>
<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">	
	<fieldset>
		<label for="editar-cat-nombre">Nombre</label>
		<input type="text" name="editar-cat-nombre" placeholder="Nombre de la categoría" value="<?php echo $cat_nombre ?>">
	</fieldset>
	<fieldset>
		<input type="hidden" name="cid" value="<?php echo $cid ?>">
		<input type="submit" id="submit" name="editar-cat-submit" value="Modificar">
		<input type="reset" id="reset" value="Limpiar campos">
	</fieldset>

</form>