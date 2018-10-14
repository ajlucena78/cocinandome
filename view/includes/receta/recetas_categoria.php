<?php if ($categoria and $platos) { ?>
	<h2>M&aacute;s recetas de la categor&iacute;a <?php 
			echo formato_html(strtolower($categoria->nombre_categoria)); ?></h2>
	<div>
		<?php foreach ($platos as $plato) { ?>
			<div class="a_la_izquierda" style="width: 49%;">
				<div>
					<?php olink('receta', null, array('id_receta' => $plato->id_plato)); ?>
						<?php if ($plato->foto) { ?>
							<img src="<?php echo URL_APP; ?>res/img/plato/<?php 
									echo $plato->foto; ?>.jpg" alt="<?php 
									echo formato_html($plato->nombre_plato); ?>" 
									style="width: 100%;" />
						<?php } ?>
					<?php clink(); ?>
				</div>
				<div style="text-align: center">
					<?php olink('receta', null, array('id_receta' => $plato->id_plato)); ?>
						<span><?php echo formato_html($plato->nombre_plato); ?></span>
					<?php clink(); ?>
					<?php if ($plato->puedo_hacerlo()) { ?>
						<br />
						<span class="fuenteMini" style="color: #999;">Puedes hacer esta receta</span>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		<div class="separador"></div>
	</div>
	<?php if ($verMas) { ?>
		<div class="texto_centrado">
			<a href="<?php vlink('recetas', array('id_categoria' => $categoria->id_categoria)); 
					?>">Ver m&aacute;s recetas con <?php 
					echo formato_html(strtolower($categoria->nombre_categoria)); ?></a>
		</div>
	<?php } ?>
<?php } ?>