<?php
include_once 'includesEspecialesBackend/php_comun.php';
?>
<!DOCTYPE html>
<html lang="<?php include_once '../includes/lang.php';?>">
<head>
	<?php
	$titulo='Modificar artículo';
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
                $rutaFormulario="/administracion/includesEspecialesBackend/formulario-modificar-articulo.php";
                
                if(array_key_exists("editar-articulo-submit", $_POST)){
////////                
// Administrador llegó desde el formulario, procesar valores.
////////
                    $error                  = "";
                    $msg                    = "";
                    
                    //conectar a la base de datos
                    $bd = bd_conectar();
                    //echo '<pre>' . print_r( $bd, 1 ) . '</pre>';
                    
                    //recuperar valores del $_POST;
                    $titulo = $bd->real_escape_string(limpiarString( $_POST['editar-articulo-titulo'] ));
                    //$desc     = $bd->real_escape_string(limpiarString( $_POST['editar-articulo-descripcion'] ));
                    //le sacamos el limpiarString y ponemos htmlspecialchars para permitir usar tinymce
                    $desc   = htmlspecialchars($bd->real_escape_string($_POST['editar-articulo-descripcion'] ));
                    $cat_id = intval( $_POST['editar-articulo-categoria'] ) ;
                    $articulo_url=$_POST['foto-antigua'];//esta variable será usada para borrar la foto antigua en caso de que se desee cambiar la foto por otra
                    //hacemos una nueva variable a partir de $articulo_url para usar en caso de cambiarse la foto. Tiene el mismo nombre que la anterior, pero le sacamos la extensión para permitir que una eventual nueva extensión sea concatenada en las lineas de mas abajo segun la extensión de la nueva foto que se esté subiendo. Como sabemos que en cualquiera de los 3 posibles formatos (.jpg, .gif y .png) son 4 caracteres, le cortamos los ultimos 4 caracteres
                    $nueva_articulo_url=substr($articulo_url, 0, -4);
                    $articulo_estado=$_POST['editar-articulo-estado'];
                    $fid=$_POST['fid'];
                    //echo '<pre>' . print_r( $_POST, 1 ) . '</pre>';
                    
                    //validar existencia del título.
                    if( !validarRango($titulo, 3, 60) ){
                        $error  = true;
                        $msg    = "<p>Debes ingresar un título apropiado.</p>";
                    }
                    
                    if( !validarRango($desc, 0, 2000) ){//considerar etiquetas html de tinymce
                        $error  = true;
                        $msg    .= "<p>La descripción no debe superar los 2000 caracteres.</p>";
                    }
                    
                    if( $error ){
                        notificar( $msg );
                        //mostrar formulario de subida
                        include(RUTA_ROOT.$rutaFormulario);
                    }else{
                        if($_FILES['file']['error'] === 0){
        //el admin, a parte de querer modificar los registros de la BD, quiere cambiar la foto
                            $formatos_permitidos    = array("image/jpeg", "image/png", "image/gif");
                            if( is_uploaded_file( $_FILES['file']['tmp_name'] ) ){
                                // Evaluar formato
                                if( in_array($_FILES['file']['type'], $formatos_permitidos) ){
                                    
                                    $carpeta    = RUTA_ROOT . "/administracion/subidas/";
                                    $extension  = pathinfo( $_FILES['file']['name'], PATHINFO_EXTENSION );
                                    $nombre_final   = $nueva_articulo_url.".".$extension;//acá le ponemos su nueva extension al nombre que originalmente fue sacado de la BD
                                    $ubicacion_final = $carpeta . $nombre_final;
                                    //borrar la foto antigua antes de guardar la nueva en su '$ubicacion_final' para evitar que, en caso que se haya cambiado de formato, se acumulen fotos del mismo nombre con distintos formatos para un mismo item (lo cual no provocaría problemas porque en la bd queda como parte del nombre el formato usado, pero la idea es evitar fotos basura en el directorio)
                                    $filename=$carpeta.$articulo_url;
                                    if (file_exists($filename))
                                        {
                                        unlink($filename);
                                        }
                                    //subir el articulo nuevo
                                    if( move_uploaded_file( $_FILES['file']['tmp_name'], $ubicacion_final ) ){
                                        $update = "UPDATE blog_articulos SET
                                            articulo_titulo='$titulo',
                                            articulo_desc='$desc',
                                            articulo_cat_id='$cat_id',
                                            articulo_url='$nombre_final',
                                            articulo_fecha_modificacion=NOW(),
                                            articulo_estado='$articulo_estado'
                                        WHERE articulo_id='$fid'
                                        ";
                                        $result = $bd->query( $update );
                                        //echo '<pre>' . print_r( $result, 1 ) . '</pre>';
                                        
                                        if($bd->affected_rows==1) {
                                            notificar( "<p>El artículo ha sido modificado.</p>","exito" );
                                        } else {
                                            
                                            notificar( "<p>No pudimos almacenar la información</p>" );
                                            //mostrar formulario de subida
                                            include(RUTA_ROOT.$rutaFormulario);
                                            
                                        }                                   
                                        
                                    } else {
                                        notificar( "<p>La foto no pudo guardarse.</p>" );
                                        //mostrar formulario de subida
                                        include(RUTA_ROOT.$rutaFormulario);
                                    }
                                    
                                } else {
                                    $msg = '<p>Los formatos permitidos son JPG, GIF o PNG.</p>';
                                    notificar( $msg );
                                    //mostrar formulario de subida
                                    include(RUTA_ROOT.$rutaFormulario);
                                }
                                
                            } else {
                                $msg = '<p>La foto no está en la carpeta temporal.</p>';
                                notificar( $msg );
                                //mostrar formulario de subida
                                include(RUTA_ROOT.$rutaFormulario);
                            }

                        }elseif($_FILES['file']['error'] === 4){
        //el admin no subió una foto, porque desea solamente modificar los registros de la BD manteniendo la misma foto
                            $update = "UPDATE blog_articulos SET
                                articulo_titulo='$titulo',
                                articulo_desc='$desc',
                                articulo_cat_id='$cat_id',
                                articulo_fecha_modificacion=NOW(),
                                articulo_estado='$articulo_estado'
                            WHERE articulo_id='$fid'
                            ";
                            $result = $bd->query( $update );
                            //echo '<pre>' . print_r( $result, 1 ) . '</pre>';
                            
                            if($bd->affected_rows==1) {
                                notificar( "<p>Los datos han sido modificados.</p>","exito" );
                            } else {
                                
                                notificar( "<p>No pudimos almacenar la información</p>" );
                                //mstrar formulario de subida
                                include(RUTA_ROOT.$rutaFormulario);
                                
                            }           

                        }else{
        //el admin efectivamente trató de subir una foto pero algo falló
                            
                            switch( $_FILES['file']['error'] ){
                            
                                case 1:
                                    $msg = '<p>La foto es mayor al tamaño permitido por PHP:' . ini_get('upload_max_filesize') . '</p>';
                                    break;
                                case 2:
                                    $msg = '<p>La foto es superior al peso definido en MAX_FILE_SIZE</p>';
                                    break;
                                case 3:
                                    $msg = '<p>Es archivo subió parcialmente</p>';
                                    break;
                                /*
                                //el caso 4 está considerado en la condición anterior como una opcion esperable, por lo tanto no lo consideraremos un error para efectos prácticos
                                case 4:
                                    $msg = '<p>No se seleccionó ninguna foto</p>';
                                    break;
                                */
                                case 6:
                                    $msg = '<p>No hay una carpeta temporal definida para las subidas</p>';
                                    break;
                                case 7:
                                    $msg = '<p>El sistema no tiene permisos para continuar.</p>';
                                    break;
                                case 8:
                                    $msg = '<p>La subida de detuvo en el lado del cliente.</p>';
                                    break;
                            }
                            
                            notificar( $msg );
                            //mostrar formulario de subida
                            include(RUTA_ROOT.$rutaFormulario);
                        }

                    }
                
                }elseif(array_key_exists("fid", $_GET) ){
////////
//viene desde haber pinchado un articulo en listaArticulos.php
////////
                    $bd = bd_conectar();
                    include(RUTA_ROOT.$rutaFormulario);
                } 
                else{
////////
// Entró directo escribiendo la dirección sin elegir un articulo, por lo tanto, se redirecciona a la lista de articulos
////////
                    notificar('Debe elegir un artículo');
                    exit;
                }
                
            ?>
	</section>
	</div>
</body>
</html>