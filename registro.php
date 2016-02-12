<?php
include_once 'includes/php_comun.php';
?>
<!DOCTYPE html>
<html lang="<?php include_once 'includes/lang.php';?>">
<head>
	<?php
	$titulo='Registro';
	$selectorActivo='#menu li a.registro';
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
        if( array_key_exists( 'usuario_id', $_SESSION )  ){
            // Notificar que ya está logueado
            notificar('Usted no puede registrarse si ya está logeado');
            exit;
        } else {
            /*
            2. Determinar origen del usuario. Si llego desde el menú de navegación, mostrar el formulario de login. Si llegó desde el formulario, evaluamos que exista la llave "li-submit" en el $_POST
            */
            if( array_key_exists( 'reg-submit', $_POST ) ){
            
            	//3. Conectar a la base de datos y declarar variables del programa
            	$bd		= bd_conectar();
            	$error	=	false;
            	$msg	= "";
            
                /* 4. Procesar información del formulario
                // Para validar, incluímos las funciones del programa en el header.
                // IMPORTANTE:
				// Ya que estos datos serán almacenados en la base de datos, es MUY importante limpiar y escapar cualquier caracter especial que puedan contener.
				// Esto lo hacemos a través del método real_escape_string del objeto mysqli
				*/
                $nombre     = $bd->real_escape_string( limpiarString( $_POST['reg-nombre'] ));
                $apellido	= $bd->real_escape_string( limpiarString( $_POST['reg-apellido'] ));
                $correo     = $bd->real_escape_string( limpiarString( $_POST['reg-correo'] ));
                $contra     = $_POST['reg-contra'];
                // echo '<pre>' . print_r( $apellido, 1 ) . '</pre>';
                
                // 5. Comenzar validación de datos
		       if( !validarRango( $nombre )){
		            $error  = true;
		            $msg    .= "<p>Por favor ingresa tu nombre.</p>"; 
		        }
		        
		        if( !validarRango( $apellido )){
		            $error  = true;
		            $msg    .= "<p>Por favor ingresa tu apellido.</p>"; 
		        }
		        
		        if( !validarCorreo( $correo ) ){
		            $error  = true;
		            $msg    .= "<p>Debes ingresar un correo válido.</p>"; 
		        }
		        
		        if( !validarRango( $contra, 6, 16) ){
		            $error  = true;
		            $msg    .= "<p>Debes ingresar una contraseña de entre 6 y 16 caracteres.</p>"; 
		        }
		        
		        if( $error ){
		        	
		        	bd_cerrar( $bd );
                    notificar( $msg );
                    // Mostrar el formulario.
					include('includes/formulario-registro.php');
			        
		        } else {
		        
		        	//6. Si todo valida debemos asegurarnos que el usuario no exista previamente en la base de datos.
        			// Preprara la peticion SQL.
					$select_query	= "SELECT usuario_correo FROM blog_usuarios WHERE usuario_correo = '$correo'";
					// Hacemos la petición
					$select_resultado = $bd->query( $select_query );
					// echo '<pre>' . print_r( $select_resultado, 1 ) . '</pre>';
					// Evaluamos la propiedad num_rows. Si está tiene el valor cero, podemos registrar el usuario, si tiene el valor 1 el usuario ya existe.
					
					if( $select_resultado->num_rows > 0 ){
						
						bd_cerrar( $bd );
						notificar('<p>Tu correo ya está registrado en nuestro sitio. Inténtalo nuevamente o <a href="login.php">logueate</a></p>');
						include('includes/formulario-registro.php');								
						
					} else {
						
						// 7. El visitante no está registrado, podemos almacenar sus datos en la BD
						// Preparar la petición
						$insert_query = "INSERT INTO blog_usuarios VALUES(
							NULL,
							'$nombre',
							'$apellido',
							'$correo',
							SHA1('$contra'),
							2,
							NOW()
						);";
						// Hacer la petición
						$insert_resultado = $bd->query( $insert_query );
						
						// Evaluar el resultado de la petición
						// Evaluarmos el valor de la propiedad affected_rows del objeto MySQLi. Si se creó un nuevo registro, su valor deberá ser uno.
						// echo '<pre>' . print_r( $bd, 1 ) . '</pre>';
						if( $bd->affected_rows === 1 ){
						
							notificar('<p>Ya estás registrado(a). Puedes <a href="login.php">loguearte.</a></p>', 'exito');
							bd_cerrar( $bd );
							
						} else {
							bd_cerrar( $bd );
							notificar("<p>Hubo un problema al registrarlo, por favor inténtelo nuevamente.</p>");
							// Mostrar el formulario.
							include('includes/formulario-registro.php');									
						}
					}
			        
		        }
                
                
            } else {
                // Mostrar el formulario.
                include('includes/formulario-registro.php');
            }
        }
                
    ?>
	</section>
	<?php
	include_once 'includes/footer.php';
	?>	
	</div>
</body>
</html>