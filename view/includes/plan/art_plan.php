<?php require_once APP_ROOT . 'clases/util/Numero.php'; ?>
<?php if ($art->alimento) { ?>
	<div class="a_la_izquierda" style="width: 30%;">
		<?php if ($usuario) { ?>
			<a href="<?php vlink('ficha_alimento', array('id_alimento' => $art->alimento->id_alimento)); ?>">
		<?php }else{ ?>
			<a href="javascript:popup_cantidad_alimento('<?php vlink('elegir_cantidad_alimento_plan'
				, array('id_alimento' => $art->alimento->id_alimento, 'r' => 'alimento_plan'
				, 'destino' => 'plan_' . $art->id_plan(), 'dia' => $dia, 'comida' => $comida)); ?>');">
		<?php } ?>
			<?php if ($art->alimento->foto_alimento and file_exists(APP_ROOT . 'res/img/alimento/' 
					. $art->alimento->foto_alimento)) { ?>
				<img src="<?php echo URL_APP; ?>res/img/alimento/mini/<?php 
						echo $art->alimento->foto_alimento; ?>" alt="<?php 
						echo formato_html($art->alimento->nombre_alimento); ?>" style="width: 100%;" />
			<?php }else{ ?>
				<img src="<?php echo URL_APP; ?>res/img/alimento/mini/sin_foto.jpg" alt="<?php 
						echo formato_html($art->alimento->nombre_alimento); ?>" style="width: 100%;" />
			<?php } ?>
		</a>
	</div>
	<div class="a_la_derecha" style="width: 68%;">
		<?php if ($usuario) { ?>
			<a href="<?php vlink('ficha_alimento', array('id_alimento' => $art->alimento->id_alimento)); ?>">
		<?php }else{ ?>
			<a href="javascript:popup_cantidad_alimento('<?php vlink('elegir_cantidad_alimento_plan'
				, array('id_alimento' => $art->alimento->id_alimento, 'r' => 'alimento_plan'
				, 'destino' => 'plan_' . $art->id_plan(), 'dia' => $dia, 'comida' => $comida)); ?>');">
		<?php } ?>
			<?php echo formato_html($art->alimento->nombre_alimento); ?>
		</a>
		<?php if ($art->cantidad) { ?>
			<br />
			<span style="color: #666;">
				<?php echo $art->cantidad; ?>
				<?php if ($art->tipo_cantidad == 1) { ?>
					<?php echo ($art->cantidad == 1) ? 'unidad' : 'unidades'; ?>
				<?php }else{ ?>
					gr
				<?php } ?> 
				(<?php echo Numero::convierte_BBDD_a_web($art->calorias(), 0); ?> Kcal)
			</span>
		<?php } ?>
		<?php if (!$usuario) { ?>
			<br />
			<?php olink('quit_art_plan', 'plan_' . $art->id_plan, array('id_plan' => $art->id_plan
					, 'dia' => $art->dia, 'comida' => $art->comida), true, null
					, 'actualiza_info_nutricional_plan', false, null, 'eliminar'); 
					?>Quitar del plan<?php clink(); ?>
		<?php } ?>
	</div>
	<div class="separador"></div>
<?php } ?>
<?php if ($art->plato) { ?>
	<div class="a_la_izquierda" style="width: 30%;">
		<a href="<?php vlink('receta', array('id_receta' => $art->plato->id_plato)); ?>">
			<img src="<?php echo URL_APP; ?>res/img/plato/mini/<?php echo $art->plato->foto; ?>.jpg" 
					alt="<?php echo formato_html($art->plato->nombre_plato); ?>" style="width: 100%;" />
		</a>
	</div>
	<div class="a_la_derecha" style="width: 68%;">
		<a href="<?php vlink('receta', array('id_receta' => $art->plato->id_plato)); ?>"><?php 
				echo formato_html($art->plato->nombre_plato); ?></a>
		<br />
		<span style="color: #666;">
			<?php echo Numero::convierte_BBDD_a_web($art->calorias(), 0); ?> Kcal
		</span>
		<?php if (!$usuario) { ?>
			<br />
			<?php olink('quit_art_plan', 'plan_' . $art->id_plan(), array('id_plan' => $art->id_plan
					, 'dia' => $art->dia, 'comida' => $art->comida), true, null
					, 'actualiza_info_nutricional_plan', false, null
					, 'eliminar'); ?>Quitar del plan<?php clink(); ?>
		<?php } ?>
	</div>
	<div class="separador"></div>
<?php } ?>