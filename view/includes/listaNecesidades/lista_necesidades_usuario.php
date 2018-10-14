<?php require_once APP_ROOT . 'clases/util/Numero.php'; ?>
<?php foreach($lista as $art) { ?>
	<div id="lista_necesidades_<?php echo $art->alimento->id_alimento; ?>">
		<?php include PATH_VIEW 
				. 'includes/listaNecesidades/alimento_lista_necesidades.php'; ?>
	</div>
<?php } ?>