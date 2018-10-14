<?php if (is_array($platos) and count($platos) > 0) { ?>
	<?php foreach ($platos as $plato) { ?>
		<div id="receta_favoritos_<?php echo $plato->id_plato; ?>">
			<?php include PATH_VIEW . 'includes/receta/resultado_receta.php'; ?>
		</div>
	<?php } ?>
<?php } ?>
<?php if ($verMas) { ?>
	<div id="ver_mas_recetas">
		<?php olink('buscar_mis_recetas_favoritas', 'recetas', array('p' => ($pagina + 1)
				, 'nombre_plato' => formato_html($platoBuscar->nombre_plato)), false, null
				, 'removeElement("ver_mas_recetas")', true, 'pagina_' . $pagina); ?>Ver m&aacute;s<?php 
				clink(); ?>
	</div>
	<a name="pagina_<?php echo $pagina; ?>"></a>
<?php } ?>