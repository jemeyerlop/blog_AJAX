<?php
	//0. Iniciar session;
	session_start();
	// 1. Incluir funciones del sistema
	require_once("../lib/config.php");	
	// 2. Determinar si el usuario está loggeado y si es administrador.
	$logueado 	= usuarioLogueado();	
	if( !$logueado ){
		redireccion("login.php", 2);
	}	
	$admin		= esAdmin();
	if( !$admin ){
		redireccion("login.php", 2);
	}
?>