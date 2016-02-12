<?php
include_once 'includesEspecialesBackend/php_comun.php';
?>
<!DOCTYPE html>
<html lang="<?php include_once '../includes/lang.php';?>">
<head>
	<?php
	$titulo='Eliminar usuario';
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
            <?php
                if(array_key_exists("confirmacion", $_GET) ){
////////                
// Confirmó que desea eliminar el usuario tras la pregunta
////////

                    $bd = bd_conectar();

                    $eliminacionUsuario="DELETE FROM blog_usuarios
                                         WHERE usuario_id='$_GET[usuario_id]'
                                         AND usuario_rol<>1";//para evitar eliminar al administrador
                    $resultadoEliminacionUsuario=$bd->query( $eliminacionUsuario );
                    if($bd->affected_rows==1){
                        $eliminacionComentarios="DELETE FROM blog_comentarios WHERE comentario_usuario_id_autor='$_GET[usuario_id]'";
                        $resultadoEliminacionComentarios=$bd->query( $eliminacionComentarios );
                        notificar('El usuario fue eliminado junto con sus comentarios','exito');
                    }else{
                        notificar('No se pudo eliminar el registro');
                    }
                
                }elseif(array_key_exists("usuario_id", $_GET) ){
////////
//viene desde haber pinchado un usuario y se procede a preguntar si realmente quiere eliminarlo
////////            
                    $mensaje='¿Realmente desea eliminar al usuario \''.$_GET[usuario_nombre].' '.$_GET[usuario_apellido].'\'?<br>
                    <a style="color:#FFF" href="'.$_SERVER[REQUEST_URI].'&confirmacion=x">▸ Sí</a><br>
                    <a style="color:#FFF" href="listaUsuarios.php">▸ No</a>';
                    notificar($mensaje,'pregunta');
                } 
                else{
////////
// Entró directo escribiendo la dirección sin elegir un usuario, por lo tanto, se redirecciona a la lista
////////
                    notificar('Debe elegir un usuario');
                    exit;
                }
                
            ?> 
	</section>
	</div>
</body>
</html>