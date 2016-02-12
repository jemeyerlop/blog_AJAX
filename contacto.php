<?php
include_once 'includes/php_comun.php';
?>
<!DOCTYPE html>
<html lang="<?php include_once 'includes/lang.php';?>">
<head>
	<?php
	$titulo='Contacto';
	$selectorActivo='#menu li a.contacto';
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
	<?php
    if( array_key_exists( 'submit-correo', $_POST ) ){
        
        $nombre     = limpiarString( $_POST['ct-nombre'] );
        $apellido   = limpiarString( $_POST['ct-apellido'] );
        $correo     = limpiarString( $_POST['ct-correo'] );
        $mensaje    = limpiarString( $_POST['ct-mensaje'] );
        
        $error      = false;
        $msn        = "";
        
        if( !validarRango($nombre) ){
            $error  = true;
            $msn    .= "<p>Debes ingresar tu nombre.</p>"; 
        }
        
        if( !validarRango($apellido) ){
            $error  = true;
            $msn    .= "<p>Debes ingresar tu apellido.</p>"; 
        }
        
        if( !validarCorreo($correo) ){
            $error  = true;
            $msn    .= "<p>Debes ingresar un correo válido.</p>"; 
        }
        
        if( !validarRango($mensaje, 3, 200) ){
            $error  = true;
            $msn    .= "<p>Debes ingresar un mensaje.</p>"; 
        }
        
        
        if( $error ){
        
        	notificar($msn);
        	// Mostrar el formulario.
        	include('includes/formulario-contacto.php');
        
        } else {
        	//consulta del correo del administrador
		    $bd     = bd_conectar();
		    $query = "SELECT usuario_correo
		             FROM blog_usuarios
		             WHERE usuario_id='1' AND usuario_rol='1'";
                
		    $result = $bd->query( $query );
		    $fila = $result->fetch_assoc();

		    bd_cerrar( $bd );

		    $usuario_correo=$fila[usuario_correo];

			$para		= $usuario_correo;
			$asunto		= "Contacto desde ARQ-blog.";

			// Crear las cabeceras por separado dentro de un array. Luego se juntaran
			$cabeceras	= array();

			// PARTE HTML
			$cabeceras[] = "MIME-Version: 1.0";
			$cabeceras[] = "Content-type: text/html; charset=utf-8"; // ES LO MAS IMPORTANTE PARA QUE LO INTEPRETE COMO HTML
			// FIN PARTE HTML

			$cabeceras[] = "From: " . $correo; // ES MUY IMPORTANTE PONER ESTA CABECERA.
			$cabeceras[] = "Reply-To: " . $correo;
			//$cabeceras[] = "Cc: " . "correo@gmail.com";
			//$cabeceras[] = "Bcc: " . "correo@gmail.com";

			// Crear el contenido
			$contenido  = "<h1>Nombre:</h1> " . $nombre . " " . $apellido . "<br />";
			$contenido .= "<em>Correo:</em> " . $correo . "<br />";
			$contenido .= "******************* - *******************" . "<br />";
			$contenido .= "<h2>Dice:</h2><br />";
			$contenido .= $mensaje;

			// 7. Enviar el Correo
			if(@mail( $para, $asunto, $contenido, join( "\r\n" , $cabeceras ))) {
				// El mail se envio
				notificar('<p>Correo enviado con éxito.</p>','exito');
			} else {
				// El mail NO se envio
				notificar('<p>El correo no pudo enviarse.</p>');
				// Mostrar el formulario.
        		include('includes/formulario-contacto.php');
			}          
        }
    } else {  
        // Mostrar el formulario.
        include('includes/formulario-contacto.php');
        
    }
	?>
	</section>
	<?php
	include_once 'includes/footer.php';
	?>	
	</div>
</body>
</html>