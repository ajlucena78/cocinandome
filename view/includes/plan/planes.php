<?php foreach ($planes as $dia => $planesDia) { ?>
	<div id="dia_<?php echo $dia; ?>" style="padding-right: 1%;">
		<h2 style="text-align: center;">
			<?php /* olink('plan_dia', 'plan', array('dia' => $dia), false, null
					, 'actualiza_info_nutricional_plan'); ?><?php 
					echo formato_html(strtoupper($plan->nombre_dia($dia))); ?><?php clink(); */ ?>
			<?php echo formato_html(strtoupper($plan->nombre_dia($dia))); ?>
		</h2>
		<?php foreach ($planesDia as $comida => $planesComida) { ?>
			<div id="comida_<?php echo $dia; ?>_<?php echo $comida; ?>" <?php 
					if (!$planesComida) { ?>style="display: none;"<?php } ?>>
				<hr />
				<h3 style="text-align: center;">
					<?php /* olink('plan_comida', 'plan', array('comida' => $comida), false, null
							, 'actualiza_info_nutricional_plan'); ?><?php 
							echo formato_html($plan->nombre_comida($comida)); ?><?php clink(); */ ?>
					<?php echo formato_html($plan->nombre_comida($comida)); ?>
				</h3>
				<hr />
				<div id="plan_<?php echo $dia; ?>_<?php echo $comida; ?>">
					<?php include PATH_VIEW . 'includes/plan/plan.php'; ?>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="separador"></div>
<?php } ?>
<?php if (!$hayPlanes) { ?>
	<?php if ($usuario) { ?>
		<div id="no_hay_planes" class="gris texto_centrado">
			A&uacute;n no hay nada en este d&iacute;a :|
		</div>
	<?php } else { ?>
		<div id="no_hay_planes">
			A&uacute;n no hay nada en este d&iacute;a, puede <a 
					href="javascript:popup_elegir_dia_plan();">a&ntilde;adir alimentos</a> o <a 
					href="javascript:popup_elegir_dia_plan(null,null,'receta','plan');">a&ntilde;adir recetas.</a>
			<br />
			Tambi&eacute;n puedes crear tus propias recetas <a href="<?php vlink('nueva_receta'); ?>">haciendo 
			clic aqu&iacute;</a>.
		</div>
	<?php } ?>
<?php } ?>