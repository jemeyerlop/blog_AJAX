<?php

	// 1. Constantes para incluir archivos.	
    define("RUTA_LIB", dirname(__FILE__) ); 		// Recuperar la carpeta que contiene el archivo actual
	define("RUTA_ROOT", dirname( RUTA_LIB ));		// Ruta a la raíz del sitio, util para incluir elementos, no para redireccionar.
	
	// 2. Constantes para vincular recursos. Que van en la URL
	$p = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$s	= $_SERVER['SERVER_NAME'];
	$u  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	DEFINE("RUTA_SITIO", $p . $s . $u);

	
	// Información base de datos local
	
	define("DB_SERVER"	, "localhost");
	define("DB_USER"	, "root");
	define("DB_PASSWORD", "");
	define("DB_NAME"	, "bd_blog");
	
	// Incluir funciones del sistema
	require_once( RUTA_LIB . '/fns-bd.php');
	require_once( RUTA_LIB . '/fns-validacion.php');
	require_once( RUTA_LIB . '/fns-html.php');
	require_once( RUTA_LIB . '/fns-http.php');
	require_once( RUTA_LIB . '/fns-usuario.php');
	require_once( RUTA_LIB . '/fns-contenido.php');
	require_once( RUTA_LIB . '/fns-fecha.php');

?>