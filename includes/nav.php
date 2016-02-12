<nav>
	<ul id="menu">
        <li><a class="inicio" href="index.php">Artículos</a></li>
        <li><a class="contacto" href="contacto.php">Contacto</a></li>
        <li><p>|</p></li>
		<?php
		if($logueado){
			echo '<li><a class="logout" href="logout.php">Logout</a></li>';
			echo '<li><a class="mis_datos" href="mis_datos.php">Mis datos</a></li>';
			if($_SESSION[usuario_rol]==1){
				echo '<li><a class="administrar" target="_blank" href="administracion/index.php">Administrar</a></li>';
			}
		}else{
			echo '<li><a class="login" href="login.php">Login</a></li>';
			echo '<li><a class="registro" href="registro.php">Registrarse</a></li>';
		}
		?>	
    </ul>
</nav>