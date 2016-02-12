<?php
	//consulta específica del articulo elegido
	$fid=$_GET[fid];
	$query = "SELECT
				articulo_titulo,
				articulo_desc,
				articulo_cat_id,
				articulo_url,
				articulo_estado
			 FROM blog_articulos
			 WHERE articulo_id='$fid'";
				
	$result	= $bd->query( $query );
	$fila = $result->fetch_assoc();

	$articulo_titulo=$fila[articulo_titulo];
	$articulo_desc=htmlspecialchars_decode($fila[articulo_desc]);//con esta funcion se decodifican las etiquetas html para que aparezcan en el tinymce correctamente
	$articulo_cat_id=$fila[articulo_cat_id];
	$articulo_url=$fila[articulo_url];
	$articulo_estado=$fila[articulo_estado];

	//consulta general de categorías
	$categorias = getArrayCategorias( $bd );
?>
<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
	<script src="js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
	tinymce.init({
	    selector: "#descripcion",
	    height: 400,
	    plugins: "paste link fullscreen",//los plugins deben ir mas arriba de donde se usan (por ejemplo '| link unlink |')
	    menubar: false,
	    toolbar: "bold italic | cut copy paste | bullist numlist | undo redo removeformat | link unlink | fullscreen",
	    paste_as_text: true,
	    skin: "camaraoscura"
	 });
	//www.tinymce.com
	</script>
	<fieldset>
		<label>Título</label>
		<input type="text" name="editar-articulo-titulo" placeholder="Título artículo" value="<?php echo $articulo_titulo ?>">
	</fieldset>
	<fieldset>
		<label>Categoría</label>
		<select name="editar-articulo-categoria">
			<?php while( $fila = $categorias->fetch_assoc() ) : ?>
				<?php if($fila['cat_id']==$articulo_cat_id){//categoria seleccionada?>
				<option value="<?php echo $fila['cat_id'];?>" selected><?php echo ucfirst( $fila['cat_nombre'] );?></option>
				<?php }else{//categoria no seleccionada ?>
				<option value="<?php echo $fila['cat_id'];?>"><?php echo ucfirst( $fila['cat_nombre'] );?></option>
				<?php } ?>
			<?php endwhile; ?>
		</select>
	</fieldset>
	<fieldset>
		<label>Imagen actual</label>
		<img width="33%" src="<?php echo "subidas/".$articulo_url?>" >
	</fieldset>
	<input type="hidden" name="foto-antigua" value="<?php echo $articulo_url ?>">
	<fieldset>
		<label>Cambiar imagen</label>
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo (ereg_replace("[^0-9]","",ini_get('upload_max_filesize')))*1024*1024 ?>">
		<input type="file" name="file">
	</fieldset>
	<fieldset>
		<label>Estado</label>
		<input type="radio" name="editar-articulo-estado" value="1"<?php if($articulo_estado==1){echo 'checked';} ?>>
		<label>Visible</label>
		<input type="radio" name="editar-articulo-estado" value="2"<?php if($articulo_estado==2){echo 'checked';} ?>>
		<label>Oculto</label>
	</fieldset>
	<fieldset>
		<textarea id="descripcion" name="editar-articulo-descripcion" placeholder="Texto"><?php echo $articulo_desc ?></textarea>
	</fieldset>
	<fieldset>
		<input type="hidden" name="fid" value="<?php echo $fid ?>">
		<input type="submit" id="submit" name="editar-articulo-submit" value="Modificar">
		<input type="reset" id="reset" value="Limpiar campos">
	</fieldset>
</form>