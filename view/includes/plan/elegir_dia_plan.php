<div>
	<h2>Elija un d&iacute;a de la semana del plan</h2>
	<hr />
	<div style="padding-top: 2%;">
		<?php for ($dia = 1; $dia <= 7; $dia++) { ?>
			<div class="a_la_izquierda" style="width: 14%;">
				<?php olink('elegir_comida_plan', 'contenido_popup', array('dia' => $dia
						, 'id_alimento' => $_GET['id_alimento'], 'id_receta' => $_GET['id_receta']
						, 'tipo' => $_GET['tipo'], 'donde' => $_GET['donde'])); ?>
					<h3><?php echo formato_html($plan->nombre_dia($dia)); ?></h3>
				<?php clink(); ?>
			</div>
		<?php } ?>
	</div>
</div>