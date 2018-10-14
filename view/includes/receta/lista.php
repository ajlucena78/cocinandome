<?php if (is_array($platos) and count($platos) > 0) { ?>
	<?php foreach ($platos as $plato) { ?>
		<?php include PATH_VIEW . 'includes/receta/resultado_receta.php'; ?>
	<?php } ?>
<?php }else{ ?>
<div style="color: #999;">
	No hay recetas que mostrar
</div>
<?php } ?>