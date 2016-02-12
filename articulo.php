<?php
include_once 'includes/php_comun.php';
?>
<!DOCTYPE html>
<html lang="<?php include_once 'includes/lang.php';?>">
<head>
	<?php
	$titulo='Blog de arquitectura';
	$selectorActivo='';
	include_once 'includes/head.php';
	?>
<script>
//getUrlParameter para atrapar en js información pasada mediente el método get por la url
	function getUrlParameter(sParam){
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++){
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam){
        	return sParameterName[1];
	        }
	    }
	}
//funcion de procesar datos
	function procesarDatos(data){
		var estado=data.estado;
		var codigo_html=data.codigo_html;
		var codigo_paginacion=data.codigo_paginacion;
		if(estado=='e1' || estado=='e2'){
			$('#notificaciones').html(codigo_html);
		}else if(estado=='e3'){
			$('#notificaciones').html('');
			$('#columnaComentarios').html(codigo_html);
			$('.paginacion').html(codigo_paginacion);
			$('#formComentario textarea').val('').hide().fadeIn();
			pag_actual=1;//siempre que se agrega un nuevo comentario la lista de estos vuelve al principio
		}else if(estado=='e4'){
			$('#notificaciones').html('');
			$('#columnaComentarios').html(codigo_html);
			$('.paginacion').html(codigo_paginacion);
		}
		paginar();//para cuando los botones de paginar son creados desde ajax (otra opcion es usar la función 'on' para delegar, en lugar de invocar "paginar()" dentro de "procesarDatos()")
	}
//paginar
	function paginar(){
		$('.sig').click(function(e) {
			pag_actual++;
			var cadena='id='+id_art+'&page='+pag_actual;
			$.post('comentarios_ajax.php', cadena, procesarDatos,'json');
			e.preventDefault();
		});
		$('.ant').click(function(e) {
			pag_actual--;
			var cadena='id='+id_art+'&page='+pag_actual;
			$.post('comentarios_ajax.php', cadena, procesarDatos,'json');
			e.preventDefault();
		});
	}
//comienza document.ready
	$(document).ready(function(){
		//variable global de pagina actual para paginar con ajax (parte en 1 por defecto al cargar toda la pagina por primera vez)
		pag_actual=1;
		//extraer el id de la url tambien a una variable global
		id_art=getUrlParameter('id');
		//al enviar formulario:
		$('#formComentario').submit(function(e){
			var comentario=$(this).find('textarea').val();
			var cadena='id='+id_art+'&comentario='+comentario;//no se agrega "page", porque por defecto en comentarios_ajax.php si no va esa variable entonces la considera "1", y eso es justamente lo deseado para cuando se hace submit desde el formulario, es decir, que se vuelvan a cargar los comentarios desde la primera paginacion de comentarios
			$.post('comentarios_ajax.php', cadena, procesarDatos,'json');
			e.preventDefault();
		});
		paginar();
	});
