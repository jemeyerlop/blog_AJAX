<header>
	<a href="index.php" id="logo"></a>
	<?php
	if($logueado){
		if($_SESSION[usuario_rol]==1){$rol='administrador';}else{$rol='participante';}
		echo '<div id="identificacionUsuario"><p>Bienvenido '.ucwords($_SESSION[usuario_nombre]).' ('.ucwords($rol).')</p></div>';
	}
	?>	
</header>