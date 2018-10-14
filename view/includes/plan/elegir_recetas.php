<h2>
	Elija una de las recetas
	<?php if ($categoria) { ?>
		 de la categor&iacute;a <?php echo formato_html(lcfirst($categoria->nombre_categoria)); ?>
	<?php } ?>
</h2>
<div>
	<?php foreach ($platos as $plato) { ?>
		<div class="a_la_izquierda" style="width: <?php echo $tamColumna; ?>%;">
			<?php olink('elegir_receta_plan', 'elegir_receta', array('id_receta' => $plato->id_plato
					, 'dia' => $_GET['dia'], 'comida' => $_GET['comida'], 'donde' => $_GET['donde'])); ?>
				<?php if ($plato->foto) { ?>
					<img src="<?php echo URL_APP; ?>res/img/plato/<?php 
							echo $plato->foto; ?>.jpg" alt="<?php echo formato_html($plato->nombre_plato); ?>" 
							style="width: 80%;" />
				<?php } ?>
				<br />
				<span class="fuenteMini"><?php echo formato_html($plato->nombre_plato); ?></span>
			<?php clink(); ?>
		</div>
	<?php } ?>
	<div class="separador"></div>
	<?php if ($verMas) { ?>
		<div class="texto_centrado">
			<a href="<?php vlink('elegir_recetas_plan', array('id_categoria' => $categoria->id_categoria)); 
					?>">Ver m&aacute;s recetas</a>
		</div>
	<?php } ?>
</div>