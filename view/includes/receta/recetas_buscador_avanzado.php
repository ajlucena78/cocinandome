<?php include PATH_VIEW . 'includes/receta/lista.php'; ?>
<?php if ($verMas) { ?>
	<div id="ver_mas_recetas">
		<?php olink('buscar_recetas_avanzado', 'recetas', array('p' => ($pagina + 1)), false, null
				, 'removeElement("ver_mas_recetas")', true, 'pagina_' . $pagina); ?>Ver m&aacute;s<?php 
				clink(); ?>
	</div>
	<a name="pagina_<?php echo ($pagina + 1); ?>"></a>
<?php } ?>