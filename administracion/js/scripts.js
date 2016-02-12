$(document).ready(function(){
	$('#breadcrumb ul').css('display', 'none');
	var url = window.location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);
	//variables desde donde comenzara el retroceso
	var $actual=$('#breadcrumb ul li a[href="'+filename+'"]');
	var cadena='';
	//con el bucle se retrocede hasta llegar a index.php
	do {
		var texto=$actual.text();
		var link=$actual.attr('href');
		cadena=' ▸ <a href="'+link+'">'+texto+'</a>'+cadena;
		$actual=$actual.parent().parent().prev().children();
	} while (link !== 'index.php');
	//se inserta el codigo, envuelto en un parrafo, dentro del breadcrumb
	$('#breadcrumb').html('<p>'+cadena+'</p>');
});