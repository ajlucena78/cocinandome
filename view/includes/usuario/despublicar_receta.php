<h2>Cancelar la publicaci&oacute;n de mi receta</h2>
<div>
	Vas a ha hacer que tu receta no aparezca para todos los usuarios de nuestra web.
</div>
<div>
	<?php olink('despublicacion_receta', 'contenido_popup', array('id_receta' => $plato->id_plato), false, null
			, 'window.location.reload();'); ?>S&iacute;, deseo cancelar la publicaci&oacute;n de mi receta<?php 
			clink(); ?>
</div>
<div>
	<a href="javascript:quitar_popup();">No, que continue como est&aacute;</a>
</div>