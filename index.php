<?php
include_once 'includes/php_comun.php';
//determinar orden de la lista de articulos
$orden_nombre='';
$orden_cat='';
$orden_creacion='';
$orden_nombreDESC='';
$orden_catDESC='';
$orden_creacionDESC='';
//variable de marcar
$marcar='style="font-weight:bold;color:#E2513D;"';
if(array_key_exists('orden', $_GET)){
    //orden de la consulta a la BD
    $orden=$_GET[orden];
    //determinar botón en estado seleccionado
    switch ($_GET[orden]) {
        //ascendentes
        case 'articulo_titulo':
            $orden_nombre=$marcar;
            break;
        case 'blog_categorias.cat_nombre':
            $orden_cat=$marcar;
            break;
        case 'articulo_fecha_creacion':
            $orden_creacion=$marcar;
            break;
        //descendentes
        case 'articulo_titulo DESC':
            $orden_nombreDESC=$marcar;
            break;
        case 'blog_categorias.cat_nombre DESC':
            $orden_catDESC=$marcar;
            break;
        case 'articulo_fecha_creacion DESC':
            $orden_creacionDESC=$marcar;
            break;
    }
}else{
    //orden de la consulta a la BD
    $orden='articulo_fecha_creacion DESC';
    //determinar botón en estado seleccionado
    $orden_creacionDESC=$marcar;
}

//conectar a la base de datos
    $bd = bd_conectar();

//ver si se ha filtrado por categorías o no
	if(array_key_exists('filtrar-categoria',$_GET)){//aca en lugar de ver si esta el submit se pregunta directamente por el filtrar-categoria, ya que puede venir desde otros links de reordenamiento de la tabla o de botones del paginador
		$catSeleccionada=$_GET['filtrar-categoria'];
	}else{
		$catSeleccionada=0;//0 es el numero para la opcion de todas las categorías
	}

