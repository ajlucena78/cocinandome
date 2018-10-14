<?php include PATH_VIEW . 'includes/receta/lista.php'; ?>
<?php if ($verMas) { ?>
	<div id="ver_mas_recetas">
		<?php olink('buscar_mis_recetas', 'recetas'
				, array('nombre_plato' => formato_html($platoBuscar->nombre_plato), 'p' => ($pagina + 1)), false
				, null, 'removeElement("ver_mas_recetas")', true); ?>Ver m&aacute;s<?php clink(); ?>
	</div>
<?php } ?>