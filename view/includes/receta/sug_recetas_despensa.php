<?php if (count($platos) > 0) { ?>
	<h2>Recetas que puedes hacer...</h2>
	<?php foreach ($platos as $plato) { ?>
		<div id="receta_<?php echo $plato->id_plato; ?>" style="padding-bottom: 1%;" title="<?php 
					echo formato_html($plato->nombre_plato); ?>">
			<div class="a_la_izquierda" style="width: 37%;">
				<a href="<?php vlink('receta', array('id_receta' => $plato->id_plato)); ?>">
					<img src="<?php echo URL_APP; ?>res/img/plato/mini/<?php 
							echo $plato->foto; ?>.jpg" alt="<?php 
							echo formato_html($plato->nombre_plato); ?>" 
							style="width: 100%;" />
				</a>
			</div>
			<div class="a_la_derecha" style="width: 60%;">
				<?php
					if (strlen($plato->nombre_plato) > 40)
					{
						$nombre_plato = substr($plato->nombre_plato, 0, 40) . '...';
					}
					else
					{
						$nombre_plato = $plato->nombre_plato;
					}
				?>
				<a href="<?php vlink('receta', array('id_receta' => $plato->id_plato)); ?>"><?php 
						echo formato_html($nombre_plato); ?></a>
			</div>
			<div class="separador"></div>
		</div>
	<?php } ?>
	<div class="texto_centrado">
		<a href="<?php vlink('que_recetas_puedo_cocinar'); ?>">Ver m&aacute;s recetas</a>
	</div>
	<hr />
<?php } ?>