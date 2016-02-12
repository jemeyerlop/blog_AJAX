<?php
include_once 'includesEspecialesBackend/php_comun.php';
//determinar orden de la lista de articulos
$orden_nombre='';
$orden_cat='';
$orden_autor='';
$orden_creacion='';
$orden_modificacion='';
$orden_estado='';
$orden_nombreDESC='';
$orden_catDESC='';
$orden_autorDESC='';
$orden_creacionDESC='';
$orden_modificacionDESC='';
$orden_estadoDESC='';
//variable de marcar
$marcar='style="font-weight:bold"';
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
        case 'blog_usuarios.usuario_nombre':
            $orden_autor=$marcar;
            break;
        case 'articulo_fecha_creacion':
            $orden_creacion=$marcar;
            break;
        case 'articulo_fecha_modificacion':
            $orden_modificacion=$marcar;
            break;
        case 'articulo_estado':
            $orden_estado=$marcar;
            break;
        //descendentes
        case 'articulo_titulo DESC':
            $orden_nombreDESC=$marcar;
            break;
        case 'blog_categorias.cat_nombre DESC':
            $orden_catDESC=$marcar;
            break;
        case 'blog_usuarios.usuario_nombre DESC':
            $orden_autorDESC=$marcar;
            break;
        case 'articulo_fecha_creacion DESC':
            $orden_creacionDESC=$marcar;
            break;
        case 'articulo_fecha_modificacion DESC':
            $orden_modificacionDESC=$marcar;
            break;
        case 'articulo_estado DESC':
            $orden_estadoDESC=$marcar;
            break;
    }
}else{
    //orden de la consulta a la BD
    $orden='articulo_titulo';
    //determinar botón en estado seleccionado
    $orden_nombre=$marcar;
}

//conectar a la base de datos
    $bd = bd_conectar();

//paginación
//recuperar el total de elementos en la tabla
    $total_articulos = $bd->query("SELECT COUNT(*) from blog_articulos"); // Contar los elementos de la tabla
    $total = $total_articulos->fetch_row(); // Recuperar el resultado. Para acceder al numero diría $total['0'];
    $app    = 10; // articulos por pagina.
    
    //$p_actual = 1; // a. Pagina actual - b. Recuperar este valor con el GET
    $p_actual = array_key_exists('page', $_GET) ? $_GET['page'] : 1;
    $desfase = ( $p_actual - 1 ) * $app; // El punto de inicio de cada pagina
    
    $max_paginas = ceil( $total['0'] / $app ); // El numero de articulos disponbiles dividido por el numero de articulos por pagina. Redondeado hacia arriba.
    /* CON ESTOS ESTOS DATOS PODEMOS ARMAR LOS BOTONES DE PAGINACION. */
