<?php
if($logueado){
?>
<ul>
    <li><a href="index.php">Menú principal</a></li>
    <ul>
	    <li><a href="articulos.php">Artículos</a></li>
	    <ul>
		    <li><a href="agregarArticulos.php">Agregar artículo</a></li>
		    <li><a href="listaArticulos.php">Listado (eliminar / modificar)</a></li>
		    <ul>
			    <li><a href="modificarArticulos.php">Modificar artículo</a></li>
			    <li><a href="eliminarArticulos.php">Eliminar artículo</a></li>
			</ul>
		</ul>
	    <li><a href="categorias.php">Categorías</a></li>
	    <ul>
		    <li><a href="agregarCategorias.php">Agregar categoría</a></li>
		    <li><a href="listaCategorias.php">Listado (eliminar / modificar)</a></li>
		    <ul>
			    <li><a href="modificarCategorias.php">Modificar categoría</a></li>
			    <li><a href="eliminarCategorias.php">Eliminar categoría</a></li>
			</ul>
		</ul>
	    <li><a href="usuarios.php">Usuarios</a></li>
	    <ul>
		    <li><a href="listaUsuarios.php">Listado (eliminar)</a></li>
		    <ul>
			    <li><a href="eliminarUsuarios.php">Eliminar usuario</a></li>
			</ul>
		</ul>
	</ul>
</ul>	
<?php
}
?>	