//paginación
//recuperar el total de elementos en la tabla, o según categoría, si se ha filtrado previamente
	if($catSeleccionada==0){
		$total_articulos = $bd->query("SELECT COUNT(*) FROM blog_articulos
										WHERE blog_articulos.articulo_estado='1'
										AND blog_articulos.articulo_cat_id<>'1'");
		// Contar todos los visibles articulo_estado='1' y que no esten en stand_by (articulo_cat_id<>'1')
	}else{
		$total_articulos = $bd->query("SELECT COUNT(*) FROM blog_articulos
										WHERE blog_articulos.articulo_estado='1'
										AND blog_articulos.articulo_cat_id<>'1'
										AND articulo_cat_id='$catSeleccionada'");
		// Contar todos los visibles articulo_estado='1' y que no esten en stand_by (articulo_cat_id<>'1'), pero de la categoría filtrada solamente
	}   
    $total = $total_articulos->fetch_row(); // Recuperar el resultado. Para acceder al numero diría $total['0'];
    $app    = 10; // articulos por pagina.
    
    //$p_actual = 1; // a. Pagina actual - b. Recuperar este valor con el GET
    $p_actual = array_key_exists('page', $_GET) ? $_GET['page'] : 1;
    $desfase = ( $p_actual - 1 ) * $app; // El punto de inicio de cada pagina
    
    $max_paginas = ceil( $total['0'] / $app ); // El numero de articulos disponbiles dividido por el numero de articulos por pagina. Redondeado hacia arriba.
    /* CON ESTOS ESTOS DATOS PODEMOS ARMAR LOS BOTONES DE PAGINACION. */
?>
<!DOCTYPE html>
<html lang="<?php include_once 'includes/lang.php';?>">
<head>
	<?php
	$titulo='Blog de arquitectura';
	$selectorActivo='#menu li a.inicio';
	include_once 'includes/head.php';
	?>
</head>
<body>
	<div id="contenedor">
	<?php
	include_once 'includes/header.php';
	include_once 'includes/nav.php';
	?>
	<section class="contenido">
		<div id="div_titulo">
			<h1>Artículos de nuestro ARQ-blog</h1>
		</div>
		<?php
		//extraer lista de categorías
		$categorias = getArrayCategorias( $bd );
		?>
		<div id="div_filtro">
			<form method="GET" action="<?php $_SERVER['PHP_SELF']; ?>">
				<fieldset>
					<label>Seleccionar categorías</label>
					<select name="filtrar-categoria">
						<option value="0"<?php if($catSeleccionada==0){echo ' selected';} ?>>Todas</option>
						<?php while( $fila = $categorias->fetch_assoc() ) : ?>
							<?php if($fila['cat_id']<>1){//para que no se seleccione el stand_by en el frontend ?>
								<?php if($fila['cat_id']==$catSeleccionada){//categoria seleccionada?>
								<option value="<?php echo $fila['cat_id'];?>" selected><?php echo ucfirst( $fila['cat_nombre'] );?></option>
								<?php }else{//categoria no seleccionada ?>
								<option value="<?php echo $fila['cat_id'];?>"><?php echo ucfirst( $fila['cat_nombre'] );?></option>
								<?php } ?>
							<?php } ?>
						<?php endwhile; ?>
					</select>
				</fieldset>
				<fieldset>
					<input type="submit" name="submit-filtrar" value="Filtrar">
				</fieldset>
			</form>
		</div>
		<div id="div_lista">
	        <div class="contenedorTabla">
	            <table>
	                <tr>
	                    <?php $mismaPagina=$_SERVER['PHP_SELF']; ?>
	                    <th>Nombre<?php echo '
	                        <a '.$orden_nombre.' href="'.$mismaPagina.'?orden=articulo_titulo&page='.$p_actual.'&filtrar-categoria='.$catSeleccionada.'"> △</a>
	                        <a '.$orden_nombreDESC.' href="'.$mismaPagina.'?orden=articulo_titulo DESC&page='.$p_actual.'&filtrar-categoria='.$catSeleccionada.'"> ▽</a>' ?></th>
	                    <th>Categoria<?php echo '
	                        <a '.$orden_cat.' href="'.$mismaPagina.'?orden=blog_categorias.cat_nombre&page='.$p_actual.'&filtrar-categoria='.$catSeleccionada.'"> △</a>
	                        <a '.$orden_catDESC.' href="'.$mismaPagina.'?orden=blog_categorias.cat_nombre DESC&page='.$p_actual.'&filtrar-categoria='.$catSeleccionada.'"> ▽</a>' ?></th>
	                    <th>Fecha de creación<?php echo '
	                        <a '.$orden_creacion.' href="'.$mismaPagina.'?orden=articulo_fecha_creacion&page='.$p_actual.'&filtrar-categoria='.$catSeleccionada.'"> △</a>
	                        <a '.$orden_creacionDESC.' href="'.$mismaPagina.'?orden=articulo_fecha_creacion DESC&page='.$p_actual.'&filtrar-categoria='.$catSeleccionada.'"> ▽</a>' ?></th>
	                </tr>
			<?php
			if($catSeleccionada==0){
				$seleccon="<>'0'";
			}else{
				$seleccon="='".$catSeleccionada."'";
			}
            $query = "SELECT
                        blog_articulos.articulo_id,
                        blog_articulos.articulo_titulo,
                        blog_articulos.articulo_cat_id,
                        blog_articulos.articulo_fecha_creacion,
                        blog_categorias.cat_id,
                        blog_categorias.cat_nombre
                     FROM blog_articulos
                     INNER JOIN blog_categorias
                        ON blog_articulos.articulo_cat_id = blog_categorias.cat_id
                     WHERE blog_articulos.articulo_cat_id".$seleccon."
                     AND blog_articulos.articulo_estado='1'
                     AND blog_articulos.articulo_cat_id<>'1'
                     ORDER BY $orden LIMIT $desfase, $app";
                     //fueron seleccionados los visibles (articulo_estado='1') y que no esten en stand_by (articulo_cat_id<>'1')
                    $result = $bd->query( $query );
                    //procesar resultado
                    while( $fila = $result->fetch_assoc() ) : ?>
                        <tr>
                            <td><a target="_blank" href="articulo.php?id=<?php echo $fila['articulo_id'];?>" title="Ver más"><?php echo ucfirst($fila['articulo_titulo']); ?></a></td>
                            <td><?php echo ucfirst( $fila['cat_nombre']); ?></td>
                            <td><?php echo formatTimeStamp( $fila['articulo_fecha_creacion'] ); ?></td>
                        </tr>
                    <?php endwhile;// echo $query;?>
            
            	</table>
        	</div>
            <div class="paginacion">
                
                <?php if( $p_actual > 2 ) : ?>
                    <a href="<?php echo $_SERVER['PHP_SELF']."?orden=".$orden."&page=".($p_actual - 1)."&filtrar-categoria=".$catSeleccionada;?>" class="ant">&laquo; Anterior</a>
                <?php elseif($p_actual == 2) :?>
                    <a href="<?php echo $_SERVER['PHP_SELF']."?orden=".$orden."&filtrar-categoria=".$catSeleccionada;?>" class="ant">&laquo; Anterior</a>
                <?php endif; ?>               
                <?php if( $p_actual != $max_paginas and $total[0]!=0/*si no lo hace aparecer de todas formas*/ ) : ?>
                    <a href="<?php echo $_SERVER['PHP_SELF']."?orden=".$orden."&page=".($p_actual + 1)."&filtrar-categoria=".$catSeleccionada;?>" class="sig">Siguiente &raquo;</a>
                <?php endif; ?>
                
            </div>
		</div>
	</section>
	<?php
	include_once 'includes/footer.php';
	?>	
	</div>
</body>
</html>