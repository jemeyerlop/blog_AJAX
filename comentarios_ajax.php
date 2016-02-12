<?php
include_once 'includes/php_comun.php';
if(array_key_exists("id", $_POST)){
	//declaramos variables del array final que sera devuelto
	$estado='';
	$codigo_html='';
	$codigo_paginacion='';
	//comienza procesamiento
    $articulo_id=intval($_POST[id]);
    $bd=bd_conectar();
	if(array_key_exists('usuario_id',$_SESSION)){
		if(array_key_exists('comentario',$_POST)){
			$error                  = "";
			$msg                    = "";   	   				
		    $comentario = $bd->real_escape_string(limpiarString( $_POST[comentario] ));			      
		    if( !validarRango($comentario, 3, 250) ){
		        $error  = true;
		        $msg    = "<p>Debes ingresar un comentario de máximo 250 y mínimo 3 caracteres.</p>";
		    }      
		    if( $error ){
		    	$estado='e1';
		    	$codigo_html='
            	<div style="float:left;width:95%;height:auto;padding:0;margin:20px 0 0 0;">'.notificar_cadena( $msg ).'</div>';
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
		        	$msg    = "<p>No se pudo agregar el comentario.</p>";
		        	$estado='e2';
			    	$codigo_html='
	            	<div style="float:left;width:95%;height:auto;padding:0;margin:20px 0 0 0;">'.notificar_cadena( $msg ).'</div>';
		        }else{//paginamos con los nuevos datos recien agregadoa a la bd
		        	$estado='e3';
			    }
			}
		}else{//paginamos saltandonos todo lo que esta dentro de la condicion de que exista un comentario por agregar, porque la intension era solamente cambiar de pagina
    		$estado='e4';
    	}		
	}else{//paginamos saltandonos todo lo que esta dentro de la condicion de session iniciada, porque la intension era solamente cambiar de pagina y eso lo puede hacer cualquier visitante sin necesidad de estar loggeado
    	$estado='e4';	
	}
	if($estado=='e3' || $estado=='e4'){//si es e1 o e2 ya tiene su html del mensaje de error
		//paginación de comentarios
		//recuperar el total de elementos en la tabla.
	    $total_comentarios = $bd->query("SELECT COUNT(*) from blog_comentarios WHERE comentario_articulo_id='$articulo_id'"); // Contar los elementos de la tabla.
	    $total = $total_comentarios->fetch_row(); // Recuperar el resultado. Para acceder al numero diría $total['0'];
	    $com_pp    = 5; // comentarios por pagina.
	    //$p_actual = 1; // a. Pagina actual - b. Recuperar este valor con el GET
	    $p_actual = array_key_exists('page', $_POST) ? $_POST['page'] : 1;
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
	    while( $fila = $result->fetch_assoc() ) {
	    	$codigo_html.='
	    	<div class="comentario">
	    		<p><span class="destacado">'.ucwords($fila[usuario_nombre].' '.$fila[usuario_apellido]).'</span> dijo:</p>
					<p>'.$fila[comentario_texto].'</p>
					<p class="destacado">'.formatTimeStamp_cadena($fila[comentario_fecha_creacion]).'</p>
				</div>
				';
	    }
	    if( $p_actual >= 2 ) {
	    	$codigo_paginacion.='
			<a href="#" class="ant">&laquo; Anterior</a>
	    	';
	    }
	    if( $p_actual != $max_paginas and $total[0]!=0/*si no lo hace aparecer de todas formas*/ ){
	    	$codigo_paginacion.='
			<a href="#" class="sig">Siguiente &raquo;</a>
	    	';
	    }
	}
}
//sobre los estados:
	//e1=no se valido el texto
	//e2=no se agrego a la BD
	//e3=se sube un nuevo comentario y se pagina
	//e4=solamente se cambia de pagina pagina
$sobre=array(
	"estado"=>$estado,
	"codigo_html"=>$codigo_html,
	"codigo_paginacion"=>$codigo_paginacion
	);
echo json_encode($sobre);
?>