</script>
</head>
<body>
	<div id="contenedor">
	<?php
	include_once 'includes/header.php';
	include_once 'includes/nav.php';
	?>
	<section class="contenido">
    <?php
    if(array_key_exists("id", $_GET)){
        $articulo_id=intval($_GET[id]);
        if($articulo_id<1){
            notificar('No se puede ingresar un id=0');
            exit;
        }
        $bd=bd_conectar();
        $consulta="SELECT * FROM blog_articulos
                     INNER JOIN blog_categorias
                        ON blog_articulos.articulo_cat_id = blog_categorias.cat_id
                     WHERE articulo_id='$articulo_id'";
         $result    = $bd->query( $consulta );
         if($result->num_rows===1){
            $fila = $result->fetch_assoc();
             $titulo=$fila[articulo_titulo];
             $descripcion=$fila[articulo_desc];
             $categoria=$fila[cat_nombre];
             $url=$fila[articulo_url];
             $fecha=$fila[articulo_fecha_creacion];
         }else{
            notificar('No encontramos lo que buscas');
            exit;
         }  
    }else{
        notificar('Se debe ingresar un id para la búsqueda');
        exit;
    }
    ?>
	    <section id="contenidoArticulo">
	        <article>
	            <section>
	            	<h2><?php echo ucwords($titulo) ?></h2>
	                <?php echo htmlspecialchars_decode($descripcion) //para decodificar las etiquetas html ?>
	            	<ul class="listaArticulo">
	                	<li><span class="destacado">Categoría: </span><?php echo ucfirst($categoria) ?></li>
	                	<li><span class="destacado">Fecha: </span><?php echo formatTimeStamp($fecha) ?></li>
	            	</ul>	                
	            </section>
	        </article>
	        <section>      
	            <img class="imgArticulo" src="administracion/subidas/<?php echo $url ?>" alt="Foto">       
	        </section>
	   	</section>
	   	<aside class="comentariosArticulo">
	   		<?php 
	   			if(array_key_exists('usuario_id',$_SESSION)){
	   		?>
				<form id="formComentario" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
					<fieldset>
						<label>Comentar</label>
						<textarea name="comentario" cols="30" rows="5" maxlength="250"></textarea>
					</fieldset>
				    <fieldset>
				        <input type="submit" name="submit-comentario" value="Enviar">
				    </fieldset>					
				</form>
				<div id="notificaciones">
	   		<?php
		   			if(array_key_exists('submit-comentario',$_POST)){
		   				//echo '<script>alert("'.$_POST[comentario].'")</script>';
	            		$error                  = "";
            			$msg                    = "";   	   				
			            $comentario = $bd->real_escape_string(limpiarString( $_POST[comentario] ));			      
			            if( !validarRango($comentario, 3, 250) ){
			                $error  = true;
			                $msg    = "<p>Debes ingresar un comentario de máximo 250 y mínimo 3 caracteres.</p>";
			            }      
			            if( $error ){
			            	echo '<div style="float:left;width:95%;height:auto;padding:0;margin:20px 0 0 0;">';
			                notificar( $msg );
			                echo '</div>';
			            }else{
		                    $insert_query   = "INSERT INTO blog_comentarios VALUES(
		                        NULL,
		                        '$_SESSION[usuario_id]',
		                        '$articulo_id',
		                        '$comentario',
		                        NOW()
		                    )";
		                    $result = $bd->query( $insert_query );                
		                    if($bd->affected_rows<1) {
		                    	echo '<div style="float:left;width:95%;height:auto;padding:0;margin:20px 0 0 0;">';
		                        notificar( "<p>No se pudo agregar el comentario.</p>");
		                        echo '</div>';
		                    }else{
		                    	//en caso de insercion exitosa borramos page de get para que en la paginación se vuelva a la pagina 1 si es que se hizo la insercion desde otra pagina de los comentarios y asi nos aseguremos que se vea inmediatamente el nuevo comentario evitando que el usuario crea que su comentario no se agrego
		                    	unset($_GET['page']);
		                    }
		                }
		   			}// fin de if(array_key_exists('submit-comentario',$_POST)){
		   	?>
		   		</div>	
		   	<?php	
	   			}//fin de if(array_key_exists('usuario_id',$_SESSION)){
	   		?>
	   		
			<div id="columnaComentarios">
	   		<?php
            	//paginación de comentarios
            	//recuperar el total de elementos en la tabla.
                $total_comentarios = $bd->query("SELECT COUNT(*) from blog_comentarios WHERE comentario_articulo_id='$articulo_id'"); // Contar los elementos de la tabla.
                $total = $total_comentarios->fetch_row(); // Recuperar el resultado. Para acceder al numero diría $total['0'];
                $com_pp    = 5; // comentarios por pagina.
                //$p_actual = 1; // a. Pagina actual - b. Recuperar este valor con el GET
                $p_actual = array_key_exists('page', $_GET) ? $_GET['page'] : 1;
                $desfase = ( $p_actual - 1 ) * $com_pp; // El punto de inicio de cada pagina   
                $max_paginas = ceil( $total['0'] / $com_pp ); // El numero de comentarios disponbiles dividido por el numero de comentarios por pagina. Redondeado hacia arriba.                     
            //preparar la petición de los comentarios.
            $query="SELECT
            		blog_comentarios.comentario_usuario_id_autor,
            		blog_comentarios.comentario_texto,
            		blog_comentarios.comentario_fecha_creacion,
            		blog_usuarios.usuario_id,
            		blog_usuarios.usuario_nombre,
            		blog_usuarios.usuario_apellido
            		FROM blog_comentarios
                    INNER JOIN blog_usuarios
                    ON blog_comentarios.comentario_usuario_id_autor = blog_usuarios.usuario_id
                    WHERE comentario_articulo_id='$articulo_id'
                    ORDER BY comentario_fecha_creacion DESC LIMIT $desfase, $com_pp";
            $result = $bd->query( $query );
            //procesar resultado
            while( $fila = $result->fetch_assoc() ) :
	   		?>
	   			<div class="comentario">
	   				<p><?php echo '<span class="destacado">'.ucwords($fila[usuario_nombre].' '.$fila[usuario_apellido]).'</span> dijo:'; ?></p>
	   				<p><?php echo $fila[comentario_texto]; ?></p>
	   				<p class="destacado"><?php echo formatTimeStamp($fila[comentario_fecha_creacion]); ?></p>
	   			</div>
            <?php endwhile; ?>
	   		</div>
            <div class="paginacion">
                <?php if( $p_actual > 2 ) : ?>
                    <a href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . ($p_actual - 1)."&id=".$articulo_id;?>" class="ant">&laquo; Anterior</a>
                <?php elseif($p_actual == 2) :?>
                    <a href="<?php echo $_SERVER['PHP_SELF']."?id=".$articulo_id;?>" class="ant">&laquo; Anterior</a>
                <?php endif; ?>               
                <?php if( $p_actual != $max_paginas and $total[0]!=0/*si no lo hace aparecer de todas formas*/ ) : ?>
                    <a href="<?php echo $_SERVER['PHP_SELF']. "?page=" . ($p_actual + 1)."&id=".$articulo_id;?>" class="sig">Siguiente &raquo;</a>
                <?php endif; ?>
            </div>
	   	</aside>
	</section>
	<?php
	include_once 'includes/footer.php';
	?>	
	</div>
</body>
</html>