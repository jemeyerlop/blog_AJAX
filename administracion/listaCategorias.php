<?php
include_once 'includesEspecialesBackend/php_comun.php';
?>
<!DOCTYPE html>
<html lang="<?php include_once '../includes/lang.php';?>">
<head>
	<?php
	$titulo='Listado de categorías';
	include_once 'includesEspecialesBackend/head.php';
	?>
</head>
<body>
	<div id="contenedor">
	<?php
	include_once '../includes/header.php';
	include_once 'includesEspecialesBackend/nav.php';
	?>
	<div id="breadcrumb"><?php include_once 'includesEspecialesBackend/mapaNav.php'; ?></div>
	<section class="contenido">
        <div class="contenedorTabla">
            <table>
                <tr>
                    <th>Categoría</th>
                    <th>Fecha de creación</th>
                    <th class="eliminar">Eliminar</th>
                </tr>
                <?php
                    //conectar a la base de datos
                    $bd = bd_conectar();
                    //paginación
                    //recuperar el total de elementos en la tabla.
                        $total_cat = $bd->query("SELECT COUNT(*) from blog_categorias"); // Contar los elementos de la tabla.
                        $total = $total_cat->fetch_row(); // Recuperar el resultado. Para acceder al numero diría $total['0'];
                        $cpp    = 10; // categorias por pagina.
                        //$p_actual = 1; // a. Pagina actual - b. Recuperar este valor con el GET
                        $p_actual = array_key_exists('page', $_GET) ? $_GET['page'] : 1;
                        $desfase = ( $p_actual - 1 ) * $cpp; // El punto de inicio de cada pagina   
                        $max_paginas = ceil( $total['0'] / $cpp ); // El numero de categorias disponbiles dividido por el numero de categorias por pagina. Redondeado hacia arriba.                     
                    //preparar la petición de las categorias.
                    $query="SELECT * FROM blog_categorias
                            WHERE cat_id<>'1'
                            ORDER BY cat_nombre LIMIT $desfase, $cpp";//se excluye el cat_id 1 porque es la categoría stand_by y no se debe eliminar ni modificar        
                    $result = $bd->query( $query );
                    //procesar resultado
                    while( $fila = $result->fetch_assoc() ) : ?>
                        <tr>
                            <td><a href="modificarCategorias.php?cid=<?php echo $fila['cat_id'];?>" title="Modificar categoría"><?php echo $fila['cat_nombre'];?></a></td>
                            <td><?php echo formatTimeStamp($fila['cat_fecha_creacion']);?></td>
                            <td class="eliminar"><?php echo '<a href="eliminarCategorias.php?id='.$fila[cat_id].'&cat_nombre='.$fila[cat_nombre].'">×</a>'; ?></td>
                        </tr>
                    <?php endwhile; ?>
            </table>
        </div>
            <div class="paginacion">
                <?php if( $p_actual > 2 ) : ?>
                    <a href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . ($p_actual - 1);?>" class="ant">&laquo; Anterior</a>
                <?php elseif($p_actual == 2) :?>
                    <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="ant">&laquo; Anterior</a>
                <?php endif; ?>               
                <?php if( $p_actual != $max_paginas and $total[0]!=0/*si no lo hace aparecer de todas formas*/ ) : ?>
                    <a href="<?php echo $_SERVER['PHP_SELF']. "?page=" . ($p_actual + 1); ?>" class="sig">Siguiente &raquo;</a>
                <?php endif; ?>
            </div>
	</section>
	</div>
</body>
</html>