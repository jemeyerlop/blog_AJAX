<meta charset="UTF-8">
<title><?php echo $titulo ?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Cantarell:400,700|Cardo:400,700' rel='stylesheet' type='text/css'>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<style>
<?php
if($selectorActivo<>''){
?>
	<?php echo $selectorActivo ?>:link{
		color:#99ccff;
		cursor:default;
	}
	<?php echo $selectorActivo ?>:visited{
		color:#99ccff;
		cursor:default;
	}
	<?php echo $selectorActivo ?>:hover{
		color:#99ccff;
		cursor:default;
	}
	<?php echo $selectorActivo ?>:active{
		color:#99ccff;
		cursor:default;
	}
<?php } ?>
</style>