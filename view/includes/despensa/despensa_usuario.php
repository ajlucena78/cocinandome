<?php foreach($despensa as $art) { ?>
	<div id="despensa_<?php echo $art->id_despensa(); ?>">
		<?php include PATH_VIEW . 'includes/despensa/alimento_despensa.php'; ?>
	</div>
<?php } ?>
<?php if (count($despensa) == 0) { ?>
	<div class="gris">
		No hay productos en la despensa para los criterios aportados
	</div>
<?php } ?>