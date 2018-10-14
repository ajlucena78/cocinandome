<img src="<?php echo URL_APP; ?>res/img/web/me-mola.jpg" alt="Me mola" 
		style="vertical-align: middle;" /> a <strong><?php echo $plato->me_mola; 
		?></strong> personas<?php if ($me_mola) { ?>, incluy&eacute;ndote a ti,<?php } ?> les mola esta receta 
<?php if (!$me_mola) { ?>
	<?php olink('anunciar-me-mola-receta', 'me-mola-receta', array('id_receta' => $plato->id_plato), false, null
			, null, false, 'boton_mini', 'width: 60px;'
			, 'Pulsa aqu&iacute; para anunciar que te gusta esta receta'); ?>Me mola :)<?php clink(); ?>
<?php } ?>