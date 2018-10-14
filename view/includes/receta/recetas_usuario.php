<?php foreach ($platos as $plato) { ?>
	<div id="receta_<?php echo $plato->nombre_plato; ?>" style="width: 100%;">
		<div class="a_la_izquierda" style="width: 11%;">
			<a href="<?php vlink('receta', array('id_receta' => $plato->id_plato)); ?>">
				<img src="<?php echo URL_APP; 
						?>res/img/plato/mini/<?php echo $plato->foto; ?>.jpg" 
						alt="<?php echo formato_html($plato->nombre_plato); ?>" 
						style="width: 100%;" />
			</a>
		</div>
		<div class="a_la_derecha" style="width: 87%;">
			<a href="<?php vlink('receta', array('id_receta' => $plato->id_plato)); ?>"><?php 
					echo formato_html($plato->nombre_plato); ?></a>
			<?php if ($plato->puedo_hacerlo()) { ?>
				<br />
				<span style="color: green;">Puedes hacer esta receta</span>
			<?php } ?>
		</div>
		<div class="separador"></div>
	</div>
<?php } ?>
<?php /* if ($verMas) { ?>
	<div id="ver_mas_recetas" style="width: 100%;">
		<?php olink('recetas_usuario', 'recetas', array('p' => ($pagina + 1), 'id_u' => $id_u), false, null 
				, 'removeElement("ver_mas_recetas")', true); ?>Ver m&aacute;s recetas del usuario<?php clink(); ?>
	</div>
<?php } */ ?>