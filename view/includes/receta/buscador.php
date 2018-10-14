<?php if (!is_array($platos) or count($platos) == 0) { ?>
	<div>
		No se han encontrado recetas
	</div>
<?php }else{ ?>
	<?php include PATH_VIEW . 'includes/receta/lista.php'; ?>
	<?php if ($verMas) { ?>
		<div id="ver_mas_recetas">
			<?php olink('buscar_recetas', 'buscar_recetas', array('nombre_plato' => $platoBuscar->nombre_plato
					, 'id_alimento' => $alimento->id_alimento
					, 'id_categoria' => $platoBuscar->categoria->id_categoria, 'p' => ($_GET['p'] + 1))
					, false, null, 'removeElement("ver_mas_recetas")', true); ?>Ver m&aacute;s<?php clink(); ?>
		</div>
	<?php } ?>
<?php } ?>