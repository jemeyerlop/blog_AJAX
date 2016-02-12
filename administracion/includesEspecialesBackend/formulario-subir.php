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
		<input type="text" name="articulo-titulo" placeholder="Título artículo">
	</fieldset>
	<?php
		$bd 		= bd_conectar();
		$categorias = getArrayCategorias( $bd );
		//echo '<pre>' . print_r( $categorias, 1 ) . '</pre>';
	?>
	<fieldset>
		<label>Categoría</label>
		<select name="articulo-categoria">
			<?php while( $fila = $categorias->fetch_assoc() ) : ?>
				<option value="<?php echo $fila['cat_id'];?>"><?php echo ucfirst( $fila['cat_nombre'] );?></option>
			<?php endwhile; ?>
		</select>
	</fieldset>
	<fieldset>
		<label>Imagen</label>
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo (ereg_replace("[^0-9]","",ini_get('upload_max_filesize')))*1024*1024 ?>">
		<input type="file" name="file">
	</fieldset>


	<fieldset>
		<label>Estado</label>
		<input type="radio" name="articulo-estado" value="1" checked>
		<label>Visible</label>
		<input type="radio" name="articulo-estado" value="2">
		<label>Oculto</label>
	</fieldset>
	
	<fieldset>
		<textarea id="descripcion" name="articulo-descripcion" placeholder="Texto"></textarea>
	</fieldset>

	<fieldset>
		<input type="submit" id="submit" name="articulo-submit" value="Agregar">
		<input type="reset" id="reset" value="Limpiar campos">
	</fieldset>

</form>