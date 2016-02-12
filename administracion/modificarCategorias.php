<?php
include_once 'includesEspecialesBackend/php_comun.php';
?>
<!DOCTYPE html>
<html lang="<?php include_once '../includes/lang.php';?>">
<head>
	<?php
	$titulo='Modificar categoría';
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
            $rutaFormulario="/administracion/includesEspecialesBackend/formulario-modificar-cat.php";   
                if(array_key_exists("editar-cat-submit", $_POST)){
////////                
// administrador llegó desde el formulario, procesar valores.
////////
                    $error                  = "";
                    $msg                    = "";
                    //conectar a bd
                    $bd = bd_conectar();
                    //echo '<pre>' . print_r( $bd, 1 ) . '</pre>';
                    //recuperar valores del $_POST;
                    $cat_nombre = $bd->real_escape_string(limpiarString( $_POST['editar-cat-nombre'] ));
                    $cid=$_POST['cid'];
                    //echo '<pre>' . print_r( $_POST, 1 ) . '</pre>';
                    //validar existencia del nombre.
                    if( !validarRango($cat_nombre, 3, 40) ){
                        $error  = true;
                        $msg    = "<p>Debes ingresar un nombre de categoría apropiado.</p>";
                    }
                    if( $error ){
                        notificar( $msg );
                        //mostrar formulario de subida
                        include(RUTA_ROOT.$rutaFormulario);
                    }else{
                        //revisar que no se repita el nombre de la categoría
                        $query_coincidencia =
                        "SELECT * FROM blog_categorias WHERE cat_nombre='$cat_nombre'
                        AND cat_id<>'$cid'";//no tiene sentido decir que ya existe una categoría con tal nombre si justo se refiere a la misma, por lo tanto hacemos la busqueda en categorías que no sean la misma que estamos modificando
                        $coincidencia=$bd->query( $query_coincidencia );
                        if($coincidencia->num_rows>=1){
                            $msg = "<p>Ya existe una categoría llamada ".$cat_nombre." y no pueden repetirse.</p>";
                            notificar( $msg );
                            include(RUTA_ROOT.$rutaFormulario);
                        }else{
                            $update = "UPDATE blog_categorias SET cat_nombre='$cat_nombre' WHERE cat_id='$cid' AND cat_id<>'1'";//está prohibido eliminar la categoría stand_by que tiene id_cat=1
                            $result = $bd->query( $update );
                            //echo '<pre>' . print_r( $result, 1 ) . '</pre>';
                            
                            if($bd->affected_rows==1) {
                                notificar( "<p>Los datos han sido modificados.</p>","exito" );
                            } else {
                                notificar( "<p>No pudimos almacenar la información</p>" );
                                //mostrar formulario de subida
                                include(RUTA_ROOT.$rutaFormulario);
                            }   
                        }
                    }
                }elseif(array_key_exists("cid", $_GET) ){
////////
//viene desde haber pinchado una categoria en listaCategorias.php
////////
                    $bd= bd_conectar();
                    include(RUTA_ROOT.$rutaFormulario);
                } 
                else{
////////
// entró directo escribiendo la dirección sin elegir un articulo, por lo tanto, se redirecciona a la lista
////////
                    notificar('Debe elegir una categoría');
                    exit;
                } 
            ?>     
	</section>
	</div>
</body>
</html>