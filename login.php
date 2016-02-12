<?php
include_once 'includes/php_comun.php';
/* 1. Evaluar estado del visitante. Si ya esta logueado/a entonces redireccionar al home del sitio.
IMPORTANTE: Debemos iniciar la sesión en le header o si no el superglobal $_SESSION no estará disponible.
*/
if( array_key_exists('usuario_id',$_SESSION)){
    // Ya está logueado, enviar al home.
    header("Location:index.php");
    exit;
}else{
    /*
    2. Determinar origen del usuario. Si llego desde el menú de navegación, mostrar el formulario de login. Si llegó desde el formulario, evaluamos que exista la llave "li-submit" en el $_POST
    */
    if(array_key_exists('li-submit',$_POST)){
        // 3. Procesar información del formulario
        // Para validar, incluímos las funciones del programa en el header.
        $correo=limpiarString( $_POST['li-correo'] );
        $contra=$_POST['li-contra'];
        // 4. Conectarse a la base de datos
        $bd=bd_conectar();
        // 5. Preparar petición
        $query="SELECT * FROM blog_usuarios
                WHERE usuario_correo = '$correo'
                AND usuario_password = SHA1('$contra')";
        // 6. Enviar la petición
        $resultado = $bd->query( $query );
        /* 7. Evaluar el resultado de la petición.
        // echo '<pre>' . print_r( $resultado, 1 ) . '</pre>';
        Revisar si el valor de la propiedad "num_rows" es igual a 1 (uno), si lo es, significa que encontró un usuario con las credenciales entregadas. Si no, significa que las credenciales están equivocadas o el usuario no se ha registrado a la plataforma.
        */
        if( $resultado->num_rows === 1 ){
            /* 8. Usuario existe, loguear en la Session
                   Asociar los valores recupeardos de la petición a la $_SESSION                     
            */
                $fila = $resultado->fetch_assoc();
                // echo '<pre>' . print_r( $fila, 1 ) . '</pre>';
                $_SESSION['usuario_id']       = $fila['usuario_id'];
                $_SESSION['usuario_nombre']   = $fila['usuario_nombre'];
                $_SESSION['usuario_apellido'] = $fila['usuario_apellido'];
                $_SESSION['usuario_correo']   = $fila['usuario_correo'];
                $_SESSION['usuario_rol']      = $fila['usuario_rol'];
                // Cerrar conexion a la base de datos
                bd_cerrar( $bd );
                // Redireccionar al home
                header("Location:index.php");
        }else{
            // Usuario no existe o sus credenciales están malas. Notificar y mostrar el formulario.
            $estado='notificar+formulario';
        }
    }else{
        // Mostrar el formulario.
        $estado='formulario';
    }
}
?>
<!DOCTYPE html>
<html lang="<?php include_once 'includes/lang.php';?>">
<head>
	<?php
	$titulo='Login';
	$selectorActivo='#menu li a.login';
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
    <?php if ($estado) {
        if ($estado=='notificar+formulario') {
            notificar( '<p>Tu correo y password no coinciden. Inténtalo nuevamente o <a href="registro.php">regístrate.</a></p>' );
            include('includes/formulario-login.php');
        } elseif ($estado=='formulario') {
            include('includes/formulario-login.php');
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