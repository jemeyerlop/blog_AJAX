<?php
include_once 'includes/php_comun.php';
if(!array_key_exists('usuario_id',$_SESSION)){
    header("Location:index.php");
    exit;
}    
?>
<!DOCTYPE html>
<html lang="<?php include_once 'includes/lang.php';?>">
<head>
	<?php
	$titulo='Modificar mi cuenta';
	$selectorActivo='#menu li a.mis_datos';
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
        if(array_key_exists('usuario_id',$_SESSION)){
            if(array_key_exists( 'mod-submit', $_POST ) ){
            
                $bd     = bd_conectar();
                $error  =   false;
                $msg    = "";
            
                $nombre     = $bd->real_escape_string( limpiarString( $_POST['mod-nombre'] ));
                $apellido   = $bd->real_escape_string( limpiarString( $_POST['mod-apellido'] ));
                $correo     = $bd->real_escape_string( limpiarString( $_POST['mod-correo'] ));
                $contra     = $_POST['mod-contra'];
                // echo '<pre>' . print_r( $apellido, 1 ) . '</pre>';

               if( !validarRango( $nombre)){
                    $error  = true;
                    $msg    .= "<p>Por favor ingresa tu nombre.</p>"; 
                }
                
                if( !validarRango( $apellido)){
                    $error  = true;
                    $msg    .= "<p>Por favor ingresa tu apellido.</p>"; 
                }
                
                if( !validarCorreo( $correo ) ){
                    $error  = true;
                    $msg    .= "<p>Debes ingresar un correo válido.</p>"; 
                }
                
                if( $error ){
                    
                    bd_cerrar( $bd );
                    notificar( $msg );
                    // Mostrar el formulario.
                    include('includes/formulario-modificar-cuenta.php');
                    
                }else{
                    //comprobar si entro su verdadera contraseña
                    $uid=$_SESSION[usuario_id];
                    $query="SELECT * FROM blog_usuarios
                            WHERE usuario_id = '$uid'
                            AND usuario_password = SHA1('$contra')";

                    $resultado = $bd->query( $query );

                    if( $resultado->num_rows === 1 ){
                        //hacer el update
                        $update = "UPDATE blog_usuarios SET
                        usuario_nombre='$nombre',
                        usuario_apellido='$apellido',
                        usuario_correo='$correo'
                        WHERE usuario_id='$uid'";
                        $result = $bd->query( $update );
                        
                        if($bd->affected_rows==1) {
                            notificar( "<p>Los datos han sido modificados.</p>","exito" );
                            bd_cerrar( $bd );
                        } else {
                            notificar( "<p>No pudimos almacenar la información</p>" );
                            bd_cerrar( $bd );
                            include('includes/formulario-modificar-cuenta.php');
                        }   
                    }else{
                        notificar( "<p>La contraseña es incorrecta.</p>" );
                        bd_cerrar( $bd );
                        include('includes/formulario-modificar-cuenta.php');
                    }
                }  
            }else{
                // Mostrar el formulario.
                include('includes/formulario-modificar-cuenta.php');
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