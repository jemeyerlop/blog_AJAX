<?php
include_once 'includesEspecialesBackend/php_comun.php';
?>
<!DOCTYPE html>
<html lang="<?php include_once '../includes/lang.php';?>">
<head>
	<?php
	$titulo='Administración del Blog';
	include_once 'includesEspecialesBackend/head.php';
	?>
<style>
#menu li a.inicio:link,#menu li a.inicio:visited,#menu li a.inicio:hover,#menu li a.inicio:active{
	color:#fff;
	cursor:default;
}
</style>
</head>
<body>
	<div id="contenedor">
	<?php
	include_once '../includes/header.php';
	include_once 'includesEspecialesBackend/nav.php';
	?>
	<div id="breadcrumb"><?php include_once 'includesEspecialesBackend/mapaNav.php'; ?></div>
	<section class="contenido">
		<a href="articulos.php" class="botonGrande">Artículos</a>
		<a href="categorias.php" class="botonGrande">Categorías</a>
		<a href="usuarios.php" class="botonGrande">Usuarios</a>
	</section>
	</div>
</body>
</html>