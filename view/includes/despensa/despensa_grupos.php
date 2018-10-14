<?php if (count($despensa) == 0) { ?>
	<div class="gris">
		No hay productos en la lista de compra para los criterios aportados
	</div>
<?php }else{ ?>
	<div class="gris">
		Aqu&iacute; tiene la lista de alimentos que tiene actualmente en su despensa.
		<br />Para ver la informaci&oacute;n de cada uno, pulse sobre el nombre o la foto del mismo.
	</div>
	<?php foreach ($despensa as $art) { ?>
		<div id="despensa_<?php echo $art->id_despensa(); ?>" style="width: 200pt;  margin-top: 4pt; 
				margin-right: 4pt;" class="a_la_izquierda">
			<?php include PATH_VIEW . 'includes/despensa/alimento_despensa.php'; ?>
		</div>
	<?php } ?>
	<div class="separador"></div>
<?php } ?>