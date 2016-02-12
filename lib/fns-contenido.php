<?php
	/** getArrayCategorias();
	 *
	 * Hace una petición a la base de datos por las categorías de la plataforma
	 * @author Pablo Reyes
	 *
	 * @param $bd MySQLi El objeto MySQLi a través del cual hacemos la petición.
	 * @return MySQLi Result Resultado de la petición.
	**/

	function getArrayCategorias( $bd ){

		$query 		= "SELECT * FROM blog_categorias";
		$resultado 	= $bd->query( $query );
		
		return $resultado;

	}

	function getArrayFotos( $bd,$offset,$fpp,$order='foto_id',$dir='DESC'){

		$query 		= "SELECT * FROM blog_fotos ORDER BY $order $dir LIMIT $offset, $fpp";
		$resultado 	= $bd->query( $query );
		
		return $resultado;

	}

	function getPaginacion($bd,$p_actual,$fpp,$tabla='blog_fotos'){
		$total_fotos = $bd->query("SELECT COUNT(*) from $tabla");
        $total = $total_fotos->fetch_row();
        $max_paginas=ceil($total[0]/$fpp);
?>

        <nav class="paginacion">
        <?php if($p_actual>2): ?>
            <a href="<?php echo $_SERVER['PHP_SELF']."?page=".($p_actual-1) ?>" class="ant">&laquo; Anterior</a>
		<?php endif; ?>
		<?php if($p_actual==2): ?><!-- este es para que no se vea page=1 en la url cuando se está en la primera -->
            <a href="<?php echo $_SERVER['PHP_SELF']?>" class="ant">&laquo; Anterior</a>
		<?php endif; ?>
		<?php if($p_actual!=$max_paginas): ?>
            <a href="<?php echo $_SERVER['PHP_SELF']."?page=".($p_actual+1) ?>" class="sig">Siguiente &raquo;</a>
        <?php endif; ?>
        </nav>

<?php

	}

?>