<?php if (count($lista) == 0) { ?>
	<div class="gris">
		No hay productos en la lista de la compra para los criterios aportados
	</div>
<?php }else{ ?>
	<div class="gris">
		Aqu&iacute; tiene la lista de alimentos que tiene actualmente en su lista de la compra.
		<br />Para ver la informaci&oacute;n de cada uno, pulse sobre el nombre o la foto del mismo.
	</div>
	<?php foreach ($lista as $art) { ?>
		<div id="lista_compra_<?php echo $art->id_lista; ?>" style="width: 200pt;  margin-top: 4pt; 
				margin-right: 4pt;" class="a_la_izquierda">
			<?php include PATH_VIEW . 'includes/listaCompra/alimento_lista_compra.php'; ?>
		</div>
	<?php } ?>
<?php } ?>