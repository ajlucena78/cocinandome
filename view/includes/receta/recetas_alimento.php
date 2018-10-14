<?php if ($alimento and $platos) { ?>
	<h2>Algunas recetas con <?php echo formato_html(strtolower($alimento->nombre_alimento)); ?>...</h2>
	<?php foreach ($platos as $plato) { ?>
		<div class="a_la_izquierda" style="width: 32%; padding-right: 1%; text-align: center;">
			<div>
				<?php olink('receta', null, array('id_receta' => $plato->id_plato)); ?>
					<?php if ($plato->foto) { ?>
						<img src="<?php echo URL_APP; ?>res/img/plato/<?php echo $plato->foto; ?>.jpg" 
								alt="<?php echo formato_html($plato->nombre_plato); ?>" style="width: 100%;" />
					<?php } ?>
				<?php clink(); ?>
			</div>
			<div>
				<?php olink('receta', null, array('id_receta' => $plato->id_plato)); ?>
					<?php echo formato_html($plato->nombre_plato); ?>
				<?php clink(); ?>
			</div>
			<?php if ($plato->puedo_hacerlo()) { ?>
				<div>
					<span class="fuenteMini" style="color: #999;">Puedes hacer esta receta</span>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
	<div class="separador"></div>
	<?php if ($verMas) { ?>
		<div class="texto_centrado">
			<a href="<?php vlink('recetas', array('id_alimento' => $alimento->id_alimento)); 
					?>">Ver m&aacute;s recetas con <?php 
					echo formato_html(strtolower($alimento->nombre_alimento)); ?></a>
		</div>
	<?php } ?>
<?php } ?>