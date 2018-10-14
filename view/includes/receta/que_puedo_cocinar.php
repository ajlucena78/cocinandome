<?php include PATH_VIEW . 'includes/receta/lista.php'; ?>
<?php if ($verMas) { ?>
	<div id="ver_mas_recetas">
		<?php olink('recetas_que_puedo_cocinar', 'recetas', array('p' => ($pagina + 1)
				, 'nombre_plato' => $platoBuscar->nombre_plato), false, null
				, 'removeElement("ver_mas_recetas")', true); ?>Ver m&aacute;s<?php clink(); ?>
	</div>
<?php } ?>