<?php
include_once 'includesEspecialesBackend/php_comun.php';
//determinar orden de la lista de usuarios
$orden_nombre='';
$orden_apellido='';
$orden_correo='';
$orden_fecha_registro='';
$orden_nombreDESC='';
$orden_apellidoDESC='';
$orden_correoDESC='';
$orden_fecha_registroDESC='';
//variable de marcar
$marcar='style="font-weight:bold"';
if(array_key_exists('orden', $_GET)){
    //orden de la consulta a la BD
    $orden=$_GET[orden];
    //determinar botón en estado seleccionado
    switch ($_GET[orden]) {
        //ascendentes
        case 'usuario_nombre':
            $orden_nombre=$marcar;
            break;
        case 'usuario_apellido':
            $orden_apellido=$marcar;
            break;
        case 'usuario_correo':
            $orden_correo=$marcar;
            break;
        case 'usuario_fecha_registro':
            $orden_fecha_registro=$marcar;
            break;
        //descendentes
        case 'usuario_nombre DESC':
            $orden_nombreDESC=$marcar;
            break;
        case 'usuario_apellido DESC':
            $orden_apellidoDESC=$marcar;
            break;
        case 'usuario_correo DESC':
            $orden_correoDESC=$marcar;
            break;
        case 'usuario_fecha_registro DESC':
            $orden_fecha_registroDESC=$marcar;
            break;
    }
}else{
    //orden de la consulta a la BD
    $orden='usuario_correo';
    //determinar botón en estado seleccionado
    $orden_nombre=$marcar;
}

//conectar a la base de datos
    $bd = bd_conectar();

//paginación
//recuperar el total de elementos en la tabla
    $total_usuarios = $bd->query("SELECT COUNT(*) from blog_usuarios"); // Contar los elementos de la tabla
    $total = $total_usuarios->fetch_row(); // Recuperar el resultado. Para acceder al numero diría $total['0'];
    $upp    = 10; // usuarios por pagina.
    
    //$p_actual = 1; // a. Pagina actual - b. Recuperar este valor con el GET
    $p_actual = array_key_exists('page', $_GET) ? $_GET['page'] : 1;
    $desfase = ( $p_actual - 1 ) * $upp; // El punto de inicio de cada pagina
    $max_paginas = ceil( $total['0'] / $upp ); // El numero de usuarios disponbiles dividido por el numero de usuarios por pagina. Redondeado hacia arriba.
    /* CON ESTOS ESTOS DATOS PODEMOS ARMAR LOS BOTONES DE PAGINACION. */
?>
<!DOCTYPE html>
<html lang="<?php include_once '../includes/lang.php';?>">
<head>
	<?php
	$titulo='listado de usuarios';
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
                        <a '.$orden_nombre.' href="'.$mismaPagina.'?orden=usuario_nombre&page='.$p_actual.'"> △</a>
                        <a '.$orden_nombreDESC.' href="'.$mismaPagina.'?orden=usuario_nombre DESC&page='.$p_actual.'"> ▽</a>' ?></th>
                    <th>Apellido<?php echo '
                        <a '.$orden_apellido.' href="'.$mismaPagina.'?orden=usuario_apellido&page='.$p_actual.'"> △</a>
                        <a '.$orden_apellidoDESC.' href="'.$mismaPagina.'?orden=usuario_apellido DESC&page='.$p_actual.'"> ▽</a>' ?></th>
                    <th>Correo<?php echo '
                        <a '.$orden_correo.' href="'.$mismaPagina.'?orden=usuario_correo&page='.$p_actual.'"> △</a>
                        <a '.$orden_correoDESC.' href="'.$mismaPagina.'?orden=usuario_correo DESC&page='.$p_actual.'"> ▽</a>' ?></th>
                    <th>Fecha de registro<?php echo '
                        <a '.$orden_fecha_registro.' href="'.$mismaPagina.'?orden=usuario_fecha_registro&page='.$p_actual.'"> △</a>
                        <a '.$orden_fecha_registroDESC.' href="'.$mismaPagina.'?orden=usuario_fecha_registro DESC&page='.$p_actual.'"> ▽</a>' ?></th>
                    <th class="eliminar">Eliminar</th>
                </tr>
                
                <?php
                    
                    //preparar la petición de los usuarios.
                    $query = "SELECT
                                usuario_id,
                                usuario_nombre,
                                usuario_apellido,
                                usuario_correo,
                                usuario_fecha_registro
                             FROM blog_usuarios
                             WHERE usuario_rol <> 1
                             ORDER BY $orden LIMIT $desfase, $upp";//WHERE usuario_rol <> 1 para no poder eliminar al administrador
                                
                    //echo '<p>'.$query.'</p>';
                    $result = $bd->query( $query );
                    //procesar resultado
                    while( $fila = $result->fetch_assoc() ) : ?>

                        <tr>
                            <td><?php echo ucfirst($fila['usuario_nombre']); ?></td>
                            <td><?php echo ucfirst( $fila['usuario_apellido']); ?></td>
                            <td><?php echo ucwords( $fila['usuario_correo']); ?></td>
                            <td><?php echo formatTimeStamp( $fila['usuario_fecha_registro'] ); ?></td>
                            <td class="eliminar"><?php echo '<a href="eliminarUsuarios.php?usuario_id='.$fila[usuario_id].'&usuario_nombre='.$fila[usuario_nombre].'&usuario_apellido='.$fila[usuario_apellido].'">×</a>'; ?></td>
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