<?php
	/** notificar();
	 *
	 * Genera un contenedor HTML con un mensaje determinado.
	 * @author Pablo Reyes
	 *
	 * @param $msg String El mensaje a mostrar. Puede contener HTML.
	 * @param $class String Class a insertar en el contenedor. Por defecto error. Las clases se definene en el archivo CSS.
	 * @echo String Estructura HTML para insertar en el documento.
	**/

	function notificar( $msg, $class = "error"){

		$html  = '<div class="notificacion ' . $class . '">';
		$html .= $msg;
		$html .= '</div>';

		echo $html;

	}
	//misma función que antes, pero en lugar de hacer "echo", solamente devuelve el codigo para poder almacenarlo en una variable
	function notificar_cadena( $msg, $class = "error"){

		$html  = '<div class="notificacion ' . $class . '">';
		$html .= $msg;
		$html .= '</div>';

		return $html;

	}

?>