?>
<!DOCTYPE html>
<html lang="<?php include_once '../includes/lang.php';?>">
<head>
	<?php
	$titulo='listado de artículos';
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
                    <?php $mismaPagina=$_SERVER['PHP_SELF']; ?>
                    <th>Nombre<?php echo '
                        <a '.$orden_nombre.' href="'.$mismaPagina.'?orden=articulo_titulo&page='.$p_actual.'"> △</a>
                        <a '.$orden_nombreDESC.' href="'.$mismaPagina.'?orden=articulo_titulo DESC&page='.$p_actual.'"> ▽</a>' ?></th>
                    <th>Categoria<?php echo '
                        <a '.$orden_cat.' href="'.$mismaPagina.'?orden=blog_categorias.cat_nombre&page='.$p_actual.'"> △</a>
                        <a '.$orden_catDESC.' href="'.$mismaPagina.'?orden=blog_categorias.cat_nombre DESC&page='.$p_actual.'"> ▽</a>' ?></th>
                    <th>Autor<?php echo '
                        <a '.$orden_autor.' href="'.$mismaPagina.'?orden=blog_usuarios.usuario_nombre&page='.$p_actual.'"> △</a>
                        <a '.$orden_autorDESC.' href="'.$mismaPagina.'?orden=blog_usuarios.usuario_nombre DESC&page='.$p_actual.'"> ▽</a>' ?></th>
                    <th>Fecha de creación<?php echo '
                        <a '.$orden_creacion.' href="'.$mismaPagina.'?orden=articulo_fecha_creacion&page='.$p_actual.'"> △</a>
                        <a '.$orden_creacionDESC.' href="'.$mismaPagina.'?orden=articulo_fecha_creacion DESC&page='.$p_actual.'"> ▽</a>' ?></th>
                    <th>Fecha de modificación<?php echo '
                        <a '.$orden_modificacion.' href="'.$mismaPagina.'?orden=articulo_fecha_modificacion&page='.$p_actual.'"> △</a>
                        <a '.$orden_modificacionDESC.' href="'.$mismaPagina.'?orden=articulo_fecha_modificacion DESC&page='.$p_actual.'"> ▽</a>' ?></th>
                    <th>Estado<?php echo '
                        <a '.$orden_estado.' href="'.$mismaPagina.'?orden=articulo_estado&page='.$p_actual.'"> △</a>
                        <a '.$orden_estadoDESC.' href="'.$mismaPagina.'?orden=articulo_estado DESC&page='.$p_actual.'"> ▽</a>' ?></th>
                    <th class="eliminar">Eliminar</th>
                </tr>
                
                <?php
                    
                    //preparar la petición de las articulos.
                    $query = "SELECT
                                blog_articulos.articulo_id,
                                blog_articulos.articulo_titulo,
                                blog_articulos.articulo_cat_id,
                                blog_articulos.articulo_url,
                                blog_articulos.articulo_fecha_creacion,
                                blog_articulos.articulo_fecha_modificacion,
                                blog_articulos.articulo_estado,
                                blog_categorias.cat_id,
                                blog_categorias.cat_nombre,
                                blog_usuarios.usuario_id,
                                blog_usuarios.usuario_nombre,
                                blog_usuarios.usuario_apellido
                             FROM blog_articulos
                             INNER JOIN blog_categorias
                                ON blog_articulos.articulo_cat_id = blog_categorias.cat_id
                             INNER JOIN blog_usuarios
                                ON blog_articulos.articulo_usuario_id_autor = blog_usuarios.usuario_id
                             ORDER BY $orden LIMIT $desfase, $app";
                                
                    //echo '<p>'.$query.'</p>';
                    $result = $bd->query( $query );
                    //procesar resultado
                    while( $fila = $result->fetch_assoc() ) : ?>

                        <tr>
                            <td><a href="modificarArticulos.php?fid=<?php echo $fila['articulo_id'];?>" title="Modificar"><?php echo ucfirst($fila['articulo_titulo']); ?></a></td>
                            <td><?php echo ucfirst( $fila['cat_nombre']); ?></td>
                            <td><?php echo ucwords( $fila['usuario_nombre'].' '.$fila['usuario_apellido']); ?></td>
                            <td><?php echo formatTimeStamp( $fila['articulo_fecha_creacion'] ); ?></td>
                            <td><?php //es posible que la imagen no registre modificaciones hasta el momento:
                                if($fila['articulo_fecha_modificacion']<>''){
                                    echo formatTimeStamp( $fila['articulo_fecha_modificacion'] );
                                }else{
                                    echo 'Sin modificar';
                                }
                                ?>
                            </td>
                            <td><?php
                                if($fila['articulo_estado']==1){
                                    echo 'Visible';
                                }elseif($fila['articulo_estado']==2){
                                    echo 'Oculta';
                                }
                                ?>
                            </td>
                            <td class="eliminar"><?php echo '<a href="eliminarArticulos.php?id='.$fila[articulo_id].'&articulo_url='.$fila[articulo_url].'&articulo_titulo='.$fila[articulo_titulo].'">×</a>'; ?></td>
                        </tr>
                    
                    <?php endwhile; ?>
            
            </table>
        </div>
            <div class="paginacion">
                
                <?php if( $p_actual > 2 ) : ?>
                    <a href="<?php echo $_SERVER['PHP_SELF']."?orden=".$orden."&page=".($p_actual - 1);?>" class="ant">&laquo; Anterior</a>
                <?php elseif($p_actual == 2) :?>
                    <a href="<?php echo $_SERVER['PHP_SELF']."?orden=".$orden;?>" class="ant">&laquo; Anterior</a>
                <?php endif; ?>               
                <?php if( $p_actual != $max_paginas and $total[0]!=0/*si no lo hace aparecer de todas formas*/ ) : ?>
                    <a href="<?php echo $_SERVER['PHP_SELF']."?orden=".$orden."&page=".($p_actual + 1);?>" class="sig">Siguiente &raquo;</a>
                <?php endif; ?>
                
            </div>
	</section>
	</div>
</body>
</html>