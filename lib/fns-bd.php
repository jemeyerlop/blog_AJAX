<?php
/** bd_conectar()
 *
 * Conecta a la base de datos
 * @author Pablo Reyes
 *
 * @param ninguno
 * return Si conecta con éxito devuelve un Objeto mysqli con coneccion a la base de datos.
 * return Si no conecta devuelve una excepción que hay que atrapar desde el llamado a la función.
**/
	function bd_conectar(){

		// Inicializar Objeto MySQLi
		$mysqli = new mysqli( DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME );

		if ($mysqli->connect_error){
			// Existe un error en la conexión. Mostrarlo y eliminar la conexión
			echo $mysqli->connect_error; // Lo ideal es notificar al usuario de otra forma y enviar los detalles del error al administrador del sitio por correo.
			unset( $mysqli );
			return false;
		} else {
			// Declarar el set de caracteres de la conexión
			$mysqli->set_charset("utf8");
			// Devolver el objeto al programa
			return $mysqli;
		}

	} // end db_connect;
	
/** bd_cerrar()
 *
 * Cierra la conexion a una base de datos y elimina el recurso MySQLi
 * @author Pablo Reyes
 *
 * @param MySQLi Objeto - El recurso MySQLI que queremos cerrar
**/
	function bd_cerrar( $mysqli ){
	
		$mysqli->close();
		unset( $mysqli );

	} // end db_connect;

?>