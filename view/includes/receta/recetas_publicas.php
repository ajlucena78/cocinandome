<?php if ($platos) { ?>
	<h2>Algunas de vuestras recetas...</h2>
	<div>
		<?php foreach ($platos as $plato) { ?>
			<div class="a_la_izquierda" style="width: 33%;">
				<div>
					<?php olink('receta', null, array('id_receta' => $plato->id_plato)); ?>
						<?php if ($plato->foto) { ?>
							<img src="<?php echo URL_APP; ?>res/img/plato/<?php 
									echo $plato->foto; ?>.jpg" alt="<?php 
									echo formato_html($plato->nombre_plato); ?>" title="<?php 
									echo formato_html($plato->nombre_plato); ?>" style="width: 98%;" />
						<?php } ?>
					<?php clink(); ?>
				</div>
				<div style="text-align: center;">
					<?php olink('receta', null, array('id_receta' => $plato->id_plato)); ?>
						<span><?php echo formato_html($plato->nombre_plato); ?></span>
					<?php clink(); ?>
				</div>
			</div>
		<?php } ?>
		<div class="separador"></div>
	</div>
<?php } ?>