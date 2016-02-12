<?php
include_once 'includesEspecialesBackend/php_comun.php';
?>
<!DOCTYPE html>
<html lang="<?php include_once '../includes/lang.php';?>">
<head>
	<?php
	$titulo='Eliminar categoría';
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
// Ha confirmado que desea eliminar la categoría
////////
                if(array_key_exists("accion_articulos", $_GET)){//se ha indicado qué se quiere hacer con los articulos de la categoría
                    $bd = bd_conectar();
                    //eliminar la categoría
                    $eliminacion_cat="DELETE FROM blog_categorias WHERE cat_id='$_GET[id]' AND cat_id<>'1'";//está prohibido eliminar la categoría stand_by que tiene id_cat=1
                    $resultado_cat=$bd->query( $eliminacion_cat );
                    if($bd->affected_rows==1){//se eliminó la categoría
                        $mensaje='Se ha eliminado la categoría \''.$_GET[cat_nombre].'\' y se han ';
                        //consultamos los articulos pertenecientes a esa categoría eliminada para posteriormente ejecutar ya sea el bucle de eliminar los articulos o el de pasarlos a la categoría stand-by
                        $consulta_articulos="SELECT articulo_url,articulo_id,articulo_titulo FROM blog_articulos WHERE articulo_cat_id='$_GET[id]'";
                        $resultado_articulos    = $bd->query( $consulta_articulos );
                        if($_GET[accion_articulos]=='eliminar'){//se desea eliminar los articulos de la categoría eliminada
                            //con los datos  de $consulta_articulos se ejecutará un bucle para eliminar los articulos
                            $carpeta    =RUTA_ROOT . "/img/subidas/";
                            while( $fila = $resultado_articulos->fetch_assoc() ){
                                //echo '<p>'.$fila[articulo_id].' '.$fila[articulo_url].'</p>';
                                //borramos el archivo de imagen
                                $filename=$carpeta.$fila[articulo_url];
                                if (file_exists($filename))
                                    {
                                    unlink($filename);
                                    }
                                //borramos el registro en la bd
                                $eliminacion_articulo="DELETE FROM blog_articulos WHERE articulo_id='$fila[articulo_id]'";
                                //eliminar comentarios vinculados al articulo
		                        $eliminacionComentarios="DELETE FROM blog_comentarios WHERE comentario_articulo_id='$fila[articulo_id]'";
		                        $resultadoEliminacionComentarios=$bd->query( $eliminacionComentarios );
                                $resultado_eliminacion_articulo=$bd->query( $eliminacion_articulo );
                                if($bd->affected_rows==1){
                                    $articulos_eliminados.='<br>- '.$fila[articulo_titulo];
                                }   
                            }
                            notificar($mensaje.' eliminado los siguientes artículos:'.$articulos_eliminados,'exito');
                        }elseif($_GET[accion_articulos]=='stand_by'){//se desea cambiar los articulos a la categoría stand-by
                            //con los datos de $consulta_articulos se ejecutará un bucle para pasar los articulos a stand-by
                            while( $fila = $resultado_articulos->fetch_assoc() ){
                                //1 es el id de stand-by por defecto
                                $modificacion_cat_articulo="UPDATE blog_articulos
                                                        SET articulo_cat_id='1'
                                                        WHERE articulo_id='$fila[articulo_id]'";
                                $resultado_cambio_cat   = $bd->query( $modificacion_cat_articulo );
                                if($bd->affected_rows==1){
                                    $articulos_a_standby.='<br>- '.$fila[articulo_titulo];
                                }   
                            }
                            notificar($mensaje.' cambiado a \'Stand-by\' los siguientes artículos:'.$articulos_a_standby,'exito');
                        }
                    }else{//no se eliminó la categoría
                        notificar('No se pudo eliminar la categoría');
                    }
                }else{//no se ha indicado qué hacer con los articulos de la categoría... entonces hay que preguntar
                    $mensaje='¿Qué desea hacer con los artículos de la categoría \''.$_GET[cat_nombre].'\'?<br>
                    <a style="color:#FFF" href="'.$_SERVER[REQUEST_URI].'&accion_articulos=eliminar">▸ También deseo eliminarlos</a><br>
                    <a style="color:#FFF" href="'.$_SERVER[REQUEST_URI].'&accion_articulos=stand_by">▸ Deseo dejarlos en la categoría predeterminada \'stand-by\' para reasignarlos más adelante a otras categorías</a>';
                    notificar($mensaje,'pregunta');
                }
            }elseif(array_key_exists("id", $_GET) ){
////////
//viene desde haber pinchado una categoría en listaCategorias.php y se procede a preguntar si realmente quiere eliminarla
////////            
                $mensaje='¿Realmente desea eliminar la categoría \''.$_GET[cat_nombre].'\'?<br>
                <a style="color:#FFF" href="'.$_SERVER[REQUEST_URI].'&confirmacion=x">▸ Sí</a><br>
                <a style="color:#FFF" href="listaCategorias.php">▸ No</a>';
                notificar($mensaje,'pregunta');
            } 
            else{
////////
// Entró directo escribiendo la dirección sin elegir una categoría, por lo tanto, se redirecciona a la lista de categorías
////////
                notificar('Debe elegir una categoría');
                exit;
            }          
        ?>
	</section>
	</div>
</body>
</html>