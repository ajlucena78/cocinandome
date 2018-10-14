<h2>Publicar mi receta</h2>
<div>
	&iquest;Deseas publicar esta receta? Si es as&iacute; otros usuarios podr&aacute;n verla y comentarla aunque 
	no formen parte de tus contactos. Adem&aacute;s puede ser consultada por usuarios no registrados y 
	encontrada por buscadores como Google, Bing, Yahoo, etc.
	<br />
	Recuerda que puedes revocar en cualquier momento esta publicaci&oacute;n si lo deseas.
	<br />
	Ten en cuenta que la receta debe ser supervisada antes de ser publicada.
</div>
<div>
	<?php olink('envio_publicacion_receta', 'contenido_popup', array('id_receta' => $plato->id_plato)); 
			?>S&iacute;, deseo publicar mi receta<?php clink(); ?>
</div>
<div>
	<a href="javascript:quitar_popup();" style="color: red;">No, gracias</a>
</div>