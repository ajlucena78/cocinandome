<?php require_once APP_ROOT . 'clases/util/Numero.php'; ?>
<div id="ingrediente_receta_<?php echo $art->alimento->id_alimento; ?>" class="a_la_izquierda"
		style="width: 32%; padding-bottom: 4%; padding-right: 1%;">
	<div class="a_la_izquierda" style="width: 28%;">
		<a href="javascript:popup_cantidad_alimento('<?php vlink('elegir_cantidad_ingrediente'
				, array('id_alimento' => $art->alimento->id_alimento, 'r' => 'ingrediente_receta'
				, 'destino' => 'ingrediente_receta_' . $art->alimento->id_alimento)); ?>');">
			<?php if ($art->alimento->foto_alimento and file_exists(APP_ROOT 
								. 'res/img/alimento/' . $art->alimento->foto_alimento)) { ?>
				<img id="img_alimento_<?php echo $art->alimento->id_alimento; ?>" 
						src="<?php echo URL_APP; ?>res/img/alimento/mini/<?php 
						echo $art->alimento->foto_alimento; ?>" 
						alt="<?php echo formato_html($art->alimento->nombre_alimento); ?>" 
						title="<?php echo formato_html($art->alimento->nombre_alimento); ?>" 
						style="width: 100%;" />
			<?php }else{ ?>
				<img id="img_alimento_<?php echo $art->alimento->id_alimento; ?>" 
						src="<?php echo URL_APP; ?>res/img/alimento/mini/sin_foto.jpg" 
						alt="Sin foto" style="width: 100%;" title="Sin foto" />
			<?php } ?>
		</a>
	</div>
	<div class="a_la_derecha" style="width: 70%;">
		<a href="javascript:popup_cantidad_alimento('<?php vlink('elegir_cantidad_ingrediente'
				, array('id_alimento' => $art->alimento->id_alimento, 'r' => 'ingrediente_receta'
				, 'destino' => 'ingrediente_receta_' . $art->alimento->id_alimento)); ?>');">
			<?php echo formato_html($art->alimento->nombre_alimento); ?>
		</a>
		<div style="color: #888;">
			Cantidad: <?php echo Numero::convierte_BBDD_a_web($art->cantidad); ?> 
			<?php if ($art->tipo_cantidad == 0) { ?>
				gr
			<?php }else{ ?>
				unidad/es
			<?php } ?>
		</div>
	</div>
	<div class="separador"></div>
	<div class="a_la_izquierda" style="width: 60%;">
		<a href="javascript:popup_cantidad_alimento('<?php vlink('elegir_cantidad_ingrediente'
				, array('id_alimento' => $art->alimento->id_alimento, 'r' => 'ingrediente_receta'
				, 'destino' => 'ingrediente_receta_' . $art->alimento->id_alimento)); ?>');" class="boton">Editar</a>
	</div>
	<div class="a_la_derecha" style="width: 40%; text-align: right;">
		<?php olink('quit_ingrediente_receta', 'ingrediente_receta_' . $art->alimento->id_alimento, 
				array('id_alimento' => $art->alimento->id_alimento), true, null
				, 'actualiza_info_nutricional_receta', false, null, 'boton eliminar'); ?>Quitar<?php clink(); ?>
	</div>
	<div class="separador"></div>
	<input name="alimentos[]" value="<?php echo $art->alimento->id_alimento; ?>" type="hidden" />
	<input name="cantidad[]" value="<?php echo $art->cantidad; ?>" type="hidden" />
	<input name="tipo_cantidad[]" value="<?php echo $art->tipo_cantidad; ?>" type="hidden" />
</div>