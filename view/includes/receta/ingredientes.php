<?php if (is_array($plato->ingredientes) and count($plato->ingredientes) > 0) { ?>
	<?php foreach ($plato->ingredientes as $art) { ?>
		<?php include PATH_VIEW . 'includes/receta/ingrediente_receta.php'; ?>
	<?php } ?>
<?php }else{ ?>
	<div>
		<span style="color: gray;">La receta no tiene ingredientes.
			<br />
			Pulsa en el bot&oacute;n <strong>A&ntilde;adir ingredientes</strong> para agregarlos a la receta.
		</span>
		<br />
		&nbsp;
	</div>
<?php } ?>