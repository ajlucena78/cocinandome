<?php if ($categoria and $platos) { ?>
	<h2>M&aacute;s recetas de la clase <?php 
			echo formato_html(strtolower($categoria->nombre_categoria)); ?></h2>
	<div>
		<?php foreach ($platos as $plato) { ?>
			<div class="a_la_izquierda" style="width: 32%; padding-right: 1%;">
				<div>
					<?php olink('receta', null, array('id_receta' => $plato->id_plato)); ?>
						<?php if ($plato->foto) { ?><img src="<?php echo URL_APP; ?>res/img/plato/<?php 
								echo $plato->foto; ?>.jpg" alt="<?php 
								echo formato_html($plato->nombre_plato); ?>" style="width: 100%;" />
						<?php } ?>
					<?php clink(); ?>
				</div>
				<div style="text-align: center;">
					<?php olink('receta', null, array('id_receta' => $plato->id_plato)); ?>
						<?php echo formato_html($plato->nombre_plato); ?>
					<?php clink(); ?>
				</div>
			</div>
		<?php } ?>
		<div class="separador"></div>
	</div>
<?php } ?>