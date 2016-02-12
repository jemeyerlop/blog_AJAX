<?php
	/** redireccion();
	 *
	 * Redirecciona hacia un documento en particular dependiendo de la ubicación desde donde se le invoque.
	 * Podemos invocar esta función desde el front-end o desde el back-end. Si invocamos desde el backend, debemos subir un nivel desde la carpeta "admin", esto lo hacemos a través del segundo argumento de la función.
	 * @author Pablo Reyes
	 *
	 * @param $url 		String 		El nombre y extensión del documento a donde queremos redireccionar.
	 * @param $desde 	Number		Un valor entre 1 y 2. Desde donde invocamos esta funcion: 1: frontend y 2: backend
	**/

	function redireccion( $url = "index.php", $desde = 1 ){
			
		$destino = RUTA_SITIO;
		
		if( $desde == 2 ){
			$destino = dirname( RUTA_SITIO );
		}
		
		header( "Location: " . $destino . "/" . $url );
		exit;

	}

?>