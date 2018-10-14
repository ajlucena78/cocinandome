<?php foreach($lista as $art) { ?>
	<div id="lista_compra_<?php echo $art->id_lista(); ?>">
		<?php include PATH_VIEW . 'includes/listaCompra/alimento_lista_compra.php'; ?>
	</div>
<?php } ?>