<?php
	/** formatTimeStamp()
	 *
	 * Transforma un TimeStamp a una fecha con formato "lunes 10 de agosto, 2014"
	 * @author Pablo Reyes
	 *
	 * @param $timestamp String TimeStamp, formato: AA-MM-DD HH:MM:SS
	 * @param $timezone String Zona horaria. Por defecto Santiago de Chile.
	 * @return String Fecha formateada.
	**/
	function formatTimeStamp( $timestamp, $timezone = "America/Santiago" ){
		// http://php.net/manual/en/timezones.america.php
		// http://php.net/manual/en/datetime.formats.date.php

		// Crear un objeto DateTimeZone que almacena la zona horaria.
		$dtz	= new DateTimeZone( $timezone );
		// Crear un objeto DateTime que convertira nuestro timestamp en un TimeZone listo para formatear.
		$dt		= new DateTime( $timestamp, $dtz );
		$nombreCompletoDia	= nombreDiaEsp( $dt->format('l') );
		$nombreAbbrDia		= $dt->format('D');
		$numeroDia			= $dt->format('d');
		$nombreCompletoMes	= nombreMesEsp( $dt->format('F') );
		$nombreAbbrMes		= $dt->format('M');
		$anioCompleto		= $dt->format('Y');
		$anioAbrr			= $dt->format('y');

		// Formato: "l d \o\f M, Y" Inglés
		//$format = $dt->format("l M d, Y");

		// Castellano. A menos que comienzen la frase siempre son en minuscula.
		$format = $nombreCompletoDia . ' ' . $numeroDia . ' de ' . $nombreCompletoMes . ', ' . $anioCompleto;

		echo $format;

	}
	//misma función que antes, pero en lugar de hacer "echo", solamente devuelve el codigo para poder almacenarlo en una variable
	function formatTimeStamp_cadena( $timestamp, $timezone = "America/Santiago" ){
		// http://php.net/manual/en/timezones.america.php
		// http://php.net/manual/en/datetime.formats.date.php

		// Crear un objeto DateTimeZone que almacena la zona horaria.
		$dtz	= new DateTimeZone( $timezone );
		// Crear un objeto DateTime que convertira nuestro timestamp en un TimeZone listo para formatear.
		$dt		= new DateTime( $timestamp, $dtz );
		$nombreCompletoDia	= nombreDiaEsp( $dt->format('l') );
		$nombreAbbrDia		= $dt->format('D');
		$numeroDia			= $dt->format('d');
		$nombreCompletoMes	= nombreMesEsp( $dt->format('F') );
		$nombreAbbrMes		= $dt->format('M');
		$anioCompleto		= $dt->format('Y');
		$anioAbrr			= $dt->format('y');

		// Formato: "l d \o\f M, Y" Inglés
		//$format = $dt->format("l M d, Y");

		// Castellano. A menos que comienzen la frase siempre son en minuscula.
		$format = $nombreCompletoDia . ' ' . $numeroDia . ' de ' . $nombreCompletoMes . ', ' . $anioCompleto;

		return $format;

	}

/*-----------------------------------------------------------------------------------*/
/*	TRADUCCIONES
/*-----------------------------------------------------------------------------------*/
function nombreDiaEsp( $nd ){
	switch ( strtolower($nd) ) {
		case "monday" :
			return "lunes";
			break;
		case "tuesday" :
			return "martes";
			break;
		case "wednesday" :
			return "miércoles";
			break;
		case "thursday" :
			return "jueves";
			break;
		case "friday" :
			return "viernes";
			break;
		case "saturday" :
			return "sábado";
			break;
		case "sunday" :
			return "domingo";
			break;
	}
}
function nombreDiaAbbrEsp( $nd ){
	switch ( strtolower($nd) ) {
		case "mon" :
			return "lun";
			break;
		case "tue" :
			return "mar";
			break;
		case "wed" :
			return "mie";
			break;
		case "thu" :
			return "jue";
			break;
		case "fri" :
			return "vie";
			break;
		case "sat" :
			return "sáb";
			break;
		case "sun" :
			return "dom";
			break;
	}
}

function nombreMesEsp( $mes ){
	switch ( strtolower($mes) ) {
		case "january" :
			return "enero";
			break;
		case "february" :
			return "febrero";
			break;
		case "march" :
			return "marzo";
			break;
		case "april" :
			return "abril";
			break;
		case "may" :
			return "mayo";
			break;
		case "june" :
			return "junio";
			break;
		case "july" :
			return "julio";
			break;
		case "august" :
			return "agosto";
			break;
		case "september" :
			return "septiembre";
			break;
		case "october" :
			return "octubre";
			break;
		case "november" :
			return "noviembre";
			break;
		case "december" :
			return "diciembre";
			break;
	}
}

function nombreMesAbbrEsp( $mes ){
	switch ( strtolower($mes) ) {
		case "jan" :
			return "ene";
			break;
		case "feb" :
			return "feb";
			break;
		case "mar" :
			return "mar";
			break;
		case "apr" :
			return "abr";
			break;
		case "may" :
			return "may";
			break;
		case "jun" :
			return "jun";
			break;
		case "jul" :
			return "jul";
			break;
		case "aug" :
			return "ago";
			break;
		case "sep" :
			return "sep";
			break;
		case "oct" :
			return "oct";
			break;
		case "nov" :
			return "nov";
			break;
		case "dec" :
			return "dic";
			break;
	}
}


?>