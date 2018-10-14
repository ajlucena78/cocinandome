<div>
	<h2>Elija una comida del <?php echo formato_html($plan->nombre_dia($_GET['dia'])); ?> del plan</h2>
	<hr />
	<div style="padding-top: 2%;">
		<?php for ($comida = 1; $comida <= 4; $comida++) { ?>
			<div class="a_la_izquierda" style="width: 25%;">
				<?php if (isset($comidas[$comida])) { ?>
					<div><?php echo formato_html($plan->nombre_comida($comida)); ?></div>
					<div class="gris">
						En esta comida ya has a&ntilde;adido el m&aacute;ximo de alimentos/recetas.
					</div>
				<?php }else{ ?>
					<?php if ($_GET['id_receta']) { ?>
						<?php olink('elegir_receta_plan', 'contenido_popup'
								, array('id_receta' => $_GET['id_receta'], 'dia' => $_GET['dia']
								, 'comida' => $comida, 'donde' => $_GET['donde'])); ?>
					<?php }elseif (isset($_GET['tipo']) and $_GET['tipo'] == 'receta') { ?>
						<?php olink('elegir_categoria_platos_plan', 'contenido_popup', array('dia' => $_GET['dia']
						, 'comida' => $comida, 'donde' => $_GET['donde'])); ?>
					<?php }elseif ($_GET['id_alimento']) { ?>
						<?php olink('elegir_cantidad_alimento_plan', 'contenido_popup'
								, array('id_alimento' => $_GET['id_alimento'], 'dia' => $_GET['dia']
								, 'comida' => $comida), false, null, 'setFocoCantidad'); ?>
					<?php }else{ ?>
						<?php olink('elegir_clase_alimentos', 'contenido_popup', array('dia' => $_GET['dia']
								, 'comida' => $comida, 'act' => 'elegir_cantidad_alimento_plan')); ?>
					<?php } ?>
						<img src="<?php echo URL_APP; ?>res/img/web/<?php 
								echo strtolower($plan->nombre_comida($comida)); ?>.jpg" alt="<?php 
								echo formato_html($plan->nombre_comida($comida)); ?>" />
						<h3><?php echo formato_html($plan->nombre_comida($comida)); ?></h3>
					<?php clink(); ?>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
</div>