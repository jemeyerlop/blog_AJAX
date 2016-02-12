<?php
include_once 'includesEspecialesBackend/php_comun.php';
?>
<!DOCTYPE html>
<html lang="<?php include_once '../includes/lang.php';?>">
<head>
	<?php
	$titulo='Eliminar artículo';
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
// Confirmó que desea eliminar el artículo tras la pregunta
////////

                    $bd = bd_conectar();

                    $eliminacion="DELETE FROM blog_articulos WHERE articulo_id='$_GET[id]'";
                    $resultado=$bd->query( $eliminacion );
                    if($bd->affected_rows==1){
                        $carpeta    =RUTA_ROOT . "/administracion/subidas/";
                        $filename   =$carpeta.$_GET[articulo_url];
                        if (file_exists($filename))
                            {
                            unlink($filename);
                            }
                        //eliminar comentarios vinculados al articulo
                        $eliminacionComentarios="DELETE FROM blog_comentarios WHERE comentario_articulo_id='$_GET[id]'";
                        $resultadoEliminacionComentarios=$bd->query( $eliminacionComentarios );
                        notificar('El registro fue eliminado','exito');
                    }else{
                        notificar('No se pudo eliminar el registro');
                    }
                
                }elseif(array_key_exists("id", $_GET) ){
////////
//viene desde haber pinchado un articulo en listaArticulos.php y se procede a preguntar si realmente quiere eliminarlo
////////            
                    $mensaje='¿Realmente desea eliminar el artículo \''.$_GET[articulo_titulo].'\'?<br>
                    <a style="color:#FFF" href="'.$_SERVER[REQUEST_URI].'&confirmacion=x">▸ Sí</a><br>
                    <a style="color:#FFF" href="listaArticulos.php">▸ No</a>';
                    notificar($mensaje,'pregunta');
                } 
                else{
////////
// Entró directo escribiendo la dirección sin elegir un articulo, por lo tanto, se redirecciona a la lista
////////
                    notificar('Debe elegir un artículo');
                    exit;
                }
                
            ?> 
	</section>
	</div>
</body>
</html>