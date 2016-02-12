<?php

/*-----------------------------------------------------------------------------------*/
/*	Limpiar Input
/*-----------------------------------------------------------------------------------*/

/** limpiarString();
 *
 * Limpiar capitalización desigual y espacios en blanco innecesarios.
 * @author Pablo Reyes
 *
 * @param $string String - El texto que queremos limpiar
 * @return String - Devuelve el string limpio.
**/
	function limpiarString( $string ){
		//a. Quitar espacios en blanco del comemienzo y del final: trim();
		//b. Pasar todo a minusculas: strtolower();
		//c. Eliminar etiquetas HTML: strip_tags();
		
		//return strip_tags( strtolower( trim( $string ) ) );
		return strip_tags( mb_strtolower( trim( $string ) ,"UTF-8") );//con mb_strtolower no se generan problemas con los acentos y eñes
	}


/*-----------------------------------------------------------------------------------*/
/*	Funciones de validación
/*-----------------------------------------------------------------------------------*/
/** validarString();
 *
 * Evalúa si el número de caracteres de un string están dentro de un rango. Por defecto evalúa si está vacío.
 * @author Pablo Reyes
 *
 * @param $string String - El texto que quiero validar
 * @param $min int - El número mínimo de caracteres permitidos. Def = 1
 * @param $max int - El número máximo de caracteres permitidos. Def = 2000
 * return Boolean - Verdadero si valida, falso si no.
**/
function validarRango( $string, $min = 1, $max = 2000 ){
	$length = strlen( $string );
	if ( $length >= $min && $length <= $max ) {
		return true;
	} else {
		return false;
	}
}

/** validarCorreo();
 *
 * Verifica que un correo sea aparentemente válido y que calce con un patrón determinado
 * @author Pablo Reyes
 *
 * @param $email String - String a evaluar como correo electrónico
 * @return Boolean - Verdadero si calza, falso si no.
**/
function validarCorreo( $email ){
	// Expresion Regular
	$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";

	if (preg_match($pattern, $email)){
		return true;
	} else {
		return false;
	}
}

?>