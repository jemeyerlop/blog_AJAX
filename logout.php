<?php
	// Activar session.
	session_start();

	// Eliminar los valores de las llaves de la SESSION
	unset( $_SESSION['usuario_id'] );
	unset( $_SESSION['usuario_nombre'] );
	unset( $_SESSION['usuario_apellido'] );
	unset( $_SESSION['usuario_correo'] );
	unset( $_SESSION['usuario_rol'] );

	// Destruir la session
	session_destroy();

	//Redireccionar al visitante al home.
	header("Location: index.php");

?>