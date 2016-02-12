<?php
include_once 'includesEspecialesBackend/php_comun.php';
?>
<!DOCTYPE html>
<html lang="<?php include_once '../includes/lang.php';?>">
<head>
	<?php
	$titulo='Agregar artículo';
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
            $rutaFormulario="/administracion/includesEspecialesBackend/formulario-subir.php";
            if( array_key_exists("articulo-submit", $_POST) ){
                // Administrador llegó desde el formulario, procesar valores.
                // 0. Declarar variables del programa
                $error                  = "";
                $msg                    = "";
                $formatos_permitidos    = array("image/jpeg", "image/png", "image/gif");
                // 1. Conectar a la base de datos
                $bd = bd_conectar();
                //echo '<pre>' . print_r( $bd, 1 ) . '</pre>';
                //recuperar valores del $_POST;
                $titulo = $bd->real_escape_string(limpiarString( $_POST['articulo-titulo'] ));
                //$desc     = $bd->real_escape_string(limpiarString( $_POST['articulo-descripcion'] ));
                //le sacamos el limpiarString y ponemos htmlspecialchars para permitir usar tinymce
                $desc   = htmlspecialchars($bd->real_escape_string($_POST['articulo-descripcion']));
                $cat_id = intval( $_POST['articulo-categoria'] ) ;
                $estado = intval( $_POST['articulo-estado'] ) ;
                //averiguamos el id del administrador que esta subiendo la foto para ingresarlo a la BD como su autor
                $autor=$_SESSION['usuario_id'];
                // 3. Validar existencia del titulo. La descripción es opcional pero no debe superar los 2000 caracteres
                if( !validarRango($titulo, 3, 60) ){
                    $error  = true;
                    $msg    = "<p>Debes ingresar un título apropiado.</p>";
                }
                if( !validarRango($desc, 0, 2000) ){//considerar etiquetas html de tinymce
                    $error  = true;
                    $msg    .= "<p>La descripción no debe superar los 2000 caracteres.</p>";
                }
                if( $error ){
                    bd_cerrar( $bd );
                    notificar( $msg );
                    // Mostrar formulario de subida
                    include(RUTA_ROOT.$rutaFormulario);
                }else{
                    // 4. Comenzar validación de la imagen
                    //echo '<pre>' . print_r( $_FILES, 1 ) . '</pre>';
                    // 5. Verificar que se haya subido una imagen
                    if( $_FILES['file']['error'] === 0 ){ // Se seleccionó una foto
                        // 6. Evaluar que la imagen esté en la carpeta temporal
                        if( is_uploaded_file( $_FILES['file']['tmp_name'] ) ){
                            // Evaluar formato
                            if( in_array($_FILES['file']['type'], $formatos_permitidos) ){
                                $carpeta    = RUTA_ROOT . "/administracion/subidas/";
                                $num        = mt_rand(100, 10000);
                                $extension  = pathinfo( $_FILES['file']['name'], PATHINFO_EXTENSION );
                                $nombre_final   = "imagen_" . $num . "." . $extension;
                                $ubicacion_final = $carpeta . $nombre_final;
                                if( move_uploaded_file( $_FILES['file']['tmp_name'], $ubicacion_final ) ){
                                    //el ultimo NULL del INSERT es para dejar en blanco la fecha de modificacion
                                    $insert_query   = "INSERT INTO blog_articulos VALUES(
                                        NULL,
                                        '$titulo',
                                        '$desc',
                                        '$cat_id',
                                        '$nombre_final',
                                        '$autor',
                                        NOW(),
                                        NULL,
                                        '$estado'
                                    )";
                                    $result = $bd->query( $insert_query );
                                    //echo '<pre>' . print_r( $result, 1 ) . '</pre>';
                                    if($bd->affected_rows==1) {
                                        notificar( "<p>El artículo subió correctamente.</p>","exito" );
                                    } else {                         
                                        notificar( "<p>No pudimos almacenar la información</p>" );
                                        // Mostrar formulario de subida
                                        include(RUTA_ROOT.$rutaFormulario);
                                    }                                     
                                } else {
                                    notificar( "<p>La imagen no pudo guardarse.</p>" );
                                    // Mostrar formulario de subida
                                    include(RUTA_ROOT.$rutaFormulario);
                                }
                            } else {
                                $msg = '<p>Los formatos permitidos para la imagen son JPG, GIF o PNG.</p>';
                                notificar( $msg );
                                // Mostrar formulario de subida
                                include(RUTA_ROOT.$rutaFormulario);
                            }
                        } else {
                            $msg = '<p>La imagen no está en la carpeta temporal.</p>';
                            notificar( $msg );
                            // Mostrar formulario de subida
                            include(RUTA_ROOT.$rutaFormulario);
                        }
                    } else {
                        $error = true;
                        switch( $_FILES['file']['error'] ){
                            case 1:
                                $msg = '<p>La imagen es mayor al tamaño permitido por PHP:' . ini_get('upload_max_filesize') . '</p>';
                                break;
                            case 2:
                                $msg = '<p>La imagen es superior al peso definido en MAX_FILE_SIZE</p>';
                                break;
                            case 3:
                                $msg = '<p>El archivo subió parcialmente</p>';
                                break;
                            case 4:
                                $msg = '<p>No se seleccionó ninguna imagen</p>';
                                break;
                            case 6:
                                $msg = '<p>No hay una carpeta temporal definida para las imágenes subidas</p>';
                                break;
                            case 7:
                                $msg = '<p>El sistema no tiene permisos para continuar.</p>';
                                break;
                            case 8:
                                $msg = '<p>La subida se detuvo en el lado del cliente.</p>';
                                break;
                        }
                        notificar( $msg );
                        // Mostrar formulario de subida
                        include(RUTA_ROOT.$rutaFormulario);              
                    }
                }               
            } else {
                // Mostrar formulario de subida
                include(RUTA_ROOT.$rutaFormulario);
            }               
        ?>
	</section>
	</div>
</body>
</html>