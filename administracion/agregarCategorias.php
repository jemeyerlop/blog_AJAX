<?php
include_once 'includesEspecialesBackend/php_comun.php';
?>
<!DOCTYPE html>
<html lang="<?php include_once '../includes/lang.php';?>">
<head>
	<?php
	$titulo='Agregar categoría';
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
		$rutaFormulario="/administracion/includesEspecialesBackend/formulario-nueva-categoria.php";
        if( array_key_exists("cat-submit", $_POST) ){
            // Administrador llegó desde el formulario, procesar valores.
            $error                  = "";
            $msg                    = "";     
            //conectar a la base de datos
            $bd = bd_conectar();
            //echo '<pre>' . print_r( $bd, 1 ) . '</pre>';
            //recuperar valores del $_POST;
            $nombre = $bd->real_escape_string(limpiarString( $_POST['cat-nombre'] ));
            // echo '<pre>' . print_r( $_POST, 1 ) . '</pre>';
            //validar existencia del nombre. La descripción es opcional pero no debe superar los 500 caracteres
            if( !validarRango($nombre, 3, 40) ){
                $error  = true;
                $msg    = "<p>Debes ingresar un nombre apropiado.</p>";
            }      
            if( $error ){
                bd_cerrar( $bd );
                notificar( $msg );
                //mostrar formulario de subida
                include(RUTA_ROOT.$rutaFormulario);
            } else {
                //revisar que no se repita el nombre de la categoría
                $query_coincidencia = "SELECT * FROM blog_categorias WHERE cat_nombre='$nombre'";
                $coincidencia=$bd->query( $query_coincidencia );
                if($coincidencia->num_rows === 1){
                    $msg = "<p>Ya existe una categoría llamada ".$nombre." y no pueden repetirse.</p>";
                    notificar( $msg );
                    include(RUTA_ROOT.$rutaFormulario);
                }else{
                    $insert_query   = "INSERT INTO blog_categorias VALUES(
                        NULL,
                        '$nombre',
                        NOW()
                    )";
                    $result = $bd->query( $insert_query );
                    //echo '<pre>' . print_r( $result, 1 ) . '</pre>';                  
                    if($bd->affected_rows==1) {
                        notificar( "<p>La categoría fue agregada correctamente.</p>","exito" );
                    } else {                      
                        notificar( "<p>No se pudo agregar la categoría</p>" );
                        //mostrar formulario de subida
                        include(RUTA_ROOT.$rutaFormulario);
                    }  
                }
            }                
        } else {
            //mostrar formulario de subida
            include(RUTA_ROOT.$rutaFormulario);
        }       
    ?>
	</section>
	</div>
</body>
</html>