<?php
	/** usuarioLogueado();
	 *
	 * Determina si un usuario ha iniciado session verificando el valor de la llave "usuario_id" en la variable global $_SESSION
	 * @author Pablo Reyes
	 *
	**/

	function usuarioLogueado(  ){
			
		if( array_key_exists("usuario_id", $_SESSION ) ){
			return true;
		} else {
			return false;
		}

	}
	
	/** esAdmin();
	 *
	 * Determina si un usuario tiene capacidades de administración del sitio verificando el valor de la llave "usuario_rol" de la global $_SESSION
	 * @author Pablo Reyes
	 *
	**/
	
	function esAdmin(){
		if( $_SESSION['usuario_rol'] === "1" ){
			return true;
		} else {
			return false;
		}
	}

?>